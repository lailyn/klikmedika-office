<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	var $tables =   "md_galeri";		
	var $page		=		"front/galeri";
	var $file		=		"galeri";
	var $pk     =   "id_galeri";
	var $title  =   "Galeri";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='front/galeri'>Galeri</a></li>										
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
		$this->load->model('m_galeri');		

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
		$list = $this->m_galeri->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
			$r = $this->m_admin->getByID("md_galeri_kategori","id_galeri_kategori",$isi->id_galeri_kategori);
			$kategori = ($r->num_rows() > 0) ? $r->row()->kategori : "" ;					
			

			if(!isset($isi->gambar) AND $isi->gambar==""){
        $foto = "user.png";
      }else{
        $foto = $isi->gambar;
      }

      if($isi->status=="draft"){      
      	$status = "<label class='badge badge-danger'>Draft</label>";
      }else{
      	$status = "<label class='badge badge-success'>Published</label>";
      }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='front/galeri/detail?id=$isi->id_galeri'>$isi->judul</a> $status";
			$row[] = $kategori;			
			$row[] = "<img src='assets/art1kel/$foto' class='mb-6 mw-100 rounded'>";
			$row[] = "
						<a href=\"front/galeri/delete?id=$isi->id_galeri\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
            <a href=\"front/galeri/edit?id=$isi->id_galeri\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>";	
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_galeri->count_all(),
						"recordsFiltered" => $this->m_galeri->count_filtered(),
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
		$data['dt_kategori'] = $this->m_admin->getAll("md_galeri_kategori");
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function kategori()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah Kategori ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['set']		= "insert2";	
		$data['dt_kategori'] = $this->m_admin->getAll("md_galeri_kategori");
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri'>";
	}	
	public function delete_kategori()
	{		
		$tabel			= "md_galeri_kategori";
		$pk 				= "id_galeri_kategori";
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri/kategori'>";
	}	
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/art1kel/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				

    $err = "";
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['gambar']	= $this->upload->file_name;
			}
		}

		$data['id_galeri_kategori'] 			= $this->input->post('id_galeri_kategori');				
		$data['judul'] 			= $this->input->post('judul');						
		$data['status'] 			= $this->input->post('status');				
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['created_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
		
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
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['gambar']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('gambar')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_galeri","id_galeri",$id)->row();
	    	if(isset($row->gambar)){
	    		unlink('assets/art1kel/'.$row->gambar);         	    		
	    	}
				$data['gambar']	= $this->upload->file_name;
			}
		}

		$data['id_galeri_kategori'] 			= $this->input->post('id_galeri_kategori');				
		$data['judul'] 			= $this->input->post('judul');						
		$data['status'] 			= $this->input->post('status');				
		$data['permalink'] 			= set_permalink($this->input->post('judul'));				
		$data['updated_at'] 			= $waktu;		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}					
		
	}	
	public function save_kategori()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_galeri_kategori";		
		$pk				= "id_galeri_kategori";		
		$data['kategori'] 			= $this->input->post('kategori');								
		$data['created_at'] 			= $waktu;				
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri/kategori'>";							
		
	}
	public function update_kategori()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_galeri_kategori";		
		$pk				= "id_galeri_kategori";		
		$id 			= $this->input->post('id');								
		$data['kategori'] 			= $this->input->post('kategori');								
		$data['updated_at'] 			= $waktu;				
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."front/galeri/kategori'>";							
		
	}
	public function edit_kategori()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah Kategori ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= "md_galeri_kategori";
		$pk			= "id_galeri_kategori";
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert2";		
		$data['mode']		= "edit";				
		$data['dt_galeri'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$data['dt_kategori'] = $this->m_admin->getAll("md_galeri_kategori");
		$this->template($data);	
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
		$data['dt_galeri'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$data['dt_kategori'] = $this->m_admin->getAll("md_galeri_kategori");
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
		$data['dt_galeri'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['dt_kategori'] = $this->m_admin->getAll("md_galeri_kategori");
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
