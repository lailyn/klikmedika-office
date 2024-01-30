<!DOCTYPE html>
<html lang="en">
<base href="<?php echo base_url(); ?>" />
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>    
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">    
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body background="assets/bg.jpg">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
                  <h2><?php echo $setting->perusahaan ?></h2>
                </div>                
                <form class="pt-3" method="POST" action="m4suk4dm1n/login">
                  <div class="form-group">
                    <input name="username" type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Password">
                  </div>
                  <div class="form-group">                    
                    <span id="captImg"><?php echo $captchaImg; ?> </span>               
                    <input autocomplete="off" name="kode" type="text" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Kode Captcha">                                      
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-gradient-primary btn-sm font-weight-medium auth-form-btn">Sign In</button>                                  
                    <button type="reset" class="btn btn-gradient-danger btn-sm font-weight-medium auth-form-btn">Reset</button>                                  
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>    
  </body>
</html>