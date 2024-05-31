<style type="text/css">
.kullanicilarListe tr:hover {
	background: #D3BB8F;
	color: #fff;
	cursor: pointer;
}
</style>

<header class="page-header">
	<h2><i class="fa fa-users"></i> Kullanıcılar</h2>
</header>

<!-- Tablo -->
<section class="panel">
	<header class="panel-heading">

		<h2 class="panel-title">Liste</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-10">
				<input type="text" id="kullaniciAra" value="<?php echo (@p('kelime')) ? p('kelime') : null; ?>" class="form-control" placeholder="Aramak için enter basınız." />
			</div>
			<div class="col-md-2">
				<select name="column" id="column" class="form-control">
					<option value="username">Kullanıcı Adı</option>
					<option value="name">Ad Soyad</option>
					<option value="tc">TC</option>
					<option value="telefon">Telefon</option>
				</select>
			</div>
		</div>
		<table class="table mb-none">
			<thead>
				<tr>
					<th>#</th>
					<th>TC</th>
					<th>Ad - Soyad</th>
					<th>Telefon</th>
					<th>Kayıt Tarihi</th>
					<th>Doğum Tarihi</th>
					<th>Kullanıcı Adı</th>
					<th>Bakiye</th>
					<th>Durum</th>
                   <?php if ( $functionName == 'bayiler' ) { ?>
					<th>Düzenle</th>
                   <?php } ?>
				</tr>
			</thead>
			<tbody class="kullanicilarListe">
				<?php foreach ($kullanicilar->fetchAll(PDO::FETCH_ASSOC) as $kullanici) { ?>
					<tr data-id="<?php echo $kullanici['id']; ?>" class="kullaniciGoruntule" style="font-weight: bold;font-size: 14px;">
						<td><?php echo $kullanici['id']; ?></td>
						<td><?php echo $kullanici['tc']; ?></td>
						<td><?php echo $kullanici['name']; ?></td>
						<td>

                            <?php
                            if ( limit_kontrol( 86 ) ) {
                                echo $kullanici['telefon'];
                            } else { echo "5********"; };
                            ?>


                        </td>
						<td><?php echo $kullanici['kayit_tarih']; ?></td>
						<td><?php echo $kullanici['dt']; ?></td>
						<td><button type="button" class="mb-xs mt-xs mr-xs btn btn-default"><i class="fa fa-user"></i> <?php echo $kullanici['username']; ?></button></td>




						<td><?php echo mf($kullanici['bakiye']); ?> <i class="fa fa-try"></i></td>
						<td><?php echo ($kullanici['durum'] == '0') ? '<i class="fa fa-circle" style="color: green"></i>' : '<i class="fa fa-circle" style="color: red"></i> '; ?></td>

							<?php if ( $functionName == 'bayiler' ) {
                                $bayialtuye = $db->prepare("SELECT id, affiliateid FROM admin WHERE affiliateid = ?");
                                $bayialtuye->execute([$kullanici['id']]);
                           ?>
                                <td><a href="<?php echo SITE_URL; ?>/profil/<?php echo $kullanici['id']; ?>/bayiler" class="btn btn-primary"><i class="fa fa-users"></i> Alt Üyeler <b>(<?php echo $bayialtuye->rowCount(); ?>)</b></a></td>
							<?php } ?>


					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- sayfalama -->
		<nav>
		  <ul class="pagination">
			<?php if ($sayfa > 1) { $onceki = $sayfa - 1; ?>
			<li>
			  <a href="#" aria-label="Previous" class="admin-action" data-action="adminKullanicilar" data-sayfa="1">
				<span aria-hidden="true">&laquo; İlk</span>
			  </a>
			</li>
			<?php } ?>
			<?php for ($i = $sayfa - $gorunecek_sayfa; $i < $sayfa + $gorunecek_sayfa + 1; $i++) { ?>
				<?php if ($i > 0 AND $i <= $toplam_sayfa) { ?>
					<?php if($i == $sayfa) { ?>
						<li class="active"><a href="#" class="admin-action" data-action="adminKullanicilar" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } else { ?>
						<li><a href="#" class="admin-action" data-action="adminKullanicilar" data-sayfa="<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<li>
			  <a href="#" aria-label="Next" class="admin-action" data-action="adminKullanicilar" data-sayfa="<?php echo $toplam_sayfa; ?>">
				<span aria-hidden="true">&raquo; Son</span>
			  </a>
			</li>
		  </ul>
		</nav>
		<!-- #sayfalama -->
</div>
</section>
<!-- #Tablo -->
