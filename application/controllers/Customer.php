<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

  var $tables =   "ind_user";		
  var $file		=		"dashboard";
  var $page		=		"dashboard";
  var $pk     =   "user_id";
  var $title  =   "Home";
  var $bread	=   "<a href='' class='current'>Home</a>";				          

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
		if($name=="")
		{			
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."login'>";
		}else{								
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/navigation');			
			$this->load->view("frontend/$data[page]");		
			$this->load->view('frontend/footer');
		}
	}
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "customer";						
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$id_user = $this->session->id_user;
		$data['dt_user'] = $this->m_admin->getByID("md_user","id_user",$id_user)->row();
		$data['page'] = "customer";
		$this->template($data);
		
	}
	public function logout()
	{		
		session_destroy();
		session_unset();	
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "home'>";
	}
	public function konfirmasiPembayaran($id){
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat-transaksi";				
		$data['order']= $this->m_admin->getByID("orders","id",decrypt_url($id))->row();
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$data['page'] = "konfirmasiPembayaran";
		$this->template($data);		
	}
	public function konfirmasiPost(){

		$data['pengirim'] = $this->input->post("pengirim",TRUE);
		$data['nominal'] = $this->input->post("nominal",TRUE);
		$data['order_id'] = $id = $this->input->post("order_id",TRUE);		
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
		$this->m_admin->update("orders",$data2,"id",$id);

		if($err==""){		  
			$this->m_admin->insert("order_payment",$data);		
			$_SESSION['pesan'] 	= "Pembayaran Berhasil Dikirim, admisi kami akan segera menghubungi anda. Terima Kasih.";
			$_SESSION['tipe'] 	= "success";			
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."riwayat-transaksi'>";							
		}else{
			$_SESSION['pesan'] 	= $err."<br>Gagal simpan, mohon coba beberapa saat lagi atau hubungi admisi kami via WA.";
			$_SESSION['tipe'] 	= "danger";			
			echo "<script>history.go(-1)</script>";							
		}
		
	}
	public function riwayatTransaksi()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat-transaksi";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$data['page'] = "riwayatTransaksi";
		$this->template($data);				
	}
	public function keranjangPesan()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "riwayat-transaksi";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$data['page'] = "keranjangPesan";
		$this->template($data);				
		
	}	
	public function saveProduk($id)
	{								
		$id_produk = decrypt_url($id);
		$rt = $this->m_admin->getByID("products","id",$id_produk);		
		$harga = ($rt->num_rows()>0)?$rt->row()->price:'';		
				
		$data['order_price'] 			= $harga;		
		$data['product_id'] 			= $id_produk;
		$data['order_qty'] 			= $qty = 1;						
		$data['updated_at'] 			= waktu();		
		$data['updated_by'] 			= $id_user = $this->session->id_user;		
		$data['status'] 		= 0;		
		$where = " AND updated_by = '$id_user' AND status = 0";
		
		$cekProduk = $this->db->query("SELECT id FROM order_items WHERE product_id ='$id_produk' $where");
		if($cekProduk->num_rows()>0){
			$this->m_admin->update("order_items",$data,"id",$cekProduk->row()->id);					
		}else{
			$this->m_admin->insert("order_items",$data);					
		}
		$_SESSION['pesan'] 		= "Layanan berhasil ditambahkan";
		$_SESSION['tipe'] 		= "success";												
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang-pesan'>";							
						
	}
	public function editProduk()
	{						
		$id 										= decrypt_url($this->input->post("id"));						
		$data['order_qty'] 			= $qty = $this->input->post("order_qty");		
		$data['updated_at'] 		= waktu();		
		$data['updated_by'] 		= $this->session->id_user;		
		$this->m_admin->update("order_items",$data,"id",$id);					
		$_SESSION['pesan'] 		= "Pesanan berhasil diubah";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang-pesan'>";		
						
	}
	public function hapusProduk($id)
	{				
		$id 				= decrypt_url($id);				
		$this->m_admin->delete("order_items","id",$id);
		$_SESSION['pesan'] 	= "Layanan berhasil dihapus";
		$_SESSION['tipe'] 	= "success";		
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang-pesan'>";		
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
		$data['updated_at'] = $data['order_date'] 			= waktu();
		$data['tgl_mulai'] 	=	$tgl_mulai	= $this->input->post("tgl_mulai");		
		$data['tgl_selesai'] 	= $tgl_selesai		= $this->input->post("tgl_selesai");		
		$cekTgl = $this->db->query("SELECT * FROM orders WHERE order_status <> 4 AND '$tgl_mulai' BETWEEN tgl_mulai AND tgl_selesai");
		// echo $cekTgl->num_rows();die();
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
		$data['total_price'] 			= $this->input->post("total");		
		$data['total_items'] 			= $t_item = $this->input->post("total_items");		
		$data['diskon'] 			= $this->input->post("diskon");		
		$data['catatan'] 			= $this->input->post("catatan");				
		$data['order_number'] 			= $order_number =  $this->_create_order_number($t_item,$id_user,"");		
		$data['sumber'] 			= "web";
		$data['order_status'] 			= 1;
		$data['payment_status'] 			= 0;
		$data['payment_method'] 			= $this->input->post("payment_method");				
		$data['user_id'] = $this->session->id_konsumen;
		$data['updated_by'] 			= $id_user;
		$this->m_admin->insert("orders",$data);	
		$order_id = $this->db->insert_id();
		$this->db->query("UPDATE order_items SET order_id = '$order_id', status = 1 WHERE status = 0 AND updated_by = '$id_user'");				
		$_SESSION['pesan'] 		= "Pesanan berhasil dibuat. Silakan melakukan pembayaran atau bisa hubnugi tim Admisi kami. Terima Kasih";
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."riwayat-transaksi'>";					

						
	}
}
