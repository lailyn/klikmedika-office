<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
  <title><?php echo $setting->perusahaan ?></title>    

  <!-- Google Font: Source Sans Pro -->
  <link rel="shortcut icon" href="assets/im493/<?php echo $setting->fav ?>" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/backend/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets/backend/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="assets/backend/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/backend/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/backend/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets/backend/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<?php if($isi=='penyewaan'){ ?>
<body class="hold-transition sidebar-mini sidebar-collapse">
<?php }else{ ?>
<body class="hold-transition sidebar-mini layout-fixed">
<?php } ?>

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="assets/im493/<?php echo $setting->logo ?>" alt="Logo" height="100" width="700">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">            
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>      
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-link">
        <a class="btn btn-warning btn-sm" target="_BLANK" href="home">Lihat Halaman Depan</a>
      </li> -->
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">                    
          Hi, <?php echo $this->session->userdata('nama') ?>
          <i class="right fas fa-angle-down"></i>          
        </a>        

        
          
          
        <div class="dropdown-menu dropdown-menu-right">                  
          <a href="master/profil" class="dropdown-item">                      
            Profil            
          </a>
          <div class="dropdown-divider"></div>            
          <a href="m4suk4dm1n/logout" class="dropdown-item">          
            Log Out             
          </a>          
        </div>

        
      </li>      
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php 
  function mata_uang($a){      
    if(is_numeric($a) AND $a != 0 AND $a != ""){
      return number_format($a, 0, ',', '.');
    }else{
      return $a;
    }
  }
  ?>

  