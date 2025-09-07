<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	var $tables =   "md_konsumen";		
	var $file		=		"monitoringdwigital";
	var $page		=		"dwigital/transaksi/monitoring";
	var $pk     =   "id_konsumen";
	var $title  =   "Monitoring";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Monitoring</a></li>										
	<li class='breadcrumb-item active'><a href='dwigital/transaksi/monitoring'>Monitoring</a></li>										
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
		$this->load->model('m_konsumen');		

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
		$data['title']  = $this->title;  
		$data['bread']  = $this->bread;                                                                                                                    
		$data['set']    = "view";        
		$data['mode']   = "view";        

		// filter tahun
		$filter_1 = $this->input->post("filter_1");
		$tahun = date('Y');
		$data['filter_1'] = $tahun;
		if (isset($filter_1) && !empty($filter_1)) {
			$data['filter_1'] = $filter_1;
		}

		$sql = "
			SELECT 
				c.id_cart,
				c.catatan,
				c.phone,
				-- ambil daftar produk dari detail, fallback ke master produk
				(
					SELECT GROUP_CONCAT(
						DISTINCT COALESCE(
							NULLIF(TRIM(d.nama_produk), ''), 
							p.nama_produk
						)
						ORDER BY COALESCE(
							NULLIF(TRIM(d.nama_produk), ''), 
							p.nama_produk
						) SEPARATOR ', '
					)
					FROM dwigital_cart_detail d
					LEFT JOIN dwigital_produk p ON p.id_produk = d.id_produk
					WHERE d.no_faktur = c.no_faktur
				) AS nama_produk,
				c.tgl AS tanggal_faktur,
				CASE 
					WHEN c.durasi_langganan = '1 bulan'  THEN DATE_ADD(c.tgl, INTERVAL 1 MONTH)
					WHEN c.durasi_langganan = '3 bulan'  THEN DATE_ADD(c.tgl, INTERVAL 3 MONTH)
					WHEN c.durasi_langganan = '6 bulan'  THEN DATE_ADD(c.tgl, INTERVAL 6 MONTH)
					WHEN c.durasi_langganan = '12 bulan' THEN DATE_ADD(c.tgl, INTERVAL 12 MONTH)
					ELSE DATE_ADD(c.tgl, INTERVAL 1 MONTH)
				END AS tanggal_kadaluarsa,
				c.nama_pemesan
			FROM dwigital_cart c
			LEFT JOIN dwigital_platform p2 ON p2.id = c.id_platform
			WHERE YEAR(c.tgl) = '".$data['filter_1']."'
			AND p2.nama = 'Non Platform'
			ORDER BY c.id_cart DESC
		";

		$data['list_data'] = $this->db->query($sql)->result();

		$this->template($data);   
	}


}
