<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RefProduk extends CI_Controller
{


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
    $this->load->model('M_dwigital_produk', 'produk');
    //===== Load Library =====
    $this->load->library('upload');
    
  }

  function selectReady()
  {
    $term = $this->input->get('term');
    
    if ($term) {
      $filter['nama_produk'] = $term;
    }
    $list_produk = $this->produk->getProduk($filter)->result();
    $result = [];
    
    foreach ($list_produk as $key => $produk) {
      $bisa_beli = true;
      $cekStok = cekStokDwigital($produk->id_produk);
      
      $result[] = [
        'id' => encrypt_url($produk->id_produk . ':produk'),
        'text' => "$produk->kode_produk // $produk->nama_produk @$produk->sat_kecil // Rp. " . mata_uang_help($produk->harga) . '<br>Sisa : ' . $cekStok,
        'bisa_beli' => $bisa_beli,
      ];
    }
    send_json(['items' => $result]);
  }
}
