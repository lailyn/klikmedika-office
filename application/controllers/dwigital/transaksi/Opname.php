<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends CI_Controller {

	var $tables =   "dwigital_stock_opname";		
	var $page		=		"dwigital/transaksi/opname";
	var $file		=		"opname";
	var $pk     =   "id";
	var $title  =   "Stock Opname";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Transaksi</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/opname'>Stock Opname</a></li>										
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
		$this->load->model('m_produk');		

		//===== Load Library =====t_opname
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($data['set']=='delete' OR $data['set']=='edit' OR $data['set']=='view') $set=$data['set'];
			else $set = "insert";
		$auth = $this->m_admin->user_auth($this->file,$set);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."adm1nb3rrk4h'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	
	public function index($history=null)
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";						
		$where = "";						
		if(is_null($history)){
			$data['mode']		= "view";		
				$data['dt_opname'] = $this->db->query("SELECT * FROM dwigital_stock_opname WHERE status = 1 $where ORDER BY id DESC");	
			}else{
				$data['mode']		= "history";		
				$data['dt_opname'] = $this->db->query("SELECT * FROM dwigital_stock_opname WHERE status <> 1 $where ORDER BY id DESC");	
			}
			if (!$this->session->userdata('loginStok')) {
			$data['show_modal'] = true;
		} else {
			$data['show_modal'] = false;
		}
		$this->template($data);	
	}
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "insert";		
		$data['mode']		= "insert";			
		$this->template($data);	
	}
	public function t_opname(){
		$category_id = $this->input->post('category_id');
		$where = "";
		if($category_id!=""){
			$where .= "AND md_produk.id_produk_kategori = '$category_id'";
		}
		
		$r 	= "SELECT md_produk.*, md_realStock.stock AS realStock FROM md_produk 
			LEFT JOIN md_realStock ON md_produk.id_produk = md_realStock.id_produk 
			WHERE md_produk.status = 1 $where GROUP BY md_produk.id_produk";				
		$data['dt_products'] = $this->db->query($r);
		$this->load->view('transaksi/t_opname',$data);
	}
	public function _create_number($quantity, $user_id)
	{
		$this->load->helper('string');

		$alpha = strtoupper(random_string('alpha', 3));
		$num = random_string('numeric', 3);
		$count_qty = $quantity;


		$number = $alpha . date('j') . date('n') . date('y') . $count_qty . $user_id . $num;
		//Random 3 letter . Date . Month . Year . Quantity . User ID . Coupon Used . Numeric		
		return $number;
	}
	public function simpanOpname()
	{				
	  $waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);	
	  $tgl = date("dm");
	  $id_user = $this->session->id_user;
		$tabel					= "dwigital_stock_opname";						
		$data['tgl_opname']	= $this->input->post('tgl');		
		$data['tgl_akhir']	= $this->input->post('tgl_akhir');		
		$data['keterangan']	= $this->input->post('catatan');						
		$data['id_karyawan']	= $this->input->post('id_karyawan');						
		$data['kode']	= $kode = "OP".$this->_create_number($tgl,$id_user);							
		$data['created_at']	= $waktu;		
		$data['created_by']	= $this->session->id_user;
		$data['status']	= 1;		
		$jum		= $this->input->post('jum');		

		// var_dump($_POST['id']); die();

		foreach ($_POST['id'] as $i => $inp) {			
			$dt['id_produk'] = $id_produk = $inp;// $_POST['id_'.$i];
			$dt['qty_onhand'] = $qty_opname = $_POST['onhand_'.$i];			
			$dt['qty_opname'] = $qty_opname = $_POST['opname_'.$i];			
			$dt['qty_selisih'] = $_POST['selisih_'.$i];			
			$dt['keterangan'] = $_POST['keterangan_'.$i];			
			$dt['kode'] = $kode;
			$dt['created_at']	= $waktu;		
			$dt['created_by']	= $this->session->id_user;
			
			$cek = $this->db->query("SELECT * FROM dwigital_stock_opnameDetail WHERE kode = '$kode' AND id_produk = '$id_produk'");
			if($cek->num_rows() > 0){
				$this->m_admin->update("dwigital_stock_opnameDetail",$dt,"id",$cek->row()->id);				
			}else{
				$this->m_admin->insert("dwigital_stock_opnameDetail",$dt);				
			}			
		}			
		
		$this->m_admin->insert($tabel,$data);		
		$_SESSION['pesan'] 	= "Data berhasil disimpan";
		$_SESSION['tipe'] 	= "success";
		// die();
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/opname'>";
	}

	public function riwayat()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat";		
		$data['mode']		= "riwayat";			
		$where = "";
		$data['id_karyawan'] = $id_karyawan = $this->session->userdata("id_karyawan");
		$data['level'] = $level = $this->session->userdata("level");        
	$where .= ($level=="karyawan") ? " AND md_opname.id_karyawan = '$id_karyawan'" : '';			
		$data['dt_opname'] = $this->db->query("SELECT * FROM md_opname WHERE (status = 'batal' OR status = 'selesai') $where ORDER BY id_opname DESC");	
		$this->template($data);	
	}		
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$data['id'] = $id 		= decrypt_url($this->uri->segment(4));
		$this->m_admin->delete($tabel,"kode",$id);
		$this->m_admin->delete("dwigital_stock_opnameDetail","kode",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/opname'>";
	}
	public function edit()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['set']		= "insert";		
		$data['mode']		= "edit";		
		$data['dt_opname'] = $this->m_admin->getByID($tabel,"kode",$id);		
		$this->template($data);	
	}
	public function detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['set']		= "detail";		
		$data['mode']		= "detail";		
		$data['dt_opname'] = $this->m_admin->getByID($tabel,"kode",$id);		
		$this->template($data);	
	}
	public function approval()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Approval ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['set']		= "detail";		
		$data['mode']		= "approval";		
		$data['dt_opname'] = $this->m_admin->getByID($tabel,"kode",$id);		
		$this->template($data);	
	}

	public function approvalOpname()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;				
		$id_user = $this->session->id_user;							
		$kode = $this->input->post("kode");
		$submit = $this->input->post("submit");
		$row = $this->m_admin->getByID($tabel,"kode",$kode)->row();
		if($submit=="approve"){
			// $data['approval_status'] = 1;
			$data['status'] = 2;	
			$data['approval_by'] = $id_user;
			$data['approval_at'] = $data['updated_at'] 			= $waktu;				
			$this->m_admin->update($tabel,$data,"kode",$kode);								
			
			$sql = $this->m_admin->getByID("dwigital_stock_opnameDetail","kode",$kode);		  
		  foreach ($sql->result() as $isi) {	  	
			  $ty = $this->db->query("SELECT * FROM md_produk WHERE id_produk='$isi->id_produk'")->row();						
				$d['stock'] = $isi->qty_opname;				
				$d['updated_at'] = $waktu;
				$d['updated_by'] = $id_user;
				$this->m_admin->update("md_produk",$d,"id_produk",$isi->id_produk);			

				$keterangan = "Stock Opname dg No: ".$kode;				
				$this->m_admin->updateStock($isi->id_produk,$isi->qty_opname,$isi->qty_opname,"-",$kode,"opname",tgl(),$keterangan);
				
		  }

		  // die();

			$_SESSION['pesan'] 		= "Data berhasil di-approve";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/opname'>";											
		}else{
			$data['approval_status'] = 1;
			$data['status'] = "rejected";								
			$data['approval_by'] = $this->session->id_user;
			$data['approval_at'] = $data['updated_at'] 			= $waktu;				
			$this->m_admin->update($tabel,$data,"kode",$kode);								
			$_SESSION['pesan'] 		= "Data berhasil di-reject";
			$_SESSION['tipe'] 		= "danger";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/opname'>";									
		}
	}		
}
