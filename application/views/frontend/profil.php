    
      <div class="iq-breadcrumb">
         <div class="container-fluid">
            <div class="row align-items-center">
               <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <h2 class="subtitle iq-fw-6 text-white mb-3">Profil</h2>
               </div>               
            </div>
         </div>
      </div>

    <div class="main-content">
      
      
      
      <section class="iq-products pt-5">
        <div class="container">
          <div class="row flex-row-reverse">
            <div class="col-lg-6 text-center align-self-center">
              <img src="assets/art1kel/<?=$this->m_admin->getByID("md_profil","id_profil",11)->row()->gambar;?>" class="img-fluid" alt="images">
            </div>
            <div class="col-lg-6 iq-rmt-50">
              <h6 class="title mb-0"><?=$this->m_admin->getByID("md_profil","id_profil",11)->row()->profil;?></h6>              
              <p class="mb-5">
                <?=$this->m_admin->getByID("md_profil","id_profil",11)->row()->deskripsi;?>
              </p>
            </div>
          </div>
        </div>
      </section>
      <!-- Features-->
      <section class="iq-feature pt-0">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              
              <div class="title-box">
                <h6 class="title">Dokumen Legal</h6>                
              </div>
            </div>
          </div>
          <div class="row justify-content-center">

            <?php 
            $sql = $this->m_admin->getByID("md_dokumen","status","publish");
            foreach($sql->result() AS $data){
            ?>  

            <div class="col-lg-4 col-md-6">
              <div class="iq-feature-box">
                <a href="assets/art1kel/<?=$data->file?>">
                  <img width="100%" src="assets/art1kel/<?=$data->gambar?>">
                </a>
              </div>
            </div> 

            <?php } ?>           
            
            
          </div>
        </div>
        
      </section>
      <!-- Features End-->
      <!-- clients -->
      <section class="iq-clients light-gray-bg">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="title-box">
                <h2>Kami juga Bekerja Sama dengan Berbagai Pihak</h2>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="false" data-items="5" data-items-laptop="5" data-items-tab="4" data-items-mobile="2" data-items-mobile-sm="2" data-margin="30" >
                  
                <?php 
                $sql = $this->m_admin->getByID("md_kerjasama","status","publish");
                foreach($sql->result() AS $data){
                ?>  
                <div class="item ">
                  <div class=" iq-client-box">
                    <img src="assets/art1kel/<?=$data->gambar?>" class="img-fluid default-img" alt="images">                    
                  </div>
                </div>

                <?php } ?>

              </div>
            </div>
          </div>
        </div>
      </section>
      