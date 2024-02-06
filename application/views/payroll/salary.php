    
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
				$row  = $dt_salary->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_salary->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_salary'>";              
			}
			?>

      <div class="row">
        <div class="col-6 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="payroll/salary" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="payroll/salary/<?php echo $form ?>" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-12">                                            
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Bagian *</label>
                        <div class="col-sm-9">                          
                          <select <?= $read2 ?> required class="form-control form-control-sm" name="id_bagian">
                            <option value="">- choose -</option>
                            <?php 
                            $sql = $this->m_admin->getAll("md_bagian");
                            foreach($sql->result() AS $rt){
                              if($row!="" AND $rt->id_bagian==$row->id_bagian) $rs = "selected";
                                else $rs = "";
                              echo "<option $rs value='$rt->id_bagian'>$rt->bagian</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Gaji Pokok * </label>
                        <div class="col-sm-9">
                          <?php echo $form_id ?>
                          <input data-type="currency" required type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->gaji_pokok : "" ; ?>" name="gaji_pokok" placeholder="Gaji Pokok" class="form-control form-control-sm " />
                        </div>                                              
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Tunj Transport </label>
                        <div class="col-sm-9">
                          <input data-type="currency" type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tunj_transport : "" ; ?>" name="tunj_transport" placeholder="Tunj Transport" class="form-control form-control-sm " />
                        </div>                                              
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Tunj Makan </label>
                        <div class="col-sm-9">
                          <input data-type="currency" type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tunj_makan : "" ; ?>" name="tunj_makan" placeholder="Tunj Makan" class="form-control form-control-sm " />
                        </div>                                              
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Tunj Anak </label>
                        <div class="col-sm-9">
                          <input data-type="currency" type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tunj_anak : "" ; ?>" name="tunj_anak" placeholder="Tunj Anak" class="form-control form-control-sm " />
                        </div>                                              
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Tunj Istri </label>
                        <div class="col-sm-9">
                          <input data-type="currency" type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->tunj_istri : "" ; ?>" name="tunj_istri" placeholder="Tunj Istri" class="form-control form-control-sm " />
                        </div>                                              
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label-sm">Pot Asuransi </label>
                        <div class="col-sm-9">
                          <input data-type="currency" type="text" <?php echo $read ?> value="<?php echo $tampil = ($row!='') ? $row->pot_asuransi : "" ; ?>" name="pot_asuransi" placeholder="Pot Asuransi" class="form-control form-control-sm " />
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
            <h4 class="card-title"><a href="payroll/salary/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>                      
                      <th width="5%">No</th>
                      <th>Bagian</th>                      
                      <th>Gaji Pokok</th>                      
                      <th>Tunj Transport</th>                      
                      <th>Tunj Makan</th>                      
                      <th>Tunj Anak</th>                      
                      <th>Tunj Istri</th>                      
                      <th>Pot Asuransi</th>                                                                
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;
                  $dt_rekap = $this->db->query("SELECT * FROM md_salary                     
                    INNER JOIN md_bagian ON md_salary.id_bagian = md_bagian.id_bagian");
                  foreach ($dt_rekap->result() as $isi) {
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>$isi->bagian</td>                                  
                      <td>".mata_uang($isi->gaji_pokok)."</td>
                      <td>".mata_uang($isi->tunj_transport)."</td>
                      <td>".mata_uang($isi->tunj_makan)."</td>
                      <td>".mata_uang($isi->tunj_anak)."</td>
                      <td>".mata_uang($isi->tunj_istri)."</td>
                      <td>".mata_uang($isi->pot_asuransi)."</td>"; ?>
                      <td>
                        <a href="payroll/salary/delete?id=<?php echo $isi->id_salary ?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>                          
                        <a href="payroll/salary/edit?id=<?php echo $isi->id_salary ?>" class="btn btn-primary btn-sm " title="Edit"><i class="fa fa-edit"></i></a>                                                      
                      </td>
                    </tr>
                    <?php
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
