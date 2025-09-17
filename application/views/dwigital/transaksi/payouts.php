<?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
  <div class="alert alert-<?= $_SESSION['tipe'] ?> alert-dismissable">
    <strong><?= $_SESSION['pesan'] ?></strong>
  </div>
<?php } $_SESSION['pesan'] = ''; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <?php if ($mode != "insert" && $mode != "edit") { ?>
          <a href="<?= site_url('dwigital/transaksi/payouts/add'); ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Payout Baru
          </a>
        <?php } ?>
      </div>
      <div>
        <small class="text-muted">
          <i class="fa fa-info-circle"></i> 
          Total Payouts: <strong>Rp <?= number_format($grand_total ?? 0, 0, ',', '.') ?></strong>
          <span class="ml-3">
            <i class="fa fa-chart-line text-success"></i>
            Profit Tersedia: <strong class="text-success">Rp <?= number_format($available_profit ?? 0, 0, ',', '.') ?></strong>
          </span>
        </small>
      </div>
    </div>
  </div>

  <?php if ($mode == "insert" || $mode == "edit") { ?>
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <a href="<?= site_url('dwigital/transaksi/payouts'); ?>" class="btn btn-warning btn-sm">
          <i class="fa fa-chevron-left"></i> Kembali
        </a>
      </div>
      <div class="card-body">
        <form method="post"
              action="<?= $mode == 'edit' ? site_url('dwigital/transaksi/payouts/update/'.$dt_payouts->row()->id) 
                                      : site_url('dwigital/transaksi/payouts/store'); ?>">

          <div class="form-group row">
            <label for="payout_to" class="col-sm-3 col-form-label">Payout To <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="payout_to" id="payout_to" 
                     class="form-control <?= form_error('payout_to') ? 'is-invalid' : '' ?>"
                     value="<?= set_value('payout_to', $mode == 'edit' ? $dt_payouts->row()->payout_to : '') ?>" 
                     placeholder="" required>
              <?= form_error('payout_to', '<div class="invalid-feedback">', '</div>') ?>
              <small class="form-text text-muted">Masukkan tujuan payout</small>
            </div>
          </div>

          <div class="form-group row">
            <label for="amount" class="col-sm-3 col-form-label">Jumlah <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp</span>
                </div>
                <input type="number" name="amount" id="amount" class="form-control <?= form_error('amount') ? 'is-invalid' : '' ?>"
                       value="<?= set_value('amount', $mode == 'edit' ? $dt_payouts->row()->amount : '') ?>" 
                       min="1" step="0.01" max="<?= $available_profit ?? 0 ?>" placeholder="Masukkan jumlah payout" required>
              </div>
              <?= form_error('amount', '<div class="invalid-feedback">', '</div>') ?>
              <small class="form-text text-muted">
                Jumlah payout tidak boleh melebihi profit tersedia (Maksimal: Rp <?= number_format($available_profit ?? 0, 0, ',', '.') ?>)
              </small>
              <div class="alert alert-info mt-2">
                <i class="fa fa-info-circle"></i> 
                <strong>Profit Tersedia:</strong> Rp <?= number_format($available_profit ?? 0, 0, ',', '.') ?>
                <br><small>Berdasarkan perhitungan: (Pendapatan + Sisa Saldo) - Pengeluaran</small>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label">Status <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <select name="status" id="status" class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" required>
                <option value="">-- Pilih Status --</option>
                <option value="pending" <?= (set_value('status', $mode == 'edit' ? $dt_payouts->row()->status : '') == 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="processing" <?= (set_value('status', $mode == 'edit' ? $dt_payouts->row()->status : '') == 'processing') ? 'selected' : '' ?>>Processing</option>
                <option value="completed" <?= (set_value('status', $mode == 'edit' ? $dt_payouts->row()->status : '') == 'completed') ? 'selected' : '' ?>>Completed</option>
                <option value="failed" <?= (set_value('status', $mode == 'edit' ? $dt_payouts->row()->status : '') == 'failed') ? 'selected' : '' ?>>Failed</option>
              </select>
              <?= form_error('status', '<div class="invalid-feedback">', '</div>') ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-9">
              <textarea name="description" id="description" class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" rows="3" placeholder="Masukkan deskripsi payout (opsional)"><?= set_value('description', $mode == 'edit' ? $dt_payouts->row()->description : '') ?></textarea>
              <?= form_error('description', '<div class="invalid-feedback">', '</div>') ?>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-sm-9 offset-sm-3">
              <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fa fa-save"></i> <?= $mode == 'edit' ? 'Update' : 'Simpan'; ?>
              </button>
              <a href="<?= site_url('dwigital/transaksi/payouts'); ?>" class="btn btn-light">
                <i class="fa fa-times"></i> Batal
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


          <table id="example" class="table" style="width:100%">
            <thead class="thead-light">
              <tr>
                <th width="5%">No</th>
                <th width="20%">Payout To</th>
                <th width="15%" class="text-right">Jumlah</th>
                <th width="15%">Status</th>
                <th width="25%">Deskripsi</th>
                <th width="15%">Tanggal</th>
                <th width="5%">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no=1; if (!empty($dt_payouts)) { foreach ($dt_payouts->result() as $payout) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <strong><?= $payout->payout_to ?? 'N/A' ?></strong>
                  </td>
                  <td class="text-right">
                    <strong>Rp <?= number_format($payout->amount, 0, ',', '.') ?></strong>
                  </td>
                  <td>
                    <?php
                    $status_class = '';
                    switch($payout->status) {
                      case 'pending': $status_class = 'badge-warning'; break;
                      case 'processing': $status_class = 'badge-info'; break;
                      case 'completed': $status_class = 'badge-success'; break;
                      case 'failed': $status_class = 'badge-danger'; break;
                      default: $status_class = 'badge-secondary';
                    }
                    ?>
                    <span class="badge <?= $status_class ?>"><?= ucfirst($payout->status) ?></span>
                  </td>
                  <td>
                    <?= $payout->description ? $payout->description : '<em class="text-muted">Tidak ada deskripsi</em>' ?>
                  </td>
                  <td>
                    <small><?= date('d-m-Y H:i', strtotime($payout->created_at)) ?></small>
                  </td>
                  <td>
                    <div class="btn-group">
                      <a href="<?= site_url('dwigital/transaksi/payouts/edit/'.$payout->id); ?>" 
                         class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="<?= site_url('dwigital/transaksi/payouts/delete/'.$payout->id); ?>" 
                         class="btn btn-danger btn-sm" 
                         onclick="return confirm('Yakin ingin menghapus payout ini?')" 
                         title="Hapus">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php } } ?>
            </tbody>

            <tfoot>
              <tr class="table-info">
                <th colspan="2" class="text-left">
                  <i class="fa fa-calculator"></i> Total Payouts
                </th>
                <th class="text-right">
                  <strong>Rp <?= number_format($grand_total ?? 0, 0, ',', '.') ?></strong>
                </th>
                <th colspan="4"></th>
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
  // DataTable initialization
  $('#example').DataTable({
    paging: true,
    info: true,
    searching: true,
    lengthChange: true,
    language: {
      emptyTable: 'Belum ada data payouts',
      zeroRecords: 'Tidak ditemukan data yang cocok',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      lengthMenu: 'Show _MENU_ entries',
      search: 'Search:',
      paginate: { previous: 'Previous', next: 'Next' }
    }
  });

  // Form validation and submission
  $('form').on('submit', function(e) {
    var isValid = true;
    var errorMessages = [];

    // Clear previous error states
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Validate Payout To
    if ($('#payout_to').val().trim() === '') {
      $('#payout_to').addClass('is-invalid');
      $('#payout_to').after('<div class="invalid-feedback">Payout To harus diisi</div>');
      isValid = false;
    }

    // Validate Amount
    var amount = parseFloat($('#amount').val());
    var maxAmount = parseFloat($('#amount').attr('max')) || 0;
    
    if (isNaN(amount) || amount <= 0) {
      $('#amount').addClass('is-invalid');
      $('#amount').after('<div class="invalid-feedback">Jumlah harus berupa angka lebih dari 0</div>');
      isValid = false;
    } else if (maxAmount > 0 && amount > maxAmount) {
      $('#amount').addClass('is-invalid');
      $('#amount').after('<div class="invalid-feedback">Jumlah tidak boleh melebihi profit tersedia (Rp ' + maxAmount.toLocaleString('id-ID') + ')</div>');
      isValid = false;
    }

    // Validate Status
    if ($('#status').val() === '') {
      $('#status').addClass('is-invalid');
      $('#status').after('<div class="invalid-feedback">Status harus diisi</div>');
      isValid = false;
    }

    // Validate Description length
    if ($('#description').val().length > 500) {
      $('#description').addClass('is-invalid');
      $('#description').after('<div class="invalid-feedback">Deskripsi maksimal 500 karakter</div>');
      isValid = false;
    }

    if (!isValid) {
      e.preventDefault();
      // Scroll to first error
      $('.is-invalid').first().focus();
      return false;
    } else {
      // Show loading state
      $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
    }
  });


  // Real-time validation
  $('#amount').on('input', function() {
    var value = parseFloat($(this).val());
    var maxAmount = parseFloat($(this).attr('max')) || 0;
    
    // Clear previous validation
    $(this).removeClass('is-invalid');
    $(this).next('.invalid-feedback').remove();
    
    if (isNaN(value) || value <= 0) {
      $(this).addClass('is-invalid');
      $(this).after('<div class="invalid-feedback">Jumlah harus berupa angka lebih dari 0</div>');
    } else if (maxAmount > 0 && value > maxAmount) {
      $(this).addClass('is-invalid');
      $(this).after('<div class="invalid-feedback">Jumlah tidak boleh melebihi profit tersedia (Rp ' + maxAmount.toLocaleString('id-ID') + ')</div>');
    }
  });

  $('#description').on('input', function() {
    var length = $(this).val().length;
    if (length > 500) {
      $(this).addClass('is-invalid');
      if (!$(this).next('.invalid-feedback').length) {
        $(this).after('<div class="invalid-feedback">Deskripsi maksimal 500 karakter</div>');
      }
    } else {
      $(this).removeClass('is-invalid');
      $(this).next('.invalid-feedback').remove();
    }
  });

  // Format currency input
  $('#amount').on('blur', function() {
    var value = parseFloat($(this).val());
    if (!isNaN(value) && value > 0) {
      $(this).val(value.toFixed(2));
    }
  });

});
</script>


