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
                <input type="text" class="form-control" placeholder="Takım, Lig, Ülke...">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </span>
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
          <?php if($getUser=='logged') {
            include "includes/head/logged.php";
          } else {
            include "includes/head/default.php";
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
                <li class="nav-menu-sports <?=($module=='sports')?' active':'';?>"><a href="/index.php?module=sports"><i class="menu-icon-sports" aria-hidden="true"></i>SPOR BAHİSLERİ</a></li>
                <li class="nav-menu-live <?=($module=='live')?' active':'';?>"><a href="/index.php?module=live"><i class="menu-icon-live animated infinite flash" aria-hidden="true"></i>CANLI</a></li>
                <li class="nav-menu-virtualGames <?=($module=='virtualGames')?' active':'';?>"><a href="/index.php?module=virtualGames"><i class="menu-icon-sanal" aria-hidden="true"></i>SANAL</a></li>
                <li class="nav-menu-poker <?=($module=='poker')?' active':'';?>"><a href="/index.php?module=poker"><i class="menu-icon-poker" aria-hidden="true"></i>POKER</a></li>
                <li class="nav-menu-vivoSlots <?=($module=='vivoSlots')?' active':'';?>"><a href="/index.php?module=vivoSlots"><i class="menu-icon-casino" aria-hidden="true"></i>CASINO</a></li>
                <li class="nav-menu-LiveCasinoGames <?=($module=='LiveCasinoGames')?' active':'';?>"><a href="/index.php?module=LiveCasinoGames"><i class="menu-icon-canli-casino" aria-hidden="true"></i>CANLI CASINO</a></li>
                <li class="nav-menu-egamingBetOn <?=($module=='egamingBetOn')?' active':'';?>"><a href="/index.php?module=egamingBetOn"><i class="menu-icon-betongames" aria-hidden="true"></i>BETON GAMES</a></li>
                <li class="nav-menu-liveTombala <?=($module=='liveTombala')?' active':'';?>"><a href="/index.php?module=liveTombala"><i class="menu-icon-tombala" aria-hidden="true"></i>CANLI TOMBALA</a></li>
                <li class="nav-menu-promotions <?=($module=='promotions')?' active':'';?>"><a href="/index.php?module=promotions"><i class="menu-icon-promosyon" aria-hidden="true"></i><span class="visible-dropdown">PROMOSYONLAR</span></a></li>
              </ul>
            </div>
          </div>
        </nav>


      </div>
    </div>
  </div>
