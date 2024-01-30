     

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
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_setting->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_setting->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_setting'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/setting" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/setting/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Pimpinan</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_pimpinan : "" ; ?>" name="nama_pimpinan" placeholder="Nama Pimpinan" class="form-control form-control-sm " />
                      </div>                                          
                      <label class="col-sm-2 col-form-label-sm">Nama Perusahaan</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->perusahaan : "" ; ?>" name="perusahaan" placeholder="Nama Perusahaan" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Email</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">No Telp</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_telp : "" ; ?>" name="no_telp" placeholder="No Telp" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">URL</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->url : "" ; ?>" name="url" placeholder="URL" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">No HP</label>
                      <div class="col-sm-4">  
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text form-control-sm " id="btnGroupAddon2">62</div>
                          </div>
                          <input <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>"  type="text" minlength="10" maxlength="13" required name="no_hp" class="form-control form-control-sm" placeholder="823xxx" aria-label="Input group example" aria-describedby="btnGroupAddon2">
                        </div>                                                
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Instagram</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->instagram : "" ; ?>" name="instagram" placeholder="Instagram" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">Facebook</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->facebook : "" ; ?>" name="facebook" placeholder="Facebook" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Tiktok</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tiktok : "" ; ?>" name="tiktok" placeholder="Tiktok" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">Youtube</label>
                      <div class="col-sm-4">                          
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->youtube : "" ; ?>" name="youtube" placeholder="Facebook" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Admin</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->admin : "" ; ?>" name="admin" placeholder="Nama Admin" class="form-control form-control-sm " />
                      </div>                    
                    </div>                    
                    <div class="form-group row">  
                      <label class="col-sm-2 col-form-label-sm">Password Karyawan</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->pass_karyawan : "" ; ?>" name="pass_karyawan" placeholder="Password Karyawan" class="form-control form-control-sm " />
                      </div>                      
                      <label class="col-sm-2 col-form-label-sm">Password Konsumen</label>
                      <div class="col-sm-4">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->pass_konsumen : "" ; ?>" name="pass_konsumen" placeholder="Password Konsumen" class="form-control form-control-sm " />
                      </div>                      
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Alamat Perusahaan</label>
                      <div class="col-sm-10">
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->alamat : "" ; ?>" name="alamat" placeholder="Alamat Perusahaan" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    

                    

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Banner Halaman</label>
                      <?php 
                      $rt = "style=display:none";
                      $banner="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->banner) OR $row->banner==""){
                          $banner = "user.png";
                        }else{
                          $banner = $row->banner;
                        }
                      }
                      ?>
                        <div class='col-sm-3'>
                        <input type="file" name="banner" class="form-control form-control-sm ">                          
                        </div>                        
                        <div <?php echo $rt ?> class='col-sm-1'><img width="80px" src="assets/im493/<?php echo $banner ?>">                                              
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Logo</label>
                      <?php 
                      $rt = "style=display:none";
                      $logo="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->logo) OR $row->logo==""){
                          $logo = "user.png";
                        }else{
                          $logo = $row->logo;
                        }
                      }
                      ?>
                        <div class='col-sm-3'>
                        <input type="file" name="logo" class="form-control form-control-sm ">                          
                        </div>                        
                        <div <?php echo $rt ?> class='col-sm-1'><img width="80px" src="assets/im493/<?php echo $logo ?>">                                              
                      </div>                                                                
                    
                      <label class="col-sm-2 col-form-label-sm">Favicon</label>
                      <?php 
                      $rt = "style=display:none";
                      $fav="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->fav) OR $row->fav==""){
                          $fav = "user.png";
                        }else{
                          $fav = $row->fav;
                        }
                      }
                      ?>
                        <div class='col-sm-3'>
                        <input type="file" name="fav" class="form-control form-control-sm ">                          
                        </div>
                        <div <?php echo $rt ?> class='col-sm-1'><img width="80px" src="assets/im493/<?php echo $fav ?>">                                              
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
    
    <?php } ?>



