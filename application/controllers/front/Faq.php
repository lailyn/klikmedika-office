<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	var $tables =   "md_faq";		
	var $page		=		"front/faq";
	var $file		=		"faq";
	var $pk     =   "id_faq";
	var $title  =   "FAQ";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='front/faq'>FAQ</a></li>										
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
		$this->load->model('m_faq');		

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
		$list = $this->m_faq->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/faq/detail?id=$isi->id_faq'>$isi->judul</a> $status";			
			$row[] = "
						<a href=\"front/faq/delete?id=$isi->id_faq\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
            <a href=\"front/faq/edit?id=$isi->id_faq\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_faq->count_all(),
						"recordsFiltered" => $this->m_faq->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/faq'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;					
		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['status'] 			= $this->input->post('status');						
		$data['created_at'] 			= $waktu;				
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/faq'>";							
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id 	= $this->input->post('id');		
		$data['judul'] 			= $this->input->post('judul');						
		$data['isi'] 			= $this->input->post('isi');				
		$data['status'] 			= $this->input->post('status');						
		$data['updated_at'] 			= $waktu;				
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/faq'>";					
		
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
		$data['dt_faq'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_faq'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
