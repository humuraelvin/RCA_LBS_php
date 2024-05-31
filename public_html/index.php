<?php

//var_dump('index');die;
ob_start();
session_start();
if (!function_exists('stripos')) {
    function stripos_clone($haystack, $needle, $offset = 0) {
		return strpos(strtoupper($haystack), strtoupper($needle), $offset);
    }
}

else {
    function stripos_clone($haystack, $needle, $offset = 0) {
		return stripos($haystack, $needle, $offset = 0);
	}
}


if (isset($_SERVER['QUERY_STRING'])) {
    $queryString = strtolower($_SERVER['QUERY_STRING']);
    if (stripos_clone($queryString, '%select%20') OR stripos_clone($queryString, '%20union%20') OR stripos_clone($queryString, 'union/*') OR stripos_clone($queryString, 'c2nyaxb0') OR stripos_clone($queryString, '+union+') OR stripos_clone($queryString, 'http://') OR stripos_clone($queryString, 'https://') OR ( stripos_clone($queryString, 'cmd=') AND ! stripos_clone($queryString, '&cmd')) OR ( stripos_clone($queryString, 'exec') AND ! stripos_clone($queryString, 'execu')) OR stripos_clone($queryString, 'union') OR stripos_clone($queryString, 'concat') OR stripos_clone($queryString, 'ftp://')) {
        die("Blocked");
        exit;
    }
}

set_time_limit(0);
define("BEGIN_TIME", microtime());
define("SYSTEM_FOLDER", "darksystem");
define("CONTENT_FOLDER", "content");
define("CONFIG_FOLDER", "config");
define("DEFAULT_CONTENT", "");
define("BASE_URL", "http://" . $_SERVER["SERVER_NAME"] . "/");
define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
ini_set("display_errors", 0);
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=utf8');
error_reporting(E_ALL);
if (strpos($_SERVER["SERVER_NAME"], "tasarim") !== false) {
    error_reporting(E_ERROR);
    define("DEBUG", "1");
}

if (strpos($_SERVER['HTTP_USER_AGENT'], "ApacheBench") !== false)
exit;

define("DEBUG", "1");
include(DOCUMENT_ROOT . SYSTEM_FOLDER . "/core/main.php");


mysql_close();