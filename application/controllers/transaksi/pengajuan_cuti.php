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
        $this->db->where('tr_pengajuan_cuti.status', 0); // hanya pending
        $data['dt_pengajuan_cuti'] = $this->db->get()->result();

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
        $this->db->where_in('tr_pengajuan_cuti.status', [1, 2]); // 1=disetujui, 2=ditolak
        $data['dt_pengajuan_cuti'] = $this->db->get()->result();

        $this->template($data);
    }

    public function set_status($id, $aksi)
    {
        $map = ['approve' => 1, 'reject' => 2];
        if (!isset($map[$aksi])) show_404();
        $res = $this->m_admin->updateData($this->tables, ['status' => $map[$aksi]], $this->pk, $id);
        if ($res >= 1) {
            $this->session->set_flashdata('success', ucfirst($aksi).' berhasil');
        } else {
            $this->session->set_flashdata('error', ucfirst($aksi).' gagal');
        }
        redirect('transaksi/pengajuan_cuti/riwayat');
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
        $data['dt_pengajuan_cuti'] = $this->db->get()->row();

        $data['dt_jenis_cuti'] = $this->m_admin->getAll("md_jenis_cuti")->result();
        $data['dt_karyawan']   = $this->m_admin->getAll("md_karyawan")->result();

        $this->template($data);	
    }

    public function save()
    {
        $id_pengajuan_cuti = $this->input->post('id_pengajuan_cuti');
        $id_jenis_cuti     = $this->input->post('id_jenis_cuti');
        $id_karyawan       = $this->input->post('id_karyawan'); // ambil dari form
        $lama_cuti         = $this->input->post('lama_cuti');
        $dari_tgl          = $this->input->post('dari_tgl');
        $sampai_tgl        = $this->input->post('sampai_tgl');
        $alasan_cuti       = $this->input->post('alasan_cuti');

        $tgl_pengajuan = date('Y-m-d');  
        $status = 0; 

        $data = array(
            'id_jenis_cuti' => $id_jenis_cuti,
            'id_karyawan'   => $id_karyawan,
            'tgl_pengajuan' => $tgl_pengajuan,
            'lama_cuti'     => $lama_cuti,
            'tgl_mulai'     => $dari_tgl,
            'tgl_selesai'   => $sampai_tgl,
            'alasan'        => $alasan_cuti,
            'status'        => $status
        );

        if ($this->input->post('mode') == "add") {
            $res = $this->m_admin->insertData($this->tables, $data);
            if ($res >= 1) {
                $this->session->set_flashdata("success","Simpan Berhasil");
                redirect('transaksi/pengajuan_cuti');
            } else {
                $this->session->set_flashdata("error","Simpan Gagal");
                redirect('transaksi/pengajuan_cuti/add');
            }
        } elseif ($this->input->post('mode') == "edit") {
            $res = $this->m_admin->updateData($this->tables, $data, $this->pk, $id_pengajuan_cuti);
            if ($res >= 1) {
                $this->session->set_flashdata("success","Update Berhasil");
                redirect('transaksi/pengajuan_cuti');
            } else {
                $this->session->set_flashdata("error","Update Gagal");
                redirect('transaksi/pengajuan_cuti/edit/'.$id_pengajuan_cuti);
            }
        }
    }

    public function delete($id)
    {
        $res = $this->m_admin->deleteData($this->tables,$this->pk,$id);
        if($res>=1) {
            $this->session->set_flashdata("success","Hapus Berhasil");
        } else {
            $this->session->set_flashdata("error","Hapus Gagal");
        }
        redirect('transaksi/pengajuan_cuti');					
    }
}
