<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
	table {margin-top: 15px;}
	table.kupon tr {
		background: #F8F8F8;
	}
	table.kupon td {font-weight: bold;}
	table.kupon thead tr th {
		background: #E7F6FC;
		color: #333;
		border-right: 1px solid #ddd;
	}
	.table-line {
		width: 100%;
		display: block;
		border: 1px solid #f3f3f3;
		margin: 10px 0 10px 0;
	}
</style>

<?php if (!@p('popup') || @p('popup') == "false") { ?>

<header class="page-header">
	<h2><i class="fa fa-barcode"></i> Finansal İşlemler</h2>
</header>

<?php } ?>

		<!-- secenekler -->
		<div class="row">
			<div class="col-md-0">
				<!-- <select class="form-control" name="kullanici" id="kullanici">
					<option value="0">Tüm Üyeler</option>
					<?php foreach ($kullanicilar as $kullanici_row) { ?>
						<option <?php echo ($kullanici == $kullanici_row['id']) ? 'selected=selected' : null; ?> value="<?php echo $kullanici_row['id']; ?>"><?php echo $kullanici_row['username']; ?></option>
					<?php } ?>
				</select> -->
				<!-- <input type="text" class="form-control" id="autoComplete_user" /> -->
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
			<div class="col-md-2">
				<button class="btn btn-primary admin-action" data-action="adminKuponlar" data-id="<?php echo $kullanici['id']; ?>">Listele</button>
			</div>
		</div>
		<!-- #secenekler -->
		<!-- kuponlar liste -->
		<table class="table mb-none kupon">
			<thead>
				<tr>
					<th>Tarih</th>
					<th>Hareket Tipi</th>
					<th>Önceki Bakiye</th>
					<th>Miktar</th>
					<th>Güncel Bakiye</th>
					<th>Yönetici Notu</th>
					<th>Durum</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($detaylar as $detay) { ?>
					<tr data-id="<?php echo $kupon['id']; ?>">
						<td><?php echo date("d/m H:i",strtotime($detay["tarih"])); ?></td>
						<td>Bahis</td>
						<td><?php echo mf($detay["oncekibakiye"]); ?> <i class="fa fa-try"></i></td>
						<td><?php echo mf($detay["tutar"]); ?> <i class="fa fa-try"></i></td>
						<td><?php echo mf($detay['sonrakibakiye']); ?> <i class="fa fa-try"></i></td>
						<td><?php echo $detay["islemad"]; ?></td>
						<td><?php echo $detay['durum']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- #kuponlar liste -->
		<!-- sayfalama -->
		<nav>
		  <ul class="pagination">
			<?php if ($sayfa > 1) { $onceki = $sayfa - 1; ?>
			<li>
			  <a href="#" aria-label="Previous" class="admin-action" data-action="adminKuponlar" data-sayfa="1">
				<span aria-hidden="true">&laquo; İlk</span>
			  </a>
			</li>
			<?php } ?>
			<?php for ($i = $sayfa - $gorunecek_sayfa; $i < $sayfa + $gorunecek_sayfa + 1; $i++) { ?>
				<?php if ($i > 0 AND $i <= $toplam_sayfa) { ?>
					<?php if($i == $sayfa) { ?>
						<li class="active"><a href="#" class="admin-action" data-action="adminKuponlar" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } else { ?>
						<li><a href="#" class="admin-action" data-action="adminKuponlar" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<li>
			  <a href="#" aria-label="Next" class="admin-action" data-action="adminKuponlar" data-sayfa="<?php echo $toplam_sayfa; ?>">
				<span aria-hidden="true">&raquo; Son</span>
			  </a>
			</li>
		  </ul>
		</nav>
		<!-- #sayfalama -->