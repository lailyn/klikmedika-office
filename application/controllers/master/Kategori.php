<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	var $tables =   "md_kategori";		
	var $page		=		"master/kategori";
	var $file		=		"kategori";
	var $pk     =   "id_kategori";
	var $title  =   "Kategori";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Karyawan</a></li>										
	<li class='breadcrumb-item active'><a href='master/kategori'>Kategori</a></li>										
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
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->file,$data['set']);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";		
		$data['dt_kategori'] = $this->m_admin->getAll($this->tables);
		$this->template($data);	
	}
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "insert";	
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/kategori'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		

		$data['kategori'] 			= $this->input->post('kategori');				
		$data['deskripsi'] 			= $this->input->post('deskripsi');				
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/kategori'>";					
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 	= $this->input->post('id');		
		$data['kategori'] 			= $this->input->post('kategori');
		$data['deskripsi'] 			= $this->input->post('deskripsi');								
		$data['updated_at'] 			= $waktu;

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/kategori'>";					
	}	
	public function edit()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['mode']		= "edit";		
		$data['dt_kategori'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}
	public function detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['dt_kategori'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
