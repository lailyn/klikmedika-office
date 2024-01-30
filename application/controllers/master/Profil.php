<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	var $tables =   "md_user";		
	var $page		=		"master/profil";
	var $file		=		"profil";
	var $pk     =   "id_user";
	var $title  =   "Profil";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master</a></li>										
	<li class='breadcrumb-item active'><a href='master/profil'>Profil</a></li>										
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
		$this->load->model('m_user');		

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');		
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
		
	public function update2()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
				

		$data['nama_pimpinan'] 			= $this->input->post('nama_pimpinan');				
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['perusahaan'] 			= $this->input->post('perusahaan');				
		$data['no_telp'] 			= $this->input->post('no_telp');				
		$data['url'] 			= $this->input->post('url');				
		$data['instagram'] 			= $this->input->post('instagram');				
		$data['twitter'] 			= $this->input->post('twitter');				
		$data['facebook'] 			= $this->input->post('facebook');				
		$data['youtube'] 			= $this->input->post('youtube');				
		$data['isi_pendaftaran'] 			= $this->input->post('isi_pendaftaran');						
		$data['admin'] 			= $this->input->post('admin');						
		if($err=="" AND $err2==""){
			$this->m_admin->update($tabel,$data,$pk,1);					
			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";						
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/Profil'>";					
		}else{
			$_SESSION['pesan'] 		= $err."<br>".$err2;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}
		
	}	

	public function update()
	{		
		$tabel				= "md_user";
		$pk 				= "id_user";
		$config['upload_path'] 		= './assets/im493/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 						
		$id 				= $this->input->post('id');											


    $err = "";
    if(!empty($_FILES['foto']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('foto')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_user","id_user",$id)->row();
	    	if(isset($row->foto)){
	    		unlink('assets/im493/'.$row->foto);         	    		
	    	}
				$data['foto']	= $this->upload->file_name;
			}
		}

		$data['nama_lengkap']			= $this->input->post('nama_lengkap');
		$data['email']			= $this->input->post('email');
		$data['no_hp']			= $this->input->post('no_hp');
		$password			= $this->input->post('password');
		if($password<>''){
			$data['password'] = md5(encr().$password);	
		}												
		$this->m_admin->update($tabel,$data,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil diubah";
		$_SESSION['tipe'] 	= "success";
		$id = $this->session->userdata('id_user');		
		$ad = array("id_user"=>$id);
		$row = $this->m_admin->kondisi($tabel,$ad)->row();
		$newdata = array(
	        'username'  => $row->email,
					'nama'     	=> $row->nama_lengkap,
					'foto'     	=> $row->foto,
					'id_user' 	=> $row->id_user,
					'id_user_type' => $row->id_user_type
				);
		$this->session->set_userdata($newdata);			
		$_SESSION['pesan'] 	= "Password berhasil diubah";
		$_SESSION['tipe'] 	= "success";		
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/profil'>";			
	}
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->session->userdata("id_user");
		$data['set']		= "insert";		
		$data['mode']		= "edit";				
		$data['dt_profil'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}	
}
