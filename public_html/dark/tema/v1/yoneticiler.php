<style type="text/css">
.kullanicilarListe tr:hover {
	background: #D3BB8F;
	color: #fff;
	cursor: pointer;
}
</style>

<header class="page-header">
	<h2><i class="fa fa-users"></i> Yöneticiler</h2>
</header>

<!-- Yönetici Ekle -->
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Yönetici Ekle</h2>
	</header>
	<div class="panel-body">
		<form id="yoneticiEkleForm">
			<fieldset>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Ad Soyad: </label>
							<input type="text" name="name" class="form-control" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Kullanıcı Adı: </label>
							<input type="text" name="username" class="form-control" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Şifre: </label>
							<input type="text" name="password" class="form-control" />
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<hr class="dotted short">
							<button class="btn btn-success admin-action" data-action="adminYoneticiEkle"><i class="fa fa-plus"></i> Ekle</button>
						</div>
					</div>
					<input type="hidden" name="tip" value="adminYoneticiEkle">
				</div>
			</fieldset>
		</form>
	</div>
</section>
<!-- #Yönetici Ekle -->

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<table class="table mb-none">
			<thead>
				<tr>
					<th>#</th>
					<th>Ad Soyad</th>
					<th>Kullanıcı Adı</th>
					<th>Durum</th>
					<th>İşlem</th>
				</tr>
			</thead>
			<tbody class="kullanicilarListe">
				<?php foreach ($kullanicilar->fetchAll(PDO::FETCH_ASSOC) as $kullanici) { ?>
					<tr data-id="<?php echo $kullanici['id']; ?>" class="yoneticiGoruntule">
						<td><?php echo $kullanici['id']; ?></td>
						<td><?php echo $kullanici['name']; ?></td>
						<td>@<?php echo $kullanici['username']; ?></td>
						<td><?php echo ($kullanici['status'] == '0') ? '<code>aktif</code>' : '<code>pasif</code>'; ?></td>
						<td>
							<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminKullaniciSil" data-id="<?php echo $kullanici['id']; ?>"><i class="fa fa-remove"></i></button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
</div>
</section>
<!-- #Tablo -->