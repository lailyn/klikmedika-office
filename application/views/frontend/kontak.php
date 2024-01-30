
      <div class="iq-breadcrumb">
         <div class="container-fluid">
            <div class="row align-items-center">
               <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <h2 class="subtitle iq-fw-6 text-white mb-3">Kontak Kami</h2>
               </div>               
            </div>
         </div>
      </div>
      <!--=================================
      Breadcrumb -->
      <!-- Main Content -->
      <div class="main-content">
      <section class="iq-contact">
        <div class="container"> 
            <div class="row"> 
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
                <div class="col-lg-6 mb-2"> 
                <h2>Bisa kirim kritik dan saran untuk <?=$setting->perusahaan?></h2>                
                <form method="POST" action="home/savePesan">
                  <div class="row"> 
                        <div class="col-lg-6">  
                          <input type="text" name="nama" class="form-control" id="inputName" placeholder="Nama Lengkap"> 
                        </div>
                        <div class="col-lg-6">   
                          <input type="Email" name="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                        <div class="col-lg-12"> 
                          <input type="text" name="subjek" class="form-control" id="inputSubject" placeholder="Keterangan">
                        </div>
                        <div class="col-lg-12"> 
                          <textarea class="form-control" name="pesan" id="exampleFormControlTextarea1" rows="7" placeholder="Pesan"></textarea>
                        </div>
                        <div class="col-lg-12"> 
                        <button class="button" type="submit">Kirim Pesan</button>
                        </div>
                  </div>
                </form>
                 </div>
                <div class="col-lg-4"> 
                    <div class="iq-address">  
                         <div class="info">
            <h4 class="iq-font-30 mb-4">Alamat Kantor</h4>
            <p class="mb-0"><?=$setting->alamat?></p>
           
          </div>
                    </div>
                    <div class="iq-address">  
                          <div class="info">
            <h4 class="iq-font-30 mb-4">Kontak</h4>
            <p class="mb-0">Phone: <?=$setting->no_hp?><br>            
            Email: <?=$setting->email?></p>
          </div>
                    </div>
                 </div>
            </div>
        </div>

      </section>
        
   <div class="overview-block-ptb iq-map pt-0">
     <div class="container">  
        <div class="row"> 
            <div class="col-sm-12"> 
              <?php 
                $lat = $setting->lat;
                $lang = $setting->lang;
                ?>

                <iframe src="https://maps.google.com/maps?q=<?php echo $lat ?>,<?php echo $lang ?>&hl=en&z=14&amp;output=embed" width="100%" frameborder="0" style="width:100%; height: 300px; border:0" allowfullscreen>></iframe>                            
            </div>
        </div>
     </div>
   </div>
       
       
      
     
   
      </div>
     