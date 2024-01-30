
<link rel="stylesheet" type="text/css" href="assets/css/artikel.css">
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function ambilBulan($b){
  switch ($b) {
    case '01':
      $bulan = "JAN";
      break;
    case '02':
      $bulan = "FEB";
      break;
    case '03':
      $bulan = "MAR";
      break;
    case '04':
      $bulan = "APR";
      break;
    case '05':
      $bulan = "MAY";
      break;
    case '06':
      $bulan = "JUN";
      break;
    case '07':
      $bulan = "JUL";
      break;
    case '08':
      $bulan = "AUG";
      break;
    case '09':
      $bulan = "SEP";
      break;
    case '10':
      $bulan = "OCT";
      break;
    case '11':
      $bulan = "NOV";
      break;
    default:
      $bulan = "DES";
      break;
  }
  return $bulan;
}
?>
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Blog</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">
        
            
      <section class="blog-listing">
        <div class="container">
          <div class="row align-items-start">
            <div class="col-lg-8 m-15px-tb">
              <div class="row">
                <?php           
                foreach($dt_artikel->result() AS $data){            
                ?>
                <div class="col-sm-6">
                  <div class="blog-grid">
                    <div class="blog-img">
                      <div class="date" style="background-color:orange !important;">
                        <span><?=substr($data->tgl_buat, 8,2)?></span>
                        <label><?=ambilBulan(substr($data->tgl_buat, 5,2))?></label>
                      </div>
                      <a href="detail/<?=$data->permalink?>">
                        <img src="assets/art1kel/<?=$data->gambar1?>" title="<?=$data->judul?>" alt="Gambar Artikel">
                      </a>
                    </div>
                    <div class="blog-info">
                      <h5><a href="detail/<?=$data->permalink?>"><?=$data->judul?></a></h5>
                      <p><?=$data->preview?></p>
                      <div class="btn-bar">
                        <a href="detail/<?=$data->permalink?>" class="px-btn-arrow">
                          <span>Selengkapnya</span>
                          <i class="arrow"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <?php } ?>
                

                  <div class="col-12">      
                    <?php echo $pagination; ?>
                  </div>
                
              </div>
            </div>

            <?php include("aside_blog.php") ?>
          </div>
        </div>
      </section>
      
    </div>