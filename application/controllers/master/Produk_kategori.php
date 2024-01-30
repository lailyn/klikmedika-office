<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_kategori extends CI_Controller {

	var $tables =   "product_category";		
	var $page		=		"master/produk_kategori";
	var $file		=		"produk_kategori";
	var $pk     =   "id";
	var $title  =   "Kategori Produk";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Produk</a></li>										
	<li class='breadcrumb-item active'><a href='master/produk_kategori'>Kategori Produk</a></li>										
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll($this->tables);
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
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk_kategori'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/4lkes/';
		$config['allowed_types'] 	= 'jpg|png|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		

    $err = "";
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['gambar']	= $this->upload->file_name;
			}
		}

		$data['name'] 			= $this->input->post('name');				
		$data['keterangan'] 			= $this->input->post('keterangan');				
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk_kategori'>";					
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$config['upload_path'] 		= './assets/4lkes/';
		$config['allowed_types'] 	= 'jpg|png|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("product_category","id",$id)->row();
	    	if(isset($row->gambar)){
	    		unlink('assets/4lkes/'.$row->gambar);         	    		
	    	}
				$data['gambar']	= $this->upload->file_name;
			}
		}	
		
		$data['name'] 			= $this->input->post('name');				
		$data['keterangan'] 			= $this->input->post('keterangan');				
		

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk_kategori'>";					
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
		$data['dt_produk_kategori'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_produk_kategori'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
