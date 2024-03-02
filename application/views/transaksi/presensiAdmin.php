


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">       
          <div class="card-header">
            
            <form action="transaksi/presensi/index" method="GET" enctype="multipart/form-data" class="form-sample">                  
              <div class="row">
                <div class="col-sm-12">           
                  <div class="form-group row">                                                                              
                    <label class="col-sm-1 col-form-label-sm text-right">Tgl Awal</label>
                    <div class="col-sm-2">                          
                      <input id="presensi_1" type="date" value="<?php echo $cek_tgl1 = ($filter_1!="") ? $filter_1 : "" ?>" name="tgl_awal" required placeholder="Tanggal Awal" class="form-control form-control-sm">
                    </div>                                                            
                    <label class="col-sm-1 col-form-label-sm text-right">Tgl Akhir</label>
                    <div class="col-sm-2">                          
                      <input id="presensi_2" type="date" value="<?php echo $cek_tgl1 = ($filter_2!="") ? $filter_2 : "" ?>" name="tgl_akhir" required placeholder="Tanggal Akhir" class="form-control form-control-sm">
                    </div>                              

                  
                    <label class="col-sm-1 col-form-label-sm text-right">Status</label>
                    <div class="col-sm-2">                        
                      <select id="presensi_3" class="form-control form-control-sm" name="jenis">
                        <option <?php echo ($filter_3=='')?'selected':''; ?> value="">Semua</option>                        
                        <option <?php echo ($filter_3=='datang')?'selected':''; ?> value="datang">Datang</option>
                        <option <?php echo ($filter_3=='pulang')?'selected':''; ?> value="pulang">Pulang</option>
                      </select>
                    </div>                
                    <label class="col-sm-1 col-form-label-sm text-right">Karyawan</label>
                    <div class="col-sm-2">                        
                      <select id="presensi_4" class="form-control form-control-sm" name="id_karyawan">
                        <option value="">Semua</option>    
                        <?php           
                        $dt = $this->db->query("SELECT * FROM md_karyawan WHERE status = 1 ORDER BY nama_lengkap ASC");                
                        foreach ($dt->result() as $isi) {                                        
                          if($filter_4==$isi->id_karyawan) $rt='selected';
                            else $rt = "";
                          echo "<option $rt value='$isi->id_karyawan'>$isi->nama_lengkap</option>";
                        }
                        ?>                    
                      </select>
                    </div>   
                  </div>
                  <div class="form-group row">                                                                                               
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">                                            
                      <div class="input-group col-sm-4">
                        <div class="input-group-append">
                          <button type="submit" name="filter" value="preview" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Preview</button>                      
                          <a href="transaksi/presensi/index/reset" class="btn btn-sm btn-warning">Reset</a>                      
                        </div>
                        <input type="month" value="<?=date('Y-m')?>" class="form-control form-control-sm" name="bulan">
                        <div class="input-group-append">
                          <button class="btn btn-info btn-sm" type="submit" name="filter" value="download">Cetak Rekap</button>
                        </div>
                      </div>                      
                    
                    </div>                  
                  </div>
                </div>
              </div>                  
            </form>                
            
          </div>   
          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="presensi_dt" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Nama Karyawan</th>     
                      <th>Datang/Pulang</th>                                       
                      <th>Waktu</th>   
                      <th>Status</th>
                      <th>Location</th>                                                                                                                                                                                                                       
                      <th>Foto</th>                      
                      <th width="10%">#</th>                      
                    </tr>
                  </thead>
                  <tbody>                                
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

