<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {

	var $tables =   "products";		
	var $page		=		"master/paket";
	var $file		=		"paket";
	var $pk     =   "id";
	var $title  =   "Paket";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Paket</a></li>										
	<li class='breadcrumb-item active'><a href='master/paket'>Paket</a></li>										
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll('md_kategori');		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/paket'>";
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/paket/edit?id=".$id."'>";							
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
		
		$config = $this->m_admin->set_upload_options('./assets/uploads/products/','jpg|png|jpeg','1000');
		$files = $_FILES;
    $cpt = count($_FILES['gambar']['name']);
    $err="";
    for($i=0; $i<$cpt; $i++)
    {
      $_FILES['gambar']['name']= $files['gambar']['name'][$i];
      $_FILES['gambar']['type']= $files['gambar']['type'][$i];
      $_FILES['gambar']['tmp_name']= $files['gambar']['tmp_name'][$i];
      $_FILES['gambar']['error']= $files['gambar']['error'][$i];
      $_FILES['gambar']['size']= $files['gambar']['size'][$i];
				
			if(!empty($_FILES['gambar']['name'])){
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('gambar')){
					$err = $this->upload->display_errors();				
				}else{
					$err = "";								
					$dataInfo[] = $this->upload->file_name;
					$data['picture_name'] 					= $dataInfo[0];
				}
			}        
    }    

		$data['sku'] 			= $this->get_kode();
		$data['name'] 			= $this->input->post('name');								
		$data['status'] 			= $this->input->post('status');								
		$data['description'] 			= $this->input->post('description');
		$data['tipe'] 			= 2;
		$data['id_kategori'] 			= $this->input->post('id_kategori');	
		$data['id_merchant'] 			= $this->input->post('id_merchant');	
		$data['current_discount'] 			= $this->input->post('current_discount');		
		$data['price'] 			= str_replace(",", "", $this->input->post('price'));
		$data['description'] 			= $this->input->post('keterangan');																
		$data['created_at'] 			= $waktu;
		//$data['id_apotek'] 				= $id_apotek;
		$data['created_by'] 			= $id_user;
		$isi = $this->input->post("jum");
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$id = $this->db->insert_id();
			if(isset($_POST["id_product_".$i])){
				for($i=1; $i<=$isi; $i++){
					$data2['paket_id'] = $id;
					$data2['product_id'] = $_POST["id_product_".$i];
					$this->m_admin->insert("product_details",$data2);						
				}    
			}

			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/paket'>";							
		}else{
			$_SESSION['pesan'] 		= "Data gagal disimpan";
			$_SESSION['tipe'] 		= "danger";
			echo "<script>history.go(-1)</script>";
		}
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;								
		$id 	= $this->input->post('id');		
		$id_user = $this->session->userdata("id_user");		
		$config = $this->m_admin->set_upload_options('./assets/uploads/products/','jpg|png|jpeg','1000');				
		$files = $_FILES;
    $cpt = count($_FILES['gambar']['name']);
    $err="";
    for($i=0; $i<$cpt; $i++)
    {
      $_FILES['gambar']['name']= $files['gambar']['name'][$i];
      $_FILES['gambar']['type']= $files['gambar']['type'][$i];
      $_FILES['gambar']['tmp_name']= $files['gambar']['tmp_name'][$i];
      $_FILES['gambar']['error']= $files['gambar']['error'][$i];
      $_FILES['gambar']['size']= $files['gambar']['size'][$i];
				
			if(!empty($_FILES['gambar']['name'])){
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('gambar')){
					$err = $this->upload->display_errors();				
				}else{
					$err = "";	
					$dataInfo[] = $this->upload->file_name;
					$data['picture_name'] 			= $dataInfo[0]; 
				}
			}        
    }	    	    

		$id 			= $this->input->post('id');				
		//$data['kode_produk'] 			= $this->get_kode();
		$data['name'] 			= $this->input->post('name');								
		$data['status'] 			= $this->input->post('status');						
		$data['description'] 			= $this->input->post('description');
		$data['id_kategori'] 			= $this->input->post('id_kategori');	
		$data['id_merchant'] 			= $this->input->post('id_merchant');	
		$data['current_discount'] 			= $this->input->post('current_discount');		
		$data['price'] 			= str_replace(",", "", $this->input->post('price'));							
		$data['description'] 			= $this->input->post('keterangan');												
		$data['updated_at'] 			= $waktu;				
		$data['updated_by'] 			= $id_user;		
		$isi = $this->input->post("jum");		
		if($err==""){
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$this->m_admin->delete("product_details","paket_id",$id);
			for($i=1; $i<=$isi; $i++){
				if(isset($_POST["id_product_".$i])){
					$data2['paket_id'] = $id;
					$data2['product_id'] = $_POST["id_product_".$i];
					$this->m_admin->insert("product_details",$data2);						
				}
			}
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/paket'>";					
		}else{
			$_SESSION['pesan'] 		= "Data gagal disimpan";
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll('md_kategori');		
		$data['dt_paket'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_produk_kategori'] = $this->m_admin->getAll('md_kategori');		
		$data['dt_paket'] = $this->m_admin->getByID($tabel,$pk,$id);
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
