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
          $jenis = "datang";
        }elseif($cek_datang->num_rows() == 1 AND $cek_pulang->num_rows() == 0){
          $datang = 'd-none';
          $pulang = '';
          $lbdatang = "";
          $lbpulang = "d-none";
          $jenis = "pulang";
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
                <img width="100px" src="assets/uploads/presensi/<?php echo $ro->foto ?>">
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
                <img width="100px" src="assets/uploads/presensi/<?php echo $ro->foto ?>">
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
                        <input type="hidden" id="jenis" name="jenis" value="<?php echo $jenis ?>">
                        <input type="hidden" id="waktu" name="waktu" value="<?php echo $waktu ?>">
                        <input type="hidden" id="id_karyawan" name="id_karyawan" value="<?php echo $id_karyawan ?>">
                        <input type="text" class="form-control" id="kerja_ket" name="kerja_ket" placeholder="Keterangan">
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
                        <input type="file" id="fileInput" required class="form-upload" name="foto" accept="capture=camera">
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
                        <button class="btn btn-block btn-primary" type="button" onclick="simpanData()">Simpan</button>
                        <!-- <button type="submit" id="tombol1" name="submit" value="datang" onclick="return confirm('Anda yakin?')" class="btn btn-block btn-primary <?php echo $datang ?>"><i class="fa fa-download"></i> Datang</button>                          
                        <button type="submit" id="tombol2" name="submit" value="pulang" onclick="return confirm('Anda yakin?')" class="btn btn-block btn-danger <?php echo $pulang ?>"><i class="fa fa-upload"></i> Pulang</button>                                                    -->
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
              locationResultInput.value = "error,Anda menolak akses ke lokasi.";
              break;
            case error.POSITION_UNAVAILABLE:
              locationResultInput.value = "error,Informasi lokasi tidak tersedia.";
              break;
            case error.TIMEOUT:
              locationResultInput.value = "error,Waktu permintaan lokasi habis.";
              break;
            case error.UNKNOWN_ERROR:
              locationResultInput.value = "error,Terjadi kesalahan yang tidak diketahui.";
              break;
          }
        });
      } else {
        // Browser tidak mendukung Geolocation API
        alert("Geolocation tidak didukung oleh browser ini.");
      }
    });
  </script>

<script>

  function simpanData() {

    // Mendapatkan gambar dari input file
    const fileInput = document.getElementById('fileInput');
    const selectedImage = fileInput.files[0];

    var radioButtons = document.getElementsByName('kesehatan');
    var selectedValue;

    for (var i = 0; i < radioButtons.length; i++) {
      if (radioButtons[i].checked) {
        selectedValue = radioButtons[i].value;
        break;
      }
    }

    // Mengompres gambar sebelum mengirimkannya ke server
    compressImage(selectedImage, function (compressedImageBlob) {
      // Parameter tambahan
      const additionalParameters = {
        id_karyawan: $("#id_karyawan").val(),        
        kerja_ket: $("#kerja_ket").val(),        
        kesehatan: selectedValue,
        waktu: $("#waktu").val(),                
        jenis: $("#jenis").val(),        
        tagging: $("#locationResult").val()      
      };

      // Menggabungkan gambar yang dikompres dengan parameter tambahan
      const formData = new FormData();
      formData.append('image', compressedImageBlob, 'compressedImage.jpg');
      for (const key in additionalParameters) {
        formData.append(key, additionalParameters[key]);
      }

      // Mengirim data ke server menggunakan Ajax
      $.ajax({
        url: '<?php echo site_url('transaksi/presensi/save')?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          location.reload();
        },
        error: function (error) {
          alert(error);
        },
      });
    });
  }

  function compressImage(file, callback) {
    const reader = new FileReader();

    reader.onload = function (e) {
      const img = new Image();

      img.onload = function () {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Menghitung rasio kompresi
        const maxWidth = 800; // Sesuaikan dengan kebutuhan
        const maxHeight = 600; // Sesuaikan dengan kebutuhan
        let width = img.width;
        let height = img.height;

        if (width > height) {
          if (width > maxWidth) {
            height *= maxWidth / width;
            width = maxWidth;
          }
        } else {
          if (height > maxHeight) {
            width *= maxHeight / height;
            height = maxHeight;
          }
        }

        // Mengatur ukuran canvas
        canvas.width = width;
        canvas.height = height;

        // Menggambar gambar ke dalam canvas dengan ukuran yang disesuaikan
        ctx.drawImage(img, 0, 0, width, height);

        // Mengompres gambar menjadi data URL
        canvas.toBlob(function (blob) {
          // Panggil kembali fungsi dengan objek Blob hasil kompresi
          callback(blob);
        }, 'image/jpeg', 0.7); // Sesuaikan dengan kebutuhan kualitas
      };

      img.src = e.target.result;
    };

    reader.readAsDataURL(file);
  }

  </script>  