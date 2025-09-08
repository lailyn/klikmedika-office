<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card card-primary">
          <div class="card-body">

            <?php if ($set == "view") { ?>
              <!-- BUTTON -->
              <a href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/add"
                class="btn btn-primary btn-sm mb-3">
                <i class="fa fa-plus"></i> Tambah Pengajuan Cuti
              </a>
              <a href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/riwayat" 
                class="btn btn-info btn-sm mb-3">
                <i class="fa fa-history"></i> Riwayat Pengajuan Cuti
              </a>

              <!-- TABLE PENGAJUAN -->
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Cuti</th>
                    <th>Lama Cuti (Hari)</th>
                    <th>Dari Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Alasan Cuti</th>
                    <th>Sisa Cuti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($dt_pengajuan_cuti as $row){ ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_pengajuan)); ?></td>
                    <td><?= $row->nama_lengkap; ?></td>
                    <td><?= $row->nama_jenis_cuti; ?></td>
                    <td><?= $row->lama_cuti; ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_mulai)); ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_selesai)); ?></td>
                    <td><?= $row->alasan; ?></td>
                    <td><?= $row->sisa_cuti; ?> hari</td>
                    <td>
                      <?php if ($row->status == 0) echo "<span class='badge badge-warning'>Menunggu</span>"; ?>
                      <?php if ($row->status == 1) echo "<span class='badge badge-success'>Disetujui</span>"; ?>
                      <?php if ($row->status == 2) echo "<span class='badge badge-danger'>Ditolak</span>"; ?>
                    </td>
                    <td>
                      <?php if ($row->status == 0) { ?>
                        <div class="btn-group">
                          <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            Aksi
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/set_status/<?= $row->id_pengajuan_cuti; ?>/approve">Approve</a>
                            <a class="dropdown-item" href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/set_status/<?= $row->id_pengajuan_cuti; ?>/reject">Reject</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/edit/<?= $row->id_pengajuan_cuti; ?>">Edit</a>
                            <a class="dropdown-item text-danger" href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/delete/<?= $row->id_pengajuan_cuti; ?>" onclick="return confirm('Yakin hapus pengajuan cuti ini?')">Hapus</a>
                          </div>
                        </div>
                      <?php } else { echo "<span class='text-muted'>Tidak ada aksi</span>"; } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

            <?php } elseif ($set == "riwayat") { ?>
              <!-- BUTTON -->
              <a href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>" 
                class="btn btn-secondary btn-sm mb-3">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>

              <!-- TABLE RIWAYAT -->
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Cuti</th>
                    <th>Lama Cuti (Hari)</th>
                    <th>Dari Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Alasan</th>
                    <th>Sisa Cuti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($dt_pengajuan_cuti as $row){ ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_pengajuan)); ?></td>
                    <td><?= $row->nama_lengkap; ?></td>
                    <td><?= $row->nama_jenis_cuti; ?></td>
                    <td><?= $row->lama_cuti; ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_mulai)); ?></td>
                    <td><?= date("d-m-Y", strtotime($row->tgl_selesai)); ?></td>
                    <td><?= $row->alasan; ?></td>
                    <td><?= $row->sisa_cuti; ?> hari</td>
                    <td>
                      <?php if ($row->status == 1) echo "<span class='badge badge-success'>Approved</span>"; ?>
                      <?php if ($row->status == 2) echo "<span class='badge badge-danger'>Rejected</span>"; ?>
                    </td>
                    <td>
                      <a href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/delete/<?= $row->id_pengajuan_cuti; ?>" 
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Hapus riwayat ini?')">
                         Hapus
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

            <?php } elseif ($set == "add" || $set == "edit") { ?>
              <!-- FORM -->
              <form action="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/save" method="post">
                <input type="hidden" name="mode" value="<?= $set; ?>">
                <?php if($set=="edit"){ ?>
                  <input type="hidden" name="id_pengajuan_cuti" value="<?= $dt_pengajuan_cuti->id_pengajuan_cuti; ?>">
                <?php } ?>

                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <select class="form-control" name="id_karyawan" required>
                    <option value="" disabled <?= ($set=="add")?"selected":""; ?>>-- Pilih Karyawan --</option>
                    <?php foreach($dt_karyawan as $kar){ ?>
                      <option value="<?= $kar->id_karyawan; ?>" 
                        <?= ($set=="edit" && $kar->id_karyawan==$dt_pengajuan_cuti->id_karyawan)?"selected":""; ?>>
                        <?= $kar->nama_lengkap; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Jenis Cuti</label>
                  <select class="form-control" name="id_jenis_cuti" required>
                    <option value="" disabled <?= ($set=="add")?"selected":""; ?>>-- Pilih Jenis Cuti --</option>
                    <?php foreach ($dt_jenis_cuti as $row){ ?>
                      <option value="<?= $row->id_jenis_cuti; ?>" 
                        <?= ($set=="edit" && $row->id_jenis_cuti==$dt_pengajuan_cuti->id_jenis_cuti)?"selected":""; ?>>
                        <?= $row->nama_jenis_cuti; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Dari Tanggal</label>
                  <input type="date" class="form-control" name="dari_tgl" id="dari_tgl" 
                    value="<?= ($set=="edit")?$dt_pengajuan_cuti->tgl_mulai:""; ?>" required>
                </div>

                <div class="form-group">
                  <label>Sampai Tanggal</label>
                  <input type="date" class="form-control" name="sampai_tgl" id="sampai_tgl" 
                    value="<?= ($set=="edit")?$dt_pengajuan_cuti->tgl_selesai:""; ?>" required>
                </div>

                <div class="form-group">
                  <label>Lama Cuti (Hari)</label>
                  <input type="number" class="form-control" name="lama_cuti" id="lama_cuti" 
                    value="<?= ($set=="edit")?$dt_pengajuan_cuti->lama_cuti:""; ?>" readonly>
                </div>

                <div class="form-group">
                  <label>Alasan Cuti</label>
                  <textarea class="form-control" name="alasan_cuti" required><?= ($set=="edit")?$dt_pengajuan_cuti->alasan:""; ?></textarea>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?= base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>" class="btn btn-secondary">Batal</a>
                </div>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SCRIPT HITUNG LAMA CUTI -->
<script>
function hitungLamaCuti(){
  let tglMulai = document.getElementById("dari_tgl") ? document.getElementById("dari_tgl").value : null;
  let tglSelesai = document.getElementById("sampai_tgl") ? document.getElementById("sampai_tgl").value : null;
  if(tglMulai && tglSelesai){
    let start = new Date(tglMulai);
    let end = new Date(tglSelesai);
    let diff = Math.floor((end - start) / (1000*60*60*24)) + 1;
    if(diff < 1) diff = 1;
    document.getElementById("lama_cuti").value = diff;
  }
}
if(document.getElementById("dari_tgl")){
  document.getElementById("dari_tgl").addEventListener("change", hitungLamaCuti);
  document.getElementById("sampai_tgl").addEventListener("change", hitungLamaCuti);
}
</script>
