<?php

$url = 'https://pay.hizlicapapara.com/iframe/v1/new/papara';

// Bu değerleri gerçek değerlerinizle değiştirin
$token = 'I1Be2L1AaNhDUotecfbkokJhP6LcPFDf';
$secret = '2shY1aMQCFeLMl9ssp9tBMoR0q3cdWNl';
$refid = '123996';
$nameSurname = 'Sabri Test';
$username = 'sabritest';
$amount = 250.00;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => $amount,
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

// status değeri true ise URL'ye yönlendir
if (isset($responseArray['status']) && $responseArray['status'] === true) {
    header('Location: ' . $responseArray['url']);
    exit;
}

// Yönlendirme olmazsa cevabı ekrana yaz
echo $response;

?>