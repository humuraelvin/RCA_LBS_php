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
	.list tr:hover {
		background: #D3BB8F;
		color: #fff;
		cursor: pointer;
	}
</style>

<?php if (!@p('popup') || @p('popup') == "false") { ?>

<header class="page-header">
	<h2><i class="fa fa-users"></i> Online</h2>
</header>

<?php } ?>

<section class="panel">
	<div class="panel-body">
	
		<fieldset>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Başlangıç Tarihi: </label>
						<input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d',$baslangic); ?>" name="baslangic">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Bitiş Tarihi: </label>
						<input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d', $bitis); ?>" name="bitis">
					</div>
				</div>
			</div>
			<hr class="dotted short">
			<div class="row">
				<div class="col-md-3">
					<button class="btn btn-primary admin-action" data-action="adminBankaYatirim">Listele</button>
				</div>
			</div>
			<hr class="dotted short">
		</fieldset>
	
		<!-- kullanıcı liste -->
		<table class="table table-bordered mb-none" id="datatable-default">
			<thead>
				<tr class="table_row">
					<th>#</th>
					<th>Kullanıcı Adı</th>
					<th>Tarayıcı</th>
					<th>İşletim Sistemi</th>
					<th>IP Adresi</th>
					<th>Son Aktiflik</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>#</th>
					<th>Kullanıcı Adı</th>
					<th>Tarayıcı</th>
					<th>İşletim Sistemi</th>
					<th>IP Adresi</th>
					<th>Son Aktiflik</th>
				</tr>
			</tfoot>
			<tbody class="list">
				<?php foreach ($online as $kullanici) { ?>
					<tr class="kullaniciGoruntule" data-id="<?php echo $kullanici['admin_id']; ?>">
						<td><?php echo $kullanici['id']; ?></td>
						<td><?php echo $kullanici['username']; ?></td>
						<td><?php echo $kullanici['browser']; ?></td>
						<td><?php echo $kullanici['os']; ?></td>
						<td><?php echo $kullanici['ip']; ?></td>
						<td><?php echo date('d/m/Y H:i', $kullanici['last_active']); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- #kullanıcı liste -->
	
	</div>
</section>