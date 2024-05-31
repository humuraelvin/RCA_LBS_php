<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Bakiye Özet</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<select name="filtre" class="form-control" id="filtre">
					<option <?php echo ($filtre == '1') ? 'selected=selected' : null; ?> value="1">Tüm İşlemler</option>
					<option <?php echo ($filtre == '2') ? 'selected=selected' : null; ?> value="2">Para Yatırma</option>
					<option <?php echo ($filtre == '3') ? 'selected=selected' : null; ?> value="3">Para Çekme</option>
				</select>
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
			<div class="col-md-3">
				<button class="btn btn-primary admin-action" data-action="adminBakiyeListele">Listele</button>
			</div>
		</div>
		<table class="table mb-none">
			<thead>
				<tr>
					<th>#</th>
					<th>Kullanıcı</th>
					<th>Tarih</th>
					<th>İşlem</th>
					<th>Kalan Bakiye</th>
					<th>Tutar</th>
				</tr>
			</thead>
			<tbody class="bakiyeListe">
				<!-- <tr style="background-color: red; color: #fff">
					<td>1</td>
					<td>idriskhrmn</td>
					<td>00:12 19/06</td>
					<td>21 Nolu Kupon Yatırma Ücreti!</td>
					<td>75.00 TL</td>
					<td>-5.00 TL</td>
				</tr> -->
				<?php foreach ($detaylar as $detay) { // userid ?>
					<tr class="<?php echo ( explode('-', $detay['tutar'])[1] ) ? 'row-red' : 'row-green'; ?>">
						<td><?php echo $detay['id']; ?></td>
						<td><a href="/profil/<?php echo $detay['userid']; ?>/" target="_blank" style="color:#fff;"><?php echo $detay['ad']; ?></a></td>
						<td><?php echo date("H:i d/m", strtotime($detay["tarih"])); ?></td>
						<td><?php echo $detay['islemad']; ?></td>
						<td><?php echo mf($detay['sonrakibakiye']); ?></td>
						<td><?php echo mf($detay['tutar']); ?> TL</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- sayfalama -->
		<nav>
		  <ul class="pagination">
			<?php if ($sayfa > 1) { $onceki = $sayfa - 1; ?>
			<li>
			  <a href="#" aria-label="Previous" class="admin-action" data-action="adminBakiyeListele" data-sayfa="1">
				<span aria-hidden="true">&laquo; İlk</span>
			  </a>
			</li>
			<?php } ?>
			<?php for ($i = $sayfa - $gorunecek_sayfa; $i < $sayfa + $gorunecek_sayfa + 1; $i++) { ?>
				<?php if ($i > 0 AND $i <= $toplam_sayfa) { ?>
					<?php if($i == $sayfa) { ?>
						<li class="active"><a href="#" class="admin-action" data-action="adminBakiyeListele" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } else { ?>
						<li><a href="#" class="admin-action" data-action="adminBakiyeListele" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<li>
			  <a href="#" aria-label="Next" class="admin-action" data-action="adminBakiyeListele" data-sayfa="<?php echo $toplam_sayfa; ?>">
				<span aria-hidden="true">&raquo; Son</span>
			  </a>
			</li>
		  </ul>
		</nav>
		<!-- #sayfalama -->
</div>
</section>
<!-- #Tablo -->