<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	var $tables =   "md_karyawan";		
	var $file		=		"karyawan";
	var $page		=		"master/karyawan";
	var $pk     =   "id_karyawan";
	var $title  =   "Karyawan";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Karyawan</a></li>										
	<li class='breadcrumb-item active'><a href='master/karyawan'>Karyawan</a></li>										
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
		$this->load->model('m_karyawan');		

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
		$list = $this->m_karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			$r = $this->m_admin->getByID("md_bagian","id_bagian",$isi->id_bagian);
			$bagian = ($r->num_rows() > 0) ? $r->row()->bagian : "" ;								
						
			if($isi->status==1) $status = "<label class='badge badge-success'>aktif</label>";			
			 else $status = "<label class='badge badge-danger'>non-aktif</label>";								

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/karyawan/detail?id=$isi->id_karyawan'>$isi->nama_lengkap </a> <br> $status";						
			$row[] = $isi->email." <br> ".$isi->no_hp;			
			$row[] = $bagian;			
			$row[] = $isi->alamat;		
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"master/karyawan/delete?id=$isi->id_karyawan\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"master/karyawan/edit?id=$isi->id_karyawan\" class='dropdown-item'>Edit</a>
                <a href=\"master/karyawan/akun?id=$isi->id_karyawan\" class='dropdown-item'>Aktivasi</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_karyawan->count_all(),
						"recordsFiltered" => $this->m_karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function lamaran()
	{								
		$data['isi']    = "lamaran";		
		$data['title']	= "Data Ajuan Lamaran ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "lamaran";		
		$data['mode']		= "lamaran";		
		$data['sql'] = $this->m_admin->getByID("md_karyawan","status_ajuan","input");		
		$this->template($data);	
	}
	public function history()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "History Lamaran ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "history";		
		$data['mode']		= "history";		
		$data['sql'] = $this->db->query("SELECT * FROM md_karyawan WHERE status_ajuan = 'rejected'");		
		$this->template($data);	
	}	
	public function add()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Tambah ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');				
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";
	}	
	public function akun()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$id = $this->input->get("id");
		$row = $this->m_admin->getByID("md_karyawan","id_karyawan",$id)->row();
		$data['id_karyawan'] 			= $row->id_karyawan;
		$data['nama_lengkap'] 			= $row->nama_lengkap;
		$data['email'] 		= $row->email;
		$data['no_hp'] 			= $row->no_hp;
		$data['tgl_daftar'] = $waktu;
		$data['id_user_type'] 			= 2;
		$data['status'] 			= 1;		
		$pass = $this->m_admin->getByID("md_setting","id_setting","1")->row()->pass_karyawan;		
		$data['password'] = md5(encr().$pass);
		$data['level'] = $data['jenis'] 			= "karyawan";
		$data['foto'] 			= "";		
		$data['created_at'] 			= $waktu;
		$sql = $this->m_admin->getByID("md_user","email",$row->email);
		if(!is_null($row->email) && !is_null($row->no_hp)){
			if($sql->num_rows() == 0){
				$this->m_admin->insert("md_user",$data);					
				$_SESSION['pesan'] 		= "Akun berhasil dibuat";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
			}else{
				$this->m_admin->update("md_user",$data,"email",$row->email);							
				$_SESSION['pesan'] 		= "Akun berhasil direset";
				$_SESSION['tipe'] 		= "success";						
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";					
			}
		}else{
			$_SESSION['pesan'] 		= "Email dan No HP tidak boleh kosong";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}				
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
		$data['id_bagian'] 			= $this->input->post('id_bagian');						
		$data['jenis_kelamin'] 			= $this->input->post('jenis_kelamin');						
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['created_at'] 			= $waktu;		
    $this->m_admin->insert($tabel,$data);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";						
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
		$data['id_bagian'] 			= $this->input->post('id_bagian');						
		$data['status'] 			= $this->input->post('status');						
		$data['jenis_kelamin'] 			= $this->input->post('jenis_kelamin');						
		$data['alamat'] 			= $this->input->post('alamat');						
		$data['updated_at'] 			= $waktu;		
    $this->m_admin->update($tabel,$data,$pk,$id);					
    $_SESSION['pesan'] 		= "Data berhasil diubah";
    $_SESSION['tipe'] 		= "success";						
    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/karyawan'>";						
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
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');				
		$data['dt_karyawan'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_bagian'] = $this->m_admin->getAll('md_bagian');				
		$data['dt_karyawan'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
