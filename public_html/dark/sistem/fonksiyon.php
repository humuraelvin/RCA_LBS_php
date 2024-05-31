<?php

	function p($par, $st = false){
		if ($st) {
			return htmlspecialchars(stripslashes(strip_tags(trim($_POST[$par]))));
		} else {
			return stripslashes(strip_tags(trim($_POST[$par])));
		}
	}
	
	function g($par) {
		return strip_tags(trim(addslashes($_GET[$par])));
	}
	
	function kisalt($par, $uzunluk = 50) {
		if (strlen($par) > $uzunluk) {
			$par = mb_substr($par, 0, $uzunluk, "UTF-8")."...";
		}
		return $par;
	}
	
	function session_olustur($par) {
		foreach ($par as $anahtar => $deger) {
			$_SESSION[$anahtar] = $deger;
		}
	}

function httpPost($url,$params) {
    $postData = '';
    foreach($params as $k => $v) {
        $postData .= $k . '='.$v.'&';
    }
    rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}
	
	function sef_link($url){
		$url = trim($url);
		$url = strtolower($url);
		$find = array('<b>', '</b>');
		$url = str_replace ($find, '', $url);
		$url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);
		$find = array(' ', '"', '&', '&', '\r\n', '\n', '/', '\\', '+', '<', '>');
		$url = str_replace ($find, '-', $url);
		$find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
		$url = str_replace ($find, 'e', $url);
		$find = array('í', 'ì', 'î', 'ï', 'I', 'Í', 'Ì', 'Î', 'Ï', 'İ', 'ı');
		$url = str_replace ($find, 'i', $url);
		$find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
		$url = str_replace ($find, 'o', $url);
		$find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
		$url = str_replace ($find, 'a', $url);
		$find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
		$url = str_replace ($find, 'u', $url);
		$find = array('ç', 'Ç');
		$url = str_replace ($find, 'c', $url);
		$find = array('Ş', 'ş');
		$url = str_replace ($find, 's', $url);
		$find = array('Ğ', 'ğ');
		$url = str_replace ($find, 'g', $url);
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$url = preg_replace ($find, $repl, $url);
		$url = str_replace ('--', '-', $url);
		return $url;
	}
	
	function session($sessionadi,$degeri = null){
		if(!isset($_SESSION[$sessionadi])){
			if($degeri==null){
				return false;
			}else{
				$_SESSION[$sessionadi] = $degeri;
			}
		}else{
			if($degeri==null){
				return $_SESSION[$sessionadi];
			}else{
				return false;
			}
		}
	}
	
	function ss($par) {
		return stripslashes($par);
	}
	
	function go($par, $time = 0) {
		if ($time == 0) {
			header("Location: {$par}");
		} else {
			header("Refresh: {$time}; url={$par}");
		}
	}
	
	function mf($amount) {
		return number_format($amount, 2);
	}
	
	function timeAgo($date)
	{
		if (strlen($date) == 10) {
			$timestamp = $date;
		} else $timestamp = strtotime($date);
		$currentDate = new DateTime('@' . $timestamp);
		$nowDate = new DateTime('@' . time());
		return $currentDate
			->diff($nowDate)
			->format('%i dakika %s saniye önce');
	}
	
	function oranf($oran,$artis,$artis2=0){
		return mf($oran*1+$artis*1+$artis2*1);
	}

    function GetIP(){
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        return $_SERVER['REMOTE_ADDR'];
    }
	
?>