<!-- transactions -->
<div id="transactions" class="tab-pane active">
	<style type="text/css">
		.kullaniciTabHareket {font-weight: bold;}
		.kullaniciTabHareket:hover {
			background-image: -ms-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
			background-image: -moz-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
			background-image: -o-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(100, #CBA96D));
			background-image: -webkit-linear-gradient(top, #A68C6A 0%, #CBA96D 100%);
			background-image: linear-gradient(to bottom, #A68C6A 0%, #CBA96D 100%);
			color: #fff;
			cursor: pointer;
		}
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
	<!-- form -->
	<fieldset>
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
		<div class="col-md-6">
			<div class="form-group">
				<label for="exampleInputEmail1">Canlı: </label>
				<select name="canli" id="canli" class="form-control" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
					<option value="" <?php echo (empty(@p('canli'))) ? 'selected=selected' : null; ?>>Tümü (Canlı / Normal)</option>
					<option value="0" <?php echo (@p('canli') == '0') ? 'selected=selected' : null; ?>>Normal</option>
					<option value="1" <?php echo (@p('canli') == '1') ? 'selected=selected' : null; ?>>Canlı</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<?php if (@$islem_tip != '3') { ?>
			<div class="form-group">
				<label for="exampleInputEmail1">Durum: </label>
				<select name="durum" id="durum" class="form-control" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
					<option value="" <?php echo (empty(@p('durum'))) ? 'selected=selected' : null; ?>>Durum (Tümü)</option>
					<option value="0" <?php echo (@$_POST['durum'] == '0') ? 'selected=selected' : null; ?>>Bekleyen</option>
					<option value="1" <?php echo (@$_POST['durum'] == '1') ? 'selected=selected' : null; ?>>Kazanan</option>
					<option value="2" <?php echo (@$_POST['durum'] == '2') ? 'selected=selected' : null; ?>>Kaybeden</option>
					<option value="3" <?php echo (@$_POST['durum'] == '3') ? 'selected=selected' : null; ?>>İptal</option>
				</select>
			</div>
			<?php } ?>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<hr class="dotted short">
				<button class="btn btn-success admin-action" data-action="adminKullaniciTab_Bahis">Listele</button>
			</div>
		</div>
		</div>
	</fieldset>
	<hr class="dotted short">
	<!-- #form -->
	<!-- table -->
	<table class="table table-bordered table-striped dataTables_wrapper" id="datatable-default">
		<thead>
			<tr class="table_row">
				<th>ID</th>
				<th>Kullanıcı Adı</th>
				<th>Kupon No</th>
				<th>Tarih</th>
				<th>Yatırılan</th>
				<th>Oran</th>
				<th>Max Kazanç</th>
				<th>Maç Adet</th>
				<th>Ödenen</th>
				<th>Sonuç</th>
				<th>Kupon Tür</th>
				<th>Detay</th>
			</tr>
		</thead>
		 <tfoot>
			<tr>
				<th>ID</th>
				<th>Kullanıcı Adı</th>
				<th>Kupon No</th>
				<th>Tarih</th>
				<th>Yatırılan</th>
				<th>Oran</th>
				<th>Max Kazanç</th>
				<th>Maç Adet</th>
				<th>Ödenen</th>
				<th>Sonuç</th>
				<th>Kupon Tür</th>
				<th>Detay</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($kuponlar as $kupon) { $toplam+=$kupon["miktar"]; ?>
				<tr data-id="<?php echo $kupon['id']; ?>">
					<td><?php echo $kupon['id']; ?></td>
					<td><?php echo kullanici($kupon['userid'])['username']; ?></td>
					<td><?php echo $kupon['id']; ?></td>
					<td><?php echo date("d/m H:i",strtotime($kupon["tarih"])) ?></td>
					<td><?php echo mf($kupon['miktar']); ?> <i class="fa fa-try"></i></td>
					<td><?php echo mf($kupon['oran']); ?></td>
					<td><?php echo mf($kupon["oran"]*$kupon["miktar"]); ?> <i class="fa fa-try"></i></td>
					<td><?php echo $kupon["kazanan"]."/".$kupon["toplam"]; ?></td>
					<td><?php echo ($kupon['durum'] == "1") ? mf($kupon["oran"] * $kupon["miktar"]) : '0.00'; ?> <i class="fa fa-try"></i></td>
					<td class="durum <?php echo ($kupon['durum'] == "1") ? 'row-green' : ($kupon['durum'] == "2" ? 'row-red' : null); ?>"><?php echo ($kupon['durum'] == "1") ? 'Kazandı' : ($kupon['durum'] == "2" ? 'Kaybetti' : ($kupon['iptal'] != "1" ? 'Beklemede' : 'Iade Edildi')); ?></td>
					<td><?php echo ($kupon['canli'] == "1") ? 'Canlı Kupon' : 'Normal Kupon'; ?></td>
					<td><a href="#modalForm" class="admin-action modal-with-form" data-action="adminKuponDetay" data-id="<?php echo $kupon['id']; ?>"><i class="fa fa-plus"></i> Detay</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- #table -->
</div>
<!-- #transactions -->