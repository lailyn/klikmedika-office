<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {

	var $tables =   "md_brand";		
	var $file		=		"brand";
	var $page		=		"master/brand";
	var $pk     =   "id";
	var $title  =   "Brand";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Brand</a></li>										
	<li class='breadcrumb-item active'><a href='master/brand'>Brand</a></li>										
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
		$this->load->model('m_brand');		

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
		$list = $this->m_brand->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {			

			$no++;
			$row = array();
			$row[] = $no;			
			$row[] = "<a href='master/brand/detail?id=$isi->id'>$isi->brand </a>";						
			$row[] = $isi->pimpinan;			
			$row[] = $isi->email." <br> ".$isi->no_hp;			
			$row[] = $isi->website;						
			$row[] = "<img width='50%' src='assets/uploads/sites/$isi->bg_header'>";		
			$row[] = "<img width='50%' src='assets/uploads/sites/$isi->logo'>";		
			$row[] = "<img width='50%' src='assets/uploads/sites/$isi->bg_invoice'>";		
			$row[] = "<img width='50%' src='assets/uploads/sites/$isi->bg_cr'>";		
			$row[] = "
						<div class='btn-group'>
              <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
              <div class='dropdown-menu'>
                <a href=\"master/brand/delete?id=$isi->id\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                <a href=\"master/brand/edit?id=$isi->id\" class='dropdown-item'>Edit</a>
                <a href=\"master/brand/akun?id=$isi->id\" class='dropdown-item'>Aktivasi</a>                
              </div>
            </div>";													
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_brand->count_all(),
						"recordsFiltered" => $this->m_brand->count_filtered(),
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
		$data['sql'] = $this->m_admin->getByID("md_brand","status_ajuan","input");		
		$this->template($data);	
	}
	public function history()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "History Lamaran ".$this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "history";		
		$data['mode']		= "history";		
		$data['sql'] = $this->db->query("SELECT * FROM md_brand WHERE status_ajuan = 'rejected'");		
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
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/brand'>";
	}		
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;
		$config['upload_path'] 		= './assets/uploads/sites/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		

    $err = "";
    if(!empty($_FILES['logo']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('logo')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['logo']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_invoice']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_invoice')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['bg_invoice']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_cr']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_cr')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['bg_cr']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_header']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_header')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";				
				$data['bg_header']	= $this->upload->file_name;
			}
		}
		
		$data['brand'] 			= $this->input->post('brand');						
		$data['email'] 			= $this->input->post('email');				
		$data['website'] 			= $this->input->post('website');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['pimpinan'] 			= $this->input->post('pimpinan');						
		$data['alamat'] 			= $this->input->post('alamat');								
		$data['created_at'] 			= $waktu;		
		if($err!=""){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}else{
	    $this->m_admin->insert($tabel,$data);					
	    $_SESSION['pesan'] 		= "Data berhasil diubah";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/brand'>";						
	  }
	}		
	public function update()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;				
		$id			= $this->input->post('id');						
		$id_user = $this->session->userdata("id_user");		
		$config['upload_path'] 		= './assets/uploads/sites/';
		$config['allowed_types'] 	= 'jpg|png|bmp|jpeg';
		$config['max_size']				= '1000';		
    $config['encrypt_name'] 	= TRUE; 				
		$id 	= $this->input->post('id');		

    $err = "";
    if(!empty($_FILES['logo']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('logo')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_client","id",$id)->row();
	    	if(isset($row->logo)){
	    		unlink('assets/uploads/sites/'.$row->logo);         	    		
	    	}
				$data['logo']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_invoice']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_invoice')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_client","id",$id)->row();
	    	if(isset($row->bg_invoice)){
	    		unlink('assets/uploads/sites/'.$row->bg_invoice);         	    		
	    	}
				$data['bg_invoice']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_cr']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_cr')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_client","id",$id)->row();
	    	if(isset($row->bg_cr)){
	    		unlink('assets/uploads/sites/'.$row->bg_cr);         	    		
	    	}
				$data['bg_cr']	= $this->upload->file_name;
			}
		}

		if(!empty($_FILES['bg_header']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('bg_header')){
				$err = $this->upload->display_errors();				
			}else{
				$err = "";
				$row = $this->m_admin->getByID("md_client","id",$id)->row();
	    	if(isset($row->bg_header)){
	    		unlink('assets/uploads/sites/'.$row->bg_header);         	    		
	    	}
				$data['bg_header']	= $this->upload->file_name;
			}
		}
		$data['brand'] 			= $this->input->post('brand');						
		$data['email'] 			= $this->input->post('email');				
		$data['no_hp'] 			= $this->input->post('no_hp');				
		$data['website'] 			= $this->input->post('website');				
		$data['pimpinan'] 			= $this->input->post('pimpinan');						
		$data['alamat'] 			= $this->input->post('alamat');								
		$data['updated_at'] 			= $waktu;		
		if($err!=""){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1)</script>";
		}else{
	    $this->m_admin->update($tabel,$data,$pk,$id);					
	    $_SESSION['pesan'] 		= "Data berhasil diubah";
	    $_SESSION['tipe'] 		= "success";						
	    echo "<meta http-equiv='refresh' content='0; url=".base_url()."master/brand'>";						
	  }
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
		$data['dt_brand'] = $this->m_admin->getByID($tabel,$pk,$id);		
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
		$data['dt_brand'] = $this->m_admin->getByID($tabel,$pk,$id);
		$data['mode']		= "detail";				
		$this->template($data);	
	}	
}
