<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_platform extends CI_Controller
{

  var $tables =   "dwigital_saldo_platform";
  var $page    =    "dwigital/transaksi/saldo_platform";
  var $file    =    "dwigital_saldo_platform";
  var $pk     =   "id";
  var $title  =   "Saldo Platform";
  var $bread  =   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Transaksi</a></li>										
	<li class='breadcrumb-item active'><a href='dwigital/transaksi/saldo_platform'>Saldo Platform</a></li>										
	</ol>";
  var $path = "dwigital/transaksi/saldo_platform";


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
    $auth = $this->m_admin->user_auth($this->page, $data['set']);
    if ($name == "") {
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n'>";
    } elseif ($auth == 'false') {
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "denied'>";
    } else {
      $this->load->view('back_template/header', $data);
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
    $data['mode']    = "view";
    $data['dt_saldo_platform'] = $this->m_admin->getAll($this->tables);
    $this->template($data);
  }
  public function add()
  {
    $data['isi']    = $this->file;
    $data['title']  = "Tambah " . $this->title;
    $data['bread']  = $this->bread;
    $data['set']    = "insert";
    $data['mode']    = "insert";
    $this->template($data);
  }
  public function delete()
  {
    $tabel      = $this->tables;
    $pk         = $this->pk;
    $id         = $this->input->get('id');
    $this->m_admin->delete($tabel, $pk, $id);
    $_SESSION['pesan']   = "Data berhasil dihapus";
    $_SESSION['tipe']   = "success";
    echo "<meta http-equiv='refresh' content='0; url=" . base_url($this->path) . "'>";
  }
  public function save()
  {
    $tabel    = $this->tables;

    $data['nama']       = $this->input->post('nama');
    $data['sisa_saldo']       = $this->input->post('sisa_saldo');

    $this->m_admin->insert($tabel, $data);
    $_SESSION['pesan']     = "Data berhasil disimpan";
    $_SESSION['tipe']     = "success";
    echo "<meta http-equiv='refresh' content='0; url=" . base_url($this->path) . "'>";
  }
  public function update()
  {
    $tabel    = $this->tables;
    $pk       = $this->pk;
    $id       = $this->input->post('id');

    $data['nama']         = $this->input->post('nama');
    $data['sisa_saldo']    = $this->input->post('sisa_saldo');


    $this->m_admin->update($tabel, $data, $pk, $id);
    $_SESSION['pesan']     = "Data berhasil diubah";
    $_SESSION['tipe']     = "success";
    echo "<meta http-equiv='refresh' content='0; url=" . base_url($this->path) . "'>";
  }
  public function edit()
  {
    $data['isi']    = $this->file;
    $data['title']  = "Ubah " . $this->title;
    $data['bread']  = $this->bread;
    $tabel  = $this->tables;
    $pk      = $this->pk;
    $id     = $this->input->get('id');
    $data['set']    = "insert";
    $data['mode']    = "edit";
    $data['dt_saldo_platform'] = $this->m_admin->getByID($tabel, $pk, $id);
    $this->template($data);
  }
  public function detail()
  {
    $data['isi']    = $this->file;
    $data['title']  = "Detail " . $this->title;
    $data['bread']  = $this->bread;
    $tabel  = $this->tables;
    $pk      = $this->pk;
    $id     = $this->input->get('id');
    $data['set']    = "insert";
    $data['dt_saldo_platform'] = $this->m_admin->getByID($tabel, $pk, $id);
    $data['mode']    = "detail";
    $this->template($data);
  }
}
