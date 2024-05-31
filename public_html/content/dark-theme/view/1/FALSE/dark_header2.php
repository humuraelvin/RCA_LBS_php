<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title><?php echo SITE_NAME;?> | Bahis Oyna, Canlı Bahis Deneyimini Tat!</title>
    <meta name="description" content="Spor Bahisleri, Canlı Tek Maç Bahisi, Casino, Slot Oyunlar, Avrupa'nın En Yüksek Oranları ile Güvenilir Bahis Sitesi <?php echo SITE_NAME;?>">
    <meta name="keywords" content="Canlı Bahis, bahis , canlı poker, canlı casino , maç sonuçları, bahis yap, canlı bahis oyna, klaspoker, poker, online poker,">
    <meta name="google-site-verification" content="Mw0eWlBGTgHv-3sMkDrG1ny1T0KFFbWw1zSJdGsp8kU" />
    <script type="text/javascript" language="javascript" src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/functionsv1.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <script type="text/javascript" src="/assets/js/datatable.js"></script>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script data-turbolinks-track="true" src="/assets/theme15/mainv2.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/assets/css/css/font-awesome.min.css">
    <script type="text/javascript" src="/assets/js/bettingv11.js"></script>
    <link rel="stylesheet" href="/assets/css/css/alert.css" />
    <script type="text/javascript" src="/assets/js/alert.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js'></script>
    <link data-turbolinks-track="true" href="/assets/theme15/stylev9.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/css/remodal/remodal.css">
    <script src="/assets/css/remodal/remodal.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-sticky.js"></script>
    <script type="text/javascript">$(document).ready(function() {$('#navbar-menu2').scrollToFixed();});</script>
    
</head>

<body class="welcome-theme">
    <nav id="navbar" class="navbar navbar-default ">
    <?php if (empty($_SESSION['username'])) { ?>
            <div class="navbar-menu1">
            <div class="container">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-menu"> <i class="icon-menu"></i> </button>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-acc"> <i class="icon-head"></i> </button>
                    <a class="navbar-brand" href="/"> <img height="50" src="/uploads/logo/logo.png" width="190" /> </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-acc">
                    <form class="navbar-form navbar-right" id="headerGirisForm">
                        <div class="form-group form-icon ">
                            <i class="icon-head"></i>
                            <input class="clientInput form-control input-lg radiusx" name="username" placeholder="Kullanıcı Adı" type="text" autocomplete="off">
                        </div>
                <div class="form-group form-icon">
                            <i class="icon-key"></i>
                            <input class="passwordInput form-control input-lg radiusx" name="password" placeholder="Şifre" type="password" autocomplete="off">
                </div>
                <span class="sep">
                            <button class="btn btn-default loginbutton user-action " data-action="login" data-form="headerGirisForm" style="color:#fff;"> GİRİŞ YAP </button>
                            <a href="/signin" class="btn btn-default loginbutton">KAYIT OL</a>
                        
                        <a href="/resetpassword/forget"><span class="sep" style="padding-right: 20px;" title = "Şifremi Unuttum"><span class="sep mobilehide" style="color:#fff;">ŞİFREMİ UNUTTUM</span><i class="fa fa-question-circle newicon mobile-hide" aria-hidden="true" style="color:#0F843D;font-size: 30px;padding-top: 0px !important;position: absolute;"></i></span></a>
                    </form>
                </div>
            </div>

            <div class="remodal" data-remodal-id="login" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc" style="background: none;">
                <div class="modal-content" style="-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-remodal-action="close" aria-label="Close"></i></button>
                        <h4 class="modal-title" style="font-size: 20px;">GİRİŞ YAP</h4>
                    </div>
                    <div class="modal-body scrollable" >
                        <p style="font-size: 16px;">
                        <form class="" id="headerGirisForm">
                            <input type="text" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0 logintextbox" placeholder="Kullanıcı adı" name="username">
                            <input type="password" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0 logintextbox" placeholder="Şifre" name="password">
                            <button class="btn btn-default loginbutton user-action " data-action="login" data-form="headerGirisForm" style="width: 10%;color:#fff;"> GİRİŞ YAP </button>
                            <a href="/signin" class="btn btn-default loginbutton" style="width: 10%;">KAYIT OL</a>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
    <?php } else { ?>
        <script>
            $( document ).ready(function() {
                $.playgoAJAX._amount();
            });
        </script>
    <div class="navbar-menu1">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-menu"> <i class="icon-menu"></i> </button>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-acc"><i class="icon-head" ></i></button>
                <a class="navbar-brand" href="/"> <img height="50" src="/uploads/logo/logo.png" width="190" /></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse-acc" style="max-height: 924px;">
                <div class="navbar-form navbar-acc navbar-right">
                    <span class="sep pull-right hidden-xs hidden-sm"><a href="/sports/logout" class="btn btn-link btn-lg btn-icon btn-out">ÇIKIŞ<i class="icon-lock"></i></a></span>
                    <span class="sep pull-right">
                        <div class="btn-group popover-check">
                        <button type="button" class="btn btn-link btn-lg btn-icon" data-toggle="dropdown"><a class="username" style="color:#fff;"><?php echo $bilgi['username']; ?> </a><i class="icon-arrow-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="/myaccount"><i class="icon-settings2"></i>Hesabım</a></li>
                            <li><a href="/myaccount/transactions"><i class="icon-stats"></i>Hesap Hareketleri</a></li>
                            <li><a href="/myaccount/coupons"><i class="icon-menu"></i>Bahis Geçmişi</a></li>
                            <li><a href="/myaccount/transfer"><i class="icon-transactions"></i>Transfer</a></li>
                            <li><a href="/myaccount/deposit"><i class="icon-wallet"></i>Para Yatır</a></li>
                            <li><a href="/myaccount/withdraw"><i class="icon-money"></i>Para Çek</a></li>
                            <li class="hidden-md hidden-lg"><a href="/sports/logout"><i class="icon-lock"></i>Çıkış Yap</a></li>
                        </ul>
                        </div>
                    </span>

                    <div class="input-group tongue money">

                        <span class="input-group-addon popover-check">
                            <label id="balance"><span class="balance"><?php echo nf($bilgi['bakiye']); ?> <i class='fa fa-try'></i> </span>  <i class='fa fa-refresh balance-refresh user-action' data-action="balanceUpdate" ></i></label>
                        </span>

                        <span class="input-group-btn"><a href="/myaccount/deposit" type="button" class="btn btn-info btn-lg btn-icon">PARA YATIR<i class="icon-wallet"></i></a></span>
                        <span class="input-group-btn" style="padding-left: 10px !important;"><a href="/myaccount/coupons" type="button" class="btn btn-primary btn-lg btn-icon">BAHİS GEÇMİŞİ<i class="icon-betslip"></i></a></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
      </div>
    </div>
    <?php } ?>

<?php
$pageUrl = $_SERVER['REQUEST_URI'];
if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    $mobile = 1;
} else $mobile = 0;
?>
    <nav id="navbar-menu2">
    <div class="navbar-menu2">
        <div class="container">
            <div class="collapse navbar-collapse propogate" id="navbar-collapse-menu">
                <ul class="nav navbar-nav navbar-collapse navbar-center" style="max-height: 585px;">
                    <li><a class="hvr-sweep-to-bottom " href="/" > ANASAYFA</a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/sports"> SPOR BAHISLERI</a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/live"> CANLI BAHISLER</a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/GoldenRace/Games"> SANAL BAHISLER <span style="align:center;position:absolute;top: -7px;right: 0px;font-size:10px;color: #ffffff;width: 30px;height:14px;background-color: #0F853D;border-radius: 5px;text-align:center;">YENİ</span></a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/LiveCasino/Slot"> CASINO</a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/LiveCasino"> CANLI CASINO</a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/GoldenRace/Keno/100138"> TV OYUNLARI <span style="align:center;position:absolute;top: -7px;right: 0px;font-size:10px;color: #ffffff;width: 30px;height:14px;background-color: #0F853D;border-radius: 5px;text-align:center;">YENİ</span></a></li>
                    <li><a class="hvr-sweep-to-bottom " href="/home/Promotions"> PROMOSYONLAR</a></li>
                </ul>
            </div>
        </div>
    </div>
    </nav>
</nav>