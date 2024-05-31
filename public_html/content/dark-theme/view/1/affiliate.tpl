{php} include "content/dark-theme/view/dark_header.php";{/php}
{literal}
    <link rel="stylesheet" href="https://uxsolutions.github.io/bootstrap-datepicker/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />
{/literal}

<div class="navbar-title visible-sm visible-xs">
    <button type="button" class="navbar-toggle toggle-left" data-toggle="sidebar" data-target=".sidebar-left"> <i class="icon-menu"></i> </button>
    <a class="page-title"><i class="icon-head"></i>AFFILIATE</a>
</div>

<section id="main" class="" style="">
    <div class="container">
        <div id="main-panel" class="row have-sidebar-left">
            <div id="main-left" class="sidebar sidebar-left sidebar-animate sidebar-md-show nano has-scrollbar">
                {php} include "content/dark-theme/view/sidebar.php";{/php}
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
                            Affiliate Adresi => {php} echo $affiliatelink; {/php}
                        </div>
                        <div class="panel-body panel-control">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <form action="/myaccount/affiliate/users" method="post">
                                        <div class="input-daterange input-group form-group" id="bet-history">
                                            <input type="text" class="form-control" name="from" id="start" value="{php}echo $tarih1 {/php}">
                                            <span class="input-group-addon"> ‐ </span>
                                            <input type="text" class="form-control" name="to" id="end" value="{php}echo $tarih2  {/php}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-gray" type="submit"><i class="icon-search"></i></button>
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <div class="tablo-filtre form-group btn-group col-md-8 col-sm-6">
                                        <a class="btn btn-info">
                                            Affiliate Yüzdesi : %{php} echo $json['percent']; {/php}
                                        </a>
                                        <a class="btn btn-primary">
                                            Toplam Komisyon : {php} echo $json['totalCommission']; {/php}
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
                                {foreach from="$json['list']['users']" item="detay" key="a"}
                                    <tr>
                                        <td>{$detay['username']}</td>
                                        <td>{$detay['name']}</td>
                                        <td>{$detay['balance']}</td>
                                        <td>{$detay['finance']['deposit']}</td>
                                        <td>{$detay['finance']['withdraw']}</td>
                                        <td>{$detay['bet']['total']}</td>
                                        <td>{$detay['bet']['pending']}</td>
                                        <td>{$detay['bet']['won']}</td>
                                        <td>{$detay['bet']['lost']}</td>
                                        <td>{$detay['bet']['return']}</td>
                                        <td>{$detay['bet']['profit']}</td>
                                        <td>{$detay['bonus']}</td>
                                        <td>{$detay['netprofit']}</td>
                                        <td>{$detay['commission']}</td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                            {php} if ($user != "users") { {/php}
                            <div class="alert alert-warning"><p>Lütfen tarih seçip arama butonuna basınız.</p></div>
                            {php} } {/php}
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-overlay"></div>
        </div>
    </div>
</section>

{php} include "content/dark-theme/view/dark_footer.php";{/php}