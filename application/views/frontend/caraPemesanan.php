
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Cara Pemesanan</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">
        
      <section class="iq-products">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 text-center align-self-center">
              <img src="assets/art1kel/<?=$this->m_admin->getByID("md_profil","id_profil",8)->row()->gambar;?>" class="img-fluid" alt="images">
            </div>
            <div class="col-lg-6 iq-rmt-50">
              <h2 class="title mb-0"><?=$this->m_admin->getByID("md_profil","id_profil",8)->row()->profil;?></h2>              
              <p class="mb-5">
                <?=$this->m_admin->getByID("md_profil","id_profil",8)->row()->deskripsi;?>
              </p>              
            </div>
          </div>
        </div>
      </section>
      
    </div>