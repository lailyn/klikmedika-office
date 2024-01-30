  <style>
  .fixed-wa {
    position: fixed;
    bottom: 80px;
    right: 48px;
    width: 30px;
    z-index: 999;
  }
  </style>
      <footer  class="iq-footer gray-bg ">
        <div class="container">
        <div class="row mb-5">
          <div class="col-lg-4 col-md-6 iq-rmb-50">
            <div class="footer-logo">
              <div class="logo">
                <img style="width:90px;" src="assets/im493/<?php echo $setting->fav ?>" class="img-fluid" alt="logo">           
              </div>
              <h3><?=$setting->perusahaan?></h3>
              <p><?=$setting->alamat?></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
             <h4 class="mb-3">Pages</h4>
             <ul class="list">
               <li><a href="paket-penyewaan">Paket Penyewaan</a></li>
               <li><a href="cara-pemesanan">Cara Pemesanan</a></li>
               <li><a href="galeri">Galeri</a></li>
               <li><a href="blog">Blog</a></li>
               <li><a href="faq">FAQ</a></li>
             </ul>
          </div>          
          <div class="col-lg-2 col-md-6 iq-rmt-50">
             <h4 class="mb-3">Kontak Kami</h4>
              <ul class="list">
              <li><?=$setting->email?></li>
              <li><?=$setting->no_hp?></li>              
            </ul>
            <ul class="social-icon mt-3">
              <?php if($setting->facebook!=""){ ?>
                <li><a href="<?=$setting->facebook?>"><i class="fab fa-facebook-f"></i></a></li>
              <?php } ?>
              <?php if($setting->youtube!=""){ ?>
                <li><a href="<?=$setting->youtube?>"><i class="fab fa-youtube"></i></a></li>
              <?php } ?>
              <?php if($setting->instagram!=""){ ?>
                <li><a href="<?=$setting->instagram?>"><i class="fab fa-instagram"></i></a></li>
              <?php } ?>              
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright dark-gray-bg  text-center">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <a href="home">Copyright 2022 <?=$setting->perusahaan?> All Rights Reserved.</a>
            </div>
          </div>
        </div>
      </div>
      <a target="_blank" href="https://api.whatsapp.com/send?phone=+62<?php echo $setting->no_hp ?>&text=Halo, saya ingin tahu lebih lanjut" class="fixed-wa">
        <img width="50px" src="assets/whatsapp-logo_baru.png">
      </a>
        <!-- back-to-top -->
        <div id="back-to-top">
          <a class="top" id="top" href="#top"> <i class="ion-ios-upload-outline"></i> </a>
        </div>
        <!-- back-to-top End -->
      </footer>
      <!-- Footer End -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="assets/frontend/js/jquery-3.3.1.min.js" ></script>
      <!-- popper  -->
      <script src="assets/frontend/js/popper.min.js"></script>
      <!--  bootstrap -->
      <script src="assets/frontend/js/bootstrap.min.js" ></script>
      <!-- Modernizr JavaScript -->
      <script src="assets/frontend/js/modernizr.js"></script>
      <!-- Appear JavaScript -->
      <script src="assets/frontend/js/appear.min.js"></script>
      <!-- Wow -->
      <script src="assets/frontend/js/wow.min.js"></script>
      <!-- waypoints JavaScript -->
     <!--  <script src="assets/frontend/js/waypoints.min.js"></script> -->
      <!-- Owl Carousel JavaScript -->
      <script src="assets/frontend/js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="assets/frontend/js/jquery.magnific-popup.min.js"></script>
      <!-- Parallax JavaScript -->
      <script src="assets/frontend/js/parallax.min.js"></script>
      
      <!-- slick  -->
      <script src="assets/frontend/js/slick.min.js"></script>
     <!-- REVOLUTION JS FILES -->
    <script  src="assets/frontend/revslider/js/jquery.themepunch.tools.min.js"></script>
    <script  src="assets/frontend/revslider/js/jquery.themepunch.revolution.min.js"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.actions.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.carousel.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.migration.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.navigation.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.parallax.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script  src="assets/frontend/revslider/js/extensions/revolution.extension.video.min.js"></script>
      <!-- Retina JavaScript -->
      <!-- <script src="assets/frontend/js/retina.min.js"></script> -->
      <!-- Custom JavaScript -->
      <script src="assets/frontend/js/custom.js"></script>
      
      <script >
         var tpj=jQuery;
      
      var revapi9;
      tpj(document).ready(function() {
        if(tpj("#rev_slider_9_1").revolution == undefined){
          revslider_showDoubleJqueryError("#rev_slider_9_1");
        }else{
          revapi9 = tpj("#rev_slider_9_1").show().revolution({
            sliderType:"standard",
jsFileLocation:"//localhost/revslider-standalone/revslider-standalone/revslider/public/assets/js/",
            sliderLayout:"fullwidth",
            dottedOverlay:"none",
            delay:9000,
            navigation: {
              onHoverStop:"off",
            },
            visibilityLevels:[1240,1024,778,480],
            gridwidth:1170,
            gridheight:790,
            lazyType:"none",
            parallax: {
              type:"mouse",
              origo:"enterpoint",
              speed:400,
              levels:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,55],
              type:"mouse",
            },
            shadow:0,
            spinner:"spinner0",
            stopLoop:"off",
            stopAfterLoops:-1,
            stopAtSlide:-1,
            shuffle:"off",
            autoHeight:"off",
            disableProgressBar:"on",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            debugMode:false,
            fallbacks: {
              simplifyAll:"off",
              nextSlideOnWindowFocus:"off",
              disableFocusListener:false,
            }
          });
        }
      }); /*ready*/
    </script>
    </body>
  </html>