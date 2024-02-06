<body>

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
      $tgl = gmdate("Y-m-d", time()+60*60*7);
      $waktu = gmdate("Y-m-d H:i:s", time()+60*60*7);
      $jenis = $this->session->userdata("jenis");
      $level = $this->session->userdata("level");
      $id_karyawan = $this->session->userdata("id_karyawan");
      if($jenis=='karyawan'){     
        $sql = $this->m_admin->getByID("md_karyawan","id_karyawan",$id_karyawan)->row();   
        $cek_datang = $this->db->query("SELECT * FROM md_presensi WHERE id_karyawan = '$id_karyawan' AND LEFT(waktu,10) = '$tgl' AND jenis = 'datang'");
        $cek_pulang = $this->db->query("SELECT * FROM md_presensi WHERE id_karyawan = '$id_karyawan' AND LEFT(waktu,10) = '$tgl' AND jenis = 'pulang'");
        if($cek_datang->num_rows() == 0){
          $lbdatang = "d-none";
          $lbpulang = "d-none";
          $datang = "";
          $pulang = 'd-none';
        }elseif($cek_datang->num_rows() == 1 AND $cek_pulang->num_rows() == 0){
          $datang = 'd-none';
          $pulang = '';
          $lbdatang = "";
          $lbpulang = "d-none";
        }else{
          $datang = 'd-none';
          $pulang = 'd-none';
          $lbdatang = "";
          $lbpulang = "";
        }
        
      ?>
      <div class="row">
        <div class="col-md-4">

          <div class="callout callout-info">
            <h5>Presensi Datang</h5>
            <?php if($cek_datang->num_rows>0){ $ro = $cek_datang->row(); ?>
              <ul>
                <li><strong>Waktu : </strong> <?php echo $ro->waktu ?> <?php echo ($ro->telat==1) ? "<span class='badge badge-danger'>terlambat</span>" : '' ; ?></li>                
                <li><strong>Status : </strong> <?php echo strtoupper($ro->kesehatan) ?></li>                                
                <li><strong>Tagging : </strong> <?php echo $ro->tagging ?></li>                
                <img src="assets/uploads/presensi/<?php echo $ro->foto ?>">
              </ul>
            <?php } ?>
          </div>
          <div class="callout callout-danger">
            <h5>Presensi Pulang</h5>
            <?php if($cek_pulang->num_rows>0){ $ro = $cek_pulang->row(); ?>
              <ul>
                <li><strong>Waktu : </strong> <?php echo $ro->waktu ?> <?php echo ($ro->telat==1) ? "<span class='badge badge-danger'>pulang terlalu cepat</span>" : '' ; ?></li>                
                <li><strong>Status : </strong> <?php echo strtoupper($ro->kesehatan) ?></li>                                
                <li><strong>Tagging : </strong> <?php echo $ro->tagging ?></li>                
                <img src="assets/uploads/presensi/<?php echo $ro->foto ?>">
              </ul>
            <?php } ?>
          </div>          
              

        </div>
        <div class="col-md-8 grid-margin">
          <div class="card">            
            <div class="card-body">
              <form action="transaksi/presensi/save" method="POST" enctype="multipart/form-data" class="form-sample">                  
                <div class="row">
                  <div class="col-12">                         
                   
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Nama Lengkap</label>
                      <div class="col-sm-9"><?php echo $sql->nama_lengkap ?></div>                                          
                    </div>                                                  
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Email</label>
                      <div class="col-sm-9"><?php echo $sql->email ?></div>                                          
                    </div>                                                                    
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">No HP</label>
                      <div class="col-sm-9"><?php echo $sql->no_hp ?></div>                                                                
                    </div>       
                                                   
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="waktu" value="<?php echo $waktu ?>">
                        <input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan ?>">
                        <input type="text" class="form-control" name="kerja_ket" placeholder="Keterangan">
                      </div>                                          
                    </div>                                                                  
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Status</label>
                      <div class="col-sm-9">                                            
                        <div class="icheck-success d-inline">
                          <input type="radio" name="kesehatan" value="hadir" checked id="radioDanger9">
                          <label for="radioDanger9">Hadir
                          </label>
                        </div>
                        <div class="icheck-warning d-inline">
                          <input type="radio" name="kesehatan" value="izin" id="radioDanger8">
                          <label for="radioDanger8">Izin
                          </label>
                        </div>                        
                        <div class="icheck-danger d-inline">
                          <input type="radio" name="kesehatan" value="sakit" id="radioDanger7">
                          <label for="radioDanger7">Sakit
                          </label>
                        </div>                                                
                      </div>
                    </div>                            
                    
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Foto</label>
                      <div class="col-sm-8">                        
                        <input type="file" required class="form-upload" name="foto" accept="capture=camera">
                      </div>                                                                
                    </div>                                                                                                                                                                         

                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label-sm">Tagging</label>
                      <div class="col-sm-8">                        
                        <input type="text" readonly id="locationResult" class="form-control" name="tagging" placeholder="Latitude Longitude">                        
                      </div>                                                                
                    </div>                                                                                                                                                                         
                                        
                  </div>   
                </div>
                <div class="row">
                  <div class="col-12">                
                    <hr>
                    <div class="row">
                      <div class="col-md-12">                    
                        <button type="submit" id="tombol1" name="submit" value="datang" onclick="return confirm('Anda yakin?')" class="btn btn-block btn-primary <?php echo $datang ?>"><i class="fa fa-download"></i> Datang</button>                          
                        <button type="submit" id="tombol2" name="submit" value="pulang" onclick="return confirm('Anda yakin?')" class="btn btn-block btn-danger <?php echo $pulang ?>"><i class="fa fa-upload"></i> Pulang</button>                                                   
                      </div>
                    </div>
                  </div>
                </div>                
              </form>   
                  

            </div>
          </div>
        </div>
        
      <?php } ?>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Dapatkan referensi elemen input
      var locationResultInput = document.getElementById("locationResult");

      // Periksa apakah Geolocation didukung oleh browser
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
          // Akses data koordinat
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;

          // Tampilkan hasil di dalam input teks
          locationResultInput.value = "Latitude: " + latitude + ", Longitude: " + longitude;
        }, function (error) {
          // Tangani kesalahan jika ada
          switch (error.code) {
            case error.PERMISSION_DENIED:
              locationResultInput.value = "Anda menolak akses ke lokasi.";
              break;
            case error.POSITION_UNAVAILABLE:
              locationResultInput.value = "Informasi lokasi tidak tersedia.";
              break;
            case error.TIMEOUT:
              locationResultInput.value = "Waktu permintaan lokasi habis.";
              break;
            case error.UNKNOWN_ERROR:
              locationResultInput.value = "Terjadi kesalahan yang tidak diketahui.";
              break;
          }
        });
      } else {
        // Browser tidak mendukung Geolocation API
        alert("Geolocation tidak didukung oleh browser ini.");
      }
    });
  </script>
    