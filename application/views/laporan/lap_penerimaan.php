   

   
    <div class="row">
      <div class="col-12 grid-margin">        
                
        <div class="card">
          <div class="card-header">
            <form method="post" action="laporan/lap_penerimaan/index" >
              <div class="row">                                
                <div class="col-sm-2">                  
                  <div class="form-group">                    
                    <label>Tgl Awal</label>
                    <input type="date" value="<?php echo ($filter_1!="")?$filter_1:date("Y-m-d"); ?>" name="tgl_awal" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="col-sm-2">                  
                  <div class="form-group">                    
                    <label>Tgl Akhir</label>
                    <input type="date" value="<?php echo ($filter_2!="")?$filter_2:date("Y-m-d"); ?>" name="tgl_akhir" class="form-control form-control-sm">
                  </div>
                </div>
                                            
                <div class="col-sm-2">
                  <div class="form-group">                    
                    <br>
                    <button type="submit" class="btn btn-sm btn-info mt-2"><i class="fa fa-filter"></i> Filter</button>                              
                    <a href="laporan/lap_penerimaan" class="btn text-white btn-sm btn-warning mt-2"> Reset</a>                              
                  </div>
                </div>
              </div>                          
            </form>
          </div> 

          <?php 
          if($set=="detail"){
          ?>
          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>No Faktur</th>                      
                      <th>Supplier</th>                           
                      <th>Detail Item</th>                                       
                      <th>Catatan</th>                           
                      <th>Tgl PO</th>                           
                      <th>Status PO</th>                           
                    </tr>
                  </thead>
                  <tbody> 
                  <?php                   
                  $no=1;
                  $where="";$total=0;                  
                  
                  if($filter_1!="") $where.=" AND md_penerimaan.tgl BETWEEN '$filter_1' AND '$filter_2'";
                    
                  $sql = $this->db->query("SELECT * FROM md_penerimaan WHERE status = 'approved' $where ORDER BY id_penerimaan DESC");  
                                    
                  foreach ($dt_penerimaan->result() as $isi) {                                        

                    $cek_user = $this->m_admin->getByID("md_user","id_user",$isi->id_user);
                    $user = ($cek_user->num_rows()>0) ? $cek_user->row()->nama_lengkap : "" ;
                    $no_hp = ($cek_user->num_rows()>0) ? $cek_user->row()->no_hp : "" ;


                    $id = encrypt_url($isi->id_penerimaan);
                    $no_faktur = encrypt_url($isi->no_faktur);
                    $link = "transaksi/penerimaan/detail/$no_faktur";
                    
                    $item = $this->m_admin->getByID("md_penerimaan_detail","no_faktur",$isi->no_faktur)->num_rows();

                    $r = $this->m_admin->getByID("md_supplier","id_supplier",$isi->id_supplier);
                    $supplier = ($r->num_rows() > 0) ? $r->row()->nama_lengkap : "" ;               

                    echo "
                    <tr>
                      <td>$no</td>                      
                      <td>$isi->no_faktur</td>
                      <td>$supplier</td>                                          
                      <td align='left'>".mata_uang($isi->total)."</td>                      
                      <td align='left'>".mata_uang($item)." item</td>                      
                      <td>$isi->catatan</td>
                      <td>$isi->tgl_penerimaan</td>                      
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

        <?php } ?>
      </div>
    </div>
  </div>


