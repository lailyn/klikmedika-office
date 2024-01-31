<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	var $tables =   "products";		
	var $page		=		"master/produk";
	var $file		=		"produk";
	var $pk     =   "id";
	var $title  =   "Produk";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Produk</a></li>										
	<li class='breadcrumb-item active'><a href='master/produk'>Produk</a></li>										
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
		$this->load->model('m_produk');		

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
	public function mata_uang($a){      
    if(is_numeric($a) AND $a != 0 AND $a != ""){
      return number_format($a, 0, ',', '.');
    }else{
      return $a;
    }
  }
	
	public function index($jenis=null)
	{								
		$data['mode']		= "semua";				
		if(!is_null($jenis)){
			$data['mode']		= $jenis;				
		}		
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";				
		$this->template($data);	
	}
	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['dt_produk_kategori'] = $this->m_admin->getAll('product_category');		
		$data['set']		= "insert";	
		$data['mode']		= "insert";									
		$this->template($data);	
	}
	public function import()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Import ".$this->title;	
		$data['bread']	= $this->bread;																															
		$data['set']		= "insert";	
		$data['mode']		= "import";									
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk'>";
	}		
	public function uploadGambar(){
		$config = $this->m_admin->set_upload_options('./assets/uploads/products/','jpg|png|jpeg','1000');		
    $config['encrypt_name'] 	= TRUE; 						
		$data['id'] = $id = $this->input->post('id_prod');											


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
		if($err==""){
			$this->m_admin->insert("md_produk_gambar",$data);					
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk/edit?id=".$id."'>";							
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id_user = $this->session->userdata("id_user");
				

		$data['sku'] 			= $this->get_kode();
		$data['name'] 			= $this->input->post('name');								
		$data['status'] 			= $this->input->post('status');								
		$data['description'] 			= $this->input->post('description');
		$data['id_kategori'] 			= $this->input->post('id_kategori');					
		$data['price'] 			= str_replace(",", "", $this->input->post('price'));
		$data['description'] 			= $this->input->post('keterangan');																
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $id_user;
		
		
		$this->m_admin->insert($tabel,$data);							
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk'>";							
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;								
		$id 	= $this->input->post('id');		
		$id_user = $this->session->userdata("id_user");		
		
		$id 			= $this->input->post('id');						
		$data['name'] 			= $this->input->post('name');								
		$data['status'] 			= $this->input->post('status');						
		$data['description'] 			= $this->input->post('description');
		$data['id_kategori'] 			= $this->input->post('id_kategori');	
		$data['price'] 			= str_replace(",", "", $this->input->post('price'));							
		$data['description'] 			= $this->input->post('keterangan');												
		$data['updated_at'] 			= $waktu;				
		$data['updated_by'] 			= $id_user;		
		
		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/produk'>";					
		
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll('product_category');		
		$data['dt_produk'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll('product_category');		
		$data['dt_produk'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
	public function resetKode(){
		$sql = $this->m_admin->getAll("products");
		foreach($sql->result() AS $er){
			if($er->sku==''){
				$data['sku'] = $this->get_kode();
				$this->m_admin->update("products",$data,"id",$er->id);
			}
		}
	}
	public function get_kode(){
		$tgl = date("Y-m");
		$rd = rand(11,99);
		$q = $this->db->query("SELECT MAX(RIGHT(sku,6)) AS kd_max FROM products WHERE LEFT(created_at,7) = '$tgl' ORDER BY id DESC LIMIT 0,1");
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
}
