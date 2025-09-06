<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_cuti extends CI_Controller {

    var $tables =   "md_jenis_cuti";		
    var $page	=	"master/jenis_cuti";
    var $file	=	"jenis_cuti";
    var $pk     =   "id_jenis_cuti";
    var $title  =   "Jenis Cuti";
    var $bread	=   "<ol class='breadcrumb'>
    <li class='breadcrumb-item'><a>Master</a></li>
    <li class='breadcrumb-item active'><a href='master/jenis_cuti'>Jenis Cuti</a></li>
    </ol>";

    public function __construct()
    {		
        parent::__construct();
        //---- cek session -------//		

        //===== Load Database =====
        $this->load->database();
        $this->load->helper('url', 'string');
        //===== Load Model =====
        $this->load->model('m_admin');		
        //===== Load Library =====
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
        $data['set']		= "view";		
        $data['mode']		= "view";		
        $data['dt_jenis_cuti'] = $this->m_admin->getAll($this->tables)->result();
        $this->template($data);	
    }
    public function add()
    {								
        $data['isi']    = $this->file;		
        $data['title']	= "Tambah ".$this->title;	
        $data['bread']	= $this->bread;																													
        $data['set']		= "add";		
        $data['mode']		= "add";		
        $this->template($data);	
    }
    public function edit($id)
    {								
        $data['isi']    = $this->file;		
        $data['title']	= "Edit ".$this->title;	
        $data['bread']	= $this->bread;																													
        $data['set']		= "edit";		
        $data['mode']		= "edit";		
        $data['dt_jenis_cuti'] = $this->m_admin->getByID($this->tables,$this->pk,$id)->row();
        $this->template($data);	
    }
    public function save()
    {
        $id = $this->input->post('id_jenis_cuti');
        $data = array(            
            'nama_jenis_cuti' => $this->input->post('nama_jenis_cuti'),            
            'keterangan' => $this->input->post('keterangan'),            
            'jumlah_hari' => $this->input->post('jumlah_hari'),            
            'status' => $this->input->post('status'),            
        );
        if($id){
            // update
            $this->m_admin->update($this->tables,$this->pk,$id,$data);
            $this->session->set_flashdata('success', 'Data berhasil diupdate');
        }else{
            // insert
            $this->m_admin->insert($this->tables,$data);
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('master/jenis_cuti');
    }
    public function delete($id)
    {
        $this->m_admin->delete($this->tables,$this->pk,$id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('master/jenis_cuti');
    }
}
