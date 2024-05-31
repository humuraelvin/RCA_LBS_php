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
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Bakiye Günlük Raporlar</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2">
				<!-- <select class="form-control" name="kullanici" id="kullanici">
					<option value="0">Tüm Üyeler</option>
					<?php foreach ($kullanicilar as $kullanici_row) { ?>
						<option <?php echo ($kullanici == $kullanici_row['id']) ? 'selected=selected' : null; ?> value="<?php echo $kullanici_row['id']; ?>"><?php echo $kullanici_row['username']; ?></option>
					<?php } ?>
				</select> -->
				<input type="text" class="form-control" id="autoComplete_user" />
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
			<div class="col-md-3">
				<button class="btn btn-primary admin-action" data-action="adminBakiyeRapor">Listele</button>
			</div>
		</div>
		<?php if (@$g[1] == 'detay') { ?>
		<table class="table mb-none">
			<thead>
				<tr>
					<th colspan="2">Yatırılan</th>
					<th colspan="2" style="color: green">Kazanılan</th>
					<th colspan="2" style="color: red;">Kaybedilen</th>
					<th colspan="2">Devam Eden</th>
					<th>Sonuç</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo mf(@$dtoplam); ?> TL</td>
					<td><?php echo @$dtoplams; ?></td>
					<td style="color: green;"><?php echo mf(@$dkazan); ?> TL</td>
					<td style="color: green;"><?php echo @$dkazans; ?></td>
					<td style="color: red;"><?php echo mf(@$dkaybeden); ?> TL</td>
					<td style="color: red;"><?php echo @$dkaybedens; ?></td>
					<td><?php echo mf(@$ddevam); ?> TL</td>
					<td><?php echo @$ddevams; ?></td>
					<td style="color: <?php echo ($dsonuc > 0) ? 'green' : 'red'; ?>"><?php echo mf(@$dsonuc); ?> TL</td>
				</tr>
			</tbody>
		</table>
		
		<div class="table-line"></div>
		<?php } ?>
		
		<table class="table mb-none">
			<thead>
				<tr>
					<?php if (@$g[1] != 'detay') { ?>
						<th>Tarih</th>
					<?php } else { ?>
						<th>Bayi</th>
						<th>Komisyon</th>
					<?php } ?>
					<th colspan="2">Toplam Ödenen</th>
					<th colspan="2">Kazandığı Miktar</th>
					<th colspan="2">Kaybettiği Miktar</th>
					<th colspan="2">İptal Bedeli</th>
					<th>Sonuç</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($detaylar as $key => $detay) { ?>
					<?php
						$renk = ($detay["toplam"]-round($detay["kazan"]["toplam"],2)-$detay["devam"]["toplam"]>0) ? 'color: green;': 'color: red;';
					?>
					<tr>
						<?php if (@$g[1] != "detay") { ?>
							<td><?php echo $detay['tarihz']; ?></td>
						<?php } else { ?>
							<td><?php echo $detay['bayi']; ?></td>
							<td>%<?php echo $detay['komisyon']; ?></td>
							<?php $kom =($detay["komisyon"]*($detay["toplam"]-round($detay["kazan"]["toplam"],2)-$detay["devam"]["toplam"]-$detay["iptal"]["toplam"]))/100; ?>
						<?php } ?>
						<td style="<?php echo $renk; ?>"><?php echo $detay['toplam']; ?> TL</td>
						<td style="<?php echo $renk; ?>border: 1px solid #ddd"><?php echo $detay['kuponsay']; ?></td>
						<td style="<?php echo $renk; ?>"><?php echo round($detay["kazan"]["toplam"],2); ?> TL</td>
						<td style="<?php echo $renk; ?>border: 1px solid #ddd"><?php echo $detay["kazan"]["kuponsay"]; ?></td>
						<td style="<?php echo $renk; ?>"><?php echo $detay['kaybeden']['toplam']; ?> TL</td>
						<td style="<?php echo $renk; ?>border: 1px solid #ddd"><?php echo $detay["kaybeden"]["kuponsay"]; ?></td>
						<td style="<?php echo $renk; ?>"><?php echo $detay['iptal']['toplam']; ?> TL</td>
						<td style="<?php echo $renk; ?>border: 1px solid #ddd"><?php echo $detay["iptal"]["kuponsay"]; ?></td>
						<td style="<?php echo $renk; ?>"><?php echo $detay["toplam"]-round($detay["kazan"]["toplam"],2)-$detay["devam"]["toplam"]; ?> TL</td>
						<?php
							$toplam += $detay["toplam"]-round($detay["kazan"]["toplam"],2)-$detay["devam"]["toplam"];
						?>
					</tr>
				<?php } ?>
				<?php if (@$g[1] == 'detay') { ?>
				<tr>
					<td colspan="3"></td>
					<td colspan="2"><strong>Kalan:</strong></td>
					<td><?php echo $toplam; ?> TL</td>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2"><strong>Kalan (%<?php echo (@$key==0) ? @$detay["komisyon"] : '30'; ?>)</strong></td>
					<td><?php echo ($toplam<0) ? "0" : round($toplam*0.3,2); ?> TL</td>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="2"><strong>Kalan (%<?php echo (@$key == 0) ? 100-@$detay["komisyon"] : '70'; ?>)</strong></td>
					<td><?php echo ($toplam<0) ? "0" : round(($toplam*0.7),2); ?> TL</td>
					<td colspan="5"></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
</div>
</section>
<!-- #Tablo -->