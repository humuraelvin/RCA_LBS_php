<?php  include "content/dark-theme/view/dark_header.php"; ?>

    <link rel="stylesheet" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />


<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
    <a class="page-title"><i class="icon-head"></i>AFFILIATE</a>
</div>

<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left">
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">
                <?php  include "content/dark-theme/view/sidebar.php"; ?>
                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 484px; transform: translate(0px, 0px);"></div>
                </div>
            </div>

            <div id="main-center">
                <div class="center-container" style="min-height: 500px;">
                    <div class="panel panel-white no-padding-sm">
                        <div class="panel-heading">
                            <h2>
                                <i class="icon-head"></i>
                                Affiliate
                            </h2>
                        </div>
                        <div class="alert alert-success">
                            Affiliate Adresi => <?php  echo $affiliatelink;  ?>
                        </div>
                        <div class="panel-body panel-control">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <form action="/myaccount/affiliate/users" method="post">
                                        <div class="input-daterange input-group form-group" id="bet-history">
                                            <input type="text" class="form-control" name="from" id="start" value="<?php echo $tarih1  ?>">
                                            <span class="input-group-addon"> ‐ </span>
                                            <input type="text" class="form-control" name="to" id="end" value="<?php echo $tarih2   ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-gray" type="submit"><i class="icon-search"></i></button>
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <div class="tablo-filtre form-group btn-group col-md-8 col-sm-6">
                                        <a class="btn btn-info">
                                            Affiliate Yüzdesi : %<?php  echo $json['percent'];  ?>
                                        </a>
                                        <a class="btn btn-primary">
                                            Toplam Komisyon : <?php  echo $json['totalCommission'];  ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-table table-responsive table-mobile" style="min-height: 100px;">
                            <table class="table table-hover bets-table" id="bet-history-table">
                                <thead>
                                <tr>
                                    <th>Kullanıcı Adı</th>
                                    <th>İsim Soyisim</th>
                                    <th>Bakiye</th>
                                    <th>Yatırım</th>
                                    <th>Çekim</th>
                                    <th>Toplam Bahis</th>
                                    <th>Bekleyen Bahis</th>
                                    <th>Kazanan Bahis</th>
                                    <th>Kaybeden Bahis</th>
                                    <th>İade Bahis</th>
                                    <th>Kar</th>
                                    <th>Bonus</th>
                                    <th>Net Kar</th>
                                    <th>Komisyon</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($json['list']['users'] as $a => $detay){ ?>
                                    <tr>
                                        <td><?php if(isset($detay['username'])) { echo $detay['username'];}?></td>
                                        <td><?php if(isset($detay['name'])) { echo $detay['name'];}?></td>
                                        <td><?php if(isset($detay['balance'])) { echo $detay['balance'];}?></td>
                                        <td><?php if(isset($detay['finance']['deposit'])) { echo $detay['finance']['deposit'];}?></td>
                                        <td><?php if(isset($detay['finance']['withdraw'])) { echo $detay['finance']['withdraw'];}?></td>
                                        <td><?php if(isset($detay['bet']['total'])) { echo $detay['bet']['total'];}?></td>
                                        <td><?php if(isset($detay['bet']['pending'])) { echo $detay['bet']['pending'];}?></td>
                                        <td><?php if(isset($detay['bet']['won'])) { echo $detay['bet']['won'];}?></td>
                                        <td><?php if(isset($detay['bet']['lost'])) { echo $detay['bet']['lost'];}?></td>
                                        <td><?php if(isset($detay['bet']['return'])) { echo $detay['bet']['return'];}?></td>
                                        <td><?php if(isset($detay['bet']['profit'])) { echo $detay['bet']['profit'];}?></td>
                                        <td><?php if(isset($detay['bonus'])) { echo $detay['bonus'];}?></td>
                                        <td><?php if(isset($detay['netprofit'])) { echo $detay['netprofit'];}?></td>
                                        <td><?php if(isset($detay['commission'])) { echo $detay['commission'];}?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php  if ($user != "users") {  ?>
                            <div class="alert alert-warning"><p>Lütfen tarih seçip arama butonuna basınız.</p></div>
                            <?php  }  ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>

<?php  include "content/dark-theme/view/dark_footer.php"; ?>