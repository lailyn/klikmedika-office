    

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
        $row  = $dt_profil->row();              
        $read = "readonly";
        $read2 = "disabled";
        $vis  = "style='display:none;'";
        $form = "save";              
        $form_id = "";
      }elseif($mode == 'edit'){
        $row  = $dt_profil->row();
        $read = "";
        $read2 = "";
        $form = "update";              
        $vis  = "";
        $form_id = "<input type='hidden' name='id' value='$row->id_user'>";              
      }
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">            
            <div class="card-body">
              <form action="master/profil/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control form-control-sm " />
                      </div>                                          
                      <label class="col-sm-2 col-form-label-sm">Password</label>
                      <div class="col-sm-4">                        
                        <input type="password" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? "" : "" ; ?>" name="password" placeholder="Kosongkan jika tidak diubah" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Email</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input type="email" readonly <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Foto</label>
                      <div class="col-sm-4">                        
                        <input type="file" name="foto" class="form-control form-control-sm " />
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
                        <button type="reset" class="btn btn-warning">Cancel</button>               
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



