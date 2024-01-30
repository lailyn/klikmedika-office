<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {

	var $tables =   "md_pesan";		
	var $page		=		"front/pesan";
	var $file		=		"pesan";
	var $pk     =   "id_pesan";
	var $title  =   "Pesan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Front</a></li>										
	<li class='breadcrumb-item active'><a href='front/pesan'>Pesan</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		$this->load->helper('permalink_helper');				
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_pesan');		

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
	public function ajax_list()
	{
		$list = $this->m_pesan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						
      

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/pesan/detail?id=$isi->id_pesan'>$isi->nama</a>";						
			$row[] = $isi->subjek;			
			$row[] = $isi->pesan;			
			$row[] = "						
            <a href=\"front/pesan/detail?id=$isi->id_pesan\" class=\"btn btn-primary btn-sm\">baca</a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_pesan->count_all(),
						"recordsFiltered" => $this->m_pesan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function detail()
	{								
		$waktu 		= gmdate("y-m-d h:i:s", time()+60*60*7);				
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data2['status'] 			= "read";
		$data2['updated_at'] 			= $waktu;
		$this->m_admin->update($tabel,$data2,$pk,$id);			
		$data['set']		= "insert";		
		$data['dt_pesan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
