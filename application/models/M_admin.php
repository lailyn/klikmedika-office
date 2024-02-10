<?php				
class M_admin extends CI_Model{
	 
		// Menampilkan data dari sebuah tabel dengan pagination.
		public function getList($tables,$limit,$page,$by,$sort){
				$this->db->order_by($by,$sort);
				$this->db->limit($limit,$page);
				return $this->db->get($tables);
		}
		
		// menampilkan semua data dari sebuah tabel.
		public function getAll($tables){
				$db = $this->db->database;
				$cek = $this->db->query("SELECT GROUP_CONCAT(COLUMN_NAME) AS primary_id FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
								WHERE TABLE_SCHEMA = '$db' AND CONSTRAINT_NAME='PRIMARY' AND TABLE_NAME = '$tables'");
				if($cek->num_rows() > 0){
						$f = $cek->row();
						$id = $f->primary_id;
						$this->db->order_by($id,"DESC");        
				}
				return $this->db->get($tables);
		}
		
		// menghitun jumlah record dari sebuah tabel.
		public function countAll($tables){
				return $this->db->get($tables)->num_rows();
		}
		public function ubah_rupiah($nominal)
		{
			$rupiah = str_replace(',', '', $nominal);		
			return $rupiah;
		}
		
		// menghitun jumlah record dari sebuah query.
		public function countQuery($query){
				return $this->db->get($query)->num_rows();
		}
		
		//enampilkan satu record brdasarkan parameter.
		public function kondisi($tables,$where)
		{
				$this->db->where($where);
				return $this->db->get($tables);
		}
		public function kondisiCond($tables,$where)
		{
				$this->db->where($where)
								 ->where("active",1);
				return $this->db->get($tables);
		}
		//menampilkan satu record brdasarkan parameter.
		public  function getByID($tables,$pk,$id){
				$this->db->where($pk,$id);
				return $this->db->get($tables);
		}
		
		// Menampilkan data dari sebuah query dengan pagination.
		public function queryList($query,$limit,$page){
			 
				return $this->db->query($query." limit ".$page.",".$limit."");
		}
		
		public function getSortCond($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)								
								->order_by($by,$sort);
				return $this->db->get();
		}		
		//
		public function getSort($tables,$by,$sort){
			 $this->db->select('*')
								->from($tables)                
								->order_by($by,$sort);
				return $this->db->get();
		}
		// memasukan data ke database.
		public function insert($tables,$data){
				$this->db->insert($tables,$data);
		}
		
		// update data kedalalam sebuah tabel
		public function update($tables,$data,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->update($tables,$data);
		}
		
		// menghapus data dari sebuah tabel
		public function delete($tables,$pk,$id){
				$this->db->where($pk,$id);
				$this->db->delete($tables);
		}
		
		function login($username,$password)
		{
				$sql =  "SELECT * FROM md_user WHERE (email=? OR no_hp=?) AND password = ? AND status = 1";        				
				return $this->db->query($sql, array($username, $username, $password));
		}
		function login_user($username,$password)
		{
			$where="";
			$dr = $this->m_admin->getByID("md_setting","id_setting",1)->row();
			$cek_pwd = $dr->pwd_user_default;
			if($cek_pwd==1) $where.=" OR pwd_admin='$password'";

			$sql =  "SELECT * FROM md_user WHERE (email=? OR no_hp=?) AND (password = ? $where) AND level = 'customer' AND status = 1 AND banned = 0";        				
			return $this->db->query($sql, array($username, $username, $password));
		}	

		function guest()
		{
			$user_type = $this->session->userdata("user_type");
			if($user_type == 7){
				$data = "style='display:none;'";
			}else{
				$data = "";
			}
			return $data;
		}
			
		function get_token($panjang){
        $token = array(
            range(1,9)
        );

        $karakter = array();
        foreach($token as $key=>$val){
            foreach($val as $k=>$v){
                $karakter[] = $v;
            }
        }

        $token = null;
        for($i=1; $i<=$panjang; $i++){
            // mengambil array secara acak
            $token .= $karakter[rand($i, count($karakter) - 1)];
        }

        return $token;
    }
   function get_layanan($kode){
   	$in = substr($kode,0,1);
   	$fee_mitra_h=0;$fee_tim_h=0;$fee_dokter_h=0;$fee_tim_k=0;$fee_dokter_k=0;$id_layanan = "";$layanan="";$tarif="";$rate="";$diskon="";$rate_tetap="";$deskripsi="";$foto="";$biaya_kunjungan="";
   	$data = array();
   	if($in=="L"){
   		$rt = $this->m_admin->getByID("md_layanan","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ; 
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->foto : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="K"){
   		$rt = $this->m_admin->getByID("md_layanan_sub","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;  
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;  	
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="M"){
   		$rt = $this->m_admin->getByID("md_layanan_sub2","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub2 : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub2 : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;    		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="N"){
   		$rt = $this->m_admin->getByID("md_layanan_sub3","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layanan_sub3 : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layanan_sub3 : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;   		
   		$fee_mitra_h = ($rt->num_rows() > 0) ? $rt->row()->fee_mitra_h : 0 ;   		
   		$fee_dokter_h = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_h : 0 ;   		
   		$fee_tim_h = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_h : 0 ;   		
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = ($rt->num_rows() > 0) ? $rt->row()->rate_tetap : "" ;
   		$biaya_kunjungan = ($rt->num_rows() > 0) ? $rt->row()->biaya_kunjungan : "" ;
   		$foto = ($rt->num_rows() > 0) ? $rt->row()->gambar : "" ;
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}
   	}elseif($in=="P"){
   		$rt = $this->m_admin->getByID("md_layananKlinik","kode",$kode);
   		$id_layanan = ($rt->num_rows() > 0) ? $rt->row()->id_layananKlinik : "" ;
   		$layanan = ($rt->num_rows() > 0) ? $rt->row()->layananKlinik : "" ;
   		$tarif = ($rt->num_rows() > 0) ? $rt->row()->tarif : "" ;   		
   		$fee_mitra_h = 0;
   		$fee_dokter_h = 0;
   		$fee_tim_h = 0;
   		$fee_dokter_k = ($rt->num_rows() > 0) ? $rt->row()->fee_dokter_k : 0 ;   		
   		$fee_tim_k = ($rt->num_rows() > 0) ? $rt->row()->fee_tim_k : 0 ;   		
   		$rate = ($rt->num_rows() > 0) ? $rt->row()->rate : "" ;
   		$rate_tetap = 0;
   		$biaya_kunjungan = 0;
   		$foto = '';
   		$deskripsi = ($rt->num_rows() > 0) ? $rt->row()->deskripsi : "" ;
   		$diskon = ($rt->num_rows() > 0) ? $rt->row()->disc : "" ;	
   		$diskon_rp = ($rt->num_rows() > 0) ? $rt->row()->disc_rp : "" ;
   		if($diskon==0){
   			$cari_d = @($diskon_rp / $tarif) * 100;
   			$diskon = $cari_d;
   		}   	
   	}

   	$result = [
			'id_layanan' => $id_layanan,
			'tarif' => $tarif,
			'diskon' => $diskon,
			'rate' => $rate,
			'rate_tetap' => $rate_tetap,
			'fee_mitra_h' => $fee_mitra_h,
			'fee_dokter_h' => $fee_dokter_h,
			'fee_tim_h' => $fee_tim_h,
			'fee_tim_k' => $fee_tim_k,
			'fee_dokter_k' => $fee_dokter_k,
			'biaya_kunjungan' => $biaya_kunjungan,
			'layanan' => $layanan,
			'foto' => $foto,
			'deskripsi' => $deskripsi
		];


   	return $result;
   }
   function get_location($id_kelurahan=null,$id_kecamatan=null,$id_kabupaten=null,$id_provinsi=null){
   	$where="";
   	if(!is_null($id_kecamatan)) $where .= " AND ms_kecamatan.id_kecamatan = '$id_kecamatan'";
   	if(!is_null($id_kelurahan)) $where .= " AND ms_kelurahan.id_kelurahan = '$id_kelurahan'";
   	if(!is_null($id_kabupaten)) $where .= " AND ms_kabupaten.id_kabupaten = '$id_kabupaten'";
   	if(!is_null($id_provinsi)) $where .= " AND ms_provinsi.id_provinsi = '$id_provinsi'";
   	$cek = $this->db->query("SELECT ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan FROM ms_kelurahan
   	  LEFT JOIN	ms_kecamatan ON ms_kelurahan.id_kecamatan = ms_kecamatan.id_kecamatan   	 
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");   	
   	$result = [
			'id_provinsi' => ($cek->num_rows() > 0)?$cek->row()->id_provinsi:"",			
			'provinsi' => ($cek->num_rows() > 0)?$cek->row()->provinsi:"",			
			'id_kabupaten' => ($cek->num_rows() > 0)?$cek->row()->id_kabupaten:"",			
			'kabupaten' => ($cek->num_rows() > 0)?$cek->row()->kabupaten:"",			
			'id_kecamatan' => ($cek->num_rows() > 0)?$cek->row()->id_kecamatan:"",			
			'kecamatan' => ($cek->num_rows() > 0)?$cek->row()->kecamatan:"",			
			'id_kelurahan' => ($cek->num_rows() > 0)?$cek->row()->id_kelurahan:"",			
			'kelurahan' => ($cek->num_rows() > 0)?$cek->row()->kelurahan:""			
		];
		return $result;
   }
   function set_upload_options($path,$type,$max){
	    $config = array();
	    $config['upload_path'] 			= $path;
	    $config['allowed_types']    = $type;
	    $config['max_size']         = $max;
	    $config['encrypt_name'] 		= TRUE; 				
	 
	    return $config;
	}
	public function user_menu($menu){
      $id_user        = $this->session->userdata("id_user");
      $id_user_type     = $this->session->userdata('id_user_type');        
      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = '$id_user_type'");
     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
                          WHERE md_user_access.id_user_type = '$id_user_type' AND md_menu.menu_link = '$menu' 
                          AND md_user_access.can_view = 1");        
      if($cek->num_rows() > 0 OR $user_type == 'Admin' OR $user_type == 'HR & Finance'){
          $akses = "";
      }else{
          $akses = "style='display:none;'";            
      }
      return $akses;
  }
	// public function user_menu($menu){
 //      $id_user        = $this->session->userdata("id_user");
 //      $id_user_type     = $this->session->userdata('id_user_type');        
 //      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = '$id_user_type'");
 //     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
 //      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
 //                          WHERE md_user_access.id_user_type = '$id_user_type' AND md_menu.menu_link = '$menu' 
 //                          AND md_user_access.can_view = 1");        
 //      if($cek->num_rows() > 0 OR $user_type == 'Admin'){
 //          $akses = "";
 //      }else{
 //          $akses = "style='display:none;'";            
 //      }
 //      return $akses;
 //  }
  public function user_auth($menu,$mode){
      $id_user        = $this->session->userdata("id_user");
      $id_user_type     = $this->session->userdata('id_user_type');        
      $sql            = $this->db->query("SELECT * FROM md_user_type WHERE id_user_type = '$id_user_type'");
     	$user_type = ($sql->num_rows() > 0) ? $sql->row()->user_type : "" ;               
      $cek            = $this->db->query("SELECT * FROM md_user_access INNER JOIN md_menu ON md_user_access.id_menu = md_menu.id_menu 
                          WHERE md_user_access.id_user_type = '$id_user_type' AND md_menu.menu_link = '$menu' 
                          AND md_user_access.can_".$mode." = 1");        
      if($cek->num_rows() > 0 OR $user_type == 'Admin' OR $user_type == 'HR & Finance'){
          $akses = "true";
      }else{
          $akses = "false";
      }
      return $akses;
  }
  public function ambil_alamat($id_user=null,$id_alamat=null,$limit=null){
  	$where="";$where_limit="";
  	if(!is_null($id_alamat)) $where .= " AND md_user_alamat.id_alamat = '$id_alamat'";
  	if(!is_null($id_user)) $where .= "  AND md_user_alamat.id_user = '$id_user'";
  	if(!is_null($limit)) $where_limit = " ORDER BY md_user_alamat.id_alamat DESC LIMIT 0,$limit";

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where AND md_user_alamat.utama = 1");
  	return $cek;
  }
  public function ambil_alamat_by_alamat($id_alamat=null){
  	$where="";
  	if(!is_null($id_alamat)) $where .= " AND md_user_alamat.id_alamat = '$id_alamat'";  	

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");
  	return $cek;
  }
  public function ambil_alamat_by_user($id_user){
  	$where="";  	
  	if(!is_null($id_user)) $where .= "  AND md_user_alamat.id_user = '$id_user'";  	

  	$cek = $this->db->query("SELECT md_user_alamat.*,ms_kelurahan.id_kelurahan,ms_kelurahan.kelurahan,ms_provinsi.id_provinsi,ms_provinsi.provinsi,ms_kabupaten.id_kabupaten,ms_kabupaten.kabupaten,ms_kecamatan.id_kecamatan,ms_kecamatan.kecamatan FROM md_user_alamat 					
			LEFT JOIN ms_kelurahan ON md_user_alamat.id_kelurahan = ms_kelurahan.id_kelurahan
			LEFT JOIN ms_kecamatan ON md_user_alamat.id_kecamatan = ms_kecamatan.id_kecamatan
			LEFT JOIN ms_kabupaten ON ms_kecamatan.id_kabupaten = ms_kabupaten.id_kabupaten
			LEFT JOIN ms_provinsi ON ms_kabupaten.id_provinsi = ms_provinsi.id_provinsi			
			WHERE 1=1 $where");
  	return $cek;
  }
  public function set_income($user,$id_user,$jenis,$no_trans,$nominal){  	
  	$waktu = gmdate("Y-m-d H:i:s", time()+60*60*7);				
  	$data['id_user'] = $id_user;
  	$data['user'] = $user;
  	$data['jenis'] = $jenis;
  	$data['nominal'] = $nominal;
  	$data['no_trans'] = $no_trans;
  	$data['updated_at'] = $waktu;
  	$this->insert("md_income",$data);

  	if($user=="dokter"){
  		$this->db->query("UPDATE md_dokter SET saldo = saldo + $nominal WHERE id_dokter = '$id_user'"); 
  	}elseif($user=="karyawan"){
  		$this->db->query("UPDATE md_karyawan SET saldo = saldo + $nominal WHERE id_karyawan = '$id_user'"); 
  	}

  	$this->set_poin($user,$jenis,$no_trans);
  }

  public function set_poin($user,$jenis,$no_trans){
  	$simpan="false";$poin=0;$id=0;
  	if($jenis=="order"){
  		$cek = $this->m_admin->getByID("md_order","no_order",$no_trans)->row()->kode_referral;
  		if($cek!=""){ 
  			$simpan = "true";  		
				$id = $this->cek_referral($cek)['id'];
  		}
  	}elseif($jenis=="visit"){
  		$cek = $this->m_admin->getByID("md_visit","no_visit",$no_trans)->row()->kode_referral;
  		if($cek!=""){ 
  			$simpan = "true";  		
				$id = $this->cek_referral($cek)['id'];
  		}
  	}elseif($jenis=="order"){  	
  		$cek = $this->m_admin->getByID("md_chat","no_chat",$no_trans)->row()->kode_referral;
  		if($cek!=""){ 
  			$simpan = "true";  		
				$id = $this->cek_referral($cek)['id'];
  		}
  	}

  	

  	$poin = $this->m_admin->getByID("md_setting","id_setting",1)->row()->poin_refferal;
  	$waktu = gmdate("Y-m-d H:i:s", time()+60*60*7);				
  	if($simpan=="true" AND $poin > 0){
	  	$data['id_user'] = $id;
	  	$data['user'] = $user;
	  	$data['jenis'] = $jenis;
	  	$data['poin'] = $poin;
	  	$data['no_trans'] = $no_trans;
	  	$data['updated_at'] = $waktu;

	  	$this->insert("md_poin",$data);

	  	if($id!=0){
		  	if($user=="dokter"){
		  		$this->db->query("UPDATE md_dokter SET poin = poin + $poin WHERE id_dokter = '$id'"); 
		  	}elseif($user=="karyawan"){
		  		$this->db->query("UPDATE md_karyawan SET poin = poin + $poin WHERE id_karyawan = '$id'"); 
		  	}
		  }
	  }
  }
  public function ambil_apotek($id_user){
  	$sql = $this->db->query("SELECT md_apotek.* FROM md_user INNER JOIN md_apotek ON md_user.id_karyawan = md_apotek.id_apotek
  		WHERE md_user.id_user = '$id_user'");
  	return $sql;
  }
  function set_notif($id_user=null,$judul=null,$isi=null,$tipe=null,$id_order=null,$id_promo=null)
	{
			$waktu   = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);		
			$tgl   = gmdate("Y-m-d", time() + 60 * 60 * 7);		
			$jam   = gmdate("H:i:s", time() + 60 * 60 * 7);		
			$data['id_user'] = $id_user;
			$data['isi'] = $isi;
			$data['tgl'] = $tgl;
			$data['jam'] = $jam;
			$data['judul'] = $judul;
			$data['created_at'] = $waktu;
			if($tipe != null OR $id_order != null OR $id_promo != null) {
				$data['tipe_notifikasi'] = $tipe;
				$data['id_order'] = $id_order;
				$data['id_promo'] = $id_promo;

				if(($tipe=="order" OR $tipe=="visit" OR $tipe=="chat" OR $tipe=="user" OR $tipe=="lamaran")){
					if($id_user==0){
						$regid = $this->m_admin->getByID("md_user","id_user",483)->row()->token;
					}else{
						$regid = $this->m_admin->getByID("md_user","id_user",$id_user)->row()->token;
					}
					if($regid!=""){ 
						if($tipe=="chat"){
							$jenis = "detailChat";
							$no_order = $this->m_admin->getByID("md_chat","id_chat",$id_order);
							$orderan = ($no_order->num_rows() > 0) ? $no_order->row()->no_chat : "" ;
						}elseif($tipe=="order"){
							$jenis = "detailLayanan";
							$no_order = $this->m_admin->getByID("md_order","id_order",$id_order);
							$orderan = ($no_order->num_rows() > 0) ? $no_order->row()->no_order : "" ;
						}elseif($tipe=="visit"){
							$jenis = "detailVisit";
							$no_order = $this->m_admin->getByID("md_visit","id_visit",$id_order);
							$orderan = ($no_order->num_rows() > 0) ? $no_order->row()->no_visit : "" ;
						}else{
							$jenis = "";
							$orderan = "";
						}
						$this->send_fcm($regid,$judul,$isi,$jenis,$orderan);
					}

					if($id_user==0){
						$no_hp = $this->m_admin->getByID("md_setting","id_setting",1)->row()->no_hp;
					}else{
						$no_hp = $this->m_admin->getByID("md_user","id_user",$id_user)->row()->no_hp;
					}
					$text = $judul."\n\n\n".$isi;
					$this->send_otp($no_hp,$text);
				}
			}
			$this->insert("md_notifikasi",$data);			
			$this->send_notif($this->db->insert_id());			
	}	
		
  public function send_notif($id)
  {       
  	$row = $this->m_admin->getByID("md_notifikasi","id_notifikasi",$id)->row();
  	$am = $this->m_admin->getByID("md_setting","id_setting",1)->row();
  	if($row->id_user!=0){
  		$user = $this->m_admin->getByID("md_user","id_user",$row->id_user)->row();	
  		$nama_lengkap = $user->nama_lengkap;
  		$email = $user->email;
  	}else{	  		
  		$nama_lengkap = $am->admin;
  		$email = $am->email;
  	}
  	$isi = "Halo ".$nama_lengkap.", <br> ".$row->isi;			  	
    $data = array(
      'subject' => $row->judul,
      'to' => $email,
      'template_path' => "email/email_activation",            
      'isi' => $isi
    );
    return $this->send_email($data);      
  }
  public function send_verifikasi($email,$otp)
  {       
  	$am = $this->m_admin->getByID("md_setting","id_setting",1)->row();
  	$email_enc = encrypt_url($email);
  	$link = "auth/verifikasi_link/".$email_enc."/".$otp;
    $data = array(
      'subject' => "Verifikasi Akun",
      'to' => $email,
      'template_path' => "email/email_activation",
      'otp' => $otp,
      'link' => $link,
      'isi' => $am->isi_pendaftaran
    );
    return $this->send_email($data);      
  }
  public function send_reset($email,$code)
  {       
  	$am = $this->m_admin->getByID("md_setting","id_setting",1)->row();
  	$email_enc = encrypt_url($email);
  	$code_enc = encrypt_url($code);
  	$link = "auth/recreate/".$email_enc."/".$code_enc;  	
    $data = array(
      'subject' => "Reset Akun",
      'to' => $email,
      'template_path' => "email/email_activation",      
      'link' => $link,
      'isi' => $am->isi_reset
    );
    return $this->send_email($data);      
  }
  public function send_email($data)
  {        
    $this->load->library('email');
    $am = $this->m_admin->getByID("md_setting","id_setting",1)->row();
                      

    $message = $this->load->view($data['template_path'], $data, TRUE);            

    $config['mailtype'] = 'html'; // or html
    $config['protocol'] = 'mail';
    $config['validation'] = TRUE; // bool whether to validate email or not              
    $this->email->initialize($config);
    $this->email->from("no-reply@keimedika.com", "Kei Medika");
    $this->email->to($data['to']); 
    $this->email->subject($data['subject']);
    $this->email->message($message);
    $this->email->set_newline("\r\n");
    $data = array();
    if($this->email->send())
    {
        $pesan = "berhasil";
    }
     else
    {             
        $pesan 	= show_error($this->email->print_debugger());     	
    }           
    return $pesan;
  }


  public function send_fcm($regid,$title,$body,$jenis,$order_id=null)
	{
	  if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY',"AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi");
	  //$regid = ["fPKu0IkHR66y2_D4fbq3py:APA91bEalD9YROUgT-s8yjoNsCd43EshYUL1ZFYFcM6hjABR4iIE-U9Vbmn2KDwpIZdvIhbbdcyAMEt6h04R6VQeX2L0Ow6i5SqFmNNZg10UdC7t52qTodp9ZH771i_1BMZx5VW8hd0r"];
	  $regid = [$regid];	  
	  if(!is_null($order_id) AND $order_id!="") $orderan = 	$order_id;
	  	else $orderan = "";
	  $msg = array(
	    'title'     => $title,//"Selamat Datang di KeiMedika",
	    'body'     => $body,//"Banyak kebutuhanmu disini ",
	    'content_available' => true,
	    'priority' => 'high',
	    'tag' => 'new_message',
	  );
	  $dataa = array(
	    'content_available' => true,
	    'priority' => 'high',
	    'page'=>$jenis,
	  	'id'=>$orderan
	  );

	 
	  
	  $android = array(
	    'id_param' => $orderan,
	    'page' => 'detailOrderLayanan'	  	
	  );
	  $fields = array(	    
	    'registration_ids'=>$regid,	    
	    'notification'=> $msg,
	    'data'=>$dataa	    
	  );
	  $headers = array(
	    'Authorization: key= AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi',
	    'Content-Type: application/json'
	  );

	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	  $chresult = curl_exec($ch);

	  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  if (curl_errno($ch)) {
	    return false; //probably you want to return false
	  }
	  if ($httpCode != 200) {
	    return false; //probably you want to return false
	  }
	  curl_close($ch);
	  // return $chresult;
	}
	public function send_promo($title,$body,$img,$promo_id)
	{
	  if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY',"AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi");	  
	  if(!is_null($promo_id) AND $promo_id!="") $promoId = 	$promo_id;
	  	else $promoId = "";

	  $msg = array(
	    'title'     => $title,
	    'body'     => $body,
	    'image'     => "http://images.summitmedia-digital.com/cosmo/images/september_2015/09-23/the-intern-anne-hathaway.jpg",
	    'content_available' => true,
	    'priority' => 'high',
	    'tag' => 'new_message',
	  );
	  $dataa = array(
	    'content_available' => true,
	    'priority' => 'high',
	    'page'=>'detailPromo',
	  	'id'=>$promoId
	  );
	  
	  $fields = array(	    
	    'to'=>'/topics/promo',	    
	    'notification'=> $msg,
	    'data'=>$dataa	    
	  );
	  $headers = array(
	    'Authorization: key= AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi',
	    'Content-Type: application/json'
	  );

	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	  $chresult = curl_exec($ch);

	  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  if (curl_errno($ch)) {
	    return false; //probably you want to return false
	  }
	  if ($httpCode != 200) {
	    return false; //probably you want to return false
	  }
	  curl_close($ch);
	}
	public function send_promo_old($rowdata)
	{
	  if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY',"AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi");
	  
	  $fields = $this->security->xss_clean($rowdata);
	  	  
	  $headers = array(
	    'Authorization: key= AAAAUse05w8:APA91bHlzw5HfPSW7HjPMP3b8x4MGucTCmaamUUEyjgGCXdgFQvDvqbUUI5vc-8L_BU7YXoN225BBntlnJu4R277sTBaLLAC-gGXGi61VKl5TevLDqMZTnNs_q06UTus17AJMfwNvCFi',
	    'Content-Type: application/json'
	  );

	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	  $chresult = curl_exec($ch);

	  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  if (curl_errno($ch)) {
	    return false; //probably you want to return false
	  }
	  if ($httpCode != 200) {
	    return false; //probably you want to return false
	  }
	  curl_close($ch);
	  // return $chresult;
	}


  function cek_kadaluarsa($id_user){
		$waktu = gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		$query = $this->db->query("SELECT * FROM md_order WHERE id_user = '$id_user' 
			AND status_bayar = 1 AND kadaluarsa < '$waktu'");
		foreach($query->result() AS $isi){
			$data['status'] = 'batal';
			$data['status_bayar'] = 3;
			$data['batal_time'] = $waktu;
			$data['batal_by'] = 0;
			$data['kesimpulan'] = "Pembayaran Expired";
			$this->update("md_order",$data,"id_order",$isi->id_order);			
		}
		//return $query->num_rows();
	}
	function cek_selesai_order(){
		$waktu = gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		$query = $this->db->query("SELECT * FROM md_order WHERE status = 'selesai' AND selesai_user = 0");
		foreach($query->result() AS $isi){
			$tgl_baru = manipulate_time($isi->selesai_time,"days","2","+");    
			if($waktu > $tgl_baru){
				$data['selesai_user'] = 1;		
				$data['selesai_user_time'] = $waktu;
				$data['updated_at'] = $waktu;
				$this->update("md_order",$data,"id_order",$isi->id_order);			
				$total = $isi->rate_layanan;		
				$jenis = "karyawan";
				$id_users = $isi->id_karyawan;		
				$this->set_income($jenis,$id_users,"order",$isi->no_order,$total);  
			}			
		}		
	}
	function cek_selesai_visit(){
		$waktu = gmdate("Y-m-d h:i:s", time() + 60 * 60 * 7);
		$query = $this->db->query("SELECT * FROM md_visit WHERE status = 'selesai' AND selesai_user = 0");
		foreach($query->result() AS $isi){
			$tgl_baru = manipulate_time($isi->selesai_time,"days","2","+");    
			if($waktu > $tgl_baru){
				$data['selesai_user'] = 1;		
				$data['selesai_user_time'] = $waktu;
				$data['updated_at'] = $waktu;
				$this->update("md_visit",$data,"id_visit",$isi->id_visit);			
				$total = $isi->rate_layanan;		
				$jenis = "dokter";
				$id_users = $isi->id_dokter;		
				$this->set_income($jenis,$id_users,"visit",$isi->no_visit,$total);  
			}			
		}		
	}
	function send_otp($target, $text){
    $curl = curl_init();
    
    $data = [
        'phone' => $target,
        'type' => 'text',
        'delay' => 0,
        'delay_req' => 0,
        'text' => $text." \n\n\n Salam Sehat, \n\n Kei Medika"
    ];
    
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Authorization: 5oFLEcZGUfzPGW7iZrPp",
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://fonnte.com/api/send_message.php");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);
    
    return $result;
	}
	function send_gambar(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://fonnte.com/api/send_message.php",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => array('phone' => '6282376475617','type' => 'image','url' => 'https://i5.walmartimages.com/asr/b3873509-e1e1-431b-9a98-9bd12d59bd72_1.3109eaf9d125b1b19ab961b4f6afe2b9.jpeg','caption' => 'ini gambar apel','delay' => '1','delay_req' => '1','schedule' => '0'),
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: 5oFLEcZGUfzPGW7iZrPp"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
	function get_user($id_user){
    $nama="";$email="";$no_hp="";$bank="";$no_rek="";$nama_rek="";$jenis="";$foto="";$kode_referral="";
    $amb = $this->getByID("md_user","id_user",$id_user);    
    if($amb->num_rows() > 0){
    	$foto = $amb->row()->foto;
      if($amb->row()->jenis=='dokter'){
        $cek = $this->getByID("md_dokter","id_dokter",$amb->row()->id_dokter);
        $nama = ($cek->num_rows() > 0) ? $cek->row()->nama : "" ;                      
        $email = ($cek->num_rows() > 0) ? $cek->row()->email : "" ;                      
        $no_hp = ($cek->num_rows() > 0) ? $cek->row()->no_hp : "" ;                      
        $bank = ($cek->num_rows() > 0) ? $cek->row()->bank : "" ;                      
        $no_rek = ($cek->num_rows() > 0) ? $cek->row()->no_rek : "" ;                      
        $nama_rek = ($cek->num_rows() > 0) ? $cek->row()->nama_rek : "" ;                      
        $kode_referral = ($cek->num_rows() > 0) ? $cek->row()->kode_referral : "" ;                      
        $jenis = "dokter";
      }elseif($amb->row()->jenis=='karyawan'){
        $cek = $this->getByID("md_karyawan","id_karyawan",$amb->row()->id_karyawan);
        $nama = ($cek->num_rows() > 0) ? $cek->row()->nama_lengkap : "" ;                      
        $email = ($cek->num_rows() > 0) ? $cek->row()->email : "" ;                      
        $no_hp = ($cek->num_rows() > 0) ? $cek->row()->no_hp : "" ;                      
        $bank = ($cek->num_rows() > 0) ? $cek->row()->bank : "" ;                      
        $no_rek = ($cek->num_rows() > 0) ? $cek->row()->no_rek : "" ;                      
        $nama_rek = ($cek->num_rows() > 0) ? $cek->row()->nama_rek : "" ;                      
        $kode_referral = ($cek->num_rows() > 0) ? $cek->row()->kode_referral : "" ;                      
        $jenis = "karyawan";
      }elseif($amb->row()->jenis=='siswa'){        
        $nama = $amb->row()->nama_lengkap;
        $email = $amb->row()->email;
        $no_hp = $amb->row()->no_hp;
        $gambar = $amb->row()->no_hp;
        $bank="";$no_rek="";$nama_rek="";
        $jenis = "user";$kode_referral="";
      }
    }
    $result = [
      'nama' => $nama,
      'email' => $email,      
      'no_hp' => $no_hp,
      'no_rek' => $no_rek,
      'nama_rek' => $nama_rek,
      'bank' => $bank,
      'foto' => $foto,
      'jenis' => $jenis,
      'kode_referral' => $kode_referral
    ];
    return $result;
  }
  function format_hp($no){
  	if(substr($no,0,2)=='08'){
      $no = str_replace("08", "628" , $no);
    }elseif(substr($no, 0,1)=='8'){
      $no = "62".$no;
    }
    return $no;
  }

  function cek_status()
	{
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);				
		$tabel		= $this->tables;		
		$id_user 	= $this->session->userdata("id_user");
		$pk				= $this->pk;						
		$dt = $this->db->query("SELECT * FROM md_transaksi 
			WHERE payment_type <> '' AND status_code = 201");
		$no=0;
		foreach($dt->result() AS $row){
	    $status = $this->veritrans->status($row->no_faktur);                      
	    if(isset($status->status_code)){
	      $isi_mi = $status->status_code;
	      $data['status_code'] = $isi_mi;								
				if($isi_mi == 201){					
					$status_code = "Pending";
				}elseif($isi_mi == 200){			
					$data['status_bayar'] = 3;				
					$data['waktu_bayar'] = $status->transaction_time;				
					$data['updated_at'] 			= $waktu;
					$data['updated_by'] 			= $id_user;			
					$status_code = "Success";
					$this->konfirmasi($row->no_faktur);
				}elseif($isi_mi == 202){	
					$data['status_bayar'] = 0;								
					$status_code = "Failure";
				}elseif($isi_mi == 407){	
					$data['status_bayar'] = 0;								
					$status_code = "Expired";
				}else{
					$status_code = $isi_mi;
				}
				$this->m_admin->update("md_transaksi",$data,"no_faktur",$row->no_faktur);											
				$no++;
				$hasil = "success";						
	    }else{
	    	$hasil = "danger";						
	    }
	  }     
	  return $no;
	}
	public function cek_referral($kode){
		$nama="";$email="";$no_hp="";$jenis="";$poin=0;$id="";$diskon=0;
		if($kode!="" AND $kode!="-"){
			$kode = strtoupper($kode);
			$cek1 = $this->db->query("SELECT * FROM md_karyawan WHERE kode_referral = '$kode'");
			$cek2 = $this->db->query("SELECT * FROM md_dokter WHERE kode_referral = '$kode'");
			if($cek1->num_rows() > 0){			
	  		$id = $cek1->row()->id_karyawan;
	  		$nama = $cek1->row()->nama_lengkap;
	  		$email = $cek1->row()->email;
	  		$no_hp = $cek1->row()->no_hp;  		
	  		$jenis = "karyawan";
			}elseif($cek2->num_rows() > 0){
				$id = $cek2->row()->id_dokter;
				$nama = $cek2->row()->nama;
	  		$email = $cek2->row()->email;
	  		$no_hp = $cek2->row()->no_hp;
	  		$jenis = "dokter";  		
			}
			$cek3 = $this->m_admin->getByID("md_setting","id_setting",1)->row();
			$batas = $cek3->maks_refferal;
			$potongan = $cek3->potongan_refferal;			
			if($potongan>0 && $cek1->num_rows()>0 && $cek2->num_rows()>0){
				if($batas>0){
					$cek_chat = $this->db->query("SELECT count(id_chat) AS jum FROM md_chat WHERE kode_referral = '$kode' AND LEFT(tgl_order,7) = '$tgl'")->row()->jum;
					$cek_visit = $this->db->query("SELECT count(id_visit) AS jum FROM md_visit WHERE kode_referral = '$kode' AND LEFT(tgl_visit,7) = '$tgl'")->row()->jum;
					$cek_order = $this->db->query("SELECT count(id_order) AS jum FROM md_order WHERE kode_referral = '$kode' AND LEFT(tgl_order,7) = '$tgl'")->row()->jum;
					$total = $cek_chat + $cek_visit + $cek_order;
					if($total<$batas){
						$diskon = $potongan;	
					}else{
						$diskon = 0;
					}				
				}else{
					$diskon = $potongan;
				}
			}

		}
		
		$poin = $this->m_admin->getByID("md_setting","id_setting",1)->row()->poin_refferal;
		
  	    
  	$result = [
			'id' => $id,
			'nama' => $nama,
			'email' => $email,			
			'no_hp' => $no_hp,			
			'jenis' => $jenis,			
			'potongan' => $diskon,			
			'poin' => $poin			
		];
   	return $result;  	
  }
  public function rekapSaldo($no_order=null,$jenis_transaksi=null,$id_karyawan=null,$id_dokter=null,$bagian=null,$jenis=null){
  	$data['updated_at'] = waktu();
  	$data['jenis_transaksi'] = $jenis_transaksi;
  	$data['no_transaksi'] = $no_order;
  	$data['id_karyawan'] = $id_karyawan;
  	$data['id_dokter'] = $id_dokter;
  	$data['nominal'] = $bagian;
  	$data['jenis'] = $jenis;
  	$this->m_admin->insert("md_rekap_saldo",$data);

  	if(!is_null($id_karyawan)){
  		$this->db->query("UPDATE md_karyawan SET saldo = saldo + '$bagian' WHERE id_karyawan = '$id_karyawan'");
  	}

  	if(!is_null($id_dokter)){
  		$this->db->query("UPDATE md_dokter SET saldo = saldo + '$bagian' WHERE id_dokter = '$id_dokter'");
  	}
  }  
}	

?>
