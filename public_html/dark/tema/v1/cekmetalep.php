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
		background: #EFA740;
		color: #fff;
	}
	table tr.durum2 {
		background: #58753B;
		color: #fff;
	}
	table tr.durum3 {
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
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Çekim İşlemleri</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<fieldset>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<!-- <label for="exampleInputEmail1">İşlem Tipi: </label>
					<select class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
						<option value="0" <?php echo ($tur == '0') ? 'selected' : null; ?>>Yatırım Yöntemi: </option>
						<option value="Havale" <?php echo ($tur == 'Havale') ? 'selected' : null; ?>>Havale</option>
						<option value="Cep Bank" <?php echo ($tur == 'Cep Bank') ? 'selected' : null; ?>>Cep Bank</option>
						<option value="AstroPay" <?php echo ($tur == 'AstroPay') ? 'selected' : null; ?>>AstroPay</option>
						<option value="TL Nakit" <?php echo ($tur == 'TL Nakit') ? 'selected' : null; ?>>TL Nakit</option>
						<option value="ECOPAYZ" <?php echo ($tur == 'ECOPAYZ') ? 'selected' : null; ?>>ECOPAYZ</option><option value="Bocash">Bocash</option>
					</select> -->
					<input placeholder="Kullanıcı arayın." type="text" class="form-control" id="autoComplete_user" />
					<input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" />
				</div>
			</div>
		</div>
			<hr class="dotted short">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Başlangıç Tarihi: </label>
					<input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Bitiş Tarihi: </label>
					<input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
				</div>
			</div>
		</div>
			<hr class="dotted short">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Hareket Tipi: </label>
					<select class="form-control" name="tur" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
						<option value="Havale" <?php echo ($tur == 'Havale') ? 'selected' : null; ?>>Havale</option>
						<option value="CepBank" <?php echo ($tur == 'Cep Bank') ? 'selected' : null; ?>>Cep Bank</option>
						<option value="AstroPay" <?php echo ($tur == 'AstroPay') ? 'selected' : null; ?>>AstroPay</option>
						<option value="TL Nakit" <?php echo ($tur == 'TL Nakit') ? 'selected' : null; ?>>TL Nakit</option>
						<option value="ECOPAYZ" <?php echo ($tur == 'ECOPAYZ') ? 'selected' : null; ?>>ECOPAYZ</option><option value="Bocash">Bocash</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">Sorgu Tipi: </label>
					<select class="form-control" name="durum" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
						<option value="4" <?php echo ($durum == '4') ? 'selected' : null; ?>>Hepsi</option>
						<option value="0" <?php echo ($durum == '0') ? 'selected' : null; ?>>Yeni</option>
						<option value="1" <?php echo ($durum == '1') ? 'selected' : null; ?>>Bekleyen</option>
						<option value="2" <?php echo ($durum == '2') ? 'selected' : null; ?>>Onaylanan</option>
						<option value="3" <?php echo ($durum == '3') ? 'selected' : null; ?>>İptal Edilen</option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary admin-action" data-action="adminBankaYatirim">Listele</button>
			</div>
		</div>
		</fieldset>
		<hr class="dotted short">
		<!-- #form -->
		
		<!-- <table class="table mb-none">
			<thead>
				<tr>
					<td>Çekim Yöntemi</td>
					<td>Tarih</td>
					<td>Ad Soyad</td>
					<td>Kullanıcı Adı</td>
					<td>Banka Adı</td>
					<td>Kullanıcının Bakiyesi</td>
					<td>Tutar</td>
					<td>İşlem</td>
				</tr>
			</thead>
			<tbody>
				<?php $toplam = 0; foreach ($talep as $talep) { $toplam = $toplam+(int)$talep['miktar']; $kullanici = kullanici($talep['uye']); ?>
				<tr class="durum<?php echo $talep['durum']; ?>">
					<td><?php echo $talep["turu"]; ?></td>
					<td><?php echo date("d/m H:i",strtotime($talep["tarih"])); ?></td>
					<td><?php echo $kullanici['name']; ?></td>
					<td><?php echo $kullanici['username']; ?></td>
					<td><?php echo $talep['banka']; ?></td>
					<td><?php echo $kullanici['bakiye']; ?></td>
					<td><input type="text" disabled class="form-control" value="<?php echo $talep['miktar']; ?>" /></td>
					<td>
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-success admin-action" data-action="adminBankaCekimTalepOnayla" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-check"></i></button>
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminBankaCekimTalepSil" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-remove"></i></button>
						<div class="btn-group">
							<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-plus"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="admin-action modal-with-form" data-action="adminBankaCekimTalepDetay" href="#modalForm" data-id="<?php echo $talep['id']; ?>">Detay</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php } ?>
				<tr style="background: #ccc; color: #fff">
					<td colspan="7">Sayfa genel toplam: </td>
					<td><?php echo mf($toplam); ?> <i class="fa fa-try"></i></td>
				</tr>
			</tbody>
		</table> -->
		
		<table class="table table-bordered mb-none" id="datatable-default">
			<thead>
				<tr class="table_row">
					<td>Id</td>
					<td>Yönetici</td>
					<td>Çekim Yöntemi</td>
					<td>Tarih</td>
					<td>Ad Soyad</td>
					<td>Kullanıcı Adı</td>
					<td>Banka Adı</td>
					<td>Kullanıcının Bakiyesi</td>
					<td>Tutar</td>
					<th>Durum</th>
					<td>İşlem</td>
					
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Id</th>
					<th class="banka">Yönetici</th>
					<th>Çekim Yöntemi</th>
					<th>Tarih</th>
					<th>Ad Soyad</th>
					<th>Kullanıcı Adı</th>
					<th>Banka Adı</th>
					<th>Kullanıcının Bakiyesi</th>
					<th>Tutar</th>
					<th>Durum</th>
					<th>İşlem</th>
				</tr>
			</tfoot>
			<tbody>
				<!--<tr class="gradeX">
					<td>Trident</td>
					<td>Internet
						Explorer 4.0
					</td>
					<td>Win 95+</td>
					<td class="center hidden-phone">4</td>
					<td class="center hidden-phone">X</td>
				</tr> -->
				<?php $toplam = 0; foreach ($rows as $talep) { $toplam = $toplam+(int)$talep['miktar']; $kullanici = kullanici($talep['uye']);
					$logBul = $db->query("SELECT * FROM yonetici_logs WHERE aciklama = '".$talep['id']." numaralı çekimi onayladı.'");
					$log = $logBul->fetch();
				?>
				<tr class="durum<?php echo $talep['durum']; ?>">
					<td><?php echo $talep["id"]; ?></td>
					<td><?php echo (isset($log['id'])) ? db_yonetici($log['yonetici_id'])['name'] : '-'; ?></td>
					<td><?php echo $talep["turu"]; ?></td>
					<td><?php echo date("d/m H:i",strtotime($talep["tarih"])); ?></td>
					<td><?php echo $kullanici['name']; ?></td>
					<td><a href="/profil/<?php echo $kullanici['id']; ?>/" target="_blank" style="color:#fff;"><?php echo $kullanici['username']; ?></a></td>
					<td><?php echo $talep['banka']; ?></td>
					<td><?php echo round($kullanici['bakiye'],2); ?></td>
					<td><?php echo $talep['miktar']; ?></td>
					<td><?php 

					if ($talep['durum'] == 0) { echo "Yeni"; }
					elseif ($talep['durum'] == 1) {	echo "Beklemede"; }
					elseif ($talep['durum'] == 2) { echo "Onaylandı"; }
					elseif ($talep['durum'] == 3) {	echo "İptal Edildi"; }
					elseif ($talep['durum'] == 4) { echo "Hepsi"; }
					?>
						
					</td>
					<td>
						<?php if ($talep['durum'] == 0) { ?>
							<button class="mb-xs mt-xs mr-xs btn btn-xs btn-warning admin-action" data-action="adminBankaCekimTalepBekleyen" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-check"></i></button>
						<?php } else { ?>
							<button class="mb-xs mt-xs mr-xs btn btn-xs btn-success admin-action" data-action="adminBankaCekimTalepOnayla" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-check"></i></button>
						<?php } ?>
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminBankaCekimTalepSil" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-remove"></i></button>
						<div class="btn-group">
							<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-plus"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="admin-action modal-with-form" data-action="adminBankaCekimTalepDetay" href="#modalForm" data-id="<?php echo $talep['id']; ?>">Detay</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="table-money">
			<ul>
				<li>Toplam Tutar: <b style="color: green"><?php echo mf($toplam); ?> ₺</b></li>
				<li>Yöneticinin Onayladığı Toplam Tutar: <b style="color: green"><span class="yoneticiOnayToplam"></span> ₺</b></li>
			</ul>
		</div>
	</div>
</section>
<!-- #Tablo -->