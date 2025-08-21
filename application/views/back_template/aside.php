  <?php $setting = $this->m_admin->getByID("md_setting", "id_setting", 1)->row(); ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="w3b" class="brand-link">
      <span class="brand-text font-weight-light"><?php echo $setting->perusahaan ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php
        $foto = $this->session->userdata('foto');
        if ($foto == "") {
          $foto = "user.png";
        } else {
          $foto = $foto;
        }
        ?>
        <div class="image">
          <img src="assets/im493/<?php echo $foto ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $this->session->userdata('nama') ?></a>
        </div>
      </div>


      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php
          $act = "";
          $show = "";
          if (setMenu('dashboard') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'dashboard') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="m4suk4dm1n/dashboard" class="nav-link <?php echo ($isi == 'dashboard') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard<span class="right badge badge-danger"></span></p>
            </a>
          </li>
          <?php
          $act = "";
          $show = "";
          if (setMenu('presensi') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'presensi') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="transaksi/presensi" class="nav-link <?php echo ($isi == 'presensi') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-check"></i>
              <p>Presensi<span class="right badge badge-danger"></span></p>
            </a>
          </li>
          <?php
          $act = "";
          $show = "";
          if (setMenu('brand') != '' and setMenu('prospek') != '' and setMenu('bagian') != '' and setMenu('karyawan') != '' and setMenu('client') != '' and setMenu('produk') != '' and setMenu('produk_kategori') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'brand' or $isi == 'prospek' or $isi == 'bagian' or $isi == 'karyawan' or $isi == 'client' or $isi == 'produk' or $isi == 'produk_kategori') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-folder"></i>
              <p>General<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a <?= setMenu('brand') ?> href="master/brand" class="nav-link <?php echo ($isi == 'brand') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brand</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('produk') ?> href="master/produk_kategori" class="nav-link <?php echo ($isi == 'produk_kategori') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('produk') ?> href="master/produk" class="nav-link <?php echo ($isi == 'produk') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('bagian') ?> href="master/bagian" class="nav-link <?php echo ($isi == 'bagian') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bagian</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('karyawan') ?> href="master/karyawan" class="nav-link <?php echo ($isi == 'karyawan') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Karyawan</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('prospek') ?> href="master/prospek" class="nav-link <?php echo ($isi == 'prospek') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prospek</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('client') ?> href="master/client" class="nav-link <?php echo ($isi == 'client') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client</p>
                </a>
              </li>
            </ul>
          </li>
          <?php
          $act = "";
          $show = "";
          if (setMenu('dokumen') != '' and setMenu('dokumen_kategori') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'dokumen' or $isi == 'dokumen_kategori') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-folder"></i>
              <p>Pemberkasan<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a <?= setMenu('dokumen_kategori') ?> href="master/dokumen_kategori" class="nav-link <?php echo ($isi == 'dokumen_kategori') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('dokumen') ?> href="master/dokumen" class="nav-link <?php echo ($isi == 'dokumen') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dokumen</p>
                </a>
              </li>
            </ul>
          </li>
          <?php
          $act = "";
          $show = "";
          if (setMenu('user_type') != '' and setMenu('user') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'user_type' or $isi == 'user') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-folder"></i>
              <p>User<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a <?= setMenu('user') ?> href="master/user" class="nav-link <?php echo ($isi == 'user') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('user') ?> href="master/user_type" class="nav-link <?php echo ($isi == 'user_type') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Type</p>
                </a>
              </li>
            </ul>
          </li>

          <?php
          $act = "";
          $show = "";
          if (setMenu('sosmed') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'sosmed') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-phone"></i>
              <p>Digital Marketing<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a <?= setMenu('sosmed') ?> href="master/sosmed" class="nav-link <?php echo ($isi == 'sosmed') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Social Media</p>
                </a>
              </li>
            </ul>
          </li>

          <?php
          $act = "";
          $show = "";
          if (setMenu('monitoring') != '' and setMenu('grafik') != '' and setMenu('invoice') != '' and setMenu('pengeluaran') != '' and setMenu('pemasukan') != '' and setMenu('penggajian') != '' and setMenu('salary') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'monitoring' or $isi == 'grafik' or $isi == 'invoice' or $isi == 'pengeluaran' or $isi == 'pemasukan' or $isi == "penggajian" or $isi == "salary") {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>Finance<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a <?= setMenu('grafik') ?> href="m4suk4dm1n/grafik" class="nav-link <?php echo ($isi == 'grafik') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Infografis</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('monitoring') ?> href="transaksi/monitoring" class="nav-link <?php echo ($isi == 'monitoring') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monitoring Pembayaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('invoice') ?> href="transaksi/invoice" class="nav-link <?php echo ($isi == 'invoice') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('pengeluaran') ?> href="transaksi/pengeluaran" class="nav-link <?php echo ($isi == 'pengeluaran') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('pemasukan') ?> href="transaksi/pemasukan" class="nav-link <?php echo ($isi == 'pemasukan') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('salary') ?> href="payroll/salary" class="nav-link <?php echo ($isi == 'salary') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Salary</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('penggajian') ?> href="payroll/penggajian" class="nav-link <?php echo ($isi == 'penggajian') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penggajian</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-image"></i>
              <p>
                Dwigital
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= site_url('dwigital/infografis') ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Infografis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Produk
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/produk/platform') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Platform</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/produk/kategori') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kategori</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/produk/produk') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Produk</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Transaksi
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/transaksi/penjualan') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Penjualan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/transaksi/opname') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Stock Opname</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/transaksi/saldo_platform') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Saldo Platform</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Laporan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url('dwigital/laporan/stok') ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Laporan Stok</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>


          <?php
          $act = "";
          $show = "";
          if (setMenu('lap_pengeluaran') != '' and setMenu('lap_pemasukan') != '' and setMenu('lap_pendapatan') != '' and setMenu('lap_konsumen') != '' and setMenu('lap_penyewaan') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'lap_pengeluaran' or $isi == 'lap_pemasukan' or $isi == 'lap_pendapatan' or $isi == 'lap_konsumen' or $isi == 'lap_penyewaan') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a href="#" class="nav-link <?php echo $act ?>">
              <i class="nav-icon fas fa-print"></i>
              <p>Laporan<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <!--li class="nav-item">
                  <a <?= setMenu('lap_konsumen') ?> href="laporan/lap_konsumen" class="nav-link <?php echo ($isi == 'lap_konsumen') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lap Konsumen</p>
                  </a>
                </li>                                        
                <li class="nav-item">
                  <a <?= setMenu('lap_penyewaan') ?> href="laporan/lap_penyewaan" class="nav-link <?php echo ($isi == 'lap_penyewaan') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lap Penyewaan</p>
                  </a>
                </li>                                        
                <li class="nav-item">
                  <a <?= setMenu('lap_pendapatan') ?> href="laporan/lap_pendapatan" class="nav-link <?php echo ($isi == 'lap_pendapatan') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lap Pendapatan</p>
                  </a>
                </li>                                         -->
              <li class="nav-item">
                <a <?= setMenu('lap_pengeluaran') ?> href="laporan/lap_pengeluaran" class="nav-link <?php echo ($isi == 'lap_pengeluaran') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lap Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?= setMenu('lap_pemasukan') ?> href="laporan/lap_pemasukan" class="nav-link <?php echo ($isi == 'lap_pemasukan') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lap Pemasukan</p>
                </a>
              </li>
            </ul>
          </li>

          <!--?php 
            $act="";$show="";
            if(setMenu('slide')!='' AND setMenu('profil')!='' AND setMenu('kerjasama')!='' AND setMenu('promo')!='' AND setMenu('artikel')!='' AND setMenu('dokumen')!='' AND setMenu('galeri')!='' AND setMenu('faq')!='' AND setMenu('pesan')!=''){           
              $show = 'd-none';                        
            }else{            
              if($isi=='slide' OR $isi=='profil' OR $isi=='promo' OR $isi=='kerjasama' OR $isi=='artikel' OR $isi=='dokumen' OR $isi=='galeri' OR $isi=='faq' OR $isi=='pesan'){
                $act = "active"; 
                $show = "menu-open"; 
              }
            }              
            ?>
            
            <li class="nav-item <?php echo $show ?>">
              <a href="#" class="nav-link <?php echo $act ?>">
                <i class="nav-icon fas fa-file"></i>
                <p>Front End<i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a <?= setMenu('slide') ?> href="front/slide" class="nav-link <?php echo ($isi == 'slide') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Slide</p>
                  </a>
                </li>                
                <li class="nav-item">
                  <a <?= setMenu('artikel') ?> href="front/artikel" class="nav-link <?php echo ($isi == 'artikel') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Artikel</p>
                  </a>
                </li>  
                <li class="nav-item">
                  <a <?= setMenu('kerjasama') ?> href="front/kerjasama" class="nav-link <?php echo ($isi == 'kerjasama') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kerjasama</p>
                  </a>
                </li>  
                <li class="nav-item">
                  <a <?= setMenu('dokumen') ?> href="front/dokumen" class="nav-link <?php echo ($isi == 'dokumen') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dokumen</p>
                  </a>
                </li>                                                               
                <li class="nav-item">
                  <a <?= setMenu('galeri') ?> href="front/galeri" class="nav-link <?php echo ($isi == 'galeri') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Galeri</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a <?= setMenu('profil') ?> href="front/profil" class="nav-link <?php echo ($isi == 'profil') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lain-lain</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a <?= setMenu('faq') ?> href="front/faq" class="nav-link <?php echo ($isi == 'faq') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>FAQ</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a <?= setMenu('pesan') ?> href="front/pesan" class="nav-link <?php echo ($isi == 'pesan') ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pesan</p>
                  </a>
                </li>                                                                                                                                            
              </ul>
            </li-->
          <?php
          $act = "";
          $show = "";
          if (setMenu('setting') != '') {
            $show = 'd-none';
          } else {
            if ($isi == 'setting') {
              $act = "active";
              $show = "menu-open";
            }
          }
          ?>
          <li class="nav-item <?php echo $show ?>">
            <a <?= setMenu('setting') ?> href="master/setting" class="nav-link <?php echo ($isi == 'setting') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>Setting<span class="right badge badge-danger"></span></p>
            </a>
          </li>
        </ul>

      </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php echo $bread ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        let currentPath = window.location.pathname.replace(/\/+$/, "");
        document.querySelectorAll('.nav-link').forEach(function(link) {
          if (!link.getAttribute('href') || link.getAttribute('href') === '#') return;
          let linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/+$/, "");
          if (currentPath === linkPath || currentPath.startsWith(linkPath + "/")) {
            link.classList.add('active');
            let parent = link.closest('.nav-item');
            while (parent) {
              parent.classList.add('menu-open');
              let parentLink = parent.querySelector(':scope > .nav-link');
              if (parentLink) {
                parentLink.classList.add('active');
              }
              parent = parent.parentElement.closest('.nav-item');
            }
          }
        });
      });
    </script>
    <section class="content">
      <div class="container-fluid">