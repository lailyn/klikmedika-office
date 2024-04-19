     

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
				$row  = $dt_prospek->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";$re="";
			}elseif($mode == 'edit'){
				$row  = $dt_prospek->row();
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
                <h4 class="card-title"><a href="master/prospek" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/prospek/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Faskes</label>
                      <div class="col-sm-8">         
                        <?php echo $form_id ?>               
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_faskes : "" ; ?>" name="nama_faskes" placeholder="Nama Faskes" class="form-control form-control-sm " />
                      </div>                                                                                
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama PIC</label>
                      <div class="col-sm-5">                        
                        <input type="text" required value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama PIC" class="form-control form-control-sm " />
                      </div>                                                                              
                      <label class="col-sm-1 col-form-label-sm">Foto</label>
                      <div class="col-sm-3">                          
                        <input type="file" name="logo" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">No HP</label>
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
                        </select>
                      </div>     

                      <label class="col-sm-1 col-form-label-sm">Tgl Prospek</label>
                      <div class="col-sm-2">                        
                        <input type="date" required value="<?php echo $tampil = ($row!='') ? $row->tgl_daftar : "" ; ?>" name="tgl_daftar" placeholder="Tgl Prospek" class="form-control form-control-sm " />
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
                      <label class="col-sm-2 col-form-label-sm">Status Prospek</label>
                      <div class="col-sm-3">                          
                        <select class="form-control form-control-sm" required name="status_prospek">
                          <?php echo $tampil = ($row!='') ? $row->status_prospek : "" ; ?>
                          <option <?=($tampil=="")?'selected':'';?> value="">- choose -</option>
                          <option <?=($tampil=="deal")?'selected':'';?> value="deal">Deal</option>
                          <option <?=($tampil=="hot")?'selected':'';?> value="hot">Hot Prospek</option>
                          <option <?=($tampil=="cold")?'selected':'';?> value="cold">Cold Prospek</option>
                          <option <?=($tampil=="cancel")?'selected':'';?> value="cancel">Cancel</option>
                        </select>
                      </div>
                    </div> 
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Keterangan</label>
                      <div class="col-sm-10">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->keterangan : "" ; ?>" name="keterangan" placeholder="Keterangan" class="form-control form-control-sm " />                                                                        
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
              <a href="master/prospek/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              <!-- <a href="master/prospek/import" class="btn btn-info btn-sm"><i class="mdi mdi-import"></i> Import</a>               -->
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>Nama Faskes</th>                                                                                       
                      <th>Alamat</th>                                                                                       
                      <th>No HP</th>                                                                                       
                      <th>Jenis</th>                                                                                       
                      <th>Nama PIC</th>                                                                                                                                                                                           
                      <th>Tgl Prospek</th>                                                                                   
                      <th>Keterangan</th>                                                                                   
                      <th>Status</th>                                                                                   
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php
                  $no=1;$where="";                                    
                  $sql = $this->db->select("p.*")                      
                      ->order_by("p.id","desc")
                      ->get("md_prospek p");                  
                  foreach ($sql->result() as $isi) {
                    if($isi->status_prospek=="hot"){
                      $bg = "yellow";
                      $status = "Hot Prospek";
                    }elseif($isi->status_prospek=="cold"){
                      $bg = "aqua";
                      $status = "Cold Prospek";
                    }elseif($isi->status_prospek=="deal"){
                      $bg = "green";
                      $status = "Deal";
                    }elseif($isi->status_prospek=="cancel"){
                      $bg = "red";
                      $status = "Cancel";
                    }else{
                      $bg = "";$status = "";
                    }
                                         

                    echo
                      "<tr>
                      <td>$no</td>                                            
                      <td><a href='master/prospek/detail?id=$isi->id'>$isi->nama_faskes</a></td>                      
                      <td>$isi->alamat</td>                                            
                      <td>$isi->no_hp</td>                                            
                      <td>$isi->jenis</td>                                            
                      <td>$isi->nama_lengkap</td>                                                                                        
                      <td>".tgl_indo($isi->tgl_daftar)."</td>                        
                      <td>$isi->keterangan</td>                                                                                        
                      <td bgcolor='$bg'>$status</td>                                                                                        
                      <td>
                            <a href=\"master/prospek/delete?id=$isi->id\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
                            <a href=\"master/prospek/edit?id=$isi->id\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>
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


