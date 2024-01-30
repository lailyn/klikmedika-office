<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n?denied'>";
		}else{								
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/aside');			
			$this->load->view($this->page);		
			$this->load->view('frontend/footer');
		}
	}
	public function index()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "home";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/index");		
		$this->load->view('frontend/footer');
		
	}
	public function kontak()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "kontak";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/kontak");		
		$this->load->view('frontend/footer');
		
	}
	public function profil()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "profil";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/profil");		
		$this->load->view('frontend/footer');
		
	}
	public function kalender()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "kalender";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/kalender");		
		$this->load->view('frontend/footer');
		
	}
	public function galeri()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "galeri";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/galeri");		
		$this->load->view('frontend/footer');
		
	}
	public function savePesan(){
		$data['nama'] = $this->input->post("nama",TRUE);
		$data['email'] = $this->input->post("email",TRUE);
		$data['subjek'] = $this->input->post("subjek",TRUE);
		$data['pesan'] = $this->input->post("pesan",TRUE);
		$data['created_at'] = waktu();
		$data['status'] = "unread";
		$this->m_admin->insert("md_pesan",$data);
		$_SESSION['pesan'] 	= "Pesan berhasil dikirim, terima kasih";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "kontak'>";						
	}
	public function caraPemesanan()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "cara-pemesanan";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/caraPemesanan");		
		$this->load->view('frontend/footer');
		
	}
	public function paketPenyewaan()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "paket-penyewaan";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/paketPenyewaan");		
		$this->load->view('frontend/footer');
		
	}
	public function pesan()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "pesan";				
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();

		$name = $this->session->userdata('nama');		
		if($name==""){
			$_SESSION['pesan'] 	= "Silakan Login atau Register untuk melakukan pemesanan";
			$_SESSION['tipe'] 	= "danger";			
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."login'>";		
		}else{								
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/navigation');			
			$this->load->view("frontend/paketPenyewaan");		
			$this->load->view('frontend/footer');
		}
		
	}
	public function register()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;		
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();																											
		$data['set']		= "register";						
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/register");		
		$this->load->view('frontend/footer');		
	}
	public function registerPost(){
		$data2['nama_lengkap'] = $data['nama_lengkap'] = $this->input->post("nama",TRUE);
		$data2['email'] = $data['email'] = $email = $this->input->post("email",TRUE);
		$data2['no_hp'] = $data['no_hp'] = $this->input->post("no_hp",TRUE);
		$password = $this->input->post("password",TRUE);
		$password2 = $this->input->post("password2",TRUE);
		if($password==$password2){
			$cek = $this->m_admin->getByID("md_user","email",$email);
			if($cek->num_rows()==0){
				$data2['status'] = 1;
				$data2['created_at'] = waktu();
				$this->m_admin->insert("md_konsumen",$data2);


				$data['id_konsumen'] = $this->db->insert_id();
				$data['level'] = "customer";
				$data['id_user_type'] = "3";
				$data['status'] = "1";
				$data['created_at'] = waktu();
				$data['tgl_daftar'] = tgl();
				$data['password'] = md5(encr().$this->input->post('password'));				
				$this->m_admin->insert("md_user",$data);				
				$_SESSION['pesan'] 	= "Selamat, akun kamu berhasil didaftarkan. Silakan login";
				$_SESSION['tipe'] 	= "success";			
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."login'>";		
			}else{
				$_SESSION['pesan'] 	= "Email sudah terdaftar";
				$_SESSION['tipe'] 	= "danger";
				echo "<script>history.go(-1)</script>";							
			}			
		}else{
			$_SESSION['pesan'] 	= "Password harus sama!";
			$_SESSION['tipe'] 	= "danger";
			echo "<script>history.go(-1)</script>";							
		}				
	}
	public function profilPost(){
		$data['nama_lengkap'] = $this->input->post("nama_lengkap",TRUE);
		$data['email'] = $email = $this->input->post("email",TRUE);
		$data['no_hp'] = $this->input->post("no_hp",TRUE);
		$id_user = $this->input->post("id_user",TRUE);
		$password = $this->input->post("password",TRUE);		
		$data['updated_at'] = waktu();
		if($password!=''){		
			$data['password'] = md5(encr().$this->input->post('password'));				
		}
		
		$this->m_admin->update("md_user",$data,"id_user",$id_user);
		
		$_SESSION['pesan'] 	= "Selamat, akun kamu berhasil diubah.";
		$_SESSION['tipe'] 	= "success";			
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."customer'>";							
		
	}
	public function login()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;		
		$data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();																											
		$data['set']		= "login";						
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/login");		
		$this->load->view('frontend/footer');			
	}
	public function loginPost()
	{
		$username =	$this->input->post('username');
		$password = md5(encr().$this->input->post('password'));				
		$tgl 			= gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		
		$rs_login = $this->m_admin->login_user($username, $password);				
		if ($rs_login->num_rows() == 1) {
			$row = $rs_login->row();										
			$newdata = array(
				'username'  => $row->email,
				'nama'     	=> $row->nama_lengkap,
				'foto'     	=> $row->foto,
				'id_user' 	=> $row->id_user,
				'level' 		=> $row->level,														
				'id_user_type' => $row->id_user_type,
				'id_konsumen' => $row->id_konsumen,
				'app' => "purigracia"
			);
			$nama = $row->nama_lengkap;
			$this->session->set_userdata($newdata);
			$_SESSION['pesan'] 	= "Selamat Datang, ".$nama."!";
			$_SESSION['tipe'] 	= "success";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "customer'>";						
		} else {
			$_SESSION['pesan'] 	= "Kombinasi Username dan Password salah!";
			$_SESSION['tipe'] 	= "danger";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "login?usernametidakada'>";
		}					
	}	
	public function blog()
  {        
 
    //konfigurasi pagination
    $config['base_url'] = 'blog/pages'; //site url
    $config['total_rows'] = $this->db->count_all('md_artikel'); //total row
    $config['per_page'] = 10;  //show record per halaman
    $config["uri_segment"] = 3;  // uri parameter
    $choice = $config["total_rows"] / $config["per_page"];
    $config["num_links"] = 2;//floor($choice);

    // Membuat Style pagination untuk BootStrap v4
    $config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = TRUE;
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';

    $this->pagination->initialize($config);
    $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    //panggil function get_mahasiswa_list yang ada pada mmodel mahasiswa_model. 
    // public function getList($tables,$limit,$page,$by,$sort){
    $limit = $config['per_page'];
    $start = $data['page'];
    $data['dt_artikel'] = $this->db->query("SELECT md_artikel.*,md_artikel_kategori.kategori,md_user.nama_lengkap FROM md_artikel 
        LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
        LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user
        WHERE md_artikel.status = 'publish' ORDER BY md_artikel.id_artikel DESC LIMIT $start, $limit");
        
    //$data['data'] = $this->m_admin->getList("md_artikel",$config["per_page"], $data['page'],"id_artikel","DESC");                   
    $data['pagination'] = $this->pagination->create_links();
    $data['title']      = "Blog";   
    $data['setting'] = $this->m_admin->getByID("md_setting","id_setting",1)->row();         
    $data['cari'] =  $id = $this->input->get("cari");       
    $data['set'] = "blog";      
    $data['mode'] = ""; 
 

    $this->load->view('frontend/header',$data);
		$this->load->view('frontend/navigation');			
		$this->load->view("frontend/blog");		
		$this->load->view('frontend/footer');
	}
	public function blogDetail($permalink)
  {
      $data['permalink'] =  $permalink;        
      $data['dt_artikel'] = $this->db->query("SELECT * FROM md_artikel 
          LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
          LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user
          WHERE md_artikel.permalink = '$permalink'");        
      $data['setting']= $this->m_admin->getByID("md_setting","id_setting",1)->row();
      $data['set'] = "blog";
      $this->load->view('frontend/header',$data);
			$this->load->view('frontend/navigation');			
			$this->load->view("frontend/detail");		
			$this->load->view('frontend/footer');
  }

  public function cari($cari=null)
    {        
 
        //konfigurasi pagination
        $config['base_url'] = 'pages/blog'; //site url
        $config['total_rows'] = $this->db->count_all('md_artikel'); //total row
        $config['per_page'] = 10;  //show record per halaman
        $config["uri_segment"] = 4;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;//floor($choice);
 
        // Membuat Style pagination untuk BootStrap v4
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
 
        //panggil function get_mahasiswa_list yang ada pada mmodel mahasiswa_model. 
        // public function getList($tables,$limit,$page,$by,$sort){
        $limit = $config['per_page'];
        $start = $data['page'];
        if(!is_null($cari)) $carikan = " AND md_artikel_kategori.permalink LIKE '%$cari%'";
            else $carikan = "";
        $data['dt_artikel'] = $this->db->query("SELECT md_artikel.*,md_artikel_kategori.kategori,md_user.nama_lengkap FROM md_artikel 
            LEFT JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
            LEFT JOIN md_user ON md_artikel.created_by = md_user.id_user
            WHERE md_artikel.status = 'publish' $carikan ORDER BY md_artikel.id_artikel DESC LIMIT $start, $limit");
            
        //$data['data'] = $this->m_admin->getList("md_artikel",$config["per_page"], $data['page'],"id_artikel","DESC");                   
        $data['pagination'] = $this->pagination->create_links();
        $data['title']      = "Blog";   
        $data['setting'] = $this->m_admin->getByID("md_setting","id_setting",1)->row();         
        $data['cari'] =  $id = $this->input->get("cari");       
        $data['set'] = "blog";      
        $data['mode'] = ""; 
     

        $this->load->view('frontend/header',$data);
				$this->load->view('frontend/navigation');			
				$this->load->view("frontend/blog");		
				$this->load->view('frontend/footer');
    }

}
