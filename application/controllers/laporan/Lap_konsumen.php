<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_konsumen extends CI_Controller {

	var $tables =   "";			
	var $file   =   "lap_konsumen";
	var $pk     =   "";
	var $title  =   "Laporan PO";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Laporan</a></li>										
	<li class='breadcrumb-item active'><a href='laporan/lap_konsumen'>Konsumen</a></li>										
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
		if($data['set']=='delete' OR $data['set']=='edit' OR $data['set']=='view') $set=$data['set'];
			else $set = "insert";
		$auth = $this->m_admin->user_auth($this->file,$set);										
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."adm1n'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($data['page']);		
			$this->load->view('back_template/footer');
		}
	}	
	public function index()
	{								
		$data['isi']    = "lap_konsumen";		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																																		
		$data['page']		= "laporan/lap_konsumen";						
		$data['set']		= "detail";		
		$this->template($data);	
	}	
}
