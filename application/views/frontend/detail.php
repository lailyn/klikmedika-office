<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
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
$data = $dt_artikel->row();
?>
    
    <div class="iq-breadcrumb">
       <div class="container-fluid">
          <div class="row align-items-center">
             <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <h2 class="subtitle iq-fw-6 text-white mb-3">Cara Pemesanan</h2>
             </div>               
          </div>
       </div>
    </div>
    <div class="main-content">
        
            
      <section class="blog-listing gray-bg">
        <div class="container">
          <div class="row align-items-start">
            <div class="blog-single gray-bg">
              <div class="container">
                <div class="row align-items-start">
                  <div class="col-lg-8 m-15px-tb">
                    <article class="article">
                      <div class="article-img">
                        <img src="assets/art1kel/<?=$data->gambar1?>" title="<?=$data->gambar1?>" alt="Gambar Artikel">
                      </div>
                      <div class="article-title">
                        <h6><a href="#"><?=$data->kategori?></a></h6>
                        <h2><?=$data->judul?></h2>
                        <div class="media">
                          <div class="avatar">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" title="" alt="">
                          </div>
                          <div class="media-body">
                            <label><?=$data->nama_lengkap?></label>
                            <span><?=$data->tgl_buat?></span>
                          </div>
                        </div>
                      </div>
                      <div class="article-content">
                      <p>
                      <?php echo $data->isi ?>
                      </p>
                  </div>                  
              </article>
            </div>

            <?php include("aside_blog.php") ?>
          </div>
        </div>
      </section>
      
    </div>