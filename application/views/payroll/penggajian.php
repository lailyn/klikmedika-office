    
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
				$row  = $dt_penggajian->row();              
				$read = "readonly";
				$read2 = "disabled";
				$vis  = "style='display:none;'";
				$form = "save";              
				$form_id = "";
			}elseif($mode == 'edit'){
				$row  = $dt_penggajian->row();
				$read = "";
				$read2 = "";
				$form = "update";              
				$vis  = "";
				$form_id = "<input type='hidden' name='id' value='$row->id_penggajian'>";              
        if(!is_null($row->id_karyawan)){
          $dt = $this->db->query("SELECT * FROM md_karyawan
            INNER JOIN md_bagian ON md_karyawan.id_bagian = md_bagian.id_bagian
            WHERE md_karyawan.id_karyawan = '$row->id_karyawan'");
          $nama_karyawan = ($dt->num_rows()>0)?$dt->row()->nama_lengkap:"";
          $bagian = ($dt->num_rows()>0)?$dt->row()->bagian:"";
        }
        if(!is_null($row->id_dokter)){
          $dt = $this->db->query("SELECT * FROM md_dokter
            INNER JOIN md_bagian ON md_dokter.id_bagian = md_bagian.id_bagian
            WHERE md_dokter.id_dokter = '$row->id_dokter'");
          $nama_karyawan = ($dt->num_rows()>0)?$dt->row()->nama." (dokter)":"";
          $bagian = ($dt->num_rows()>0)?$dt->row()->bagian:"";
        }
			}


      $feeIT=$this->m_admin->getFee(2);

			?>

      <div class="row">
        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a href="payroll/penggajian" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> View</a></h4>
            </div>
            <div class="card-body">
              <div class="col-12">                
                <form action="payroll/penggajian/update" method="POST" class="form-sample">                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm text-right">No Faktur</label>
                        <div class="col-sm-2">                     
                          <input type="hidden" name="id" value="<?php echo $row->id_penggajian ?> ">     
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $row->no_faktur : "" ; ?>" name="no_faktur" placeholder="No Faktur" class="form-control form-control-sm " />
                        </div>
                        <label class="col-sm-2 col-form-label-sm text-right">Tgl</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $row->tgl : "" ; ?>" name="tgl" placeholder="Tgl" class="form-control form-control-sm " />
                        </div>
                        <label class="col-sm-2 col-form-label-sm text-right">Bagian</label>                        
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $bagian : "" ; ?>" name="bagian" placeholder="bagian" class="form-control form-control-sm " />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm text-right">Nama Lengkap</label>                        
                        <div class="col-sm-6">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $nama_karyawan : "" ; ?>" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control form-control-sm " />
                        </div>                                              
                        <label class="col-sm-2 col-form-label-sm text-right">Gaji Pokok</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $row->gaji_pokok : "" ; ?>" name="gaji_pokok" placeholder="Gaji Pokok" class="form-control form-control-sm " />
                        </div>
                      </div>
                      <div class="form-group row">                        
                        <label class="col-sm-2 col-form-label-sm text-right">Tunj Transport</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? mata_uang($row->tunj_transport) : "" ; ?>" name="tunj_transport" placeholder="Tunj Transport" class="form-control form-control-sm " />
                        </div>                               
                        <label class="col-sm-2 col-form-label-sm text-right">Tunj Makan</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? mata_uang($row->tunj_makan) : "" ; ?>" name="tunj_makan" placeholder="Tunj Makan" class="form-control form-control-sm " />
                        </div>                
                        <?php if($bagian=="Tim IT" OR $bagian=="CEO"){ ?>
                          <label class="col-sm-2 col-form-label-sm text-right">Fee Tim IT</label>
                          <div class="col-sm-2">                          
                            <input type="text" readonly value="<?php echo $tampil = ($row!='') ? $feeIT : "" ; ?>" name="feeIT" placeholder="Fee Tim IT" class="form-control form-control-sm " />
                          </div>               
                        <?php } ?>
                      </div>
                      <div class="form-group row">                        
                        <label class="col-sm-2 col-form-label-sm text-right">Tunj Istri</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? mata_uang($row->tunj_istri) : "" ; ?>" name="tunj_istri" placeholder="Tunj Istri" class="form-control form-control-sm " />
                        </div>                               
                        <label class="col-sm-2 col-form-label-sm text-right">Tunj Anak</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? mata_uang($row->tunj_anak) : "" ; ?>" name="tunj_anak" placeholder="Tunj Anak" class="form-control form-control-sm " />
                        </div>                               
                        <label class="col-sm-2 col-form-label-sm text-right">Pot Asuransi</label>
                        <div class="col-sm-2">                          
                          <input type="text" readonly value="<?php echo $tampil = ($row!='') ? mata_uang($row->pot_asuransi) : "" ; ?>" name="pot_asuransi" placeholder="Pot Asuransi" class="form-control form-control-sm " />
                        </div>                               
                      </div>                                            
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label-sm text-right">Keterangan</label>
                        <div class="col-sm-10">                          
                          <textarea class="form-control" readonly name="keterangan" id="summernote"><?php echo $row->keterangan ?></textarea>
                        </div>                        
                      </div>     
                      <hr>
                      <div class="row" <?php echo $vis ?> >
                        <div class="col-md-6">                    
                          <button type="submit" onclick="return confirm('Anda Yakin?')" name="submit" value="approve" class="btn btn-primary">Approve</button>                                            
                          <button type="submit" onclick="return confirm('Anda Yakin?')" name="submit" value="reject" class="btn btn-danger">Reject</button>                                            
                        </div>
                      </div>
                    </form>                  
                    <hr>
                      <div class="form-group row">
                        Tambah Detail Penggajian
                        <table class="table table-bordered" width="100%">
                          <thead>
                            <tr>
                              <td width="5%">No</td>
                              <td width="10%">Op</td>
                              <td width="20%">Nominal</td>
                              <td>Uraian</td>
                              <td width="5%"></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            $no=1;
                            $sql = $this->m_admin->getByID("md_penggajian_detail","no_faktur",$row->no_faktur);
                            foreach($sql->result() as $rs){
                              echo "
                              <tr>
                                <td>$no</td>
                                <td>$rs->jenis</td>
                                <td>".mata_uang_help($rs->nominal)."</td>
                                <td>$rs->uraian</td>
                                <td>
                                  <a href='payroll/penggajian/deleteDetail?id=$row->id_penggajian&d=$rs->id' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
                                </td>
                              </tr>
                              ";
                              $no++;
                            }
                            ?>
                            <tr>
                              <form action="payroll/penggajian/updateDetail" method="POST">
                              <td></td>
                              <td>
                                <select name="jenis" class="form-control form-control-sm">
                                  <option>+</option>
                                  <option>-</option>
                                </select>
                              </td>
                              <td>
                                <input type="hidden" name="id" value="<?= $row->id_penggajian ?>">
                                <input type="hidden" name="no_faktur" value="<?= $row->no_faktur ?>">
                                <input autocomplete="off" type="text" class="form-control form-control-sm" name="nominal">
                              </td>
                              <td>
                                <input autocomplete="off" type="text" class="form-control form-control-sm" name="uraian">
                              </td>
                              <td>
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                              </td>
                              </form>
                            </tr>
                          </tbody>
                        </table>
                      </div>                                       
                    </div>                    
                  </div>   
                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php }elseif($set=="download"){ 
      if($dt->num_rows()==0){
        echo "Data tidak ditemukan";
      }else{
        $row = $dt->row();
        if(!is_null($row->id_karyawan)){          
          $dt = $this->db->query("SELECT * FROM md_karyawan            
            INNER JOIN md_bagian ON md_karyawan.id_bagian = md_bagian.id_bagian            
            WHERE md_karyawan.id_karyawan = '$row->id_karyawan'");
          $nama_karyawan = ($dt->num_rows()>0)?$dt->row()->nama_lengkap:"";
          $bagian = ($dt->num_rows()>0)?$dt->row()->bagian:"";          
        }
              
        $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();
      ?>

      <!DOCTYPE html>
      <html>      
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Cetak</title>
          <style>
            @media print {
              @page {                
                sheet-size: 219mm 278mm;                                
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 0.1cm;
                margin-top: 0.5cm;
                padding-right: 1cm;                
              }
              .text-center{text-align: center;}
              .bold{font-weight: bold;}
              .table {
                width: 100%;
                max-width: 100%;
                border-collapse: collapse;
               /*border-collapse: separate;*/
              }
              .table-bordered td {
                border: 0.01em solid black;
                padding-left: 6px;
                padding-right: 6px;                
              }
              body{
                font-family: "Arial";
                font-size: 11pt;
              }
              
            }
          </style>
        </head>
        <body> 
        <table border="0" width="100%">
          <tr>
            
            <td colspan="2" align="center" width="60%">
              <img src="assets/im493/<?=$setting->logo?>" width="10%">
              <h2><u><?=$setting->perusahaan?></u></h2>
              <?=$setting->alamat?> <br> 
              Tlpn : <?=$setting->no_hp?> email: <?=$setting->email?> <br>
              Website : <?=$setting->url?>
            </td>
            
          </tr>
          <tr>
            <td align="center" colspan="2"><hr></td>
          </tr>
          <tr>
            <td align="center" colspan="2"><b><u>Slip Gaji Karyawan</u></b></td>
          </tr>
          <tr>
            <td align="center" colspan="2"><b>Periode <?= $row->bln ?></b></td>
          </tr>

          <tr>
            <td width="20%">Nama Karyawan</td>
            <td>: <?= $nama_karyawan ?></td>
          </tr>          
          <tr>
            <td>Jabatan</td>            
            <td>: <?=  $bagian ?></td>
          </tr>
        </table>
    
        <table class="table-bordered" align="center" width="90%">
          <tr>
            <td align="center" colspan="3"><b><br>PENERIMAAN <br></b></td>
            <td align="center" colspan="3"><b><br>POTONGAN <br></b></td>
          </tr>
          <tr>
            <td>Gaji Pokok</td>
            <td width="1%">:</td>
            <td align="right">Rp <?= mata_uang_help($row->gaji_pokok); ?></td>
            
            <td colspan="3" rowspan="3">
              <?php 
              $tp=0;
              $sql = $this->db->get_where("md_penggajian_detail",array("no_faktur"=>$row->no_faktur, "jenis"=>"-"));
              if($sql->num_rows()>0){
                echo "<ul>";
                foreach($sql->result() AS $dt){
                  $tp+=$dt->nominal;
                  echo "<li> $dt->uraian ==> Rp ".mata_uang_help($dt->nominal)." </li>";
                }
                echo "</ul>";
              }else{
                echo "Tidak ada potongan";
              }
              ?>
            </td>            
          </tr>                
          <tr>
            <td width="30%">Tunj Transport</td>
            <td>:</td>
            <td align="right">Rp <?= mata_uang_help($row->tunj_transport); ?></td>
          </tr>
          <tr>
            <td><b>Tambahan</b></td>
            <td width="1%">:</td>
            <td>
              <?php 
              $ta=0;
              $sql = $this->db->get_where("md_penggajian_detail",array("no_faktur"=>$row->no_faktur, "jenis"=>"+"));
              if($sql->num_rows()>0){
                echo "<ul>";
                foreach($sql->result() AS $dt){
                  $ta+=$dt->nominal;
                  echo "<li> $dt->uraian ==> Rp ".mata_uang_help($dt->nominal)." </li>";
                }
                echo "</ul>";
              }else{
                echo "Tidak ada potongan";
              }
              ?>
            </td>
          </tr>
          
          <tr>
            <td><b>Total</b></td>
            <td width="1%">:</td>
            <td width="35%" align="right"><b>Rp <?= mata_uang_help($a = $row->total_gaji + $ta); ?></b></td>                  
            <td width="20%"><b>Total</b></td>
            <td width="1%">:</td>
            <td width="35%" align="right"><b>Rp <?= mata_uang_help($b = $tp); ?></b></td>
          </tr>    
        </table>
        
        <table border="0">

          <tr>
            <td align="center" colspan="2"><br></td>
          </tr>
          <tr>
            <td align="center" style="background-color: yellow;" colspan="2"><b>TOTAL PENERIMAAN GAJI (TAKE HOME PAY) : Rp <?= mata_uang_help($a-$b) ?></b></td>
          </tr>         
          <tr>
            <td>
              Jambi, <?php echo date("d-m-Y"); ?> <br>
              Disetujui Oleh
            </td>
            <td><br><br><br><br><br><br><br><br><br></td>
          </tr> 
          <tr>
            <td>
              <u><?=$setting->nama_pimpinan?></u>
            </td>
          </tr>
                             
        </table>
        </body>
      </html>


    <?php } }else{ ?>


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-header">
            <?php if(is_null($history)){ ?>            
            <form action="payroll/penggajian/generate" method="POST" enctype="multipart/form-data" class="form-sample">                  
              <div class="row">
                <div class="col-sm-8">                
                  <div class="form-group row">   
                    <input type="hidden" name="filter">                     
                    <div class="col-sm-4">   
                      <input type="month" value="<?php echo $cek_tgl1 = ($bln!="") ? $bln : "" ?>" required class="form-control form-control-sm" name="bln">
                    </div>                    
                    <div>
                      <button onclick="return confirm('Pastikan proses berbagai macam transaksi di Backend Kei Medika dan Klinik sudah selesai, lanjutkan?')" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Generate</button>
                      <a href="payroll/penggajian/index/history" class="btn btn-warning btn-sm"><i class="fa fa-history"></i> Riwayat</a>                      
                    </div>
                  </div>
                </div>
              </div>                  
            </form>
            <?php }else{ ?>
              <a href="payroll/penggajian" class="btn btn-warning btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>                                    
            <?php } ?>      
          </div>
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>                      
                      <th width="5%">No</th>
                      <th>Bulan</th>                      
                      <th>Tgl Buat</th>                      
                      <th>No Faktur</th>                      
                      <th>Nama Lengkap</th>                                                              
                      <th>Bagian</th>                      
                      <th>Gapok</th>                                                                                                                                                  
                      <th>Tunjangan</th>                                                                                                                                                  
                      <th>Total</th>                                                                
                      <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no=1;                  
                  foreach ($dt_penggajian->result() as $isi) {
                    if($isi->status=="approved"){ 
                      $er = 'd-none';$sr="";
                    }else{ 
                      $er = "";
                      $sr = "d-none";
                    }
                    if(!is_null($history)){
                      $hapus = "d-none";
                    }else{
                      $hapus = "";
                    }
                    if(!is_null($isi->id_karyawan)){
                      $dt = $this->db->query("SELECT * FROM md_karyawan
                        INNER JOIN md_bagian ON md_karyawan.id_bagian = md_bagian.id_bagian
                        WHERE md_karyawan.id_karyawan = '$isi->id_karyawan'");
                      $nama_karyawan = ($dt->num_rows()>0)?$dt->row()->nama_lengkap:"";
                      $bagian = ($dt->num_rows()>0)?$dt->row()->bagian:"";
                    }
                    
                    $tunjangan="";
                    if($isi->tunj_transport!=0) $tunjangan .= "Transport: ".mata_uang($isi->tunj_transport);
                    if($isi->tunj_makan!=0) $tunjangan .= "<br>Makan: ".mata_uang($isi->tunj_makan);
                    if($isi->tunj_anak!=0) $tunjangan .= "<br>Anak: ".mata_uang($isi->tunj_anak);
                    if($isi->tunj_istri!=0) $tunjangan .= "<br>Istri: ".mata_uang($isi->tunj_istri);

                    $lainnyaTambah = 0;$lainnyaKurang = 0;
                    $cekTambah = $this->db->query("SELECT SUM(nominal) AS jum FROM md_penggajian_detail WHERE jenis = '+' AND no_faktur = '$isi->no_faktur'");
                    $cekKurang = $this->db->query("SELECT SUM(nominal) AS jum FROM md_penggajian_detail WHERE jenis = '-' AND no_faktur = '$isi->no_faktur'");
                    if($cekTambah->num_rows()>0) $lainnyaTambah = $cekTambah->row()->jum;
                    if($cekKurang->num_rows()>0) $lainnyaKurang = $cekKurang->row()->jum;
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>$isi->bln</td>
                      <td>$isi->tgl</td>
                      <td>$isi->no_faktur</td>
                      <td>$nama_karyawan</td>                      
                      <td>$bagian</td>                      
                      <td>".mata_uang($isi->gaji_pokok)."</td>                      
                      <td>$tunjangan</td>                      
                      <td>".mata_uang($isi->total_gaji + $lainnyaTambah - $lainnyaKurang)."</td>"; ?>
                      <td>                        
                        <a onclick="return confirm('Anda yakin?')" href="payroll/penggajian/delete?id=<?php echo $isi->no_faktur ?>" class="btn btn-danger btn-sm <?=$hapus?>" title="Hapus"> Hapus</a>                                                      
                        <a href="payroll/penggajian/review?id=<?php echo $isi->id_penggajian ?>" class="btn btn-success btn-sm <?=$er?>" title="Review"> Review</a>                                                      
                        <a href="payroll/penggajian/cetak?id=<?php echo $isi->id_penggajian ?>" class="btn btn-warning btn-sm <?= $sr ?>" title="Cetak"> Cetak Slip</a>                                                      
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
