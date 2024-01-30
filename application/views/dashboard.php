
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

<body>
<?php
function time_ago($timestamp)
    {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);           // value 60 is seconds
        $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks = round($seconds / 604800);          // 7*24*60*60;
        $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return "just_now";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 " . "minute_ago";
            } else {
                return "$minutes " . "minutes_ago";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 " . "hour_ago";
            } else {
                return "$hours " . "hours_ago";
            }
        } else if ($days <= 30) {
            if ($days == 1) {
                return "1 " . "day_ago";
            } else {
                return "$days " . "days_ago";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 " . "month_ago";
            } else {
                return "$months " . "months_ago";
            }
        } else {
            if ($years == 1) {
                return "1 " . "year_ago";
            } else {
                return "$years " . "years_ago";
            }
        }
    }
?>

<style type="text/css">
body{margin-top:0px;}

.team-list img {
  width: 50%;
}

.team-list .content {
  width: 50%;
}

.team-list .content .follow {
  position: absolute;
  bottom: 24px;
}

.team-list:hover {
  -webkit-transform: scale(1.05);
          transform: scale(1.05);
}

.team, .team-list {
  -webkit-transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0s;
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0s;
}

.team .content .title, .team-list .content .title {
  font-size: 18px;
}

.team .overlay {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  opacity: 0;
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
}

.team .member-position, .team .team-social {
  position: absolute;
  bottom: -35px;
  right: 0;
  left: 0;
  margin: auto 10%;
  z-index: 99;
}

.team .team-social {
  bottom: 40px;
  opacity: 0;
  -webkit-transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0s;
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0s;
}

.team:hover {
  -webkit-transform: translateY(-7px);
          transform: translateY(-7px);
  -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
}

.team:hover .overlay {
  opacity: 0.6;
}

.team:hover .team-social {
  opacity: 1;
}


.rounded {
    border-radius: 1px !important;
}

.para-desc {
    max-width: 600px;
}
.text-muted {
    color: #8492a6 !important;
}

.section-title .title {
    letter-spacing: 0.5px;
    font-size: 30px;
}
</style>


    <div class="row">

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3></h3>
            <p>Layanan</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <a href="master/produk" class="text-white">
              <h3></h3>
              <p>Paket</p>
            </a>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3></h3>
            <p> User</p>
          </div>                      
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3></h3>
            <p> Pesanan Baru</p>
          </div>                      
        </div>
      </div>

            
    </div>  
    <div class="row">      
      <div class="col-lg-6 col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Pesanan Terbaru <a href="trans/penjualan" class="btn btn-sm btn-info">lihat semua</a></h4>
            <div class="table-responsive">
              <table id="example3" class="table table-hover table-striped">
                <thead>
                  <tr>                    
                    <th> User </th>
                    <th> Layanan </th>
                    <th> Status </th>                    
                    <th> No Order </th>
                  </tr>
                </thead>
                <tbody>                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>    

      <div class="col-lg-6 col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">User Terbaru <a href="master/product" class="btn btn-sm btn-info">lihat semua</a></h4>
            <div class="table-responsive">
              <table id="example4" class="table table-hover table-striped">
                <thead>
                  <tr>                    
                    <th> Username </th>
                    <th> Email </th>
                    <th> No HP </th>                                        
                  </tr>
                </thead>  
                <tbody>
                
                </tbody>              
              </table>
            </div>
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

  <script src="https://unpkg.com/rc-year-calendar@latest/dist/rc-year-calendar.umd.min.js"></script>

  