<style type="text/css">
	.row-red {background: red; color: #fff}
	.row-green {background: green; color: #fff}
	table {margin-top: 15px;}
	table.kullanicilar tr {
		background: #F8F8F8;
	}
	table.kullanicilar td {font-weight: bold;}
	table.kullanicilar thead tr th {
		background: #E7F6FC;
		color: #333;
		border-right: 1px solid #ddd;
	}
	.table-line {
		width: 100%;
		display: block;
		border: 1px solid #f3f3f3;
		margin: 10px 0 10px 0;
	}
</style>

<?php if (!@p('popup') || @p('popup') == "false") { ?>

<header class="page-header">
	<h2><i class="fa fa-users"></i> Online</h2>
</header>

<?php } ?>



<div id="edit" class="tab-pane active">

<?php 
$usern =  $kullanici['username']; 

$bulmkuyesini = $db->query("SELECT * FROM admin  WHERE username = '$usern' ORDER BY id DESC")->fetchAll();

$uyeid =  $bulmkuyesini[0]['id'];

$bulmkbonusunu = $db->query("SELECT * FROM uye_bonuslar  WHERE uye = '$uyeid' ORDER BY id DESC")->fetchAll();

?>


<div class="row">
	<!-- durum -->
	<div class="col-md-12">
		<section class="panel panel-featured-danger panel-featured">
			<header class="panel-heading">
				<h2 class="panel-title">Bonus Bilgileri</h2>
			</header>
			<div class="panel-body">
		

			<table class="table mb-none kullanicilar">
				<thead>
					<tr>
						<th>Kullanıcı Id</th>
						<th>Bonus</th>
						<th>Eklenme Tarihi</th>		
						<th>İşlem</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach ($bulmkbonusunu as $kullanici) { ?>
					<tr data-id="<?php echo $kullanici['id']; ?>">
						<td><?php echo $kullanici['uye']; ?>  </td>
						<td><?php  
						$promos = $kullanici['bonus']; 
						$prosbul = $db->query("SELECT * FROM bonuslar WHERE id = '$promos' ORDER BY id DESC")->fetchAll();
						echo $prosbul[0]['bonusadi'];
						?></td>				
						<td><?php echo $kullanici['tarih']; ?></td>
						<td>					
							<button class="mb-xs mt-xs mr-xs btn btn-xs btn-danger admin-action" data-action="adminPromosSil" data-id="<?php echo $kullanici['id']; ?>"><i class="fa fa-remove"></i></button>

						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>


			</div>
		</section>
	</div>
	<!-- #durum -->
</div>
<!-- #row -->
</div>