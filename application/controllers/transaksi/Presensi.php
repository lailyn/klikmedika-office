<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends CI_Controller {

	var $tables =   "md_presensi";		
	var $page		=		"transaksi/presensi";
	var $file		=		"presensi";
	var $pk     =   "presensi_id";
	var $title  =   "Presensi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Teknisi</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/presensi'>Presensi</a></li>										
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
		$data['bread']	= "";																													
		$data['set']		= "view";		
		$data['mode']		= "view";
		if($this->session->level!='admin'){				
			$this->template($data);	
		}else{
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view("transaksi/presensiAdmin");		
			$this->load->view('back_template/footer');
		}
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d", time()+60*60*7);		
		$jam_sekarang  = gmdate("H:i:s", time()+60*60*7);    
		$jam_sekarang_stamp = strtotime($jam_sekarang);
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$data['id_karyawan'] 		= $id_karyawan	= $this->input->post('id_karyawan');										
		$data['kerja_ket'] 			= $this->input->post('kerja_ket');								
		$data['kesehatan'] 			= $this->input->post('kesehatan');										
		$data['waktu'] 			= $this->input->post('waktu');								
		$data['created_at'] 			= $waktu;
		$data['trans'] 			= $this->input->post('trans');		
		$data['jenis']  = $jenis			= $this->input->post('submit');		
		$data['tagging'] 			= $this->input->post('tagging');		
		$data['shift'] 		= $shift	= $this->input->post('shift');	

		
		$jam_datang = $this->m_admin->getByID("md_setting","id_setting",1)->row()->jam_datang_s1;	
		$jam_pulang = $this->m_admin->getByID("md_setting","id_setting",1)->row()->jam_pulang_s1;	
		
		$jenis = "pulang";
		if($jenis=='datang'){			
	    $jam_awal_datang_stamp = strtotime($jam_datang);	    	    
	    if ($jam_sekarang_stamp - $jam_awal_datang_stamp > 1 * 60) {
	      $data['telat'] = 1;
	    }
		}else{
			$jam_awal_pulang_stamp = strtotime($jam_pulang);	    	    
	    if ($jam_sekarang_stamp < $jam_awal_pulang_stamp) {
	      $data['telat'] = 1;
	    }
		}		

		$config = $this->m_admin->set_upload_options('./assets/uploads/presensi/','jpg|png|jpeg|pdf','5000');		
		$err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['foto']	= $this->upload->file_name;
			}
		}
		
		if($err!=''){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";											
			echo "<script>history.go(-1)</script>";
			exit();
		}


		$cek = $this->db->query("SELECT * FROM md_presensi WHERE id_karyawan = '$id_karyawan' AND jenis = '$jenis' AND LEFT(waktu,10) = '$tgl'");
		if($cek->num_rows() == 0){                            
			$this->m_admin->insert("md_presensi",$data);					
			$_SESSION['pesan'] 		= "Presensi kamu berhasil";
			$_SESSION['tipe'] 		= "success";									
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/presensi'>";							
		}else{
			$_SESSION['pesan'] 		= "Presensi gagal, Kamu sudah isi presensi";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1);</script>";
		}
	}	
}
