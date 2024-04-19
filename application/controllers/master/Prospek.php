<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospek extends CI_Controller {

	var $tables =   "md_prospek";		
	var $page		=		"master/prospek";
	var $file		=		"prospek";
	var $pk     =   "id";
	var $title  =   "Prospek";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Prospek</a></li>										
	<li class='breadcrumb-item active'><a href='master/prospek'>Prospek</a></li>										
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
		$config = $this->m_admin->set_upload_options('./assets/uploads/sites/','jpg|png|jpeg','1000');		
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
		$config['upload_path'] 		= './assets/uploads/sites/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		

    $err = "";
    if(!empty($_FILES['logo']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('logo')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['logo']	= $this->upload->file_name;
			}
		}
		
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');										
		$data['nama_faskes'] 			= $this->input->post('nama_faskes');								
		$data['status'] 			= $this->input->post('status');										
		$data['alamat'] 			= $this->input->post('alamat');
		$data['no_hp'] 			= $this->input->post('no_hp');							
		$data['keterangan'] 			= $this->input->post('keterangan');																		
		$data['jenis'] 			= $this->input->post('jenis');																		
		$data['tgl_daftar'] 			= $this->input->post('tgl_daftar');
		$data['status_prospek'] 			= $this->input->post('status_prospek');
		$data['created_at'] 			= $waktu;		
		$data['created_by'] 			= $id_user;
		
		if($err!=""){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}else{
			$this->m_admin->insert($tabel,$data);							
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/prospek'>";							
		}
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;								
		
		$id_user = $this->session->userdata("id_user");		
		$config['upload_path'] 		= './assets/uploads/sites/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['logo']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('logo')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_prospek","id",$id)->row();
	    	if(isset($row->logo)){
	    		unlink('assets/uploads/sites/'.$row->logo);         	    		
	    	}
				$data['logo']	= $this->upload->file_name;
			}
		}		

		$id_kel 			= $this->input->post('id_kelurahan');
		if($id_kel!=""){				
			$data['id_kelurahan'] = $this->input->post('id_kelurahan');
		}				
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');										
		$data['nama_faskes'] 			= $this->input->post('nama_faskes');								
		$data['status'] 			= $this->input->post('status');										
		$data['alamat'] 			= $this->input->post('alamat');
		$data['no_hp'] 			= $this->input->post('no_hp');							
		$data['tgl_daftar'] 			= $this->input->post('tgl_daftar');																		
		$data['keterangan'] 			= $this->input->post('keterangan');																		
		$data['jenis'] 			= $this->input->post('jenis');																		
		$data['status_prospek'] 			= $this->input->post('status_prospek');		
		$data['updated_at'] 			= $waktu;				
		$data['updated_by'] 			= $id_user;		
		
		if($err!=""){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}else{
			$this->m_admin->update($tabel,$data,$pk,$id);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/prospek'>";					
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
		$data['dt_prospek'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$sql = $this->m_admin->getAll("md_prospek");
		foreach($sql->result() AS $er){
			if($er->sku==''){
				$data['sku'] = $this->get_kode();
				$this->m_admin->update("md_prospek",$data,"id",$er->id);
			}
		}
	}
	public function get_kode(){
		$tgl = date("Y-m");
		$rd = rand(11,99);
		$q = $this->db->query("SELECT MAX(RIGHT(sku,6)) AS kd_max FROM md_prospek WHERE LEFT(created_at,7) = '$tgl' ORDER BY id DESC LIMIT 0,1");
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
