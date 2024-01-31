<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends CI_Controller {

	var $tables =   "ms_provinsi";		
	var $page		=		"master/provinsi";
	var $file		=		"provinsi";
	var $pk     =   "id_provinsi";
	var $title  =   "Provinsi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>	
	<li class='breadcrumb-item'><a>Master Wilayah</a></li>																			
	<li class='breadcrumb-item active'><a href='master/provinsi'>Provinsi</a></li>										
	</ol>";				          


	public function __construct()
	{		
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		//===== Load Model =====
		$this->load->model('m_provinsi');		
		$this->load->model('m_admin');		
		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->file,$data['set']);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."adm1n'>";
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
		$data['dt_provinsi'] = $this->m_admin->getAll($this->tables);
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_provinsi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='master/provinsi/detail?id=$isi->id_provinsi'>$isi->id_provinsi</a>";
			$row[] = $isi->provinsi;			
			$row[] = "
						<a href=\"master/provinsi/delete?id=$isi->id_provinsi\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
            <a href=\"master/provinsi/edit?id=$isi->id_provinsi\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_provinsi->count_all(),
						"recordsFiltered" => $this->m_provinsi->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/provinsi'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		

		$data['provinsi'] 			= $this->input->post('provinsi');				
		$data['created_at'] 			= $waktu;
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/provinsi'>";					
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 	= $this->input->post('id');		
		$data['provinsi'] 			= $this->input->post('provinsi');				
		$data['updated_at'] 			= $waktu;

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/provinsi'>";					
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
		$data['dt_provinsi'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_provinsi'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
	public function ambil_kelurahan_all()
  {
		$data = [];
		$term	= $this->input->post('term');		

		if(!is_null($term)){
			$cek = $this->db->query("SELECT ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan FROM ms_kelurahan
	   	  LEFT JOIN	ms_kecamatan ON ms_kelurahan.id_kecamatan = ms_kecamatan.id_kecamatan   	 
				INNER JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
				LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
				WHERE ms_kelurahan.kelurahan LIKE '%$term%'
				OR ms_kecamatan.kecamatan LIKE '%$term%'
				OR ms_kabupaten.kabupaten LIKE '%$term%'");			
			foreach($cek->result() AS $isiData){
				$data[] = array(
					"id"=>$isiData->id_kelurahan,
					"text"=>$isiData->kelurahan.", ".$isiData->kecamatan.", ".$isiData->kabupaten.", ".$isiData->provinsi
				);
			}
		}
		echo json_encode($data);
  }
}
