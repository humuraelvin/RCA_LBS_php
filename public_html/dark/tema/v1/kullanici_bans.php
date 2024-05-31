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
		<div class="col-md-12">
			<div class="col-md-12">
				<h4>Yeni Ekle</h4>
				<div class="form-group">
					<label for="exampleInputEmail1">Not: </label>
					<input type="text" class="form-control" id="not">
				</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<hr class="dotted short">
				<button class="btn btn-success admin-action" data-action="adminKullaniciBan_Ekle" data-id="<?php echo $kullanici['admin_id']; ?>">Kaydet</button>
			</div>
			</div>
		</div>
		</div>
	</fieldset>
	<hr class="dotted short">
	<!-- #form -->
	<!-- table -->
	<table class="table table-bordered mb-none" id="datatable-default">
		<thead>
			<tr class="table_row">
				<th>ID</th>
				<th>Kullanıcı Adı</th>
				<th>Yönetici Adı</th>
				<th>Not</th>
				<th>Tarih</th>
			</tr>
		</thead>
		 <tfoot>
			<tr>
				<th>ID</th>
				<th>Kullanıcı Adı</th>
				<th>Yönetici Adı</th>
				<th>Not</th>
				<th>Tarih</th>
			</tr>
		</tfoot>
		<tbody id="kullaniciBanList">
			<?php foreach ($bans as $ban) { ?>
				<tr data-id="<?php echo $ban['ban_id']; ?>">
					<td><?php echo $ban['ban_id']; ?></td>
					<td><?php echo $kullanici['username']; ?></td>
					<td><?php echo $ban['username']; ?></td>
					<td><?php echo $ban['not']; ?></td>
					<td><?php echo $ban['tarih']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- #table -->
</div>
<!-- #transactions -->