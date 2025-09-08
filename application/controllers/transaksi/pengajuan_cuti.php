<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_cuti extends CI_Controller {

    var $tables =   "tr_pengajuan_cuti";		
    var $page	=	"transaksi/pengajuan_cuti";
    var $file	=	"pengajuan_cuti";
    var $pk     =   "id_pengajuan_cuti";
    var $title  =   "Pengajuan Cuti";
    var $bread	=   "<ol class='breadcrumb'>
    <li class='breadcrumb-item'><a>Transaksi</a></li>
    <li class='breadcrumb-item active'><a href='transaksi/pengajuan_cuti'>Pengajuan Cuti</a></li>
    </ol>";

    public function __construct()
    {		
        parent::__construct();
        $this->load->database();
        $this->load->helper('url', 'string');
        $this->load->model('m_admin');		
        $this->load->library('upload');
    }

    protected function template($data)
    {
        $this->load->view('back_template/header',$data);
        $this->load->view('back_template/aside');			
        $this->load->view($this->page);		
        $this->load->view('back_template/footer');
    }

    // Hitung sisa cuti per tahun
    private function get_sisa_cuti($id_karyawan)
    {
        $row = $this->db->select('jatah_cuti')
                        ->from('md_karyawan')
                        ->where('id_karyawan', $id_karyawan)
                        ->get()->row();
        $jatah = $row ? $row->jatah_cuti : 0;

        $tahun = date('Y');
        $total = $this->db->select_sum('lama_cuti')
                          ->from('tr_pengajuan_cuti')
                          ->where('id_karyawan', $id_karyawan)
                          ->where('status', 1)
                          ->where('is_deleted', 0)
                          ->where('YEAR(tgl_mulai)', $tahun)
                          ->get()->row()->lama_cuti;

        return $jatah - (int)$total;
    }

    public function index()
    {								
        $data['isi']    = $this->file;		
        $data['title']	= $this->title;	
        $data['bread']	= $this->bread;																														
        $data['set']	= "view";		
        $data['mode']	= "view";		

        $this->db->select('tr_pengajuan_cuti.*, md_jenis_cuti.nama_jenis_cuti, md_karyawan.nama_lengkap');
        $this->db->from('tr_pengajuan_cuti');
        $this->db->join('md_jenis_cuti', 'tr_pengajuan_cuti.id_jenis_cuti = md_jenis_cuti.id_jenis_cuti', 'left');
        $this->db->join('md_karyawan', 'tr_pengajuan_cuti.id_karyawan = md_karyawan.id_karyawan', 'left');
        $this->db->where('tr_pengajuan_cuti.status', 0);
        $this->db->where('tr_pengajuan_cuti.is_deleted', 0);
        $data['dt_pengajuan_cuti'] = $this->db->get()->result();

        foreach ($data['dt_pengajuan_cuti'] as &$row) {
            $row->sisa_cuti = $this->get_sisa_cuti($row->id_karyawan);
        }

        $this->template($data);	
    }

    public function riwayat()
    {
        $data['isi'] = $this->file;
        $data['title'] = "Riwayat " . $this->title;
        $data['bread'] = $this->bread;
        $data['set'] = "riwayat";
        $data['mode'] = "view";

        $this->db->select('tr_pengajuan_cuti.*, md_jenis_cuti.nama_jenis_cuti, md_karyawan.nama_lengkap');
        $this->db->from('tr_pengajuan_cuti');
        $this->db->join('md_jenis_cuti', 'tr_pengajuan_cuti.id_jenis_cuti = md_jenis_cuti.id_jenis_cuti', 'left');
        $this->db->join('md_karyawan', 'tr_pengajuan_cuti.id_karyawan = md_karyawan.id_karyawan', 'left');
        $this->db->where_in('tr_pengajuan_cuti.status', [1, 2]);
        $this->db->where('tr_pengajuan_cuti.is_deleted', 0);
        $data['dt_pengajuan_cuti'] = $this->db->get()->result();

        foreach ($data['dt_pengajuan_cuti'] as &$row) {
            $row->sisa_cuti = $this->get_sisa_cuti($row->id_karyawan);
        }

        $this->template($data);
    }

    public function add()
    {								
        $data['isi']    = $this->file;		
        $data['title']	= "Tambah ".$this->title;	
        $data['bread']	= $this->bread;																														
        $data['set']	= "add";		
        $data['mode']	= "add";

        $data['dt_jenis_cuti'] = $this->m_admin->getAll("md_jenis_cuti")->result();		
        $data['dt_karyawan']   = $this->m_admin->getAll("md_karyawan")->result();	

        $this->template($data);	
    }

    public function edit($id)
    {								
        $data['isi']    = $this->file;		
        $data['title']	= "Edit ".$this->title;	
        $data['bread']	= $this->bread;																														
        $data['set']	= "edit";		
        $data['mode']	= "edit";		

        $this->db->select('tr_pengajuan_cuti.*, md_jenis_cuti.nama_jenis_cuti, md_karyawan.nama_lengkap');
        $this->db->from('tr_pengajuan_cuti');
        $this->db->join('md_jenis_cuti', 'tr_pengajuan_cuti.id_jenis_cuti = md_jenis_cuti.id_jenis_cuti', 'left');
        $this->db->join('md_karyawan', 'tr_pengajuan_cuti.id_karyawan = md_karyawan.id_karyawan', 'left');
        $this->db->where('tr_pengajuan_cuti.'.$this->pk, $id);
        $this->db->where('tr_pengajuan_cuti.is_deleted', 0);
        $data['dt_pengajuan_cuti'] = $this->db->get()->row();

        $data['dt_jenis_cuti'] = $this->m_admin->getAll("md_jenis_cuti")->result();
        $data['dt_karyawan']   = $this->m_admin->getAll("md_karyawan")->result();

        $this->template($data);	
    }

    public function save()
    {
        $id_pengajuan_cuti = $this->input->post('id_pengajuan_cuti');
        $id_jenis_cuti     = $this->input->post('id_jenis_cuti');
        $id_karyawan       = $this->input->post('id_karyawan');
        $dari_tgl          = $this->input->post('dari_tgl');
        $sampai_tgl        = $this->input->post('sampai_tgl');
        $alasan_cuti       = $this->input->post('alasan_cuti');

        $tgl_pengajuan = date('Y-m-d');  
        $status = 0; 

        $lama_cuti = (strtotime($sampai_tgl) - strtotime($dari_tgl)) / (60*60*24) + 1;
        if ($lama_cuti < 1) $lama_cuti = 1;

        $data = array(
            'id_jenis_cuti' => $id_jenis_cuti,
            'id_karyawan'   => $id_karyawan,
            'tgl_pengajuan' => $tgl_pengajuan,
            'lama_cuti'     => $lama_cuti,
            'tgl_mulai'     => $dari_tgl,
            'tgl_selesai'   => $sampai_tgl,
            'alasan'        => $alasan_cuti,
            'status'        => $status,
            'is_deleted'    => 0
        );

        $sisa = $this->get_sisa_cuti($id_karyawan);
        if ($lama_cuti > $sisa) {
            $this->session->set_flashdata("error","Sisa cuti hanya $sisa hari di tahun ".date('Y').", tidak bisa mengajukan $lama_cuti hari.");
            if ($this->input->post('mode') == "add") {
                redirect('transaksi/pengajuan_cuti/add');
            } else {
                redirect('transaksi/pengajuan_cuti/edit/'.$id_pengajuan_cuti);
            }
            return;
        }

        if ($this->input->post('mode') == "add") {
            $res = $this->m_admin->insertData($this->tables, $data);
            $msg = $res ? "Simpan Berhasil" : "Simpan Gagal";
            $this->session->set_flashdata($res ? "success":"error", $msg);
            redirect('transaksi/pengajuan_cuti');
        } elseif ($this->input->post('mode') == "edit") {
            $res = $this->m_admin->updateData($this->tables, $data, $this->pk, $id_pengajuan_cuti);
            $msg = $res ? "Update Berhasil" : "Update Gagal";
            $this->session->set_flashdata($res ? "success":"error", $msg);
            redirect('transaksi/pengajuan_cuti');
        }
    }

    public function set_status($id, $aksi)
    {
        $map = ['approve' => 1, 'reject' => 2];
        if (!isset($map[$aksi])) show_404();

        $res = $this->m_admin->updateData($this->tables, ['status' => $map[$aksi]], $this->pk, $id);
        $msg = $res ? 'Status cuti berhasil diubah' : 'Gagal mengubah status cuti';
        $this->session->set_flashdata($res ? 'success':'error', $msg);

        redirect('transaksi/pengajuan_cuti/riwayat');
    }

    // Soft delete
    public function delete($id)
    {
        $res = $this->m_admin->updateData($this->tables, ['is_deleted'=>1], $this->pk, $id);
        $msg = $res ? "Riwayat berhasil dihapus" : "Hapus Gagal";
        $this->session->set_flashdata($res ? "success":"error", $msg);
        redirect('transaksi/pengajuan_cuti/riwayat');					
    }
}
