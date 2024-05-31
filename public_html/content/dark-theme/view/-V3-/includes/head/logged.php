
          <div class="user-area">
            <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <img class="img-circle" src="img/albert.jpg"></span><span class="name hidden-sm">Albert</span>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="userMenu">
                <li><a href="/index.php?module=myaccount"><i class="nav-icon fa fa-user-o" aria-hidden="true"></i> Hesabım</a></li>
                <li><a href="/index.php?module=mycoupons"><i class="nav-icon fa fa-history" aria-hidden="true"></i> Bahislerim</a></li>
                <li><a href="/index.php?module=mytransfer"><i class="nav-icon fa fa-exchange" aria-hidden="true"></i> Transfer</a></li>
                <li><a href="/index.php?module=deposit"><i class="nav-icon fa fa-plus-square-o" aria-hidden="true"></i> Para Yatır</a></li>
                <li><a href="/index.php?module=withdraw"><i class="nav-icon fa fa-money" aria-hidden="true"></i> Para Çek</a></li>
                <li><a href="/index.php?module=affiliate"><i class="nav-icon fa fa-handshake-o" aria-hidden="true"></i> Affiliate</a></li>
              </ul>
            </div>
          </div>
          <div class="wallet-balance">
            <small><b>Kullanılabilir</b> Bakiye</small>
            <div class="text">26,999.99 <i class="fa fa-try" aria-hidden="true"></i></div>
          </div>
          <div class="btn-group">
            <a href="/index.php?module=deposit" class="btn btn-link btn-deposit"><i class="fa fa-plus hidden-sm" aria-hidden="true"></i> PARA YATIR</a>
            <a href="/index.php?module=<?=$module?>&user=logout" class="btn btn-link btn-logout">ÇIKIŞ</a>
          </div>
            <!--a href="/index.php?module=myaccount" class="btn btn-link"><span><img class="img-circle" src="img/albert.jpg"></span><span class="name hidden-sm">Albert Einstein</span></a-->