<section role="main" >
    <header class="page-header">
        <h2>Site Ayarları</h2>

    </header>
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Site Ayarları</h2>
        </header>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form id="adminSettings">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Bahis Yapma</label>
                                <div class="col-md-9 form-group">
                                    <?php
                                    if ($settings[0]['key'] == "bet") {
                                        $bet_settings =  $settings[0]['value'];
                                    }
                                    ?>
                                    <select name="bet" id="bet" class="form-control" >
                                        <option value="0" <?php echo ($bet_settings == '0') ? 'selected' : null; ?> >Pasif</option>
                                        <option value="1" <?php echo ($bet_settings == '1') ? 'selected' : null; ?> >Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Canli Bahis Oranları</label>
                                <div class="col-md-2">
                                    <?php
                                    if ($settings[1]['key'] == "live_odds") {
                                        $live_odds_settings = json_decode($settings[1]['value']);
                                    }
                                    ?>
                                    <select name="live_odds_type" id="live_odds_type" class="form-control" >
                                        <option value="increase" <?php echo ($live_odds_settings[0] == 'increase') ? 'selected' : null; ?> >Arttır</option>
                                        <option value="decrease" <?php echo ($live_odds_settings[0] == 'decrease') ? 'selected' : null; ?> >Azalt</option>
                                    </select>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" id="live_odds" name="live_odds" value="<?php echo $live_odds_settings[1]; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileFirstName">Maç Öncesi Bahis Oranları</label>
                                <div class="col-md-2">
                                    <?php
                                    if ($settings[2]['key'] == "pre_odds") {
                                        $pre_odds_settings = json_decode($settings[2]['value']);
                                    }
                                    ?>
                                    <select name="pre_odds_type" id="pre_odds_type" class="form-control" >
                                        <option value="increase" <?php echo ($pre_odds_settings[0] == 'increase') ? 'selected' : null; ?> >Arttır</option>
                                        <option value="decrease" <?php echo ($pre_odds_settings[0] == 'decrease') ? 'selected' : null; ?> >Azalt</option>
                                    </select>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" id="pre_odds" name="pre_odds" value="<?php echo $pre_odds_settings[1]; ?>">
                                </div>
                            </div>


                            <div class="form-group">
                                <button class="mb-xs mt-xs mr-xs btn btn-success btn-lg btn-block admin-action" data-action="adminSettings" "><i class="fa fa-refresh"></i> Güncelle</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
