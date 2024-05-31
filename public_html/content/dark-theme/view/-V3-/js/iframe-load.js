$(function() {
	$('#liveTombala_iframe iframe').load(function(e) {
		var css = '<style type="text/css">body{background-color: transparent!important;}section.lg-v2{max-width:1140px;}</style>';
		$('#liveTombala_iframe iframe').contents().find("head").append(css);
		console.log(e);
	});
});