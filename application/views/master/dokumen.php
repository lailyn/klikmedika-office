     

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
				$row  = $dt_dokumen->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_dokumen->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/dokumen" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="master/dokumen/<?php echo $form ?>" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-12">                      
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Nama Dokumen</label>
                        <div class="col-sm-10">
                          <?php echo $form_id ?>
                          <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->name : "" ; ?>" name="name" placeholder="Nama Dokumen" class="form-control form-control-sm " />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">No Surat</label>
                        <div class="col-sm-4">                          
                          <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->no_surat : "" ; ?>" name="no_surat" placeholder="No Surat" class="form-control form-control-sm " />
                        </div>
                        <label class="col-sm-1 col-form-label-sm">Tgl Surat</label>
                        <div class="col-sm-2">                          
                          <input type="date" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tgl_surat : "" ; ?>" name="tgl_surat" placeholder="Tgl Surat" class="form-control form-control-sm " />
                        </div>                      
                        <label class="col-sm-1 col-form-label-sm">Kode</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $row->kode : "Auto" ; ?>" name="kode" placeholder="Kode" class="form-control form-control-sm " />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Kategori</label>
                        <div class="col-sm-3">                          
                          <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_kategori">
                            <?php $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                            <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                            <?php     
                            $dt_produk_kategori = $this->m_admin->getAll("dokumen_category");                       
                            foreach ($dt_produk_kategori->result() as $isi) {
                              $id_kategori = ($row!='') ? $row->id_kategori : "";
                              if($id_kategori!='' && $id_kategori==$isi->id){
                               $se = "selected";
                              }else{
                                $se="";
                              }
                              echo "<option $se value='$isi->id'>$isi->name</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <label class="col-sm-1 col-form-label-sm">Tautan</label>
                        <div class="col-sm-6">                          
                          <input required type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tautan : "" ; ?>" name="tautan" placeholder="Tautan" class="form-control form-control-sm " />
                        </div>                      
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Client (opt)</label>
                        <div class="col-sm-4">                          
                          <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_client">
                            <?php $tampil = ($row!='') ? $row->id_client : "" ; ?>                          
                            <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                            <?php     
                            $dt_produk_kategori = $this->m_admin->getAll("md_client");                       
                            foreach ($dt_produk_kategori->result() as $isi) {
                              $id_client = ($row!='') ? $row->id_client : "";
                              if($id_client!='' && $id_client==$isi->id){
                               $se = "selected";
                              }else{
                                $se="";
                              }
                              echo "<option $se value='$isi->id'>$isi->nama_faskes</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>                    
                  </div>   
                  <hr>
                  <div class="row" <?php echo $vis ?> >
                    <div class="col-md-6">                    
                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="reset" class="btn btn-light">Cancel</button>               
                    </div>
                  </div>
                </form>                  
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
            <h4 class="card-title"><a href="master/dokumen/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Kode</th>                      
                      <th>Name</th>                      
                      <th>Kategori</th>                      
                      <th>No Surat</th>                      
                      <th>Tgl Surat</th>                      
                      <th>Tautan</th>                      
                      <th>Client</th>                      
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  foreach ($dt_dokumen->result() as $isi) {                                        
                    echo "
                    <tr>
                      <td>$no</td>
                      <td><a href='master/dokumen/detail?id=$isi->id'>$isi->kode</a></td>
                      <td>$isi->name</td>                      
                      <td>$isi->kategori</td>                      
                      <td>$isi->no_surat</td>                      
                      <td>$isi->tgl_surat</td>                      
                      <td>$isi->tautan</td>                      
                      <td>$isi->client</td>                      
                      <td>";?>
                        <a href="master/dokumen/delete?id=<?php echo $isi->id ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>                          
                        <a href="master/dokumen/edit?id=<?php echo $isi->id ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>                                                      
                      <?php
                      echo "</td>
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

  <?php } ?>