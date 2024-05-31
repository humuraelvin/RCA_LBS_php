<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function arrayToXml($data, $xml = null) {
    if ($xml === null){
        $xml = new SimpleXMLElement('<root/>');
    }
    
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $childNode = $xml->addChild($key);
            arrayToXml($value, $childNode);
        } else {
            $xml->addAttribute($key, htmlspecialchars($value));
        }
    }
    
    return $xml;
}



$zaman = time();

$now = new DateTime('now', new DateTimeZone('Europe/Istanbul')); // Türkiye saati için

$after12Hours = clone $now;
$after12Hours->modify('+24 hours');

$from = $now->format('Ymd\THisO');
$to = $after12Hours->format('Ymd\THisO');

$from = str_replace('+', '%2B', $from);
$to = str_replace('+', '%2B', $to);

$site = json_decode(file_get_contents("https://forbet777.com/prematchtr.php"));


$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Data></Data>');


foreach ($site->events as $events) {
$eventid = $events->event->id;

$botid = $eventid;
$pluskod = $eventid;
$hitit_kod = $eventid;
$baslangic = $events->event->start;
$evsahibi_isim = $events->event->homeName;
$misafir_isim = $events->event->awayName;
$lig_isim = $events->event->group;
$lig_id = $events->event->groupId;
$ulke_isim = $events->event->path[1]->name;
$countrySlug = $events->event->path[1]->termKey;
$ulke_id = $events->event->path[1]->id;
$ligresim = 0;
$mackodu = $botid;
$istatistik = 0;
$id = $eventid;
$oran_adet = $events->event->nonLiveBoCount;
$tur = $events->event->path[0]->name;
$sport = $events->event->sport;

switch ($sport) {
case 'FOOTBALL':
$sportid = 0;
break;
case 'BASKETBALL':
$sportid = 12;
break;
case 'VOLLEYBALL':
$sportid = 19;
break;
case 'TENNIS':
$sportid = 4;
break;
case 'BASEBALL':
$sportid = 13;
break;
case 'TABLE_TENNIS':
$sportid = 34;
break;
default:
$sportid = 9999;
break;
}

$tip = $sportid;

$betOffers = $events->betOffers[0]->outcomes;

if (count($betOffers) == 3) {
$oran1 = $betOffers[0]->odds / 1000;
$oran0 = $betOffers[1]->odds / 1000;
$oran2 = $betOffers[2]->odds / 1000;
} elseif (count($betOffers) == 2) {
$oran1 = $betOffers[0]->odds / 1000;
$oran2 = $betOffers[1]->odds / 1000;
$oran0 = 0;
}


$matchData = [
'eventid' => $eventid,
'botid' => $botid,
'pluskod' => $pluskod,
'hitit_kod' => $hitit_kod,
'baslangic' => $baslangic,
'evsahibi_isim' => $evsahibi_isim,
'misafir_isim' => $misafir_isim,
'lig_isim' => $lig_isim,
'lig_id' => $lig_id,
'ulke_isim' => $ulke_isim,
'ulke_id' => $ulke_id,
'ligresim' => $ligresim,
'mackodu' => $mackodu,
'istatistik' => $istatistik,
'id' => $id,
'oran_adet' => $oran_adet,
'tur' => $tur,
'tip' => $tip,
'oran1' => $oran1,
'oran0' => $oran0,
'oran2' => $oran2,
'sportid' => $sportid,
'mbs' => 1,
'countrySlug' => $countrySlug,
];


$macNode = $xml->addChild('Mac', ' ');
foreach ($matchData as $key => $value) {
$macNode->addAttribute($key, htmlspecialchars($value));
}

}

header('Content-Type: text/xml');
echo $xml->asXML();

?>