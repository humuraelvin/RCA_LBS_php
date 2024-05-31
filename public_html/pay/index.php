<?php

$servername = "localhost";
$username = "atab_atabet";
$password = "EDC0301cde*";
$dbname = "atab_atabet";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn->set_charset("utf8mb4")) {
    log_to_file("Error loading character set utf8mb4: " . $conn->error);
    exit();
} else {
    log_to_file("Current character set: " . $conn->character_set_name());
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

function log_to_file($message) {
    $file = 'requests.txt';
    $current = file_get_contents($file);
    $current .= $message . "\n---------\n";
    file_put_contents($file, $current);
}

log_to_file("Received data: " . json_encode($data, JSON_PRETTY_PRINT));

$stmt = $conn->prepare("SELECT * FROM parayatir WHERE refid = ? AND durum = 0");
$stmt->bind_param("s", $data->refid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($data->status == 1) {
            // ID'yi ve önceki bakiyeyi al
            $stmt_id = $conn->prepare("SELECT id, bakiye FROM admin WHERE username = ?");
            $stmt_id->bind_param("s", $data->username);
            $stmt_id->execute();
            $res_id = $stmt_id->get_result();
            $row_id = $res_id->fetch_assoc();
            $user_id = $row_id['id'];
            $onceki_bakiye = $row_id['bakiye'];
            $stmt_id->close();

            // Bakiye güncelleme
            $stmt_balance = $conn->prepare("UPDATE admin SET bakiye = bakiye + ? WHERE username = ?");
            $stmt_balance->bind_param("ds", $data->amount, $data->username);
            $stmt_balance->execute();
            $sonraki_bakiye = $onceki_bakiye + $data->amount;
            $stmt_balance->close();

            // Log tablosuna kayıt ekleme
            $stmt_log = $conn->prepare("INSERT INTO log (userid, islemad, tutar, tarih, oncekibakiye, sonrakibakiye) VALUES (?, 'Para Yatırma İşlemi', ?, NOW(), ?, ?)");
            $stmt_log->bind_param("iddi", $user_id, $data->amount, $onceki_bakiye, $sonraki_bakiye);
            $stmt_log->execute();
            $stmt_log->close();

            $update_status = 1;
        } elseif ($data->status == 2) {
            $update_status = 2;
        }

        $stmt_update = $conn->prepare("UPDATE parayatir SET durum = ?, miktar = ? WHERE refid = ?");
        $stmt_update->bind_param("ids", $update_status, $data->amount, $data->refid); // miktar sütunu için "d" parametre türü eklendi.
        $stmt_update->execute();
        

        if ($stmt_update->affected_rows > 0) {
            log_to_file("Record updated successfully with status: " . $update_status);
            echo json_encode(["message" => "Record updated successfully with status: " . $update_status]);
        } else {
            log_to_file("Error updating record.");
            echo json_encode(["error" => "Error updating record."]);
        }
        $stmt_update->close();
    }
} else {
    log_to_file("No matching record found or the transaction is already processed");
    echo json_encode(["error" => "No matching record found or the transaction is already processed"]);
}

$stmt->close();
$conn->close();

?>