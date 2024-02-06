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
		if($set=="insert" && $mode!="kategori"){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_sosmed->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_sosmed->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_sosmed'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/sosmed" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/sosmed/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
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
                      <label class="col-sm-2 col-form-label-sm">Kategori</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm " <?php echo $read2 ?> name="id_kategori">
                          <?php echo $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php     
                          $dt_kategori = $this->m_admin->getAll("md_kategoriSosmed");
                          foreach ($dt_kategori->result() as $isi) {
                            $id_kategori = ($row!='') ? $row->id_kategori : "";
                            if($id_kategori!='' && $id_kategori==$isi->id_kategori){
                             $se = "selected";
                            }else{
                              $se="";
                            }
                            echo "<option $se value='$isi->id_kategori'>$isi->kategori</option>";
                          }
                          ?>
                        </select>
                      </div>     
                      <div class="col-sm-2">
                        <a href="master/sosmed/kategori" class="btn btn-sm btn-primary">Tambah Kategori</a>
                      </div>    
                      <label class="col-sm-1 col-form-label-sm">Karyawan</label>
                      <div class="col-sm-4">
                        <?php 
                        $id_karyawan = $this->session->id_karyawan;
                        $cekK = $this->m_admin->getByID("md_karyawan","id_karyawan",$id_karyawan);

                        $nama_lengkap = ($cekK->num_rows()>0)?$cekK->row()->nama_lengkap:'';
                        ?>
                        <input readonly value="<?=$nama_lengkap; ?>" type="text" name="id_karyawan" placeholder="Karyawan" class="form-control form-control-sm">
                      </div>                                                                                               
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Link</label>
                      <div class="col-sm-10">         
                        <input type="hidden" name="link_lama" value="<?php echo $tampil = ($row!='') ? $row->link : "" ; ?>">               
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
    
    <?php 
    }elseif($set=="insert" && $mode=="kategori"){
      $read = "";
      $read2 = "";
      $form = "saveKategori";
      $vis  = "";
      $form_id = "";
      $row = "";
    ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/sosmed/add" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Back</a></h4>
            </div>
            <div class="card-body">
              <form action="master/sosmed/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Kategori</label>
                      <div class="col-sm-10">        
                        <?php echo $form_id ?>                
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->kategori : "" ; ?>" name="kategori" placeholder="Kategori" class="form-control form-control-sm " />
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

              <div class="box mt-4">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Kategori</th>                           
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>                  
                  <?php 
                  $no=1;
                  $sql = $this->m_admin->getAll("md_kategoriSosmed");                  
                  foreach($sql->result() AS $rt){
                    echo "
                      <tr>
                        <td>$no</td>
                        <td>$rt->kategori</td>
                        <td>
                          <a href='master/sosmed/deleteKategori?id=$rt->id_kategori' class='btn btn-danger btn-sm'>hapus</a>
                        </td>
                      </tr>
                    ";
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

    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="master/sosmed/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="sosmed_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Judul</th>     
                      <th>Jenis</th>                                                             
                      <th>Karyawan</th>                                                             
                      <th>Link</th>                                                             
                      <th>Waktu</th>                                                             
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
