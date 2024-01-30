<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>      

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">      
      <li class="nav-item <?=($set=="riwayat-transaksi")?'active':'';?>">
        <a class="nav-link" href="riwayat-transaksi">Riwayat Transaksi</a>
      </li>      
      <li class="nav-item <?=($set=="customer")?'active':'';?>">
        <a class="nav-link" href="customer">Ubah Profil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-danger text-white" href="customer/logout" onclick="return confirm('Anda yakin?')">Logout</a>
      </li>          
    </ul>        
  </div>
</nav>