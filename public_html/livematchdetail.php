<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$matchid = $_GET['matchid'];
$zaman = time();

$translations = [
    'Next Goal' => 'Sonraki Gol',
    'Total Corner' => 'Toplam Korner',
    'Total Goals by' => 'Toplam Gol - ',
    'Under' => 'Alt',
    'Over' => 'Üst',
    '1st Half' => 'İlk Yarı',
    '2nd Half' => '2. Yarı',
    'Draw No Bet' => 'Beraberlikte İade',
    'No More Goals' => 'Başka Gol Olmaz',
    'Even' => 'Çift',
    'Odd' => 'Tek',
    'Yes' => 'Evet',
    'No' => 'Hayır',
    'Draw' => 'Beraberlik',
    'Both Teams To Score' => 'Her İki Takım Gol Atar',
    '3-Way Handicap' => '3 Yollu Handikap',
    // ... Diğer çeviriler
    'Yarı Devre' => 'İlk Yarı',
    'Red Card' => 'Kırmızı Kart',
    'Yellow Card' => 'Sarı Kart',
    'Substitution' => 'Değişim',
    'Total Goals' => 'Toplam Gol',
    'Draw: No More Goals' => 'Beraberlik: Başka Gol Olmaz'
];


$url = "https://eu-offering-api.kambicdn.com/offering/v2018/ub/betoffer/event/".$matchid.".json?lang=tr_TR&market=ZZ&client_id=2&channel_id=1&ncid=".$zaman."&includeParticipants=true";

$List = file_get_contents($url);

$getList = json_decode($List);

$homeTeamName = $getList->events[0]->homeName;
$awayTeamName = $getList->events[0]->awayName;

$translations[$homeTeamName] = "Ev Sahibi";
$translations[$awayTeamName] = "Misafir";

function translate($input, $translations) {
    return str_replace(array_keys($translations), array_values($translations), $input);
}


$xml = new SimpleXMLElement('<ROOT />');
$MatchDetails = $xml->addChild('MatchDetails');


$sport = $getList->events[0]->sport;
$state = $getList->events[0]->state;

switch ($sport) {
    case 'FOOTBALL':      $sportid = 1;       break;
    case 'BASKETBALL':    $sportid = 88;      break;
    case 'VOLLEYBALL':    $sportid = 356;     break;
    case 'TENNIS':        $sportid = 351;     break;
    case 'BASEBALL':      $sportid = 363;     break;
    case 'TABLE_TENNIS':  $sportid = 361;     break;
    default:              $sportid = 9999;    break;
}

switch ($state) {
    case 'STARTED':       $state = 1;         break;
    default:              $state = 0;         break;
}

$Event = $MatchDetails->addChild('E');
$Event->addAttribute('Id', $getList->events[0]->id);
$Event->addAttribute('Sport', $getList->events[0]->sport);
$Event->addAttribute('SportId', $sportid);
$Event->addAttribute('Home', $getList->events[0]->homeName);
$Event->addAttribute('Away', $getList->events[0]->awayName);
$Event->addAttribute('Date', $getList->events[0]->start);
$Event->addAttribute('Live', $state);
$Event->addAttribute('BetRadarID', $getList->events[0]->id);

$filter = ['Maç Bahisi', 'Maç Bahisi (1,2)', '3-Way Handicap', '3-Ways Handicap', '3-Way Handicap - 1st Half', '3-Way Handicap - 2nd half', 'Handicap', 'Handicap - 1st Half', 'Handicap - 2nd Half', 'Handikap - 1. Yarı', 'Handikap - 2. Yarı', 'Toplam Goller', 'Toplam Korner'];
$Games = $Event->addChild('Games');
$gamesArray = [];

foreach ($getList->betOffers as $list) {
    if (!in_array($list->criterion->label, $filter)) {
        $label = translate($list->criterion->label, $translations);

        if (!isset($gamesArray[$label])) {
            $gamesArray[$label] = [
                'Id' => $list->id,
                'Name' => $label,
                'Columns' => 0,
                'Odds' => []
            ];
        }

        foreach ($list->outcomes as $Odds) {
            $oddsdurum = ($Odds->status == "OPEN") ? 1 : 0;
            $translatedLabel = translate(trim($Odds->label), $translations);

            if (in_array($translatedLabel, ['Over', 'Under', 'Alt', 'Üst'])) {
                $outcomeLabel = ($Odds->line / 1000) . ' ' . $translatedLabel;
            } elseif (stripos($list->criterion->label, 'Handikap') !== false || stripos($list->criterion->label, 'Handicap') !== false) {
                $outcomeLabel = ($Odds->line / 1000) . ' ' . $translatedLabel;
            } else {
                $outcomeLabel = $translatedLabel;
            }

            $gamesArray[$label]['Odds'][] = [
                'Id' => $Odds->betOfferId,
                'Name' => $outcomeLabel,
                'O0' => $Odds->odds / 1000,
                'GameIsVisible' => $oddsdurum
            ];
            
            $gamesArray[$label]['Columns']++;
        }
    }
}

foreach ($gamesArray as $game) {
    $G = $Games->addChild('G');
    $G->addAttribute('Id', $game['Id']);
    $G->addAttribute('Name', $game['Name']);
    $G->addAttribute('Columns', $game['Columns']);

    foreach ($game['Odds'] as $odd) {
        $R = $G->addChild('R');
        $R->addAttribute('Id', $odd['Id']);
        $R->addAttribute('Name', $odd['Name']);
        $R->addAttribute('O0', $odd['O0']);
        $R->addAttribute('GameIsVisible', $odd['GameIsVisible']);
    }
}

header("Content-type: text/xml");
echo $xml->asXML();
?>