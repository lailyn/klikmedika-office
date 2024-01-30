  
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Review Pesanan</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">
        
      <section class="iq-products">        
        <div class="container">
          <?php                       
          if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {                    
          ?>                  
          <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable mt-2">
            <strong><?php echo $_SESSION['pesan'] ?></strong>                    
          </div>
          <?php
          }
          $_SESSION['pesan'] = ''; 
          ?>
          <div class="row">
            <table class="table table-hovered">
              <thead>
                <tr>
                  <th>Layanan</th>
                  <th width="10%">Qty</th>
                  <th width="10%">Subtotal</th>
                  <th width="10%"></th>
                </tr>                
              </thead>
              <tbody>
              <?php 
              $no=1;$where = "";
              $tqty = 0;$tdiskon=0;$ttotal=0;$ttotal_items=0;
              $id_user = $this->session->id_user;                    
              $where .= " AND updated_by = '$id_user' AND status = 0 AND order_id IS NULL";              
              $sql = $this->db->query("SELECT * FROM order_items WHERE 1=1 $where ORDER BY id DESC");
              foreach($sql->result() AS $dt){
                $id = encrypt_url($dt->id);                                      
                $getProduct = $this->m_admin->getByID("products","id",$dt->product_id);
                $name = ($getProduct->num_rows()>0)?$getProduct->row()->name:"";
                $sku = ($getProduct->num_rows()>0)?$getProduct->row()->sku:"";                      
                echo "
                <tr>
                  <form action='customer/editProduk' method='POST'>                    
                    <input type='hidden' value='$id' name='id'>                          
                    <input type='hidden' value='$dt->order_price' name='order_price'>                    
                    <td>$name</td>                                                      
                    <td>
                      <input min='0' type='number' name='order_qty' class='form-control form-control-sm' value='$dt->order_qty'>
                    </td>                    
                    <td>".mata_uang_help($sub = $dt->order_price * $dt->order_qty - $dt->diskon)."</td>                          
                    <td>
                      <a href='customer/hapusProduk/$id' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
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
                  <th colspan="2">Total</th>                  
                  <th><?= mata_uang_help($ttotal) ?></th>
                  <th></th>
                </tr>
              </thead>
            </table>
            <div class="card-body">
              <form action='simpanPenyewaan' method='POST'>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label-sm">Metode Bayar</label>
                      <div class="col-2">
                        <input type="hidden" name="total" value="<?= $ttotal ?>">
                        <input type="hidden" name="total_items" value="<?= $ttotal_items ?>">
                        <input type="hidden" name="diskon" value="<?= $tdiskon ?>">
                        <select class="form-control" name="payment_method">
                          <option value="1">Bank Transfer</option>
                          <option value="2">COD</option>
                        </select>
                      </div>
                      <label class="col-sm-2 col-form-label-sm">Catatan Tambahan</label>
                      <div class="col-6">
                        <input type="text" class="form-control form-control-sm" name="catatan" placeholder="Tambahakan Catatan Jika Ada">
                      </div>
                    </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm">Tanggal Acara/Kegiatan</label>
                        <div class="col-2">
                          <input type="date" class="form-control form-control-sm" required name="tgl_mulai" placeholder="Mulai">
                        </div> 
                        <div class="col-1">sampai</div>
                        <div class="col-2">
                          <input type="date" class="form-control form-control-sm" required name="tgl_selesai" placeholder="Selesai">
                        </div> 
                        <div class="col-2">
                          <a class="btn btn-warning mt-2" target="_BLANK" href="kalender"><i class="fa fa-calendar"></i> Lihat Kalender Puri Gracia</a>                          
                        </div>
                      </div>
                  </div>
                </div>
                <div>
                  <a class="btn btn-warning mr-2" href="paket-penyewaan"><i class="fa fa-chevron-left"></i> Pesan Layanan Lain</a>
                  <button type="submit" class="btn btn-primary" onclick="return confirm('Pastikan pesanan anda sudah benar, lanjutkan?')"><i class="fa fa-check"></i> Buat Pesanan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      
    </div>