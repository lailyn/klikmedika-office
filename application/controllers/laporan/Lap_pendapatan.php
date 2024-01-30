<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_pendapatan extends CI_Controller {

	var $tables =   "";			
	var $file   =   "lap_pendapatan";
	var $pk     =   "";
	var $title  =   "Laporan Pendapatan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Laporan</a></li>										
	<li class='breadcrumb-item active'><a href='laporan/lap_pendapatan'>Lap Pendapatan</a></li>										
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
		$data['isi']    = "lap_pendapatan";		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																																		
		$data['page']		= "laporan/lap_pendapatan";				
		$filter_1 = $this->input->post("tgl_awal");
		$filter_2 = $this->input->post("tgl_akhir");
		$filter_3 = $this->input->post("status");
		$data['filter_1']="";$data['filter_2']="";$data['filter_3']="";
		if(isset($filter_1) AND !is_null($filter_1)) $data['filter_1'] = $filter_1;			
		if(isset($filter_2) AND !is_null($filter_2)) $data['filter_2'] = $filter_2;					
		if(isset($filter_3) AND !is_null($filter_3)) $data['filter_3'] = $filter_3;					
		if($filter_1!="" OR $filter_2!=""){
			$data['set']		= "detail";
		}else{
			$data['set']		= "view";
		}
		$this->template($data);	
	}	
}
