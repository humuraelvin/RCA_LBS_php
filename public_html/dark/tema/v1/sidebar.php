<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

<div class="sidebar-header">
	<div class="sidebar-title">
		Hızlı Menü
	</div>
	<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
		<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
	</div>
</div>

<div class="nano">
	<div class="nano-content">
		<nav id="menu" class="nav-main" role="navigation">
			<ul class="nav nav-main">
				<li>
					<a href="<?php echo SITE_URL; ?>" class="admin-action" data-action="page">
						<i class="fa fa-home" aria-hidden="true"></i>
						<span>Anasayfa</span>
					</a>
				</li>
				<?php if ( limit_kontrol(49) ): ?>
				<li class="nav-parent"> <!-- nav-active -->
					<a>
						<i class="fa fa-user" aria-hidden="true"></i>
						<span>Hesaplar</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="<?php echo SITE_URL; ?>/kullanicilar" class="admin-action" data-action="page">
                                <i class="fa fa-user" aria-hidden="true"></i>Kullanıcılar
							</a>
						</li>
						<li>
							<a href="<?php echo SITE_URL; ?>/bakiye_durumu" class="admin-action" data-action="page">
                                <i class="fa fa-money" aria-hidden="true"></i>Üye Bakiye Durumları
							</a>
						</li>
                        <li>
                            <a class="admin-action" data-action="page" href="<?php echo SITE_URL; ?>/bayiler">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span>Bayiler </span>
                            </a>
                        </li>
                        <li>                                <?php if ( limit_kontrol(51) ): ?>
                                <a class="admin-action" data-action="page" href="<?php echo SITE_URL; ?>/bahis_yogunlugu">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span>Nowa Felek</span>
                                </a>
                                <?php endif; ?>
                        </li>
					</ul>
				</li>

                <?php endif; ?>



					<?php if ( limit_kontrol(50) ): ?>

                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span>Kuponlar</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="<?php echo SITE_URL; ?>/kuponlar" class="admin-action" data-action="page">
                                    <i class="fa fa-tasks"></i> Kuponlar
                                </a>
                                <a href="<?php echo SITE_URL; ?>/kupon_sonucla" class="admin-action" data-action="page">
                                    <i class="fa fa-tasks"></i> Kupon Bahisler
                                </a>
                            </li>
                        </ul>
                    </li>
					<?php endif; ?>

                
                <?php if ( limit_kontrol(100) ): ?>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-futbol-o" aria-hidden="true"></i>
                            <span>Sportsbook</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="<?php echo SITE_URL; ?>/sportsLimit" >
                                    <i class="fa fa-futbol-o"></i> Spor Limitlendirme
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>/countryLimit" >
                                    <i class="fa fa-futbol-o"></i> Ülke Limitlendirme
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>/leagueLimit" >
                                    <i class="fa fa-futbol-o"></i> Lig Limitlendirme
                                </a>
                            </li>
                            <?php if ( limit_kontrol(83) ): ?>
                                <li>
                                    <a class="admin-action" data-action="page" href="<?php echo SITE_URL; ?>/siralama">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                        <span>Sıralama Yönetim </span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>



				<?php if ( limit_kontrol(53) ) : ?>
				<li class="nav-parent">
					<a>
						<i class="fa fa-credit-card" aria-hidden="true"></i>
						<span>Banka İşlemleri</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="<?php echo SITE_URL; ?>/yatirmatalep" class="admin-action" data-action="page">
								<i class="fa fa-try"></i> Yatırım İşlemleri
							</a>
							<a href="<?php echo SITE_URL; ?>/cekmetalep" class="admin-action" data-action="page">
								<i class="fa fa-try"></i> Çekim İşlemleri
							</a>

                            <?php if ( limit_kontrol(68) ) : ?>
                            <a href="<?php echo SITE_URL; ?>/banka_hesaplari" class="admin-action" data-action="page">
                                <i class="fa fa-bank"></i> Banka Hesapları
                            </a>
                            <a href="<?php echo SITE_URL; ?>/banka_ekle" class="admin-action" data-action="page">
                                <i class="fa fa-plus-circle"></i> Banka Ekle
                            </a>
                            <?php endif; ?>

						</li>
					</ul>
				</li>
				<?php endif; ?>




				<?php if ( limit_kontrol(54) ) : ?>
				<li class="nav-parent">
					<a>
						<i class="fa fa-unlock-alt" aria-hidden="true"></i>
						<span>Güvenlik</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="<?php echo SITE_URL; ?>/online" class="admin-action" data-action="page">
								 <i class="fa fa-users"></i> Giriş Logları
							</a>
						</li>
						<li>
							<a href="<?php echo SITE_URL; ?>/kullanici_yakala" class="admin-action" data-action="page">
								 <i class="fa fa-info"></i> (IP) Kullanıcı Yakala!
							</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>
				<?php if ( limit_kontrol(55) ) : ?>
				<li class="nav-parent">
					<a>
						<i class="fa fa-bar-chart" aria-hidden="true"></i>
						<span>Rapor</span>
					</a>
                    <ul class="nav nav-children">

                        <li>
                            <a href="<?php echo SITE_URL; ?>/genel_rapor" class="admin-action" data-action="page">
                                <i class="fa fa-pie-chart"></i> Genel Rapor
                            </a>
                        </li>
                        <!-- -->
                        <li>
                            <a href="<?php echo SITE_URL; ?>/detailedReport" class="admin-action" data-action="page">
                                <i class="fa fa-signal"></i> Detaylı Rapor
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo SITE_URL; ?>/bakiye_ozet/1" class="admin-action" data-action="page">
                                <i class="fa fa-list"></i>  Hesap Özetleri
                            </a>
                        </li>

                        <!-- # -->
                    </ul>
				</li>
				<?php endif; ?>
			


				<?php if ( limit_kontrol(57) ): ?>
				<li class="nav-parent">
					<a>
						<i class="fa fa-upload" aria-hidden="true"></i>
						<span>Banner Yönetim </span>
					</a>
					<ul class="nav nav-children">
						<li>
                            <?php if ( limit_kontrol(74) ): ?>
                            <a href="<?php echo SITE_URL; ?>/promosyon_ekle" class="admin-action" data-action="page">
                                <i class="fa fa-file-image-o"></i> Promosyon Ekle
                            </a>
                            <?php endif; ?>
							<a href="<?php echo SITE_URL; ?>/banner_ekle" class="admin-action" data-action="page">
								<i class="fa fa-file-image-o"></i> Banner Ekle
							</a>
							<a href="<?php echo SITE_URL; ?>/banner_duzenle" class="admin-action" data-action="page">
								<i class="fa fa-pencil-square-o"></i> Banner Düzenle
							</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>

                <?php if ( limit_kontrol(63) ): ?>
                    <li>
                        <a class="admin-action" data-action="page" href="<?php echo SITE_URL; ?>/bonuslar">
                            <i class="fa fa-gift" aria-hidden="true"></i>
                            <span>Bonus Yönetim </span>
                        </a>
                    </li>
                <?php endif; ?>

				<?php if ( limit_kontrol(79) ): ?>
				<li>
					<a class="admin-action" data-action="page" href="<?php echo SITE_URL; ?>/duyurular">
						<i class="fa fa-bullhorn" aria-hidden="true"></i>
						<span>Duyuru Yönetim</span>
					</a>
				</li>
				<?php endif; ?>

                <?php if ( limit_kontrol(99) ): ?>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-cubes" aria-hidden="true"></i>
                            <span>Site Ayarları</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="<?php echo SITE_URL; ?>/sitesettings" class="admin-action" data-action="page">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <span>Site Ayarları</span>
                                </a>
                                <?php if ( limit_kontrol(84) ): ?>
                                <a href="<?php echo SITE_URL; ?>/domainler" class="admin-action" data-action="page">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <span>Domain Yönetimi</span>
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo SITE_URL; ?>/settings" class="admin-action" data-action="page">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <span>Canlı Bot Ayarları</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
				<?php if ( limit_kontrol(58) ): ?>
				<li class="nav-parent">
					<a>
						<i class="fa fa-user-secret" aria-hidden="true"></i>
						<span>Yönetim</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="<?php echo SITE_URL; ?>/yoneticiler" class="admin-action" data-action="page">
								<i class="fa fa-user-secret" aria-hidden="true"></i>
								<span>Yöneticiler</span>
							</a>
							<a href="<?php echo SITE_URL; ?>/yonetici_hareketleri" class="admin-action" data-action="page">
								<i class="fa fa-industry" aria-hidden="true"></i>
								<span>Loglar</span>
							</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>

			</ul>
		</nav>
	</div>

	<script>
		// Preserve Scroll Position
		if (typeof localStorage !== 'undefined') {
			if (localStorage.getItem('sidebar-left-position') !== null) {
				var initialPosition = localStorage.getItem('sidebar-left-position'),
					sidebarLeft = document.querySelector('#sidebar-left .nano-content');
				
				sidebarLeft.scrollTop = initialPosition;
			}
		}
	</script>

</div>

</aside>
<!-- end: sidebar -->