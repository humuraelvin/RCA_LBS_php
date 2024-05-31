<!DOCTYPE html>
<html lang="en" class="ab-page-index">

	
<!-- Mirrored from iyzibet1.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Dec 2022 16:45:43 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="google-site-verification" content="Mw0eWlBGTgHv-3sMkDrG1ny1T0KFFbWw1zSJdGsp8kU" />
    <script type="text/javascript" language="javascript" src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/functionsv1.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="/assets/js/datatable.js"></script>
    <script data-turbolinks-track="true" src="/assets/theme15/mainv2.js" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/js/bettingv11.js"></script>
    <script type="text/javascript" src="/assets/js/alert.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js'></script>
    <script src="/assets/css/remodal/remodal.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-sticky.js"></script>
    <script type="text/javascript">$(document).ready(function() {$('#navbar-menu2').scrollToFixed();});</script>
  <link rel="icon" href="favicon.html">
<title><?php echo SITE_NAME;?> | Bahis Oyna, Canlı Bahis Deneyimini Tat!</title>  
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,500i,700&amp;subset=latin-ext" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/style.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/animate.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/intlTelInput.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/slider.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/dataTables.bootstrap.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/responsive.dataTables.min.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/animate.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/custom.css" rel="stylesheet">
  <link href="https://iyzibet2.com/them/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/e48321c271.js" crossorigin="anonymous"></script>
</head>

  <div class="ab-wrapper ab-header ab-header-bg">
    <nav class="navbar navbar-inverse navbar-static-top ab-navbar-top clear-mb hidden-xs">
      <div class="container">
        <div id="ab-navbar-top" class="navbar-collapse collapse">
          <div class="nav navbar-left">
            <span class="navbar-text"><i class="fa fa-clock-o" aria-hidden="true"></i> 7 Ağustos 2017 - 03:05:25</span>
          </div>
          <ul class="nav navbar-nav nav-sss hidden-sm">
            <li><a href="/index.php?module=alt-sss">S.S.S.</a></li>
            <li><a href="/index.php?module=alt-bahiskurallari">BAHİS KURALLARI</a></li>
            <li><a href="/index.php?module=alt-bizeulasin">BİZE ULAŞIN</a></li>
          </ul>
          <div class="navbar-highlight navbar-right">

            <form class="navbar-form pull-left">
              <div class="input-group">
              </div>
            </form>
            <ul class="nav navbar-nav navbar-lang pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="flag"src="img/flags/tr.png" alt="Türkçe"> TR <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><img class="flag"src="img/flags/us.png" alt="English"> English</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    
    

    <div class="logo-wrapper hidden-xs">
      <div class="container">

        <div class="logo-left pull-left">
          <a href="/index.php?module=index"><img src="img/logo.png" class="ab-logo" alt="ArmaniBet"></a>
          <div class="ab-online visible-lg"><i class="fa fa-users" aria-hidden="true"></i> <b>ONLINE</b> OYUNCU: <b>875 KİŞİ</b></div>
        </div>
        
        
        
        
        <div class="pull-right user-actions">
          <?php if($_SESSION['username']) {
            include "them/includes/head/logged.php";
          } else {
            include "them/includes/head/default.php";
          } ?>
        </div>
      </div>
    </div>
    <div class="navbar-wrapper navbar-headroom">
      <div class="container">
        <nav class="navbar navbar-default navbar-static-top ab-navbar-main">

          <div class="container">
            <div class="navbar-header visible-xs">
              <button id="menu-toggle" type="button" class="navbar-toggle toggle-menu">
                <i class="fa fa-bars" aria-hidden="true"></i>
              </button>
              <button id="login-toggle" type="button" class="navbar-toggle toggle-login">
                <i class="fa fa-user-o" aria-hidden="true"></i>
              </button>
              <a class="navbar-brand" href="/index.php?module=index"><img src="img/mobile-logo.png" alt=""></a>
            </div>
            
            <div id="ab-navbar-main" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li class="nav-menu-sports <?=($module=='sports')?' active':'';?>"><a href="/"><i class="menu-icon-sports" aria-hidden="true"></i>Anasayfa</a></li>
                <li class="nav-menu-sports <?=($module=='sports')?' active':'';?>"><a href="/sports"><i class="menu-icon-sports" aria-hidden="true"></i>SPOR BAHİSLERİ</a></li>
                <li class="nav-menu-live <?=($module=='live')?' active':'';?>"><a href="/live"><i class="menu-icon-live animated infinite flash" aria-hidden="true"></i>CANLI</a></li>
                <li class="nav-menu-vivoSlots <?=($module=='vivoSlots')?' active':'';?>"><a href="/LiveCasino/Slot"><i class="menu-icon-casino" aria-hidden="true"></i>CASINO</a></li>
                <li class="nav-menu-LiveCasinoGames <?=($module=='LiveCasinoGames')?' active':'';?>"><a href="/LiveCasino"><i class="menu-icon-canli-casino" aria-hidden="true"></i>CANLI CASINO</a></li>
                <li class="nav-menu-egamingBetOn <?=($module=='egamingBetOn')?' active':'';?>"><a href="/GoldenRace/Keno/100138"><i class="menu-icon-betongames" aria-hidden="true"></i>TV Oyunları</a></li>
                <li class="nav-menu-promotions <?=($module=='promotions')?' active':'';?>"><a href="/home/Promotions"><i class="menu-icon-promosyon" aria-hidden="true"></i><span class="visible-dropdown">PROMOSYONLAR</span></a></li>
              </ul>
            </div>
          </div>
        </nav>


      </div>
    </div>
  </div>
			  <div class="modal modal-dark modal-login fade" id="ab-login" tabindex="-1" role="dialog" aria-labelledby="ab-login">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header padding-30 clear-pb text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
          <img src="img/logo.png" class="img-responsive" alt="ArmaniBet" class="">
        </div>
        <div class="modal-body padding-30">
          <form class="" id="headerGirisForm">
           <div class="form-group form-icon ">
                            <i class="icon-head"></i>
              <input class="clientInput form-control input-lg radiusx" name="username" placeholder="Kullanıcı Adı" type="text" autocomplete="off">
            </div>
                            <div class="form-group form-icon">
                            <i class="icon-key"></i>
              <label for="password">Şifre</label>
              <input type="password" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0 logintextbox" placeholder="Şifre" name="password">
            </div>
            <div class="form-group">
                <button class="btn btn-default loginbutton user-action " data-action="login" data-form="headerGirisForm" style="width: 10%;color:#fff;"> GİRİŞ YAP </button>
              <button class="btn btn-success btn-login btn-bg btn-p-lg pull-right loginbutton user-action" data-action="login" data-form="headerGirisForm" >GİRİŞ YAP</button>
              <a href="index457c.html?module=password-reset" class="btn btn-link btn-p-lg clear-pr clear-pl">Şifremi unuttum!</a>
            </div>
          </form>
        </div>
        <div class="modal-footer padding-30 clear-pt text-center">
          <div class="h5">Üye değil misin?</div>
          <a href="index8c6c.html?module=singin" class="btn btn-white btn-bg btn-p-lg btn-block">HEMEN ÜYE OL</a>
        </div>
      </div>
    </div>
  </div>