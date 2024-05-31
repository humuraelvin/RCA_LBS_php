<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
	table {margin-top: 15px;}
	table.kupon tr {
		background: #F8F8F8;
	}
	table.kupon td {font-weight: bold;}
	table.kupon thead tr th {
		background: #0099E6;
		color: #fff;
		border-right: 1px solid #ddd;
	}
	.table-line {
		width: 100%;
		display: block;
		border: 1px solid #f3f3f3;
		margin: 10px 0 10px 0;
	}
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Kupon Hareketleri</h2>
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
				<button class="btn btn-primary admin-action" data-action="adminKuponHareketleri">Listele</button>
			</div>
		</div>
		
		<table class="table mb-none kupon">
			<thead>
				<tr>
					<th colspan="4" style="text-align: center">Kullanıcı Kupon Hareketleri</th>
				</tr>
				<tr>
					<th>Sıra</th>
					<th>Kullanıcı</th>
					<th>Adet</th>
					<th>Miktar</th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
					<td>1</td>
					<td>idriskhrmn</td>
					<td>10</td>
					<td>100 TL</td>
				</tr> -->
				<?php foreach ($kupon->fetchAll() as $key => $row) { ?>
					<?php if ($row['miktar'] > 0 ) { ?>
						<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo $row['userad']; ?></td>
							<td><?php echo $row['kupon']; ?></td>
							<td><?php echo $row['miktar']; ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		
</div>
</section>
<!-- #Tablo -->