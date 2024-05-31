<header class="page-header">
	<h2><i class="fa fa-comment"></i> Sms Ekle</h2>
</header>

<section class="panel">
	<div class="panel-body">
		<!-- Form -->
		<form id="smsGonderForm">
			<div class="form-group">
				<label for="">Kullanıcı Seçin: </label>
				<!-- <select class="form-control" name="kullanici" id="kullanici">
					<option value="0">Tüm Üyeler</option>
					<?php foreach ($kullanicilar as $kullanici_row) { ?>
						<option <?php echo ($kullanici == $kullanici_row['id']) ? 'selected=selected' : null; ?> value="<?php echo $kullanici_row['id']; ?>"><?php echo $kullanici_row['username']; ?></option>
					<?php } ?>
				</select> -->
				<input type="text" class="form-control" id="autoComplete_user" />
				<input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" />
			  </div>
			  <div class="form-group">
				<label for="">SMS: </label>
				<div class="mevcutsms"><b class="sms">0.00</b> adet</div>
			  </div>
			  <div class="form-group">
				<label for="">İşlem Türü: </label>
				<select name="method" id="method">
					<option value="1">Sms Ekle (+)</option>
					<option value="2">Sms Çıkart (-)</option>
				</select>
			  </div>
			  <div class="form-group">
				<label for="">SMS: </label>
				<div class="row">
					<div class="col-md-1" style="width: 10.33333333%">
						<input type="text" maxlength="5" class="form-control" name="smsadet" />
					</div>
				</div>
				</div>
				<div class="form-group">
					<label for="">Açıklama: </label>
					<textarea name="aciklama" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<?php if(@p('type') == 'adminGeriDon') { ?>
						<button class="btn btn-primary admin-action" data-action="adminGeriDon">Geri Dön</button>
					<?php } ?>
					<button type="submit" class="btn btn-success admin-action" data-action="adminSmsGonder">Gönder</button>
				</div>
		</form>
		<!-- #Form -->
	</div>
</section>