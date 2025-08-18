<style type="text/css">
.password-masked {
    font-family: 'password-mask', sans-serif;
    -webkit-text-security: disc; /* Safari */
    text-security: disc; /* Proposal for future CSS spec */
}

/* Fallback for other browsers */
@font-face {
    font-family: 'password-mask';
    src: local('Arial');
    unicode-range: U+002A; /* Replace all characters with asterisk */
}

.password-masked::placeholder {
    color: #ccc; /* Customize placeholder color */
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
		if($set=="insert" AND $mode!='import'){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
        $re = "required";
			}elseif($mode == 'detail'){
				$row  = $dt_produk->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";$re="";
			}elseif($mode == 'edit'){
				$row  = $dt_produk->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
        $re="";
				$form_id = "<input type='hidden' name='id' value='$row->id_produk'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="dwigital/produk/produk" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="dwigital/produk/produk/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Kode Produk</label>
                      <div class="col-sm-2">
                        <?php echo $form_id ?>
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kode_produk : "" ; ?>" name="kode_produk" placeholder="Kode Produk" class="form-control form-control-sm " />
                      </div>
                      
                    </div>            
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Produk *</label>
                      <div class="col-sm-8">                        
                        <input type="text" required <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_produk : "" ; ?>" name="nama_produk" placeholder="Nama Produk" class="form-control form-control-sm " />
                      </div>                                                          
                      <div class="form-check mx-sm-2">
                        <label class="form-check-label">
                          <?php $on = ($row!='') ? $row->status : "" ; ?>                                                    
                          <input type="checkbox" <?php echo $n = ($on==0 && $row!='') ? '' : 'checked' ?> name="status" class="form-check-input" value='1'> Aktif </label>                      
                      </div>                                                                                                                                     
                    </div>
                    <div class="form-group row">
                      
                      <label class="col-sm-2 col-form-label-sm">Kategori *</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm " required <?php echo $read2 ?> name="id_produk_kategori">
                          <?php $tampil = ($row!='') ? $row->id_produk_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_produk_kategori->result() as $isi) {
                            $id_produk_kategori = ($row!='') ? $row->id_produk_kategori : "";
                            if($id_produk_kategori!='' && $id_produk_kategori==$isi->id){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id'>$isi->nama</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <label class="col-sm-1 col-form-label-sm">Stok Awal</label>
                      <div class="col-sm-1">                        
                        <input type="number" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->stok : "" ; ?>" name="stok" placeholder="Stok" class="form-control form-control-sm " />                                                                                                                        
                      </div>
                   
                      
                    </div>
                    <hr>       
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Harga Beli</label>
                      <div class="col-sm-2">                          
                        <input type="text" data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->harga_beli : "" ; ?>" name="harga_beli" placeholder="Harga Beli" class="form-control form-control-sm " />                                                                        
                      </div>
                      <!--label class="col-sm-1 col-form-label-sm">Tipe Diskon</label>
                      <div class="col-sm-2">                        
                        <select class="form-control form-control-sm" name="tipe_diskon">
                          <option value="rp">Rupiah</option>
                          <option value="persen">Persen</option>
                        </select>
                      </div>                    
                      <label class="col-sm-1 col-form-label-sm">Diskon</label>
                      <div class="col-sm-1">                        
                        <input type="text" data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->harga_diskon : "" ; ?>" name="diskon" placeholder="Diskon" class="form-control form-control-sm " />
                      </div>                    
                    </div>             
                    
                    <div class="form-group row"-->                                                                                                                             
                      <label class="col-sm-1 col-form-label-sm">Harga Jual *</label>
                      <div class="col-sm-2">                          
                        <input type="text" id="harga_jual" required data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->harga : "" ; ?>" name="harga_1" placeholder="Harga Jual Eceran" class="form-control form-control-sm " />                                                                        
                      </div>

                      <label class="col-sm-1 col-form-label-sm">Kapsitas *</label>
                      <div class="col-sm-2">                          
                        <input type="number" id="kapasitas" required data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kapasitas : "" ; ?>" name="kapasitas" placeholder="Kapasitas" class="form-control form-control-sm " />                                                                        
                      </div>
                      
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Satuan (Retail) *</label>
                      <div class="col-sm-2">                          
                        <input type="text" id="satuan" required <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->sat_kecil : "" ; ?>" name="sat_kecil" placeholder="Satuan" class="form-control form-control-sm " />                                                                        
                      </div>
                      
                      <label class="col-sm-1 col-form-label-sm">Supplier</label>
                      <div class="col-sm-5">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->supplier : "" ; ?>" name="supplier" placeholder="Supplier" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Keterangan</label>
                      <div class="col-sm-10">                        
                        <textarea <?php echo $read2 ?> name="keterangan" class="form-control form-control-sm ">
                          <?php echo $tampil = ($row!='') ? $row->keterangan : "" ; ?>
                        </textarea>
                      </div>                                          
                    </div>                                                     
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Gambar</label>
                      <?php
                      $rt = "style=display:none";
                      $gambar = "";
                      if ($mode != "insert") {
                        $rt = "";
                        if (!isset($row->gambar) or $row->gambar == "") {
                          $gambar = "produk.png";
                        } else {
                          $gambar = $row->gambar;
                        }
                      }
                      ?>
                      <div class='col-sm-4'>
                        <input type="file" name="gambar" class="form-control form-control-sm ">
                      </div>
                      <div class='col-sm-2'></div>
                      <div <?php echo $rt ?> class='col-sm-4'><img width="300px" src="assets/pr0duk/<?php echo $gambar ?>">
                      </div>
                    </div>                    
                                                                                               

                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" class="btn btn-primary">Save</button>
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
    
    <?php 
    }elseif($set=='insert' AND $mode=='import'){
    ?>
    
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
              <h4 class="card-title">
                <a href="dwigital/produk/produk" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
                <a href="dwigital/produk/produk/download" class="btn btn-success btn-sm"><i class="mdi mdi-download"></i> Download Template</a>
              </h4>              
          </div>
          <div class="card-body">
            <form action="dwigital/produk/produk/importExcel" method="POST" enctype="multipart/form-data" class="form-sample">                  
              <div class="row">
                <div class="col-12">                
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label-sm">Upload</label>
                    <div class="col-sm-8">                        
                      <input type="file" name="file" class="form-control form-control-sm" />
                    </div>                                                                              
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row">
                      <div class="col-md-6">                    
                        <button type="submit" class="btn btn-primary">Save</button>                        
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
          <div class="card-header">
            <h4 class="card-title">
              <a href="dwigital/produk/produk/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              <a href="dwigital/produk/produk/import" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> Import Data</a>              
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="produk_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>Nama Produk</th>                        
                      <th>Kode</th>                                                                                                                                                                                                  
                      <th>Kategori</th>                                                             
                      <th>Stok</th>                                                               
                      <th>Satuan</th>                 
                      <th>Harga Beli</th>                 
                      <th>Harga Jual</th>                                       
                      <th>Ket</th>                                       
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody> 
                              
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
function back(){
  window.history.back();
}
$(document).ready(function() {        
  $('#samakan').change(function() {
    if ($(this).is(':checked')) {      
      var harga_jual = $('#harga_jual').val();      
      $('#harga_resep').val(harga_jual);
      document.getElementById("harga_resep").setAttribute('readonly',true);
    }else{
      $('#harga_resep').val("");
      document.getElementById("harga_resep").removeAttribute('readonly');
    }
  });  
});
</script>