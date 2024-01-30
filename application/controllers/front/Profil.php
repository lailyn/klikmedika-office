<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	var $tables =   "md_profil";		
	var $page		=		"front/profil";
	var $file		=		"profil";
	var $pk     =   "id_profil";
	var $title  =   "Lain-lain";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Front</a></li>										
	<li class='breadcrumb-item active'><a href='front/profil'>Lain-lain</a></li>										
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
		$this->load->model('m_profil');		

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
		$list = $this->m_profil->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {						
      

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/profil/detail?id=$isi->id_profil'>$isi->profil</a>";			
			$row[] = "						
            <a href=\"front/profil/edit?id=$isi->id_profil\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_profil->count_all(),
						"recordsFiltered" => $this->m_profil->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/art1kel/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    //$config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_profil","id_profil",$id)->row();
	    	if(isset($row->gambar)){
	    		unlink('assets/front/img/'.$row->gambar);         	    		
	    	}
				$data['gambar']	= $this->upload->file_name;
			}
		}

		$data['profil'] 			= $this->input->post('profil');						
		$data['deskripsi'] 			= $this->input->post('deskripsi');								
		$data['updated_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/profil'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}					
		
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
		$data['dt_profil'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_profil'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
