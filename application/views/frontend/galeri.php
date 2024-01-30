<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<style type="text/css">
*{
  padding:0;
  margin:0;
}

/*  general */

section{
    padding: 20px 0;
}

.filter-button{
    font-size: 14px;
    border: 2px solid #3F6184;
  padding:5px 10px;
    text-align: center;
    color: #3F6184;
    margin-bottom: 30px;
  background:transparent;
}
.filter-button:hover,
.filter-button:focus,
.filter-button.active{
    color: #ffffff;
    background-color:#3F6184;
  outline:none;
}
.gallery_product{
  margin: 0px;
  padding:5px;
  position:relative;
}
.gallery_product .img-info{
  position: absolute;
  text-align: center;
    background: rgba(0,0,0,0.5);
    left: 0;
    right: 0;
    bottom: 0;
    padding: 5px;
  overflow:hidden;
  color:#fff;
  top:0;
  display:none;
     -webkit-transition: 2s;
    transition: 2s;
}

.gallery_product:hover .img-info{
  display:block;
   -webkit-transition: 2s;
    transition: 2s;
}

/*  end gallery */

</style>
<div class="iq-breadcrumb">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <h2 class="subtitle iq-fw-6 text-white mb-3">Galeri</h2>
         </div>               
      </div>
   </div>
</div>
<div class="main-content">
    
  <section class="iq-products">
    <div class="container">
      <div class="row">

        <div class="col-lg-12">          
          <div align="center">
            <button class="filter-button" data-filter="all">All</button>
            <?php 
            $sql = $this->m_admin->getAll("md_galeri_kategori");
            foreach($sql->result() AS $row){
            ?>
            <button class="filter-button" data-filter="<?php echo $row->id_galeri_kategori ?>"><?php echo $row->kategori; ?></button>
            <?php } ?>
          </div>
        
          <br/>
          <br/>
          <?php 
          $sql = $this->m_admin->getAll("md_galeri");
          foreach($sql->result() AS $isi){
          ?>
          <div class="gallery_product col-sm-2 col-xs-6 filter <?php echo $isi->id_galeri_kategori ?>">
              <a class="fancybox" rel="ligthbox" href="assets/art1kel/<?php echo $isi->gambar ?>">
                  <img class="img-responsive" alt="" src="assets/art1kel/<?php echo $isi->gambar ?>"/>
                  <div class='img-info'>                      
                      <p><?php echo $isi->judul ?></p>
                  </div>
              </a>
          </div>
          <?php } ?>

        </div>
      



  
      </div>
    </div>
  </section>
  
</div>

<script type="text/javascript">
 /* gallery */
$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            $('.filter').show('1000');
        }
        else
        {
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }

            if ($(".filter-button").removeClass("active")) {
      $(this).removeClass("active");
        }
          $(this).addClass("active");
        });
});
/*  end gallery */

$(document).ready(function(){
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
});
   
  
  </script>