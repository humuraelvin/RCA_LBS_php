<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// date_default_timezone_set('Europe/Istanbul'); // Zaman dilimi olarak Türkiye'yi ayarla
#staging
// $BASE_URL = 'https://staging.slotegrator.com/api/index.php/v1';
// $MERCHANT_KEY = '83af0916875c6948d76ef43a18c1224166d0ca0d';
// $MERCHANT_ID = '42ee478e61caa9c90f71c0e9bcc37621';
#production
$BASE_URL = 'https://gis.slotegrator.com/api/index.php/v1';
$MERCHANT_KEY = '356d4ab8ff54500feea085bb1fff4fcc72ce3873';
$MERCHANT_ID = '843486dd00b159109ea78f57cc8a4502';

$host = "localhost";
$user = "atab_atabet";
$password = "EDC0301cde*";
$dbname = "atab_atabet";
// $merchantKey = '83af0916875c6948d76ef43a18c1224166d0ca0d';
$merchantKey = '356d4ab8ff54500feea085bb1fff4fcc72ce3873';


$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getHeaders($merchantKey, $merchantId, $request = []) {
    $timestamp = time();
    $nonce = md5(uniqid(mt_rand(), true));
    $headers = [
        'X-Merchant-Id' => $merchantId,
        'X-Timestamp' => $timestamp,
        'X-Nonce' => $nonce
    ];

    $mergedParams = array_merge($request, $headers);
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('cURL Error: ' . curl_error($ch));
        throw new Exception('cURL Error: ' . curl_error($ch));
    }

    $decodedResponse = json_decode($response, true);

    if (isset($decodedResponse['error'])) {
        error_log('API Error: ' . $decodedResponse['error']);
        die('API Error: ' . $decodedResponse['error']);
    }

    curl_close($ch);

    return $decodedResponse;
}
function freespinGet($request) {
    global $MERCHANT_KEY, $MERCHANT_ID;
    $headers = getHeaders($MERCHANT_KEY, $MERCHANT_ID, $request);
    $url = '/freespins/bets?game_uuid='.$request['game_uuid'].'&currency='.$request['currency'];
    return request('GET', $url, $headers, $request);
}
function freespinSet($request) {
    global $MERCHANT_KEY, $MERCHANT_ID;
    $headers = getHeaders($MERCHANT_KEY, $MERCHANT_ID, $request);
    $url = '/freespins/set';
    return request('POST', $url, $headers, $request);
}
function gameInit($request) {
    global $MERCHANT_KEY, $MERCHANT_ID;
    // var_dump('hehe');die;
    $headers = getHeaders($MERCHANT_KEY, $MERCHANT_ID, $request);
    return request('POST', '/games/init', $headers, $request);
}

// function selfValidate() {
//     global $MERCHANT_KEY, $MERCHANT_ID;
//     $headers = getHeaders($MERCHANT_KEY, $MERCHANT_ID);
//     return request('POST', '/self-validate', $headers);
// }

$gameUrl = null;
$validationResponse = null;

function logToFile($message) {
    $file = 'play_log.txt';
    $current = file_get_contents($file);
    $current .= date('Y-m-d H:i:s') . ': ' . $message . "\n\n\n";
    file_put_contents($file, $current);
}

if (isset($_REQUEST['user_id']) && isset($_REQUEST['game_id']) && isset($_REQUEST['username']) && isset($_REQUEST['currency']) && isset($_REQUEST['lang'])) {
    $user_id = $_REQUEST['user_id'];
    $game_id = $_REQUEST['game_id'];
    // $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    $currency = $_REQUEST['currency'];
    $lang = $_REQUEST['lang'];
    $lang = 'tr';
    $uniqueSessionId = uniqid();

    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
    $return_url = "$protocol://" . $_SERVER['HTTP_HOST'];

    $response = gameInit([
        'game_uuid' => $game_id,
        'player_id' => $user_id,
        'player_name' => $username,
        'currency' => $currency,
        'session_id' => $uniqueSessionId,
        'return_url' => $return_url,
        // 'email' => $email,
        'language' => $lang
    ]);
    

    if(isset($response['url'])) {
        $gameUrl = $response['url'];
        $sql = "INSERT INTO game_sessions (player_id, session_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_id, $uniqueSessionId);
        $stmt->execute();
        $stmt->close();
        
        echo $gameUrl;
        // $validationResponse = selfValidate();
    } else {
        var_dump(json_encode($response));die;
        error_log("Error initializing game: " . json_encode($response));
        logToFile("Error initializing game: " . json_encode($response));
    }
}
if (isset($_REQUEST['method']) && $_REQUEST['method'] == 'freespinGet') {
    # code...
    if (isset($_REQUEST['game_id']) && isset($_REQUEST['currency']) ) {
    
        $game_id = $_REQUEST['game_id'];
        $currency = $_REQUEST['currency'];
        $response = freespinGet([
            'game_uuid' => $game_id,
            'currency' => $currency,
        ]);
        
    
        if(isset($response['denominations'])) {
            $denominations = $response['denominations'];
            var_dump($response);
        } else {
            var_dump(json_encode($response));die;
            error_log("Error initializing game: " . json_encode($response));
            logToFile("Error initializing game: " . json_encode($response));
        }
    }
}
if (isset($_REQUEST['method']) && $_REQUEST['method'] == 'freespinSet') {
    # set freespin...
    // $player_id = '264371';
    // $player_name = 'eyyttt';
    // $currency = 'TRY';
    //$game_id = '447eebaff41fdc9c36cf680720ea2ce321d33b67'; //staging 4 of a King Mobile, fs id= 65b911545d2a1
    //$game_id = 'fe38b9de0f44ac5892261d426ba39cd1aa410807'; //staging Chimney Sweep Mobile, fs id= 65b911a8b83fb
    //$game_id = '5111b171119b9d8dddf0a7d20f013aab936fad6e'; //staging Football Mobile,fs id=65b911dd98f4c
    // $game_id = 'f5470d59bedf4dfca216bb37f8c2e3ff'; //production sweet bonanza mobile,fs id=65b938dd29613
    // $quantity = 250;

    $player_id = $_REQUEST['player_id'];
    $player_name = $_REQUEST['player_name'];
    $currency = $_REQUEST['currency'];
    $game_id = $_REQUEST['game_id'];
    $quantity = $_REQUEST['quantity'];

    $data = array(
        "player_id" => $player_id,
        "player_name" => $player_name,
        "currency" => $currency,
        "quantity" => $quantity,
        "valid_from" => time(),
        "valid_until" => time() + 7 * 24 * 3600,
        "freespin_id" => uniqid(),
        "bet_id" => 0,
        "denomination" => 1,
        "game_uuid" => $game_id,
    );
    var_dump('play.php',$data);
    $response = freespinSet($data);

    echo json_encode($response);
    die;
    

    if(isset($response)) {
        echo json_encode($response);
    } else {
        var_dump(json_encode($response));die;
        error_log("Error initializing game: " . json_encode($response));
        logToFile("Error initializing game: " . json_encode($response));
    }
}
?>