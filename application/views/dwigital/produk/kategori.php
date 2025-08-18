     <?php
      $absolute_path = "dwigital/produk/kategori";
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
          $form = "save";
          $vis  = "";
          $form_id = "";
          $row = "";
        } elseif ($mode == 'detail') {
          $row  = $dt_produk_kategori->row();
          $read = "readonly";
          $read2 = "disabled";
          $vis  = "style='display:none;'";
          $form = "save";
          $form_id = "";
        } elseif ($mode == 'edit') {
          $row  = $dt_produk_kategori->row();
          $read = "";
          $read2 = "";
          $form = "update";
          $vis  = "";
          $form_id = "<input type='hidden' name='id' value='$row->id'>";
        }
      ?>

       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title"><a href="<?= $absolute_path ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
             </div>
             <div class="card-body">
               <div class="col-12">
                 <form action="<?= $absolute_path ?>/<?php echo $form ?>" enctype="multipart/form-data" method="POST" class="form-sample">
                   <div class="row">
                     <div class="col-md-12">
                       <div class="form-group row">
                         <label class="col-sm-2 col-form-label-sm">Kategori</label>
                         <div class="col-sm-10">
                           <?php echo $form_id ?>
                           <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row != '') ? $row->nama : ""; ?>" name="nama" placeholder="Kategori" class="form-control form-control-sm " />
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-md-12">
                       <div class="form-group row">
                         <label class="col-sm-2 col-form-label-sm">Deskripsi</label>
                         <div class="col-sm-10">
                           <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm"><?php echo ($row != '') ? $row->deskripsi : ""; ?></textarea>
                         </div>
                       </div>
                     </div>
                   </div>
                   <hr>
                   <div class="row" <?php echo $vis ?>>
                     <div class="col-md-6">
                       <button type="submit" class="btn btn-primary">Save</button>
                       <button type="reset" class="btn btn-light">Cancel</button>
                     </div>
                   </div>
                 </form>
               </div>
             </div>
           </div>
         </div>
       </div>
       </div>

     <?php } else { ?>


       <div class="row">
         <div class="col-12 grid-margin">
           <div class="card">
             <div class="card-header">
               <h4 class="card-title"><a href="<?= $absolute_path ?>/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
             </div>
             <div class="card-body">
               <div class="box">
                 <div class="table-responsive">
                   <table id="example" class="table" style="width:100%">
                     <thead>
                       <tr>
                         <th width="5%">No</th>
                         <th>Kategori</th>
                         <th>Deskripsi</th>
                         <th width="10%"></th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                        $no = 1;
                        foreach ($dt_produk_kategori->result() as $isi) {
                          echo "
                    <tr>
                      <td>$no</td>
                      <td>$isi->nama</td>                      
                      <td>$isi->deskripsi</td>                      
                      <td>"; ?>
                         <a href="<?= $absolute_path ?>/delete?id=<?php echo $isi->id ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
                         <a href="<?= $absolute_path ?>/edit?id=<?php echo $isi->id ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                       <?php
                          echo "</td>
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

     <?php } ?>