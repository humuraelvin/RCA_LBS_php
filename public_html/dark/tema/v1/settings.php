<section role="main" >
    <header class="page-header">
        <h2>Canli Bot Ayarları</h2>

    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Canli Bot Ayarları</h2>
        </header>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form id="adminSiteSettings">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Canlı Bot Servisi</label>
                                <div class="col-md-9">
                                    <select name="bot" id="bot" class="form-control" >
                                        <?php foreach ($odds_services->fetchAll(PDO::FETCH_ASSOC) as $key => $odds) { ?>
                                            <option value="<?php echo $odds['id']; ?>" <?php echo ($odds['active'] == '1') ? 'selected' : null; ?> ><?php echo $odds['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="mb-xs mt-xs mr-xs btn btn-success btn-lg btn-block admin-action" data-action="adminSiteSettings" "><i class="fa fa-refresh"></i> Güncelle</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
