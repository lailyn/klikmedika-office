     

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
				$row  = $dt_user->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_user->row();
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
            <div class="card-header">
                <h4 class="card-title"><a href="master/user" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/user/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Nama User</label>
                      <div class="col-sm-10">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->nama_lengkap : "" ; ?>" name="nama_lengkap" placeholder="Nama User" class="form-control form-control-sm " />
                      </div>                                          
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Email</label>
                      <div class="col-sm-4">
                        <?php echo $form_id ?>
                        <input readonly type="email" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->email : "" ; ?>" name="email" placeholder="Email" class="form-control form-control-sm " />
                      </div>                    
                      <label class="col-sm-2 col-form-label-sm">Password</label>
                      <div class="col-sm-4">                          
                        <input type="password" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? "" : "" ; ?>" name="password" placeholder="Password" class="form-control form-control-sm " />                                                                        
                      </div>
                    </div> 

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">ID User Type</label>
                      <div class="col-sm-4">
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="id_user_type">
                          <?php $tampil = ($row!='') ? $row->id_user_type : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
                          foreach ($dt_user_type->result() as $isi) {
                            $id_user_type = ($row!='') ? $row->id_user_type : "";
                            if($id_user_type!='' && $id_user_type==$isi->id_user_type){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_user_type'>$isi->user_type</option>";
                          }
                          ?>
                        </select>
                      </div>                       
                    </div>

                    
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Foto</label>
                      <?php 
                      $rt = "style=display:none";
                      $foto="";
                      if($mode!="insert"){ 
                        $rt = "";
                        if(!isset($row->foto) OR $row->foto==""){
                          $foto = "user.png";
                        }else{
                          $foto = $row->foto;
                        }
                      }
                      ?>
                        <div class='col-sm-4'>
                        <input type="file" name="foto" class="form-control form-control-sm ">                          
                        </div>
                        <div class='col-sm-2'></div>
                        <div <?php echo $rt ?> class='col-sm-4'><img width="300px" src="assets/im493/<?php echo $foto ?>">                                              
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
          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th></th>
                      <th>Nama User</th>     
                      <th>Email</th>                                                                                                                                             
                      <th>No HP</th>                                                                                                                                             
                      <th>User Type</th>                      
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>                  
                  <?php 
                  $no=1;
                  if($this->session->id_user_type==5) $list = $this->db->query("SELECT * FROM md_user ORDER BY id_user DESC");
                    else  $list = $this->db->query("SELECT * FROM md_user WHERE id_user_type <> 5 ORDER BY id_user DESC");                  
                  foreach ($list->result() as $isi) {
                    $r = $this->m_admin->getByID("md_user_type","id_user_type",$isi->id_user_type);
                    $user_type = ($r->num_rows() > 0) ? $r->row()->user_type : "" ;         
                    $jenis = (!is_null($isi->jenis) AND $isi->jenis!="") ? $isi->jenis : "umum" ;         
                    
                    if(!isset($isi->foto) AND $isi->foto==""){
                      $foto = "user.png";
                    }else{
                      $foto = $isi->foto;
                    }
                    
                    
                    if($isi->status==1) $status = "<label class='badge badge-success'>Aktif</label>";      
                      else $status = "";     
                    if($isi->email_sent==1) $email_sent = "<label class='badge badge-info'>Email Sent</label>";      
                      else $email_sent = "";     
                    if($isi->banned==1) $banned = "<label class='badge badge-danger'>Banned</label>";      
                      else $banned = "";     
                    if($isi->email_verified==1) $email_verified = "<label class='badge badge-primary'>Verified</label>";      
                      else $email_verified = "";     
                    

                    echo "
                    <tr>
                    <td>$no</td>
                    <td><a href='master/user/detail?id=$isi->id_user'><img src='assets/im493/$foto' class='img-circle elevation-2' width='40px'></a></td>
                    <td><a href='master/user/detail?id=$isi->id_user'>$isi->nama_lengkap</a></td>
                    <td>$isi->email $status $banned</td>                                                            
                    <td>$isi->no_hp</td>                                                            
                    <td>$user_type</td>                          
                    <td>
                      <div class='btn-group'>
                        <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                        <div class='dropdown-menu'>
                          <a href=\"master/user/delete?id=$isi->id_user\" onclick=\"return confirm('Anda yakin?')\" class='dropdown-item'>Hapus</a>
                          <a href=\"master/user/edit?id=$isi->id_user\" class='dropdown-item'>Edit</a>                          
                        </div>
                      </div>                          
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

