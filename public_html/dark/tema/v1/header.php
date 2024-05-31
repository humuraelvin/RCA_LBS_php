<!-- start: header -->





<header class="header">
	<div class="logo-container">
		<a href="<?php echo SITE_URL; ?>/" class="logo admin-action" data-action="page">
			<img src="https://<?php echo ACTIVE_DOMAIN; ?>/uploads/logo/logo.png" height="36" alt="Porto Admin" />
		</a>
		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<!-- start: search & user box -->
	<div class="header-right">

		<form action="<?php echo SITE_URL; ?>/kullanicilar/" method="POST" class="search nav-form">
			<div class="input-group input-search">
				<input type="hidden" name="sutun" value="name" />
				<input type="text" class="form-control" name="kelime" id="x" placeholder="Kullanıcı arayın.">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>

		<span class="separator"></span>

		<ul class="notifications">
			<li>
				<a href="<?php echo SITE_URL; ?>/yatirmatalep" class="dropdown-toggle notification-icon admin-action" data-action="page" data-toggle="dropdown">
					<i class="fa fa-arrow-up"></i>
					<span class="badge parayatir_toplam">3</span>
				</a>
			</li>
			<li>
				<a href="<?php echo SITE_URL; ?>/cekmetalep" data-action="page" class="admin-action dropdown-toggle notification-icon" data-toggle="dropdown">
					<i class="fa fa-arrow-down"></i>
					<span class="badge paracek_toplam">3</span>
				</a>
			</li>
		</ul>

        <?php if (limit_kontrol(101) ) { ?>
        <span class="separator"></span>
        <ul class="notifications"><li><a href="" class="dropdown-toggle notification-icon admin-action" data-action="cacheClear" data-toggle="dropdown"><i class="fa fa-recycle"></i></a></li></ul>
        <?php } ?>


		<span class="separator"></span>

		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
				</figure>
				<div class="profile-info" >
					<span class="name"><?php echo session('name'); ?></span>
				</div>

				<i class="fa custom-caret"></i>
			</a>

			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1"  href="<?php echo SITE_URL; ?>/yonetici/<?php echo session('id'); ?>"><i class="fa fa-pencil"></i> Şifre</a>
						<a role="menuitem" tabindex="-1" href="<?php echo SITE_URL; ?>/cikis"><i class="fa fa-power-off"></i> Çıkış</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>
<!-- end: header -->