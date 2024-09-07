<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	var $tables =   "md_invoice";		
	var $page		=		"transaksi/invoice";
	var $file		=		"invoice";
	var $pk     =   "id";
	var $title  =   "Invoice";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Transaksi</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/invoice'>Invoice</a></li>										
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
		$data['dt_invoice'] = $this->db->query("SELECT * FROM md_invoice WHERE status < 3 ORDER BY id DESC");	
		$this->template($data);	
	}
	public function riwayat()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat";		
		$data['mode']		= "riwayat";			
		$data['dt_invoice'] = $this->db->query("SELECT * FROM md_invoice WHERE status >= 3 ORDER BY id DESC");	
		$this->template($data);	
	}		
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$data['id'] = $id 		= decrypt_url($this->uri->segment(4));
		$this->m_admin->delete($tabel,"kode",$id);
		$this->m_admin->delete("md_invoice_detail","kode",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";
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
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_invoice'] = $this->m_admin->getByID($tabel,"kode",$id);		
		$this->template($data);	
	}
	public function customerReceipt()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Customer Receipt";	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;		
		$data['set']		= "insert";		
		$data['mode']		= "customerReceipt";		
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_invoice'] = $this->m_admin->getByID($tabel,"kode",$id);		
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
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_invoice'] = $this->m_admin->getByID($tabel,"kode",$id);		
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
		$data['kode'] = $id 		= decrypt_url($this->uri->segment(4));
		$data['dt_invoice'] = $this->m_admin->getByID($tabel,"kode",$id);		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";											
	}

	public function approvalInvoice()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;				
		$kode = $this->input->post("kode");
		$submit = $this->input->post("submit");
		$row = $this->m_admin->getByID($tabel,"kode",$kode)->row();
		if($submit=="update"){
			$data['status'] = 2;
						
			$data['approval_status'] = 1;
			$data['approval_at'] = $waktu;
			$data['updated_at'] = $waktu;
			$data['updated_by'] = $this->session->id_user;			
			$this->m_admin->update($tabel,$data,"kode",$kode);								
			
			$_SESSION['pesan'] 		= "Data berhasil di-ubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";											
		}
	}	
	public function ajax_resepK()
	{		
		$list = $this->m_product->get_datatables();
		$data = array();
		$no = $_POST['start'];		
		foreach ($list as $isi) {						
			$noReg = $_POST['noReg'];						

			$cekKategori = $this->m_admin->getByID("product_category","id",$isi->id_kategori);
			$kategori = ($cekKategori->num_rows()>0)?$cekKategori->row()->name:"";

			$no++;
			$row = array();
			$row[] = $no;						
			$row[] = $isi->sku;
			$row[] = $isi->name;			
			$row[] = $kategori;
			$row[] = $isi->price;			
			$row[] = "<a href=\"transaksi/invoice/saveProduk/$isi->id/$noReg\" class='btn btn-sm btn-danger'>Pilih</a>";													
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
		$item = ($rt->num_rows()>0)?$rt->row()->name:'';		
				
		$data['item'] 			= $item;		
		$data['product_id'] 			= $id_produk;
		$data['qty'] 			= $qty = 1;						
		$data['nominal'] 			= $harga;
		$data['total'] 			= $harga * $qty;
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $id_user = $this->session->id_user;		
		$data['status'] 		= 0;
		if($noReg!='add'){ 
			$kode = decrypt_url($noReg);
			$order = $this->m_admin->getByID("md_invoice","kode",$kode)->row()->kode;
			$data['kode'] = $order;
			$where = " AND kode = '$order'";
		}else{
			$where = " AND updated_by = '$id_user' AND status = 0";
		}
		$cekProduk = $this->db->query("SELECT id FROM md_invoice_detail WHERE product_id ='$id_produk' $where");
		if($cekProduk->num_rows()>0){
			$this->m_admin->update("md_invoice_detail",$data,"id",$cekProduk->row()->id);					
		}else{
			$this->m_admin->insert("md_invoice_detail",$data);					
		}
		$_SESSION['pesan'] 		= "Data berhasil disimpan";
		$_SESSION['tipe'] 		= "success";								
		if($noReg!='add'){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/edit/".$noReg."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/add'>";					
		}
						
	}
	public function _create_kode($quantity, $user_id, $coupon_id)
	{
		$this->load->helper('string');

		$alpha = strtoupper(random_string('alpha', 3));
		$num = random_string('numeric', 3);
		$count_qty = $quantity;


		$number = $alpha . date('j') . date('n') . date('y') . $count_qty . $user_id . $coupon_id . $num;
		//Random 3 letter . Date . Month . Year . Quantity . User ID . Coupon Used . Numeric		
		return $number;
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
	public function cariKodeCr(){
		$tgl = date("Y-m");
		$q = $this->db->query("SELECT MAX(RIGHT(kode_cr,6)) AS kd_max FROM md_invoice WHERE LEFT(updated_at,7) = '$tgl' ORDER BY id DESC LIMIT 0,1");		
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
	public function simpanInvoice()
	{		
		$jam = jam();
		$id_user = $this->session->id_user;				
		$data['tgl_invoice'] 			= $this->input->post("tgl_invoice")." ".$jam;				
		$total = $this->input->post("total");		
		$data['diskon'] 			= $diskon = $this->input->post("diskon");		
		if($diskon!='' && $diskon>0){
			$gtotal = $total - $diskon;
		}else{
			$gtotal = $total;
		}
		$data['total'] 			= $gtotal;
		$data['ppn'] 			= $this->input->post("ppn");		
		$data['periode'] 			= $this->input->post("periode");		
		$data['keterangan'] 			= $this->input->post("keterangan");				
		$data['id_karyawan'] 		= $this->input->post("id_karyawan");		
		$data['id_brand'] 		= $this->input->post("id_brand");		
		$data['id_client'] 	= $this->input->post("id_client");		
		$data['lama'] 	= $this->input->post("lama");		
						
		$data['kode'] 			= $kode =  $this->_create_kode(10,$id_user,"");				
		$data['status'] 			= 1;
		$data['created_at'] 			= waktu();				
		$data['created_by'] 			= $id_user = $this->session->id_user;
		$this->m_admin->insert("md_invoice",$data);	
		
		$this->db->query("UPDATE md_invoice_detail SET kode = '$kode', status = 1 WHERE status = 0 AND updated_by = '$id_user'");						

		$_SESSION['pesan'] 		= "Invoice berhasil dibuat";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";					

						
	}

	public function uploadBukti($kode){
		$get = $this->m_admin->getByID("md_invoice","kode",$kode)->row();		

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

		$data2['no_ref'] = $this->input->post("no_ref");
		$data2['payment_status'] = 1;
		$data2['updated_at'] = waktu();
		$data2['updated_by'] = $this->session->id_user;
		$this->m_admin->update("invoice",$data2,"kode",$kode);
		// echo $err; die();
		if($err==""){		  
			$this->m_admin->insert("order_payment",$data);		
		}else{
			return false;
		}
	}
	public function updateInvoice()
	{		
		$jam = jam();
		$id_user = $this->session->id_user;		
		$kode 			= $this->input->post("kode");				
		$data['tgl_invoice'] 			= $this->input->post("tgl_invoice")." ".$jam;				
		$total = $this->input->post("total");		
		$data['diskon'] 			= $diskon = $this->input->post("diskon");		
		if($diskon!='' && $diskon>0){
			$gtotal = $total - $diskon;
		}else{
			$gtotal = $total;
		}
		$data['total'] 			= $gtotal;
		$data['periode'] 			= $this->input->post("periode");		
		$data['keterangan'] 			= $this->input->post("keterangan");				
		$data['id_karyawan'] 		= $this->input->post("id_karyawan");		
		$data['id_brand'] 		= $this->input->post("id_brand");		
		$data['id_client'] 	= $this->input->post("id_client");				
		$data['lama'] 	= $this->input->post("lama");
		$data['ppn'] 			= $this->input->post("ppn");		
		$data['updated_at'] 			= waktu();				
		$data['updated_by'] 			= $id_user = $this->session->id_user;
		$this->m_admin->update("md_invoice",$data,"kode",$kode);	
		$this->db->query("UPDATE md_invoice_detail SET status = 1 WHERE status = 0 AND updated_by = '$id_user'");				
		$_SESSION['pesan'] 		= "Transaksi berhasil disimpan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";					
						
	}
	public function batal()
	{
		$id_user = $this->session->id_user;
		$this->db->query("DELETE FROM order_items WHERE updated_by = '$id_user' AND status = 0");
		$_SESSION['pesan'] 		= "Transaksi berhasil dibatalkan";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice'>";					
	}
	public function editProduk()
	{				
		
		$kode 			= $this->input->post("kode");				
		$id 			= decrypt_url($this->input->post("id"));				
		//$data['harga'] 			= $harga = $this->input->post("harga");
		$data['diskon'] 			= $diskon = $this->input->post("diskon");
		$data['qty'] 			= $qty = $this->input->post("qty");
		
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $this->session->id_user;		
		$this->m_admin->update("md_invoice_detail",$data,"id",$id);					
		$_SESSION['pesan'] 		= "Data berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		if(!is_null($kode) && $kode!=''){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/edit/".encrypt_url($kode)."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/add'>";					
		}
						
	}
	public function hapusProduk($id,$kode=null)
	{				
		$id 				= decrypt_url($id);				
		$this->m_admin->delete("md_invoice_detail","id",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		if(!is_null($kode) && $kode!=''){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/edit/".encrypt_url($kode)."'>";					
		}else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/add'>";
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
	public function cetak($kode)
	{						    
    if (ob_get_contents()) ob_clean();    
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 900);
		$mpdf = new \Mpdf\Mpdf();	
    $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
    $mpdf->charset_in               = 'UTF-8';
    $mpdf->autoLangToFont           = true;      
    $data['set']                   	= 'download';                      
    $data['kode']           = $kode;    
    $html = $this->load->view('transaksi/cetak_invoice', $data, true);    
    $mpdf->WriteHTML($html);    
    $mpdf->Output();    
    // $this->load->view('transaksi/cetak_invoice', $data);    
		
	}
	public function cetakCr($kode)
	{						    
    if (ob_get_contents()) ob_clean();    
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 900);
		$mpdf = new \Mpdf\Mpdf();	
    $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
    $mpdf->charset_in               = 'UTF-8';
    $mpdf->autoLangToFont           = true;      
    $data['set']                   	= 'download';                      
    $data['kode']           = $kode;    
    $html = $this->load->view('transaksi/cetak_cr', $data, true);    
    $mpdf->WriteHTML($html);    
    $mpdf->Output();    
    // $this->load->view('transaksi/cetak_invoice', $data);    
		
	}
	public function updatePembayaran()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;		
		$pk				= $this->pk;				

		$kode = $this->input->post("kode");
		$submit = $this->input->post("submit");
		
		$row = $this->m_admin->getByID("md_invoice","kode",$kode)->row();
		$data['kode_cr'] = $this->cariKodeCr();
		$data['paid_at'] = $data['updated_at'] 			= $waktu;				
		$data['payment_method'] = $this->input->post("payment_method");
		$data['payment_status'] = $this->input->post("payment_status");
		$data['status'] 			= 3;							

		$config = $this->m_admin->set_upload_options('./assets/uploads/payments/','jpg|png|jpeg|pdf','5000');		
		$err = "";
    if(!empty($_FILES['bukti']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bukti')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['bukti']	= $this->upload->file_name;
			}
		}
		
		if($err!=''){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";											
			echo "<script>history.go(-1)</script>";
			exit();
		}
		$this->m_admin->update("md_invoice",$data,"kode",$kode);
		
		$data2['sumber'] = "invoice";
		$data2['no_reference'] = $kode;
		$data2['tgl'] = tgl();
		$data2['kode_pemasukan'] = $this->cari_kode();
		$data2['id_kategori'] = 1;
		$data2['total'] = $row->total;
		$data2['uraian'] = "Pembayaran Invoice";		
		$data2['created_by'] = $this->session->id_user;
		$data2['created_at'] = waktu();

		$cek = $this->m_admin->getByID("md_pemasukan","no_reference",$kode);
		if($cek->num_rows()==0){
			$this->m_admin->insert("md_pemasukan",$data2);
		}		

		$enr = encrypt_url($kode);

		$_SESSION['pesan'] 		= "Status invoice berhasil diubah";
		$_SESSION['tipe'] 		= "success";											
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/invoice/cetakCr/".$enr."'>";												
	}	
}
