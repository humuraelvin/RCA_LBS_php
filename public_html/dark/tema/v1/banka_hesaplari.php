<style type="text/css">
.bonusListe tr:hover {
	background: #D3BB8F;
	color: #fff;
	cursor: pointer;
}
</style>

<header class="page-header">
	<h2><i class="fa fa-bank"></i> Banka Hesaplari</h2>
</header>

<div class="row">
	<div class="col-md-12">
		
		<!-- list -->
		<div class="row">
		
			<!-- hesaplar -->
			<?php foreach ($hesaplar->fetchAll() as $banka) { ?>
			<div class="col-md-3">
				<!-- panel -->
				<section class="panel">
					<header class="panel-heading">
						<h2 class="panel-title"><?php echo $banka['banka']; ?> <button class="btn btn-danger btn-xs admin-action" data-id="<?php echo $banka['id']; ?>" data-action="adminBankaHesabiSil"><i class="fa fa-remove"></i> Kaldır</button></h2>
					</header>
					<div class="panel-body">
						<!-- form -->
						<form id="adminBankaGuncelleForm" banka-id="<?php echo $banka['id']; ?>">
							<fieldset>
								<div class="row">
									<div class="col-md-12 form-group">
										<label class="control-label" for="profileFirstName">Ad Soyad: </label>
										<input type="text" name="adsoyad" class="form-control" value="<?php echo $banka['adsoyad']; ?>" />
									</div>
									<div class="col-md-6 form-group">
										<label class="control-label" for="profileFirstName">Şube: </label>
										<input type="text" name="sube" value="<?php echo $banka['sube']; ?>" class="form-control" />
									</div>
									<div class="col-md-6 form-group">
										<label class="control-label" for="profileFirstName">Hesap: </label>
										<input type="text" name="hesap" value="<?php echo $banka['hesap']; ?>" class="form-control" />
									</div>
									<div class="col-md-12 form-group">
										<label class="control-label" for="profileFirstName">IBAN: </label>
										<input type="text" name="iban" value="<?php echo $banka['iban']; ?>" class="form-control" />
									</div>
									<div class="col-md-12 form-group">
										<label class="control-label" for="profileFirstName">Durum: </label>
										<select name="durum" id="durum" class="form-control">
											<option value="0" <?php echo ($banka['durum'] == '0') ? 'selected' : null; ?>>Pasif</option>
											<option value="1" <?php echo ($banka['durum'] == '1') ? 'selected' : null; ?>>Aktif</option>
										</select>
									</div>
									<div class="col-md-4 form-group">
										<label class="control-label" for="profileFirstName">Yatırım: </label>
										<select name="deposit" id="deposit" class="form-control">
											<option value="0" <?php echo ($banka['deposit'] == '0') ? 'selected' : null; ?>>Pasif</option>
											<option value="1" <?php echo ($banka['deposit'] == '1') ? 'selected' : null; ?>>Aktif</option>
										</select>
									</div>
									<div class="col-md-4 form-group">
										<label class="control-label" for="profileFirstName">Çekim: </label>
										<select name="withdraw" id="withdraw" class="form-control">
											<option value="0" <?php echo ($banka['withdraw'] == '0') ? 'selected' : null; ?>>Pasif</option>
											<option value="1" <?php echo ($banka['withdraw'] == '1') ? 'selected' : null; ?>>Aktif</option>
										</select>
									</div>
									<div class="col-md-4 form-group">
										<label class="control-label" for="profileFirstName">Cepbank: </label>
										<select name="mobiletransfer" id="mobiletransfer" class="form-control">
											<option value="0" <?php echo ($banka['mobiletransfer'] == '0') ? 'selected' : null; ?>>Pasif</option>
											<option value="1" <?php echo ($banka['mobiletransfer'] == '1') ? 'selected' : null; ?>>Aktif</option>
										</select>
									</div>
									<div class="form-group col-md-12">
										<button class="btn btn-success admin-action" data-action="adminBankaHesabiGuncelle" data-id="<?php echo $banka['id']; ?>"><i class="fa fa-check"></i> güncelle</button>
									</div>
								</div>
							</fieldset>
						</form>
						<!-- #form -->
					</div>
				</section>
				<!-- #panel -->
			</div>
			<?php } ?>
		
		</div>
		<!-- #list --->
		
	</div>
</div>