<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

	var $tables =   "md_salary";		
	var $page		=		"payroll/salary";
	var $file		=		"salary";
	var $pk     =   "id_salary";
	var $title  =   "Master Salary";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Payroll</a></li>										
	<li class='breadcrumb-item active'><a href='payroll/salary'>Master Salary</a></li>										
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."acm1nt0ck0'>";
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
		$data['dt_salary'] = $this->m_admin->getAll($this->tables);
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/salary'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		

		$data['id_bagian'] 		= $this->input->post('id_bagian');				
		$data['gaji_pokok'] 			= $this->m_admin->ubah_rupiah($this->input->post('gaji_pokok'));				
		$data['tunj_transport'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_transport'));				
		$data['tunj_anak'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_anak'));				
		$data['tunj_makan'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_makan'));				
		$data['tunj_istri'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_istri'));				
		$data['pot_asuransi'] 			= $this->m_admin->ubah_rupiah($this->input->post('pot_asuransi'));				
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/salary'>";					
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 	= $this->input->post('id');		
		$data['id_bagian'] 		= $this->input->post('id_bagian');				
		$data['gaji_pokok'] 			= $this->m_admin->ubah_rupiah($this->input->post('gaji_pokok'));				
		$data['tunj_transport'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_transport'));				
		$data['tunj_anak'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_anak'));				
		$data['tunj_makan'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_makan'));				
		$data['tunj_istri'] 			= $this->m_admin->ubah_rupiah($this->input->post('tunj_istri'));				
		$data['pot_asuransi'] 			= $this->m_admin->ubah_rupiah($this->input->post('pot_asuransi'));				
		

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/salary'>";					
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
		$data['dt_salary'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_salary'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
