<style type="text/css">
.bonusListe tr:hover {
	background: #D3BB8F;
	color: #fff;
	cursor: pointer;
}
</style>

<header class="page-header">
	<h2><i class="fa fa-users"></i> Bonuslar</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Liste <button class="btn btn-success btn-xs admin-action" data-action="adminYeniBonusEkleForm">Yeni Ekle</button></h2>
	</header>
	<div class="panel-body">
		<table class="table mb-none">
			<thead>
				<tr>
					<th>#</th>
					<th>Bonus Başlık</th>
					<th>Yüzde</th>
					<th>İşlem</th>
				</tr>
			</thead>
			<tbody class="bonusListe">
				<?php foreach ( $bonuslar as $bonus ) { ?>
					<tr data-id="<?php echo $bonus['id']; ?>">
						<td><?php echo $bonus['id']; ?></td>
						<td><?php echo $bonus['bonusadi']; ?></td>
						<td><?php echo $bonus['yuzde']; ?></td>
						<td><button class="btn btn-danger btn-xs admin-action" data-action="adminBonusSil" data-id="<?php echo $bonus['id']; ?>"><i class="fa fa-remove"></i></button></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
</div>
</section>
<!-- #Tablo -->