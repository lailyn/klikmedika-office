     

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
    if($set=="insert"){
      if($mode == 'insert'){
        $read = "";
        $read2 = "";
        $form = "save";
        $vis  = "";
        $form_id = "";
        $komp  = "style='display:none;'";
        $row = "";
      }elseif($mode == 'detail' OR $mode == 'tambah_detail'){
        $row  = $dt_pemasukan->row();              
        $read = "readonly";
        $read2 = "disabled";
        if($mode=="tambah_detail") $komp = "";
          else $komp  = "style='display:none;'";
        $vis  = "style='display:none;'";
        $form = "save_detail";              
        $form_id = "<input type='hidden' name='id' value='$row->id_pemasukan'><input type='hidden' name='kode' value='$row->kode_pemasukan'>";              
      }elseif($mode == 'edit'){
        $row  = $dt_pemasukan->row();
        $read = "";
        $read2 = "";
        $komp  = "style='display:none;'";
        $form = "update";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id_pemasukan'>";              
      }
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="finance/pemasukan" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="finance/pemasukan/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">         
                    <div class="form-group row">
                      <?php echo $form_id ?>
                      <label class="col-sm-2 col-form-label-sm">Uraian</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" <?php echo $read2 ?> name="uraian" id="exampleTextarea1" class="form-control form-control-sm " rows="15">
                          <?php echo $tampil = ($row!='') ? $row->uraian : "" ; ?>
                        </textarea>
                      </div>                                          
                    </div>
                    
                    <div class="form-group row">                    
                      <label class="col-sm-2 col-form-label-sm">Kategori</label>
                      <div class="col-sm-3">                          
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="id_kategori">
                          <?php $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                
                          $dt_kategori = $this->m_admin->getAll("md_pemasukan_kategori");           
                          foreach ($dt_kategori->result() as $isi) {
                            $id_kategori = ($row!='') ? $row->id_kategori : "";
                            if($id_kategori!='' && $id_kategori==$isi->id){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id'>$isi->kategori</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-sm-2"><a href="finance/pemasukan/kategori" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Kategori </a></div>                      
                      <label class="col-sm-1 col-form-label-sm">Total</label>
                      <div class="col-sm-3">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->total : "" ; ?>" name="total" placeholder="Total" data-type="currency" class="form-control form-control-sm">
                      </div>
                    </div>                          
                    <div class="form-group row">     
                      <label class="col-sm-2 col-form-label-sm">Tanggal</label>
                      <div class="col-sm-2">
                        <input <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tgl : date("Y-m-d") ; ?>" type="date" name="tgl" placeholder="Tanggal" class="form-control form-control-sm">
                      </div>               
                      <div class="col-sm-2"></div>
                      
                      <label class="col-sm-2 col-form-label-sm">File Pendukung</label>
                      <div class="col-sm-3">                          
                        <input <?php echo $read ?> class="form-control form-control-sm" type="file" name="file_pendukung">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $file_pendukung="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->file_pendukung) OR $row->file_pendukung==""){
                          $file_pendukung = "user.png";
                        }else{
                          $file_pendukung = $row->file_pendukung;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/fin4nc3/<?php echo $file_pendukung ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>                        
                      </div>
                    </div>                                        
                                                                                                                               
                    
                    <?php if($mode=="tambah_detail" OR $mode=="detail"){ ?>                                                    
                      <hr>
                      <?php include("detail.php"); ?>
                    <?php } ?>
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" value="save" class="btn btn-primary">Save</button>
                        <button type="submit" name="submit" value="detail" class="btn btn-primary">Save & Add Detail</button>
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                  </div>
                </div>
              </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <?php }elseif($set=="kategori"){ ?>


      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="finance/pemasukan/add" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Back</a></h4>
            </div>
            <div class="card-body">
              <form action="finance/pemasukan/simpan_kategori" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                             
                    <div class="form-group row">                    
                      <label class="col-sm-1 col-form-label-sm">Kategori</label>
                      <div class="col-sm-3">
                        <input type="text" name="kategori" placeholder="Kategori" class="form-control form-control-sm">
                      </div>                      
                      <div class="col-sm-2"></div>
                      <div class="col-sm-6">
                        <div class="table-responsive">
                          <table id="example1" class="table" style="width:100%">
                            <thead>
                              <tr>
                                <th>Kategori</th>
                                <th width="5%"></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach($dt_pemasukan_kategori->result() AS $row){
                              echo "
                              <tr>
                                <td>$row->kategori</td>
                                <td>"; ?>
                                  <a href="finance/pemasukan/delete_pemasukan?id=<?php echo $row->id ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>                                                            
                              </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row">
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" value="save" class="btn btn-primary">Save</button>                        
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                          
                      <th>Kode Transaksi</th>                      
                      <th>Tanggal</th>                      
                      <th>Sumber</th>
                      <th>Jenis</th>
                      <th>Uraian</th>   
                      <th>Total</th>  
                    </tr>
                  </thead>
                  <tbody>         
                  <?php 
                  $no=1;
                  $cek = $this->db->query("SELECT * FROM md_pemasukan ORDER BY md_pemasukan.id_pemasukan DESC");
                  foreach($cek->result() AS $row){
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>$row->no_transaksi</td>
                      <td>$row->tgl_pemasukan</td>
                      <td>$row->sumber</td>
                      <td>$row->jenis_transaksi</td>
                      <td>$row->uraian</td>
                      <td>".mata_uang($row->total)."</td>
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

  

<script type="text/javascript">
function cek_produk(){
  var id_produk = $("#id_produk").val();                       
  $.ajax({
      url : "<?php echo site_url('finance/pemasukan/cari_produk')?>",
      type:"POST",
      data:"id_produk="+id_produk,            
      cache:false,
      success:function(msg){                
          data=msg.split("|");          
          $("#nama_produk").val(data[0]);                
          $("#satuan").val(data[2]);                                                                
          $("#jenis").val(data[1]);                                                                
          $("#harga").val(data[3]);                                                                          
          $("#qty").focus();
      }
  })     
}
function kalikan(){
  var qty = $("#qty").val();                       
  var harga = $("#harga").val();                       
  var subtotal = parseInt(qty) * parseInt(harga);
  $("#subtotal").val(subtotal);
}
</script>