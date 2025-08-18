<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infografis extends CI_Controller
{

	var $tables =   "ind_user";
	var $file		=		"dashboard";
	var $page		=		"dashboard";
	var $pk     =   "user_id";
	var $title  =   "Dashboard";
	var $bread	=   "<a href='' class='current'>Dashboard</a>";

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
		if ($name == "") {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "m4suk4dm1n?denied'>";
		} else {
			$this->load->view('back_template/header', $data);
			$this->load->view('back_template/aside');
			$this->load->view($this->page);
			$this->load->view('back_template/footer');
		}
	}

	public function index()
	{
		$data['isi']    = "infografis";
		$data['title']	= $this->title;
		$data['bread']	= $this->bread;
		$data['set']		= "infografis";
		$data['title2']	= "Infografis";
		$this->load->view('back_template/header', $data);
		$this->load->view('back_template/aside');
		$this->load->view('dwigital/infografis');
		$this->load->view('back_template/footer');
	}
}
