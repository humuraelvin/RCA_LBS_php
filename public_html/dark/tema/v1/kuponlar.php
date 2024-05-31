<style type="text/css">
    .row-red {
        background-color: #ae1b24;
        background-image: -webkit-linear-gradient(top,#AE1B24,#600013)!important;
        background-image: -moz-linear-gradient(top,#AE1B24,#600013)!important;
        background-image: -ms-linear-gradient(top,#AE1B24,#600013)!important;
        background-image: -o-linear-gradient(top,#AE1B24,#600013)!important;
        background-image: linear-gradient(90deg,#AE1B24,#600013)!important;
        color:#fff;
        text-align: center;
    }
	.row-green {
        background: #159904;
        background-image: -webkit-linear-gradient(top,#159904,#3C732E)!important;
        background-image: -moz-linear-gradient(top,#159904,#3C732E)!important;
        background-image: -ms-linear-gradient(top,#159904,#3C732E)!important;
        background-image: -o-linear-gradient(top,#159904,#3C732E)!important;
        background-image: linear-gradient(90deg,#159904,#3C732E)!important;
        color:#fff;
        text-align: center;
    }
	.row-gray {
        background: #555;
        background-image: -webkit-linear-gradient(top,#555,#333)!important;
        background-image: -moz-linear-gradient(top,#555,#333)!important;
        background-image: -ms-linear-gradient(top,#555,#333)!important;
        background-image: -o-linear-gradient(top,#555,#333)!important;
        background-image: linear-gradient(90deg,#555,#333)!important;
        color: #fff;
        text-align: center;
    }
    .row-orange {
        background: #ffb432;
        background-image: -webkit-linear-gradient(top,#ffb432,#77360d)!important;
        background-image: -moz-linear-gradient(top,#ffb432,#77360d)!important;
        background-image: -ms-linear-gradient(top,#ffb432,#77360d)!important;
        background-image: -o-linear-gradient(top,#ffb432,#77360d)!important;
        background-image: linear-gradient(90deg,#ffb432,#77360d)!important;
        color:#fff;
        text-align: center;
    }
	.row-active {background:#000; color: #fff}
	.row-active a {
		color: #fff;
	}
	table tr {
		background: #F8F8F8;
	}
	.kullaniciTabHareket:hover{background: rgba(70,140,0,.5); color: #fff; cursor: pointer;}
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
	.dataTables_filter {display: none;}
</style>

<?php if (!@p('popup') || @p('popup') == "false") { ?>

<header class="page-header">
	<h2><i class="fa fa-barcode"></i> Kuponlar</h2>
</header>

<?php } ?>

		<!-- secenekler -->
		<div class="row">
			<div class="col-md-2">
				<input type="text" class="form-control" id="autoComplete_kupon" />
				<input type="hidden" name="kullanici" id="kullanici" value="<?php echo (!empty($kullanici)) ? $kullanici : 0; ?>" />
			</div>
			<div class="col-md-4">
				<div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-plugin-datepicker="">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" class="form-control datepicker" value="<?php echo $baslangic; ?>" name="baslangic">
					<span class="input-group-addon">-</span>
					<input type="text" class="form-control datepicker" value="<?php echo $bitis; ?>" name="bitis">
				</div>
			</div>
			<div class="col-md-2">
				<select name="canli" id="canli" class="form-control">
					<option value="" <?php echo (empty(@p('canli'))) ? 'selected=selected' : null; ?>>Tümü (Canlı / Normal)</option>
					<option value="0" <?php echo (@p('canli') == '0') ? 'selected=selected' : null; ?>>Normal</option>
					<option value="1" <?php echo (@p('canli') == '1') ? 'selected=selected' : null; ?>>Canlı</option>
				</select>
			</div>
			<div class="col-md-2">
				<select name="durum" id="durum" class="form-control">
					<option value="" <?php echo (empty(@p('durum'))) ? 'selected=selected' : null; ?>>Durum (Tümü)</option>
					<option value="0" <?php echo (@$_POST['durum'] == '0') ? 'selected=selected' : null; ?>>Bekleyen</option>
					<option value="1" <?php echo (@$_POST['durum'] == '1') ? 'selected=selected' : null; ?>>Kazanan</option>
					<option value="2" <?php echo (@$_POST['durum'] == '2') ? 'selected=selected' : null; ?>>Kaybeden</option>
					<option value="3" <?php echo (@$_POST['durum'] == '3') ? 'selected=selected' : null; ?>>İade</option>
				</select>
			</div>
			<div class="col-md-2">
				<button class="btn btn-primary admin-action" data-action="adminKuponlar">Listele</button>
			</div>
		</div>
		<!-- #secenekler -->
		<hr class="dotted short">
		<!-- kuponlar liste -->
		<table class="table mb-none kupon" id="datatable-default">
			<thead>
				<tr>
					<td>Kupon No</td>
					<td>Hesap</td>
					<td>Saat</td>
					<td>Yatırılan</td>
					<td>Oran</td>
					<td>Max Kazanç</td>
					<td>Maç Adet</td>
					<td>Ödenen</td>
					<td>Sonuç</td>
					<td>Kupon Tür</td>
					<td style="display: none">İşlem</td>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Kupon No</th>
					<th>Hesap</th>
					<th>Saat</th>
					<th>Yatırılan</th>
					<th>Oran</th>
					<th>Max Kazanç</th>
					<th>Maç Adet</th>
					<th>Ödenen</th>
					<th>Sonuç</th>
					<th>Kupon Tür</th>
					<th style="display: none">İşlem</th>
				</tr>
			</tfoot>
			<tbody>
				<?php
					$kazanan_toplam = 0;
					$bekleyen_toplam = 0;
					$kaybeden_toplam = 0;
					$iade_toplam = 0;
					$iade_kupon = 0;
				foreach ($kuponlar as $kupon) { $toplam+=$kupon["miktar"]; ?>
					<?php
						if ($kupon['durum'] == '1') {
							$kazanan_toplam+=$kupon['miktar'];
						} else if ($kupon['durum'] == '2') {
							$kaybeden_toplam+=$kupon['miktar'];
						} else if ($kupon['iptal'] != '1') {
							$bekleyen_toplam+= $kupon['miktar'];
						} else {
							$iade_toplam += $kupon['miktar'];
							$iade_kupon++;
						}
					?>
					<tr style="height: 25px !important;" data-id="<?php echo $kupon['id']; ?>">
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo $kupon['id']; ?></td>
						<td><a href="/profil/<?php echo $kupon['userid'] ?>"><?php echo kullanici($kupon['userid'])['username']; ?></a></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo date("H:i",strtotime($kupon["tarih"])) ?></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo mf($kupon['miktar']); ?> <i  class="fa fa-try"></i></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo mf($kupon['oran']); ?></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo mf($kupon["oran"]*$kupon["miktar"]); ?> <i class="fa fa-try"></i></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo $kupon["kazanan"]."/".$kupon["toplam"]; ?></td>
						<td class="admin-action modal-with-form dropdown-toggle" href="#modalForm" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><?php echo ($kupon['durum'] == "1") ? mf($kupon["oran"] * $kupon["miktar"]) : '0.00'; ?> <i class="fa fa-try"></i></td>
						<td class="durum <?php echo ($kupon['durum'] == "1") ? 'row-green' : ( ($kupon['durum'] == "2") ? 'row-red' : ( ($kupon['durum'] == "3") ? 'row-gray' : 'row-orange' ) ); ?>">
                            <?php echo ($kupon['durum'] == "1") ? 'Kazandı' : ($kupon['durum'] == "2" ? 'Kaybetti' : ($kupon['durum'] == "3" ? 'Iade' : ($kupon['durum'] == "0" ? 'Beklemede' : '')  )); ?></td>
						<td><?php echo ($kupon['canli'] == "1") ? 'Canlı' : 'Normal'; ?></td>
							<td style="display: none">
							<div class="btn-group">
							<a href="#modalForm" style="line-height: 5px" class="admin-action modal-with-form mb-xs mt-xs mr-xs btn btn-xs btn-default dropdown-toggle" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>">
							<span style="font-weight: bold;font-size: 14px;">+</span> Detay
							</a>
							</div></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		