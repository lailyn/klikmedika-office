<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function getPenjualan($filter)
  {
    $customer = "'Walk in Customer'";
    

    if ($this->input->post('search')['value'] != '') {
      $this->db->group_start();
      $this->db->like('cart.no_faktur', $this->input->post('search')['value']);
      $this->db->or_like('cart.tgl', $this->input->post('search')['value']);
      $this->db->or_like('cart.total', $this->input->post('search')['value']);      
      $this->db->group_end();
    }

    if (isset($filter['order'])) {
      $list_order_column = [null, 'cart.no_faktur', 'cart.tgl', $customer, 'cart.total', null];
      $this->db->order_by($list_order_column[$filter['order'][0]['column']], $filter['order'][0]['dir']);
    } else {
      $this->db->order_by('cart.id_cart', 'desc');
    }

    if (isset($filter['limit'])) {
      $this->db->limit($filter['limit'][1], $filter['limit'][0]);
    }

    $this->db->select("cart.*,($customer) as customer,platform.nama platform");
    $this->db->join("dwigital_platform platform", "platform.id = cart.id_platform", "left");  
    return $this->db->get("dwigital_cart cart");
  }

  function getDetail($filter, $need_return = '')
  {
    if (isset($filter['updated_by'])) {
      $this->db->where('cart_detail.updated_by', $filter['updated_by']);
    }

    if (isset($filter['no_faktur'])) {
      $this->db->where('cart_detail.no_faktur', $filter['no_faktur']);
    }

    if (isset($filter['id_produk'])) {
      $this->db->where('cart_detail.id_produk', $filter['id_produk']);
    }

    if (isset($filter['status'])) {
      $this->db->where('cart_detail.status', $filter['status']);
    }

    $this->db->select("cart_detail.*");
    $result =  $this->db->get("dwigital_cart_detail cart_detail");
    if ($need_return == '') {
      $return = [];
      foreach ($result->result() as $item) {
        $return[] = [
          'id' => encrypt_url($item->id),
          'id_produk' => encrypt_url($item->id_produk),
          'kode_produk' => $item->kode_produk,
          'nama_produk' => $item->nama_produk,
          'satuan' => $item->satuan,
          'qty' => (int)$item->qty,
          'harga' => (int)$item->harga,
          'diskon' => (int)$item->diskon,
          'subtotal' => (int)($item->qty * (int)$item->harga) - (int)$item->diskon,
        ];
      }
    } else {
      if ($need_return == 'row') {
        $return = $result->row();
      }
    }
    return $return;
  }

  function getDetailCartBelumSelesai($filter, $need_return = '')
  {
    $filter['status'] = 0;
    return $this->getDetail($filter, $need_return);
  }

  function getDetailCartHold($filter, $need_return = '')
  {
    $filter['status'] = 2;
    $result = $this->getDetail($filter, $need_return);
    return $result;
  }
}
