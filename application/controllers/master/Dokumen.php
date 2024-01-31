<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller {

	var $tables =   "md_dokumen";		
	var $file		=		"dokumen";
	var $page		=		"master/dokumen";
	var $pk     =   "id";
	var $title  =   "Dokumen";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Dokumen</a></li>										
	<li class='breadcrumb-item active'><a href='master/dokumen'>Dokumen</a></li>										
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
		$this->load->model('m_dokumen');		

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
		$data['dt_dokumen'] = $this->db->query("SELECT md_dokumen.*, dokumen_category.name AS kategori, md_client.nama_faskes AS client
				FROM md_dokumen INNER JOIN dokumen_category ON md_dokumen.id_kategori = dokumen_category.id
				LEFT JOIN md_client ON md_dokumen.id_client = md_client.id
				ORDER BY md_dokumen.id DESC");
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokumen'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$data['kode'] 			= $this->get_kode();
		$data['name'] 			= $this->input->post('name');						
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['id_client'] 			= $this->input->post('id_client');				
		$data['tgl_surat'] 			= $this->input->post('tgl_surat');						
		$data['no_surat'] 			= $this->input->post('no_surat');						
		$data['tautan'] 			= $this->input->post('tautan');						
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $this->session->id_user;		
    $this->m_admin->insert($tabel,$data);					
    $_SESSION['pesan'] 		= "Data berhasil disimpan";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokumen'>";						
	}
	public function get_kode(){
		$tgl = date("Y-m");
		$rd = rand(11,99);
		$q = $this->db->query("SELECT MAX(RIGHT(kode,6)) AS kd_max FROM md_dokumen WHERE LEFT(created_at,7) = '$tgl' ORDER BY id DESC LIMIT 0,1");
		$kd = "";
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%06s", $tmp);
			}
		}else{
			$kd = "000001";
		}
		return $rd.date('my').$kd;
	}		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id			= $this->input->post('id');						
		$data['name'] 			= $this->input->post('name');						
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['id_client'] 			= $this->input->post('id_client');				
		$data['tgl_surat'] 			= $this->input->post('tgl_surat');						
		$data['no_surat'] 			= $this->input->post('no_surat');						
		$data['tautan'] 			= $this->input->post('tautan');						
		$data['updated_at'] 			= $waktu;		
		$data['updated_by'] 			= $this->session->id_user;		
    $this->m_admin->update($tabel,$data,$pk,$id);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/dokumen'>";						
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
		$data['dt_dokumen'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_dokumen'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
