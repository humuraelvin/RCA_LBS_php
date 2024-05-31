<script type="text/javascript">
    $(function(){
        $.kullaniciBakiye = function(game){
            $(".balance." +game).html( "<i class='fa fa-spinner fa-spin'></i>");
            $.ajax({
                type: "POST",
                url: SITE_URL + "/ajax/admin.ajax.php",
                dataType: "json",
                data: {"tip": "kullaniciBakiyeleri", "game": game, "id": <?php echo $kullanici['admin_id']; ?>},
                success: function(c) {
                    $(".balance." +game).html( c.balance + " ₺" );
                }
            });
        }
    });
</script>
<?php if (!@g('ajax') || @g('page')) { ?>
<section role="main">

    <header class="page-header">
        <h2><i class="fa fa-user"></i> @<?php echo $kullanici['username'];?></h2>
    </header>




    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="tabs tabs-quaternary">
                <ul class="nav nav-tabs">
                    <li <?php echo (@$url[0] == '') ? 'class="active"' : null; ?>>
                        <a href="#overview" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="/" data-id="<?php echo $url[1]; ?>"><i class="fa fa-user"></i> Profil</a>
                    </li>
                    <li <?php echo (@$url[2] == 'duzenle') ? 'class="active"' : null; ?>>
                        <a href="#edit" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="duzenle" data-id="<?php echo $url[1]; ?>"><i class="fa fa-pencil"></i> Düzenle</a>
                    </li>
                    <li <?php echo (@$url[2] == 'bakiye') ? 'class="active"' : null; ?>>
                        <a href="#amount" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="bakiye" data-id="<?php echo $url[1]; ?>"><i class="fa fa-try"></i> Bakiye</a>
                    </li>
                    <li <?php echo (@$url[2] == 'betlimit') ? 'class="active"' : null; ?>>
                        <a href="#bans" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="betlimit" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Limit</a>
                    </li>
                    <li <?php echo (@$url[2] == 'hareketler') ? 'class="active"' : null; ?>>
                        <a href="#transactions" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="hareketler" data-islem="3" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Hesap Hareketleri</a>
                    </li>
                    <li <?php echo (@$url[2] == 'bahis') ? 'class="active"' : null; ?>>
                        <a href="#transactions" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="bahis" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Bahis Geçmişi</a>
                    </li>
                    <li <?php echo (@$url[2] == 'bonus') ? 'class="active"' : null; ?>>
                        <a href="#transactions" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="bonus" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Bonus Geçmişi</a>
                    </li>
                    <li <?php echo (@$url[2] == 'bans') ? 'class="active"' : null; ?>>
                        <a href="#bans" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="bans" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Üye Notları</a>
                    </li>
                    <?php if ($kullanici['affiliate'] == "1" ) { ?>
                        <li <?php echo (@$url[2] == 'bayiler') ? 'class="active"' : null; ?>>
                            <a href="#bayiler" data-toggle="tab" class="admin-action nav-link show" data-action="adminKullaniciTab" data-page="bayiler" data-id="<?php echo $url[1]; ?>"><i class="fa fa-list"></i> Affiliate</a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php } ?>
                    <?php
                    if (isset($url[2])) {
                        call_user_func( 'profil_' . $url[2], $kullanici );
                    } else {
                        ?>
                        <div id="overview" class="tab-pane active">








                            <div class="row">

                                <div class="col-md-4 ">
                                    <section class="panel panel-featured-success panel-featured">
                                        <header class="panel-heading">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">Kişisel Bilgiler</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Id</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo $kullanici['id'] ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kullanıcı Adı</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo $kullanici['username'] ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>İsim</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo $kullanici['name'] ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kimlik No</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo $kullanici['tc'] ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Yaş</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo date('Y') - date('Y', strtotime($kullanici['dt'])); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Doğum Tarihi</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo $kullanici['dt']; ?></span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="col-md-4">
                                    <section class="panel panel-featured-info panel-featured">
                                        <header class="panel-heading">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">İletişim Bilgileri</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>E-Posta</td>
                                                        <td align="right"><span class="badge badge-info"><?php if ( limit_kontrol( 87 ) ) { echo $kullanici['email']; } else { echo "************@gmail.com"; } ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telefon</td>
                                                        <td align="right"><span class="badge badge-info"><?php if ( limit_kontrol( 86 ) ) { echo $kullanici['telefon']; } else { echo "5********"; }; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Şehir</td>
                                                        <td align="right"><span class="badge badge-info"><?php echo $kullanici['il']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ülke</td>
                                                        <td align="right"><span class="badge badge-info">Türkiye</span></td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="col-md-4">
                                    <section class="panel panel-featured-danger panel-featured">
                                        <header class="panel-heading ">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">Finans Bilgileri</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Bakiye</td>
                                                        <td align="right"><span class="badge badge-danger"><?php echo mf($kullanici['bakiye']); ?> <i class="fa fa-try" ></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Casino Bakiye (HoGaming)</td>
                                                        <td align="right"><span class="badge badge-danger balance hogaming">0 ₺</span><i class="fa fa-refresh" style="margin-left:6px;cursor:pointer;" onclick="$.kullaniciBakiye('hogaming');"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toplam Yatırım</td>
                                                        <td align="right"><span class="badge badge-danger"><?php echo mf($yatirim_cekim['deposit']); ?> <i class="fa fa-try"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Toplam Çekim</td>
                                                        <td align="right"><span class="badge badge-danger"><?php echo mf($yatirim_cekim['draw']); ?> <i class="fa fa-try"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Genel</td>
                                                        <td align="right"><span class="badge badge-success"><?php echo mf($yatirim_cekim['deposit']-$yatirim_cekim['draw']); ?> <i class="fa fa-try"></i></span></td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                            </div>


                            <hr class="dotted short">



                            <div class="row">

                                <div class="col-md-4 ">
                                    <section class="panel panel-featured-warning panel-featured">
                                        <header class="panel-heading">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">Güvenlik</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>Kayıt Tarihi</td>
                                                        <td align="right"><span class="badge badge-warning"><?php echo date('Y-m-d H:i', strtotime($kullanici['kayit_tarih'])); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Son Giriş Tarihi</td>
                                                        <td align="right"><span class="badge badge-warning"><?php echo date('Y-m-d H:i',$lastLoginDate); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Son Giriş IP</td>
                                                        <td align="right"><span class="badge badge-warning"><?php echo $lastLoginIp; ?></span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="col-md-4">
                                    <section class="panel panel-featured-dark panel-featured">
                                        <header class="panel-heading">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">Hızlı İşlemler</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <td>TC Onay</td>
                                                        <td align="right">
                                                        <span class="badge badge-dark">
                                                            <?php if ($kullanici['TcOnay'] == '1') { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="TcOnay" data-values='{"TcOnay": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> ONAYLI</span>
                                                            <?php } else { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="TcOnay" data-values='{"TcOnay": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> KNT ET</span>
                                                            <?php } ?>
                                                        </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bahis Yapma</td>
                                                        <td align="right">
                                <span class="badge badge-dark">
                                    <?php if ($kullanici['sports'] == '1') { ?>
                                        <span  class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="sports" data-values='{"sports": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                    <?php } else { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="sports" data-values='{"sports": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                    <?php } ?>
                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Casino</td>
                                                        <td align="right">
                                                        <span class="badge badge-dark">
                                                            <?php if ($kullanici['casino'] == '1') { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="casino" data-values='{"casino": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                                            <?php } else { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="casino" data-values='{"casino": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                                            <?php } ?>
                                                        </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tombala</td>
                                                        <td align="right">
                                                        <span class="badge badge-dark">
                                                            <?php if ($kullanici['tombala'] == '1') { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="tombala" data-values='{"tombala": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                                            <?php } else { ?>
                                                                <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="tombala" data-values='{"tombala": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                                            <?php } ?>
                                                        </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Yatırım</td>
                                                        <td align="right">
                                <span class="badge badge-dark">
                                    <?php if ($kullanici['deposit'] == '1') { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="deposit" data-values='{"deposit": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                    <?php } else { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="deposit" data-values='{"deposit": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                    <?php } ?>
                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Çekim</td>
                                                        <td align="right">
                                <span class="badge badge-dark">
                                    <?php if ($kullanici['withdraw'] == '1') { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="withdraw" data-values='{"withdraw": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                    <?php } else { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="withdraw" data-values='{"withdraw": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                    <?php } ?>
                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Affiliate</td>
                                                        <td align="right">
                                <span class="badge badge-dark">
                                    <?php if ($kullanici['affiliate'] == '1') { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="affiliate" data-values='{"affiliate": 0, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-check"></i> Açık</span>
                                    <?php } else { ?>
                                        <span href="#" class="admin-action" data-action="adminKullaniciTab_StatusDegistir" data-name="affiliate" data-values='{"affiliate": 1, "id": <?php echo $kullanici['admin_id']; ?>}'><i class="fa fa-remove"></i> Kapalı</span>
                                    <?php } ?>
                                </span>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="col-md-4">
                                    <section class="panel panel-featured-primary panel-featured">
                                        <header class="panel-heading ">
                                            <div class="panel-actions">
                                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                                                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                                            </div>
                                            <h2 class="card-title">Son Hareketler</h2>
                                        </header>
                                        <div class="panel-body" style="display: block;">
                                            <div class="content">
                                                <table class="table table-responsive-md table-striped mb-0">
                                                    <tbody>
                                                    <?php foreach ($logs as $log) {  ?>
                                                        <tr>
                                                            <td><?php echo $log['islemad']; ?></td>
                                                            <td align="right"><span class="badge badge-grey"><?php echo date('Y-m-d H:i', strtotime($log['tarih'])); ?></span></td>
                                                        </tr>
                                                    <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                            </div>




                        </div>
                    <?php } ?>
                    <?php if (!@g('ajax') || @g('page')) { ?>
                </div>
            </div>
        </div>

    </div>
    <!-- end: page -->
</section>
<?php } ?>
