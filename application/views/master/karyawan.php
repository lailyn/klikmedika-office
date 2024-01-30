     

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
				$row  = $dt_karyawan->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "approve";              
				$form_id = "<input type='hidden' name='id' value='$row->id_karyawan'>";              
			}elseif($mode == 'edit'){
				$row  = $dt_karyawan->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_karyawan'>";              
			}

      if(isset($_GET['l'])){
        $link = "master/karyawan/lamaran";
      }elseif(isset($_GET['h'])){
        $link = "master/karyawan/history";
      }else{
        $link = "master/karyawan";
      }
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="<?php echo $link ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/karyawan/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-8">                        
                        <?php echo $form_id ?>                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control form-control-sm " />
                      </div>                                    
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Bagian</label>
                      <div class="col-sm-4">
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="id_bagian">
                          <?php $tampil = ($row!='') ? $row->id_bagian : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_bagian->result() as $isi) {
                            $id_bagian = ($row!='') ? $row->id_bagian : "";
                            if($id_bagian!='' && $id_bagian==$isi->id_bagian){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_bagian'>$isi->bagian</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                      
                      <label class="col-sm-2 col-form-label-sm">Status</label>
                      <div class="col-sm-4">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="status">
                          <?php echo $tampil = ($row!='') ? $row->status : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="1") echo 'selected' ?> value="1">Aktif</option>
                          <option <?php if($tampil=="0") echo 'selected' ?> value="0">Non-Aktif</option>
                        </select>
                      </div>                  
                    </div>                                                            
                    
                    <div class="form-group row">                      
                      <label class="col-sm-2 col-form-label-sm">Jenis Kelamin</label>
                      <div class="col-sm-4">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="jenis_kelamin">
                          <?php echo $tampil = ($row!='') ? $row->jenis_kelamin : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <option <?php if($tampil=="Laki-laki") echo 'selected' ?>>Laki-laki</option>
                          <option <?php if($tampil=="Perempuan") echo 'selected' ?>>Perempuan</option>
                        </select>
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
            <h4 class="card-title"><a href="master/karyawan/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="karyawan_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                                            
                      <th>Nama</th>                           
                      <th>Kontak</th>                                       
                      <th>Bagian</th>                 
                      <th>Alamat</th>                                    
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

