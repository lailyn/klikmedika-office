<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/backend/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/backend/dist/css/adminlte.min.css">  
</head>
<body class="hold-transition login-page" background="assets/backend/dist/img/photo2.png">
<div class="login-box">
  <?php
  if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>                    
  <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
      <strong><?php echo $_SESSION['pesan'] ?></strong>
      <button class="close" data-dismiss="alert">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>  
      </button>
  </div>
  <?php } $_SESSION['pesan'] = ''; ?>
  <!-- /.login-logo -->
  <div class="card card-outline card-danger">    
    <div class="card-header text-center">
      <a href="m4suk4dm1n" class="h1">
        <?php $st = $this->m_admin->getByID("md_setting","id_setting",1)->row(); ?>
        <b></b> <?php echo $st->perusahaan ?>
      </a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="m4suk4dm1n/login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" required class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>        
        <div class="form-group">                    
          <span id="captImg"><?php echo $captchaImg; ?> </span>               
          <input autocomplete="off" name="kode" type="text" class="form-control" id="exampleInputPassword1" placeholder="Kode Captcha">                                      
        </div>
        <div class="row">
          <div class="col-8">            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/backend/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/backend/dist/js/adminlte.min.js"></script>
</body>
</html>
