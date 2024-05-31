<?php

set_time_limit(0);
session_start();

//ob_start("ob_gzhandler");

// error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/html; charset=UTF-8");
ini_set('session.cookie_httponly', 1);
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_MONETARY, 'tr_TR');

$config['db'] = array(
    'host'      => 'localhost',
    'username'  => 'atab_atabet',
    'password'  => 'EDC0301cde*',
    'dbname'    => 'atab_atabet'
);


//HOGAMING
define('HOGAMING_KEY', 'sZHwnSfiyzibet2');
define('HOGAMING_SECRET', '3wqhaRzwjKVtYsiJoFfgs74uJlU2iyzibet2');

//SİTE ADRES
define('SITE_ADRES', 'https://darkoffice.atabet.bet');
define('REDIS_KEY','frz');
define('REDIS_PASSWORD','qpzintpkrkvibne4');




try {

    $db = new PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'], $config['db']['username'], $config['db']['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $db->query("SET CHARACTER SET 'utf8'");
    $db->query("SET NAMES 'utf8'");

    $activeDomain = $db->prepare("SELECT name FROM domain WHERE status = 1");
    $activeDomain->execute();
    $activeDomain = $activeDomain->fetch(PDO::FETCH_ASSOC);

    define('ACTIVE_DOMAIN', $activeDomain['name']);


    $genelAyarlar = $db->prepare("SELECT * FROM ayarlar");
    $genelAyarlar->execute();
    $ayarlar = $genelAyarlar->fetchAll();
    foreach ($ayarlar as $ayar) {
        define("PATH", realpath("."));
        define("URL", SITE_ADRES);
        define("GET_URL", "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."");
        define("TEMA_URL", URL."/tema/".$ayar['site_tema']);
        define("TEMA", PATH."/tema/".$ayar['site_tema']);
        define("SITE_ADI", $ayar['site_adi']);
        define("SITE_URL", SITE_ADRES);
        define("SITE_ACIKLAMA", $ayar['site_aciklama']);
        define("SITE_KELIMELER", $ayar['site_kelimeler']);
        define("SITE_DURUM", $ayar['site_durum']);
        define("SITE_BULTEN", $ayar['site_bulten']);
        define("SITE_BOTYER", $ayar['site_botyer']);
    }

    $GLOBALS["botyer"]="bwin";
    $GLOBALS["mackodu"]="hitit";
    $GLOBALS["kisaad"]="kisaad";
    $GLOBALS["bulten"]="hitit";
    $GLOBALS["canli_kapali"]="0";
    $GLOBALS["canli_kapali_aciklama"]="";

    /* Require Include
    require 'lib/klaspoker.php';
    require 'lib/klasokey.php';
    require 'lib/Tombala.php';
    require 'lib/BetOn.php';
    require 'lib/Xpro.php';
    require 'lib/TLNakit.php';
    require 'lib/LiveGames/src/Api.php';
    require 'lib/VivoAPI.php';
    require 'lib/ezugi.class.php';
    require 'lib/evolution.class.php'; */

} catch (PDOException $e) {
    echo $e->getMessage();
}

?>