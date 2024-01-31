     

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
		if($set=="insert" AND $mode!='import'){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
        $re = "required";
			}elseif($mode == 'detail'){
				$row  = $dt_produk->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";$re="";
			}elseif($mode == 'edit'){
				$row  = $dt_produk->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
        $re="";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/produk" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <form action="master/produk/<?php echo $form ?>" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Produk/Layanan</label>
                      <div class="col-sm-8">                        
                        <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->name : "" ; ?>" name="name" placeholder="Produk/Layanan" class="form-control form-control-sm " />
                      </div>                                                          
                      <div class="form-check mx-sm-2">
                        <label class="form-check-label">
                          <?php $on = ($row!='') ? $row->status : "" ; ?>                                                    
                          <input type="checkbox" <?php echo $n = ($on==0 && $row!='') ? '' : 'checked' ?> name="status" class="form-check-input" value='1'> Aktif </label>                      
                      </div>                                                                                                                                     
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Kode</label>
                      <div class="col-sm-2">
                        <?php echo $form_id ?>
                        <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $row->sku : "Auto" ; ?>" name="sku" placeholder="Kode" class="form-control form-control-sm " />
                      </div>                    
                      
                                          
                      <label class="col-sm-1 col-form-label-sm">Harga</label>
                      <div class="col-sm-2">                          
                        <input type="text" data-type="currency" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->price : "" ; ?>" name="price" placeholder="Harga" class="form-control form-control-sm " />                                                                        
                      </div>
                      
                    
                      <label class="col-sm-2 col-form-label-sm">Kategori</label>
                      <div class="col-sm-3">                        
                        <select class="form-control form-control-sm select2" <?php echo $read2 ?> name="id_kategori">
                          <?php $tampil = ($row!='') ? $row->id_kategori : "" ; ?>                          
                          <option <?php if($tampil=="") echo 'selected' ?> value="">- choose -</option>
                          <?php                           
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
                                                            
                    </div>
                                          
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Deskripsi Lengkap</label>
                      <div class="col-sm-10">                        
                        <textarea id="summernote" <?php echo $read2 ?> name="keterangan" id="exampleTextarea1" class="form-control form-control-sm " rows="15">
                          <?php echo $tampil = ($row!='') ? $row->keterangan : "" ; ?>
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
            <h4 class="card-title">
              <a href="master/produk/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              <!-- <a href="master/produk/import" class="btn btn-info btn-sm"><i class="mdi mdi-import"></i> Import</a>               -->
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Produk/Layanan</th>                                                                                       
                      <th>Kategori</th>                                                             
                      <th>Deskripsi</th>                                                                                   
                      <th>Harga</th>                 
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php
                  $no=1;$where="";                  
                  $id_tipe = $this->session->userdata("id_user_type");                  
                  $cek_tipe = $this->m_admin->getByID("md_user_type","id_user_type",$id_tipe);
                  $type = ($cek_tipe->num_rows() > 0) ? $cek_tipe->row()->user_type : "" ;                                                      
                  $sql = $this->db->select("p.*,c.name AS kategori")
                      ->join("product_category c","p.id_kategori=c.id","left")                                            
                      ->order_by("p.id","desc")
                      ->get("products p");                  
                  foreach ($sql->result() as $isi) {
                                                          

                    if(!isset($isi->picture_name) AND $isi->picture_name==""){
                      $gambar = "produk.png";
                    }else{
                      $gambar = $isi->picture_name;
                    }

                    if($isi->current_discount!=0){
                      $dis = "<del>".mata_uang($isi->current_discount)."</del><br>";
                    }else{
                      $dis = "";
                    }                    
                    echo
                      "<tr>
                      <td>$no</td>                      
                      <td><a href='master/produk/detail?id=$isi->id'>$isi->sku | $isi->name</a></td>                      
                      <td>$isi->kategori</td>                                            
                      <td>$isi->description</td>                                                                  
                      <td>$dis ".mata_uang($isi->price)."</td>                        
                      <td>
                            <a href=\"master/produk/delete?id=$isi->id\" onclick=\"return confirm('Anda yakin?')\" class=\"btn btn-danger btn-sm\" title=\"Hapus\"><i class=\"fa fa-trash\"></i></a>                          
                            <a href=\"master/produk/edit?id=$isi->id\" class=\"btn btn-primary btn-sm\" title=\"Edit\"><i class=\"fa fa-edit\"></i></a>
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

