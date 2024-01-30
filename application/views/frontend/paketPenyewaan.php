
    
<div class="iq-breadcrumb">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <h2 class="subtitle iq-fw-6 text-white mb-3">Paket Penyewaan</h2>
         </div>               
      </div>
   </div>
</div>
<div class="main-content">
      
  <!-- Blog -->
  <section class="our-blog pt-4">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-8">
          <div class="title-box text-center">            
            <p>Silakan Pilih Layanan yang Kamu Butuhkan, Kami Siap Memprosesnya.</p>            
          </div>
        </div>
      </div>
      <div class="row">        
        <div class="col-lg-11 col-md-12">
          <div style="margin-top:-50px;" class="row justify-content-center">            
            <?php 
            $sql = $this->db->select("p.*,c.kategori,m.merchant")
              ->join("md_kategori c","p.id_kategori=c.id_kategori","left")
              ->join("md_merchant m","m.id_merchant=p.id_merchant","left")
              ->where("p.tipe",1)
              ->order_by("p.id","desc")
              ->get("products p");          
            foreach($sql->result() AS $data){        
              if(!isset($data->picture_name) AND $data->picture_name=="") $gambar = "produk.png";
                else $gambar = $data->picture_name;
              if($data->current_discount!=0) $dis = "<del>Rp ".mata_uang_help($data->current_discount)."</del><br>";
                else $dis = "";  

              $idc = encrypt_url($data->id);                  
            ?>
            <div class="col-lg-4 col-md-6">
              <div class="iq-feature-box">
                <img src='assets/uploads/products/<?=$gambar?>' class='mb-3' width='100%'>
                <h4 class="mb-3"><?=$data->name?></h4>
                <?=$dis?>
                <h5 class="mb-3 text-grey"> Rp <?=mata_uang_help($data->price)?>/<?=$data->satuan?></h5>
                <p><?=$data->description?></p>
                <a href="pesan/<?=$idc?>" class="btn btn-primary btn-lg">Pesan</a>
              </div>
            </div>

            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Blog End -->

  <!-- Pricing Table-->
  <section class="iq-pricing-tab" style="margin-top:-150px;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-8">
          <div class="title-box text-center">
            <h6 class="title ">Paket Bundling</h6>            
            <p class="mb-0">Kami Juga Menyediakan Beberapa Paket yang Bisa anda Pilih Sesuai Kebutuhan.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <div class="pricing-tab">
                                             
            <div class="row justify-content-center">
              <?php 
              $sql = $this->db->select("p.*,c.kategori,m.merchant")
                ->join("md_kategori c","p.id_kategori=c.id_kategori","left")
                ->join("md_merchant m","m.id_merchant=p.id_merchant","left")
                ->where("p.tipe",2)
                ->order_by("p.id","desc")
                ->get("products p");          
              foreach($sql->result() AS $data){        
                if(!isset($data->picture_name) AND $data->picture_name=="") $gambar = "produk.png";
                  else $gambar = $data->picture_name;
                if($data->current_discount!=0) $dis = "<del>Rp ".mata_uang_help($data->current_discount)."</del><br>";
                  else $dis = "";   

                $idc = encrypt_url($data->id);                 
              ?>
              <div class="col-lg-4 col-md-6 col-sm-12 iq-rmb-50">
                <div class="iq-pricing-box">
                  <img src='assets/uploads/products/<?=$gambar?>' width='100%' class="img-fluid mb-3" alt="images">
                  <div class="pricing-title">
                    <h5 class="big-title">Rp<?=mata_uang_help($data->price)?><small><?=$data->satuan?></small></h5>
                    <h6 class="text-uppercase"><?=$data->name?></h6>
                  </div>
                  
                  <p><?=$data->description?></p>
                  
                  <a href="pesan/<?=$idc?>" class="button blue">Pilih Paket</a>
                </div>
              </div>                
              <?php } ?>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Pricing Table End -->
  
</div>