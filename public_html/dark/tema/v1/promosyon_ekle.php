<?php
	$domain = explode(".", $_SERVER["HTTP_HOST"]);
	$newbeturl = $domain[1].".".$domain[2];
?>

<style type="text/css">
ul li {list-style: none}
.results {border-top: 1px solid #ddd; padding-top: 10px;}
.results li img {height: 300px;}
.results li {padding-bottom: 10px; width: 2000px; height: auto; overflow: hidden; float: left; margin-right: 5px; margin-bottom: 10px; border-bottom: 3px solid #ddd}
.results .promotionUploadImage {}
.results .promotionUploadTitle {width: 400px;}
.l {float: left;}
.right {margin-left: 10px;}
.l > button {margin-top: 38px; margin-left: 10px}

.promotion-list li {
	width: 700px;
	height: 300px;
	overflow: hidden;
	position: relative;
	float: left;
}

.promotion-list li img {
	width: 700px;
	height: 300px
}

.promotion-list li .title {
	position: absolute;
	top: 0;
	height: 0;
	background: rgba(0,0,0,.6);
	width: 700px;
	height: 300px;
	color: #fff;
	text-align: center;
	opacity: 0.0;
	
	 -webkit-transition: all 500ms ease-in-out;
    -moz-transition: all 500ms ease-in-out;
    -ms-transition: all 500ms ease-in-out;
    -o-transition: all 500ms ease-in-out;
    transition: all 500ms ease-in-out;
}

.title h4 {
	padding:0;margin:100px 0 20px 0
	
}

.promotion-list li:hover .title {
	 opacity: 1.0;
}

.not-active {
	border-bottom: 10px solid #f1f1f1;
	padding-bottom: 10px;
	margin-bottom: 10px !important;
}

.promotion-list {
	border: 1px solid #ddd
}
</style>

<header class="page-header">
	<h2><i class="fa fa-list"></i> Promosyonlar</h2>
</header>

<section class="panel">
	<div class="panel-body">
		<h3><i class="fa fa-plus"></i> Promosyon Ekle</h3>
		<hr class="dotted short">
		<!-- upload -->
			<div id="fileuploader">Upload</div>
		<!-- #upload -->
		<!-- results -->
			<div class="results">
				<ul>
					<!-- <li> ornek temp
						<div class="left l">
							<div class="promotionUploadImage">
								<img src="https://s-media-cache-ak0.pinimg.com/originals/7d/cb/e2/7dcbe2597bd4205c48bd3d032764ab71.jpg" alt="" />
							</div>
						</div>
						<div class="right l">
							<div class="promotionUploadTitle">
								<h5>Başlık: </h5>
								<input type="text" class="form-control" />
							</div>
							<div class="promotionUploadTitle">
								<h5>İçerik: </h5>
								<textarea class="form-control" name="" id="" cols="30" rows="8"></textarea>
							</div>
						</div>
						<div class="l">
							<button class="btn btn-success">İşlemi Tamamla</button>
						</div>
						<div style="clear: both"></div>
					</li> -->
				</ul>
			</div>
		<!-- #results -->
	</div>
</section>

<!-- form -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myLargeModalLabel"></h4>
		</div>
		<form id="adminPromosyonGuncelleForm">
		<div class="modal-body">
			<h4>Başlık: </h4>
			<input name="baslik" class="form-control form-title" type="text" />
			<h4>İçerik: </h4>
			<textarea name="icerik" cols="30" rows="10" class="form-control form-content"></textarea>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success admin-action" data-action="adminPromosyonGuncelle" data-id="" >Güncelle</button>
		</div>
		</form>
	</div>
  </div>
</div>
<!-- #form -->


<section class="panel">
	<div class="panel-body">
		<h3><i class="fa fa-list"></i> Promosyonlar</h3>
		<hr class="dotted short">
		
		<ul class="promotion-list active" id="foo" style="height: 2000px">
			<?php foreach ($promosyonlar as $promosyon) { if ($promosyon['sira'] != '0') { ?>
			<li data-id="<?php echo $promosyon['id']; ?>">
				<img src="http://<?php echo $newbeturl;?><?php echo $promosyon['resim']; ?>" alt="" />
				<div class="title">
					<h4><?php echo $promosyon['baslik']; ?></h4>
					<a href="#" class="btn btn-primary admin-action" data-action="adminPromosyonPencere" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="<?php echo $promosyon['id']; ?>"><i class="fa fa-pencil"></i></a>
					<a href="#" class="btn btn-danger admin-action" data-action="adminPromosyonSil" data-id="<?php echo $promosyon['id']; ?>"><i class="fa fa-remove"></i></a>
				</div>
			</li>
			<?php } } ?>
			<div style="clear: both">
		</ul>
	</div>
</section>