<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
	table tr {
		background: #F8F8F8;
	}
	table td {font-weight: bold;}
	.table-line {
		width: 100%;
		display: block;
		border: 1px solid #f3f3f3;
		margin: 10px 0 10px 0;
	}
	table tr.durum1 {
		background: #58753B;
		color: #fff;
	}
	table tr.durum2 {
		background: #F64744;
		color: #fff;
	}
	table tr.durum0 {
		background: #54B1F6;
		color: #fff;
	}
	.table-money {
		font-size: 18px;
	}
	table code {
		background: #35baff;
		color: #fff;
		padding: 5px;
	}
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Bahis Yoğunluğu</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<!-- <div class="row">
			<div class="col-md-2">
				<select class="form-control" name="tur" id="tur">
					<option value="0" <?php echo ($tur == '0') ? 'selected' : null; ?>>Yatırım Yöntemi: </option>
					<option value="Havale" <?php echo ($tur == 'Havale') ? 'selected' : null; ?>>Havale</option>
					<option value="Cep Bank" <?php echo ($tur == 'Cep Bank') ? 'selected' : null; ?>>Cep Bank</option>
					<option value="AstroPay" <?php echo ($tur == 'AstroPay') ? 'selected' : null; ?>>AstroPay</option>
					<option value="TL Nakit" <?php echo ($tur == 'TL Nakit') ? 'selected' : null; ?>>TL Nakit</option>
					<option value="ECOPAYZ" <?php echo ($tur == 'ECOPAYZ') ? 'selected' : null; ?>>ECOPAYZ</option><option value="Bocash">Bocash</option>
				</select>
			</div>
			<div class="col-md-2">
				<!-- <select class="form-control" name="kullanici" id="kullanici">
					<option value="0">Tüm Üyeler</option>
					<?php foreach ($kullanicilar as $kullanici_row) { ?>
						<option <?php echo ($kullanici == $kullanici_row['id']) ? 'selected=selected' : null; ?> value="<?php echo $kullanici_row['id']; ?>"><?php echo $kullanici_row['username']; ?></option>
					<?php } ?>
				</select> -->
				<!-- <input type="text" class="form-control" id="autoComplete_user" />
				<input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" />
			</div>
			<div class="col-md-4">
				<div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-plugin-datepicker="">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
					<span class="input-group-addon">-</span>
					<input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
				</div>
			</div>
			<div class="col-md-1">
				<select class="form-control" name="durum">
					<option value="3" <?php echo ($durum == '3') ? 'selected' : null; ?>>Hepsi</option>
					<option value="0" <?php echo ($durum == '0') ? 'selected' : null; ?>>Bekleyen</option>
					<option value="1" <?php echo ($durum == '1') ? 'selected' : null; ?>>Onaylanan</option>
					<option value="2" <?php echo ($durum == '2') ? 'selected' : null; ?>>İptal Edilen</option>
				</select>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary admin-action" data-action="adminBankaYatirim">Listele</button>
			</div>
		</div> -->
		<!-- form -->
		<fieldset>
		</fieldset>
		<hr class="dotted short">
		<!-- #form -->
		
		<table class="table table-bordered mb-none dataTable" id="datatable-default">
			<thead>
				<tr class="table_row">
					<td>Maç No</td>
					<td>Tarih</td>
					<td>Karşılaşma</td>
					<td>Tür</td>
					<td>Tercih</td>
					<td>Adet</td>
					<td>Yatırılan</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($kuponlar as $kupon) { ?>
					<tr class="durum">
						<td><?php echo $kupon['kodu']; ?></td>
						<td><?php echo $kupon['tarihi']; ?></td>
						<td><?php echo $kupon['mace']. ' - ' .$kupon['macd']; ?></td>
						<td><code><?php echo $kupon['aciklamasi']; ?></code></td>
						<td><code><?php echo $kupon['tur']; ?></code></td>
						<td><code><?php echo $kupon['sayi']; ?></code></td>
						<td><code style="background: red"><?php echo mf($kupon['miktar']); ?></code> ₺</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		
	</div>
</section>
<!-- #Tablo -->