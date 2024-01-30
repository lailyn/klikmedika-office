

      <div class="col-lg-4 m-15px-tb blog-aside">                    
        <div class="widget widget-post">
          <div class="widget-title">
            <h3>Kategori</h3>
          </div>
          <div class="widget-body">
            <ul>
            <?php 
            $kategori = $this->db->select("DISTINCT(a.id_artikel_kategori), count(a.id_artikel_kategori) AS jum, k.kategori, k.permalink as perma")
                  ->from("md_artikel_kategori k")
                  ->join("md_artikel a","k.id_artikel_kategori=a.id_artikel_kategori")
                  ->group_by("a.id_artikel_kategori")->get();                  
            foreach($kategori->result() AS $data){
              echo "<li>
                  <a href='cari/$data->perma'>$data->kategori ($data->jum) </a>
                </li>";
            }
            ?>
            </ul>
          </div>
        </div>
        
        <div class="widget widget-latest-post">
          <div class="widget-title">
            <h3>Artikel Terbaru</h3>
          </div>
          <div class="widget-body">
            <?php 
            $artikel = $this->db->select("a.*, k.kategori, u.nama_lengkap")
                  ->from("md_artikel_kategori k")
                  ->join("md_artikel a","k.id_artikel_kategori=a.id_artikel_kategori")
                  ->join("md_user u","a.created_by=u.id_user")
                  ->order_by("a.id_artikel","DESC")->limit(10)->get();                  
            foreach($artikel->result() AS $data){
            ?>
            <div class="latest-post-aside media">
              <div class="lpa-left media-body">
                <div class="lpa-title">
                  <h5><a href="pages/detail/<?=$data->permalink?>"><?=$data->judul?></a></h5>
                </div>
                <div class="lpa-meta">
                  <a class="name" href="#">
                      <?=$data->nama_lengkap?>
                  </a>
                  <a class="date" href="#">
                      <?=$data->tgl_buat?>
                  </a>
                </div>
              </div>
              <div class="lpa-right">
                <a href="pages/detail/<?=$data->permalink?>">
                  <img src="assets/art1kel/<?=$data->gambar1?>" title="<?=$data->judul?>" alt="Gambar Artikel">
                </a>
              </div>
            </div>
            <?php } ?>                            
          
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>