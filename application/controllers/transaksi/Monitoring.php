<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	var $tables =   "md_konsumen";		
	var $file		=		"monitoring";
	var $page		=		"transaksi/monitoring";
	var $pk     =   "id_konsumen";
	var $title  =   "Monitoring Pembayaran";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Monitoring Pembayaran</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/monitoring'>Monitoring Pembayaran</a></li>										
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
		$this->load->model('m_konsumen');		

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
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";		
		$filter_1 = $this->input->post("filter_1");
		$data['filter_1']=date('Y');
		if(isset($filter_1) AND !is_null($filter_1)) $data['filter_1'] = $filter_1;					
		$this->template($data);	
	}
}
