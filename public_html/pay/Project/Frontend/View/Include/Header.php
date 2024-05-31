<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

    <?=Config\Meta::title();?>
    <?=Config\Meta::description();?>

    <link href="<?php echo PATH_ASSET;?>/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PATH_ASSET;?>/css/style.css?v=<?=rand(10000,99999);?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://kit.fontawesome.com/4f08f02980.js" crossorigin="anonymous"></script>

  </head>

  <body class="page-main" style="overflow: visible;">

    <app-root ng-version="8.2.14">
      <router-outlet>
        <preloader></preloader>
      </router-outlet>
      <app-out-component>

        <!-- header-->
        <app-header>


          <app-static-inner-content contentcode="m_header_announcement">
            <div extroutelink=""></div>
            <div></div>
            <div></div>
          </app-static-inner-content>


          <header class="navbar-fixed">
            <nav>
              <div class="nav-wrapper">
                <a class="logo logo-out" href="<?=PATH;?>" style="float:left; margin-top:3px">
                  <img alt="" class="lg" src="<?=PATH_ASSET;?>/img/logo.png?v=1">
                </a>

                <div class="logout-menu right">
                  <ul class="clear">
                    <!--
                    <li>
                      <a class="login-btn" href="login">asd  </a>
                    </li>
                    -->
                    <li>
                      <a href="register" class="register-btn">
                        Hoşgeldin, <?php echo Helper\Database\DBGetID::userIdE($_GET['id'], 'name');?>
                      </a>
                    </li>
                  </ul>
                </div>

              </div>
            </nav>
          </header>
          <div class="modal modal-md" id="BalanceModal" materialize="modal" style="z-index: 1005;"></div>
        </app-header>

        <div id="allCnt">

          <!-- alt menu-->
          <app-bottom-menu class="hidden-lg hidden-md">
            <div class="bottom-fixed-controls">
              <div class="bottom-fixed-wrapper flex-container">
                <a class="flex-item truncate" routerlinkactive="active" href="https://atabet.bet">
                  <i class="icon cherry foot-icon"></i>
                  <span class="text"> Casino </span>
                </a>
                <a class="flex-item truncate" routerlinkactive="active" href="https://atabet.bet">
                  <i class="icon cards-fill foot-icon"></i>
                  <span class="text"> Canlı Casino </span>
                </a>
                <a class="button-collapse right-sidebar coupon" href="https://atabet.bet"  id="bslpb">
                  <i aria-hidden="true" class="fa fa-plus"></i>
                  <span class="count-wrapper"></span>
                </a>
                <a class="flex-item truncate" href="livesports" routerlinkactive="https://atabet.bet">
                  <i class="material-icons foot-icon">ondemand_video</i>
                  <span class="text"> Canlı Bahis </span>
                </a>
                <a class="flex-item truncate" target="_blank" href="https://bit.ly/3TAG3i0">
                  <i class="material-icons foot-icon">mode_comment</i>
                  <span class="text"> Destek </span>
                </a>
              </div>
            </div>
            <div class="modal modal-md" id="BalanceModal" materialize="modal" style="z-index: 1009;"></div>
          </app-bottom-menu>
