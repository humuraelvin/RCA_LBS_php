<?php
    $baglan = new PDO("mysql:host=localhost;dbname=atab_atabet;charset=utf8", "atab_atabet", "EDC0301cde*");
    $baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $baglan->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$baglan->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>