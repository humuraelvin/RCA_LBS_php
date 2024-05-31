<!-- transactions -->
<div id="transactions" class="tab-pane active">

	<!-- form -->
	<fieldset>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="exampleInputEmail1">İşlem Tipi: </label>
					<select class="form-control" name="islem_tip" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
						<option value="1" <?php echo @$islem_tip == '1' ? 'selected' : null; ?>>Para Yatırma</option>
						<option value="2" <?php echo @$islem_tip == '2' ? 'selected' : null; ?>>Para Çekim</option>
						<option value="3" <?php echo @$islem_tip == '3' ? 'selected' : null; ?>>Hesap Hareketleri</option>
					</select>
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
					<?php if (@$islem_tip != '3') { ?>
						<option value="Havale" <?php echo ($tur == 'Havale') ? 'selected' : null; ?>>Havale</option>
						<option value="CepBank" <?php echo ($tur == 'Cep Bank') ? 'selected' : null; ?>>Cep Bank</option>
						<option value="AstroPay" <?php echo ($tur == 'AstroPay') ? 'selected' : null; ?>>AstroPay</option>
						<option value="TL Nakit" <?php echo ($tur == 'TL Nakit') ? 'selected' : null; ?>>TL Nakit</option>
						<option value="ECOPAYZ" <?php echo ($tur == 'ECOPAYZ') ? 'selected' : null; ?>>ECOPAYZ</option><option value="Bocash">Bocash</option>
					<?php } else { ?>
						<option value="Para Yatırma" <?php echo ($tur == '1') ? 'selected' : null; ?>>Para Yatırma</option>
						<option value="Para Çekme" <?php echo ($tur == '2') ? 'selected' : null; ?>>Para Çekim</option>
						<option value="Beton Games" <?php echo ($tur == '3') ? 'selected' : null; ?>>Beton Games</option>
						<option value="Poker" <?php echo ($tur == '4') ? 'selected' : null; ?>>Poker</option>
						<option value="Transfer" <?php echo ($tur == '5') ? 'selected' : null; ?>>Transfer</option>
						<option value="Bakiye" <?php echo ($tur == '6') ? 'selected' : null; ?>>Bakiye</option>
						<option value="Kupon" <?php echo ($tur == '7') ? 'selected' : null; ?>>Kupon</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<?php if (@$islem_tip != '3') { ?>
			<div class="form-group">
				<label for="exampleInputEmail1">Sorgu Tipi: </label>
				<select class="form-control" name="durum" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
					<option value="3" <?php echo ($durum == '3') ? 'selected' : null; ?>>Hepsi</option>
					<option value="0" <?php echo ($durum == '0') ? 'selected' : null; ?>>Bekleyen</option>
					<option value="1" <?php echo ($durum == '1') ? 'selected' : null; ?>>Onaylanan</option>
					<option value="2" <?php echo ($durum == '2') ? 'selected' : null; ?>>İptal Edilen</option>
				</select>
			</div>
			<?php } ?>
		</div>
		<div class="col-md-12">
			<button class="btn btn-success admin-action" data-action="adminKullaniciTab_Hareketler">Listele</button>
		</div>
		</div>
	</fieldset>
	<hr class="dotted short">
	<!-- #form -->
	<!-- table -->
	<table class="table table-bordered table-striped dataTables_wrapper" id="datatable-default">
		<thead>
			<tr class="table_row">
				<?php if (@$islem_tip != '3') { ?>
					<?php if (@$islem_tip != '3') { ?>
						<th>ID</th>
						<th>Tarih</th>
						<th>Tip</th>
						<th>Banka</th>
						<th>Miktar</th>
						<th>Güncel Bakiye</th>
						<?php if (@$islem_tip == '1') { ?>
							<th>Bonus</th>
						<?php } ?>
						<th>Müşteri Kodu</th>
						<th>Müşteri İsmi</th>
					<?php } else { ?>
						<th>ID</th>
						<th>Tarih</th>
						<th>İşlem</th>
						<th>Tutar</th>
						<th>Güncel Bakiye</th>
						<?php if (@$islem_tip == '1') { ?>
							<th>Bonus</th>
						<?php } ?>
						<th>Müşteri Kodu</th>
						<th>Müşteri İsmi</th>
					<?php } ?>
				<?php } else { ?>
					<th>ID</th>
					<th>Tarih</th>
					<th>Açıklama</th>
					<th>Bakiye</th>
					<th>Miktar</th>
					<th>Son Bakiye</th>
				<?php } ?>
			</tr>
		</thead>
		 <tfoot>
			<tr>
				<?php if (@$islem_tip != '3') { ?>
					<?php if (@$islem_tip != '3') { ?>
						<th>ID</th>
						<th>Tarih</th>
						<th>Tip</th>
						<th>Banka</th>
						<th>Miktar</th>
						<th>Güncel Bakiye</th>
						<?php if (@$islem_tip == '1') { ?>
							<th>Bonus</th>
						<?php } ?>
						<th>Müşteri Kodu</th>
						<th>Müşteri İsmi</th>
					<?php } else { ?>
						<th>ID</th>
						<th>Tarih</th>
						<th>İşlem</th>
						<th>Tutar</th>
						<th>Güncel Bakiye</th>
						<?php if (@$islem_tip == '1') { ?>
							<th>Bonus</th>
						<?php } ?>
						<th>Müşteri Kodu</th>
						<th>Müşteri İsmi</th>
					<?php } ?>
				<?php } else { ?>
					<th>ID</th>
					<th>Tarih</th>
					<th>Açıklama</th>
					<th>Bakiye</th>
					<th>Miktar</th>
					<th>Son Bakiye</th>
				<?php } ?>
			</tr>
		</tfoot>
		<tbody>
			<?php $toplam = 0; ?>
			<?php if (@$islem_tip != '3') { ?>
				<?php foreach ($talep as $talep) { $toplam = $toplam+(int)$talep['miktar']; $k = kullanici($talep['uye']); ?>
					<tr class="durum<?php echo $talep['durum']; ?>">
						<td><?php echo $talep['id']; ?></td>
						<td><?php echo date("d/m H:i",strtotime($talep["tarih"])); ?></td>
						<td><?php echo ($islem_tip == '1') ? $talep["tur"] : $talep["turu"]; ?></td>
						<td><?php echo $talep['banka']; ?></td>
						<td><?php echo $talep['miktar']; ?></td>
						<td><?php echo $k['bakiye']; ?></td>
						<?php if (@$islem_tip == '1') { ?>
							<th><?php echo $talep['bonusadi']; ?></th>
						<?php } ?>
						<td><?php echo $k['id']; ?></td>
						<td><?php echo $k['name']; ?></td>
					</tr>
				<?php } ?>
			<?php } else { foreach ($talep as $talep) { $toplam = $toplam+(int)$talep['tutar']; $k = kullanici($talep['userid']); ?>
				<tr>
					<td><?php echo $talep['id']; ?></td>
					<td><?php echo date("d/m H:i",strtotime($talep["tarih"])); ?></td>
					<td><?php echo $talep['islemad']; ?></td>
					<td><?php echo $talep['oncekibakiye']; ?></td>
					<td><?php echo $talep['tutar']; ?></td>
					<td><?php echo $talep['sonrakibakiye']; ?></td>
				</tr>
			<?php } } ?>
		</tbody>
	</table>
	<!-- #table -->
</div>
<!-- #transactions -->