<?php

$matchid = $_GET['matchid'];
$zaman = time();

try {
    $site = file_get_contents("https://eu-offering-api.kambicdn.com/offering/v2018/ub/betoffer/event/".$matchid.".json?lang=tr_TR&market=ZZ&client_id=2&channel_id=1&ncid=".$zaman."&includeParticipants=true");
    echo $site;
} catch (Exception $e) {
    // Bir hata meydana geldiğinde, veritabanından mackodu değerini al

    // Veritabanına bağlan (Bu örnek PDO kullanmaktadır)
    $pdo = new PDO('mysql:host=your_host;dbname=atab_atabet', 'atab_atabet', 'EDC0301cde*');

    // $matchid değeriyle eşleşen mackodu değerini sorgula
    $query = $pdo->prepare("SELECT mackodu FROM maclar WHERE id = :matchid");
    $query->execute([':matchid' => $matchid]);
    $result = $query->fetch();

    if ($result) {
        $newMatchId = $result['mackodu'];
        
        // Yeni matchid değeriyle tekrar file_get_contents işlemi gerçekleştir
        $site = file_get_contents("https://eu-offering-api.kambicdn.com/offering/v2018/ub/betoffer/event/".$newMatchId.".json?lang=tr_TR&market=ZZ&client_id=2&channel_id=1&ncid=".$zaman."&includeParticipants=true");
        echo $site;
    } else {
        echo "Match ID bulunamadı!";
    }
}

?>