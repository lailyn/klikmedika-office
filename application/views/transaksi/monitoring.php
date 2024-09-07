     

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

		
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <form method="post" action="transaksi/monitoring/index" >
              <div class="row">                                
                <div class="col-sm-2">                  
                  <div class="form-group">                    
                    <label>Pilih Tahun</label>
                    <select class="form-control form-control-sm" name="filter_1" required>
                      <?php 
                      $tahun = date('Y');
                      for ($i=$tahun-5; $i <= $tahun+5 ; $i++) { 
                        if($i==$tahun || $i==$filter_1) $er="selected";
                          else $er="";
                        echo "<option $er>$i</option>";
                      }
                      ?>                      
                    </select>
                  </div>
                </div>                
                                                 
                <div class="col-sm-2">
                  <div class="form-group">                    
                    <br>
                    <button type="submit" class="btn btn-sm btn-info mt-2"><i class="fa fa-filter"></i> Filter</button>                              
                    <a href="transaksi/monitoring" class="btn text-white btn-sm btn-warning mt-2"> Reset</a>                              
                  </div>
                </div>
              </div>                          
            </form>            
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="konsumen_dt" class="table table-bordered table-stripped" style="width:100%">
                  <thead>
                    <tr>
                      <th rowspan="2" width="5%">No</th>                         
                      <th rowspan="2">Kode</th>                                                                                
                      <th rowspan="2">Nama Faskes</th>                                                 
                      <th colspan="12" align="center">Bulan</th>                                                          
                    </tr>
                    <tr>
                      <?php 
                      for ($i=1; $i <= 12; $i++) { 
                        echo "<td align='center'>$i</td>";
                      }
                      ?>
                    </tr>
                  </thead>
                  <tbody> 
                  <?php 
                  $no=1;
                  $sql = $this->db->select("p.*")                      
                      ->order_by("p.id","desc")
                      ->where("p.id_brand",1)
                      ->get("md_client p"); 
                  $cekInvoice="";$cekCr=""; $lama = "";                
                  foreach ($sql->result() as $isi) {
                    echo "
                      <tr>
                        <td>$no</td>
                        <td>$isi->kode_faskes</td>
                        <td>$isi->nama_faskes</td>";                        
                        $cekInvoice="";$cekCr="";$lama = "";                                 
                        for ($i=1; $i <= 12; $i++) { 
                          $iFormatted = sprintf("%02s", $i);
                          $th = $filter_1;
                          $thb = $th."-".$iFormatted;

                          $invoice = $this->db->query("SELECT lama, bukti, kode, status, kode, tgl_invoice, paid_at FROM md_invoice 
                            WHERE id_client = '$isi->id'
                            AND LEFT(tgl_invoice,7) = '$thb'");
                          if($invoice->num_rows()>0){
                            $dt = $invoice->row();                            
                            if(!is_null($dt->lama) && $dt->lama!=1){
                              $lama = "<br><label class='badge badge-danger'>bayar $dt->lama bulan<label>";
                            }
                            $kode = encrypt_url($dt->kode);
                            if(!is_null($dt->tgl_invoice)){                              
                              $link = "transaksi/invoice/detail/$kode";
                              $cekInvoice = "<a target='_BLANK' href='$link'><label class='badge badge-warning'>$dt->kode<br>$dt->tgl_invoice</label></a>";
                            }
                            if(!is_null($dt->paid_at) && $dt->status==3){
                              $cekCr = "<br><a href='assets/uploads/payments/$dt->bukti' class='badge badge-success'>$dt->paid_at</a>";
                            }
                          }else{
                            $cekInvoice="";$cekCr="";$lama="";                   
                          }
                          echo "<td align='center'>$cekInvoice $cekCr $lama</td>";
                        }                        
                      echo "
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
