

    <div class="row">

      <div class="col-lg-6 col-12">        
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
              <?php               
              $dt = date("Y-m");
              $jum1 = $this->db->query("SELECT SUM(total) AS jum FROM md_pemasukan")->row()->jum;              
              echo "Rp ". mata_uang($jum1);
              ?> 
            </h3>
            <p> Total Pendapatan</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-6 col-12">        
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>
              <?php 
              $dt = date("Y-m");              
              $jum2 = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran")->row()->jum;
              echo "Rp ". mata_uang($jum2);
              ?> 
            </h3>
            <p> Total Pengeluaran</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">        
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
              <?php 
              $dt = date("Y-m-d");
              $jum1 = $this->db->query("SELECT SUM(total) AS jum FROM md_pemasukan WHERE tgl = '$dt'")->row()->jum;              
              echo "Rp ". mata_uang((!is_null($jum1))?$jum1:0);
              ?> 
            </h3>
            <p> Pendapatan Hari Ini</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">        
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
              <?php 
              $dt = date("Y-m");
              $jum1 = $this->db->query("SELECT SUM(total) AS jum FROM md_pemasukan WHERE LEFT(tgl,7) = '$dt'")->row()->jum;              
              echo "Rp ". mata_uang((!is_null($jum1))?$jum1:0);
              ?> 
            </h3>
            <p> Pendapatan Bulan Ini</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">        
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>
              <?php 
              $dt = date("Y-m-d");
              $jum1 = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran WHERE tgl = '$dt'")->row()->jum;              
              echo "Rp ". mata_uang((!is_null($jum1))?$jum1:0);
              ?> 
            </h3>
            <p> Pengeluaran Hari Ini</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">        
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>
              <?php 
              $dt = date("Y-m");
              $jum1 = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran WHERE LEFT(tgl,7) = '$dt'")->row()->jum;              
              echo "Rp ". mata_uang((!is_null($jum1))?$jum1:0);
              ?> 
            </h3>
            <p> Pengeluaran Bulan Ini</p>
          </div>                      
        </div>
      </div>
          
      
                        
    


      <div class="col-md-12 col-lg-12" >
        <div class="card">
          <div class="card-body">
            
            <div id="container"></div>
          </div>
        </div>
      </div>

      <div class="col-md-12 col-lg-12" >
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Grafik Income</h4>
            <div class="grafik_income" style="width:100%; height:400px;"></div>            
          </div>
        </div>
      </div>
      
      </div>
      

    </div>
  
  <base href="<?php echo base_url(); ?>" />
  
  <script src="assets/js_chart/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="assets/js_chart/highcharts.js" type="text/javascript"></script>
  <script src="assets/js_chart/exporting.js" type="text/javascript"></script>
  <script src="assets/js_chart/series-label.js" type="text/javascript"></script>
  <script src="assets/js_chart/export-data.js" type="text/javascript"></script>

  <script type="text/javascript">
  $('.grafik_income').highcharts({
    <?php 
    $tgl_akhir2 = date("Y-m-d");   
    $tgl_awal2 = manipulate_time($tgl_akhir2,"days",30,"-","Y-m-d");  
    $cari_data = $this->db->query("SELECT LEFT(bulan,7) as month, SUM(jum) as grand_total
              FROM (                  
                  SELECT SUM(total) AS jum, tgl AS bulan FROM md_pemasukan GROUP BY LEFT(bulan,7)                                    
              ) as combined_data GROUP BY month");
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
      text: 'Jumlah Income'
    },
    subtitle: {
      text: ""
    },
    xAxis: {
      categories: [
      <?php 
      foreach($cari_data->result() AS $label){
        $tgl_b = str_replace("-", "", $label->month);
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
      "name":"Income",
      "data":[

      <?php 
      foreach($cari_data->result() AS $label){      
        echo "$label->grand_total";
        echo ",";
      }
      ?>

      ]
      }]
  });
  </script>

  <script type="text/javascript">
  function rupiah(bilangan){  
    var reverse = bilangan.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');
    return ribuan;
  }
  $(document).ready(function() {
    var chart1; // globally available
    $(document).ready(function() {
      chart1 = new Highcharts.Chart({
       chart: {
        renderTo: 'container',
        type: 'column'
      },
    title: {
        text: 'Grafik Pendapatan & Pengeluaran'
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
            text: 'Rupiah'
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
        name: 'Pengeluaran',
        data: [        
          <?php
          $data = "";
          for ($i=1; $i <= 12; $i++) {             
            $i = sprintf("%02s", $i);
            $th = date("Y");
            $thb = $th."-".$i;
            $cek = $this->db->query("SELECT SUM(total) AS jum FROM md_pengeluaran WHERE LEFT(tgl,7) = '$thb'");
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
        name: 'Pendapatan',
        data: [
          <?php
          $data = "";
          for ($i=1; $i <= 12; $i++) { 
            if(strlen($i)==1) $i = "0".$i;
            $th = date("Y");
            $thb = $th."-".$i;
            $cek = $this->db->query("SELECT SUM(total) AS jum FROM md_pemasukan WHERE LEFT(tgl,7) = '$thb'");
            if(!is_null($cek->row()->jum)) $jum = $cek->row()->jum;
              else $jum = 20;
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
  </script>
</body>
</html>