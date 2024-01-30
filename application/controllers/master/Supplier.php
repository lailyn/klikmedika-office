<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	var $tables =   "md_supplier";		
	var $file		=		"supplier";
	var $page		=		"master/supplier";
	var $pk     =   "id_supplier";
	var $title  =   "Supplier";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Supplier</a></li>										
	<li class='breadcrumb-item active'><a href='master/supplier'>Supplier</a></li>										
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
		$this->load->model('m_supplier');		

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
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_supplier->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
						
			if($isi->status==1) $status = "<label class='badge badge-success'>aktif</label>";			
			 else $status = "<label class='badge badge-danger'>non-aktif</label>";								

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/supplier/detail?id=$isi->id_supplier'>$isi->nama_lengkap </a> <br> $status";						
			$row[] = $isi->email." <br> ".$isi->no_hp;						
			$row[] = $isi->alamat;		
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"master/supplier/delete?id=$isi->id_supplier\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"master/supplier/edit?id=$isi->id_supplier\" class='dropdown-item'>Edit</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_supplier->count_all(),
						"recordsFiltered" => $this->m_supplier->count_filtered(),
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/supplier'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['status'] 			= $this->input->post('status');				
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['created_at'] 			= $waktu;		
    $this->m_admin->insert($tabel,$data);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/supplier'>";						
	}		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id			= $this->input->post('id');						
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['status'] 			= $this->input->post('status');								
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['updated_at'] 			= $waktu;		
    $this->m_admin->update($tabel,$data,$pk,$id);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/supplier'>";						
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
		$data['dt_supplier'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_supplier'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
