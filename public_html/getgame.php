<?php
#Staging
// $BASE_URL = 'https://staging.slotegrator.com/api/index.php/v1';
// $MERCHANT_KEY = '83af0916875c6948d76ef43a18c1224166d0ca0d';
// $MERCHANT_ID = '42ee478e61caa9c90f71c0e9bcc37621';
#production
$BASE_URL = 'https://gis.slotegrator.com/api/index.php/v1';
$MERCHANT_KEY = '356d4ab8ff54500feea085bb1fff4fcc72ce3873';
$MERCHANT_ID = '843486dd00b159109ea78f57cc8a4502';

// Veritabanı balantısı (PDO rneği)
$db_host = 'localhost';
$db_name = 'atab_atabet';
$db_user = 'atab_atabet';
$db_pass = 'EDC0301cde*';

$db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

$db->exec("TRUNCATE TABLE slotegrator_games");

function getHeaders($merchantKey, $merchantId, $request = []) {
    $timestamp = time();
    $nonce = md5(uniqid(mt_rand(), true));
    $headers = [
        'X-Merchant-Id' => $merchantId,
        'X-Timestamp' => $timestamp,
        'X-Nonce' => $nonce
    ];

    $mergedParams = $headers + $request;
    ksort($mergedParams);
    $hashString = http_build_query($mergedParams);
    $XSign = hash_hmac('sha1', $hashString, $merchantKey);

    $headers['X-Sign'] = $XSign;

    return $headers;
}

function request($method, $endpoint, $headers, $params = []) {
    global $BASE_URL;

    $ch = curl_init();
    $url = $BASE_URL . $endpoint;

    if ($method === 'GET' && !empty($params)) {
        $url .= '?' . http_build_query($params);
    }

    $httpHeaders = [];
    foreach ($headers as $key => $value) {
        $httpHeaders[] = "$key: $value";
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }

    curl_close($ch);

    return json_decode($response, true);
}

function getGames($page = 1) {
    global $MERCHANT_KEY, $MERCHANT_ID;
    $params = ['page' => $page];
    return request('GET', '/games', getHeaders($MERCHANT_KEY, $MERCHANT_ID, $params), $params);
}



$page = 1;
$totalPages = 1;
$count = 0;
while ($page <= $totalPages) {
    $response = getGames($page);

    if ($page == 1) {
        $totalPages = ceil($response['_meta']['totalCount'] / 50);
    }

    foreach ($response['items'] as $game) {
        $stmt = $db->prepare("INSERT INTO slotegrator_games (uuid, name, image, type, provider, technology, has_lobby, is_mobile, has_freespins, has_tables, freespins_valid_until_full_day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $game['uuid'],
            $game['name'],
            $game['image'],
            $game['type'],
            $game['provider'],
            $game['technology'],
            $game['has_lobby'],
            $game['is_mobile'],
            $game['has_freespins'],
            $game['has_tables'],
            $game['freespin_valid_until_full_day']
        ]);
        $count++;
        echo('&nbsp;&nbsp;'.$count.'&nbsp;&nbsp;&nbsp;&nbsp;'.$game['name'].'&nbsp;&nbsp;('.$game['provider'].')&nbsp;&nbsp;('.$game['type'].'<br>');
    }

    $page++;
}

echo "Tüm oyunlar veritabanına eklendi!";

?>