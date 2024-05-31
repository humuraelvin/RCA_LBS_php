
        <div class="col-sm-5 col-md-4 col-lg-3 ab-sidebar-account hidden-xs">

          <div class="panel panel-default border-radius">
            <div class="panel-heading clear-border text-center ab-profile-header">
              <div class="div-circle"><img class="img-circle" src="img/albert.jpg"></div>
              <div class="ab-user-name">Albert Einstein</div>
              <div class="ab-user-handle">@username</div>
            </div>

            <ul class="nav nav-pills nav-pills-2x nav-stacked ab-profile-nav">
              <li role="presentation"<?=($module=='myaccount')?' class="active"':'';?>"><a href="/index.php?module=myaccount"><i class="nav-icon fa fa-user-o" aria-hidden="true"></i>HESABIM</a></li>
              <li role="presentation"<?=($module=='deposit')?' class="active"':'';?>><a href="/index.php?module=deposit"><i class="nav-icon fa fa-plus-square-o" aria-hidden="true"></i>PARA YATIR</a></li>
              <li role="presentation"<?=($module=='mycoupons')?'class="active"':'';?>><a href="/index.php?module=mycoupons"><i class="nav-icon fa fa-history" aria-hidden="true"></i>BAHİSLERİM</a></li>
              <li role="presentation"<?=($module=='mytransfer')?'class="active"':'';?>><a href="/index.php?module=mytransfer"><i class="nav-icon fa fa-exchange" aria-hidden="true"></i>TRANSFER</a></li>
              <li role="presentation"<?=($module=='mytransactions')?'class="active"':'';?>><a href="/index.php?module=mytransactions"><i class="nav-icon fa fa-try" aria-hidden="true"></i>HESAP HAREKETLERİ</a></li>
              <li role="presentation"<?=($module=='withdraw')?'class="active"':'';?>><a href="/index.php?module=withdraw"><i class="nav-icon fa fa-money" aria-hidden="true"></i>PARA ÇEK</a></li>
              <li role="presentation"<?=($module=='affiliate')?'class="active"':'';?>><a href="/index.php?module=affiliate"><i class="nav-icon fa fa-handshake-o" aria-hidden="true"></i>AFFILIATE</a></li>
            </ul>
          </div>
        </div>
