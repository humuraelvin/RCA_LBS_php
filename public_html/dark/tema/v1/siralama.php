<style type="text/css">
.results {border-top: 1px solid #ddd; padding-top: 10px;}
.results li img {width: auto; height: 300px;}
.results li {width: auto; height: 300px; overflow: hidden; border: 2px solid green; float: left; margin-right: 5px; margin-bottom: 5px;}
</style>

<header class="page-header">
	<h2><i class="fa fa-list"></i> Sıralama</h2>
</header>

<div class="col-md-12">
	<kbd>Listeleme için çift tıklayınız.</kbd>
</div>

<div class="col-md-4">
	<section class="panel panel-success">
		<header class="panel-heading">
			<h2 class="panel-title">Sporlar</h2>
		</header>
		<div class="panel-body">
			<div class="dd" id="nestable">
				<ol class="dd-list" id="sporListesi">
					<!-- <li class="dd-item" data-id="1">
						<div class="dd-handle">Item 1</div>
					</li> -->
					<?php foreach ( $db->query("SELECT * FROM dark_sports WHERE live = 0 ORDER BY listindex ASC")->fetchAll() as $spor ) { ?>
						<li class="dd-item" ondblclick="$.list_getCountry(<?php echo $spor['sportid']; ?>);" data-id="<?php echo $spor['sportid']; ?>">
							<div class="dd-handle"><?php echo $spor['name']; ?></div>
						</li>
					<?php } ?>
				</ol>
			</div>
		</div>
	</section>
</div>

<div class="col-md-4">
	<section class="panel panel-primary">
		<header class="panel-heading">
			<h2 class="panel-title">Ülkeler</h2>
		</header>
		<div class="panel-body ulkeListeBody"></div>
	</section>
</div>

<div class="col-md-4">
	<section class="panel panel-danger">
		<header class="panel-heading">
			<h2 class="panel-title">Ligler</h2>
		</header>
		<div class="panel-body ligListeBody"></div>
	</section>
</div>