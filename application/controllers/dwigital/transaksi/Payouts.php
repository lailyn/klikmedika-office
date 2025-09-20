<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payouts extends CI_Controller
{
    var $tables      = "dwigital_payouts";
    var $page   = "dwigital/transaksi/payouts";
    var $file   = "payouts";
    var $pk     = "id";
    var $title  = "Payouts";
    var $bread  = "<ol class='breadcrumb'>
        <li class='breadcrumb-item'><a>Transaksi</a></li>										
        <li class='breadcrumb-item active'><a href='dwigital/transaksi/payouts'>Payouts</a></li>										
    </ol>";
    var $path = "dwigital/transaksi/payouts";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url', 'form', 'string', 'permalink_helper'));
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->model('m_admin');
    }

    protected function template($data)
    {
        $name = $this->session->userdata('nama');
        if ($data['set'] == 'delete' or $data['set'] == 'edit' or $data['set'] == 'view')
            $set = $data['set'];
        else
            $set = "insert";

        $auth = $this->m_admin->user_auth($this->page, $set);
        if ($name == "") {
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n'>";
        } elseif ($auth == 'false') {
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "denied'>";
        } else {
            $data['page'] = $this->page;
            $this->load->view('back_template/header', $data);
            $this->load->view('back_template/aside', $data);
            $this->load->view($this->page, $data);
            $this->load->view('back_template/footer', $data);
        }
    }

    public function index()
    {
        $data['file']  = $data['isi'] = $this->file;
        $data['title'] = $this->title;
        $data['bread'] = $this->bread;
        $data['set']   = "view";
        $data['mode']  = "view";

        $q = $this->input->get('q', true);

        $this->db->select('p.id, p.start_date, p.end_date, p.payout_to, p.amount, p.status, p.description, p.created_at');
        $this->db->from($this->tables . ' p');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('p.payout_to', $q);
            $this->db->or_like('p.amount', $q);
            $this->db->or_like('p.status', $q);
            $this->db->or_like('p.description', $q);
            $this->db->group_end();
        }

        $this->db->order_by('p.id', 'DESC');

        $data['dt_payouts'] = $this->db->get();

        // Calculate grand total
        $data['grand_total'] = 0;
        if (!empty($data['dt_payouts'])) {
            foreach ($data['dt_payouts']->result() as $payout) {
                $data['grand_total'] += (float)$payout->amount;
            }
        }

        // Calculate available profit (same as infografis)
        $data['available_profit'] = $this->calculateAvailableProfit();

        $this->template($data);
    }

    public function add()
    {
        $data['file']  = $data['isi'] = $this->file;
        $data['title'] = "Tambah " . $this->title;
        $data['bread'] = $this->bread;
        $data['set']   = "insert";
        $data['mode']  = "insert";

        // Set grand_total to 0 for add mode
        $data['grand_total'] = 0;

        // Calculate available profit (no date filtering for add mode)
        $data['available_profit'] = 0;

        $this->template($data);
    }

    public function store()
    {
        // Set validation rules
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'required|callback_check_date_range');
        $this->form_validation->set_rules('payout_to', 'Payout To', 'required|max_length[100]');
        $this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,processing,completed,failed]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'max_length[500]');

        // Set custom error messages
        $this->form_validation->set_message('required', '{field} harus diisi');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka');
        $this->form_validation->set_message('greater_than', '{field} harus lebih dari 0');
        $this->form_validation->set_message('integer', '{field} harus berupa angka bulat');
        $this->form_validation->set_message('in_list', '{field} tidak valid');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form with errors
            $data['file']  = $data['isi'] = $this->file;
            $data['title'] = "Tambah " . $this->title;
            $data['bread'] = $this->bread;
            $data['set']   = "insert";
            $data['mode']  = "insert";

            // Set grand_total to 0 for validation failed
            $data['grand_total'] = 0;

            // Calculate available profit
            $data['available_profit'] = $this->calculateAvailableProfit();

            $this->template($data);
        } else {
            // Validation passed, proceed with saving
            $data = array(
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'payout_to' => $this->input->post('payout_to'),
                'amount' => $this->input->post('amount'),
                'status' => $this->input->post('status'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id_user')
            );

            $this->m_admin->insert($this->tables, $data);
            $this->session->set_flashdata('pesan', 'Data berhasil disimpan');
            $this->session->set_flashdata('tipe', 'success');
            redirect($this->path);
        }
    }

    public function edit($id)
    {
        $data['file']  = $data['isi'] = $this->file;
        $data['title'] = "Edit " . $this->title;
        $data['bread'] = $this->bread;
        $data['set']   = "edit";
        $data['mode']  = "edit";

        $data['dt_payouts'] = $this->db->select('p.*')
            ->from($this->tables . ' p')
            ->where('p.id', $id)
            ->get();

        // Set grand_total to 0 for edit mode
        $data['grand_total'] = 0;

        // Calculate available profit
        $data['available_profit'] = $this->calculateAvailableProfit();

        $this->template($data);
    }

    public function update($id)
    {
        // Set validation rules
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'required|callback_check_date_range');
        $this->form_validation->set_rules('payout_to', 'Payout To', 'required|max_length[100]');
        $this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,processing,completed,failed]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'max_length[500]');

        // Set custom error messages
        $this->form_validation->set_message('required', '{field} harus diisi');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka');
        $this->form_validation->set_message('greater_than', '{field} harus lebih dari 0');
        $this->form_validation->set_message('integer', '{field} harus berupa angka bulat');
        $this->form_validation->set_message('in_list', '{field} tidak valid');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form with errors
            $data['file']  = $data['isi'] = $this->file;
            $data['title'] = "Edit " . $this->title;
            $data['bread'] = $this->bread;
            $data['set']   = "edit";
            $data['mode']  = "edit";

            $data['dt_payouts'] = $this->db->select('p.*')
                ->from($this->tables . ' p')
                ->where('p.id', $id)
                ->get();

            // Set grand_total to 0 for validation failed
            $data['grand_total'] = 0;

            // Calculate available profit
            $data['available_profit'] = $this->calculateAvailableProfit();

            $this->template($data);
        } else {
            // Validation passed, proceed with updating
            $data = array(
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'payout_to' => $this->input->post('payout_to'),
                'amount' => $this->input->post('amount'),
                'status' => $this->input->post('status'),
                'description' => $this->input->post('description'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id_user')
            );

            $this->db->update($this->tables, $data, [$this->pk => $id]);
            $this->session->set_flashdata('pesan', 'Data berhasil diupdate');
            $this->session->set_flashdata('tipe', 'success');
            redirect($this->path);
        }
    }

    public function delete($id)
    {
        $this->m_admin->delete($this->tables, $this->pk, $id);
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus');
        $this->session->set_flashdata('tipe', 'success');
        redirect($this->path);
    }

    public function destroy($id)
    {
        $this->m_admin->delete($this->tables, $this->pk, $id);
        $this->session->set_flashdata('pesan', 'Data berhasil dihapus');
        $this->session->set_flashdata('tipe', 'success');
        redirect($this->path);
    }

    /**
     * Calculate available profit with date filtering
     * @param string $start_date
     * @param string $end_date
     * @return float
     */
    private function calculateAvailableProfit($start_date = null, $end_date = null)
    {
        $date_filter = '';
        if ($start_date && $end_date) {
            $date_filter = " AND tgl BETWEEN '$start_date' AND '$end_date'";
        }

        // Calculate total revenue from completed orders
        $total_pendapatan = $this->db->query("SELECT SUM(total) AS jum FROM dwigital_cart WHERE status='selesai' $date_filter")->row()->jum ?? 0;

        // Calculate total expenses from category 28
        $total_pengeluaran = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran WHERE id_kategori=28 $date_filter")->row()->jum ?? 0;

        // Calculate total payouts already made in this period
        $total_payouts = 0;
        if ($start_date && $end_date) {
            // Payout yang periodenya overlap dengan periode yang dipilih
            $total_payouts = $this->db->query("SELECT SUM(amount) AS jum FROM dwigital_payouts WHERE 
                (start_date <= '$end_date' AND end_date >= '$start_date')")->row()->jum ?? 0;
        }

        // Calculate remaining balance from platform
        $sisa_saldo = $this->db->query("SELECT SUM(sisa_saldo) AS jum FROM dwigital_saldo_platform")->row()->jum ?? 0;

        // Calculate total profit: (Pendapatan + Sisa Saldo) - Pengeluaran - Payout yang sudah ada
        $total_profit = ($total_pendapatan + $sisa_saldo) - $total_pengeluaran - $total_payouts;

        return max(0, $total_profit); // Ensure non-negative
    }

    /**
     * Custom validation callback to check date range
     * @param string $end_date
     * @return bool
     */
    public function check_date_range($end_date)
    {
        $start_date = $this->input->post('start_date');

        if ($start_date && $end_date && $start_date > $end_date) {
            $this->form_validation->set_message(
                'check_date_range',
                'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai'
            );
            return FALSE;
        }

        return TRUE;
    }


    /**
     * AJAX method to get filtered profit based on date range
     */
    public function get_filtered_profit()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if ($start_date && $end_date) {
            // Get detailed breakdown
            $date_filter = " AND tgl BETWEEN '$start_date' AND '$end_date'";

            // Calculate total revenue from completed orders
            $total_pendapatan = $this->db->query("SELECT SUM(total) AS jum FROM dwigital_cart WHERE status='selesai' $date_filter")->row()->jum ?? 0;

            // Calculate total expenses from category 28
            $total_pengeluaran = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran WHERE id_kategori=28 $date_filter")->row()->jum ?? 0;

            // Calculate total payouts already made in this period
            $total_payouts = $this->db->query("SELECT SUM(amount) AS jum FROM dwigital_payouts WHERE 
                (start_date <= '$end_date' AND end_date >= '$start_date') AND dwigital_payouts.status!='failed'")->row()->jum ?? 0;

            // Calculate actual remaining balance: Pemasukan - Pengeluaran - Payout yang sudah ada
            $sisa_saldo = $total_pendapatan - $total_pengeluaran - $total_payouts;
            $sisa_saldo = max(0, $sisa_saldo); // Ensure non-negative

            $response = [
                'success' => true,
                'breakdown' => [
                    'pendapatan' => $total_pendapatan,
                    'pengeluaran' => $total_pengeluaran,
                    'payouts_existing' => $total_payouts,
                    'sisa_saldo' => $sisa_saldo
                ]
            ];

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Start date and end date are required'
                ]));
        }
    }
}
