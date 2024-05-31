<header class="page-header">
	<h2><i class="fa fa-plus"></i> Banka Ekle</h2>
</header>

<section class="panel">
	<div class="panel-body">
		<!-- Form -->
		<form id="adminBankaEkleForm">
			<fieldset>
				<div class="row">
					<div class="col-md-12 form-group">
						<label class="control-label" for="profileFirstName">BANKA: </label>
						<input type="text" name="banka" class="form-control" />
					</div>
					<div class="col-md-12 form-group">
						<label class="control-label" for="profileFirstName">Ad Soyad: </label>
						<input type="text" name="adsoyad" class="form-control" />
					</div>
					<div class="col-md-6 form-group">
						<label class="control-label" for="profileFirstName">Şube: </label>
						<input type="text" name="sube" class="form-control" />
					</div>
					<div class="col-md-6 form-group">
						<label class="control-label" for="profileFirstName">Hesap: </label>
						<input type="text" name="hesap" class="form-control" />
					</div>
					<div class="col-md-12 form-group">
						<label class="control-label" for="profileFirstName">IBAN: </label>
						<input type="text" name="iban" class="form-control" />
					</div>
					<div class="col-md-12 form-group">
						<label class="control-label" for="profileFirstName">Durum: </label>
						<select name="durum" id="durum" class="form-control">
							<option value="0">Pasif</option>
							<option value="1">Aktif</option>
						</select>
					</div>
					<div class="col-md-4 form-group">
						<label class="control-label" for="profileFirstName">Yatırım: </label>
						<select name="deposit" id="deposit" class="form-control">
							<option value="0">Pasif</option>
							<option value="1">Aktif</option>
						</select>
					</div>
					<div class="col-md-4 form-group">
						<label class="control-label" for="profileFirstName">Çekim: </label>
						<select name="withdraw" id="withdraw" class="form-control">
							<option value="0">Pasif</option>
							<option value="1">Aktif</option>
						</select>
					</div>
					<div class="col-md-4 form-group">
						<label class="control-label" for="profileFirstName">Cepbank: </label>
						<select name="mobiletransfer" id="mobiletransfer" class="form-control">
							<option value="0">Pasif</option>
							<option value="1">Aktif</option>
						</select>
					</div>
					<div class="form-group col-md-12">
						<button class="btn btn-success admin-action" data-action="adminBankaHesabiEkle"><i class="fa fa-plus"></i> Ekle</button>
					</div>
				</div>
			</fieldset>
		</form>
		<!-- #Form -->
	</div>
</section>