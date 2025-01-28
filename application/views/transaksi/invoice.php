<body onload="cekResi();cekPpn();">

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
				$form = "simpanInvoice";
				$vis  = "";
				$form_id = "";
				$row = "";
        $tom  = "";
        $tombol = "Simpan Transaksi";
        $vis2  = "style='display:none;'";
			}elseif($mode == 'detail' OR $mode=="approval"){
				$row  = $dt_invoice->row();              
				$read = "readonly";
				$read2 = "disabled";
        $tom  = "";
				$vis2 = $vis  = "style='display:none;'";        
				$form = "approvalInvoice";              
				$form_id = "";
        $tombol = "Approve";                
        if($mode=="approval") $vis = "";
			}elseif($mode == 'edit'){
        $tombol = "Update Transaksi";
				$row  = $dt_invoice->row();
				$read = "";
				$read2 = "";
				$form = "updateInvoice";              
        $vis  = "";
				$tom  = "";
        $vis2  = "style='display:none;'";
				$form_id = "<input type='hidden' name='id' value='$row->id'>";              
      }elseif($mode == 'customerReceipt'){
        $tombol = "Upload Bukti Pembayaran & Cetak CR";
        $row  = $dt_invoice->row();
        $read = "readonly";
        $read2 = "disabled";
        $vis = $vis2  = "style='display:none;'";                
        $tom = "style='display:none;'";
        $form = "updatePembayaran";                      
        $form_id = "<input type='hidden' name='id' value='$row->id'>";              
			}
			?>

      <div class="row">
        <div class="col-8 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                  <?php if($mode=="insert"){ ?>
                    <a href="transaksi/invoice/batal" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Batal dan Kembali</a>
                  <?php }elseif($mode=="detail" || $mode=="approval"){ ?>
                    <a href="transaksi/invoice" class="btn btn-danger btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
                  <?php }else{ ?>
                    <a href="transaksi/invoice/batal/<?=$kode?>" onclick="return confirm('Anda yakin?')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Batal dan Kembali</a>                    
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
                    if($mode=="insert") $where .= " AND updated_by = '$id_user' AND status = 0 AND kode IS NULL";
                      else $where .= " AND kode = '$row->kode'";                                        
                    $sql = $this->db->query("SELECT * FROM md_invoice_detail WHERE 1=1 $where ORDER BY id DESC");
                    foreach($sql->result() AS $dt){
                      $id = encrypt_url($dt->id);                      
                      $kode = ($row!='') ? $row->kode : "" ;
                      $getProduct = $this->m_admin->getByID("products","id",$dt->product_id);
                      $name = ($getProduct->num_rows()>0)?$getProduct->row()->name:"";
                      $sku = ($getProduct->num_rows()>0)?$getProduct->row()->sku:"";                      
                      echo "
                      <tr>
                        <form action='transaksi/invoice/editProduk' method='POST'>
                          <input type='hidden' value='$kode' name='kode'>                          
                          <input type='hidden' value='$id' name='id'>                          
                          <input type='hidden' value='$dt->nominal' name='harga'>
                          <td>$no</td>
                          <td>$sku</td>
                          <td>$name</td>                                  
                          <td>".mata_uang($dt->nominal)."</td>
                          <td>
                            <input $read type='number' name='qty' class='form-control form-control-sm' value='$dt->qty'>
                          </td>
                          <td>
                            <input $read type='number' name='diskon' class='form-control form-control-sm' value='$dt->diskon'>
                          </td>
                          <td>".mata_uang($sub = $dt->nominal * $dt->qty - $dt->diskon)."</td>                          
                          <td $vis>
                            <a href='transaksi/invoice/hapusProduk/$id/$kode' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
                            <button type='submit' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></button>
                          </td>
                        </form>
                      </tr>
                      ";
                      $tqty+=$dt->qty;
                      $tdiskon+=$dt->diskon;
                      $ttotal+=$sub;
                      $ttotal_items=$sql->num_rows();
                      $no++;
                    }
                    ?>
                    </tbody>
                    <thead>
                      <tr>  
                        <th colspan="4">Sub Total</th>
                        <th><?= $tqty ?></th>
                        <th><?= mata_uang($tdiskon) ?></th>
                        <th>
                          <!-- <?= mata_uang($ttotal) ?> -->
                          <input type="text" class="form-control form-control-sm" id="subtotal" readonly value="<?=$ttotal?>">              
                        </th>
                        <th></th>
                      </tr>
                      <tr>  
                        <th colspan="4">PPN</th>
                        <th></th>
                        <th></th>
                        <th>                                    
                          <input type="text" class="form-control form-control-sm" readonly id="ppn" value="<?php echo $ppnN = ($row!='') ? $row->ppn : 0 ; ?>">          
                        </th>
                        <th></th>
                      </tr>
                      <tr>  
                        <th colspan="4">Total</th>
                        <th></th>
                        <th></th>
                        <th>                          
                          <input type="text" class="form-control form-control-sm" readonly id="total" name="total" value="<?=$gtotal = $ttotal + $ppnN?>">              
                        </th>
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
              <form action='transaksi/invoice/<?=$form?>' method='POST' enctype="multipart/form-data">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">No Invoice</label>
                      <div class="col-sm-8">                        
                        <input type="text" name="total" id="totalFix" value="<?= $gtotal ?>">
                        <input type="text" name="ppn" id="ppnFix" value="<?= $ppnN ?>">                        
                        <input type="text" value="<?php echo $tampil = ($row!='') ? $row->kode : "" ; ?>" readonly name="kode" placeholder="Auto" class="form-control form-control-sm  form-control form-control-sm -sm" />                        
                      </div>                                                                              
                    </div>    
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Brand</label>
                      <div class="col-sm-8">                                             
                        <select <?=$read2?> class="form-control form-control-sm select2" required name="id_brand">                      
                          <option value="">- pilih -</option>
                          <?php                                       
                          $dt_user = $this->db->query("SELECT * FROM md_brand ORDER BY id ASC");                   
                          foreach ($dt_user->result() as $isi) { 
                            $id_brand = ($row!='') ? $row->id_brand : '';
                            if($isi->id==$id_brand) $rt = "selected";
                              else $rt = "";                             
                            echo "<option $rt value='$isi->id'>$isi->brand</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                              
                    </div>                                                                                               
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Tgl Invoice</label>
                      <div class="col-sm-8">                        
                        <input type="date" <?=$read?> name="tgl_invoice" placeholder="Tgl" value="<?php echo $tampil = ($row!='') ? substr($row->tgl_invoice,0,10) : date("Y-m-d") ; ?>" class="form-control form-control-sm  form-control form-control-sm -sm" />                        
                      </div>                                                                              
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Langganan</label>
                      <div class="col-sm-8">                        
                        <select onchange="cekLama()" id="lama"  class="form-control form-control-sm" name="lama" required>
                          <option <?=($row!='' && $row->lama==1)?'selected':'';?> value="1">1 Bulan</option>
                          <option <?=($row!='' && $row->lama==6)?'selected':'';?> value="6">6 Bulan</option>
                          <option <?=($row!='' && $row->lama==12)?'selected':'';?> value="12">12 Bulan</option>
                        </select>
                      </div>                                                                                                    
                    </div>                    
                    <div class="form-group row" id="periode">
                      <label class="col-sm-4 col-form-label-sm">Periode</label>
                      <div class="col-sm-8">                        
                        <input type="month" <?=$read?> name="periode" placeholder="Periode" value="<?php echo $tampil = ($row!='') ? $row->periode : date("Y-m") ; ?>" class="form-control form-control-sm" />                        
                      </div>                                                                                                    
                    </div>                    
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Diskon</label>
                      <div class="col-sm-8">                        
                        <input type="number" <?=$read?> name="diskon" placeholder="Diskon" value="<?php echo $tampil = ($row!='') ? $row->diskon : '' ; ?>" class="form-control form-control-sm" />                        
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
                      <label class="col-sm-4 col-form-label-sm">Client</label>
                      <div class="col-sm-8">                        
                        <select required <?=$read2?> class="form-control form-control-sm select2" name="id_client">                      
                          <option value="">- pilih -</option>
                          <?php              
                          $dt_user = $this->m_admin->getAll("md_client");                   
                          foreach ($dt_user->result() as $isi) {                                                    
                            $id_client = ($row!='') ? $row->id_client : '';
                            if($isi->id==$id_client) $rt = "selected";
                              else $rt = "";                                                   
                            echo "<option $rt value='$isi->id'>$isi->nama_faskes</option>";
                          }
                          ?>
                        </select>
                      </div>                                                                              
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Tambahkan PPN?</label>
                      <div class="col-sm-4">                        
                        <select class="form-control form-control-sm" onchange="cekPpn()" id="ppnkan" name="ppnkan">
                          <option <?=($row!='' && $row->ppnkan==0)?'selected':'';?> value="0">Tidak</option>
                          <option <?=($row!='' && $row->ppnkan==1)?'selected':'';?> value="1">Ya</option>
                        </select>
                      </div>                                                                              
                    </div>        
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label-sm">Catatan</label>
                      <div class="col-sm-8">                        
                        <textarea <?=$read?>  rows="2" class="form-control textarea" name="keterangan">                        
                          <?php echo $tampil = ($row!='') ? $row->keterangan : '' ; ?>                                                    
                        </textarea>
                      </div>                                                                              
                    </div>        

                    <?php if($mode=="customerReceipt"){ ?>                                
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm">Bukti Transfer</label>
                        <div class="col-sm-8">
                          <input type="file" required class="form-upload" name="bukti">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm">No.Ref Transaksi</label>
                        <div class="col-sm-8">
                          <input type="text" required placeholder="No.Ref" class="form-control form-control-sm" name="no_ref">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm">Payment Methods</label>
                        <div class="col-sm-8">                        
                          <select class="form-control form-control-sm" id="order_status" name="payment_method" required>                          
                            <option <?=($row!='' && $row->payment_method=="1")?'selected':'';?> value="1">Bank Transfer</option>                          
                            <option <?=($row!='' && $row->payment_method=="2")?'selected':'';?> value="2">Cash</option>                            
                          </select>
                        </div>                    
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm">Status Bayar</label>
                        <div class="col-sm-8">                        
                          <select onchange="cekResi()" class="form-control form-control-sm" id="payment_status" name="payment_status" required>                 
                            <option <?=($row!='' && $row->payment_status=="2")?'selected':'';?> value="2">Konfirmasi</option>                                                             
                            <option <?=($row!='' && $row->payment_status=="0")?'selected':'';?> value="0">Belum Bayar</option>
                            <option <?=($row!='' && $row->payment_status=="1")?'selected':'';?> value="1">Menunggu Konfirmasi</option>                                                      
                          </select>
                        </div>                    
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm">Status Order</label>
                        <div class="col-sm-8">                        
                          <select onchange="cekResi()" class="form-control form-control-sm" id="order_status" name="order_status" required>                                                      
                            <option <?=($row!='' && $row->status=="3")?'selected':'';?> value="3">Selesai</option>                          
                            <option <?=($row!='' && $row->status=="4")?'selected':'';?> value="4">Batal</option>                          
                          </select>
                        </div>                    
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label-sm"></label>
                        <div class="col-sm-8">
                          <button onclick="return confirm('Pastikan semua data sudah benar! Lanjutkan?')" name="submit" value="bayar" class="btn btn-success" type="submit"> <i class="fa fa-save"></i> <?=$tombol?></button>                          
                        </div>
                      </div>
                    <?php } ?>
                                      
                    <div <?=$vis?> class="form-group row">
                      <label class="col-sm-4 col-form-label-sm"></label>
                      <div class="col-sm-8">
                        <button onclick="return confirm('Pastikan semua data sudah benar! Lanjutkan?')" name="submit" value="update" class="btn btn-success" type="submit"> <i class="fa fa-save"></i> <?=$tombol?></button>
                        <a href="transaksi/invoice" class="btn btn-danger">Tutup</a>
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
              <a href="transaksi/invoice/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transaksi Baru</a>
              <a href="transaksi/invoice/riwayat" class="btn btn-warning btn-sm"><i class="mdi mdi-history"></i> Riwayat</a>
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
                      <th>No Invoice</th>                      
                      <th>Brand</th>                                               
                      <th>Client</th>                                               
                      <th>Catatan</th>                           
                      <th>Tgl Invoice</th>
                      <th>Periode</th>
                      <th>Total Pembayaran</th>                                                              
                      <th>Status</th>                           
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;
                  foreach ($dt_invoice->result() as $isi) {                                        

                    $cek_user = $this->m_admin->getByID("md_client","id",$isi->id_client);
                    $user = ($cek_user->num_rows()>0) ? $cek_user->row()->nama_faskes : "" ;                    

                    $cek_brand = $this->m_admin->getByID("md_brand","id",$isi->id_brand);
                    $brand = ($cek_brand->num_rows()>0) ? $cek_brand->row()->brand : "" ;                    
                    
                    $cr = "display:none;";
                    if($isi->status==1){      
                      $edit = $approval = $hapus = "";
                      $status = "<label class='badge badge-info'>Baru</label>";
                    }elseif($isi->status==2){      
                      $approval = $hapus = $edit = "display:none;";
                      $cr = "";
                      $status = "<label class='badge badge-primary'>Approve</label>";                    
                    }elseif($isi->status==3){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-success'>Selesai</label>";
                    }elseif($isi->status==4){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-danger'>Batal</label>";
                    }

                    if($isi->payment_status==1){
                      $konfirmasi = "display:none;";
                      $status = "<label class='badge badge-primary'>Konfirmasi Bayar</label>";
                    }                                      
                    

                    $id = encrypt_url($isi->id);
                    $kode = encrypt_url($isi->kode);
                    $link = "transaksi/invoice/detail/$kode";
                                                     
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>
                        <div class='btn-group'>
                          <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                          <div class='dropdown-menu'>
                            <a href='transaksi/invoice/cetak/$kode' class='dropdown-item'>Cetak Invoice</a>                            
                            <a href='transaksi/invoice/detail/$kode' class='dropdown-item'>Detail</a>                            
                            <a href='transaksi/invoice/approval/$kode' class='dropdown-item' style='$approval'>Approve</a>                            
                            <a href='transaksi/invoice/delete/$kode' class='dropdown-item' style='$hapus'>Hapus</a>                            
                            <a href='transaksi/invoice/edit/$kode' class='dropdown-item' style='$edit'>Edit</a>                            
                            <a href='transaksi/invoice/customerReceipt/$kode' class='dropdown-item' style='$cr'>Customer Receipt</a>                            
                          </div>
                        </div>  
                      </td>
                      <td><a href='$link'>$isi->kode</a></td>
                      <td>$brand</td>                                                                
                      <td>$user</td>                                                                
                      <td>$isi->keterangan</td>                      
                      <td>$isi->tgl_invoice</td>
                      <td>$isi->periode</td>
                      <td align='left'>Rp ".mata_uang($isi->total)."</td>                                                                                                              
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
            <h4 class="card-title"><a href="transaksi/invoice" class="btn btn-danger btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a></h4>
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="5%"></th>                      
                      <th>No Invoice</th>                      
                      <th>Brand</th>                                               
                      <th>Client</th>                                               
                      <th>Catatan</th>                           
                      <th>Tgl Invoice</th>
                      <th>Periode</th>
                      <th>Total Pembayaran</th>                                        
                      <th>Pembayaran</th>                          
                      <th>Status</th>                           
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;
                  foreach ($dt_invoice->result() as $isi) {                                        

                    $cek_user = $this->m_admin->getByID("md_client","id",$isi->id_client);
                    $user = ($cek_user->num_rows()>0) ? $cek_user->row()->nama_faskes : "" ;                    

                    $cek_brand = $this->m_admin->getByID("md_brand","id",$isi->id_brand);
                    $brand = ($cek_brand->num_rows()>0) ? $cek_brand->row()->brand : "" ;                    
                    
                    if($isi->status==1){      
                      $edit = $approval = $hapus = "";
                      $status = "<label class='badge badge-info'>Baru</label>";
                    }elseif($isi->status==2){      
                      $approval = $hapus = $edit = "display:none;";
                      $status = "<label class='badge badge-primary'>Approve</label>";                    
                    }elseif($isi->status==3){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-success'>Selesai</label>";
                    }elseif($isi->status==4){ 
                      $approval = $hapus = $edit = "display:none;";     
                      $status = "<label class='badge badge-danger'>Batal</label>";
                    }

                    $pembayaran = "";
                    if($isi->payment_status==2){
                      $konfirmasi = "display:none;";
                      $status = "<label class='badge badge-primary'>Konfirmasi Bayar</label>";
                      $pembayaran.=" Method :".$isi->payment_method;
                      $pembayaran.=" <br> Paid at :".$isi->paid_at;
                      $pembayaran.=" <br> <a href='assets/uploads/payments/$isi->bukti' class='badge badge-info'>lihat bukti</a>";
                    }                                      
                    

                    $id = encrypt_url($isi->id);
                    $kode = encrypt_url($isi->kode);
                    $link = "transaksi/invoice/detail/$kode";
                                                     
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>
                        <div class='btn-group'>
                          <button type='button' class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown'>Action</button>
                          <div class='dropdown-menu'>
                            <a href='transaksi/invoice/cetakCr/$kode' class='dropdown-item'>Cetak CR</a>                            
                            <a href='transaksi/invoice/cetak/$kode' class='dropdown-item'>Cetak Invoice</a>                            
                            <a href='transaksi/invoice/detail/$kode' class='dropdown-item'>Detail</a>                            
                            <a href='transaksi/invoice/approval/$kode' class='dropdown-item' style='$approval'>Approve</a>                            
                            <a href='transaksi/invoice/delete/$kode' class='dropdown-item' style='$hapus'>Hapus</a>                            
                            <a href='transaksi/invoice/edit/$kode' class='dropdown-item' style='$edit'>Edit</a>                            
                          </div>
                        </div>  
                      </td>
                      <td><a href='$link'>$isi->kode</a></td>
                      <td>$brand</td>                                                                
                      <td>$user</td>                                                                
                      <td>$isi->keterangan</td>                      
                      <td>$isi->tgl_invoice</td>
                      <td>$isi->periode</td>
                      <td align='left'>Rp ".mata_uang($isi->total)."</td>                                                                                        
                      <td>$pembayaran</td>
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
  

  <?php } ?>

<script type="text/javascript">
function cekPpn(){
  var ppnkan = $("#ppnkan").val();  
  var subtotal = $("#subtotal").val();  
  $.ajax({
      url : "<?php echo site_url('transaksi/invoice/cari_ppn')?>",
      type:"POST",
      data:"ppnkan="+ppnkan+"&subtotal="+subtotal,            
      cache:false,
      success:function(msg){                
          data=msg.split("|");          
          $("#ppn").val(data[0]);                          
          $("#ppnFix").val(data[0]);                          
          $("#total").val(data[1]);                          
          $("#totalFix").val(data[1]);                          
      }
  }) 
}
function cekResi(){
  var order_s = $("#order_status").val();  
  if(order_s==3){
    $("#dataResi").show();
  }else{
    $("#dataResi").hide();
  }
}
function cekLama(){
  var lama = $("#lama").val();  
  if(lama==1){
    $("#periode").show();
  }else{
    $("#periode").hide();
  }
  
}
</script>