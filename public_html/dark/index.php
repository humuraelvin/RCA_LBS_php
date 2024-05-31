<?php
	define("GUVENLIK", true);

	require_once "sistem/ayar.php";
	require_once "sistem/sistem.php";
	
	if ($ayar["site_durum"] == 1) {
		if (!@g('ajax')) {
			require(TEMA."/index.php");
		} else {
			if (session('admin_oturum')) {
				tema_icerik();
			} else die();
		}
			
	} else {
		echo "offline mode!";
	}
	
?>