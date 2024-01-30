     

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
		if($set=="insert" AND $mode!="access"){
			if($mode == 'insert'){
				$read = "";
				$read2 = "";
				$form = "save";
				$vis  = "";
				$form_id = "";
				$row = "";
			}elseif($mode == 'detail'){
				$row  = $dt_user_type->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_user_type->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_user_type'>";              
			}
			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/user_type" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="master/user_type/<?php echo $form ?>" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">User Type</label>
                        <div class="col-sm-9">
                          <?php echo $form_id ?>
                          <input type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->user_type : "" ; ?>" name="user_type" placeholder="User Type" class="form-control form-control-sm " />
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

    <?php 
      }elseif($set=='insert' AND $mode=="access"){
        $row  = $data_user_type->row();
      ?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="master/user_type" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>                    
            <form action="master/user_type/save_access" method="post">
              <div class="col-md-12">
                <div class="card-body">        
                  <div class="form-group mb-3 row">
                    <label class="form-label col-3 col-form-label">User Type</label>
                    <div class="col col-4">              
                      <input type="hidden" name="id_user_type" value="<?php echo $row->id_user_type ?>">         
                      <input type="text" readonly name="user_type" value="<?php echo $tampil = ($row!='') ? $row->user_type : "" ; ?>" class="form-control" required aria-describedby="emailHelp" placeholder="User Type">                
                    </div>
                  </div>          
                  <div class="table-responsive">
                    <table id="example2" class="table" style="width:100%">                  
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Menu (Check All <input type="checkbox" id="select-all">)</th>
                          <th width="15%">Can View</th>                        
                          <th width="15%">Can Insert</th>                                                    
                          <th width="15%">Can Edit</th>                                                    
                          <th width="15%">Can Delete</th>                                                    
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $no=1;
                      if($this->session->id_user_type==5) $sql = $this->m_admin->getAll("md_menu");
                        else $sql = $this->db->query("SELECT * FROM md_menu WHERE akses=0");                    
                      foreach ($sql->result() as $isi) {
                        $jum = $sql->num_rows();
                        $cek = $this->db->query("SELECT * FROM md_user_access WHERE id_menu = '$isi->id_menu' AND id_user_type = '$row->id_user_type'");
                        if($cek->num_rows() > 0){
                          if($cek->row()->can_view == 1) $view = "checked";
                            else $view = "";                        
                          if($cek->row()->can_edit == 1) $edit = "checked";
                            else $edit = "";
                          if($cek->row()->can_insert == 1) $insert = "checked";
                            else $insert = "";
                          if($cek->row()->can_delete == 1) $delete = "checked";
                            else $delete = "";
                        }else{
                          $view = "";
                          $edit = "";
                          $insert = "";
                          $delete = "";
                        }                       
                        echo "
                        <tr>
                          <td>$no</td>
                          <td>$isi->menu</td>
                          <th>
                            <input type='hidden' name='id_menu_$no' value='$isi->id_menu'>
                            <input type='hidden' name='jml' value='$jum'>
                            <input class='data-check' type='checkbox' $insert name='insert_$no' value=1>
                          </th>
                          <th align='center'><input type='checkbox' $view name='view_$no' value=1></th>
                          <td align='center'><input type='checkbox' $edit name='edit_$no' value=1></th>
                          <th><input type='checkbox' $delete name='delete_$no' value=1></th>
                        </tr>
                        ";
                        $no++;
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>               
                  <br>             
                  <div class="form-footer">                
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div> 
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <?php }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="master/user_type/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID User Type</th>
                      <th>User Type</th>                      
                      <th width="20%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  foreach ($dt_user_type->result() as $isi) {
                    echo "
                    <tr>
                      <td>$no</td>
                      <td><a href='master/user_type/detail?id=$isi->id_user_type'>$isi->id_user_type</a></td>
                      <td>$isi->user_type</td>
                      <td>";?>
                        <a href="master/user_type/delete?id=<?php echo $isi->id_user_type ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>                          
                        <a href="master/user_type/edit?id=<?php echo $isi->id_user_type ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>                                                      
                        <a href="master/user_type/akses?id=<?php echo $isi->id_user_type ?>" class="btn btn-success btn-sm">user access</a>                          
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

<script type="text/javascript">
document.getElementById('select-all').onclick = function() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (var checkbox of checkboxes) {
    checkbox.checked = this.checked;
  }
}
</script>