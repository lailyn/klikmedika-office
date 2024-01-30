<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyewaan extends CI_Controller {

	var $tables =   "orders";		
	var $page		=		"transaksi/penyewaan";
	var $file		=		"penyewaan";
	var $pk     =   "id";
	var $title  =   "Penyewaan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Transaksi</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/penyewaan'>Penyewaan</a></li>										
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
		$this->load->model('m_product');		

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
	// 1=>Menunggu Pembayaran, 2=>Proses, 3=>Dalam Pengiriman, 4=>Order Selesai, 5=>Batal
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$data['dt_orders'] = $this->db->query("SELECT * FROM orders WHERE order_status < '4' ORDER BY id DESC");	
		$this->template($data);	
	}
	public function riwayat()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat";		
		$data['mode']		= "riwayat";			
		$data['dt_orders'] = $this->db->query("SELECT * FROM orders WHERE order_status >= '4' ORDER BY id DESC");	
		$this->template($data);	
	}		
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$data['id'] = $id 		= decrypt_url($this->uri->segment(4));
		$this->m_admin->delete($tabel,"id",$id);
		$this->m_admin->delete("order_items","order_id",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";
	}
	public function edit()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;		
		$data['set']		= "insert";		
		$data['mode']		= "edit";		
		$data['order_number'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_orders'] = $this->m_admin->getByID($tabel,"order_number",$id);		
		$this->template($data);	
	}
	public function detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;		
		$data['set']		= "insert";		
		$data['mode']		= "detail";		
		$data['order_number'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_orders'] = $this->m_admin->getByID($tabel,"order_number",$id);		
		$this->template($data);	
	}
	public function approval()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Proses ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;		
		$data['set']		= "insert";		
		$data['mode']		= "approval";		
		$data['order_number'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_orders'] = $this->m_admin->getByID($tabel,"order_number",$id);		
		$this->template($data);	
	}
	public function pembayaranDiterima($order_id){
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;				
		$data['payment_status'] = 2;
		$data['confirmed_date'] = $waktu;
		$this->m_admin->update("payments",$data,"order_id",$order_id);
		$_SESSION['pesan'] 		= "Pembayaran Diterima";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";											
	}

	public function approvalPenyewaan()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;				
		$order_number = $this->input->post("order_number");
		$submit = $this->input->post("submit");
		$row = $this->m_admin->getByID($tabel,"order_number",$order_number)->row();
		if($submit=="update"){
			$data['order_status'] = $order_status = $this->input->post("order_status");
			$data['payment_status'] = $this->input->post("payment_status");
			
			if($order_status==4) $data['finish_date'] = $waktu;			
			$data['updated_at'] = $waktu;
			$data['updated_by'] = $this->session->id_user;			
			$this->m_admin->update($tabel,$data,"order_number",$order_number);								

			$this->uploadBukti($order_number);
			$_SESSION['pesan'] 		= "Data berhasil di-ubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";											
		}
	}	
	public function ajax_resepK()
	{		
		$list = $this->m_product->get_datatables();
		$data = array();
		$no = $_POST['start'];		
		foreach ($list as $isi) {						
			$noReg = $_POST['noReg'];						

			$cekKategori = $this->m_admin->getByID("md_kategori","id_kategori",$isi->id_kategori);
			$kategori = ($cekKategori->num_rows()>0)?$cekKategori->row()->kategori:"";

			$no++;
			$row = array();
			$row[] = $no;						
			$row[] = $isi->sku;
			$row[] = $isi->name;			
			$row[] = $kategori;
			$row[] = $isi->price;			
			$row[] = "<a href=\"transaksi/penyewaan/saveProduk/$isi->id/$noReg\" class='btn btn-sm btn-danger'>Pilih</a>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_product->count_all(),
						"recordsFiltered" => $this->m_product->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function saveProduk($id_produk,$noReg=null)
	{								
		$rt = $this->m_admin->getByID("products","id",$id_produk);		
		$harga = ($rt->num_rows()>0)?$rt->row()->price:'';		
				
		$data['order_price'] 			= $harga;		
		$data['product_id'] 			= $id_produk;
		$data['order_qty'] 			= $qty = 1;						
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $id_user = $this->session->id_user;		
		$data['status'] 		= 0;
		if($noReg!='add'){ 
			$order_number = decrypt_url($noReg);
			$order = $this->m_admin->getByID("orders","order_number",$order_number)->row()->id;
			$data['order_id'] = $order;
			$where = " AND order_id = '$order'";
		}else{
			$where = " AND updated_by = '$id_user' AND status = 0";
		}
		$cekProduk = $this->db->query("SELECT id FROM order_items WHERE product_id ='$id_produk' $where");
		if($cekProduk->num_rows()>0){
			$this->m_admin->update("order_items",$data,"id",$cekProduk->row()->id);					
		}else{
			$this->m_admin->insert("order_items",$data);					
		}
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";								
		if($noReg!='add'){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/edit/".$noReg."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/add'>";					
		}
						
	}
	public function _create_order_number($quantity, $user_id, $coupon_id)
	{
		$this->load->helper('string');

		$alpha = strtoupper(random_string('alpha', 3));
		$num = random_string('numeric', 3);
		$count_qty = $quantity;


		$number = $alpha . date('j') . date('n') . date('y') . $count_qty . $user_id . $coupon_id . $num;
		//Random 3 letter . Date . Month . Year . Quantity . User ID . Coupon Used . Numeric		
		return $number;
	}
	public function simpanPenyewaan()
	{		
		$jam = jam();
		$id_user = $this->session->id_user;				
		$data['order_date'] 			= $this->input->post("order_date")." ".$jam;				
		$data['total_price'] 			= $this->input->post("total");		
		$data['tgl_acara'] 			= $this->input->post("tgl_acara");		
		$data['total_items'] 			= $t_item = $this->input->post("total_items");		
		$data['diskon'] 			= $this->input->post("diskon");		
		$data['catatan'] 			= $this->input->post("delivery_data");		
		$data['tgl_mulai'] 		= $tgl_mulai	= $this->input->post("tgl_mulai");		
		$data['tgl_selesai'] 	= $tgl_selesai = $this->input->post("tgl_selesai");		

		$cekTgl = $this->db->query("SELECT * FROM orders WHERE order_status <> 4 AND '$tgl_mulai' BETWEEN tgl_mulai AND tgl_selesai");		
		if($cekTgl->num_rows()>0){
			$_SESSION['pesan'] 		= "Tanggal tersebut sudah ada yang booking, silakan cari tanggal lain.";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
			exit();
		}
		if($tgl_selesai<$tgl_mulai){
			$_SESSION['pesan'] 		= "Tanggal Mulai tidak boleh lebih lama dari Tanggal Selesai!";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
			exit();	
		}

		$data['user_id'] 			= $this->input->post("user_id");		
		$data['id_karyawan'] 			= $this->input->post("id_karyawan");		
		$data['order_number'] 			= $order_number =  $this->_create_order_number($t_item,$id_user,"");		
		$data['sumber'] 			= "kasir";
		$data['order_status'] 			= $this->input->post("order_status");		
		$data['payment_status'] 			= $this->input->post("payment_status");		
		$data['payment_method'] 			= $this->input->post("payment_method");		
		$data['updated_at'] 			= waktu();				
		$data['updated_by'] 			= $id_user = $this->session->id_user;
		$this->m_admin->insert("orders",$data);	
		$order_id = $this->db->insert_id();
		$this->db->query("UPDATE order_items SET order_id = '$order_id', status = 1 WHERE status = 0 AND updated_by = '$id_user'");				

		$this->uploadBukti($order_number);

		$_SESSION['pesan'] 		= "Transaksi berhasil dibuat";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";					

						
	}

	public function uploadBukti($order_number){
		$get = $this->m_admin->getByID("orders","order_number",$order_number)->row();
		$order_id = $get->id;
		$user_id = $get->user_id;
		$data['pengirim'] = $this->m_admin->getByID("md_konsumen","id_konsumen",$user_id)->row()->nama_lengkap;
		$data['nominal'] = $this->input->post("total",TRUE);
		$data['order_id'] = $order_id;
		$data['created_at'] = waktu();
		$data['created_by'] = $this->session->id_user;

		$config = $this->m_admin->set_upload_options('./assets/uploads/payments/','jpg|png|jpeg','5000');		
		$err = "";
    if(!empty($_FILES['bukti']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bukti')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['bukti']	= $this->upload->file_name;
			}
		}

		$data2['payment_status'] = 1;
		$data2['updated_at'] = waktu();
		$data2['updated_by'] = $this->session->id_user;
		$this->m_admin->update("orders",$data2,"order_number",$order_number);
		// echo $err; die();
		if($err==""){		  
			$this->m_admin->insert("order_payment",$data);		
		}else{
			return false;
		}
	}
	public function updatePenyewaan()
	{		
		$jam = jam();
		$id_user = $this->session->id_user;		
		$order_number 			= $this->input->post("order_number");				
		$data['order_date'] 			= $this->input->post("order_date")." ".$jam;				
		$data['tgl_acara'] 			= $this->input->post("tgl_acara");		
		$data['total_price'] 			= $this->input->post("total");		
		$data['total_items'] 			= $t_item = $this->input->post("total_items");		

		$data['tgl_mulai'] 		= $tgl_mulai	= $this->input->post("tgl_mulai");		
		$data['tgl_selesai'] 	= $tgl_selesai = $this->input->post("tgl_selesai");		

		$cekTgl = $this->db->query("SELECT * FROM orders WHERE order_status <> 4 AND '$tgl_mulai' BETWEEN tgl_mulai AND tgl_selesai");		
		if($cekTgl->num_rows()>0){
			$_SESSION['pesan'] 		= "Tanggal tersebut sudah ada yang booking, silakan cari tanggal lain.";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
			exit();
		}
		if($tgl_selesai<$tgl_mulai){
			$_SESSION['pesan'] 		= "Tanggal Mulai tidak boleh lebih lama dari Tanggal Selesai!";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
			exit();	
		}
		$this->uploadBukti($order_number);
		$data['diskon'] 			= $this->input->post("diskon");		
		$data['catatan'] 			= $this->input->post("delivery_data");		
		$data['user_id'] 			= $this->input->post("user_id");		
		$data['id_karyawan'] 			= $this->input->post("id_karyawan");		
		$data['sumber'] 			= "kasir";
		$data['payment_status'] 			= $this->input->post("payment_status");		
		$data['order_status'] 			= $order_status = $this->input->post("order_status");		
		$data['payment_method'] 			= $this->input->post("payment_method");		
		$data['updated_at'] 			= waktu();				
		$data['updated_by'] 			= $id_user = $this->session->id_user;
		$this->m_admin->update("orders",$data,"order_number",$order_number);	
		$this->db->query("UPDATE order_items SET status = 1 WHERE status = 0 AND updated_by = '$id_user'");				
		$_SESSION['pesan'] 		= "Transaksi berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";					
						
	}
	public function batal()
	{
		$id_user = $this->session->id_user;
		$this->db->query("DELETE FROM order_items WHERE updated_by = '$id_user' AND status = 0");
		$_SESSION['pesan'] 		= "Transaksi berhasil dibatalkan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan'>";					
	}
	public function editProduk()
	{				
		
		$order_number 			= $this->input->post("order_number");				
		$id 			= decrypt_url($this->input->post("id"));				
		//$data['harga'] 			= $harga = $this->input->post("harga");
		$data['diskon'] 			= $diskon = $this->input->post("diskon");
		$data['order_qty'] 			= $qty = $this->input->post("order_qty");
		
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $this->session->id_user;		
		$this->m_admin->update("order_items",$data,"id",$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		if(!is_null($order_number) && $order_number!=''){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/edit/".encrypt_url($order_number)."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/add'>";					
		}
						
	}
	public function hapusProduk($id,$order_number=null)
	{				
		$id 				= decrypt_url($id);				
		$this->m_admin->delete("order_items","id",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		if(!is_null($order_number) && $order_number!=''){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/edit/".encrypt_url($order_number)."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/add'>";
		}
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
	public function cetak($order_number)
	{						    
    if (ob_get_contents()) ob_clean();    
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 900);
		$mpdf = new \Mpdf\Mpdf();	
    $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
    $mpdf->charset_in               = 'UTF-8';
    $mpdf->autoLangToFont           = true;      
    $data['set']                   	= 'download';                      
    $data['order_number']           = $order_number;    
    $html = $this->load->view('transaksi/cetak_invoice', $data, true);    
    $mpdf->WriteHTML($html);    
    $mpdf->Output();    
    // $this->load->view('transaksi/cetak_invoice', $data);    
		
	}
	public function save_status()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;		
		$pk				= $this->pk;				

		$id = $this->input->post("id_penyewaan");
		$submit = $this->input->post("submit");
		$id_penyewaan = encrypt_url($id);				
		$row = $this->m_admin->getByID("md_penyewaan","id_penyewaan",$id)->row();
		$data['updated_at'] 			= $waktu;				
		if($submit=='dikirim'){			
			$data['status'] 			= "dikirim";										
		}elseif($submit=='selesai'){			
			//$data['status'] 			= "selesai";							

			$data2['tgl_pemasukan'] = waktu();
			$data2['sumber'] = "penyewaan";
			$data2['no_transaksi'] = $row->order_number;
			$data2['tgl_transaksi'] = $row->order_date;
			$data2['id_merchant'] = 0;
			$data2['merchant'] = 0;
			$data2['nominal'] = 0;
			$data2['total'] = 0;
			$data2['user_id'] = 0;
			$data2['status'] = 1;
			$data2['created_by'] = $this->session->id_user;
			$data2['created_at'] = waktu();

			//$this->m_admin->insert("md_pemasukan",$data2);

		}elseif($submit=='batal'){			
			$data['status'] 			= "batal";							
		}
		$this->m_admin->update($tabel,$data,$pk,$id);					

		$_SESSION['pesan'] 		= "Status penyewaan berhasil diubah";
		$_SESSION['tipe'] 		= "success";											
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/penyewaan/status/".$id_penyewaan."'>";												
	}	
}
