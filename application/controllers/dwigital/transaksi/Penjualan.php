<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

	var $tables =   "dwigital_cart";
	var $page		=		"dwigital/transaksi/penjualan";
	var $file		=		"penjualan";
	var $pk     =   "id_cart";
	var $title  =   "Point of Sales (POS)";
	var $bread	=   "<ol class='breadcrumb'>	
	<li class='breadcrumb-item active'><a href='dwigital/transaksi/penjualan'>Point of Sales (POS)</a></li>										
	</ol>";


	public function __construct()
	{
		parent::__construct();
		//---- cek session -------//		

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url', 'string');
		$this->load->helper('permalink_helper');
		//===== Load Model =====
		$this->load->model('m_admin');
		$this->load->model('m_produk');
		$this->load->model('m_penjualan');

		//===== Load Library =====
		$this->load->library('upload');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if ($data['set'] == 'delete' or $data['set'] == 'edit' or $data['set'] == 'view') $set = $data['set'];
		else $set = "insert";
		$auth = $this->m_admin->user_auth($this->page, $set);
		if ($name == "") {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "adm1nb3rrk4h'>";
		} elseif ($auth == 'false') {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "denied'>";
		} else {
			$data['page'] = $this->page;
			$this->load->view('back_template/header', $data);
			$this->load->view('back_template/aside');
			$this->load->view($this->page);
			$this->load->view('back_template/footer');
		}
	}

	public function index()
	{
		$data['file']  = $data['isi'] = $this->file;
		$data['title'] = $this->title;
		$data['bread'] = $this->bread;
		$data['set']   = "view";
		$data['mode']  = "view";

		$sql = "
			SELECT 
				c.*,
				COALESCE(p.nama, '-') AS platform,
				COALESCE(u.nama_lengkap, 'Walk in Customer') AS customer
			FROM dwigital_cart c
			LEFT JOIN dwigital_platform p ON p.id = c.id_platform
			LEFT JOIN md_user u ON u.id_user = c.id_user
			WHERE (c.status <> 'batal' AND c.status <> 'selesai')
			ORDER BY c.id_cart DESC
		";

		$data['dt_penjualan'] = $this->db->query($sql);

		$this->template($data);
	}





	public function riwayat()
	{

		$data['file'] = $data['isi']    = $this->file;
		$data['title']	= $this->title;
		$data['bread']	= $this->bread;
		$data['set']		= "riwayat";
		$data['mode']		= "riwayat";
		$where = "";
		$data['dt_penjualan'] = $this->db->query("SELECT * FROM dwigital_cart WHERE (status = 'batal' OR status = 'selesai' OR status_bayar = 3) $where ORDER BY id_cart DESC");
		$this->template($data);
	}
	public function cetakStruk($kode)
	{
		$waktu 		= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		// ob_clean();
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 900);
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->allow_charset_conversion = true;  // Set by default to TRUE
		$mpdf->charset_in               = 'UTF-8';
		$mpdf->autoLangToFont           = true;

		$data['id'] = $id 		= decrypt_url($kode);
		$data['set']	= "cetak";
		$data['jenis'] = "change";
		$data['setting'] = $this->m_admin->getByID("md_setting", "id_setting", 1)->row();
		$data['order'] = $this->db->query("SELECT dwigital_cart.*,md_user.nama_lengkap,md_user.no_hp FROM dwigital_cart
			LEFT JOIN md_user ON dwigital_cart.id_user = md_user.id_user
			WHERE dwigital_cart.no_faktur = '$id'");
		// $this->load->view('transaksi/cetak_struk', $data);
		$html = $this->load->view('dwigital/transaksi/cetak_struk', $data, true);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
	public function ajax_resepK()
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
				$where .= " AND (dwigital_produk.kode_produk LIKE '%$search%' OR dwigital_produk.nama_produk LIKE '%$search%' OR dwigital_produk.lokasi LIKE '%$search%') ";
				$where_limit .= " AND (dwigital_produk.kode_produk LIKE '%$search%' OR dwigital_produk.nama_produk LIKE '%$search%' OR dwigital_produk.lokasi LIKE '%$search%') ";
			}
		}

		if (isset($orders)) {
			if ($orders != '') {
				$order = $orders;
				$order_column = ['dwigital_produk.id_produk', 'dwigital_produk.nama_produk', 'dwigital_produk.harga', 'dwigital_produk.stok'];
				$order_clm = $order_column[$order[0]['column']];
				// $order_by = $order[0]['dir'];
				$order_by = "DESC";
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

		$sql = "SELECT * FROM dwigital_produk ";


		$index = 1;
		$fetch_record_filtered = $this->db->query($sql . $where);

		$fetch_all = $this->db->query($sql . $where_limit);
		$setting = $this->m_admin->getByID("md_setting", "id_setting", id_setting())->row();
		foreach ($fetch_record_filtered->result() as $rows) {

			$noReg = ($this->input->post("noReg") != 'add') ? $this->input->post("noReg") : '';


			$cekStok = cekStokDwigital($rows->id_produk);

			$stock = "";
			if ($setting->stok_produk == 1) {
				$cekStok = cekStokDwigital($rows->id_produk);
				// if ($cekStok > 0) {
				// 	$stock = "<label class='badge badge-info'>sisa $cekStok</label>";
				// 	$tombol = "<a href=\"dwigital/transaksi/penjualan/saveProduk/$rows->id_produk/$noReg\" class='btn btn-sm btn-warning'>Pilih ($cekStok)</a>";
				// } else {
				// 	$tombol = "<a onclick=\"return confirm('Silakan re-stock terlebih dulu!')\" class='btn btn-sm btn-danger'>Kosong</a>";
				// }
			} else {
				$tombol = "<a href=\"dwigital/transaksi/penjualan/saveProduk/$rows->id_produk/$noReg\" class='btn btn-sm btn-warning'>Pilih</a>";
			}

			$sub_array = array();
			$sub_array[] = $index;
			$sub_array[] = $rows->kode_produk;
			$sub_array[] = $rows->nama_produk;
			$sub_array[] = $rows->sat_kecil;
			$sub_array[] = $rows->id_produk_kategori;
			$sub_array[] = mata_uang_help($rows->harga);
			$sub_array[] = $tombol;
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
	public function ajax_resepK_old()
	{
		$list = $this->m_produk->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$setting = $this->m_admin->getByID("md_setting", "id_setting", id_setting())->row();
		foreach ($list as $isi) {
			$noReg = ($_POST['noReg'] != 'add') ? $_POST['noReg'] : '';

			$stock = "";
			if ($setting->stok_produk == 1) {
				// $cekStok = cekStokDwigital($isi->id_produk);
				// if ($cekStok > 0) {
				// 	$stock = "<label class='badge badge-info'>sisa $cekStok</label>";
				// 	$tombol = "<a href=\"dwigital/transaksi/penjualan/saveProduk/$isi->id_produk/$noReg\" class='btn btn-sm btn-warning'>Pilih ($cekStok)</a>";
				// } else {
				// 	$tombol = "<a onclick=\"return confirm('Silakan re-stock terlebih dulu!')\" class='btn btn-sm btn-danger'>Kosong</a>";
				// }
			} else {
				$tombol = "<a href=\"dwigital/transaksi/penjualan/saveProduk/$isi->id_produk/$noReg\" class='btn btn-sm btn-warning'>Pilih</a>";
			}


			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $isi->kode_produk;
			$row[] = $isi->nama_produk;
			$row[] = $isi->sat_kecil;
			$row[] = $isi->id_produk_kategori;
			$row[] = mata_uang_help($isi->harga);
			$row[] = $tombol;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_produk->count_all(),
			"recordsFiltered" => $this->m_produk->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function insertCart()
	{
		extract($this->input->post());
		$no_faktur_dec = decrypt_url($no_faktur);
		$id_produk = explode(':', decrypt_url($id))[0];
		$qty = 1;
		$mode = 'insert';

		$this->db->where("id_produk", $id_produk);
		$produk = $this->db->get('dwigital_produk')->row();
		if ($produk == null) {
			send_json(['status' => 0, 'message' => 'Produk tidak ditemukan']);
		}

		if ($no_faktur != '') {
			$filter = [
				'no_faktur' => $no_faktur_dec,
			];
			$cek_cart = $this->m_penjualan->getDetailCartHold($filter, 'row');
		} else {
			$filter = [
				'updated_by' => $this->session->id_user,
				'id_produk' => $id_produk
			];
			$cek_cart = $this->m_penjualan->getDetailCartBelumSelesai($filter, 'row');
		}
		if ($cek_cart != null) {
			$mode = 'update';
			$qty = $cek_cart->qty + 1;
		}

		$cekStok = cekStokDwigital($produk->id_produk);
		if ($cekStok < $qty) {
			// send_json(['status' => 0, 'message' => 'Stok tidak mencukupi. Stok tersedia : ' . $cekStok]);
		}

		if ((string)$produk->sat_kecil != '') {
			$satuan = $produk->sat_kecil;
		} elseif ((string)$produk->sat_sedang != '') {
			$satuan = $produk->sat_sedang;
		} elseif ((string)$produk->sat_besar != '') {
			$satuan = $produk->sat_besar;
		}

		if ($mode == 'insert') {
			$insert = [
				'nama_produk' => $produk->nama_produk,
				'kode_produk' => $produk->kode_produk,
				'harga' => $produk->harga,
				'satuan' => $satuan,
				'id_produk' => $produk->id_produk,
				'qty' => 1,
				'status' => 0,
				'updated_at' => waktu(),
				'updated_by' => $this->session->id_user,
			];
			if ($no_faktur != '') {
				$insert['no_faktur'] = $no_faktur_dec;
				$insert['status'] = 2;
			}
			$this->db->insert('dwigital_cart_detail', $insert);
		} else {
			$this->db->update('dwigital_cart_detail', ['qty' => $qty], ['id' => $cek_cart->id]);
		}
		if ($no_faktur != '') {
			$filter = [
				'no_faktur' => $no_faktur_dec,
			];
			$list_cart = $this->m_penjualan->getDetailCartHold($filter);
		} else {
			$list_cart = $this->_getDetailCartBelumSelesai();
		}
		send_json(['status' => 1, 'message' => 'Produk berhasil ditambahkan', 'data' => $list_cart]);
	}

	function updateCart()
	{
		extract($this->input->post());
		$id_produk = explode(':', decrypt_url($id))[0];
		$no_faktur_dec = decrypt_url($no_faktur);
		if ($no_faktur != '') {
			$filter = [
				'no_faktur' => $no_faktur,
			];
			$data['list_cart'] = $this->m_penjualan->getDetailCartHold($filter);
		} else {
			$list_cart = $this->_getDetailCartBelumSelesai();
		}

		$this->db->where("id_produk", $id_produk);
		$produk = $this->db->get('dwigital_produk')->row();
		if ($produk == null) {
			send_json(
				['status' => 0, 'message' => 'Produk tidak ditemukan', 'data' => $list_cart]
			);
		}

		if ($no_faktur != '') {
			$filter_update = ['id_produk' => $id_produk, 'status' => 2, 'no_faktur' => $no_faktur_dec];
		} else {
			$filter_update = ['id_produk' => $id_produk, 'status' => 0, 'updated_by' => $this->session->id_user];
		}

		if (isset($qty)) {
			$cekStok = cekStokDwigital($produk->id_produk);
			if ($cekStok < (int)$qty) {
				// send_json([
				// 	'status' => 0,
				// 	'message' => 'Stok tidak mencukupi. Stok tersedia : ' . $cekStok,
				// 	'data' => $list_cart
				// ]);
			}
			if ($qty < 1) {
				$qty = 1;
			}
			$this->db->update(
				'dwigital_cart_detail',
				[
					'qty' => $qty,
					'updated_at' => waktu(),
				],
				$filter_update
			);
		}

		if (isset($hapus)) {
			$this->db->delete('dwigital_cart_detail', $filter_update);
		}

		if (isset($diskon)) {
			$this->db->update(
				'dwigital_cart_detail',
				['diskon' => $diskon, 'updated_at' => waktu()],
				$filter_update
			);
		}

		if (isset($harga)) {
			$this->db->update(
				'dwigital_cart_detail',
				['harga' => $harga, 'updated_at' => waktu()],
				$filter_update
			);
		}

		if ($no_faktur != '') {
			$filter = [
				'no_faktur' => $no_faktur_dec,
			];
			$list_cart = $this->m_penjualan->getDetailCartHold($filter);
		} else {
			$list_cart = $this->_getDetailCartBelumSelesai();
		}
		send_json(['status' => 1, 'message' => 'Produk berhasil diubah', 'data' => $list_cart]);
	}

	function _getDetailCartBelumSelesai()
	{
		$filter = [
			'updated_by' => $this->session->id_user,
		];
		return $this->m_penjualan->getDetailCartBelumSelesai($filter);
	}

	public function get_faktur($tgl = '')
	{
		if ($tgl == '') {
			$tgl = date("Y-m");
		}
		$rd = rand(11, 99);
		$q = $this->db->query("SELECT MAX(RIGHT(no_faktur,6)) AS kd_max FROM dwigital_cart WHERE LEFT(created_at,7) = '$tgl' ORDER BY id_cart DESC LIMIT 0,1");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%06s", $tmp);
			}
		} else {
			$kd = "000001";
		}
		return $rd . date('my') . $kd;
	}

	public function get_faktur_hold()
	{
		$tgl = date("Y-m");
		$rd = rand(11, 99);
		$q = $this->db->query("SELECT MAX(RIGHT(no_faktur,6)) AS kd_max FROM dwigital_cart WHERE LEFT(created_at,7) = '$tgl' AND status = 'hold' ORDER BY id_cart DESC LIMIT 0,1");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int)$k->kd_max) + 1;
				$kd = sprintf("%06s", $tmp);
			}
		} else {
			$kd = "000001";
		}
		return "H" . $rd . date('my') . $kd;
	}

	public function simpanPenjualan()
	{
		$id_user               = $this->session->id_user;
		$data['tgl']           = $tgl = $this->input->post("tgl");
		$data['id_user']       = $id = $this->input->post("id_user");
		$data['catatan']       = $this->input->post("catatan");
		$data['payment_type']  = $this->input->post("payment_type");
		$data['nominal']       = preg_replace("/[^0-9]/", "", $this->input->post("nominal"));
		$data['kembalian']     = preg_replace("/[^0-9]/", "", $this->input->post("kembalian"));
		$data['status']        = "selesai";
		$data['status_bayar']  = 2;
		$data['created_at']    = waktu();
		$data['created_by']    = $id_user;
		$data['no_faktur']     = $no_faktur = $this->get_faktur();
		$data['id_platform']   = $this->input->post("id_platform");
		$data['durasi_langganan'] = $this->input->post("durasi_langganan");
		$data['phone']         = $this->input->post("phone");

		$no_faktur_en  = $this->input->post("no_faktur");
		$no_faktur_dec = decrypt_url((string)$no_faktur_en);

		if ($no_faktur_en != '') {
			$filter = [
				'no_faktur' => $no_faktur_dec,
			];
			$list_cart = $this->m_penjualan->getDetailCartHold($filter);
		} else {
			$list_cart = $this->_getDetailCartBelumSelesai();
		}

		// Hitung total + kumpulkan id_produk
		$total = 0;
		$id_produk_list = [];
		foreach ($list_cart as $item) {
			$total += $item['subtotal'];
			$id_produk_list[] = $item['id_produk'];
		}
		$data['total']     = $total;
		$data['id_produk'] = !empty($id_produk_list) ? implode(',', $id_produk_list) : null;

		// Simpan transaksi
		if ((string)$no_faktur_en != '') {
			// update hold
			$this->m_admin->update("dwigital_cart", $data, "no_faktur", $no_faktur_dec);
			$this->db->update(
				"dwigital_cart_detail",
				['no_faktur' => $no_faktur, 'id_user' => $id, 'status' => 1],
				['no_faktur' => $no_faktur_dec, 'updated_by' => $id_user]
			);
		} else {
			// new
			$this->m_admin->insert("dwigital_cart", $data);
			$this->db->update(
				"dwigital_cart_detail",
				['no_faktur' => $no_faktur, 'id_user' => $id, 'status' => 1],
				['status' => 0, 'updated_by' => $id_user]
			);
		}

		// Update stok (opsional)
		$cekDetail = $this->m_admin->getByID("dwigital_cart_detail", "no_faktur", $no_faktur);
		foreach ($cekDetail->result() as $amb) {
			$keterangan = "Penjualan POS";
			// $cekStok = $this->m_admin->getByID("dwigital_produk_real_stock", "id_produk", $amb->id_produk)->row()->stock - $amb->qty;
			// $this->m_admin->updateStockDwigital($amb->id_produk, $amb->qty, $cekStok, "-", $no_faktur, "restock", $tgl, $keterangan);
		}

		$_SESSION['pesan'] = "Transaksi berhasil disimpan";
		$_SESSION['tipe']  = "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan'>";
	}


	public function batal()
	{
		$id_user = $this->session->id_user;
		$this->db->query("DELETE FROM dwigital_cart_detail WHERE updated_by = '$id_user' AND status = 0");
		$_SESSION['pesan'] 		= "Transaksi berhasil dibatalkan";
		$_SESSION['tipe'] 		= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan'>";
	}

	public function hold()
	{
		$session_user_id = $this->session->id_user;

		// nomor faktur hold
		$data['no_faktur'] = $no_faktur = $this->get_faktur_hold();

		// tanggal
		$data['tgl'] = tgl();

		// ambil nilai dari form
		$id_user_selected     = $this->input->post("id_user");
		$id_platform_selected = $this->input->post("id_platform");

		// set field cart
		$data['id_user']      = $id_user_selected;
		$data['id_platform']  = $id_platform_selected;  // <-- SAMA SEPERTI DI RIWAYAT
		$data['total']        = 0;
		$data['catatan']      = "";
		$data['payment_type'] = "";
		$data['nominal']      = 0;
		$data['kembalian']    = 0;
		$data['status']       = "hold";
		$data['status_bayar'] = 0;
		$data['created_at']   = waktu();

		// simpan header cart (status hold)
		$this->m_admin->insert("dwigital_cart", $data);

		// pindahkan detail yg masih "draft" (status=0) ke faktur hold ini
		$this->db->update(
			"dwigital_cart_detail",
			[
				'no_faktur' => $no_faktur,
				'id_user'   => $id_user_selected,
				'status'    => 2,              // 2 = item sudah di-hold
				'updated_at' => waktu()
			],
			[
				'status'     => 0,
				'updated_by' => $session_user_id
			]
		);

		$_SESSION['pesan'] = "Transaksi berhasil ditahan";
		$_SESSION['tipe']  = "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan/add'>";
	}


	public function delete($id)
	{


		$id 				= decrypt_url($id);
		$this->m_admin->delete("dwigital_cart", "no_faktur", $id);
		$this->m_admin->delete("dwigital_cart_detail", "no_faktur", $id);
		$_SESSION['pesan'] 	= "Data berhasil dihapus";
		$_SESSION['tipe'] 	= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan'>";
	}

	public function detail()
	{
		$data['isi']    = $this->file;
		$data['title']	= "Detail " . $this->title;
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$data['id'] = $id 		= decrypt_url($this->uri->segment(5));
		$data['set']		= "detail";
		$data['mode']		= "edit";
		$data['dt_penjualan'] = $this->db->query("SELECT dwigital_cart.*,md_user.nama_lengkap,md_user.no_hp
			FROM dwigital_cart
			LEFT JOIN md_user ON dwigital_cart.id_user = md_user.id_user
			WHERE dwigital_cart.no_faktur = '$id'");
		$this->template($data);
	}

	public function edit()
	{

		$data['isi']    = $this->file;
		$data['title']	= "Edit " . $this->title;
		$data['bread']	= $this->bread;
		$tabel	= $this->tables;
		$pk			= $this->pk;
		$data['id'] = $id 		= decrypt_url($this->uri->segment(5));
		$data['set']		= "form";
		$data['mode']		= "edit";
		$row = $this->db->query("SELECT dwigital_cart.*,md_user.nama_lengkap,md_user.no_hp FROM dwigital_cart
			LEFT JOIN md_user ON dwigital_cart.id_user = md_user.id_user
			WHERE dwigital_cart.no_faktur = '$id'");

		if ($row->num_rows() == 0) {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan'>";
		}
		$data['row'] = $row->row();
		$filter = [
			'no_faktur' => $id,
		];
		$data['list_cart'] = $this->m_penjualan->getDetailCartHold($filter);
		$this->template($data);
	}

	public function add()
	{

		$data['isi']    = $this->file;
		$data['title']	= "Detail " . $this->title;
		$data['bread']	= $this->bread;
		$data['set']		= "form";
		$data['mode']		= "insert";
		$data['list_cart'] = $this->_getDetailCartBelumSelesai();
		$this->template($data);
	}

	public function save_status()
	{
		$waktu 		= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$tabel		= $this->tables;
		$pk				= $this->pk;

		$id = $this->input->post("id_cart");
		$submit = $this->input->post("submit");
		$id_cart = encrypt_url($id);
		$row = $this->m_admin->getByID("dwigital_cart", "id_cart", $id)->row();
		$data['updated_at'] 			= $waktu;
		if ($submit == 'dikirim') {
			$data['status'] 			= "dikirim";
		} elseif ($submit == 'selesai') {
			$data['status'] 			= "selesai";
		} elseif ($submit == 'batal') {
			$data['status'] 			= "batal";
		}
		$this->m_admin->update($tabel, $data, $pk, $id);

		$_SESSION['pesan'] 		= "Status penjualan berhasil diubah";
		$_SESSION['tipe'] 		= "success";
		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan/status/" . $id_cart . "'>";
	}

	public function fetchRiwayat()
	{
		// ambil data page
		$fetch_data = $this->_makeQueryRiwayat();

		$data = [];
		$no   = ((int)$this->input->post('start')) + 1;

		foreach ($fetch_data->result() as $rs) {
			$id_enc     = encrypt_url($rs->no_faktur);
			$link_edit  = "dwigital/transaksi/penjualan/edit/{$id_enc}";
			$link_cetak = "dwigital/transaksi/penjualan/cetakStruk/{$id_enc}";

			// --- AMBIL NAMA PRODUK (prioritas pakai snapshot di detail) ---
			$produk_row = $this->db->select("
				GROUP_CONCAT(
				DISTINCT COALESCE(
					NULLIF(TRIM(d.nama_produk), ''),   /* pakai nama saat transaksi */
					p.nama_produk                      /* fallback ke master bila kosong */
				)
				ORDER BY COALESCE(
					NULLIF(TRIM(d.nama_produk), ''), 
					p.nama_produk
				) SEPARATOR ', '
				) AS produk
			", false)
				->from('dwigital_cart_detail d')
				->join('dwigital_produk p', 'p.id_produk = d.id_produk', 'left')
				->where('d.no_faktur', $rs->no_faktur)
				->get()
				->row();

			$produk_list = $produk_row ? ($produk_row->produk ?: '-') : '-';
			// --------------------------------------------------------------

			$button = "
			<div class='btn-group'>
			<button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
			<div class='dropdown-menu'>
				<a href=\"{$link_edit}\" class='dropdown-item'>Edit</a>
				<a target='_blank' href=\"{$link_cetak}\" class='dropdown-item'>Cetak</a>
			</div>
			</div>";

			// URUTAN KOLOM HARUS SAMA DENGAN <thead> DI VIEW
			$row = [];
			$row[] = $no;
			$row[] = "<a>{$rs->no_faktur}</a>";
			$row[] = tgl_indo($rs->tgl);
			$row[] = $rs->customer;
			$row[] = $produk_list;                 // kolom PRODUK
			$row[] = $rs->platform;
			$row[] = $rs->catatan;
			$row[] = $rs->phone;
			$row[] = $rs->durasi_langganan;
			$row[] = mata_uang_help($rs->total);
			$row[] = $button;

			$data[] = $row;
			$no++;
		}

		// hitung total dan filtered
		$recordsFiltered = $this->_makeQueryRiwayat(true);
		$recordsTotal    = $recordsFiltered;

		$output = [
			"draw"            => intval($_POST["draw"] ?? 1),
			"recordsTotal"    => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data"            => $data
		];
		echo json_encode($output);
	}




	function _makeQueryRiwayat($no_limit = null)
	{

		if (!$no_limit) {
			$start              = $this->input->post('start');
			$length             = $this->input->post('length');
			$filter['limit']    = [$start, $length];
		}

		if (isset($_POST['order'])) {
			$filter['order'] = $_POST['order'];
		}

		// Add date filtering
		if ($this->input->post('start_date')) {
			$filter['start_date'] = $this->input->post('start_date');
		}
		
		if ($this->input->post('end_date')) {
			$filter['end_date'] = $this->input->post('end_date');
		}

		// Add platform filtering
		if ($this->input->post('id_platform')) {
			$filter['id_platform'] = $this->input->post('id_platform');
		}

		// Filter for riwayat (completed/cancelled transactions)
		$filter['riwayat'] = true;
		if ($no_limit == true) {
			return $this->m_penjualan->getPenjualan($filter)->num_rows();
		} else {
			return $this->m_penjualan->getPenjualan($filter);
		}
	}

	public function getSubtotal()
	{
		$filter = [];
		
		if ($this->input->post('start_date')) {
			$filter['start_date'] = $this->input->post('start_date');
		}
		
		if ($this->input->post('end_date')) {
			$filter['end_date'] = $this->input->post('end_date');
		}

		if ($this->input->post('id_platform')) {
			$filter['id_platform'] = $this->input->post('id_platform');
		}
		
		$result = $this->m_penjualan->getSubtotal($filter);
		echo json_encode($result);
	}

	public function exportRiwayat()
	{
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$id_platform = $this->input->get('id_platform');
		
		$filter = [];
		if ($start_date) {
			$filter['start_date'] = $start_date;
		}
		if ($end_date) {
			$filter['end_date'] = $end_date;
		}
		if ($id_platform) {
			$filter['id_platform'] = $id_platform;
		}

		// Get data for export
		$data = $this->m_penjualan->getPenjualan($filter);

		// Set headers for Excel download
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="riwayat_penjualan_' . date('Y-m-d') . '.xls"');

		// Simple HTML table for Excel
		echo '<table border="1">';
		echo '<tr><th>No</th><th>No Faktur</th><th>Tanggal</th><th>Customer</th><th>Platform</th><th>Total</th></tr>';

		$no = 1;
		foreach ($data->result() as $row) {
			echo '<tr>';
			echo '<td>' . $no . '</td>';
			echo '<td>' . $row->no_faktur . '</td>';
			echo '<td>' . $row->tgl . '</td>';
			echo '<td>' . ($row->customer ?: 'Walk in Customer') . '</td>';
			echo '<td>' . ($row->platform ?: '-') . '</td>';
			echo '<td>' . number_format($row->total, 0, ',', '.') . '</td>';
			echo '</tr>';
			$no++;
		}

		echo '</table>';
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

			$all_products = $this->db->get('dwigital_produk')->result_array();
			$all_platforms = $this->db->get('dwigital_platform')->result_array();
			$last_id_platform = $this->db->select_max('id')->get('dwigital_platform')->row()->id;
			$last_id_product = $this->db->select_max('id_produk')->get('dwigital_produk')->row()->id_produk;
			$last_id_import = $this->db->select_max('id_import')->get('dwigital_cart')->row()->id_import;
			$this->db->trans_begin();
			$last_id_import++;
			$no_faktur = [];
			foreach ($data as $x => $rowData) {

				if ($x == 0) {
					continue;
				}
				$insert_platform = [];
				$insert_product = [];

				$tanggal = explode("/", $rowData[0]);
				$tanggal = $tanggal[2] . "-" . $tanggal[1] . "-" . $tanggal[0];
				$tahun_bulan = $tanggal[2] . "-" . $tanggal[1];

				$cari = $rowData[5];
				$hasil = array_filter($all_platforms, function ($item) use ($cari) {
					return stripos($item['nama'], $cari) !== false; // case-insensitive
				});
				if (count($hasil) > 0) {
					$hasil = reset($hasil);
					$id_platform = $hasil['id'];
				} else {
					$last_id_platform++;
					$insert_platform = [
						'id' => $last_id_platform,
						'nama' => $rowData[5],
						'created_at' => waktu()
					];
					$id_platform = $last_id_platform;
					$all_platforms[] = $insert_platform;
				}

				$cari = $rowData[2];
				$hasil = array_filter($all_products, function ($item) use ($cari) {
					return stripos($item['nama_produk'], $cari) !== false; // case-insensitive
				});
				if (count($hasil) > 0) {
					$hasil = reset($hasil);
					$id_product = $hasil['id_produk'];
				} else {
					$last_id_product++;
					$insert_product = [
						'id_produk' => $last_id_product,
						'nama_produk' => $rowData[2],
						'id_produk_kategori' => 1,
						'created_at' => waktu(),
						'created_by' => $id_user,
						'harga' => $rowData[3],
						'harga_beli' => $rowData[3]
					];
					$id_product = $last_id_product;
					$all_products[] = $insert_product;
				}

				$total = $rowData[3] * $rowData[4];

				if (isset($no_faktur[$tahun_bulan])) {
					$new_no_faktur = $no_faktur[$tahun_bulan] + 1;
					$no_faktur[$tahun_bulan] = $new_no_faktur;
				} else {
					$new_no_faktur = $this->get_faktur($tahun_bulan);
					$no_faktur[$tahun_bulan] = $new_no_faktur;
				}

				$insert_cart = [
					'no_faktur' => $new_no_faktur,
					'tgl' => $tanggal,
					'total' => $total,
					'nominal' => $total,
					'kembalian' => 0,
					'status' => 'selesai',
					'status_bayar' => 2,
					'created_at' => waktu(),
					'payment_type' => 'manual_transfer',
					'id_platform' => $id_platform,
					'catatan' => $rowData[1] . ' - ' . $rowData[6],
					'id_import' => $last_id_import,
					'import_at' => waktu()
				];

				$insert_cart_detail = [
					'no_faktur' => $insert_cart['no_faktur'],
					'id_produk' => $id_product,
					'nama_produk' => $rowData[2],
					'harga' => $rowData[3],
					'satuan' => $rowData[6],
					'qty' => $rowData[4],
					'status' => 1,
					'id_user' => 0,
					'updated_at' => waktu(),
				];


				if (count($insert_platform) > 0) {
					$this->db->insert('dwigital_platform', $insert_platform);
				}

				if (count($insert_product) > 0) {
					$this->db->insert('dwigital_produk', $insert_product);
				}

				$this->db->insert('dwigital_cart', $insert_cart);
				$this->db->insert('dwigital_cart_detail', $insert_cart_detail);
			}

			if ($this->db->trans_status() === FALSE) {
				// jika ada error rollback
				$this->db->trans_rollback();
				$_SESSION['pesan'] 		= "Data gagal import";
				$_SESSION['tipe'] 		= "danger";
			} else {
				// jika sukses commit
				$this->db->trans_commit();

				$_SESSION['pesan'] 		= "Data berhasil import";
				$_SESSION['tipe'] 		= "success";
			}
		}

		echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dwigital/transaksi/penjualan/import'>";
	}
}
