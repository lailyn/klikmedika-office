      
      <section class="iq-feature pt-5">          
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <?php 
            $no=1;
            $sql = $this->m_admin->getByID("md_slide","status","publish");
            foreach($sql->result() AS $data){
              if($no==1) $aktif = "active";
                else $aktif = "";
            ?>
            <div class="carousel-item <?=$aktif?>">
              <img class="d-block w-100" src="assets/art1kel/<?=$data->gambar?>" alt="<?=$data->gambar?>">
              <div class="carousel-caption d-none d-md-block">
                <h1 class="text-white"><?=$data->judul?></h1>
                <p><?=$data->isi?></p>
              </div>
            </div>
            <?php $no++; } ?>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </section>
      
        <section class="iq-feature pt-0">          
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                
                <div class="title-box">                  
                  <h2 class=" ">Kenapa Puri Gracia?</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                    <i class="flaticon-manager flaticon mb-3"></i>
                    <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",1)->row()->profil;?></h4>
                    <p><?=$this->m_admin->getByID("md_profil","id_profil",1)->row()->deskripsi;?></p>                  
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                   <i class="flaticon-statistics flaticon mb-3"></i>
                   <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",2)->row()->profil;?></h4>
                    <p><?=$this->m_admin->getByID("md_profil","id_profil",2)->row()->deskripsi;?></p>                  
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                    <i class="flaticon-diagram flaticon mb-3"></i>
                    <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",3)->row()->profil;?></h4>
                    <p><?=$this->m_admin->getByID("md_profil","id_profil",3)->row()->deskripsi;?></p>                  
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                    <i class="flaticon-cellphone flaticon mb-3"></i>
                    <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",4)->row()->profil;?></h4>
                    <p><?=$this->m_admin->getByID("md_profil","id_profil",4)->row()->deskripsi;?></p>                  
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                    <i class="flaticon-ip flaticon mb-3"></i>
                    <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",5)->row()->profil;?></h4>
                    <p><?=$this->m_admin->getByID("md_profil","id_profil",5)->row()->deskripsi;?></p>                  
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="iq-feature-box">
                  <i class="flaticon-24-hours flaticon mb-3"></i>
                   <h4 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",6)->row()->profil;?></h4>
                  <p><?=$this->m_admin->getByID("md_profil","id_profil",6)->row()->deskripsi;?></p>                  
                </div>
              </div>
            </div>
          </div>
          <center>
            <a class="btn btn-warning mt-2" href="kalender"><i class="fa fa-calendar"></i> Lihat Kalender Puri Gracia</a>
          </center>
        </section>
        <!-- Features End-->
        <!-- Finance -->
        <section class="iq-finance pt-0">
          <div class="container">
            <div class="row flex-row-reverse">
              <div class="col-lg-6 position-relative text-center">
                
                <div id="scene" data-relative-input="true" class="wow" data-wow-duration="4s" data-wow-delay="0.6s" >
                  <div data-depth="0.1" class=" feature-one"><img src="assets/frontend/images/feature/12.png" class="img-fluid" alt="images"></div>
                  <div data-depth="0.1" class=" feature-two"><img src="assets/frontend/images/feature/13.png" class="img-fluid" alt="images"></div>
                  <div data-depth="0.1" class=" feature-three"><img src="assets/frontend/images/feature/09.png" class="img-fluid" alt="images"></div>
                  <div data-depth="0.1" class=" feature-four"><img src="assets/frontend/images/feature/10.png" class="img-fluid" alt="images"></div>
                  <div data-depth="0.1" class=" feature-five"><img src="assets/frontend/images/feature/11.png" class="img-fluid" alt="images"></div>
                </div>
                <img src="assets/frontend/images/feature/08.png" class="img-fluid" alt="images">
              </div>
              <div class="col-lg-6 align-self-center iq-rmt-50">
                <h6 class="title mb-0">Paket</h6>
                <h2 class="mb-3"><?=$this->m_admin->getByID("md_profil","id_profil",7)->row()->profil;?></h2>
                <p class="mb-5"><?=$this->m_admin->getByID("md_profil","id_profil",7)->row()->deskripsi;?></p>
                <a href="pesan" class="button">Pesan Sekarang!</a>
              </div>
            </div>
            
            
          </div>
        </section>
        <!-- Finance End -->
        
        <!-- Pricing Table-->
        <!--section class="iq-pricing pricing-page">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="iq-pricing-table m-0">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="title-box text-center">
                        <h6 class="title text-white">Paket Layanan</h6>
                        <h2 class="text-white">Pilih Paket Sesuai Kebutuhan Anda</h2>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center no-gutters">
                    <div class="col-sm-12 text-center text-white mb-5"><a href="#" class="clicklink">Click Here</a> for Free Trial Demo</div>
                    <div class="col-md-4 col-lg-3 col-sm-12  wow flipInY iq-rmb-50">
                      <div class="iq-pricing  iq-pricing1">
                        <div class="price-title text-center" >
                          <span class="text-uppercase text-blue iq-font-18 iq-fw-8 ">For First site</span>
                          <h2 class="mb-4">39$</h2>
                          <a class="button" href="# ">Buy Now</a>
                        </div>
                        <ul>
                          <li><i class="fas fa-check-circle"></i>Premium Support</li>
                          <li><i class="fas fa-check-circle"></i>400+ Elements</li>
                          <li><i class="fas fa-check-circle"></i>100+ Free Themes</li>
                          <li><i class="fas fa-check-circle"></i>WooCommerce Option</li>
                          <li><i class="fas fa-check-circle"></i>Popup Builder</li>
                          <li><i class="fas fa-check-circle"></i>Updates for 6 Months</li>
                          <li><i class="fas fa-check-circle"></i>Font Option</li>
                        </ul>
                        
                      </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-sm-12  wow flipInY">
                      <div class="iq-pricing ">
                        <div class="price-title text-center">
                          <span class="text-uppercase text-blue iq-font-18 iq-fw-8 ">Unlimited Sites</span>
                          <h2 class="mb-4">259$</h2>
                          <a class="button" href="# ">Buy Now</a>
                        </div>
                        <ul>
                          <li><i class="fas fa-check-circle"></i>Premium Support</li>
                          <li><i class="fas fa-check-circle"></i>400+ Elements</li>
                          <li><i class="fas fa-check-circle"></i>100+ Free Themes</li>
                          <li><i class="fas fa-check-circle"></i>WooCommerce Option</li>
                          <li><i class="fas fa-check-circle"></i>Popup Builder</li>
                          <li><i class="fas fa-check-circle"></i>Updates for 6 Months</li>
                          <li><i class="fas fa-check-circle"></i>Font Option</li>
                        </ul>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section-->
        <!-- Pricing Table End -->        
        <!-- Blog -->
        <section class="our-blog">
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div class="col-lg-12">
                <div class="title-box">
                  <h6 class="title">Blog Terbaru</h6>                  
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-1">
              </div>
              <div class="col-lg-11 col-md-12">
                <div class="slider variable-width">

                  <?php 
                  $sql = $this->m_admin->getByID("md_artikel","status","publish");
                  foreach($sql->result() AS $data){
                    $user = $this->m_admin->getByID("md_user","id_user",$data->created_by)->row()->nama_lengkap;
                  ?>

                  <div class="grid d-inline-block position-relative  bg-over-black-70">
                    <figure class="effect-chico" width="10px">
                      <img src="assets/art1kel/<?=$data->gambar1?>" style="width: 400px;" class="img-fluid" alt="img"/>
                      <figcaption>
                      <h2 class="font-weight-bold"><?=$data->judul?></h2>                      
                      </figcaption>
                      <div class="blog-comment">
                        <ul class="list-inline">
                          <li class="list-inline-item float-left  font-weight-bold"><a href="detail/<?=$data->permalink?>" class="text-black"><?=$data->tgl_buat?></a></li>
                          <li class="float-right list-inline-item ml-4"><a href="detail/<?=$data->permalink?>" class="text-gray font-weight-bold"><span class="mr-2"><i class="far fa-user"></i></span> <?=$user?> </a></li>
                          <li class="float-right list-inline-item "><a href="detail/<?=$data->permalink?>" class="text-gray font-weight-bold"><span class="mr-2"><i class="far fa-eye"></i></span> <?=$data->baca?> </a></li>
                        </ul>
                      </div>
                    </figure>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Blog End -->
      </div>
      
