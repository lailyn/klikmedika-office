<!doctype html>
<base href="<?php echo base_url(); ?>" />
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row();?>
    <title><?php echo $setting->perusahaan ?></title>    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/im493/<?php echo $setting->fav ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/frontend/css/bootstrap.min.css">
    <!-- REVOLUTION STYLE SHEETS -->
    <link rel="stylesheet" type="text/css" href="assets/frontend/revslider/css/settings.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="assets/frontend/css/typography.css">
    <!-- Style -->
    <link rel="stylesheet" href="assets/frontend/css/style.css">
    <!-- Responsive -->
    <link rel="stylesheet" href="assets/frontend/css/responsive.css">    


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Javascripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
            
    <link rel="stylesheet" href="assets/calendar/jquery.bootstrap.year.calendar.css">
    <script src="assets/calendar/jquery.bootstrap.year.calendar.js"></script>

    <style type="text/css">
    .iq-breadcrumb{      
      background: url("assets/im493/<?=$setting->banner?>") no-repeat 0 0 !important;
    }
    </style>
  </head>
  <body class="index">
    <!-- loading -->
    <div id="loading">
      <div id="loading-center">
        <div class="loader">
          <img style="margin-left:-100px;" src="assets/im493/<?php echo $setting->logo ?>">
        </div>
      </div>
    </div>    