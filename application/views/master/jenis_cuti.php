<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card card-primary">
          <div class="card-body">
            <?php if ($set=="view") { ?>
              <a href="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/add"
                 class="btn btn-primary btn-sm mb-3">
                <i class="fa fa-plus"></i> Tambah Data
              </a>

              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th style="width:5%;">No</th>
                    <th>Jenis Cuti</th>
                    <th>Keterangan</th>
                    <th style="width:20%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach($dt_jenis_cuti as $row){ ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $row->nama_jenis_cuti; ?></td>
                      <td><?php echo $row->keterangan; ?></td>
                      <td>
                        <a href="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/edit/<?php echo $row->id_jenis_cuti; ?>"
                           class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a>
                        <a href="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/delete/<?php echo $row->id_jenis_cuti; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Anda yakin ingin menghapus data ini?');">
                           <i class="fa fa-trash"></i> Hapus
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            <?php } elseif ($set=="add") { ?>
              <form action="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/save" method="post">
                <div class="form-group">
                  <label>Jenis Cuti</label>
                  <input type="text" class="form-control" name="nama_jenis_cuti" placeholder="Jenis Cuti" required>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" required>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>"
                     class="btn btn-secondary">Batal</a>
                </div>
              </form>

            <?php } elseif ($set=="edit") { ?>
              <form action="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>/save" method="post">
                <input type="hidden" name="id_jenis_cuti" value="<?php echo $dt_jenis_cuti->id_jenis_cuti; ?>">
                <div class="form-group">
                  <label>Jenis Cuti</label>
                  <input type="text" class="form-control" name="nama_jenis_cuti"
                         value="<?php echo $dt_jenis_cuti->nama_jenis_cuti; ?>" required>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" class="form-control" name="keterangan"
                         value="<?php echo $dt_jenis_cuti->keterangan; ?>" required>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?php echo base_url().$this->uri->segment(1)."/".$this->uri->segment(2); ?>"
                     class="btn btn-secondary">Batal</a>
                </div>
              </form>
            <?php } ?>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
