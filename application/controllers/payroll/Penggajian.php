<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggajian extends CI_Controller {

	var $tables =   "md_penggajian";		
	var $page		=		"payroll/penggajian";
	var $file		=		"penggajian";
	var $pk     =   "id_penggajian";
	var $title  =   "Penggajian Transaksi";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Payroll</a></li>										
	<li class='breadcrumb-item active'><a href='payroll/penggajian'>Penggajian</a></li>										
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."acm1nt0ck0'>";
		}elseif($auth=='false'){		
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";		
		}else{								
			$this->load->view('back_template/header',$data);
			$this->load->view('back_template/aside');			
			$this->load->view($this->page);		
			$this->load->view('back_template/footer');
		}
	}
	
	public function index($history=null)
	{								
		$data['isi']    = $this->file;		
		$data['title']	= $this->title;	
		$data['bread']	= $this->bread;																													
		$data['set']		= "view";		
		$data['mode']		= "view";				
		$data['bln']		= "";				
		if(is_null($history)){ 
			$data['dt_penggajian'] = $this->m_admin->getByID("md_penggajian","status","input");
			$data['history'] = null;
		}else{
			$data['dt_penggajian'] = $this->m_admin->getByID("md_penggajian","status","approved");
			$data['history'] = $history;
		}
		$this->template($data);	
	}	
	public function cari_kode(){
		$tgl = date("Y-m");
		$q = $this->db->query("SELECT MAX(RIGHT(no_faktur,6)) AS kd_max FROM md_penggajian WHERE LEFT(created_at,7) = '$tgl' ORDER BY id_penggajian DESC LIMIT 0,1");		
		$kd = "";
		if($q->num_rows()>0){
			foreach($q->result() as $k){
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%06s", $tmp);
			}
		}else{
			$kd = "000001";
		}
		return date('dmy').$kd;
	}
	public function generate()
	{		
		$datas['history'] = null;
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);		
		$tgl 			= gmdate("Y-m-d", time()+60*60*7);		
		$tabel		= $this->tables;		
		$pk				= $this->pk;	
		$id_user = $this->session->id_user;
		$bln = $this->input->post("bln");
		// $cek_gaji = $this->db->query("SELECT * FROM md_penggajian WHERE bln = '$bln'");
		// if($cek_gaji->num_rows()>0){
		// 	$_SESSION['pesan'] 		= "Maaf, gaji bulan tsb sudah pernah digenerate!";
		// 	$_SESSION['tipe'] 		= "danger";						
		// 	echo "<script>history.go(-1);</script>";
		// }else{
			$cek_kary = $this->db->query("SELECT * FROM md_karyawan WHERE status = 1 
					AND id_karyawan NOT IN (SELECT id_karyawan FROM md_penggajian WHERE bln = '$bln') 
					ORDER BY id_karyawan ASC");
			foreach($cek_kary->result() AS $row){
				$cek_salary = $this->db->query("SELECT * FROM md_salary WHERE id_bagian = '$row->id_bagian'");
				if($cek_salary->num_rows()>0){
					$rw = $cek_salary->row();
					
					$data['created_at'] 		= $waktu;
					$data['id_karyawan'] 		= $row->id_karyawan;
					$data['no_faktur'] 		= $this->cari_kode();
					$data['bln'] 		= $bln;
					$data['tgl'] 		= $tgl;
					$data['gaji_pokok'] 		= $rw->gaji_pokok;
					$data['tunj_anak'] 		= $rw->tunj_anak;
					$data['tunj_istri'] 		= $rw->tunj_istri;
					$data['tunj_makan'] 		= $rw->tunj_makan;
					$data['tunj_transport'] 		= $rw->tunj_transport;
					$data['gaji_pokok'] 		= $rw->gaji_pokok;
					$data['pot_asuransi'] 		= $rw->pot_asuransi;					
					$data['total_gaji'] 		= ($rw->gaji_pokok+$rw->tunj_transport+$rw->tunj_makan+$rw->tunj_anak+$rw->tunj_istri)-$rw->pot_asuransi ;					
					$data['status'] 		= "input";
					$cek = $this->db->query("SELECT * FROM md_penggajian WHERE id_karyawan = '$row->id_karyawan'");
					if($cek->num_rows()>0){
						$this->m_admin->insert("md_penggajian",$data,"id_penggajian",$cek->row()->id_penggajian);
					}else{
						$this->m_admin->insert("md_penggajian",$data);
					}
				}
			}
			
			$_SESSION['pesan'] 		= "Berhasil Generate Data Gaji";
			$_SESSION['tipe'] 		= "success";						
			die();
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/penggajian'>";					
		// }
	}	
	public function review()
	{								
		$data['isi']    = $this->file;		
		$data['title']	= "Review ".$this->title;	
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= $this->input->get('id');																															
		$data['set']		= "insert";		
		$data['mode']		= "edit";		
		$data['dt_penggajian'] = $this->m_admin->getByID($tabel,$pk,$id);		
		$this->template($data);	
	}




	public function update()
	{								
		$submit = $this->input->post("submit");		
		$id = $this->input->post("id");
		
		$waktu 		= gmdate("Y-m-d H:i:s", time()+60*60*7);					
		$id_user = $this->session->id_user;

		if($submit=="approve"){			
			$data3['status'] = "approved";
			$data3['approved_at'] = $data3['updated_at'] = $waktu;
			$data3['approved_by'] = $data3['updated_by'] = $id_user;
			$data3['keterangan'] = $this->input->post("keterangan");						
			$_SESSION['pesan'] 		= "Penggajian berhasil di-approve";
		}elseif($submit=="reject"){
			$data3['status'] = "rejected";
			$data3['updated_at'] = $waktu;
			$data3['updated_by'] = $id_user;			
			$data3['keterangan'] = $this->input->post("keterangan");			
			$_SESSION['pesan'] 		= "Penggajian berhasil di-reject";
		}
		
		$this->m_admin->update("md_penggajian",$data3,"id_penggajian",$id);			
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/penggajian'>";					
		
	}
	public function deleteDetail()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');		
		$d 				= $this->input->get('d');		
		$this->m_admin->delete("md_penggajian_detail","id",$d);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/penggajian/review?id=".$id."'>";
	}
	public function delete()
	{		
		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= $this->input->get('id');				
		$this->m_admin->delete("md_penggajian","no_faktur",$id);
		$this->m_admin->delete("md_penggajian_detail","no_faktur",$id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/penggajian'>";
	}
	public function updateDetail(){		
		$id = $this->input->post("id");	
		$data3['no_faktur'] = $this->input->post("no_faktur");	
		$data3['jenis'] = $this->input->post("jenis");	
		$data3['uraian'] = $this->input->post("uraian");	
		$data3['nominal'] = $this->input->post("nominal");					
		
		$this->m_admin->insert("md_penggajian_detail",$data3);			
		$_SESSION['pesan'] 		= "Detail Penggajian berhasil ditambahkan";		
		$_SESSION['tipe'] 		= "success";						
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."payroll/penggajian/review?id=".$id."'>";
	}
	public function cetak()
	{						    
    if (ob_get_contents()) ob_clean();    
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 900);
		$mpdf = new \Mpdf\Mpdf();	
    $mpdf->allow_charset_conversion = true;  // Set by default to TRUE
    $mpdf->charset_in               = 'UTF-8';
    $mpdf->autoLangToFont           = true;      
    $data['set']                   	= 'download';                  
    $id = $this->input->get("id");
    $data['dt'] = $this->db->query("SELECT * FROM md_penggajian WHERE id_penggajian = '$id'");    
    $html = $this->load->view('payroll/penggajian', $data, true);    
    $mpdf->WriteHTML($html);
    //$mpdf->Output($row->nama.".pdf", "D");
    $mpdf->Output();    
    //$this->load->view('payroll/penggajian', $data);    
		
	}
}
