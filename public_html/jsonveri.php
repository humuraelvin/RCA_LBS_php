<?php
    //PHP İle RESTful API Kullanımı
    $token = sha1(md5("mehmet"));
    //$veriler = array("token" => $token, "id" => "1");
    //$veriler = array("token" => $token, "adsoyad" => "Ali Veli", "tckimlik" => "999999", "adres" => "Alanya - Antalya");
    //$veriler = array("token" => $token, "adsoyad" => "Zehra Selim", "tckimlik" => "000000", "adres" => "Buca - İzmir", "id" => "2");
    $type = $_REQUEST['type'];
    $veriler = array("token" => $token, "has_lobby" => $type != 'live' ? "0" : "1");
    $curl = curl_init("https://atabet.bet/webapi.php");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); //GET, POST, PUT, DELETE
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($veriler));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $cevap = curl_exec($curl);
    curl_close($curl);

	header('Content-Type: application/json; charset=utf-8');
    
	echo $cevap;
    
?>