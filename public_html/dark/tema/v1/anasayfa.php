
<header class="page-header">
	<h2>Anasayfa</h2>
</header>

<!-- start: page -->
<div class="row">

	<?php if ( $duyuru->show == 'true' ) { ?>
	<div class="col-md-12 col-lg-12 col-xl-12">
		<section class="panel panel-featured-left">
			<div class="panel-body">
				<div class="widget-summary">
					<div class="widget-summary-col widget-summary-col-icon">
						<div class="summary-icon bg-primary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
							<i class="fa fa-info"></i>
						</div>
					</div>
					<div class="widget-summary-col">
						<div class="summary">
							<span class="text-primary" style="font-weight: bold">DUYURU!</span>
							<div class="info">
								<strong class="amount" style="font-size: 14px;">
									<ul>
									<?php foreach ($duyuru->annotations as $annotation) { ?>
										<li><?php echo $annotation; ?></li>
									<?php } ?>
									</ul>
								</strong>
							</div>
						</div>
						<div class="summary-footer">
							<a class="text-muted text-uppercase">Son Guncelleme: <?php echo $duyuru->date; ?></a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<?php } ?>
    <?php if ( limit_kontrol(85) ): ?>
	<div class="col-md-12 col-lg-12 col-xl-12">
		<div class="row">
			<!-- <div class="col-md-12 col-lg-3 col-xl-3">
				<section class="panel panel-featured-left panel-featured-primary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-try"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-primary">Bahis Tutarı (toplam)</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['bakiye']; ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div> -->
			<div class="col-md-12 col-lg-3 col-xl-3">
				<section class="panel panel-featured-left panel-featured-warning">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-warning" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-try"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-warning">Bahis Tutarı (bugun)</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['toppara']; ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="/kuponlar/">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-3 col-xl-3">
				<section class="panel panel-featured-left panel-featured-secondary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-secondary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-try"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-secondary">Bekleyen (bugun)</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['bekleyen_para']; ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="/kuponlar/">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-3 col-xl-3">
				<section class="panel panel-featured-left panel-featured-tertiary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-tertiary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-try"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-tertiary">Kazanan Tutarı (bugun)</span>
									<div class="info">
										<strong class="amount"><?php echo mf($rowIstatislikler['kazanan_para']); ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="/kuponlar/">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-3 col-xl-3">
				<section class="panel panel-featured-left panel-featured-quartenary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-quartenary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-try"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-quartenary">Kaybeden Tutarı (bugun)</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['kaybeden_para']; ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="/kuponlar/">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-12 col-xl-12">
				<section class="panel panel-featured-left panel-featured-secondary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-secondary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-user"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-secondary">Üye (bugun)</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['toplam_uye_bugun']; ?></strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase" href="/kullanicilar/">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

    <?php endif; ?>
	<div class="col-md-6 col-lg-12 col-xl-6">
		<div class="row">
			<!-- <div class="col-md-12 col-lg-6 col-xl-6">
				<section class="panel panel-featured-left panel-featured-primary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary" style="font-size: 12px; width: 32px; height: 32px; line-height: 32px;">
									<i class="fa fa-arrow-up"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<span class="text-primary">Para Çekim</span>
									<div class="info">
										<strong class="amount"><?php echo $rowIstatislikler['paracek_miktar']; ?> TL</strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(Ayrıntı görüntüle)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div> -->
		</div>
	</div>
</div>

<?php if ( !limit_kontrol(85) ) { $darkstyle = 'style="display:none;"'; } ?>

<div class="row" <?php echo $darkstyle; ?> >
<!-- chart finans -->
	<div class="col-md-6">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
				</div>

				<h2 class="panel-title">Finans (Günlük)</h2>
				<p class="panel-subtitle">Para yatırım işlemlerini burada detaylı görüntüleyebilirsiniz.</p>
			</header>

			<div class="panel-body" >
				<div class="row text-center">
					<div class="col-md-6">
						<div class="gauge-chart">
							<canvas id="gaugeBasic_yatirim" width="180" height="110" data-plugin-options="{ &quot;value&quot;: <?php echo $rowIstatislikler['parayatir_miktar']; ?>, &quot;maxValue&quot;: <?php echo $rowIstatislikler['parayatir_miktar']; ?> }"></canvas>
							<strong>YATIRIM</strong>
							<label id="gaugeBasicTextfield_yatirim">0</label> <i class="fa fa-try"></i>
						</div>
					</div>
					<div class="col-md-6">
						<div class="gauge-chart">
							<canvas id="gaugeAlternative_cekim" width="180" height="110" data-plugin-options="{ &quot;value&quot;: <?php echo $rowIstatislikler['paracek_miktar']; ?>, &quot;maxValue&quot;: <?php echo $rowIstatislikler['paracek_miktar']; ?> }"></canvas>
							<strong>ÇEKİM</strong>
							<label id="gaugeAlternativeTextfield_cekim">0</label> <i class="fa fa-try"></i>
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>
	<!-- #chart finans -->
	<!-- chart genel -->
	<div class="col-md-6" >
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
				</div>

				<h2 class="panel-title">Genel</h2>
				<p class="panel-subtitle">Toplam üye bilgilerini burada görebilirsiniz.</p>
			</header>
			<div class="panel-body">
				<div class="row text-center">
					<div class="col-md-6">
						<div class="gauge-chart">
							<canvas id="gaugeBasic_members" width="180" height="110" data-plugin-options="{ &quot;value&quot;: <?php echo $rowIstatislikler['toplam_uye']; ?>, &quot;maxValue&quot;: <?php echo $rowIstatislikler['toplam_uye']; ?> }"></canvas>
							<strong>TOPLAM ÜYE</strong>
							<label id="gaugeBasicTextfield_members">0</label> <i class="fa fa-user"></i>
						</div>
					</div>
					<div class="col-md-6">
						<div class="gauge-chart">
							<canvas id="gaugeAlternative_amount" width="180" height="110" data-plugin-options="{ &quot;value&quot;: <?php echo $rowIstatislikler['bakiye']; ?>, &quot;maxValue&quot;: <?php echo $rowIstatislikler['bakiye']; ?> }"></canvas>
							<strong>TOPLAM BAKİYE</strong>
							<label id="gaugeAlternativeTextfield_amount">0</label> <i class="fa fa-try"></i>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- #chart genel -->
</div>

<div class="row"  <?php echo $darkstyle; ?>>
	<div class="col-md-12">
		<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
			</div>

			<h2 class="panel-title">Kupon Grafik</h2>
			<p class="panel-subtitle">Burada belirli zaman aralığında ki grafiği görebilirsiniz.</p>
		</header>
		<div class="panel-body">

			<!-- Morris: Line -->
			<div class="chart chart-md" id="morrisLine"></div>
			<script type="text/javascript">
				var morrisLineData = <?php echo $grafikArray; ?>;
			</script>

		</div>
		<div class="panel-footer">
			<!-- zaman araligi -->
			<form id="kuponGrafikForm">
				<div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-plugin-datepicker="">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" class="form-control datepicker" name="baslangic">
					<span class="input-group-addon">to</span>
					<input type="text" class="form-control datepicker" name="bitis">
				</div>
				<div>
					<button class="mb-xs mt-xs mr-xs btn btn-primary admin-action" data-action="adminKuponGrafik">Görüntüle</button>
				</div>
			</div>
			<!-- #zaman araligi -->
		</section>
	</div>
</div>


<!-- end: page -->