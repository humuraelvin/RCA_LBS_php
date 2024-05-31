<header class="page-header">
	<h2><i class="fa fa-money"></i> Bakiye + / -</h2>
</header>

<section class="panel">
	<div class="panel-body">
		<!-- Form -->
		<form id="bakiyeGonderForm">
			<div class="form-group">
				<label for="">Kullanıcı Seçin: </label>
				<!-- <select class="form-control" name="id" id="id">
					<option value="0">--</option>
					<?php foreach ($kullanicilar->fetchAll(PDO::FETCH_ASSOC) as $kullanici) { ?>
						<option <?php echo (@$g[1] == $kullanici['id']) ? 'selected=selected' : null; ?> value="<?php echo $kullanici['id']; ?>" data-bakiye="<?php echo mf($kullanici['bakiye']) ?>"><?php echo $kullanici['username']; ?></option>
					<?php } ?>
				</select> -->
				<input type="text" class="form-control" id="autoComplete_user" value="<?php echo (isset($g[1])) ? kullanici($g[1])['name'] : null; ?>" />
				<input type="hidden" name="kullanici" value="<?php echo (isset($g[1])) ? $g[1] : null; ?>" />
			  </div>
			  <div class="form-group">
				<label for="">Mevcut Bakiye: </label>
				<div class="mevcutbakiye"><b class="bakiye"><?php echo (isset($g[1])) ? mf(kullanici($g[1])['bakiye']) : null; ?></b> <i class="fa fa-try"></i></div>
			  </div>
			  <div class="form-group">
				<label for="">İşlem Türü: </label>
				<select name="method" id="method">
					<option value="1">Yatır (+)</option>
					<option value="2" <?php echo (@p('islem') == 'cikar') ? 'selected' : null; ?>>Çekme (-)</option>
				</select>
			  </div>
			  <div class="form-group">
				<label for="">Miktar: </label>
				<div class="row">
					<div class="col-md-1" style="width: 10.33333333%">
						<input type="text" maxlength="5" class="form-control" name="bakiye" />
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
					<button type="submit" class="btn btn-success admin-action" data-action="adminBakiyeGonder">Gönder</button>
				</div>
		</form>
		<!-- #Form -->
	</div>
</section>