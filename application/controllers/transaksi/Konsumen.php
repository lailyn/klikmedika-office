<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumen extends CI_Controller {

	var $tables =   "md_konsumen";		
	var $file		=		"konsumen";
	var $page		=		"transaksi/konsumen";
	var $pk     =   "id_konsumen";
	var $title  =   "Konsumen";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Konsumen</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/konsumen'>Konsumen</a></li>										
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
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$this->template($data);	
	}
	public function ajax_list()
	{
		$list = $this->m_konsumen->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			
						
			if($isi->status==1) $status = "<label class='badge badge-success'>aktif</label>";			
			 else $status = "<label class='badge badge-danger'>non-aktif</label>";								

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='transaksi/konsumen/detail?id=$isi->id_konsumen'>$isi->nama_lengkap </a> <br> $status";						
			$row[] = $isi->email." <br> ".$isi->no_hp;						
			$row[] = $isi->alamat;		
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"transaksi/konsumen/delete?id=$isi->id_konsumen\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"transaksi/konsumen/edit?id=$isi->id_konsumen\" class='dropdown-item'>Edit</a>
                <a href=\"transaksi/konsumen/akun?id=$isi->id_konsumen\" class='dropdown-item'>Aktivasi</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_konsumen->count_all(),
						"recordsFiltered" => $this->m_konsumen->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$id = $this->input->get("id");
		$row = $this->m_admin->getByID("md_konsumen","id_konsumen",$id)->row();
		$data['id_konsumen'] 			= $row->id_konsumen;
		$data['nama_lengkap'] 			= $row->nama_lengkap;
		$data['email'] 		= $row->email;
		$data['no_hp'] 			= $row->no_hp;
		$data['tgl_daftar'] = $waktu;
		$data['id_user_type'] = 3;
		$data['status'] 			= 1;		
		$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_konsumen;		
		$data['password'] = md5(encr().$pass);
		$data['level'] = $data['jenis'] = "konsumen";
		$data['foto'] 			= "";		
		$data['created_at'] 			= $waktu;
		$sql = $this->m_admin->getByID("md_user","email",$row->email);
		if(!is_null($row->email) && !is_null($row->no_hp)){
			if($sql->num_rows() == 0){
				$this->m_admin->insert("md_user",$data);					
				$_SESSION['pesan'] 		= "Akun berhasil dibuat";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/konsumen'>";					
			}else{
				$this->m_admin->update("md_user",$data,"email",$row->email);							
				$_SESSION['pesan'] 		= "Akun berhasil direset";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/konsumen'>";					
			}
		}else{
			$_SESSION['pesan'] 		= "Email dan No HP tidak boleh kosong";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
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
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$this->m_admin->delete($tabel,$pk,$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/konsumen'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['status'] 			= $this->input->post('status');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['created_at'] 			= $waktu;		
    $this->m_admin->insert($tabel,$data);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/konsumen'>";						
	}		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id			= $this->input->post('id');						
		$data['nama_lengkap'] 			= $this->input->post('nama_lengkap');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');						
		$data['status'] 			= $this->input->post('status');								
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['updated_at'] 			= $waktu;		
    $this->m_admin->update($tabel,$data,$pk,$id);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/konsumen'>";						
	}	
	public function edit()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Ubah ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['mode']		= "edit";				
		$data['dt_konsumen'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}		
	public function detail()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Detail ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";				
		$data['dt_konsumen'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
