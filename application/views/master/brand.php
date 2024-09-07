     

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
			}elseif($mode == 'detail' OR $mode == 'approval'){
				$row  = $dt_brand->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "approve";              
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}elseif($mode == 'edit'){
				$row  = $dt_brand->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}

      if(isset($_GET['l'])){
        $link = "master/brand/lamaran";
      }elseif(isset($_GET['h'])){
        $link = "master/brand/history";
      }else{
        $link = "master/brand";
      }
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="<?php echo $link ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/brand/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Brand</label>
                      <div class="col-sm-8">                        
                        <?php echo $form_id ?>                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->brand : "" ; ?>" name="brand" placeholder="Brand" class="form-control form-control-sm " />
                      </div>                                    
                    </div>
                                                      

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">No HP</label>
                      <div class="col-sm-4">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_hp : "" ; ?>" name="no_hp" placeholder="No HP" class="form-control form-control-sm " />                                                
                      </div>                                          
                      <label class="col-sm-2 col-form-label-sm">Email</label>
                      <div class="col-sm-4">                        
                        <input type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control form-control-sm " />                        
                      </div>                                          
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Website</label>
                      <div class="col-sm-2">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->website : "" ; ?>" name="website" placeholder="Website" class="form-control form-control-sm " />                                                
                      </div>                                          
                      <label class="col-sm-1 col-form-label-sm">Pimpinan</label>
                      <div class="col-sm-3">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->pimpinan : "" ; ?>" name="pimpinan" placeholder="Pimpinan" class="form-control form-control-sm " />                        
                      </div>                                          
                      <label class="col-sm-1 col-form-label-sm">Logo</label>
                      <div class="col-sm-3">                          
                        <input type="file" name="logo" class="form-control form-control-sm " />                                                                        
                      </div>                                                          
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Bg Invoice</label>
                      <div class="col-sm-4">                        
                        <input type="file" name="bg_invoice" class="form-control form-control-sm " />                                                                        
                      </div>
                      <label class="col-sm-2 col-form-label-sm">Bg Customer Receipt</label>
                      <div class="col-sm-4">                        
                        <input type="file" name="bg_cr" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Alamat</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" name="alamat" class="form-control form-control-sm "><?php echo $tampil = ($row!='') ? $row->alamat : "" ; ?></textarea>                        
                      </div>                                                                
                    </div>                                        
                                       
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row" <?php echo $vis ?> >
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" value="save" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-light">Cancel</button>               
                      </div>
                    </div>
                    <?php if($mode=='approval'){ ?>
                    <div class="row">
                      <div class="col-md-6">                    
                        <button type="submit" name="submit" onclick="return confirm('Anda yakin approve data ini?')" value="approve" class="btn btn-primary">Approve</button>
                        <button type="submit" name="submit" onclick="return confirm('Anda yakin reject data ini?')" value="reject" class="btn btn-gradient-danger mr-2">Reject</button>                        
                      </div>
                    </div>
                    <?php } ?>
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
            <h4 class="card-title"><a href="master/brand/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="brand_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>Nama</th>                           
                      <th>Logo</th>                                       
                      <th>Kontak</th>                                       
                      <th>Web</th>                 
                      <th>Alamat</th>                                    
                      <th>Logo</th>                                    
                      <th>Bg Invoice</th>                                    
                      <th>Bg CR</th>                                    
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

