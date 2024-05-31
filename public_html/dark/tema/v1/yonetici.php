<?php if (!@g('ajax') || @g('page')) { ?>
<section role="main">


<header class="page-header">
	<h2><i class="fa fa-user"></i> Yönetici Profil</h2>
</header>

<!-- start: page -->

<div class="row">
	<div class="col-md-4 col-lg-3">

		<section class="panel">
			<div class="panel-body">
				<div class="thumb-info mb-md">
					<img src="/images/logo.png" class="rounded img-responsive" alt="John Doe">
					<div class="thumb-info-title">
						<span class="thumb-info-inner"><?php echo $kullanici['username']; ?></span>
						<span class="thumb-info-type">Üye</span>
					</div>
				</div>

			</div>
		</section>
		
		<?php if(@g('page')) { ?>
		<section class="panel">
			<div class="form-group">
				<button class="btn btn-primary admin-action" data-action="adminGeriDon">Geri Dön</button>
			</div>
		</section>
		<?php } ?>

	</div>
	<div class="col-md-9 col-lg-9">
		<div class="tabs tabs-primary">
			<ul class="nav nav-tabs tabs-primary">
				<li <?php echo (isset($url[2]) == '') ? 'class="active"' : null; ?>>
					<a style="color: #999" href="#overview" data-toggle="tab" class="admin-action" data-action="adminYonetimTab" data-page="/" data-id="<?php echo $url[1]; ?>"><i class="fa fa-user"></i> Profil</a>
				</li>
				<?php if ( limit_kontrol(41) ): ?>
				<li <?php echo (@$url[2] == 'limit') ? 'class="active"' : null; ?>>
					<a style="color: #999" href="#limit" data-toggle="tab" class="admin-action" data-action="adminYonetimTab" data-page="limit" data-id="<?php echo $url[1]; ?>"><i class="fa fa-warning"></i> Limit</a>
				</li>
				<?php endif; ?>
			</ul>
			<div class="tab-content">
<?php } ?>
				<?php
				if (isset($url[2])) {
					call_user_func( 'yonetici_' . $url[2], $kullanici );
				} else {
				?>
				<div id="overview" class="tab-pane active">
					<h4 class="mb-md">Kişisel Bilgiler</h4>
					
					<table class="table">
						<tr>
							<td>Ad Soyad: </td>
							<td><?php echo $kullanici['name']; ?></td>
						</tr>
						<tr>
							<td>Kullanıcı Adı: </td>
							<td><?php echo $kullanici['username'] ?></td>
						</tr>
					</table>
				</div>

				<div id="overview" class="tab-pane active">
					<h4 class="mb-md">Şifre Değiştir</h4>
					
					<form class="yoneticiSifreGuncelleForm">
						<table class="table">
							<tr>
								<td>Yeni Şifre: </td>
								<td><input name="password" class="form-control" type="password" placeholder="**********"></td>
							</tr>
							<tr>
								<td></td>
								<td><button class="btn btn-success admin-action" data-action="adminYonetimSifreGuncelle" data-id="<?php echo $kullanici['id']; ?>"><i class="fa fa-check"></i> Güncelle</button></td>
							</tr>
						</table>
					</form>
				</div>

				<?php } ?>
<?php if (!@g('ajax') || @g('page')) { ?>
			</div>
		</div>
	</div>

</div>
<!-- end: page -->
</section>
<?php } ?>