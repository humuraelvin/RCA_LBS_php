<style type="text/css">
.results {border-top: 1px solid #ddd; padding-top: 10px;}
.results li img {width: auto; height: 300px;}
.results li {width: auto; height: 300px; overflow: hidden; border: 2px solid green; float: left; margin-right: 5px; margin-bottom: 5px;}
</style>

<header class="page-header">
	<h2><i class="fa fa-plus"></i> Duyuru Yönetim</h2>
</header>

<section class="panel">
	<div class="panel-body">
		<!-- form -->
		<form id="duyuruEkleForm">
			<fieldset>
				<div class="row">
					<div class="col-md-12 form-group">
						<h3 class="control-label" for="profileFirstName">Yeni Duyuru: </h3>
						<input type="text" name="icerik" class="form-control" />
					</div>
					<div class="col-md-12 form-group">
						<h3 class="control-label" for="profileFirstName">Durum: </h3>
						<select name="aktif" id="aktif" class="form-control">
							<option value="1">Aktif</option>
							<option value="0">Pasif</option>
						</select>
						<code>not: eğer aktif olursa diğer duyuru pasif olacaktır.</code>
					</div>
					<div class="form-group col-md-12">
						<button class="btn btn-success admin-action" data-action="adminDuyuruEkle"><i class="fa fa-plus"></i> Ekle</button>
					</div>
				</div>
			</fieldset>
		</form>
		<!-- #form -->
		
		<hr />
		
		<table class="table table-bordered mb-none">
			<tr>
				<td>ID</td>
				<td>İçerik</td>
				<td>Durum</td>
				<td>İşlem</td>
			</tr>
			<tbody class="duyuruListe">
				<?php foreach ( $db->query('SELECT * FROM duyuru')->fetchAll() as $duyuru ) { ?>
				<tr duyuru-id="<?php echo $duyuru['id']; ?>">
					<td><?php echo $duyuru['id']; ?></td>
					<td><?php echo $duyuru['icerik']; ?></td>
					<td>
						<select class="form-control duyuruDuzenle" name="aktif" id="aktif">
							<option value="1" <?php echo ($duyuru['aktif'] == '1') ? 'selected' : null; ?> data-id="<?php echo $duyuru['id']; ?>">Aktif</option>
							<option value="0" <?php echo ($duyuru['aktif'] == '0') ? 'selected' : null; ?> data-id="<?php echo $duyuru['id']; ?>">Pasif</option>
						</select>
					</td>
					<td>
						<button class="btn btn-danger btn-xs admin-action" data-action="adminDuyuruSil" data-id="<?php echo $duyuru['id']; ?>"><i class="fa fa-remove"></i></button>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</section>