<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
{
    var $tables      = "dwigital_withdraw";     
    var $tblPlatform = "dwigital_platform";      
    var $page   = "dwigital/transaksi/withdraw";
    var $file   = "withdraw";
    var $pk     = "id";
    var $title  = "Withdraw";
    var $bread  = "<ol class='breadcrumb'>
        <li class='breadcrumb-item active'><a href='dwigital/transaksi/withdraw'>Withdraw</a></li>
    </ol>";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','form','string','permalink_helper'));
        $this->load->library(array('session','form_validation','upload'));
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
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "adm1nb3rrk4h'>";
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


        $data['platforms']  = $this->db->select('id, nama')
                                       ->from($this->tblPlatform)
                                       ->order_by('nama','ASC')
                                       ->get()->result();

        $this->db->select('w.id, w.id_platform, w.nominal, w.tanggal, p.nama AS nama_platform');
        $this->db->from($this->tables.' w');
        $this->db->join($this->tblPlatform.' p', 'p.id = w.id_platform', 'left');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('p.nama', $q);
            $this->db->or_like('w.nominal', $q);
            $this->db->or_like('w.tanggal', $q);
            $this->db->group_end();
        }


        $this->db->order_by('w.id', 'DESC'); 

        $data['rows'] = $this->db->get()->result();

        $this->template($data);
    }

    public function form($id = null)
    {
        $data['file']  = $data['isi'] = $this->file;
        $data['title'] = $this->title;
        $data['bread'] = $this->bread;
        $data['set']   = "form";
        $data['mode']  = $id ? "edit" : "insert";

        $data['platforms'] = $this->db->select('id, nama')
                                      ->from($this->tblPlatform)
                                      ->order_by('nama','ASC')
                                      ->get()->result();

        if ($id) {
            $this->db->select('w.*, p.nama AS nama_platform');
            $this->db->from($this->tables.' w');
            $this->db->join($this->tblPlatform.' p', 'p.id = w.id_platform', 'left');
            $this->db->where('w.id', $id);
            $data['row'] = $this->db->get()->row();
        } else {
            $data['row'] = null;
        }

        $this->template($data);
    }

    public function save()
    {
        $data = [
            'id_platform' => $this->input->post('id_platform', true),
            'nominal'     => str_replace([',','.'], '', $this->input->post('nominal', true)),
            'tanggal'     => $this->input->post('tanggal', true),
        ];
        $this->db->insert($this->tables, $data);
        $_SESSION['pesan'] = 'Data berhasil disimpan';
        $_SESSION['tipe']  = 'success';
        redirect($this->page);
    }

    public function update($id)
    {
        $data = [
            'id_platform' => $this->input->post('id_platform', true),
            'nominal'     => str_replace([',','.'], '', $this->input->post('nominal', true)),
            'tanggal'     => $this->input->post('tanggal', true),
        ];
        $this->db->where('id', $id)->update($this->tables, $data);
        $_SESSION['pesan'] = 'Data berhasil diperbarui';
        $_SESSION['tipe']  = 'success';
        redirect($this->page);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete($this->tables);
        $_SESSION['pesan'] = 'Data berhasil dihapus';
        $_SESSION['tipe']  = 'success';
        redirect($this->page);
    }
}
