

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">            
            <a href="infografis/index" class="btn <?php echo ($menu=='user')?'btn-info':'btn-outline-info'; ?>">User</a>
            <a href="infografis/index/mitra" class="btn <?php echo ($menu=='mitra')?'btn-info':'btn-outline-info'; ?>">Mitra</a>
            <!-- <a href="infografis/index/layanan" class="btn <?php echo ($menu=='layanan')?'btn-info':'btn-outline-info'; ?>">Layanan</a> -->
            <!-- <a href="infografis/index/produk" class="btn <?php echo ($menu=='produk')?'btn-info':'btn-outline-info'; ?>">Produk</a> -->
            <a href="infografis/index/transaksi" class="btn <?php echo ($menu=='transaksi')?'btn-info':'btn-outline-info'; ?>">Transaksi Homecare (Web/Apps)</a>
            <a href="infografis/index/klinik" class="btn <?php echo ($menu=='klinik')?'btn-info':'btn-outline-info'; ?>">Transaksi Klinik</a>
            <a href="infografis/index/engagement" class="btn <?php echo ($menu=='engagement')?'btn-info':'btn-outline-info'; ?>">Engagement</a>
          </div>
        </div>
      </div>

      <?php if($menu=="user"){ ?>
        <body onload="daftarUser();referralDaftar();lineGraf();">

        <div class="col-md-12 col-lg-12">
          <div class="card">
            <div class="card-title">
              <p class="p-4">Tingkat Pertumbuhan User Terdaftar 3 Bulan Terakhir</p>
            </div>
            <div class="card-body">                
              <figure class="highcharts-figure">
                <canvas id="users-chart" height="200"></canvas>
              </figure>              
            </div>
          </div>
        </div>


        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Status User </h4>
              <div id="statusUser"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Sumber Daftar User </h4>
              <div id="daftarUser"></div>
            </div>
          </div>
        </div>        

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Grafik Penggunaan Referral Pendaftaran </h4>
              <div id="referralDaftar"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">User Growth</h4>
              <table id="example5" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Bulan</th>
                    <th>Pendaftaran</th>
                    <th>Growth (%)</th>
                  </tr>                  
                </thead>
                <tbody>
                  <?php 
                  $no=1;$e=0;
                  $sql = $this->db->query("SELECT LEFT(tgl_daftar,7) AS bulan, COUNT(id_user) AS jum FROM md_user 
                    GROUP BY LEFT(tgl_daftar,7) ORDER BY bulan ASC");                  
                  foreach($sql->result() AS $row){
                    $rr="";$gr="0";                                        
                    if($no>1){                      
                      $gr = round(($row->jum-$_SESSION['jum'])/$row->jum * 100,2);
                      if($gr>0){
                        $rr = "<i class='fa fa-chevron-up text-green'></i>";
                      }else{
                        $rr = "<i class='fa fa-chevron-down text-red'></i>";
                      }                      
                    }
                    

                    
                    
                    echo "
                    <tr>
                      <td>$row->bulan</td>
                      <td>$row->jum user</td>
                      <td>$gr% $rr</td>
                    </tr>
                    ";
                    $_SESSION['jum'] = $row->jum;
                    $no++;
                  }
                  ?>                  
                </tbody>
              </table>              
            </div>
          </div>
        </div>
        
      <?php }elseif($menu=="mitra"){ ?>

        <body onload="statusReferral();">

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Dokter dg Order terbanyak 3 Bulan Terakhir </h4>
              <div id="diagram9"></div>
            </div>
          </div>      
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Mitra Perawat dg Order terbanyak 3 Bulan Terakhir </h4>
              <div id="diagram8"></div>
            </div>
          </div>      
        </div>
        
        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Grafik Penggunaan Referral Layanan </h4>
              <div id="grafikReferral"></div>
            </div>
          </div>
        </div>

      <?php }elseif($menu=="layanan"){ ?>

      <?php }elseif($menu=="produk"){ ?>
        <div class="col-md-12 col-lg-6 grid-margin">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">10 Produk Paling Banyak Cari 3 Bulan Terakhir </h4>
              <div id="diagram2"></div>
            </div>
          </div>      
        </div>

      <?php }elseif($menu=="transaksi"){ ?>
        <body onload="statusOrder();sumberOrder();">
        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Order Layanan 3 Bulan Terakhir </h4>
              <div id="diagram1"></div>
            </div>
          </div>      
        </div>

        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Grafik Layanan </h4>
              <div class="grafik" style="width:100%; height:400px;"></div>
            </div>
          </div>
        </div>


        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Status Layanan </h4>
              <div id="container6"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Sumber Order </h4>
              <div id="sumberOrder"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Homecare Traction Growth</h4>
              <table id="example5" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Bulan</th>
                    <th>Order</th>
                    <th>Growth (%)</th>
                  </tr>                  
                </thead>
                <tbody>
                  <?php 
                  $no=1;$e=0;
                  $sql = $this->db->query("SELECT LEFT(tgl_order,7) AS bulan, COUNT(id_order) AS jum FROM md_order 
                    GROUP BY LEFT(tgl_order,7) ORDER BY bulan ASC");                  
                  foreach($sql->result() AS $row){
                    $rr="";$gr="0";                                        
                    if($no>1){                      
                      $gr = round(($row->jum-$_SESSION['jum'])/$row->jum * 100,2);
                      if($gr>0){
                        $rr = "<i class='fa fa-chevron-up text-green'></i>";
                      }else{
                        $rr = "<i class='fa fa-chevron-down text-red'></i>";
                      }                      
                    }
                    

                    
                    
                    echo "
                    <tr>
                      <td>$row->bulan</td>
                      <td>$row->jum order</td>
                      <td>$gr% $rr</td>
                    </tr>
                    ";
                    $_SESSION['jum'] = $row->jum;
                    $no++;
                  }
                  ?>                  
                </tbody>
              </table>              
            </div>
          </div>
        </div>
        

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Status Chat </h4>
              <div id="container7"></div>
            </div>
          </div>
        </div> 
      
      <?php }elseif($menu=="klinik"){ ?>
        <body>
        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Order Layanan 3 Bulan Terakhir </h4>
              <div id="diagram_klinik"></div>
            </div>
          </div>      
        </div>

        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Grafik Layanan </h4>
              <div class="grafik_klinik" style="width:100%; height:400px;"></div>
            </div>
          </div>
        </div>        
       

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Clinic Traction Growth</h4>
              <table id="example6" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>Bulan</th>
                    <th>Order</th>
                    <th>Growth (%)</th>
                  </tr>                  
                </thead>
                <tbody>
                  <?php 
                  $no=1;$e=0;
                  $sql = $this->db->query("SELECT LEFT(waktu_daftar,7) AS bulan, COUNT(id_pendaftaran) AS jum FROM md_pendaftaran 
                    GROUP BY LEFT(waktu_daftar,7) ORDER BY bulan ASC");                  
                  foreach($sql->result() AS $row){
                    $rr="";$gr="0";                                        
                    if($no>1){                      
                      $gr = round(($row->jum-$_SESSION['jum2'])/$row->jum * 100,2);
                      if($gr>0){
                        $rr = "<i class='fa fa-chevron-up text-green'></i>";
                      }else{
                        $rr = "<i class='fa fa-chevron-down text-red'></i>";
                      }                      
                    }
                    

                    
                    
                    echo "
                    <tr>
                      <td>$row->bulan</td>
                      <td>$row->jum order</td>
                      <td>$gr% $rr</td>
                    </tr>
                    ";
                    $_SESSION['jum2'] = $row->jum;
                    $no++;
                  }
                  ?>                  
                </tbody>
              </table>              
            </div>
          </div>
        </div>
        
      <?php }elseif($menu=="engagement"){ ?>
        <body onload="statusBrowser();statusOs();grafikArtikel();">
        <div class="col-md-12 col-lg-12 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Grafik Website Engagement </h4>
              <div class="grafik_web" style="width:100%; height:400px;"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Browser yang Akses Website </h4>
              <div id="grafik_browser"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase OS yang Akses Website </h4>
              <div id="grafik_os"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Presentase Artikel Paling Banyak Dibaca </h4>
              <div id="grafikArtikel"></div>
            </div>
          </div>      
        </div>

        <div class="col-md-12 col-lg-6 grid-margin" >
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Jumlah Artikel Publish </h4>
              <div id="publishArtikel"></div>
            </div>
          </div>      
        </div>

      <?php } ?>
   
      

            

      

           

      
      
    </div>
  </div>  
  <base href="<?php echo base_url(); ?>" />
  
  <script src="assets/js_chart/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="assets/js_chart/highcharts.js" type="text/javascript"></script>
  <script src="assets/js_chart/exporting.js" type="text/javascript"></script>
  <script src="assets/js_chart/series-label.js" type="text/javascript"></script>
  <script src="assets/js_chart/export-data.js" type="text/javascript"></script>

  <script type="text/javascript">
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'publishArtikel',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Publish'
      },
      xAxis: {
        categories: ['Jumlah Artikel']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php          
    $sql   = "SELECT COUNT(md_artikel.id_artikel) AS jum, md_user.nama_lengkap FROM md_artikel      
      INNER JOIN md_user ON md_artikel.created_by = md_user.id_user
      WHERE md_artikel.status = 'publish'
      GROUP BY md_artikel.created_by ORDER BY md_artikel.created_by DESC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {          
      $judul=$r->nama_lengkap;                    
      $jum=$r->jum;            
      ?>
      {
        name: '<?php echo $judul; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'grafikArtikel',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Akses'
      },
      xAxis: {
        categories: ['Judul Artikel']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php          
    $sql   = "SELECT md_artikel.judul, md_artikel.baca AS jum FROM md_artikel      
      WHERE baca > 0 AND status='publish'
      GROUP BY md_artikel.judul ORDER BY jum DESC LIMIT 0,15";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {          
      $judul=substr($r->judul,0,10);                    
      $jum=$r->jum;            
      ?>
      {
        name: '<?php echo $judul; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram1',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Transaksi'
      },
      xAxis: {
        categories: ['Jenis Layanan']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';
      
      $tgl_akhir = date("Y-m-d");   
      $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
      $sql   = "SELECT md_order.kode, COUNT(md_order.no_order) AS jum FROM md_order      
      WHERE LEFT(md_order.tgl_order,7) BETWEEN '$tgl_awal' AND '$tgl_akhir'
      GROUP BY md_order.kode ORDER BY jum ASC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {    
      // $tg=substr($r->tgl,0,5);
      // $tgl = str_replace("-", "/", $tg);
      $kode=$r->kode;                    
      $jum=$r->jum;      
      $cek_layanan = $this->m_admin->get_layanan($kode);      
      $layanan = $cek_layanan['layanan'];
      ?>
      {
        name: '<?php echo $layanan; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram_klinik',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Transaksi'
      },
      xAxis: {
        categories: ['Jenis Layanan']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';
      
      $tgl_akhir = date("Y-m-d");   
      $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
      $sql   = "SELECT md_pendaftaran_layanan.kodeLayanan AS kode, COUNT(md_pendaftaran.id_pendaftaran) AS jum FROM md_pendaftaran
        INNER JOIN md_pendaftaran_layanan ON md_pendaftaran.no_registrasi = md_pendaftaran_layanan.kode
        WHERE LEFT(md_pendaftaran.waktu_daftar,7) BETWEEN '$tgl_awal' AND '$tgl_akhir'
        GROUP BY md_pendaftaran_layanan.kodeLayanan ORDER BY jum ASC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {    
      // $tg=substr($r->tgl,0,5);
      // $tgl = str_replace("-", "/", $tg);
      $kode=$r->kode;                    
      $jum=$r->jum;      
      $cek_layanan = $this->m_admin->getByID("md_layananKlinik","kode",$kode);            
      $layanan = ($cek_layanan->num_rows()>0)?$cek_layanan->row()->layananKlinik:'';
      ?>
      {
        name: '<?php echo $layanan; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });

  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram2',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Transaksi'
      },
      xAxis: {
        categories: ['Produk']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';

    $tgl_akhir = date("Y-m-d");   
    $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
    $sql   = "SELECT md_cart_detail.id_produk, md_cart_detail.nama_produk, SUM(md_cart_detail.qty) AS jum FROM md_cart_detail
      INNER JOIN md_cart ON md_cart.no_faktur = md_cart_detail.no_faktur      
      WHERE LEFT(md_cart.tgl,7) BETWEEN '$tgl_awal' AND '$tgl_akhir'
      GROUP BY md_cart_detail.id_produk ORDER BY jum ASC LIMIT 0,10";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {                
      $jum=$r->jum;            
      $produk = $r->nama_produk;
      ?>
      {
        name: '<?php echo $produk; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });

  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram8',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Order'
      },
      xAxis: {
        categories: ['Mitra']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';

    $tgl_akhir = date("Y-m-d");   
    $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
    $sql   = "SELECT md_karyawan.nama_lengkap, COUNT(md_order.id_order) AS jum FROM md_order
      INNER JOIN md_karyawan ON md_order.id_karyawan = md_karyawan.id_karyawan
      WHERE LEFT(md_order.tgl_order,7) BETWEEN '$tgl_awal' AND '$tgl_akhir'
      GROUP BY md_order.id_karyawan ORDER BY jum ASC";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {                
      $jum=$r->jum;            
      $nama = $r->nama_lengkap;
      ?>
      {
        name: '<?php echo $nama; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  });

  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'diagram9',
        type: 'column'
      },   
      title: {
        text: 'Jumlah Order'
      },
      xAxis: {
        categories: ['Dokter']
      },
      yAxis: {
        title: {
         text: ''
       }
     },
     series:             
     [
     <?php     
     $g = date('Y-m-d');  
     $h = date('Y-m');
     $r = $h.'-01';
    
    $tgl_akhir = date("Y-m-d");   
    $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
    $sql   = "SELECT md_visit.id_dokter, COUNT(md_visit.id_visit) AS jum FROM md_visit
              WHERE LEFT(md_visit.tgl_visit,7) BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY md_visit.id_dokter
              UNION
              SELECT md_chat.id_dokter, COUNT(md_chat.id_chat) AS jum FROM md_chat
              WHERE LEFT(md_chat.tgl_order,7) BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY md_chat.id_dokter
              UNION
              SELECT md_order.id_dokter, COUNT(md_order.id_order) AS jum FROM md_order
              WHERE md_order.id_dokter <> '' AND LEFT(md_order.tgl_order,7) BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY md_order.id_dokter";
    
    $cek = $this->db->query($sql);
    foreach ($cek->result() as $r) {                
      $cek = $this->m_admin->getByID("md_dokter","id_dokter",$r->id_dokter);
      $nama = ($cek->num_rows() >0) ? $cek->row()->nama : "" ;
      $jum=$r->jum;                  
      ?>
      {
        name: '<?php echo $nama; ?>',
        data: [<?php echo $jum; ?>]
      },
    <?php } ?>
    ]
  });
    }); 
  } );
  </script>                    
                        
  <script type="text/javascript">
  $(document).ready(function() {
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'statusUser',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php 
        $sql = $this->db->query("SELECT status,Count(id_user) AS jum FROM md_user GROUP BY status ORDER BY COUNT(id_user) ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT Count(id_user) AS jum FROM md_user")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          if($isi->status==1) $status = 'aktif';
            else $status = "tidak aktif";
          echo "{ y : $r, name: '$status ($isi->jum user)'},";        
        }
        ?>

       ]
    }]
  });
});
function daftarUser(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'daftarUser',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php 
        $sql = $this->db->query("SELECT sumber,Count(id_user) AS jum FROM md_user WHERE sumber <> '' GROUP BY sumber ORDER BY COUNT(id_user) ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT Count(id_user) AS jum FROM md_user")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $sumber = $isi->sumber;            
          if($sumber=='biasa') $sumber = "admin";            
          echo "{ y : $r, name: '$sumber ($isi->jum user)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function statusOrder(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'container6',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT status,Count(no_order) AS jum FROM md_order GROUP BY status ORDER BY COUNT(no_order) ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT Count(no_order) AS jum FROM md_order")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->status;           
          echo "{ y : $r, name: '$status ($isi->jum order)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function sumberOrder(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'sumberOrder',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Sumber',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT sumber,Count(no_order) AS jum FROM md_order WHERE sumber <> '' 
          GROUP BY sumber ORDER BY COUNT(no_order) ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT Count(no_order) AS jum FROM md_order WHERE sumber <> ''")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->sumber;           
          echo "{ y : $r, name: '$status ($isi->jum order)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function statusReferral(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'grafikReferral',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql   = $this->db->query("SELECT md_order.kode_referral, COUNT(md_order.id_order) AS jum FROM md_order          
          WHERE md_order.kode_referral IS NOT NULL AND md_order.kode_referral <> '' AND md_order.status = 'selesai'
          GROUP BY md_order.kode_referral ORDER BY jum ASC");        
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT count(no_order) AS jum FROM md_order")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);

          $status = $this->m_admin->cek_referral($isi->kode_referral)['nama'];          
          echo "{ y : $r, name: '$status ($isi->jum order)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function referralDaftar(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'referralDaftar',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql   = $this->db->query("SELECT md_user.referral_use, COUNT(md_user.id_user) AS jum FROM md_user
          WHERE md_user.referral_use IS NOT NULL AND md_user.referral_use <> ''
          GROUP BY md_user.referral_use ORDER BY jum ASC");        
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT count(id_user) AS jum FROM md_user")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);

          $status = $this->m_admin->cek_referral($isi->referral_use)['nama'];          
          echo "{ y : $r, name: '$status ($isi->jum)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
/* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }
  var mode = 'index'
  var intersect = true
  var $visitorsChart = $('#users-chart')
  // eslint-disable-next-line no-unused-vars

  <?php 
  $tgl_akhir = date("Y-m-d");   
  $tgl_awal = manipulate_time($tgl_akhir,"days",90,"-","Y-m-d");  
  $cari_maks = $this->db->query("SELECT count(id_user) AS jum FROM md_user WHERE LEFT(tgl_daftar,10) 
    BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY LEFT(tgl_daftar,10)
    ORDER BY jum DESC LIMIT 0,1");  
  $maks = ($cari_maks->num_rows() > 0)?$cari_maks->row()->jum:0;
  
  $cari_data = $this->db->query("SELECT LEFT(tgl_daftar,10) AS tgl, count(id_user) AS jum FROM md_user WHERE LEFT(tgl_daftar,10) 
    BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY LEFT(tgl_daftar,10)
    ORDER BY tgl ASC");
  ?>



  var visitorsChart = new Chart($visitorsChart, {
    data: {
      //labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
      labels: [
        <?php 
        foreach($cari_data->result() AS $label){
          $tgl_b = substr($label->tgl, 5, 5);
          echo "'$tgl_b'";
          echo ",";
        }
        ?>
        // '18th', '20th', '22nd', '24th', '26th', '28th', '30th'
        ],
      datasets: [{
        type: 'line',
        //data: [100, 120, 170, 167, 180, 177, 160],
        data: [
        <?php 
        foreach($cari_data->result() AS $label){
          echo "$label->jum";
          echo ",";
        }
        ?>
        ],
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: <?php echo $maks ?>
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})

// lgtm [js/unused-local-variable]

</script>


<script type="text/javascript">
$('.grafik').highcharts({
  <?php 
  $tgl_akhir2 = date("Y-m-d");   
  $tgl_awal2 = manipulate_time($tgl_akhir2,"days",30,"-","Y-m-d");  
  $cari_data = $this->db->query("SELECT LEFT(tgl_order,10) AS tgl, count(id_order) AS jum FROM md_order WHERE LEFT(tgl_order,10) 
    BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY LEFT(tgl_order,10)
    ORDER BY tgl ASC");
  ?>
  chart: {
    type: 'line',
    marginTop: 80
  },
  credits: {
    enabled: false
  }, 
  tooltip: {
    shared: true,
    crosshairs: true,
    headerFormat: '<b>{point.key}</b>< br />'
  },
  title: {
    text: 'Jumlah Transaksi 2 Bulan Terakhir'
  },
  subtitle: {
    text: ""
  },
  xAxis: {
    categories: [
    <?php 
    foreach($cari_data->result() AS $label){
      $tgl_b = substr($label->tgl, 5, 5);
      echo "'$tgl_b'";
      echo ",";
    }
    ?>
    ],
    labels: {
      rotation: 0,
      align: 'right',
      style: {
        fontSize: '10px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  legend: {
    enabled: true
  },
  series: [{
    "name":"Layanan",
    "data":[

    <?php 
    foreach($cari_data->result() AS $label){      
      echo "$label->jum";
      echo ",";
    }
    ?>

    ]
    }]
});
</script>
<script type="text/javascript">
$('.grafik_klinik').highcharts({
  <?php 
  $tgl_akhir2 = date("Y-m-d");   
  $tgl_awal2 = manipulate_time($tgl_akhir2,"days",30,"-","Y-m-d");  
  $cari_data = $this->db->query("SELECT LEFT(waktu_daftar,10) AS tgl, count(id_pendaftaran) AS jum FROM md_pendaftaran WHERE LEFT(waktu_daftar,10) 
    BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY LEFT(waktu_daftar,10)
    ORDER BY tgl ASC");
  ?>
  chart: {
    type: 'line',
    marginTop: 80
  },
  credits: {
    enabled: false
  }, 
  tooltip: {
    shared: true,
    crosshairs: true,
    headerFormat: '<b>{point.key}</b>< br />'
  },
  title: {
    text: 'Jumlah Transaksi 2 Bulan Terakhir'
  },
  subtitle: {
    text: ""
  },
  xAxis: {
    categories: [
    <?php 
    foreach($cari_data->result() AS $label){
      $tgl_b = substr($label->tgl, 5, 5);
      echo "'$tgl_b'";
      echo ",";
    }
    ?>
    ],
    labels: {
      rotation: 0,
      align: 'right',
      style: {
        fontSize: '10px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  legend: {
    enabled: true
  },
  series: [{
    "name":"Layanan",
    "data":[

    <?php 
    foreach($cari_data->result() AS $label){      
      echo "$label->jum";
      echo ",";
    }
    ?>

    ]
    }]
});
</script>

<script type="text/javascript">
$('.grafik_web').highcharts({
  <?php 
  $tgl_akhir2 = date("Y-m-d");   
  $tgl_awal2 = manipulate_time($tgl_akhir,"days",30,"-","Y-m-d");  
  $cari_data = $this->db->query("SELECT date,10 AS tgl, sum(hits) AS jum FROM md_visitor WHERE date
    BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY date
    ORDER BY tgl ASC");
  ?>
  chart: {
    type: 'line',
    marginTop: 80
  },
  credits: {
    enabled: false
  }, 
  tooltip: {
    shared: true,
    crosshairs: true,
    headerFormat: '<b>{point.key}</b>< br />'
  },
  title: {
    text: 'Jumlah Akses User 2 Bulan Terakhir'
  },
  subtitle: {
    text: ""
  },
  xAxis: {
    categories: [
    <?php 
    foreach($cari_data->result() AS $label){
      $tgl_b = substr($label->tgl, 5, 5);
      echo "'$tgl_b'";
      echo ",";
    }
    ?>
    ],
    labels: {
      rotation: 0,
      align: 'right',
      style: {
        fontSize: '10px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  legend: {
    enabled: true
  },
  series: [{
    "name":"Pengguna",
    "data":[

    <?php 
    foreach($cari_data->result() AS $label){      
      echo "$label->jum";
      echo ",";
    }
    ?>

    ]
    }]
});
</script>
<script type="text/javascript">
function statusBrowser(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'grafik_browser',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT browser,sum(hits) AS jum FROM md_visitor GROUP BY browser ORDER BY browser ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT sum(hits) AS jum FROM md_visitor")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->browser;           
          echo "{ y : $r, name: '$status ($isi->jum)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
<script type="text/javascript">
function statusOs(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'grafik_os',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    credits: {
            enabled: false
          },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Status',
        colorByPoint: true,
        data: [

        <?php         
        $sql = $this->db->query("SELECT os,sum(hits) AS jum FROM md_visitor GROUP BY os ORDER BY browser ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT sum(hits) AS jum FROM md_visitor")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->os;           
          echo "{ y : $r, name: '$status ($isi->jum)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
</body>
</html>