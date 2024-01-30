   

   
    <div class="row">
      <div class="col-12 grid-margin">        
                
        <div class="card">
          <div class="card-header">
            <form method="post" action="laporan/lap_penyewaan/index" >
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
                    <label>Status Penyewaan</label>
                    <select class="form-control form-control-sm"  name="status">
                      <option <?php if($filter_3=="") echo 'selected' ?> value="">Semua</option>                      
                      <option <?php if($filter_3=="1") echo 'selected' ?> value="1">Booking</option>                      
                      <option <?php if($filter_3=="2") echo 'selected' ?> value="2">Sudah Bayar DP</option>                      
                      <option <?php if($filter_3=="3") echo 'selected' ?> value="3">Selesai</option>                      
                      <option <?php if($filter_3=="4") echo 'selected' ?> value="4">Batal</option>                      
                    </select>
                  </div>
                </div>                
                <div class="col-sm-2">
                  <div class="form-group">                    
                    <br>
                    <button type="submit" class="btn btn-sm btn-info mt-2"><i class="fa fa-filter"></i> Filter</button>                              
                    <a href="laporan/lap_penyewaan" class="btn text-white btn-sm btn-warning mt-2"> Reset</a>                              
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
                      <th>No Order</th>                      
                      <th>Konsumen</th>                         
                      <th>Item</th>                                       
                      <th>Catatan</th>                           
                      <th>Tgl Transaksi</th>
                      <th>Total Pembayaran</th>                                        
                      <th>Pembayaran</th>                          
                      <th>Status Order</th>                           
                    </tr>
                  </thead>
                  <tbody> 
                  <?php                   
                  $no=1;
                  $where="";$total=0;                  
                  if($filter_3!="") $where.=" AND orders.order_status = '$filter_3'";
                  if($filter_1!="") $where.=" AND orders.order_date BETWEEN '$filter_1' AND '$filter_2'";
                    
                  $dt_orders = $this->db->query("SELECT * FROM orders WHERE 1=1 $where ORDER BY id DESC"); 
                                    
                  foreach ($dt_orders->result() as $isi) {                                        

                    $cek_user = $this->m_admin->getByID("md_konsumen","id_konsumen",$isi->user_id);
                    $user = ($cek_user->num_rows()>0) ? $cek_user->row()->nama_lengkap : "" ;                    
                    if($isi->user_id==0) $user = "Umum";


                    if($isi->order_status==1){      
                      $edit = $approval = $hapus = "";
                      $status = "<label class='badge badge-info'>Booking</label>";
                    }elseif($isi->order_status==2){      
                      $approval = $hapus = $edit = "display:none;";
                      $status = "<label class='badge badge-primary'>Sudah Bayar DP</label>";                    
                    }elseif($isi->order_status==3){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-success'>Selesai</label>";
                    }elseif($isi->order_status==4){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-danger'>Batal</label>";
                    }

                    if($isi->payment_status==1){
                      $konfirmasi = "display:none;";
                      $status = "<label class='badge badge-primary'>Konfirmasi Bayar</label>";
                    }
                    
                    if($isi->payment_method==1){ 
                      $payments = "Bank Transfer";                      
                    }else{ 
                      $payment_s = "";
                      $payments = "COD";
                    }
                    

                    $id = encrypt_url($isi->id);
                    $order_number = encrypt_url($isi->order_number);
                    $link = "transaksi/penyewaan/detail/$order_number";
                    if($isi->sumber=="web"){
                      $edit = $hapus ="display:none";
                      $catatan = $isi->catatan;
                    }else{
                      $edit = $hapus = "";
                      $catatan = $isi->catatan;
                    }
                                                      
                    echo "
                    <tr>
                      <td>$no</td>                      
                      <td>$isi->order_number</td>
                      <td>$user</td>                                          
                      <td align='left'>".mata_uang($isi->total_items)." item</td>                      
                      <td>$catatan</td>
                      <td>$isi->order_date</td>
                      <td align='left'>Rp ".mata_uang($isi->total_price)."</td>                                                                                        
                      <td>$payments</td>
                      <td>$status</td>
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


