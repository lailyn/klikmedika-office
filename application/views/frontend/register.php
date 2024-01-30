
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Register</h2>
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
              <div class="row">
                  <div class="col-lg-6 col-sm-12 mb-4">
                      <h2 class="mt-3">Register</h2>
                      <p class="mt-3 mb-4">
                        Sudah punya kaun? <a href='login' class="btn btn-sm btn-warning"> Login Sekarang </a>
                      </p>                      
                  </div>
                  <div class="col-lg-6 col-sm-12">
                      <div class="iq-login register-box">
                          <form action="registerPost" method="POST">
                              <div class="form-group">
                                  <label for="exampleInputName">Nama Lengkap</label>
                                  <input name="nama" type="text" class="form-control email-bg" id="exampleInputName" placeholder="contoh: Beni Susanto">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputEmail">Email</label>
                                  <input name="email" type="email" class="form-control email-bg" id="exampleInputEmail" placeholder="benisusanto@">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputEmail">No HP</label>
                                  <input name="no_hp" type="number" class="form-control email-bg" id="exampleInputEmail" placeholder="0813xxxxx">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Password</label>
                                  <input name="password" type="password" class="form-control email-bg" id="exampleInputPassword1" placeholder="Password">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Confirm Password</label>
                                  <input name="password2" type="password" class="form-control email-bg" id="exampleInputPassword2" placeholder="Confirm Password">
                              </div>
                              <button type="submit" class="button mb-0">Register</button>
                          </form>
                         
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
    </div>