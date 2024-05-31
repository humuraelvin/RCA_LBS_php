<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


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

$site = json_decode(file_get_contents("https://forbet777.com/prematch.php"));


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
case 'CRICKET':
$sportid = 31;
break;
case 'ESPORTS':
$sportid = 66;
break;
case 'AUSTRALIAN_RULES':
$sportid = 26;
break;
case 'RUGBY_LEAGUE':
$sportid = 5;
break;
case 'RUGBY':
$sportid = 5;
break;
case 'RUGBY_UNION':
$sportid = 5;
break;
case 'BADMINTON':
$sportid = 35;
break;
case 'HANDBALL':
$sportid = 17;
break;
case 'DARTS':
$sportid = 9;
break;
case 'BOXING':
$sportid = 11;
break;
case 'ICE_HOCKEY':
$sportid = 16;
break;
case 'FLOORBALL':
$sportid = 18;
break;
case 'SNOOKER':
$sportid = 6;
break;
case 'BOWLING':
$sportid = 6969;
break;
case 'CHESS':
$sportid = 7070;
break;
case 'CYCLING':
$sportid = 7171;
break;
case 'FORMULA_1':
$sportid = 7272;
break;
case 'GOLF':
$sportid = 7373;
break;
case 'LACROSSE':
$sportid = 7474;
break;
case 'MOTORSPORTS':
$sportid = 7575;
break;
case 'POLITICS':
$sportid = 7676;
break;
case 'MARTIAL_ARTS':
$sportid = 7777;
break;
case 'WINTERSPORTS':
$sportid = 7878;
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