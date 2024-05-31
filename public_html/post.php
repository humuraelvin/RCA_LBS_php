<?php

$url = 'https://pay.atabet.bet';

// Göndermek istediğiniz verileri bu diziye ekleyin
$data = [
    'key1' => 'value1',
    'key2' => 'value2',
    // ... diğer veri çiftleri
];

// cURL oturumunu başlat
$ch = curl_init($url);

// cURL ayarlarını yapılandır
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

// İsteği yürüt ve cevabı al
$response = curl_exec($ch);

// Eğer bir hata varsa hata mesajını yazdır
if (curl_error($ch)) {
    echo "cURL Hatası: " . curl_error($ch);
} else {
    echo "Sunucu Yanıtı: " . $response;
}

// cURL oturumunu kapat
curl_close($ch);

?>