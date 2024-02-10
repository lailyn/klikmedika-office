


    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">          
          <div class="card-body">            
            <div class="box">                            
              <div class="table-responsive">
                <table id="example1" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>                      
                      <th>Nama Karyawan</th>     
                      <th>Datang/Pulang</th>                                       
                      <th>Waktu</th>   
                      <th>Status</th>
                      <th>Location</th>                                                                                                                                                                                                                       
                      <th>Foto</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $no = 1;                  
                  $sql = $this->m_admin->getAll("md_presensi");                  
                  foreach($sql->result() AS $dt){                    
                    $ceksaksi = $this->db->query("SELECT md_karyawan.* FROM md_karyawan WHERE id_karyawan = '$dt->id_karyawan'");
                    $karyawan = ($ceksaksi->num_rows()>0)?$ceksaksi->row()->nama_lengkap:'';
                    $telatS = ($dt->jenis=="datang")?"terlambat":"pulang terlalu cepat";
                    $telat = ($dt->telat==1)?"<label class='badge badge-danger'>".$telatS."</label>":'';
                    echo "
                    <tr>
                      <td>$no</td>
                      <td>$karyawan</td>
                      <td>$dt->jenis</td>                      
                      <td>$dt->waktu $telat</td>
                      <td>$dt->kesehatan</td>                                                                  
                      <td>$dt->tagging</td>                                              
                      <td>
                        <img src='assets/uploads/presensi/$dt->foto' width='50px'>
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
    </div>
  </div>

