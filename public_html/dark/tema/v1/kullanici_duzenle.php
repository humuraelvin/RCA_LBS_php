<div id="edit" class="tab-pane active">
<!-- row -->
<div class="row">
    <div class="col-md-4">
        <section class="panel panel-featured-dark panel-featured">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                    <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                </div>
                <h2 class="card-title">Kişisel Bilgiler</h2>
            </header>
            <div class="panel-body" >
                <div class="content">
                    <form id="adminKullaniciTab_ProfilForm">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Hesap Durumu</label>
                                <div class="col-md-8">
                                    <select name="durum" id="durum" class="form-control" >
                                        <option value="0" <?php echo ($kullanici['durum'] == '0') ? 'selected' : null; ?>>Aktif</option>
                                        <option value="1" <?php echo ($kullanici['durum'] == '1') ? 'selected' : null; ?>>Pasif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Tc Kimlik No: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="tc" value="<?php echo $kullanici['tc']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Ad Soyad: </label>
                                <div class="col-md-8">
                                    <input type="text" name="name" value="<?php echo $kullanici['name']; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Doğum Tarihi: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control datepicker" value="<?php echo $kullanici['dt']; ?>" name="dt">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Affiliate Yüzde: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control " value="<?php echo $kullanici['affiliatepercent']; ?>" name="affiliatepercent">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Affiliate Id: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control " value="<?php echo $kullanici['affiliateid']; ?>" name="affiliateid">
                                </div>
                            </div>
                            <div class="form-group">
                                    <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-action="adminKullaniciTab_FormGuncelle" data-id="<?php echo $kullanici['admin_id']; ?>"><i class="fa fa-refresh"></i> Güncelle</button>
                            </div>
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
                <h2 class="card-title">İletişim Bilgiler</h2>
            </header>
            <div class="panel-body" >
                <div class="content">
                    <form id="adminKullaniciTab_ProfilForm">
                        <fieldset>

                            <?php  if ( limit_kontrol( 86 ) ) {  ?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileFirstName">Cep Telefonu: </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="telefon" value="<?php echo $kullanici['telefon']; ?>" />
                                    </div>
                                </div>
                            <?php } ?>

                            <?php  if ( limit_kontrol( 87 ) ) {  ?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileFirstName">E-Posta: </label>
                                    <div class="col-md-8">
                                        <input type="text" name="email" value="<?php echo $kullanici['email']; ?>" class="form-control" />
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <button class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-action="adminKullaniciTab_FormGuncelle" data-id="<?php echo $kullanici['admin_id']; ?>"><i class="fa fa-refresh"></i> Güncelle</button>
                            </div>
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
                <h2 class="card-title">Şifre Değiştir</h2>
            </header>
            <div class="panel-body" >
                <div class="content">
                    <form id="kullaniciSifreDegistirForm">
                        <fieldset>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Yeni Şifre</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" placeholder="*********" class="form-control" />
                                    <input type="hidden" name="id" value="<?php echo $kullanici['admin_id']; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="mb-1 mt-1 mr-1 btn btn-dark btn-block admin-action" data-action="adminKullaniciSifreDegistir" data-id="<?php echo $kullanici['admin_id']; ?>" data-type="ajax"><i class="fa fa-pencil"></i> Şifre Değiştir</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

</div>