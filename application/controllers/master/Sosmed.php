<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sosmed extends CI_Controller {

	var $tables =   "md_sosmed";		
	var $page		=		"master/sosmed";
	var $file		=		"sosmed";
	var $pk     =   "id_sosmed";
	var $title  =   "Sosmed";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/sosmed'>Sosmed</a></li>										
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
		$this->load->model('m_sosmed');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->file,$data['set']);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."acm1nt0ck0'>";
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
		$list = $this->m_sosmed->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
			if($isi->status==1){
				$status = "<label class='badge badge-danger'>draft</label>";
			}else{
				$status = "<label class='badge badge-success'>terkirim</label>";
			}

			$cekKaryawan = $this->m_admin->getByID("md_karyawan","id_karyawan",$isi->id_karyawan);
			$karyawan = ($cekKaryawan->num_rows()>0)?$cekKaryawan->row()->nama_lengkap:'';

			$cekKategori = $this->m_admin->getByID("md_kategoriSosmed","id_kategori",$isi->id_kategori);
			$kategori = ($cekKategori->num_rows()>0)?$cekKategori->row()->kategori:'';

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/sosmed/detail?id=$isi->id_sosmed'>$isi->judul</a>";		
			$row[] = $kategori;	
			$row[] = $karyawan;					
			$row[] = $isi->link;					
			$row[] = $isi->created_at;			
			$row[] = "						
						<a href=\"master/sosmed/delete?id=$isi->id_sosmed\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
            <a href=\"master/sosmed/edit?id=$isi->id_sosmed\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_sosmed->count_all(),
						"recordsFiltered" => $this->m_sosmed->count_filtered(),
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
	public function kategori()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah Kategori ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['set']		= "insert";	
		$data['mode']		= "kategori";									
		$this->template($data);	
	}
	public function deleteKategori()
	{		
		$tabel			= "md_kategoriSosmed";
		$pk 				= "id_kategori";
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/sosmed/kategori'>";
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/sosmed'>";
	}	
	public function saveKategori()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_kategoriSosmed";		
		$pk				= "id_kategori";
		
		$data['kategori'] 			= $this->input->post('kategori');								
		$data['created_at'] 			= $waktu;

		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/sosmed/kategori'>";							
		
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$data['judul'] 			= $this->input->post('judul');						
		$data['id_kategori'] 			= $this->input->post('id_kategori');						
		$data['id_karyawan'] 			= $this->input->post('id_karyawan');		
		$data['link'] = $link 			= $this->input->post('link');						
		$data['created_at'] 			= $waktu;

		$cekLink = $this->m_admin->getByID("md_sosmed","link",$link);
		if($cekLink->num_rows()>0){
			$_SESSION['pesan'] 		= "Data Duplikat";
			$_SESSION['tipe'] 		= "success";		
			echo "<script>history.go(-1)</script>";
		}else{
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/sosmed'>";							
		}
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 			= $this->input->post('id');				
		$data['judul'] 			= $this->input->post('judul');				
		$data['id_kategori'] 			= $this->input->post('id_kategori');						
		$data['link'] = $link			= $this->input->post('link');								
		$link_lama			= $this->input->post('link_lama');								
		$data['id_karyawan'] 			= $this->input->post('id_karyawan');								
		
		$data['updated_at'] 			= $waktu;
		
		$cekLink = $this->m_admin->getByID("md_sosmed","link",$link);
		if($cekLink->num_rows()>0 && $link_lama!=$link){
			$_SESSION['pesan'] 		= "Data Duplikat";
			$_SESSION['tipe'] 		= "success";		
			echo "<script>history.go(-1)</script>";
		}else{
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/sosmed'>";					
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
		$data['dt_sosmed'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_sosmed'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
