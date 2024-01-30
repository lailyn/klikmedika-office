   

   
    <div class="row">
      <div class="col-12 grid-margin">        
                
        <div class="card">
          <div class="card-header">
            <form method="post" action="laporan/lap_pengeluaran/index" >
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
                    <a href="laporan/lap_pengeluaran" class="btn text-white btn-sm btn-warning mt-2"> Reset</a>                              
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
                      <th>Kode Transaksi</th>                      
                      <th>Tanggal</th>                      
                      <th>Kategori</th>
                      <th>Uraian</th>   
                      <th>Total</th>  
                    </tr>
                  </thead>
                  <tbody> 
                  <?php                   
                  $no=1;
                  $where="";$total=0;                                    
                  if($filter_1!="") $where.=" AND md_pengeluaran.tgl BETWEEN '$filter_1' AND '$filter_2'";
                    
                  $cek = $this->db->query("SELECT md_pengeluaran.*,md_pengeluaran_kategori.kategori FROM md_pengeluaran 
                    INNER JOIN md_pengeluaran_kategori ON md_pengeluaran.id_kategori = md_pengeluaran_kategori.id
                    $where
                    ORDER BY md_pengeluaran.id_pengeluaran DESC");
                  foreach($cek->result() AS $row){
                    echo "
                    <tr>
                      <td>$no</td>                      
                      <td>$row->kode_pengeluaran</td>
                      <td>$row->tgl</td>
                      <td>$row->kategori</td>
                      <td>$row->uraian</td>
                      <td>".mata_uang($row->total)."</td>
                    </tr>
                    ";
                    $no++;
                    $total += $row->total;
                  }
                  ?>                  
                  </tbody>                 
                  <thead>
                    <tr>
                      <th colspan="5">Grand Total</th>
                      <th><?=mata_uang($total)?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>


