<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemasukan extends CI_Controller {

	var $tables =   "md_pemasukan";		
	var $page		=		"transaksi/pemasukan";
	var $file		=		"pemasukan";
	var $pk     =   "id_pemasukan";
	var $title  =   "Pemasukan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Finance</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/pemasukan'>Pemasukan</a></li>										
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
		if($data['set']=='delete' OR $data['set']=='edit' OR $data['set']=='view') $set=$data['set'];
			else $set = "insert";
		$auth = $this->m_admin->user_auth($this->file,$set);								
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
		$data['dt_pemasukan'] = $this->m_admin->getAll($this->tables);
		$this->template($data);	
	}
	public function kategori()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "kategori";		
		$data['mode']		= "kategori";		
		$data['dt_pemasukan_kategori'] = $this->m_admin->getAll("md_pemasukan_kategori");
		$this->template($data);	
	}
	public function riwayat()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat";		
		$data['mode']		= "view";		
		$data['dt_pemasukan'] = $this->m_admin->getAll($this->tables);
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan'>";
	}
	public function delete_pemasukan()
	{		
		$tabel			= "md_pemasukan_kategori";
		$pk 				= "id";
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan/kategori'>";
	}
	public function delete_detail()
	{		
		$tabel			= "md_pemasukan_detail";
		$pk 				= "id";
		$id 				= $this->input->get('id');		
		$d 				= $this->input->get('d');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan/tambah_detail?id=".$d."'>";
	}	
	public function cari_kode(){
		$tgl = date("Y-m");
		$q = $this->db->query("SELECT MAX(RIGHT(kode_pemasukan,6)) AS kd_max FROM md_pemasukan WHERE LEFT(updated_at,7) = '$tgl' ORDER BY id_pemasukan DESC LIMIT 0,1");		
		$kd = "";
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%06s", $tmp);
			}
		}else{
			$kd = "000001";
		}
		return date('dmy').$kd;
	}
	public function simpan_kategori()
	{				
		$data['kategori'] 			= $this->input->post('kategori');						
		$this->m_admin->insert("md_pemasukan_kategori",$data);					
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan/kategori'>";					
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$user_id = $this->session->id_user;
		$config['upload_path'] 		= './assets/fin4nc3/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg|pdf';
		$config['max_size']				= '1000';		
		$config['encrypt_name'] 	= TRUE; 				

		$err = "";
		if(!empty($_FILES['file_pendukung']['name'])){
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file_pendukung')){
					$err = $this->upload->display_errors();				
				}else{				
					$data['file_pendukung']	= $this->upload->file_name;
				}
			}

		$data['kode_pemasukan'] 			= $this->cari_kode();
		$data['id_kategori'] 			= $this->input->post('id_kategori');				
		$data['total'] 			= $this->m_admin->ubah_rupiah($this->input->post('total'));				
		$data['tgl'] 			= $this->input->post('tgl');						
		$data['uraian'] 			= $this->input->post('uraian');	
		$data['updated_at'] 			= $waktu;					
		$data['updated_by'] 			= $user_id;					
		
		if($err==""){
			$this->m_admin->insert($tabel,$data);					
			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan'>";					
		}else{
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";			
		}
	}
	public function save_detail()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= "md_pemasukan_detail";				

		$data['kode_pemasukan'] 		= $kode	= $this->input->post('kode');						
		$id	= $this->input->post('id');						
		$data['nominal'] 			= $nominal = $this->m_admin->ubah_rupiah($this->input->post('nominal'));				
		$data['uraian'] 			= $this->input->post('uraian');	
		
		$this->m_admin->insert($tabel,$data);					
		$_SESSION['pesan'] 		.= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan/tambah_detail?id=".$id."'>";					
		
	}	
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		
		$id 	= $this->input->post('id');		
		$data['sumber'] 			= $this->input->post('sumber');				
		$data['nominal'] 			= $this->m_admin->ubah_rupiah($this->input->post('nominal'));				
		$data['tgl_pemasukan'] 			= $this->input->post('tgl_pemasukan');				
		$data['jatuh_tempo'] 			= $this->input->post('jatuh_tempo');				
		$data['keterangan'] 			= $this->input->post('keterangan');						
		$data['updated_at'] 			= $waktu;

		$this->m_admin->update($tabel,$data,$pk,$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/pemasukan'>";					
	}	
	public function bayar()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Bayar ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "bayar";		
		$data['mode']		= "bayar";		
		$data['dt_pemasukan'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_pemasukan'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}
	public function tambah_detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['dt_pemasukan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "tambah_detail";				
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
		$data['dt_pemasukan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}
}
