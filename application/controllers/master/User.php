<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	var $tables =   "md_user";		
	var $page		=		"master/user";
	var $file		=		"user";
	var $pk     =   "id_user";
	var $title  =   "User";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/user'>User</a></li>										
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
		$this->load->model('m_user');		

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
		$this->template($data);	
	}	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['dt_user_type'] = $this->m_admin->getAll('md_user_type');		
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/im493/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['foto']	= $this->upload->file_name;
			}
		}
		$data['id_user_type'] 			= $this->input->post('id_user_type');				
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');						
		$data['jenis'] 			= "user";						
		$data['password'] 			= md5(encr().$this->input->post('password'));				
		$data['tgl_daftar'] 			= $waktu;
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";							
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$config['upload_path'] 		= './assets/im493/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_karyawan","id_karyawan",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/im493/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}			

		$data['id_user_type'] 			= $this->input->post('id_user_type');				
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');						
		$password 			= $this->input->post('password');
		if($password!=""){				
			$data['password'] 			= md5(encr().$this->input->post('password'));				
		}
		$data['updated_at'] 			= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					
		
	}
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");
		$cek = $this->m_admin->getByID("md_user","id_user",$id)->row();
		$no_hp = $cek->no_hp;
		$jenis = $cek->jenis;
		if($jenis=="karyawan"){
			$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_karyawan;		
			$password = md5(encr().$pass);		
		}elseif($jenis=="dokter"){
			$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_dokter;		
			$password = md5(encr().$pass);		
		}elseif($jenis=="user"){
			$tiga = substr($no_hp,-3);
			$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_user;		
			$password = md5(encr().$pass.$tiga);		
		}elseif($jenis=="apotek"){
			$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_apotek;		
			$password = md5(encr().$pass);		
		}
		
		$data['password'] 	= $password;
		$data['updated_at']	= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Password berhasil direset";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					
		
	}
	public function aktifkan()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$data['status'] = $data['admin_verified'] = $data['email_verified'] 	= 1;
		$data['updated_at'] = $data['verified_time']	= $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Akun berhasil diaktifasi";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					
		
	}
	public function banned()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$data['status'] = 0;
		$data['banned'] = 1;
		$data['updated_at'] = $waktu;
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Akun berhasil di-banned";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					
		
	}	
	public function resend(){
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id = $this->input->get("id");		
		$cek = $this->m_admin->getByID("md_user","id_user",$id)->row();
		$email_dec = $cek->email;

		$otp = rand(1000,9999);		
		$this->db->query("UPDATE md_user SET otp = '$otp' WHERE email = '$email_dec'");		
		$kirim = $this->m_admin->send_verifikasi($email_dec,$otp);
		
		if($kirim=="berhasil"){
			$this->db->query("UPDATE md_user SET email_sent = 1 WHERE email = '$email_dec'");
			$_SESSION['pesan'] 		= "Kode OTP terkirim, silahkan cek kotak masuk Email atau spam anda";
			$_SESSION['tipe'] 		= "success";
		}else{
			$_SESSION['pesan'] 		= $kirim;
			$_SESSION['tipe'] 		= "danger";
		}
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/user'>";					

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
		$data['dt_user_type'] = $this->m_admin->getAll('md_user_type');
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
		$data['dt_user'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_user_type'] = $this->m_admin->getAll('md_user_type');
		//$data['dt_kelurahan'] = $this->m_admin->getAll('ms_kelurahan');		
		$data['dt_user'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
