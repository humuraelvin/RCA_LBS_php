<?php

// İsteği loglamak için bir fonksiyon
function log_request() {
    $data = [
        'method' => $_SERVER['REQUEST_METHOD'], // İstek metodu (GET, POST, vb.)
        'data' => $_REQUEST,                    // GET ve POST verileri dahil tüm istek parametreleri
        'headers' => getallheaders(),           // Tüm başlık bilgileri
        'timestamp' => date("Y-m-d H:i:s"),     // Zaman damgası
        'ip' => $_SERVER['REMOTE_ADDR']         // İstekte bulunanın IP adresi
    ];
    
    // Veriyi JSON formatında bir dosyaya yaz
    file_put_contents('request_log.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
}

// Fonksiyonu çağırarak her isteği loglama
log_request();

// Ardından normal işlemlerinize devam edebilirsiniz...
echo "Hello, World!";

?>