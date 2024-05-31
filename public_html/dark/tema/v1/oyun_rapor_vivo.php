<style type="text/css">

	.row-red {background: red; color: #fff}

	.row-green {background: green; color: #fff}

	table.table-bordered tr {

		background: #2c3e50;
		color: #fff;

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

</style>



<header class="page-header">

	<h2><i class="fa fa-money"></i> (Oyun) Vivo Raporlar</h2>

</header>



<!-- Tablo -->

<section class="panel">

	<header class="panel-heading">



		<h2 class="panel-title">Liste</h2>

	</header>

	<div class="panel-body">

		<!-- form -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input placeholder="Kullanıcı arayın." type="text" class="form-control" id="autoComplete_user" />
					<input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" />
				</div>
			</div>
		</div>

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

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<select name="tur" id="tur" class="form-control">
						<option value="0">Hepsi</option>
						<option value="1">Yatirim</option>
						<option value="2">Cekim</option>
					</select>
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

		<!-- #form -->

		

		<table class="table table-bordered mb-none playgo-table" id="datatable-default">

			<thead>

				<tr class="table_row">

					<td>#</td>
					<td>UYE</td>
					<td>RUMUZ</td>
					<td>MIKTAR</td>
					<td>ISLEM</td>
					<td>TARIH</td>
					<td>-</td>

				</tr>

			</thead>

			<tfoot>

				<tr>

					<td>#</td>
					<td>UYE</td>
					<td>RUMUZ</td>
					<td>MIKTAR</td>
					<td>ISLEM</td>
					<td>TARIH</td>
					<td>-</td>

				</tr>

			</tfoot>

			<tbody>

				<?php foreach ($raporlar as $rapor) {

					$tur = ( @p('tur') == '1' ) ? 'Ana Bakiye ->' : 'Vivo ->';

					$kullanici = kullanici( $rapor['userid'] );

					//
					$game = $db->query("SELECT * FROM vivo_users WHERE mid = '".$rapor['userid']."'");
					$game = $game->fetch();

					$renk = (isset(explode('Ana Bakiye ->', $rapor['islemad'])[1])) ? '1' : '2';

					//print_r( $game );

					if ( isset(explode($tur, $rapor['islemad'])[1]) || @p('tur') == '0') {

				?>

					<tr class="durum<?php echo $renk; ?>">

						<td><?php echo $rapor['id']; ?></td>
						<td><?php echo $kullanici['username']; ?></td>
						<td><?php echo $game['username']; ?></td>
						<td><?php echo number_format($rapor['tutar'], 2, ',', ','); ?></td>
						<td><?php echo (isset(explode('Ana Bakiye ->', $rapor['islemad'])[1])) ? 'Yatirim' : 'Cekim'; ?></td>
						<td><?php echo $rapor['tarih']; ?></td>

						<td>

							<a class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo (empty($kullanici['id'])) ? 'onclick="alert(\'Kullanici Mevcut Degil\'); return false;"' : null; ?> href="<?php echo SITE_URL; ?>/profil/<?php echo $kullanici['id']; ?>/"><i class="fa fa-user"></i></a>

						</td>

					</tr>

					<?php } ?>

				<?php } ?>

			</tbody>

		</table>

		

	</div>

</section>

<!-- #Tablo -->