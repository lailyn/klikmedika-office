<?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
  <div class="alert alert-<?= $_SESSION['tipe'] ?> alert-dismissable">
    <strong><?= $_SESSION['pesan'] ?></strong>
  </div>
<?php } $_SESSION['pesan'] = ''; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <div>
      <?php if ($set != "form") { ?>
        <a href="<?= site_url('dwigital/transaksi/withdraw/form'); ?>" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Withdraw Baru
        </a>
      <?php } ?>
    </div>
  </div>

  <?php if ($set == "form") { ?>
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <a href="<?= site_url('dwigital/transaksi/withdraw'); ?>" class="btn btn-warning btn-sm">
          <i class="fa fa-chevron-left"></i> Kembali
        </a>
      </div>
      <div class="card-body">
        <form method="post"
              action="<?= isset($row) ? site_url('dwigital/transaksi/withdraw/update/'.$row->id) 
                                      : site_url('dwigital/transaksi/withdraw/save'); ?>">

          <div class="form-group row">
            <label for="id_platform" class="col-sm-3 col-form-label">Sumber</label>
            <div class="col-sm-9">
              <select name="id_platform" id="id_platform" class="form-control" required>
                <option value="">-- Pilih Platform --</option>
                <?php foreach ($platforms as $plat) { ?>
                  <option value="<?= $plat->id ?>" <?= isset($row) && $row->id_platform == $plat->id ? 'selected' : '' ?>>
                    <?= $plat->nama ?>
                  </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
            <div class="col-sm-9">
              <input type="number" name="nominal" id="nominal" class="form-control"
                     value="<?= isset($row) ? $row->nominal : '' ?>" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-9">
              <input type="date" name="tanggal" id="tanggal" class="form-control"
                     value="<?= isset($row) ? $row->tanggal : date('Y-m-d') ?>" required>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-sm-9 offset-sm-3">
              <button type="submit" class="btn btn-primary">
                <?= isset($row) ? 'Update' : 'Save'; ?>
              </button>
              <a href="<?= site_url('dwigital/transaksi/withdraw'); ?>" class="btn btn-light">
                Cancel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

  <?php } else { ?>
    <div class="card-body">
      <div class="box">
        <div class="table-responsive">

          <?php
            // Hitung total semua nominal dari seluruh data di $rows
            $grand_total = 0;
            if (!empty($rows)) {
              foreach ($rows as $r) $grand_total += (float)$r->nominal;
            }
          ?>

          <table id="example" class="table" style="width:100%">
            <thead class="thead-light">
              <tr>
                <th width="5%">No</th>
                <th width="30%">Sumber</th>
                <th width="25%">Nominal</th>
                <th width="25%">Tanggal</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no=1; if (!empty($rows)) { foreach ($rows as $row) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->nama_platform ?></td>
                  <td><?= number_format($row->nominal, 0, ',', '.') ?></td>
                  <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="<?= site_url('dwigital/transaksi/withdraw/form/'.$row->id); ?>" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> Edit
                      </a>
                      <a href="<?= site_url('dwigital/transaksi/withdraw/delete/'.$row->id); ?>" 
                         class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fa fa-trash"></i> Hapus
                      </a>
                    </div>
                  </td>
                </tr>
              <?php } } ?>
            </tbody>


            <tfoot>
              <tr>
                <th colspan="2" class="text-left">Total</th>
                <th><?= number_format($grand_total, 0, ',', '.') ?></th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

</div>

<script>
$(document).ready(function(){
  $('#example').DataTable({
    paging: true,
    info: true,
    searching: true,
    lengthChange: true,
    language: {
      emptyTable: 'Belum ada data withdraw',
      zeroRecords: 'Tidak ditemukan data yang cocok',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      lengthMenu: 'Show _MENU_ entries',
      search: 'Search:',
      paginate: { previous: 'Previous', next: 'Next' }
    }
  });
});
</script>
