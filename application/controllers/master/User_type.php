<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_type extends CI_Controller {

	var $tables =   "md_user_type";		
	var $page		=		"master/user_type";
	var $file		=		"user_type";
	var $pk     =   "id_user_type";
	var $title  =   "User Type";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/user_type'>User Type</a></li>										
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
		if($this->session->id_user_type==5) $data['dt_user_type'] = $this->m_admin->getAll($this->tables);
			else 	$data['dt_user_type'] = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type <> 5");
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
	public function akses()
	{				
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$data['data_user_type'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['title2']	= "User Access ".$this->title;		
		$data['bread']	= $this->bread;		
		$data['set']		= "insert";		
		$data['mode']		= "access";		
		$this->template($data);	
	}	
	public function save_access()
	{				
		$tabel									= "md_user_access";		
		$data['id_user_type'] = $id_user_type			= $this->input->post('id_user_type');									
		$jml 			= $this->input->post('jml');									
		for ($i=1; $i <= $jml; $i++) { 									
			$data["id_menu"] = $id_menu = $_POST["id_menu_".$i];									
			if(isset($_POST["view_".$i])) $data["can_view"] = $_POST["view_".$i];									
				else $data["can_view"] = 0;
			if(isset($_POST["insert_".$i])) $data["can_insert"] = $_POST["insert_".$i];									
				else $data["can_insert"] = 0;
			if(isset($_POST["edit_".$i])) $data["can_edit"] = $_POST["edit_".$i];									
				else $data["can_edit"] = 0;
			if(isset($_POST["delete_".$i])) $data["can_delete"] = $_POST["delete_".$i];									
				else $data["can_delete"] = 0;
			

			$cek = $this->db->query("SELECT * FROM md_user_access WHERE id_menu = '$id_menu' AND id_user_type = '$id_user_type'");
			if($cek->num_rows() > 0){						
				$this->m_admin->update("md_user_access",$data,"id_user_access",$cek->row()->id_user_access);								
			}else{
				$this->m_admin->insert("md_user_access",$data);												
			}		
		}				
		$this->m_admin->insert($tabel,$data);
		$_SESSION['pesan'] 	= "Data has been saved successfully";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user_type'>";		
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user_type'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		

		$data['user_type'] 			= $this->input->post('user_type');				
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user_type'>";					
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 	= $this->input->post('id');		
		$data['user_type'] 			= $this->input->post('user_type');				
		$data['updated_at'] 			= $waktu;

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user_type'>";					
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
		$data['dt_user_type'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_user_type'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}

