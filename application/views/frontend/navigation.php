<style type="text/css">
  a{
    font-size: 14px !important;    
  }
</style>
<header id="header" class="home bg-white">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-10">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="home">
            <img style="width:70px;" class="logo" src="assets/im493/<?php echo $setting->logo ?>" alt="image">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left: 20px;">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link <?=($set=="home")?'active':'';?>" href="home" >Beranda</a>
              </li>
              <li class="nav-item">
                <a style="width: 140px;" class="nav-link <?=($set=="paket-penyewaan")?'active':'';?>" href="paket-penyewaan" >Paket Penyewaan</a>
              </li>
              <li class="nav-item">
                <a style="width: 130px;" class="nav-link <?=($set=="cara-pemesanan")?'active':'';?>" href="cara-pemesanan" >Cara Pemesanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?=($set=="galeri")?'active':'';?>" href="galeri" >Galeri</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?=($set=="blog")?'active':'';?>" href="blog" >Blog</a>
              </li>              
              <li class="nav-item">
                <a class="nav-link <?=($set=="profil")?'active':'';?>" href="profil" >Profil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?=($set=="kontak")?'active':'';?>" href="kontak" >Kontak</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="col-lg-2 text-right p-0">
        <ul class="login">          
          <li class="d-inline "><a href="customer" class="login-btn">
            <?php
            $name = $this->session->userdata('nama');
            if($name==""){              
              echo "Login";            
            }else{
              echo "Customer";
            }
            ?>
          </a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
