     

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
				$row  = $dt_client->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";$re="";
			}elseif($mode == 'edit'){
				$row  = $dt_client->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
        $re="";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/client" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/client/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Faskes</label>
                      <div class="col-sm-8">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_faskes : "" ; ?>" name="nama_faskes" placeholder="Nama Faskes" class="form-control form-control-sm " />
                      </div>                                                          
                      <div class="form-check mx-sm-2">
                        <label class="form-check-label">
                          <?php $on = ($row!='') ? $row->status : "" ; ?>                                                    
                          <input type="checkbox" <?php echo $n = ($on==0 && $row!='') ? '' : 'checked' ?> name="status" class="form-check-input" value='1'> Aktif </label>                      
                      </div>                                                                                                                                     
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama PIC</label>
                      <div class="col-sm-5">                        
                        <input type="text" required value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama PIC" class="form-control form-control-sm " />
                      </div>                                                                              
                      <label class="col-sm-1 col-form-label-sm">Logo</label>
                      <div class="col-sm-3">                          
                        <input type="file" name="logo" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Kode</label>
                      <div class="col-sm-2">
                        <?php echo $form_id ?>
                        <input type="text" required value="<?php echo $tampil = ($row!='') ? $row->kode_faskes : "" ; ?>" name="kode_faskes" placeholder="Kode" class="form-control form-control-sm " />
                      </div>                                                                              
                      <label class="col-sm-1 col-form-label-sm">No HP</label>
                      <div class="col-sm-2">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control form-control-sm " />                                                                        
                      </div>
                      
                    
                      <label class="col-sm-1 col-form-label-sm">Jenis</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="jenis">                        
                          <?php $tampil = ($row!='') ? $row->jenis : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>                          
                          <option <?php if($tampil=="klinik-pratama") echo 'selected' ?> value="klinik-pratama">Klinik Pratama</option>                          
                          <option <?php if($tampil=="klinik-utama") echo 'selected' ?> value="klinik-utama">Klinik Utama</option>                          
                          <option <?php if($tampil=="klinik-gigi") echo 'selected' ?> value="klinik-gigi">Klinik Gigi</option>                          
                          <option <?php if($tampil=="praktik-mandiri") echo 'selected' ?> value="praktik-mandiri">Praktik Mandiri</option>                          
                          <option <?php if($tampil=="lab") echo 'selected' ?> value="lab">Laboratorium</option>                          
                          <option <?php if($tampil=="puskesmas") echo 'selected' ?> value="puskesmas">Puskesmas</option>                          
                          <option <?php if($tampil=="pemda") echo 'selected' ?> value="pemda">Pemda</option>                          
                          <option <?php if($tampil=="instansi-swasta") echo 'selected' ?> value="instansi-swasta">Instansi Swasta</option>                          
                          <option <?php if($tampil=="lainnya") echo 'selected' ?> value="lainnya">Lainnya</option>                          
                        </select>
                      </div>                      
                                                            
                    </div>
                                          
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Alamat</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" <?php echo $read2 ?> name="alamat" id="exampleTextarea1" class="form-control form-control-sm " rows="15">
                          <?php echo $tampil = ($row!='') ? $row->alamat : "" ; ?>
                        </textarea>
                      </div>                                          
                    </div>     
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Kelurahan</label>
                      <div class="col-sm-10">                        
                        <select id="id_kelurahan" class="form-control form-control-sm js-select2" <?php echo $read2 ?> name="id_kelurahan">                        
                          <option value="">Ketik Kata Kunci</option>
                        </select>
                      </div>                    
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Tgl Daftar</label>
                      <div class="col-sm-2">                        
                        <input type="date" required value="<?php echo $tampil = ($row!='') ? $row->tgl_daftar : "" ; ?>" name="tgl_daftar" placeholder="Tgl Daftar" class="form-control form-control-sm " />
                      </div>                                                                              
                      <label class="col-sm-1 col-form-label-sm">Tgl Aktif</label>
                      <div class="col-sm-2">                          
                        <input type="date" value="<?php echo $tampil = ($row!='') ? $row->tgl_aktif : "" ; ?>" name="tgl_aktif" placeholder="Tgl Aktif" class="form-control form-control-sm " />
                      </div>
                      <label class="col-sm-1 col-form-label-sm">Tgl Kadaluarsa</label>
                      <div class="col-sm-2">                          
                        <input type="date" value="<?php echo $tampil = ($row!='') ? $row->tgl_kadaluarsa : "" ; ?>" name="tgl_kadaluarsa" placeholder="Tgl Kadaluarsa" class="form-control form-control-sm " />
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Langganan</label>
                      <div class="col-sm-2">                        
                        <select class="form-control form-control-sm" <?php echo $read2 ?> name="langganan">                        
                          <?php $tampil = ($row!='') ? $row->langganan : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>                          
                          <option <?php if($tampil=="pra-bayar") echo 'selected' ?> value="pra-bayar">Pra Bayar</option>                          
                          <option <?php if($tampil=="pasca-bayar") echo 'selected' ?> value="pasca-bayar">Pasca Bayar</option>                                                    
                        </select>
                      </div>
                      <label class="col-sm-1 col-form-label-sm">No MoU Terakhir</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_mou : "" ; ?>" name="no_mou" placeholder="No MoU" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Tgl Invoice</label>
                      <div class="col-sm-2">                        
                        <input type="number" required value="<?php echo $tampil = ($row!='') ? $row->tgl_invoice : "" ; ?>" name="tgl_invoice" placeholder="Tgl Invoice" class="form-control form-control-sm " />
                      </div>      
                      <label class="col-sm-1 col-form-label-sm">Brand</label>
                      <div class="col-sm-4">
                        <select <?=$read2?> class="form-control form-control-sm select2" required name="id_brand">                      
                          <option value="">- pilih -</option>
                          <?php                                       
                          $dt_user = $this->db->query("SELECT * FROM md_brand ORDER BY id ASC");                   
                          foreach ($dt_user->result() as $isi) { 
                            $id_brand = ($row!='') ? $row->id_brand : '';
                            if($isi->id==$id_brand) $rt = "selected";
                              else $rt = "";                             
                            echo "<option $rt value='$isi->id'>$isi->brand</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                                              
                    </div>  
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Keterangan</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote2" <?php echo $read2 ?> name="keterangan" id="exampleTextarea1" class="form-control form-control-sm " rows="15">
                          <?php echo $tampil = ($row!='') ? $row->keterangan : "" ; ?>
                        </textarea>
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

    

    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              <a href="master/client/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              <!-- <a href="master/client/import" class="btn btn-info btn-sm"><i class="mdi mdi-import"></i> Import</a>               -->
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table table-responsive" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                                                
                      <th>Nama Instansi</th>                                                                                       
                      <th>Alamat</th>                                                                                       
                      <th>No HP</th>                                                                                       
                      <th>Jenis</th>                                                                                       
                      <th>Nama PIC</th>                                                                                                                                                                     
                      <th>Langganan</th>                                                             
                      <th>Tgl Invoice</th>                                                             
                      <th>Tgl Daftar</th>                                                             
                      <th>Tgl Aktif</th>                                                             
                      <th>Tgl Kadaluarsa</th>                                                                                                         
                      <th>Brand</th>                                                                                                         
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php
                  $no=1;$where="";                                    
                  $sql = $this->db->select("p.*")                      
                      ->order_by("p.id","desc")
                      ->get("md_client p");                  
                  foreach ($sql->result() as $isi) {
                     
                    if($isi->status==1) $status = "<label class='badge badge-success'>aktif</label>";
                      else $status = "<label class='badge badge-danger'>non-aktif</label>";
                    
                    if(!isset($isi->logo) AND $isi->logo==""){
                      $gambar = "produk.png";
                    }else{
                      $gambar = $isi->logo;
                    }

                    $cek_brand = $this->m_admin->getByID("md_brand","id",$isi->id_brand);
                    $brand = ($cek_brand->num_rows()>0) ? $cek_brand->row()->brand : "" ;                    

                    echo
                      "<tr>
                      <td>$no</td>                                            
                      <td><a href='master/client/detail?id=$isi->id'>$isi->nama_faskes $status</a></td>                      
                      <td>$isi->alamat</td>                                            
                      <td>$isi->no_hp</td>                                            
                      <td>$isi->jenis</td>                                            
                      <td>$isi->nama_lengkap</td>                                                                  
                      <td>$isi->langganan</td>                                                                  
                      <td>$isi->tgl_invoice</td>                                                                  
                      <td>".tgl_indo($isi->tgl_daftar)."</td>                        
                      <td>".tgl_indo($isi->tgl_aktif)."</td>                        
                      <td>".tgl_indo($isi->tgl_kadaluarsa)."</td>                        
                      <td>$brand</td>                        
                      <td>
                            <a href=\"master/client/delete?id=$isi->id\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
                            <a href=\"master/client/edit?id=$isi->id\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>
                      </td>
                      </tr>";
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



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".js-select2").select2({
      ajax: { 
        url: '<?= base_url() ?>master/provinsi/ambil_kelurahan_all',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
              term: params.term // search term
          };
        },
        processResults: function (response) {
          return {
              results: response
          };
        },
        cache: true
      }
  });
});  
</script>


