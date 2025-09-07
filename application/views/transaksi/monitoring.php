<?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
  <div class="alert alert-<?= $_SESSION['tipe'] ?> alert-dismissable">
    <strong><?= $_SESSION['pesan'] ?></strong>
  </div>
<?php } $_SESSION['pesan'] = ''; ?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-header">
        <form method="post" action="<?= site_url('transaksi/monitoring/index'); ?>">
          <div class="row">
            <div class="col-sm-3">
              <label>Pilih Tahun</label>
              <select class="form-control form-control-sm" name="filter_1" required>
                <?php 
                $tahunNow = date('Y');
                for ($i = $tahunNow - 5; $i <= $tahunNow + 5; $i++) {
                  $sel = ($i == $filter_1) ? "selected" : "";
                  echo "<option value='$i' $sel>$i</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <br>
              <button type="submit" class="btn btn-info btn-sm mt-2">
                <i class="fa fa-filter"></i> Filter
              </button>
              <a href="<?= site_url('transaksi/monitoring'); ?>" 
                 class="btn btn-warning btn-sm mt-2 text-white">Reset</a>
            </div>
          </div>
        </form>
      </div>

      <div class="card-body">            
        <div class="box">                            
          <div class="table-responsive">
            <table class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nomor HP</th>
                  <th>Produk</th>
                  <th>Tanggal Faktur</th>
                  <th>Tanggal Kadaluwarsa</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                foreach ($list_data as $row) {
                  $phone = $row->phone ?? '';
                  $phone = preg_replace('/\D/', '', $phone);
                  $phone = ltrim($phone, '0');

                  if ($phone != '') {
                    $waUrl = "https://wa.me/62".$phone."?text=Halo%20".$row->nama_pemesan.",%20kami%20dari%20Klik%20Ciptareka";
                    $aksi = "<a href='$waUrl' target='_blank' class='btn btn-success btn-sm'>Kirim WA</a>";
                  } else {
                    $aksi = "<span class='badge badge-secondary'>No HP kosong</span>";
                  }

                  echo "
                  <tr>
                    <td>$no</td>
                    <td>{$row->catatan}</td>
                    <td>".($row->phone ?? '-')."</td>
                    <td>{$row->nama_produk}</td>
                    <td>{$row->tanggal_faktur}</td>
                    <td>{$row->tanggal_kadaluarsa}</td>
                    <td>$aksi</td>
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
