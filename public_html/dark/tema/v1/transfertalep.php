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
</style>

<header class="page-header">
	<h2><i class="fa fa-money"></i> Transfer Talep</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<table class="table mb-none">
			<thead>
				<tr>
					<td>No</td>
					<td>Tarih</td>
					<td>Kullanıcı Adı</td>
					<td>Tür</td>
					<td>Şu anki bakiye</td>
					<td>Miktar</td>
					<td>İşlem</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($talep as $talep) { $kullanici = kullanici($talep['userid']); ?>
				<tr>
					<td><?php echo $talep["id"]; ?></td>
					<td><?php echo date("d/m H:i",strtotime($talep["tarih"])); ?></td>
					<td><?php echo $kullanici['username']; ?></td>
					<td><?php echo $talep['tip']; ?></td>
					<td><?php echo $kullanici['bakiye']; ?></td>
					<td><input type="text" disabled class="form-control" value="<?php echo $talep['miktar']; ?>" /></td>
					<td>
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-success admin-action" data-action="adminBankaYatirimTalepOnayla" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-check"></i></button>
						<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminBankaYatirimTalepSil" data-id="<?php echo $talep['id']; ?>"><i class="fa fa-remove"></i></button>
						<div class="btn-group">
							<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-plus"></i> <span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="admin-action modal-with-form" data-action="adminBankaYatirimTalepDetay" href="#modalForm" data-id="<?php echo $talep['id']; ?>">Detay</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>
<!-- #Tablo -->