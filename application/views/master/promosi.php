<base href="<?php echo base_url(); ?>" />     

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
				$row  = $dt_promosi->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_promosi->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_promosi'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/promosi" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/promosi/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Judul</label>
                      <div class="col-sm-4">        
                        <?php echo $form_id ?>                
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->judul : "" ; ?>" name="judul" placeholder="Judul" class="form-control form-control-sm " />
                      </div>              
                      <label class="col-sm-2 col-form-label-sm">Jenis</label>
                      <div class="col-sm-4">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="jenis">
                          <?php echo $tampil = ($row!='') ? $row->jenis : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="Promosi") echo 'selected' ?>>Promosi</option>
                          <option <?php if($tampil=="Layanan") echo 'selected' ?>>Layanan</option>
                          <option <?php if($tampil=="Penjualan") echo 'selected' ?>>Penjualan</option>
                          <option <?php if($tampil=="Voucher") echo 'selected' ?>>Voucher</option>
                          <option <?php if($tampil=="Lain-lain") echo 'selected' ?>>Lain-lain</option>
                        </select>
                      </div>                                                                                
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Jadwal Kirim</label>
                      <div class="col-sm-2">                        
                        <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tgl : date("Y-m-d") ; ?>" name="tgl" placeholder="Tanggal Posting" class="form-control form-control-sm " />
                      </div>              
                      <div class="col-sm-2">           
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->jam : date("h:i:s") ; ?>" name="jam" class="form-control form-control-sm time" placeholder="00:00:00">                                                           
                      </div>              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Isi</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->isi : "" ; ?>" name="isi" placeholder="Isi" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Link</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->link : "" ; ?>" name="link" placeholder="Link" class="form-control form-control-sm " />
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
            <h4 class="card-title"><a href="master/promosi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="promosi_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Judul</th>     
                      <th>Isi</th>                                       
                      <th>Jenis</th>                                                             
                      <th>Jadwal Kirim</th>                                                             
                      <th width="15%"></th>
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
