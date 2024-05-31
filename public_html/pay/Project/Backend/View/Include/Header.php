<!DOCTYPE html>
<html dir="ltr" lang="tr" class="no-outlines">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- ==== Document Title ==== -->
  <title>Dashboard - <?=Helper\Database\DBGetID::config("brandName");?></title>

  <!-- ==== Document Meta ==== -->
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- ==== Favicon ==== -->
  <link rel="icon" href="<?=PATH_DASHBOARD_ASSET;?>/img/favicon.png" type="image/png">

  <!-- ==== Google Font ==== -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CMontserrat:400,500">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/jquery-ui.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/perfect-scrollbar.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/morris.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/select2.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/jquery-jvectormap.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/horizontal-timeline.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/weather-icons.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/dropzone.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/ion.rangeSlider.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/ion.rangeSlider.skinFlat.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/datatables.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/fullcalendar.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/style.css">

  <!-- Page Level Stylesheets -->
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/summernote-bs4.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/summernote-bs4-overrides.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/update.css?v=<?=rand(10000,99999);?>">

  <!-- Sweetalert -->
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/sweetalert.min.css">
  <link rel="stylesheet" href="<?=PATH_DASHBOARD_ASSET;?>/css/sweetalert-overrides.css">

  <!-- iziToast -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>

  <!-- Wrapper Start -->
  <div class="wrapper">

    <?php if(Helper\Login::dashboard()) { ?>

    <!-- Navbar Start -->
    <header class="navbar navbar-fixed">
      <!-- Navbar Header Start -->
      <div class="navbar--header">
        <!-- Logo Start -->
        <a href="<?=PATH_DASHBOARD;?>" class="logo">
          <img src="<?=PATH_DASHBOARD_ASSET;?>/img/logo.png" alt="">
        </a>
        <!-- Logo End -->
        <!-- Sidebar Toggle Button Start -->
        <a href="#" class="navbar--btn" data-toggle="sidebar" title="Toggle Sidebar">
          <i class="fa fa-bars"></i>
        </a>
        <!-- Sidebar Toggle Button End -->
      </div>
      <!-- Navbar Header End -->


      <!-- Sidebar Toggle Button Start -->
      <a href="#" class="navbar--btn" data-toggle="sidebar" title="Sidebar">
        <i class="fa fa-bars"></i>
      </a>
      <!-- Sidebar Toggle Button End -->

      <!-- Navbar Search Start -->
      <div class="navbar--search">
        <form action="search-results.html">
          <input type="search" name="search" class="form-control" placeholder="Birşeyler ara..." required>
          <button class="btn-link"><i class="fa fa-search"></i></button>
        </form>
      </div>
      <!-- Navbar Search End -->

      <div class="navbar--nav ml-auto mr-2">
        <ul class="nav">
          <li class="nav-item">
            <a target="_blank" href="<?php echo PATH;?>" class="nav-link">
              <i class="fa fa-eye"></i>
            </a>
          </li>
          <!-- Nav User Start -->
          <li class="nav-item dropdown nav--user online">
            <a href="#" class="nav-link" data-toggle="dropdown">
              <img src="<?=PATH_UPLOAD;?>/DashboardProfile/<?=Helper\Database\DBGetID::administrator("photo") ? Helper\Database\DBGetID::administrator("photo") : "admin.png";?>" alt="" class="rounded-circle">
              <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?=PATH_DASHBOARD;?>/profile/edit"><i class="far fa-user"></i>Profilim</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="<?=PATH_DASHBOARD;?>/logout"><i class="fa fa-power-off"></i>Çıkış Yap</a></li>
            </ul>
          </li>
          <!-- Nav User End -->
        </ul>
      </div>
    </header>
    <!-- Navbar End -->

    <!-- Sidebar Start -->
    <aside class="sidebar" data-trigger="scrollbar">

      <!-- Sidebar Navigation Start -->
      <div class="sidebar--nav">

        <ul>
          <li>
            <a href="#">GENEL KONTROL</a>
            <ul>
              <?php echo Helper\DashboardMenu::get("2");?>
            </ul>
          </li>
          <li>
            <a href="#">SETTINGS</a>
            <ul>
              <?php echo Helper\DashboardMenu::get("3");?>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Sidebar Navigation End -->

    </aside>

    <!-- Main Container Start -->
    <main class="main--container">

    <?php } ?>
