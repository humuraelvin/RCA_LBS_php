<style type="text/css">

#foo, #bar {width: 100%; list-style: none; background: #fff; border: 1px solid #ddd; padding: 0; margin: 0;}

#foo li, #bar li {

	padding: 10px;

	text-align: center;

	border-bottom: 1px dashed #ccc;

	cursor: move;

}

#bar li {background: #d3d3d3;border-bottom:2px solid #fff}

#bar {

	height: 1722px;

}

</style>

<header class="page-header">

	<h2><i class="fa fa-plus"></i> Banner Düzenle</h2>

</header>



<section class="panel">

	<div class="panel-body">
		<div class="col-md-12">

			<ul id="foo">

				<?php
					
					$bannerlar = $db->query("SELECT * FROM bannerlar ORDER BY `index` ASC");

					$bannerlar = $bannerlar->fetchAll();
				
					$domain = explode(".", $_SERVER["HTTP_HOST"]);
					$newbeturl = $domain[1].".".$domain[2];
					foreach ( $bannerlar as $b) { ?>

					<li data-id="<?php echo $b['id']; ?>"><img src="http://<?php echo $newbeturl; ?>/<?php echo $b['url']; ?>" width="533" height="200" alt="" /> <button class="btn btn-xs btn-warning admin-action" data-action="adminBannerSil" data-id="<?php echo $b['id']; ?>"><i class="fa fa-remove"></i></button></li>

				<?php }?>

			</ul>

		</div>

	</div>

</section>