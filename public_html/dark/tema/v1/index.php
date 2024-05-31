<!doctype html>
<html class="fixed sidebar-left-collapsed">
	<head>

		<title>Admin Panel</title>
	
		<!-- Basic -->
		<meta charset="UTF-8">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/morris.js/morris.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/chartist/chartist.min.css" />

		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/select2-bootstrap-theme/select2-bootstrap.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/stylesheets/theme.css?v=<?=time();?>" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/stylesheets/easy-autocomplete.min.css" />
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/stylesheets/easy-autocomplete.themes.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/stylesheets/skins/default.css?v=<?=time();?>" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo TEMA_URL; ?>/assets/stylesheets/theme-custom.css">

		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
		
		<!-- uploader css -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link href="https://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css" rel="stylesheet">
		
		<style type="text/css">
		#popup_form {
			width: 100%;
			height: 100%;
			position: fixed;
			top:0;
			left:0;
			background: rgba(0,0,0,.8);
			display: block;
			z-index: 99999;
			overflow: hidden;
			display: none;
		}
		#popup_form .form {
			color: #fff;
			position: absolute;
			top: 10%;
			left: 40%;
			margin: -50px 0px 0px -50px;
		}
		#popup_form .close {
			margin: 10px 15px 0 0;
			color: #fff;
		}
		#popup_form table {
			color: #333;
		}
		.sweet-alert, .sweet-overlay {
			z-index: 999999;
		}
		#modalForm .footer-buttons i {
			color: #fff;
		}
		#modalForm .panel-body h3 {
			margin: 0;
		}
		#loading_bar {
			width: 100%;
			height: 100%;
			position: fixed;
			top:0;
			left:0;
			background: rgba(0,0,0,.8);
			display: block;
			z-index: 9999999999999;
			overflow: hidden;
			display: none;
		}
		#loading_bar .load {
			color: #fff;
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -50px 0px 0px -50px;
		}
		#loading_bar .load i {
			font-size: 70px;
		}
		.table_row {
			color: #555; border: 1px solid #C4C4C4; font-weight: bold; font-size: 12px; padding: 0.6em 1em;
			background-image: -ms-linear-gradient(top, #FFFFFF 0%, #C4C4C4 100%);
			background-image: -moz-linear-gradient(top, #FFFFFF 0%, #C4C4C4 100%);
			background-image: -o-linear-gradient(top, #FFFFFF 0%, #C4C4C4 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(100, #C4C4C4));
			background-image: -webkit-linear-gradient(top, #FFFFFF 0%, #C4C4C4 100%);
			background-image: linear-gradient(to bottom, #FFFFFF 0%, #C4C4C4 100%);
		}
		</style>
		
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery/jquery.js"></script>
		
	</head>
	<body>
	
		<!-- notification -->
		<audio id="notification"><source src="<?php echo SITE_URL; ?>/notification.ogg" type="audio/ogg"><source src="<?php echo SITE_URL; ?>/notification.mp3" type="audio/mpeg"></audio>
		<!-- #notification -->
	
		<!-- loading -->
		<div id="loading_bar">
			<div class="load"><i class="fa fa-spinner fa-spin"></i></div>
		</div>
		<!-- #loading -->
	
		<!-- modalbox -->
		<!-- <a class="modal-with-form btn btn-default" href="#modalForm">Open Form</a> -->

		<!-- Modal Form -->
		<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title"></h2>
				</header>
				<div class="panel-body"></div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right footer-buttons"></div>
					</div>
				</footer>
			</section>
		</div>
		<!-- #modalbox -->
	
		<div id="popup_form">
			<div class="close"><i class="fa fa-close"></i></div>
			<div class="form">
				
			</div>
		</div>
		
		<?php if ( session('admin_oturum') ) { ?>
		
			<section class="body">




				<!-- header -->
					<?php require_once 'header.php'; ?>
				<!-- #header -->

				<div class="inner-wrapper">
				<!-- start: sidebar -->
					<?php require_once 'sidebar.php'; ?>
				<!-- end: sidebar -->
				
				<section role="main" class="content-body">
					<?php tema_icerik(); ?>
				</section>
			</div>

			<!-- start: right sidebar -->
				<?php require_once 'sidebar_right.php'; ?>
			<!-- end: right sidebar -->
			
		</section>

			
		<?php } else { ?>
			<!-- \\ giris \\ -->
				<?php require_once 'giris.php'; ?>
			<!-- // giris // -->
		<?php } ?>
		
		<!-- Head Libs -->
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/modernizr/modernizr.js"></script>
		
		<!-- Vendor -->
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-appear/jquery-appear.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/flot/jquery.flot.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/flot.tooltip/flot.tooltip.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-sparkline/jquery-sparkline.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/raphael/raphael.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/morris.js/morris.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/gauge/gauge.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/snap.svg/snap.svg.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/chartist/chartist.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo TEMA_URL; ?>/assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo TEMA_URL; ?>/assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo TEMA_URL; ?>/assets/javascripts/theme.init.js"></script>
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
		
		<script src="<?php echo TEMA_URL; ?>/assets/javascripts/jquery.easy-autocomplete.min.js"></script>
		
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/javascripts/ui-elements/modals.js"></script>
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/vendor/gauge/gauge.js"></script>
		
		<!-- notify -->
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/vendor/pnotify/pnotify.custom.js"></script>
		
		<!-- table -->
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/javascripts/tables/examples.datatables.ajax.js"></script>
		
		<!-- select -->
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/vendor/select2/js/select2.js"></script>
		
		<!-- input -->
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		
		<!-- sortable -->
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/javascripts/Sortable.js"></script>
		
		<!-- counter -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<script type="text/javascript" src="https://bfintal.github.io/Counter-Up/jquery.counterup.min.js"></script>
		
		<!-- uploader -->
		<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script>
		
		<script type="text/javascript">
		$(function(){
			
		});
		</script>
		
		<script type="text/javascript" src="<?php echo TEMA_URL; ?>/assets/javascripts/admin.mainv1.js?v=<?=time();?>"></script>
		
		<!-- AJAX JS -->
		<script type="text/javascript">
			var SITE_URL = "<?php echo SITE_URL; ?>",
				TEMA_URL = "<?php echo TEMA_URL; ?>",
				SITE_DURUM = "<?php echo SITE_DURUM; ?>";
		</script>
	
	</body>
</html>