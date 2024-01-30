     

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
				$row  = $dt_slide->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_slide->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_slide'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="front/slide" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="front/slide/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Judul</label>
                      <div class="col-sm-10">    
                        <?php echo $form_id ?>                    
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->judul : "" ; ?>" name="judul" placeholder="Judul" class="form-control form-control-sm " />
                      </div>                                          
                    </div>                    
                    <div class="form-group row">                                                              
                      <label class="col-sm-2 col-form-label-sm">Status</label>
                      <div class="col-sm-4">                                              
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="draft") echo 'selected' ?>>draft</option>
                          <option <?php if($tampil=="publish") echo 'selected' ?>>publish</option>
                        </select>
                      </div>
                      <label class="col-sm-2 col-form-label-sm">Gambar</label>
                      <div class="col-sm-3">                          
                        <input class="form-control form-control-sm " type="file" name="gambar">
                      </div>
                      <?php 
                      $rt = "style=display:none";
                      $foto="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->gambar) OR $row->gambar==""){
                          $foto = "user.png";
                        }else{
                          $foto = $row->gambar;
                        }
                      }
                      ?>
                      <div <?php echo $rt ?> class="col-sm-1">                          
                        <a href="assets/art1kel/<?php echo $foto ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i></a>                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Isi Slide</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" name="isi" id="exampleTextarea1" class="form-control form-control-sm " rows="15">
                          <?php echo $tampil = ($row!='') ? $row->isi : "<br><br>---batas---" ; ?>
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
            <h4 class="card-title"><a href="front/slide/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="slide_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Judul</th>
                      <th>Gambar</th>                                       
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

