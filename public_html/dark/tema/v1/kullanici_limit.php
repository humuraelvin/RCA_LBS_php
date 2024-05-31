<style type="text/css">
#foo, #bar {width: 100%; list-style: none; background: #fff; border: 1px solid #ddd; padding: 0; margin: 0;}
#foo li, #bar li {
	padding: 10px;
	text-align: center;
	border-bottom: 1px dashed #ccc;
	cursor: move;
}
#bar {
	height: 6000px;
}
</style>
<!-- limit -->
<div id="limit" class="tab-pane active">
	<!-- row -->
	<div class="row">
		<!-- form -->
		<div class="col-md-12">
			<section class="panel panel-featured-default panel-featured">
				<header class="panel-heading">
					<h2 class="panel-title"><i class="fa fa-warning"></i> Kullanıcı Limit</h2>
				</header>
				<div class="panel-body row">
					<div class="col-md-6">
					<ul id="foo" style="height: 6000px">
						<?php foreach (array_diff( $permissions_diff, $user_diff) as $id => $permission) { $permission = $permissions_array[ $permission ]; ?>
							<li data-user-id="<?php echo $kullanici['id']; ?>" data-id="<?php echo $id; ?>"><?php echo $permission; ?></li>
						<?php } ?>
					</ul>
					</div>
					<div class="col-md-6">
					<ul id="bar" style="height: 6000px">
						<?php foreach ( $user_permissions as $permission ) { ?>
							<li data-user-id="<?php echo $kullanici['id']; ?>" data-id="<?php echo $permission['permission_id']; ?>"><?php echo $permission['permission_name']; ?></li>
						<?php } ?>
					</ul>
					</div>
				</div>
			</section>
		</div>
		<!-- #form -->
	</div>
	<!-- #row -->
</div>
<!-- #limit -->