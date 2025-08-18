<style type="text/css">
  .password-masked {
    font-family: 'password-mask', sans-serif;
    -webkit-text-security: disc;
    /* Safari */
    text-security: disc;
    /* Proposal for future CSS spec */
  }

  /* Fallback for other browsers */
  @font-face {
    font-family: 'password-mask';
    src: local('Arial');
    unicode-range: U+002A;
    /* Replace all characters with asterisk */
  }

  .password-masked::placeholder {
    color: #ccc;
    /* Customize placeholder color */
  }
</style>

<?php
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
?>
  <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
    <strong><?php echo $_SESSION['pesan'] ?></strong>
  </div>
<?php
}
$_SESSION['pesan'] = '';

?>

<?php
if ($set == "insert") {
  if ($mode == 'insert') {
    $read = "";
    $read2 = "";
    $form = "simpanOpname";
    $vis  = "";
    $form_id = "";
    $row = "";
    $tombol = "Simpan Transaksi";
    $vis2  = "style='display:none;'";
  } elseif ($mode == 'detail' or $mode == "approval") {
    $row  = $dt_opname->row();
    $read = "readonly";
    $read2 = "disabled";
    $vis2 = $vis  = "style='display:none;'";
    $form = "approvalOpname";
    $form_id = "";
    $tombol = "";
    if ($mode == "approval") $vis2 = "";
  } elseif ($mode == 'edit') {
    $tombol = "Update Transaksi";
    $row  = $dt_opname->row();
    $read = "";
    $read2 = "";
    $form = "updateOpname";
    $vis  = "";
    $vis2  = "style='display:none;'";
    $form_id = "<input type='hidden' name='id' value='$row->id_opname'>";
  }
?>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <a href="dwigital/transaksi/opname" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
          </h4>
        </div>
        <div class="card-body">
          <form action='dwigital/transaksi/opname/<?= $form ?>' method='POST'>
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <label class="col-sm-1 col-form-label-sm">No Opname</label>
                  <div class="col-sm-2">
                    <input type="text" value="<?php echo $tampil = ($row != '') ? $row->kode : ""; ?>" readonly name="kode" placeholder="Auto" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                  <label class="col-sm-2 col-form-label-sm">Periode Opname</label>
                  <div class="col-sm-2">
                    <input type="date" <?= $read ?> name="tgl" placeholder="Tgl" value="<?php echo $tampil = ($row != '') ? $row->tgl : date("Y-m-d"); ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                  <div class="col-sm-2">
                    <input type="date" <?= $read ?> name="tgl_akhir" placeholder="Tgl" value="<?php echo $tampil = ($row != '') ? $row->tgl_akhir : date("Y-m-d"); ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-1 col-form-label-sm">Karyawan</label>
                  <div class="col-sm-2">
                    <select <?= $read2 ?> class="form-control form-control-sm select2" required name="id_karyawan">
                      <option value="">- pilih -</option>
                      <?php
                      $id_karyawan_session = $this->session->id_karyawan;
                      $level = $this->session->level;
                      if ($level == 'karyawan') $where = " AND id_karyawan='$id_karyawan_session'";
                      else $where = "";
                      $dt_user = $this->db->query("SELECT * FROM md_karyawan WHERE status = 1 $where");
                      foreach ($dt_user->result() as $isi) {
                        $id_karyawan = ($row != '') ? $row->id_karyawan : '';
                        if ($isi->id_karyawan == $id_karyawan) $rt = "selected";
                        else $rt = "";
                        if ($isi->id_karyawan == $id_karyawan_session) $rs = "selected";
                        else $rs = "";
                        echo "<option $rt $rs value='$isi->id_karyawan'>$isi->nama_lengkap</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <label class="col-sm-2 col-form-label-sm">Kategori</label>
                  <div class="col-sm-2">
                    <select <?= $read2 ?> class="form-control form-control-sm select2" id="category_id" name="category_id">
                      <option value="">- semua -</option>
                      <?php
                      $dt_produk_kategori = $this->db->query("SELECT DISTINCT(id_produk_kategori) AS produk_kategori FROM  dwigital_produk");
                      foreach ($dt_produk_kategori->result() as $isi) {
                        echo "<option value='$isi->produk_kategori'>$isi->produk_kategori</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">

                  <label class="col-sm-1 col-form-label-sm">Catatan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" name="catatan">
                  </div>
                </div>

                <div <?= $vis ?> class="form-group row">
                  <label class="col-sm-1 col-form-label-sm"></label>
                  <div class="col-sm-8">
                    <button onclick="generate();kurang();" class="btn btn-success" type="button"> <i class="fa fa-history"></i> Generate </button>
                    <button onclick="return confirm('Pastikan semua data sudah benar, lanjutkan..?')"
                      type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Semua Data
                    </button>
                  </div>
                </div>
              </div>
            </div>


            <div class="box">
              <div class="table-responsive">
                <span id="tampil_opname"></span>
              </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>

<?php
} elseif ($set == "detail") {

  $row  = $dt_opname->row();
  $read = "readonly";
  $read2 = "disabled";
  $vis2 = $vis  = "style='display:none;'";
  $form = "approvalOpname";
  $form_id = "";
  $tombol = "";
  if ($mode == "approval") $vis2 = "";

?>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <a href="dwigital/transaksi/opname" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
          </h4>
        </div>
        <div class="card-body">
          <form action='dwigital/transaksi/opname/<?= $form ?>' method='POST'>
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <label class="col-sm-1 col-form-label-sm">No Opname</label>
                  <div class="col-sm-2">
                    <input type="text" value="<?php echo $tampil = ($row != '') ? $row->kode : ""; ?>" readonly name="kode" placeholder="Auto" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                  <label class="col-sm-2 col-form-label-sm">Periode Opname</label>
                  <div class="col-sm-2">
                    <input type="date" <?= $read ?> name="tgl" placeholder="Tgl" value="<?php echo $tampil = ($row != '') ? $row->tgl_opname : date("Y-m-d"); ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                  <div class="col-sm-2">
                    <input type="date" <?= $read ?> name="tgl_akhir" placeholder="Tgl" value="<?php echo $tampil = ($row != '') ? $row->tgl_akhir : date("Y-m-d"); ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />
                  </div>
                </div>
                <div class="form-group row">

                  <label class="col-sm-1 col-form-label-sm">Karyawan</label>
                  <div class="col-sm-2">
                    <select <?= $read2 ?> class="form-control form-control-sm select2" required name="id_karyawan">
                      <option value="">- pilih -</option>
                      <?php
                      $id_karyawan_session = $this->session->id_karyawan;
                      $level = $this->session->level;
                      if ($level == 'karyawan') $where = " AND id_karyawan='$id_karyawan_session'";
                      else $where = "";
                      $dt_user = $this->db->query("SELECT * FROM md_karyawan WHERE status = 1 $where");
                      foreach ($dt_user->result() as $isi) {
                        $id_karyawan = ($row != '') ? $row->id_karyawan : '';
                        if ($isi->id_karyawan == $id_karyawan) $rt = "selected";
                        else $rt = "";
                        if ($isi->id_karyawan == $id_karyawan_session) $rs = "selected";
                        else $rs = "";
                        echo "<option $rt $rs value='$isi->id_karyawan'>$isi->nama_lengkap</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <label class="col-sm-2 col-form-label-sm">Kategori</label>
                  <div class="col-sm-2">
                    <select <?= $read2 ?> class="form-control form-control-sm select2" id="category_id" name="category_id">
                      <option value="">- semua -</option>
                      <?php
                      $dt_produk_kategori = $this->m_admin->getAll("dwigital_produk_kategori");
                      foreach ($dt_produk_kategori->result() as $isi) {
                        $id = ($row != '') ? $row->category_id : "";
                        if ($isi->produk_kategori == $id) $rt = "selected";
                        else $rt = "";
                        echo "<option $rt value='$isi->produk_kategori'>$isi->produk_kategori</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">

                  <label class="col-sm-1 col-form-label-sm">Catatan</label>
                  <div class="col-sm-8">
                    <input type="text" value="<?= $row->keterangan ?>" <?= $read ?> class="form-control form-control-sm" name="keterangan">
                  </div>
                </div>

                <div <?= $vis ?> class="form-group row">
                  <label class="col-sm-1 col-form-label-sm"></label>
                  <div class="col-sm-8">
                    <button onclick="generate();kurang();" class="btn btn-success" type="button"> <i class="fa fa-history"></i> Generate </button>
                    <button onclick="return confirm('Pastikan semua data sudah benar, lanjutkan..?')"
                      type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Semua Data
                    </button>
                  </div>
                </div>
                <div <?= $vis2 ?> class="form-group row">
                  <label class="col-sm-2 col-form-label-sm"></label>
                  <div class="col-sm-8">
                    <button onclick="return confirm('Anda yakin ingin Approve Opname ini?')" value="approve" name="submit" class="btn btn-success" type="submit"> <i class="fa fa-check"></i> Approve</button>
                    <button onclick="return confirm('Anda yakin ingin Reject Opname ini?')" value="reject" name="submit" class="btn btn-danger" type="submit"> <i class="fa fa-ban"></i> Reject</button>
                  </div>
                </div>
              </div>
            </div>


            <div class="box">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Kode</th>
                      <th>Product</th>
                      <th>Qty Onhand</th>
                      <th>Qty Opname</th>
                      <th>Qty Selisih</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $tot1 = 0;
                    $tot2 = 0;
                    $tot3 = 0;
                    $dt_products = $this->m_admin->getByID("dwigital_stock_opname_detail", "kode", $kode);
                    foreach ($dt_products->result() as $row) {
                      $jum = $dt_products->num_rows();
                      $cekP = $this->m_admin->getByID("dwigital_produk", "id_produk", $row->id_produk)->row();
                      $sku = $cekP->kode_produk;
                      $name = $cekP->nama_produk;


                      $selisih = $row->qty_opname - $row->qty_onhand;
                      echo "
                        <tr>
                          <td>$no</td>
                          <td width='15%'>$sku</td>
                          <td>$name</td>       
                          <td>$row->qty_onhand</td>       
                          <td>$row->qty_opname</td>       
                          <td>$selisih</td>                                 
                          <td>$row->keterangan</td>                                 
                        </tr>";
                      $no++;
                      $tot1 += $row->qty_onhand;
                      $tot3 += $selisih;
                      $tot2 += $row->qty_opname;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"><b>Total</b></td>
                      <td><input type='number' id='tot_onhand' value="<?php echo $tot1 ?>" class='form-control' readonly name='tot_onhand'></td>
                      <td><input type='number' id='tot_opname' value="<?php echo $tot2 ?>" class='form-control' readonly name='tot_opname'></td>
                      <td><input type='number' id='tot_selisih' value="<?php echo $tot3 ?>" class='form-control' readonly name='tot_selisih'></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>



<?php } elseif ($set == "view") { ?>


  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <?php if ($mode == "view") { ?>
              <a href="dwigital/transaksi/opname/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transaksi Baru</a>
              <a href="dwigital/transaksi/opname/index/history" class="btn btn-warning btn-sm"><i class="fa fa-history"></i> Riwayat</a>
            <?php } else { ?>
              <a href="dwigital/transaksi/opname/" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
            <?php } ?>
          </h4>
        </div>
        <div class="card-body">
          <div class="box">
            <div class="table-responsive">
              <table id="example" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="10%"></th>
                    <th>No Stock Opname</th>
                    <th>Periode</th>
                    <th>Qty Real</th>
                    <th>Qty Opname</th>
                    <th>Selisih</th>
                    <th>Catatan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($dt_opname->result() as $isi) {

                    if ($isi->status == 1) {
                      $edit = $approval = $hapus = "";
                      $status = "<label class='badge badge-info'>Baru</label>";
                    } elseif ($isi->status == 2) {
                      $approval = $hapus = $edit = "display:none;";
                      $status = "<label class='badge badge-primary'>Approved</label>";
                    } elseif ($isi->status == 0) {
                      $edit = $hapus = "";
                      $approval = "display:none";
                      $status = "<label class='badge badge-danger'>Rejected</label>";
                    } elseif ($isi->status == 3) {
                      $approval = $hapus = $edit = "display:none;";
                      $status = "<label class='badge badge-success'>Selesai</label>";
                    }


                    $item = $this->m_admin->getByID("dwigital_stock_opname_detail", "kode", $isi->kode)->num_rows();
                    $qty_opname = $this->db->query("SELECT SUM(qty_opname) AS total FROM dwigital_stock_opname_detail WHERE kode = '$isi->kode'")->row()->total;
                    $qty_onhand = $this->db->query("SELECT SUM(qty_onhand) AS total FROM dwigital_stock_opname_detail WHERE kode = '$isi->kode'")->row()->total;
                    $qty_selisih = $this->db->query("SELECT SUM(qty_selisih) AS total FROM dwigital_stock_opname_detail WHERE kode = '$isi->kode'")->row()->total;

                    $kode = encrypt_url($isi->kode);

                    if (!is_null($isi->tgl_akhir)) $akhir = " s/d " . $isi->tgl_akhir;
                    else $akhir = "";

                    echo "
                    <tr>
                      <td>$no</td>
                      <td>
                        <div class='btn-group'>
                          <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                          <div class='dropdown-menu'>
                            <a href='dwigital/transaksi/opname/detail/$kode' class='dropdown-item'>Detail</a>
                            <a href='dwigital/transaksi/opname/approval/$kode' class='dropdown-item' style='$approval'>Approval</a>                            
                            <a href='dwigital/transaksi/opname/delete/$kode' class='dropdown-item' style='$hapus'>Hapus</a>                            
                          </div>
                        </div>  
                      </td>
                      <td>$isi->kode</td>
                      <td>$isi->tgl_opname $akhir</td>                                                                
                      <td>$qty_onhand</td>                                                                
                      <td>$qty_opname</td>                                                                
                      <td>$qty_selisih</td>                                                                                      
                      <td>$isi->keterangan</td>                      
                      <td>$status</td>
                    </tr>
                    ";
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="DokumenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          Password Required
        </div>
        <form action="master/produk/loginStok" method="POST">
          <div class="modal-body">

            <div class="row">

              <div class="col-md-12">
                <?php
                if (isset($_SESSION['pesanModal']) && $_SESSION['pesanModal'] <> '') {
                ?>
                  <div class="alert alert-<?php echo $_SESSION['tipeModal'] ?> alert-dismissable">
                    <strong><?php echo $_SESSION['pesanModal'] ?></strong>
                  </div>
                <?php
                }
                $_SESSION['pesanModal'] = '';
                ?>
                <div class="form-group">
                  <label>Masukkan Password</label>
                  <input type="hidden" name="page" value="opname">
                  <input
                    type="text"
                    class="form-control password-masked"
                    name="passwordStok"
                    maxlength="16"
                    autocomplete="off"
                    required>

                </div>
              </div>


            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Proses</button>
            <button type="button" onclick="back()" class="btn btn-default">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>


<?php } ?>


<script type="text/javascript">
  function back() {
    window.history.back();
  }

  function generate() {
    $("#tampil_opname").show();
    var category_id = document.getElementById("category_id").value;
    var xhr;
    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
      xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE 8 and older
      xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = "category_id=" + category_id;
    xhr.open("POST", "dwigital/transaksi/opname/t_opname", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
    xhr.onreadystatechange = display_data;

    function display_data() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          document.getElementById("tampil_opname").innerHTML = xhr.responseText;
          kurang();
        } else {
          alert('There was a problem with the request.');
        }
      }
    }
  }


  function kurang() {
    var jum = document.getElementById("jum").value;
    var total_qty = 0;
    var total = 0;
    for (var i = 1; i <= jum; i++) {
      var onhand = $("#onhand_" + i).val();
      var opname = $("#opname_" + i).val();
      sub = parseInt(opname) - parseInt(onhand);
      $("#selisih_" + i).val(sub);
      total += sub;
      total_qty += parseInt(opname);
    }
    $("#tot_selisih").val(total);
    $("#tot_opname").val(total_qty);
  }
</script>