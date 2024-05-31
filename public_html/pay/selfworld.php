<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// $BASE_URL = 'https://staging.slotegrator.com/api/index.php/v1';
// $MERCHANT_KEY = '83af0916875c6948d76ef43a18c1224166d0ca0d';
// $MERCHANT_ID = '42ee478e61caa9c90f71c0e9bcc37621';
#production
$BASE_URL = 'https://gis.slotegrator.com/api/index.php/v1';
$MERCHANT_KEY = '356d4ab8ff54500feea085bb1fff4fcc72ce3873';
$MERCHANT_ID = '843486dd00b159109ea78f57cc8a4502';

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
        throw new Exception('cURL Error: ' . curl_error($ch));
    }

    curl_close($ch);
var_dump(json_decode($response, true));die;
    return json_decode($response, true);
}

function selfValidate() {
    global $MERCHANT_KEY, $MERCHANT_ID;
    $headers = getHeaders($MERCHANT_KEY, $MERCHANT_ID);
    return request('POST', '/self-validate', $headers);
}

$validationResponse = null;

if (true) {
    //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validationResponse = selfValidate();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doğrulama Sayfas</title>
</head>

<!--<body>-->
<!--    <form method="POST">-->
<!--        <input type="submit" value="Doğrulamayı Başlat">-->
<!--    </form>-->

<!--    <?php if(isset($validationResponse)): ?>-->
<!--    <?php if ($validationResponse['success']): ?>-->
<!--    <p>Doğrulama başarıl!</p>-->
<!--    <?php foreach ($validationResponse['log'] as $logMessage): ?>-->
<!--    <p><?php echo $logMessage; ?></p>-->
<!--    <?php endforeach; ?>-->
<!--    <?php else: ?>-->
<!--    <p>Doğrulama başarısız!</p>-->
<!--    <?php endif; ?>-->
<!--    <?php endif; ?>-->
<!--</body>-->

</html>