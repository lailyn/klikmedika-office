<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

	var $tables =   "dwigital_produk";
	var $page		=		"dwigital/produk/produk";
	var $file		=		"produk";
	var $pk     =   "id_produk";
	var $title  =   "Produk";
	var $bread	=   "<ol class='breadcrumb'>
	<li class='breadcrumb-item'><a>Master Produk</a></li>										
	<li class='breadcrumb-item active'><a href='dwigital/produk/produk'>Produk</a></li>										
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
		$this->load->model('m_produk');

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->page, $data['set']);
		if ($name == "") {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "adm1nb3rrk4h'>";
		} elseif ($auth == 'false') {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "denied'>";
		} else {
			$this->load->view('back_template/header', $data);
			$this->load->view('back_template/aside');
			$this->load->view($this->page);
			$this->load->view('back_template/footer');
		}
	}
	public function mata_uang($a)
	{
		if (is_numeric($a) and $a != 0 and $a != "") {
			return number_format($a, 0, ',', '.');
		} else {
			return $a;
		}
	}


	public function index($jenis = null)
	{
		$data['mode']		= "semua";
		if (!is_null($jenis)) {
			$data['mode']		= $jenis;
		}
		$data['isi']    = $this->file;
		$data['title']	= $this->title;
		$data['bread']	= $this->bread;
		$data['set']		= "view";
		if (!$this->session->userdata('loginStokProduk')) {
			$data['show_modal'] = true;
		} else {
			$data['show_modal'] = false;
		}
		$this->template($data);
	}

	public function add()
	{

		$data['isi']    = $this->file;
		$data['title']	= "Tambah " . $this->title;
		$data['bread']	= $this->bread;
		$data['dt_produk_kategori'] = $this->m_admin->getAll('dwigital_produk_kategori');
		$data['set']		= "insert";
		$data['mode']		= "insert";
		$this->template($data);
	}
	public function ajax_list()
	{
		$starts = (null !== $this->input->post("start")) ? $this->input->post("start") : 0;
		$length = (null !== $this->input->post("length")) ? $this->input->post("length") : 10;
		$LIMIT = "LIMIT $starts, $length ";
		$search = (null !== $this->input->post("search")["value"]) ? $this->input->post("search")["value"] : '';
		$orders = isset($_POST["order"]) ? $_POST["order"] : '';

		$where = "WHERE 1=1 ";
		$where_limit = "WHERE 1=1 ";

		$result = array();

		if (isset($search)) {
			if ($search != '') {
				$where .= " AND (dwigital_produk.kode_produk LIKE '%$search%' OR dwigital_produk.nama_produk LIKE '%$search%') ";
				$where_limit .= " AND (dwigital_produk.kode_produk LIKE '%$search%' OR dwigital_produk.nama_produk LIKE '%$search%') ";
			}
		}

		if (isset($orders)) {
			if ($orders != '') {
				$order = $orders;
				$order_column = ['dwigital_produk.id_produk', 'dwigital_produk.nama_produk', 'dwigital_produk.harga', 'dwigital_produk.stok'];
				$order_clm = $order_column[$order[0]['column']];
				$order_by = $order[0]['dir'];
				// $order_by = "DESC";
				$where .= " ORDER BY $order_clm $order_by ";
			} else {
				$where .= " ORDER BY dwigital_produk.nama_produk ASC ";
			}
		} else {
			$where .= " ORDER BY dwigital_produk.nama_produk ASC ";
		}

		if (isset($LIMIT)) {
			if ($LIMIT != '') {
				$where .= ' ' . $LIMIT;
			}
		}

		$sql = "SELECT dwigital_produk.*, dwigital_produk_kategori.nama nama_kategori FROM dwigital_produk JOIN dwigital_produk_kategori ON dwigital_produk.id_produk_kategori = dwigital_produk_kategori.id ";

		$index = 1;
		$fetch_record_filtered = $this->db->query($sql . $where);

		$fetch_all = $this->db->query($sql . $where_limit);

		foreach ($fetch_record_filtered->result() as $rows) {


			$id = encrypt_url($rows->id_produk);


			if (!isset($rows->gambar) and $rows->gambar == "") {
				$gambar = "produk.png";
			} else {
				$gambar = $rows->gambar;
			}

			$cekStok = cekStokDwigital($rows->id_produk);


			$sub_array = array();
			$sub_array[] = $index;
			$sub_array[] = "<a href='dwigital/produk/detail?id=$id'>$rows->nama_produk </a>";
			$sub_array[] = $rows->kode_produk;
			$sub_array[] = $rows->nama_kategori;
			$sub_array[] = $cekStok;
			$sub_array[] = $rows->sat_kecil;
			$sub_array[] = mata_uang_help($rows->harga_beli);
			$sub_array[] = mata_uang_help($rows->harga);
			$sub_array[] = $rows->keterangan;
			$sub_array[] = "
						<div class='btn-group'>
			  <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
			  <div class='dropdown-menu'>
				<a href=\"dwigital/produk/delete?id=$id\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
				<a href=\"dwigital/produk/edit?id=$id\" class='dropdown-item'>Edit</a>                
			  </div>
			</div>";
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
	public function import()
	{

		$data['isi']    = $this->file;
		$data['title']	= "Import " . $this->title;
		$data['bread']	= $this->bread;
		$data['set']		= "insert";
		$data['mode']		= "import";
		$this->template($data);
	}
	public function download()
	{
		$this->load->view('master/template_produk');
	}
	public function importExcel()
	{
		$id_user = $this->session->userdata("id_user");

		$config = $this->m_admin->set_upload_options('./excel/', 'xlsx', '10000');
		$err = "";
		if (!empty($_FILES['file']['name'])) {
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				$err = $this->upload->display_errors();
				$_SESSION['pesan'] 		= $err;
				$_SESSION['tipe'] 		= "danger";
				echo "<script>history.go(-1)</script>";
				exit();
			} else {
				$err = "";
				$data['file'] = $fileName = $this->upload->file_name;
			}


			$file_excel = './excel/' . $fileName;

			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $render->load($file_excel);

			$data = $spreadsheet->getActiveSheet()->toArray();
			// echo json_encode($data);die();
			foreach ($data as $x => $rowData) {
				if ($x == 0) {
					continue;
				}


				$simpandata = [
					"kode_produk" => (!empty($rowData[0])) ? $rowData[0] : '',
					"nama_produk" => (!empty($rowData[1])) ? $rowData[1] : '',
					"id_produk_kategori" => (!empty($rowData[2])) ? $rowData[2] : '',
					"sat_kecil" => (!empty($rowData[3])) ? $rowData[3] : '',
					"kapasitas" => (!empty($rowData[4])) ? $rowData[4] : '',
					"harga_beli" => (!empty($rowData[5])) ? intval($rowData[5]) : '',
					"harga" => (!empty($rowData[6])) ? intval($rowData[6]) : '',
					"stok" => (!empty($rowData[7])) ? $rowData[7] : '',
					"margin" => (!empty($rowData[8])) ? $rowData[8] : '',
					"supplier" => (!empty($rowData[9])) ? $rowData[9] : '',
					"keterangan" => (!empty($rowData[10])) ? $rowData[10] : '',
					"created_at" => waktu(),
					"created_by" => $id_user,
					"status" => 1
				];


				$this->m_admin->insert('dwigital_produk', $simpandata);
				$id_produk = $this->db->insert_id();
				if ($rowData[7] > 0) {
					$this->m_admin->updateStock($id_produk, $rowData[7], "+", "import", "import");
				}
			}
		}

		$_SESSION['pesan'] 		= "Data berhasil import";
		$_SESSION['tipe'] 		= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/produk'>";
	}
	public function delete()
	{

		$tabel			= $this->tables;
		$pk 				= $this->pk;
		$id 				= decrypt_url($this->input->get('id'));
		$this->m_admin->delete($tabel, $pk, $id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/produk'>";
	}
	public function save()
	{
		$waktu 		= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$tabel		= $this->tables;
		$pk				= $this->pk;
		$id_user = $this->session->userdata("id_user");


		$config = $this->m_admin->set_upload_options('./assets/pr0duk/', 'jpg|png|jpeg', '1000');
		$err = "";
		if (!empty($_FILES['foto']['name'])) {
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('foto')) {
				$err = $this->upload->display_errors();
			} else {
				$err = "";
				$data['foto'] = $this->upload->file_name;
			}
		}

		$data['kode_produk'] 			= $this->input->post('kode_produk');
		$data['nama_produk'] 			= $this->input->post('nama_produk');
		$data['sat_kecil'] 			= $this->input->post('sat_kecil');
		$data['id_produk_kategori'] 			= $this->input->post('id_produk_kategori');
		$data['harga'] 			= str_replace(",", "", $this->input->post('harga_1'));
		$data['harga_beli'] 			= str_replace(",", "", $this->input->post('harga_beli'));
		$data['supplier'] 			= $this->input->post('supplier');
		$data['status'] 			= $this->input->post('status');
		$data['stok'] = $stok 		= $this->input->post('stok');
		$data['keterangan'] 			= $this->input->post('keterangan');
		$data['kapasitas'] 			= $this->input->post('kapasitas');
		$data['created_at'] 			= $waktu;
		$data['created_by'] 			= $id_user;



		if ($err == "") {
			$this->m_admin->insert($tabel, $data);

			$_SESSION['pesan'] 		= "Data berhasil disimpan";
			$_SESSION['tipe'] 		= "success";

			$id_produk = $this->db->insert_id();

			$keterangan = "updateStockAwal " . waktu();
			if ($stok > 0) $this->m_admin->updateStock($id_produk, $stok, $stok, $id_klinik, "+", $keterangan, "stokAwal", tgl(), $keterangan, $noBatch, $expDate);

			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/produk'>";
		} else {
			$_SESSION['pesan'] 		= "Data gagal disimpan " . $err;
			$_SESSION['tipe'] 		= "danger";
			echo "<script>history.go(-1)</script>";
		}
	}
	public function update()
	{
		$waktu 		= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$tabel		= $this->tables;
		$pk				= $this->pk;
		$id 	= $this->input->post('id');
		$id_user = $this->session->userdata("id_user");

		$id 			= $this->input->post('id');
		$config = $this->m_admin->set_upload_options('./assets/pr0duk/', 'jpg|png|jpeg', '1000');
		$row = $this->m_admin->getByID("dwigital_produk", "id_produk", $id)->row();

		$err = "";
		if (!empty($_FILES['gambar']['name'])) {
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$err = $this->upload->display_errors();
			} else {
				$err = "";
				if (isset($row->gambar)) {
					unlink('assets/pr0duk/' . $row->gambar);
				}
				$data['gambar'] = $this->upload->file_name;
			}
		}


		$data['kode_produk'] 			= $this->input->post('kode_produk');
		$data['nama_produk'] 			= $this->input->post('nama_produk');
		$data['supplier'] 			= $this->input->post('supplier');
		$data['sat_kecil'] 			= $this->input->post('sat_kecil');
		$data['id_produk_kategori'] 			= $this->input->post('id_produk_kategori');
		$data['harga'] 			= str_replace(",", "", $this->input->post('harga_1'));
		$data['harga_beli'] 			= str_replace(",", "", $this->input->post('harga_beli'));
		$data['kapasitas'] 			= $this->input->post('kapasitas');
		$data['status'] 			= $this->input->post('status');
		$data['stok'] 		= $stok	= $this->input->post('stok');
		$data['keterangan'] 			= $this->input->post('keterangan');
		$data['updated_at'] 			= $waktu;
		$data['updated_by'] 			= $id_user;

		if ($err == "") {
			$this->m_admin->update($tabel, $data, $pk, $id);

			$_SESSION['pesan'] 		= "Data berhasil diubah";
			$_SESSION['tipe'] 		= "success";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/produk'>";

			$keterangan = "updateStockAwal " . waktu();
			if ($stok > 0) $this->m_admin->updateStock($id, $stok, $stok, "+", $keterangan, "stokAwal", tgl(), $keterangan);
		} else {
			$_SESSION['pesan'] 		= "Data gagal disimpan " . $err;
			$_SESSION['tipe'] 		= "danger";
			echo "<script>history.go(-1)</script>";
		}
	}
	public function edit()
	{

		$data['isi']    = $this->file;
		$data['title']	= "Ubah " . $this->title;
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= decrypt_url($this->input->get('id'));
		$data['set']		= "insert";
		$data['mode']		= "edit";
		$data['dt_produk_kategori'] = $this->m_admin->getAll('dwigital_produk_kategori');
		$data['dt_produk'] = $this->m_admin->getByID($tabel, $pk, $id);
		$this->template($data);
	}
	public function detail()
	{
		$data['isi']    = $this->file;
		$data['title']	= "Detail " . $this->title;
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$id 		= decrypt_url($this->input->get('id'));
		$data['set']		= "insert";
		$data['dt_produk_kategori'] = $this->m_admin->getAll('dwigital_produk_kategori');
		$data['dt_produk'] = $this->m_admin->getByID($tabel, $pk, $id);
		$data['mode']		= "detail";
		$this->template($data);
	}
	public function resetStok($id)
	{
		$no = 1;
		$cek = $this->m_admin->getByID("dwigital_produk", "id_klinik", $id);
		foreach ($cek->result() as $rt) {
			$cekStok = cekStok($rt->id_produk);
			if ($cekStok == 0) {
				$ref = "import" . date("Ymd");
				$this->m_admin->updateStock($rt->id_produk, $rt->stok, $id, "+", $ref, "import");
				$no++;
			}
		}
		echo $no;
	}
}
