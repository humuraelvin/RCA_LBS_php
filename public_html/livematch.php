<?php

function arrayToXml($data, $xml) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $childNode = $xml->addChild($key);
            arrayToXml($value, $childNode);
        } else {
            $xml->addChild($key, htmlspecialchars($value));
        }
    }
}

$site = json_decode(file_get_contents("https://forbet777.com/livematch.php"));
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Maclar></Maclar>');

foreach ($site->liveEvents as $live) {

$oyunid = isset($live->event->id) ? $live->event->id : 0;
$oyundurum = isset($live->event->state) ? $live->event->state : 'Unknown';
$awayName = isset($live->event->awayName) ? $live->event->awayName : 'Unknown';
$homeName = isset($live->event->homeName) ? $live->event->homeName : 'Unknown';
$baslangic = isset($live->event->start) ? $live->event->start : 'Unknown';
$dakika = isset($live->liveData->matchClock->minute) ? $live->liveData->matchClock->minute : 0;
$saniye = isset($live->liveData->matchClock->second) ? $live->liveData->matchClock->second : 0;
$oynuyormu = isset($live->liveData->matchClock->running) ? $live->liveData->matchClock->running : 0;
$periyot = isset($live->liveData->matchClock->period) ? $live->liveData->matchClock->period : 0;
$skorhome = isset($live->liveData->score->home) ? $live->liveData->score->home : 0;
$skoraway = isset($live->liveData->score->away) ? $live->liveData->score->away : 0;
$skor = $skorhome . "-" . $skoraway;
$sporadi = isset($live->event->path[0]->name) ? $live->event->path[0]->name : 'Unknown';
$ligid = isset($live->event->groupId) ? $live->event->groupId : 0;
$ligisim = isset($live->event->group) ? $live->event->group : 'Unknown';
$ulkeisim = isset($live->event->path[1]->name) ? $live->event->path[1]->name : 'Unknown';
$ulkeid = isset($live->event->path[1]->id) ? $live->event->path[1]->id : 0;
$ulkeslug = isset($live->event->path[1]->termKey) ? $live->event->path[1]->termKey : 'Unknown';
$oranadet = isset($live->event->liveBoCount) ? $live->event->liveBoCount : 0;
$sport = isset($live->event->sport) ? $live->event->sport : 'Unknown';

/*
"1" => "Futbol",
"88" => "Basketbol",
"352" => "Buz Hokeyi",
"351" => "Tenis",
"356" => "Voleybol",
"353" => "Hentbol",
"354" => "Snooker",
"355" => "Kriket",
"357" => "Ragbi",
"358" => "Salon Futbolu",
"359" => "Amerikan Futbolu",
"360" => "Badminton",
"361" => "Masa Tenisi",
"362" => "Plaj Voleybolu",
"363" => "Beyzbol",
"364" => "E-Sports",
"365" => "Bowls",
"366" => "Squash",
"367" => "Dart",
"401" => "FIFA VR",
"402" => "NBA2K VR",
"403" => "Rocket League",
"404" => "Football VR",
"405" => "Basketball VR",
*/

switch ($sport) {
case 'FOOTBALL':
$sportid = 1;
break;
case 'BASKETBALL':
$sportid = 88;
break;
case 'VOLLEYBALL':
$sportid = 356;
break;
case 'TENNIS':
$sportid = 351;
break;
case 'BASEBALL':
$sportid = 363;
break;
case 'TABLE_TENNIS':
$sportid = 361;
break;
default:
$sportid = 9999;
break;
}

$matchData = [
"id" => (int)$oyunid,
"sportid" => (int)$sportid,
"skor" => $skor,
"baslangic" => $baslangic,
"dakika" => $dakika,
"sure_detay" => $periyot,
"oynuyormu" => (int)$oynuyormu,
"aktifmi" => (int)1,
"ulke" => $ulkeisim,
"ulke_id" => $ulkeid,
"lig" => $ligisim,
"lig_id" => $ligid,
"oran_adet" => (int)$oranadet,
"tip" => $sporadi,
"tur" =>$sporadi,
"evsahibi_isim" => $homeName,
"misafir_isim" => $awayName
];


$macNode = $xml->addChild('Mac', ' ');
foreach ($matchData as $key => $value) {
$macNode->addAttribute($key, htmlspecialchars($value));
}

}

header('Content-Type: text/xml');
echo $xml->asXML();

?>