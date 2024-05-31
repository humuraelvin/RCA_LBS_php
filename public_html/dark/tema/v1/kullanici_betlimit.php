<div id="edit" class="tab-pane active">
    <!-- row -->
    <div class="row">

        <div class="col-md-4">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
                    </div>

                    <h2 class="card-title">Kupon Limitleri</h2>
                </header>
                <div class="panel-body" style="display: block;">
                    <div class="content">
                        <form id="adminKullaniciTab_ProfilForm">
                            <fieldset>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Genel Limit % </label>
                                    <div class="col-md-8">
                                        <div class="input-daterange input-group">
                                            <span class="input-group-addon"> <i class="fa fa-percent" aria-hidden="true"></i> </span>
                                            <input type="text" name="sportsLimit" class="form-control" value="<?php echo $kullanici['sportsLimit']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Minimum Kupon Limiti </label>
                                    <div class="col-md-8">
                                        <input type="text" name="minkupon" value="<?php echo $kullanici['minkupon']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Minimum Oran Limiti </label>
                                    <div class="col-md-8">
                                        <input type="text" name="minoran" value="<?php echo $kullanici['minoran']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Maximum Kupon Limiti </label>
                                    <div class="col-md-8">
                                        <input type="text" name="maxkupon" value="<?php echo $kullanici['maxkupon']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Maximum Oran Limiti </label>
                                    <div class="col-md-8">
                                        <input type="text" name="maxoran" value="<?php echo $kullanici['maxoran']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Minimum Maç Sayısı</label>
                                    <div class="col-md-8">
                                        <input type="text" name="minmac" value="<?php echo $kullanici['minmac']; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Maximum Maç Sayısı</label>
                                    <div class="col-md-8">
                                        <input type="text" name="maxmac" value="<?php echo $kullanici['maxmac']; ?>" class="form-control" />
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

    </div>
</div>