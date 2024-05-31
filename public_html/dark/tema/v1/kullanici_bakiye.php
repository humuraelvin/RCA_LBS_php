<div id="amount" class="tab-pane active">

    <div class="row">
        <div class="col-md-4">
            <section class="panel panel-featured-dark panel-featured">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                    </div>

                    <h2 class="card-title">Bakiye Ekle</h2>
                </header>
                <div class="panel-body" style="display: block;">
                    <div class="content">
                        <form id="bakiyeGonderForm">
                            <fieldset>
                                <div class="form-group">
                                    <label for="">Mevcut Bakiye: </label>
                                    <div class="mevcutbakiye"><b class="bakiye"><?php echo mf($kullanici['bakiye']); ?></b> <i class="fa fa-try"></i></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Miktar: </label>
                                    <input type="text" maxlength="5" class="form-control" name="bakiye" />
                                </div>
                                <div class="form-group">
                                    <label for="">Açıklama: </label>
                                    <textarea name="aciklama" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-action="adminBakiyeGonder"><i class="fa fa-plus"></i> Ekle</button>
                                </div>
                                <input type="hidden" name="method" value="1" />
                                <input type="hidden" name="kullanici" value="<?php echo $kullanici['admin_id']; ?>" />
                            </fieldset>
                        </form>
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

                    <h2 class="card-title">Bakiye Çıkar</h2>
                </header>
                <div class="panel-body" style="display: block;">
                    <div class="content">
                        <form id="bakiyeGonderForm">
                            <fieldset>
                                <div class="form-group">
                                    <label for="">Mevcut Bakiye: </label>
                                    <div class="mevcutbakiye"><b class="bakiye"><?php echo mf($kullanici['bakiye']); ?></b> <i class="fa fa-try"></i></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Miktar: </label>
                                    <input type="text" maxlength="5" class="form-control" name="bakiye" />
                                </div>
                                <div class="form-group">
                                    <label for="">Açıklama: </label>
                                    <textarea name="aciklama" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-action="adminBakiyeGonder"><i class="fa fa-remove"></i> Çıkar</button>
                                </div>
                                <input type="hidden" name="method" value="2" />
                                <input type="hidden" name="kullanici" value="<?php echo $kullanici['admin_id']; ?>" />
                            </fieldset>
                        </form>
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

                    <h2 class="card-title">Bonus Ekle</h2>
                </header>
                <div class="panel-body" style="display: block;">
                    <div class="content">
                        <script type="text/javascript">
                            function adminbonusSelect(bonus) {
                                document.getElementById('bonusSelect').value = bonus;

                            }
                        </script>
                        <?php
                        $yatirimson = $db->query("select * from parayatir where uye = '".$kullanici['admin_id']."' ORDER BY id desc LIMIT 1 ")->fetchAll();
                        foreach ($yatirimson as $yatirims) {
                            echo '<div class="form-group"><b>SON YATIRIM : </b>'.$yatirims['tur'].' - '.$yatirims['tarih'].' => <button class="btn btn-success" onclick="adminbonusSelect('.$yatirims['miktar'].');"> '.$yatirims['miktar'].' ₺</button></div>';
                        }
                        ?>
                        <hr class="dotted short">
                        <?php
                        $cekimson = $db->query("select * from paracek where uye = '".$kullanici['admin_id']."' ORDER BY id desc LIMIT 1 ")->fetchAll();
                        foreach ($cekimson as $cekims) {
                            echo '<div class="form-group" ><b style="color:#660000;">SON ÇEKİM : </b>'.$cekims['tur'].' - '.$cekims['tarih'].' => <b style="font-size: 22px;">'.$cekims['miktar'].' ₺ </b></div>';
                        }
                        ?>
                        <hr class="dotted short">

                        <form id="bonusGonderForm">
                            <fieldset>
                                <div class="form-group">
                                    <label for="">Mevcut Bakiye: </label>
                                    <div class="mevcutbakiye"><b class="bakiye"><?php echo mf($kullanici['bakiye']); ?></b> <i class="fa fa-try"></i></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Miktar: </label>
                                    <input type="text" maxlength="5" class="form-control" name="bakiye" id="bonusSelect" value=""/>
                                </div>
                                <div class="form-group">
                                    <select style="width: 100%" name="bonus" id="bonus">
                                        <option value="0">Bonus Seç</option>
                                        <?php foreach ($db->query("SELECT * FROM bonuslar")->fetchAll() as $bonus) { if ($bonus['id'] != '5') { ?>
                                            <option data-yuzde="<?php echo $bonus['yuzde']; ?>" value="<?php echo $bonus['id']; ?>"><?php echo $bonus['bonusadi']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="form-group yuzde-sonuc" style="display: none">
                                    <label for="">Bonus Hesaplaması: <div class="cevir" style="color: red; font-weight: bold">25</div> <i class="fa fa-try"></i></label>
                                </div>
                                <div class="form-group row">
                                    <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-id="<?php echo $kullanici['admin_id']; ?>" data-action="adminBonusGonder"><i class="fa fa-plus"></i> Gönder</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>

</div>