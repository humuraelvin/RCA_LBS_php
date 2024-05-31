<!-- transactions -->
<header class="panel-heading">
    <div class="panel-actions">
        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
    </div>

    <h2 class="panel-title">Affiliate (<?php echo $kullanici['username']; ?>) | Affiliate Yüzdesi => %<?php echo $kullanici['affiliatepercent']; ?></h2>
</header>
<div class="panel-body">
    <div id="transactions" class="tab-pane active">
        <style type="text/css">
            .kullaniciTabHareket {font-weight: bold;}
            .kullaniciTabHareket:hover {
                background-image: -ms-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
                background-image: -moz-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
                background-image: -o-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
                background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(100, #CBA96D));
                background-image: -webkit-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
                background-image: linear-gradient(to bottom, #A68C6A 0%, #CBA96D 100%);
                color: #fff;
                cursor: pointer;
            }
            .row-red {background: red; color: #fff}
            .row-green {background: green; color: #fff}
            table tr {
                background: #F8F8F8;
            }
            table td {font-weight: bold;}
            .table-line {
                width: 100%;
                display: block;
                border: 1px solid #f3f3f3;
                margin: 10px 0 10px 0;
            }
            table tr.durum1 {
                background: #58753B;
                color: #fff;
            }
            table tr.durum2 {
                background: #F64744;
                color: #fff;
            }
            table tr.durum0 {
                background: #54B1F6;
                color: #fff;
            }
        </style>
        <!-- form -->
        <fieldset>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success admin-action" data-action="adminKullaniciTab_Hareketler">Listele</button>
                </div>
            </div>
            <hr class="dotted short">

        </fieldset>
        <!-- #form -->
        <!-- table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">

                <thead>
                <tr class="table_row">
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>İsim</th>
                    <th>Kayıt Tarihi</th>
                    <th>Yatırım</th>
                    <th>Çekim</th>
                    <th>Toplam Bahis</th>
                    <th>Bekleyen Bahis</th>
                    <th>Kazanan Bahis</th>
                    <th>Kaybeden Bahis</th>
                    <th>İade Bahis</th>
                    <th>Kar</th>
                    <th>Bonus</th>
                    <th>Netkar</th>
                    <th>Komisyon</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>İsim</th>
                    <th>Kayıt Tarihi</th>
                    <th>Yatırım</th>
                    <th>Çekim</th>
                    <th>Toplam Bahis</th>
                    <th>Bekleyen Bahis</th>
                    <th>Kazanan Bahis</th>
                    <th>Kaybeden Bahis</th>
                    <th>İade Bahis</th>
                    <th>Kar</th>
                    <th>Bonus</th>
                    <th>Netkar</th>
                    <th>Komisyon</th>
                </tr>
                </tfoot>
                <?php if ($_POST) { ?>
                    <tbody>
                    <?php
                    $toplam = 0;
                    $totalcommission = "0";
                    foreach ($talep as $talep) {
                        $k = kullanici($talep['userid']);

                        $uyeDetay = $db->query("SELECT SUM(betTotal), SUM(betPending), SUM(betWon), SUM(betLost), SUM(betReturn), SUM(financeDeposit), SUM(financeWithdraw), SUM(Bonus) FROM affiliate where userid = '".$talep['id']."' $where order by id DESC")->fetchAll(PDO::FETCH_ASSOC);
                        $totbahis = $uyeDetay[0]['SUM(betTotal)'];
                        $bekbahis = $uyeDetay[0]['SUM(betPending)'];
                        $kazbahis = $uyeDetay[0]['SUM(betWon)'];
                        $kaybahis = $uyeDetay[0]['SUM(betLost)'];
                        $iadbahis = $uyeDetay[0]['SUM(betReturn)'];
                        $guncelbonus = $uyeDetay[0]['SUM(Bonus)'];
                        $bahiskari = $totbahis - ($bekbahis + $kazbahis + $iadbahis);
                        $bahiskari2 = $bahiskari - $guncelbonus;
                        $komisyon = ( ($bahiskari2 / 100) * $kullanici['affiliatepercent'] ) ;
                        $totalcommission = $totalcommission + $komisyon;


                        ?>
                        <tr>
                            <td><?php echo $talep['id']; ?></td>
                            <td><?php echo $talep['username']; ?></td>
                            <td><?php echo $talep['name']; ?></td>
                            <td><?php echo date("d/m H:i",strtotime($talep["kayit_tarih"])); ?></td>
                            <td><?php echo nullChange($uyeDetay[0]['SUM(financeDeposit)']); ?></td>
                            <td><?php echo nullChange($uyeDetay[0]['SUM(financeWithdraw)']); ?></td>
                            <td><?php echo nullChange($totbahis); ?></td>
                            <td><?php echo nullChange($bekbahis); ?></td>
                            <td><?php echo nullChange($kazbahis); ?></td>
                            <td><?php echo nullChange($kaybahis); ?></td>
                            <td><?php echo nullChange($iadbahis); ?></td>
                            <td><?php echo nullChange($bahiskari); ?></td>
                            <td><?php echo nullChange($guncelbonus); ?></td>
                            <td><?php echo nullChange($bahiskari2); ?></td>
                            <td><?php echo nullChange($komisyon); ?></td>
                        </tr>
                    <?php  } ?>
                    </tbody>
                <?php } ?>

            </table>
            <!-- #table -->
            <div class="row datatables-footer">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_info" id="datatable-details_info" role="status" aria-live="polite">Toplam Komisyon => <b style="font-size: 24px;"><?php echo nullChange($totalcommission); ?>  ₺</b></div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- #transactions -->







