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
	.dataTables_filter {display: none}
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Yönetici Hareketleri</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<fieldset>
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
			<div class="col-md-3">
				<button class="btn btn-primary admin-action" data-action="adminBankaYatirim">Listele</button>
			</div>
		</div>
		</fieldset>
		<hr class="dotted short">
		<!-- #form -->
		
		<table class="table table-bordered mb-none playgo-table" id="datatable-default">
			<thead>
				<tr class="table_row">
					<td>ID</td>
					<td>Kullanıcı Adı</td>
					<td>Açıklama</td>
					<td>Tarih</td>
					<td>IP Adresi</td>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td>ID</td>
					<td>Kullanıcı Adı</td>
					<td>Açıklama</td>
					<td>Tarih</td>
					<td>IP Adresi</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($logs->fetchAll() as $log) { ?>
					<tr>
						<td><?php echo $log["id"]; ?></td>
						<td><?php echo $log["username"]; ?></td>
						<td><?php echo $log["aciklama"]; ?></td>
						<td><?php echo $log["tarih"]; ?></td>
						<td><?php echo $log["ip"]; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		
	</div>
</section>
<!-- #Tablo -->