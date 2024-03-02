<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends CI_Controller {

	var $tables =   "md_presensi";		
	var $page		=		"transaksi/presensi";
	var $file		=		"presensi";
	var $pk     =   "presensi_id";
	var $title  =   "Presensi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Teknisi</a></li>										
	<li class='breadcrumb-item active'><a href='transaksi/presensi'>Presensi</a></li>										
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

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->file,$data['set']);						
		if($name==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."m4suk4dm1n'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	
	public function index($reset=null)
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= "";																													
		$data['set']		= "view";		
		$data['mode']		= "view";		
		if($this->session->level!='admin'){				
			$this->template($data);	
		}else{
			$data['filter_1'] = date("Y-m-01");
			$data['filter_2'] = date("Y-m-d");
			$data['filter_3'] = "";
			$data['filter_4'] = "";
			if(is_null($reset)){
				$filter_1 = $this->input->get("tgl_awal");
				$filter_2 = $this->input->get("tgl_akhir");
				$filter_3 = $this->input->get("jenis");
				$filter_4 = $this->input->get("id_karyawan");				
				$filter_5 = $this->input->get("bulan");				
				if(isset($filter_1) AND !is_null($filter_1)) $data['filter_1'] = $filter_1;			
				if(isset($filter_2) AND !is_null($filter_2)) $data['filter_2'] = $filter_2;					
				if(isset($filter_3) AND !is_null($filter_3)) $data['filter_3'] = $filter_3;					
				if(isset($filter_4) AND !is_null($filter_4)) $data['filter_4'] = $filter_4;					
				if(isset($filter_5) AND !is_null($filter_5)) $data['filter_5'] = $filter_5;					
			}

			$submit = $this->input->get('filter');
			if($submit=="download"){
				$this->load->view('transaksi/presensiCetak',$data);
			}else{
				$this->load->view('back_template/header',$data);
				$this->load->view('back_template/aside');			
				$this->load->view("transaksi/presensiAdmin");		
				$this->load->view('back_template/footer');
			}
		}
	}
	public function ajax_list()
	{
		$starts = (null !== $this->input->post("start"))?$this->input->post("start"):0;
		$length = (null !== $this->input->post("length"))?$this->input->post("length"):10;
		$LIMIT = "LIMIT $starts, $length ";
		$search = (null !== $this->input->post("search")["value"])?$this->input->post("search")["value"]:'';
		$orders = isset($_POST["order"]) ? $_POST["order"] : '';		

		$where = "WHERE 1=1 ";
		$where_limit = "WHERE 1=1 ";


		$tgl_awal = date("Y-m-01");
		$tgl_akhir = date("Y-m-d");


		$tgl1 = (null !== $this->input->post("tgl_awal"))?$this->input->post("tgl_awal"):$tgl_awal;
		$tgl2 = (null !== $this->input->post("tgl_akhir"))?$this->input->post("tgl_akhir"):$tgl_akhir;

		$where .= " AND LEFT(md_presensi.waktu,10) BETWEEN '$tgl1' AND '$tgl2'";
		$where_limit .= " AND LEFT(md_presensi.waktu,10) BETWEEN '$tgl1' AND '$tgl2'";


		$id_karyawan = (null !== $this->input->post("id_karyawan"))?$this->input->post("id_karyawan"):'';
		if($id_karyawan!=''){
			$where .= " AND md_presensi.id_karyawan = '$id_karyawan'";
			$where_limit .= " AND md_presensi.id_karyawan = '$id_karyawan'";
		}

		$jenis = (null !== $this->input->post("jenis"))?$this->input->post("jenis"):'';
		if($jenis!=''){
			$where .= " AND md_presensi.jenis = '$jenis'";
			$where_limit .= " AND md_presensi.jenis = '$jenis'";
		}

		$result = array();

		if (isset($search)) {
			if ($search != '') {
				$where .= " AND (md_karyawan.nama_lengkap LIKE '%$search%' OR md_presensi.waktu LIKE '%$search%') ";
				$where_limit .= " AND (md_karyawan.nama_lengkap LIKE '%$search%' OR md_presensi.waktu LIKE '%$search%') ";

			}
		}

		if (isset($orders)) {
			if ($orders != '') {
				$order = $orders;
				$order_column = ['md_karyawan.nama_lengkap', 'md_presensi.waktu', 'md_presensi.jenis'];
				$order_clm = $order_column[$order[0]['column']];
				$order_by = $order[0]['dir'];
				$where .= " ORDER BY $order_clm $order_by ";
			} else {
				$where .= " ORDER BY md_presensi.presensi_id DESC ";
			}
		} else {
			$where .= " ORDER BY md_presensi.presensi_id DESC ";
		}

		if (isset($LIMIT)) {
			if ($LIMIT != '') {
				$where .= ' ' . $LIMIT;
			}
		}

		$sql = "SELECT * FROM md_presensi LEFT JOIN md_karyawan ON md_presensi.id_karyawan = md_karyawan.id_karyawan ";


		$index = 1;
		$fetch_record_filtered = $this->db->query($sql . $where);		
		
		$fetch_all = $this->db->query($sql . $where_limit);

		$setting = $this->m_admin->getByID("md_setting",'id_setting',1)->row();
		$lat = $setting->lat;
		$lang = $setting->lang;

		foreach ($fetch_record_filtered->result() as $rows) {						
			

			$telatS = ($rows->jenis=="datang")?"terlambat":"pulang terlalu cepat";
      $telat = ($rows->telat==1)?"<label class='badge badge-danger'>".$telatS."</label>":'';
      $id = encrypt_url($rows->presensi_id);

      $tags = explode(",", $rows->tagging);
      $rt = "";
      if($tags[0]!='error' && !is_null($rows->tagging)){
	      $latitude1 = $lat;
				$longitude1 = $lang;
				$latitude2 = $tags[0];
				$longitude2 = $tags[1];

				$radius = 1; // Radius dalam kilometer

				$distance = haversineDistance($latitude1, $longitude1, $latitude2, $longitude2);

				if ($distance > $radius) $rt = "<label class='badge badge-danger'>Di luar Radius</label>";
					else $rt = "";
			}

			if (!is_null($rows->trans) && $rows->trans==1) $rst = "<label class='badge badge-danger'>rejected</label>";
					else $rst = "";


			$sub_array = array();
			$sub_array[] = $index;			
			$sub_array[] = $rows->nama_lengkap;
			$sub_array[] = $rows->jenis;
			$sub_array[] = $rows->waktu." ".$telat;						
			$sub_array[] = $rows->kesehatan;
			$sub_array[] = $rows->tagging;
			$sub_array[] = "<img src='assets/uploads/presensi/$rows->foto' width='50px'>";			
			$sub_array[] = "<a onclick=\"return confirm('Anda yakin?')\" href='transaksi/presensi/hapus/$id' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
			<a onclick=\"return confirm('Anda yakin?')\" href='transaksi/presensi/reject/$id' class='btn btn-warning btn-sm'><i class='fa fa-times'></i></a>";			
			$result[] = $sub_array;
			$index++;
		}
		$output = array(
			"draw" => intval($this->input->post("draw")),
			"recordsFiltered" => $fetch_all->num_rows(),
			"recordsTotal" => $fetch_record_filtered->num_rows(),
			"data" => $result,
		);
		echo json_encode($output);

	}
	public function reject($id){
		$id = decrypt_url($id);
		$data['trans'] = 1;
		$data['updated_at'] = waktu();
		$this->m_admin->update("md_presensi",$data,"presensi_id",$id);
		$_SESSION['pesan'] 		= "Presensi Reject";
		$_SESSION['tipe'] 		= "success";									
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/presensi'>";							
	}
	public function hapus($id){
		$id = decrypt_url($id);		
		$this->m_admin->delete("md_presensi","presensi_id",$id);
		$_SESSION['pesan'] 		= "Presensi Dihapus";
		$_SESSION['tipe'] 		= "success";									
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/presensi'>";							
	}
	public function save()
	{		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 		= gmdate("Y-m-d", time()+60*60*7);		
		$jam_sekarang  = gmdate("H:i:s", time()+60*60*7);    
		$jam_sekarang_stamp = strtotime($jam_sekarang);
		$tabel		= $this->tables;		
		$pk				= $this->pk;		
		$data['id_karyawan'] 		= $id_karyawan	= $this->input->post('id_karyawan');										
		$data['kerja_ket'] 			= $this->input->post('kerja_ket');								
		$data['kesehatan'] 			= $this->input->post('kesehatan');										
		$data['waktu'] 			= $this->input->post('waktu');								
		$data['created_at'] 			= $waktu;		
		$data['jenis']  = $jenis			= $this->input->post('jenis');		
		$data['tagging'] 			= $this->input->post('tagging');		
		$data['shift'] 		= $shift	= $this->input->post('shift');	

		
		$jam_datang = $this->m_admin->getByID("md_setting","id_setting",1)->row()->jam_datang_s1;	
		$jam_pulang = $this->m_admin->getByID("md_setting","id_setting",1)->row()->jam_pulang_s1;	
		
		$jenis = "pulang";
		if($jenis=='datang'){			
	    $jam_awal_datang_stamp = strtotime($jam_datang);	    	    
	    if ($jam_sekarang_stamp - $jam_awal_datang_stamp > 1 * 60) {
	      $data['telat'] = 1;
	    }
		}else{
			$jam_awal_pulang_stamp = strtotime($jam_pulang);	    	    
	    if ($jam_sekarang_stamp < $jam_awal_pulang_stamp) {
	      $data['telat'] = 1;
	    }
		}		

		$config = $this->m_admin->set_upload_options('./assets/uploads/presensi/','jpg|png|jpeg|pdf','5000');		
		$err = "";
    if(!empty($_FILES['image']['name'])){
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				$err = $this->upload->display_errors();				
			}else{				
				$data['foto']	= $this->upload->file_name;
			}
		}
		
		if($err!=''){
			$_SESSION['pesan'] 		= $err;
			$_SESSION['tipe'] 		= "danger";											
			echo "<script>history.go(-1)</script>";
			exit();
		}


		$cek = $this->db->query("SELECT * FROM md_presensi WHERE id_karyawan = '$id_karyawan' AND jenis = '$jenis' AND LEFT(waktu,10) = '$tgl'");
		if($cek->num_rows() == 0){                            
			$this->m_admin->insert("md_presensi",$data);					
			$_SESSION['pesan'] 		= "Presensi kamu berhasil";
			$_SESSION['tipe'] 		= "success";									
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."transaksi/presensi'>";							
		}else{
			$_SESSION['pesan'] 		= "Presensi gagal, Kamu sudah isi presensi";
			$_SESSION['tipe'] 		= "danger";						
			echo "<script>history.go(-1);</script>";
		}
	}	
}
