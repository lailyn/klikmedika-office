     

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
				$row  = $dt_pesan->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_pesan->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_pesan'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="front/pesan" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" action="depan/pesan/<?php echo $form ?>" method="POST" enctype="multipart/form-data">
              <div class="card-body">               
                <div class="form-group row">
                  <label for="fname" class="col-sm-2 text-right control-label col-form-label-sm">Nama</label>
                  <div class="col-sm-4">
                    <?php echo $form_id ?>
                    <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama : "" ; ?>" name="nama" class="form-control form-control-sm " placeholder="Nama">
                  </div>                  
                  <label for="fname" class="col-sm-2 text-right control-label col-form-label-sm">Email</label>
                  <div class="col-sm-4">                    
                    <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" class="form-control form-control-sm " placeholder="Email">
                  </div>                  
                </div>  
                <div class="form-group row">
                  <label for="fname" class="col-sm-2 text-right control-label col-form-label-sm">Subjek</label>
                  <div class="col-sm-4">                    
                    <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->subjek : "" ; ?>" name="subjek" class="form-control form-control-sm " placeholder="Subjek">
                  </div>
                  <label for="fname" class="col-sm-2 text-right control-label col-form-label-sm">Tgl Kirim</label>
                  <div class="col-sm-4">                    
                    <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->created_at : "" ; ?>" name="created_at" class="form-control form-control-sm " placeholder="Subjek">
                  </div>                
                </div>                
                <div class="form-group row">
                  <label for="cono1" class="col-sm-2 text-right control-label col-form-label-sm">Pesan</label>
                  <div class="col-sm-10">
                    <textarea rows="5" name="pesan" <?php echo $read ?> class="form-control form-control-sm "><?php echo $tampil = ($row!='') ? $row->pesan : "" ; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="border-top">
                <div class="card-body">
                  <a target="_blank" href='mailto:<?php echo $row->email ?>' class="btn btn-primary"><i class="mdi mdi-send"></i> Balas</a>                 
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
          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="pesan_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Nama</th>
                      <th>Subjek</th>
                      <th>Pesan</th>     
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

