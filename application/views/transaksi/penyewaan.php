<body onload="cekResi()">

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
				$form = "simpanPenyewaan";
				$vis  = "";
				$form_id = "";
				$row = "";
        $tombol = "Simpan Transaksi";
        $vis2  = "style='display:none;'";
			}elseif($mode == 'detail' OR $mode=="approval"){
				$row  = $dt_orders->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis2 = $vis  = "style='display:none;'";        
				$form = "approvalPenyewaan";              
				$form_id = "";
        $tombol = "Update Transaksi";                
        if($mode=="approval") $vis = "";
			}elseif($mode == 'edit'){
        $tombol = "Update Transaksi";
				$row  = $dt_orders->row();
				$read = "";
				$read2 = "";
				$form = "updatePenyewaan";              
				$vis  = "";
        $vis2  = "style='display:none;'";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}
			?>

      <div class="row">
        <div class="col-8 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                  <?php if($mode=="insert"){ ?>
                    <a href="transaksi/penyewaan/batal" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Batal dan Kembali</a>
                  <?php }elseif($mode=="detail" || $mode=="approval"){ ?>
                    <a href="transaksi/penyewaan" class="btn btn-danger btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
                  <?php }else{ ?>
                    <a href="transaksi/penyewaan/batal/<?=$order_number?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Batal dan Kembali</a>                    
                  <?php } ?>
                  <button <?=$vis?> type="button" data-toggle="modal" data-target="#Resepmodal" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Produk
                  </button>
                </h4>
            </div>
            <div class="card-body">
                                  
                                
              <div class="box">                            
                <div class="table-responsive">
                  <table id="example3" class="table" style="width:100%">
                    <thead>
                      <tr>
                        <th width="2%">No</th>                  
                        <th>Kode</th>                      
                        <th>Produk/Layanan</th>                                                                                            
                        <th>Harga</th>                  
                        <th width="10%">Qty</th>            
                        <th>Diskon</th>                        
                        <th>Subtotal</th>                                                  
                        <th width="13%"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no=1;$where = "";
                    $tqty = 0;$tdiskon=0;$ttotal=0;$ttotal_items=0;
                    $id_user = $this->session->id_user;                    
                    if($mode=="insert") $where .= " AND updated_by = '$id_user' AND status = 0 AND order_id IS NULL";
                      else $where .= " AND order_id = '$row->id'";                                        
                    $sql = $this->db->query("SELECT * FROM order_items WHERE 1=1 $where ORDER BY id DESC");
                    foreach($sql->result() AS $dt){
                      $id = encrypt_url($dt->id);                      
                      $order_number = ($row!='') ? $row->order_number : "" ;
                      $getProduct = $this->m_admin->getByID("products","id",$dt->product_id);
                      $name = ($getProduct->num_rows()>0)?$getProduct->row()->name:"";
                      $sku = ($getProduct->num_rows()>0)?$getProduct->row()->sku:"";                      
                      echo "
                      <tr>
                        <form action='transaksi/penyewaan/editProduk' method='POST'>
                          <input type='hidden' value='$order_number' name='order_number'>                          
                          <input type='hidden' value='$id' name='id'>                          
                          <input type='hidden' value='$dt->order_price' name='order_price'>
                          <td>$no</td>
                          <td>$sku</td>
                          <td>$name</td>                                  
                          <td>".mata_uang($dt->order_price)."</td>
                          <td>
                            <input $read type='number' name='order_qty' class='form-control form-control-sm' value='$dt->order_qty'>
                          </td>
                          <td>
                            <input $read type='number' name='diskon' class='form-control form-control-sm' value='$dt->diskon'>
                          </td>
                          <td>".mata_uang($sub = $dt->order_price * $dt->order_qty - $dt->diskon)."</td>                          
                          <td $vis>
                            <a href='transaksi/penyewaan/hapusProduk/$id/$order_number' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
                            <button type='submit' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></button>
                          </td>
                        </form>
                      </tr>
                      ";
                      $tqty+=$dt->order_qty;
                      $tdiskon+=$dt->diskon;
                      $ttotal+=$sub;
                      $ttotal_items=$sql->num_rows();
                      $no++;
                    }
                    ?>
                    </tbody>
                    <thead>
                      <tr>  
                        <th colspan="4">Total</th>
                        <th><?= $tqty ?></th>
                        <th><?= mata_uang($tdiskon) ?></th>
                        <th><?= mata_uang($ttotal) ?></th>
                        <th></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
                    
            </div>
            <div class="modal fade" id="Resepmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    Pilih Produk / Layanan
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>            
                  </div>
                  <div class="modal-body">                                                
                    <div class="table-responsive">
                      <table id="jualan_dt" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>                      
                            <th width="5%">No</th>                                           
                            <th>Kode</th>                                           
                            <th>Nama Produk</th>                                                                                        
                            <th>Kategori</th>                                                                             
                            <th>Harga</th>                                                             
                            <th width="10%"></th>                      
                          </tr>
                        </thead>
                        <tbody>              
                        </tbody>              
                      </table>
                    </div>              
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>        
                  </div>
                </div>
              </div>
            </div>                                           
          </div>
        </div>
        <div class="col-4 grid-margin">
          <div class="card">            
            <div class="card-body">
              <form action='transaksi/penyewaan/<?=$form?>' method='POST' enctype="multipart/form-data">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Order Number</label>
                      <div class="col-sm-8">                        
                        <input type="hidden" name="total" value="<?= $ttotal ?>">
                        <input type="hidden" name="total_items" value="<?= $ttotal_items ?>">
                        <input type="hidden" name="diskon" value="<?= $tdiskon ?>">
                        <input type="text" value="<?php echo $tampil = ($row!='') ? $row->order_number : "" ; ?>" readonly name="order_number" placeholder="Auto" class="form-control form-control-sm  form-control form-control-sm -sm" />                        
                      </div>                                                                              
                    </div>                                                                                                   
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Tgl Trans</label>
                      <div class="col-sm-8">                        
                        <input type="date" <?=$read?> name="order_date" placeholder="Tgl" value="<?php echo $tampil = ($row!='') ? substr($row->tgl_mulai,0,10) : date("Y-m-d") ; ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />                        
                      </div>                                                                              
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Tgl Acara</label>
                      <div class="col-sm-4">                        
                        <input type="date" <?=$read?> name="tgl_mulai" placeholder="Tgl" value="<?php echo $tampil = ($row!='') ? $row->tgl_mulai : date("Y-m-d") ; ?>" class="form-control form-control-sm" />                        
                      </div>                                                                              
                      <div class="col-sm-4">                        
                        <input type="date" <?=$read?> name="tgl_selesai" placeholder="Tgl" value="<?php echo $tampil = ($row!='') ? $row->tgl_selesai : date("Y-m-d") ; ?>" class="form-control form-control-sm" />                        
                      </div>                                                                              
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Karyawan</label>
                      <div class="col-sm-8">                        
                        <select <?=$read2?> class="form-control form-control-sm select2" required name="id_karyawan">                      
                          <option value="">- pilih -</option>
                          <?php             
                          $id_karyawan_session = $this->session->id_karyawan;
                          $level = $this->session->level;                                                     
                          if($level=='karyawan') $where = " AND id_karyawan='$id_karyawan_session'";
                            else $where = "";                          
                          $dt_user = $this->db->query("SELECT * FROM md_karyawan WHERE status = 1 $where");                   
                          foreach ($dt_user->result() as $isi) { 
                            $id_karyawan = ($row!='') ? $row->id_karyawan : '';
                            if($isi->id_karyawan==$id_karyawan) $rt = "selected";
                              else $rt = ""; 
                            if($isi->id_karyawan==$id_karyawan_session) $rs = "selected";
                              else $rs = ""; 
                            echo "<option $rt $rs value='$isi->id_karyawan'>$isi->nama_lengkap</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Konsumen</label>
                      <div class="col-sm-8">                        
                        <select <?=$read2?> class="form-control form-control-sm select2" name="user_id">                      
                          <option value="">- Umum -</option>
                          <?php              
                          $dt_user = $this->m_admin->getAll("md_konsumen");                   
                          foreach ($dt_user->result() as $isi) {                                                    
                            $user_id = ($row!='') ? $row->user_id : '';
                            if($isi->id_konsumen==$user_id) $rt = "selected";
                              else $rt = "";                                                   
                            echo "<option $rt value='$isi->id_konsumen'>$isi->nama_lengkap</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Catatan</label>
                      <div class="col-sm-8">                        
                        <textarea <?=$read?>  rows="2" class="form-control textarea" name="delivery_data">
                          <?php
                          if($row!=""){
                            if($row->sumber=="web"){
                              $delivery_data = json_decode($row->delivery_data);
                              echo "Nama: ".$delivery_data->customer->name." || No HP:".$delivery_data->customer->phone_number." || Alamat: ".$delivery_data->customer->address."|| Catatan:".$delivery_data->note;
                            }else{
                              echo $row->catatan;
                            }
                          }
                          ?>
                        </textarea>
                      </div>                                                                              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Payment Methods</label>
                      <div class="col-sm-8">                        
                        <select class="form-control form-control-sm" id="order_status" name="payment_method" required>                          
                          <option <?=($row!='' && $row->payment_method=="2")?'selected':'';?> value="2">COD</option>
                          <option <?=($row!='' && $row->payment_method=="1")?'selected':'';?> value="1">Bank Transfer</option>                          
                        </select>
                      </div>                    
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Pembayaran 
                        <?php 
                        $nom = 0;
                        if($row!=""){
                          $cek = $this->m_admin->getByID("order_payment","order_id",$row->id);
                          if($cek->num_rows()>0){
                            $nom = $cek->row()->nominal;
                          ?>
                            <a href="assets/uploads/payments/<?=$cek->row()->bukti?>">(lihat bukti) </a>
                          <?php }
                        } ?>
                      </label>
                      <div class="col-sm-8">                        
                        <input type="number" <?=$read?> value="<?=$nom?>"  class="form-control form-control-sm" name="dp" placeholder="Pembayaran">
                      </div>                                                                              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Status Bayar</label>
                      <div class="col-sm-8">                        
                        <select onchange="cekResi()" class="form-control form-control-sm" id="payment_status" name="payment_status" required>                          
                          <option <?=($row!='' && $row->payment_status=="0")?'selected':'';?> value="0">Belum Bayar</option>
                          <option <?=($row!='' && $row->payment_status=="1")?'selected':'';?> value="1">Menunggu Konfirmasi</option>                          
                          <option <?=($row!='' && $row->payment_status=="2")?'selected':'';?> value="2">Konfirmasi</option>                                                    
                        </select>
                      </div>                    
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Status Order</label>
                      <div class="col-sm-8">                        
                        <select onchange="cekResi()" class="form-control form-control-sm" id="order_status" name="order_status" required>                          
                          <option <?=($row!='' && $row->order_status=="1")?'selected':'';?> value="1">Menunggu Pembayaran (Booking)</option>
                          <option <?=($row!='' && $row->order_status=="2")?'selected':'';?> value="2">Dalam Proses (Sudah DP)</option>                          
                          <option <?=($row!='' && $row->order_status=="3")?'selected':'';?> value="3">Selesai</option>                          
                          <option <?=($row!='' && $row->order_status=="4")?'selected':'';?> value="4">Batal</option>                          
                        </select>
                      </div>                    
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Bukti Transfer</label>
                      <div class="col-sm-8">
                        <input type="file" class="form-upload" name="bukti">
                      </div>
                    </div>
                                      
                    <div <?=$vis?> class="form-group row">
                      <label class="col-sm-4 col-form-label-sm"></label>
                      <div class="col-sm-8">
                        <button onclick="return confirm('Pastikan semua data sudah benar! Lanjutkan?')" name="submit" value="update" class="btn btn-success" type="submit"> <i class="fa fa-save"></i> <?=$tombol?></button>
                      </div>
                    </div>                                                                                                  
                  </div>   
                </div>                
              </form>
            </div>
          </div>
        </div>
      </div>
    
    

    
    <?php }elseif($set=="view"){ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              <a href="transaksi/penyewaan/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transaksi Baru</a>
              <a href="transaksi/penyewaan/riwayat" class="btn btn-warning btn-sm"><i class="mdi mdi-history"></i> Riwayat</a>
            </h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="5%"></th>                      
                      <th>No Order</th>                      
                      <th>Konsumen</th>                         
                      <th>Item</th>                                       
                      <th>Catatan</th>                           
                      <th>Tgl Transaksi</th>
                      <th>Tgl Cara</th>
                      <th>Total Pembayaran</th>                                        
                      <th>Pembayaran</th>                          
                      <th>Status Order</th>                           
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;
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
                      <td>
                        <div class='btn-group'>
                          <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                          <div class='dropdown-menu'>
                            <a href='transaksi/penyewaan/cetak/$order_number' class='dropdown-item'>Cetak Invoice</a>                            
                            <a href='transaksi/penyewaan/detail/$order_number' class='dropdown-item'>Detail</a>                            
                            <a href='transaksi/penyewaan/approval/$order_number' class='dropdown-item'>Proses</a>                            
                            <a href='transaksi/penyewaan/delete/$id' class='dropdown-item' style='$hapus'>Hapus</a>                            
                            <a href='transaksi/penyewaan/edit/$order_number' class='dropdown-item' style='$edit'>Edit</a>                            
                          </div>
                        </div>  
                      </td>
                      <td><a href='$link'>$isi->order_number</a></td>
                      <td>$user</td>                                          
                      <td align='left'>".mata_uang($isi->total_items)." item</td>                      
                      <td>$catatan</td>
                      <td>$isi->order_date</td>
                      <td>$isi->tgl_mulai s/d $isi->tgl_selesai</td>
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
      </div>
    </div>
  

<?php }elseif($set=="riwayat"){ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><a href="transaksi/penyewaan" class="btn btn-danger btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
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
                      <th></th>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;
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
                      <td><a href='$link'>$isi->order_number</a></td>
                      <td>$user</td>                                          
                      <td align='left'>".mata_uang($isi->total_items)." item</td>                      
                      <td>$catatan</td>
                      <td>$isi->order_date</td>
                      <td align='left'>Rp ".mata_uang($isi->total_price)."</td>                                                                                        
                      <td>$payments</td>
                      <td>$status</td>
                      <td>
                        <a href='transaksi/penyewaan/cetak/$order_number' class='btn btn-sm btn-warning'>Cetak Invoice</a>                            
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
  

  <?php } ?>

<script type="text/javascript">
function cekResi(){
  var order_s = $("#order_status").val();  
  if(order_s==3){
    $("#dataResi").show();
  }else{
    $("#dataResi").hide();
  }
}
</script>