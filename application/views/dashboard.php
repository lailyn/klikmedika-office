
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

<body onload="jenisClient()">


    <div class="row">

      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">            
            <a class="text-white" href="transaksi/presensi">
              <h3>Presensi</h3>
              <p>Klik untuk Isi Kehadiran</p>
            </a>
          </div>                      
        </div>
      </div>
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo $this->m_admin->getAll("md_client")->num_rows() ?></h3>
            <p> Clients</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo $this->m_admin->getAll("md_dokumen")->num_rows() ?></h3>
            <p> Dokumen</p>
          </div>                      
        </div>
      </div>

            
    </div>  
    

    

      
         

    <?php if($this->session->id_user_type==1){ ?>

    <div class="row">
      <div class="col-md-12 col-lg-6 grid-margin" >
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Presentase Jenis Client </h4>
            <div id="jenisClient"></div>
          </div>
        </div>
      </div>

      <div class="col-md-12 col-lg-6 grid-margin" >
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Perkembangan Digital Marketing</h4>
            <div class="grafik3" style="width:100%; height:400px;"></div>          
          </div>
        </div>      
      </div>
    </div>

    <div class="col-md-12 col-lg-12 grid-margin" >
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Perbandingan Prospek Client</h4>
          <div id="grafik_banding"></div>          
        </div>
      </div>      
    </div>

    <div class="col-md-12 col-lg-12 grid-margin" >
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Perkembangan Prospek</h4>
          <div class="grafik" style="width:100%; height:400px;"></div>          
        </div>
      </div>      
    </div>

    <div class="col-md-12 col-lg-12 grid-margin" >
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Perkembangan Client</h4>
          <div class="grafik2" style="width:100%; height:400px;"></div>          
        </div>
      </div>      
    </div>

    <?php } ?>

  </div>  
  <base href="<?php echo base_url(); ?>" />
  
  <script src="assets/js_chart/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="assets/js_chart/highcharts.js" type="text/javascript"></script>
  <script src="assets/js_chart/exporting.js" type="text/javascript"></script>
  <script src="assets/js_chart/series-label.js" type="text/javascript"></script>
  <script src="assets/js_chart/export-data.js" type="text/javascript"></script>

  <script src="https://unpkg.com/rc-year-calendar@latest/dist/rc-year-calendar.umd.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'grafik_banding',
        type: 'column'
      },
    title: {
        text: 'Grafik Prospek Client'
    },    
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Client'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>Rp. {point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [

    {
        name: 'Prospek',
        data: [        
          <?php
          $data = "";
          for ($i=1; $i <= 12; $i++) {             
            $i = sprintf("%02s", $i);
            $th = date("Y");
            $thb = $th."-".$i;
            $cek = $this->db->query("SELECT COUNT(id) AS jum FROM md_prospek WHERE LEFT(tgl_daftar,7) = '$thb'");
            if(!is_null($cek->row()->jum)) $jum = $cek->row()->jum;
              else $jum = 0;
            if($data=="") $data = $jum;
              else $data .= ",".$jum;                        
          }           
          echo $data;
          ?>
        ]
        // data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }, {
        name: 'Client',
        data: [
          <?php
          $data = "";
          for ($i=1; $i <= 12; $i++) { 
            if(strlen($i)==1) $i = "0".$i;
            $th = date("Y");
            $thb = $th."-".$i;
            $cek = $this->db->query("SELECT COUNT(id) AS jum FROM md_client WHERE LEFT(tgl_daftar,7) = '$thb'");
            if(!is_null($cek->row()->jum)) $jum = $cek->row()->jum;
              else $jum = 0;
            if($data=="") $data = $jum;
              else $data .= ",".$jum;                        
          }           
          echo $data;
          ?>

        ]

    }

    ]
    });
  });
});
  $('.grafik').highcharts({
    <?php 
    $tgl_akhir2 = date("Y-m-d");   
    $tgl_awal2 = manipulate_time($tgl_akhir2,"days",60,"-","Y-m-d");  
    $cari_data = $this->db->query("SELECT LEFT(tgl_daftar,7) AS tgl, count(id) AS jum FROM md_prospek WHERE LEFT(tgl_daftar,7)
      BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY LEFT(tgl_daftar,7)
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
      text: 'Jumlah Prospek 2 Bulan Terakhir'
    },
    subtitle: {
      text: ""
    },
    xAxis: {
      categories: [
      <?php 
      foreach($cari_data->result() AS $label){
        $tgl_b = $label->tgl;
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
      "name":"Prospek",
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
    
  $('.grafik3').highcharts({
    <?php 
    $tgl_akhir2 = date("Y-m-d");   
    $tgl_awal2 = manipulate_time($tgl_akhir2,"days",60,"-","Y-m-d");  
    $cari_data = $this->db->query("SELECT LEFT(created_at,10) AS tgl, count(id_sosmed) AS jum FROM md_sosmed WHERE LEFT(created_at,10)
      BETWEEN '$tgl_awal2' AND '$tgl_akhir2' GROUP BY LEFT(created_at,10)
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
      text: 'Jumlah Konten 2 Bulan Terakhir'
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
      "name":"Konten",
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
    
  $('.grafik2').highcharts({
    <?php     
    $cari_data = $this->db->query("SELECT LEFT(tgl_daftar,7) AS tgl, count(id) AS jum FROM md_client GROUP BY LEFT(tgl_daftar,7)
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
      text: 'Jumlah Client'
    },
    subtitle: {
      text: ""
    },
    xAxis: {
      categories: [
      <?php 
      foreach($cari_data->result() AS $label){
        $tgl_b = $label->tgl;
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
      "name":"Faskes",
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
function jenisClient(){
    var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'jenisClient',
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
        $sql = $this->db->query("SELECT jenis,Count(kode_faskes) AS jum FROM md_client WHERE jenis <> '' 
          GROUP BY jenis ORDER BY COUNT(kode_faskes) ASC");
        foreach($sql->result() AS $isi){          
          $tt = $this->db->query("SELECT Count(kode_faskes) AS jum FROM md_client WHERE jenis <> ''")->row();
          $y = ($isi->jum / $tt->jum) * 100;
          $r = round($y,2);
          $status = $isi->jenis;           
          echo "{ y : $r, name: '$status ($isi->jum client)'},";        
        }
        ?>

       ]
    }]
  });
}
</script>
  