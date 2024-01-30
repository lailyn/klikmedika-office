
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Login</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">
        
      <section class="iq-login-regi">
          <div class="container">
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
              <div class="row align-items-center">
                  <div class="col-lg-6 col-sm-12 mb-4">
                      <h2 class="mt-3">Login</h2>
                      <p class="mt-3 mb-4">
                        Belum punya akun? <a href='register' class="btn btn-sm btn-warning"> Register Sekarang </a>
                      </p>                      
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="iq-login register-box">
                          <form action="loginPost" method="POST">                              
                              <div class="form-group">
                                  <label for="exampleInputEmail">Email/No HP</label>
                                  <input type="text" name="username" class="form-control email-bg" id="exampleInputEmail" placeholder="Email/No HP">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Password</label>
                                  <input type="password" name="password" class="form-control email-bg" id="exampleInputPassword1" placeholder="Password">
                              </div>                              
                              <button type="submit" class="button mb-0">Login</button>
                          </form>
                         
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
    </div>