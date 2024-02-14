<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M4suk4dm1n extends CI_Controller {

  var $tables =   "ind_user";		
  var $file		=		"dashboard";
  var $page		=		"dashboard";
  var $pk     =   "user_id";
  var $title  =   "Dashboard";
  var $bread	=   "<a href='' class='current'>Dashboard</a>";				          

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
		if($name=="")
		{			
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n?denied'>";
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	public function index()
	{				
		$config_captcha = array(
			'img_path'  => './captcha/',
			'img_url'  => base_url() . 'captcha/',
			'img_width'  => '130',
			'img_height' => 30,
			'border' => 0,
			'expiration' => 7200
		);

		// create captcha image
		$cap = create_captcha($config_captcha);

		// store image html code in a variable
		$data['captchaImg'] = $cap['image'];

		// store the captcha word in a session
		$this->session->set_userdata('mycaptcha', $cap['word']);
		
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";				
		$app = $this->session->userdata('app');
		$nama = $this->session->userdata('nama');
		if($app=="keimedika"){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n/dashboard'>";
			$_SESSION['pesan'] 	= "Selamat Datang Kembali, ".$nama."!";
			$_SESSION['tipe'] 	= "success";
		}else{
			$this->load->view("login",$data);
		}
	}
	public function login()
	{
		$username =	$this->input->post('username');
		$password = md5(encr().$this->input->post('password'));				
		$tgl 			= gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		$kode = $this->input->post('kode');
		$mycaptcha 	= $this->session->userdata('mycaptcha');
		if($kode == $mycaptcha) {				
			$rs_login = $this->m_admin->login($username, $password);				
			if ($rs_login->num_rows() == 1) {
				$row = $rs_login->row();										
				$newdata = array(
					'username'  => $row->email,
					'nama'     	=> $row->nama_lengkap,
					'foto'     	=> $row->foto,
					'id_user' 	=> $row->id_user,
					'level' 		=> $row->level,										
					'jenis' 		=> $row->jenis,										
					'id_karyawan' 		=> $row->id_karyawan,
					'id_user_type' => $row->id_user_type,
					'app' => "klikmedika-office"
				);
				$nama = $row->nama_lengkap;
				$this->session->set_userdata($newdata);
				$_SESSION['pesan'] 	= "Selamat Datang, ".$nama."!";
				$_SESSION['tipe'] 	= "success";
				echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n/dashboard'>";						
			} else {
				$_SESSION['pesan'] 	= "Kombinasi Username dan Password salah!";
				$_SESSION['tipe'] 	= "danger";
				echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n?usernametidakada'>";
			}		
		} else {
			$_SESSION['pesan'] 	= "Kode Captcha Salah!";
			$_SESSION['tipe'] 	= "danger";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n'>";
		}		
	}
	public function logout()
	{		
		session_destroy();
		session_unset();	
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n'>";
	}
	public function dashboard($cek=null)	
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "dashboard";		
		$data['title2']	= "Dashboard";		
		if(!is_null($cek)){ 
			//$isi = $this->m_admin->cek_status();
			// if($isi>0) $ada = $isi." Data Confirmed";
			// 	else $ada = "";
			$_SESSION['pesan'] 		= "Sync berhasil ";
			$_SESSION['tipe'] 		= "success";						
		}		
		$this->template($data);	
	}	
	public function notifikasi()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "notifikasi";		
		$data['title2']	= "Notifikasi";		
		$this->load->view('back_template/header',$data);
		$this->load->view('back_template/aside');			
		$this->load->view("master/notifikasi");		
		$this->load->view('back_template/footer');
	}	
	public function grafik()	
	{								
		$data['isi']    = "grafik";		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "grafik";		
		$data['title2']	= "Grafik";		
		$this->load->view('back_template/header',$data);
		$this->load->view('back_template/aside');			
		$this->load->view('grafik');		
		$this->load->view('back_template/footer');
	}
}
