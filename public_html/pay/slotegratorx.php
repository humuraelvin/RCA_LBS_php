<?php

ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Istanbul');

// Logging function
function logToFile($message) {
    $file = 'slotegrator_log.txt';
    $current = file_get_contents($file);
    $current .= date('Y-m-d H:i:s') . ': ' . $message . "\n";
    file_put_contents($file, $current);
}

$host = "localhost";
$user = "atab_atabet";
$password = "EDC0301cde*";
$dbname = "atab_atabet";
$merchantKey = '83af0916875c6948d76ef43a18c1224166d0ca0d';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$req = $_POST;
$headers = [
    'X-Merchant-Id' => $_SERVER['HTTP_X_MERCHANT_ID'],
    'X-Timestamp' => $_SERVER['HTTP_X_TIMESTAMP'],
    'X-Nonce' => $_SERVER['HTTP_X_NONCE']
];

$XSign = $_SERVER['HTTP_X_SIGN'];

$mergedParams = array_merge($req, $headers);
ksort($mergedParams);
$hashString = http_build_query($mergedParams);
$expectedSign = hash_hmac('sha1', $hashString, $merchantKey);

if ($XSign !== $expectedSign) {
    respondError("INVALID_SIGNATURE", "X-Sign doğrulaması başarısız.");
    logToFile("Imza Hatası");
    exit;
}

switch ($req['action']) {
    case "balance": balance($req); break;
    case "bet": bet($req); break;
    case "win": win($req); break;
    case "refund": refund($req); break;
    case "rollback": rollback($req); break;
    default: echo "Invalid action"; break;
}


function recordTransaction($player_id, $action, $amount, $transaction_id, $type = null) {
    global $conn;
    $sql = "INSERT INTO transactions (player_id, action, amount, transaction_id, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $player_id, $action, $amount, $transaction_id, $type);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

function balance($req) {
    global $conn;

    $player_id = $conn->real_escape_string($req['player_id']); 

    // Player bilgisini çekme
    $result = $conn->query("SELECT bakiye FROM admin WHERE id = '$player_id'");

    if (!$result || $result->num_rows == 0) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode([
            "error_code" => "PLAYER_NOT_FOUND",
            "error_description" => "No user found with id: $player_id"
        ]);
        exit;
    }

    $user = $result->fetch_assoc();

    $rdata = [
        "balance" => number_format($user['bakiye'], 4, '.', '')
    ];
    

    header('Content-Type: application/json');
    echo json_encode($rdata, JSON_PRETTY_PRINT);
    exit;
}

function getTransaction($transaction_id, $player_id) {
    global $conn;
    $query = "SELECT * FROM transactions WHERE transaction_id = '$transaction_id' AND player_id = '$player_id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


function bet($req) {
    global $conn;

    // Log data to file for debugging
    file_put_contents('slotegrator_bet.txt', json_encode($req));

    // Preparing initial response data
    $rdata = [
        "balance" => 0,
        "transaction_id" => ''
    ];
    
    $player_id = $conn->real_escape_string($req['player_id']);
    
    $result = $conn->query("SELECT bakiye FROM `admin` WHERE id = '$player_id'");
    
    if (!$result) {
        // Handle error, for example:
        die("Database query error.");
    }

    $user = $result->fetch_assoc();
    
    if (!$user) {
        // Handle error, for example:
            $rdata['error_code'] = "PLAYER_NOT_FOUND";
            echo json_encode($rdata);
            exit;
    }

    if ($user['bakiye'] < $req['amount']) {
        $rdata['error_code'] = "INSUFFICIENT_FUNDS";
        echo json_encode($rdata);
        exit;
    }

    if ($req['amount'] <= 0) {
        $lastBalanceAfter = getLastTransactionBalanceAfter($req['player_id'], "bet");
        if ($lastBalanceAfter !== null) {
            $rdata['balance'] = number_format($lastBalanceAfter, 4, '.', '');
        } else {
            $rdata['balance'] = number_format($user['bakiye'], 4, '.', ''); // Eğer böyle bir işlem bulunamazsa, mevcut bakiyeyi döndür.
        }
        $rdata['transaction_id'] = $req['transaction_id'];
        echo json_encode($rdata);
        exit;
    }
    
    
    $transactionCheck = getTransaction($req['transaction_id'], $req['player_id']);

    if ($transactionCheck) {
        if ($req['amount'] <= 0) {
            $rdata['balance'] = number_format($transactionCheck['balance_before'], 4, '.', ''); // Burada balance_before değerini kullandık.
        } else {
            $rdata['balance'] = number_format($transactionCheck['balance_after'], 4, '.', ''); // Burada balance_after değerini kullandık.
        }
        $rdata['transaction_id'] = $req['transaction_id'];
        echo json_encode($rdata);
        exit;
    }
    
if (!isset($req['type'])) {
    logToFile("Type indeksi eksik. İstek: " . json_encode($req));
}


    $slotegrator = [
        "action" => $req['action'],
        "amount" => $req['amount'],
        "currency" => $req['currency'],
        "game_uuid" => $req['game_uuid'],
        "player_id" => $req['player_id'],
        "transaction_id" => $req['transaction_id'],
        "session_id" => $req['session_id'],
        "type" => isset($req['type']) ? $req['type'] : null,
        "balance_before" => $user['bakiye'],
        "balance_after" => $user['bakiye'] - $req['amount'],
    ];

    foreach (['freespin_id', 'quantity', 'round_id', 'finished'] as $field) {
        if (isset($req[$field])) {
            $slotegrator[$field] = $req[$field];
        }
    }

    $fields = implode(", ", array_keys($slotegrator));
//    $values = implode(", ", array_map([$conn, 'real_escape_string'], array_values($slotegrator)));
$values = "'" . implode("', '", array_map(function($value) use ($conn) {
    return $conn->real_escape_string($value);
}, array_values($slotegrator))) . "'";


    $sql = "INSERT INTO transactions ($fields) VALUES ($values)";

    
    if (!$conn->query($sql)) {

            // Log the error and the SQL query to a file
        $logData = "Error: " . $conn->error . "\nSQL Query: " . $sql . "\n\n";
        file_put_contents('error_log.txt', $logData, FILE_APPEND);

        // If failed, check if transaction already exists and return its data
        $transaction = getTransaction($req['transaction_id'], $req['player_id']);
        $rdata['balance'] = number_format($transaction['balance_after'], 4, '.', '');
        $rdata['transaction_id'] = $transaction['transaction_id'];
        echo json_encode($rdata);
        exit;
    }



//    $new_balance = $user['bakiye'] - $req['amount'];
    $new_balance = number_format($user['bakiye'] - $req['amount'], 4, '.', '');

    if (!$conn->query("UPDATE `admin` SET bakiye = '$new_balance' WHERE id = '$player_id'")) {
        die("Error updating balance in database.");
    }

    $rdata['balance'] = number_format($new_balance, 4, '.', '');
    $rdata['transaction_id'] = $req['transaction_id'];

    echo json_encode($rdata);
    exit;
}


function getLastTransactionBalanceAfter($player_id, $actionType) {
    global $conn;
    $query = "SELECT balance_after FROM transactions WHERE player_id = '$player_id' AND action = '$actionType' AND type = '$actionType' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['balance_after'];
    } else {
        return null;
    }
}



function win($req) {
    global $conn;

    // Player ID and sanitize amount
    $player_id = $conn->real_escape_string($req['player_id']);
    $amount = (double)$req['amount'];

    // Fetch player data
    $result = $conn->query("SELECT bakiye FROM admin WHERE id = '$player_id'");
    if (!$result) {
        respondError('INTERNAL_ERROR', 'Database query error.');
    }

    $user = $result->fetch_assoc();
    if (!$user) {
        respondError('INTERNAL_ERROR', 'Player not found.');
    }


    

    $transactionCheck = getTransaction($req['transaction_id'], $req['player_id']);

    if ($transactionCheck) {

        if ($req['amount'] <= 0) {
            $rdata['balance'] = number_format($transactionCheck['balance_before'], 4, '.', ''); // Burada balance_before değerini kullandık.
        } else {
            $rdata['balance'] = number_format($transactionCheck['balance_after'], 4, '.', ''); // Burada balance_after değerini kullandık.
        }
        
        $rdata['transaction_id'] = $req['transaction_id'];
        echo json_encode($rdata);
        exit;

    }

    if ($req['amount'] <= 0) {
        $lastBalanceAfter = getLastTransactionBalanceAfter($req['player_id'], "win");
        if ($lastBalanceAfter !== null) {
            $rdata['balance'] = number_format($lastBalanceAfter, 4, '.', '');
        } else {
            $rdata['balance'] = number_format($user['bakiye'], 4, '.', ''); // Eğer böyle bir işlem bulunamazsa, mevcut bakiyeyi döndür.
        }
        $rdata['transaction_id'] = $req['transaction_id'];
        echo json_encode($rdata);
        exit;
    }
    


    if (!isset($req['type'])) {
        logToFile("Type index missing. Request: " . json_encode($req));
    }

    $slotegrator = [
        "action" => $req['action'],
        "amount" => $amount,
        "currency" => $req['currency'],
        "game_uuid" => $req['game_uuid'],
        "player_id" => $req['player_id'],
        "transaction_id" => $req['transaction_id'],
        "session_id" => $req['session_id'],
        "type" => isset($req['type']) ? $req['type'] : null,
        "balance_before" => $user['bakiye'],
        "balance_after" => $user['bakiye'] + $amount
    ];

    foreach (['freespin_id', 'quantity', 'round_id', 'finished'] as $field) {
        if (isset($req[$field])) {
            $slotegrator[$field] = $req[$field];
        }
    }

    $fields = implode(", ", array_keys($slotegrator));
    $values = "'" . implode("', '", array_map(function($value) use ($conn) {
        return $conn->real_escape_string($value);
    }, array_values($slotegrator))) . "'";

    $sql = "INSERT INTO transactions ($fields) VALUES ($values)";

    if (!$conn->query($sql)) {
        $logData = "Error: " . $conn->error . "\nSQL Query: " . $sql . "\n\n";
        file_put_contents('error_log.txt', $logData, FILE_APPEND);
        die("Database insert error.");
    }

    if ($amount != 0) {
        $new_balance = number_format($user['bakiye'] + $req['amount'], 4, '.', '');
    
        if (!$conn->query("UPDATE `admin` SET bakiye = '$new_balance' WHERE id = '$player_id'")) {
            die("Error updating balance in database.");
        }
    }
    

    $rdata['balance'] = $new_balance;  // Removed number_format here, keep the original precision
    $rdata['transaction_id'] = $req['transaction_id'];

    echo json_encode($rdata);
    exit;
}


function respondWithBalance($balance, $transaction_id) {
    header('Content-Type: application/json');
    echo json_encode([
        "balance" => number_format($balance, 4, '.', ''),
        "transaction_id" => $transaction_id
    ]);
    exit;
}



function hataYaniti($errorCode, $description) {
    header('Content-Type: application/json');
    echo json_encode([
        "error_code" => $errorCode,
        "error_description" => $description
    ]);
    exit;
}

function yanitla($balance, $transaction_id) {
    header('Content-Type: application/json');
    echo json_encode([
        "balance" => number_format($balance, 4, '.', ''),
        "transaction_id" => $transaction_id
    ]);
    exit;
}

function refund($req) {
    global $conn;

    // Log the request for debugging
    logToFile(json_encode($req));

    $rdata = [
        "balance" => 0,
        "transaction_id" => ''
    ];

    $player_id = $conn->real_escape_string($req['player_id']);
    $amount = (double)$req['amount'];
    
    // Fetch user details
    $result = $conn->query("SELECT bakiye FROM `admin` WHERE id = '$player_id'");
    if (!$result) {
        respondError('INTERNAL_ERROR', 'Database query error.');
    }
    $user = $result->fetch_assoc();

    if (!$user) {
        respondError('INTERNAL_ERROR', 'Player not found.');
    }

    if ($req['amount'] <= 0) {
        $rdata['balance'] = number_format($user['bakiye'], 4, '.', '');
        $rdata['transaction_id'] = $req['transaction_id'];
        echo json_encode($rdata);
        exit;
    }

    $transactionCheck = getTransaction($req['transaction_id'], $req['player_id']);

    if ($transactionCheck) {
        if ($req['amount'] <= 0) {
            $rdata['balance'] = number_format($transactionCheck['balance_before'], 4, '.', ''); // Burada balance_before değerini kullandık.
        } else {
            $rdata['balance'] = number_format($transactionCheck['balance_after'], 4, '.', ''); // Burada balance_after değerini kullandık.
        }
       $rdata['transaction_id'] = $req['transaction_id'];
       echo json_encode($rdata);
       exit;
    }
    
    

    if (!isset($req['type'])) {
        logToFile("Type indeksi eksik. İstek: " . json_encode($req));
    }

    $slotegrator = [
        "action" => $req['action'],
        "amount" => $req['amount'],
        "currency" => $req['currency'],
        "game_uuid" => $req['game_uuid'],
        "player_id" => $req['player_id'],
        "transaction_id" => $req['transaction_id'],
        "session_id" => $req['session_id'],
        "type" => isset($req['type']) ? $req['type'] : null,  // check if type is set
        "balance_before" => $user['bakiye'],
        "balance_after" => $user['bakiye'] + $req['amount']  // refund so we add amount
    ];

    foreach (['freespin_id', 'quantity', 'round_id', 'finished'] as $field) {
        if (isset($req[$field])) {
            $slotegrator[$field] = $req[$field];
        }
    }

    $fields = implode(", ", array_keys($slotegrator));
    $values = "'" . implode("', '", array_map(function($value) use ($conn) {
        return $conn->real_escape_string($value);
    }, array_values($slotegrator))) . "'";

    $sql = "INSERT INTO transactions ($fields) VALUES ($values)";
    if (!$conn->query($sql)) {
        $logData = "Error: " . $conn->error . "\nSQL Query: " . $sql . "\n\n";
        file_put_contents('error_log.txt', $logData, FILE_APPEND);
        die("Database insert error.");
    }

    $new_balance = $user['bakiye'] + $req['amount'];
    if (!$conn->query("UPDATE `admin` SET bakiye = '$new_balance' WHERE id = '$player_id'")) {
        die("Error updating balance in database.");
    }

    $rdata['balance'] = number_format($user['bakiye'], 4, '.', '');
    $rdata['transaction_id'] = $req['transaction_id'];

    echo json_encode($rdata);
    exit;
}



function rollback($req) {
    global $conn;

    // Log the request for debugging
    logToFile(json_encode($req));

    $rdata = [
        "balance" => 0,
        "transaction_id" => '',
        "rollback_transactions" => []
    ];

    $player_id = $conn->real_escape_string($req['player_id']);
    
    // Fetch user details
    $result = $conn->query("SELECT bakiye FROM `admin` WHERE id = '$player_id'");
    if (!$result) {
        respondError('INTERNAL_ERROR', 'Database query error.');
    }
    $user = $result->fetch_assoc();
    if (!$user) {
        respondError('INTERNAL_ERROR', 'Player not found.');
    }

    $balanceChange = 0;
    foreach ($req['rollback_transactions'] as $rtransaction) {
        $action = $rtransaction['action'];
        $amount = (double)$rtransaction['amount'];

        // Check if the transaction exists
        $transaction_id = $rtransaction['transaction_id'];
        $checkTransaction = $conn->query("SELECT * FROM transactions WHERE transaction_id = '$transaction_id'");
        if ($checkTransaction->num_rows == 0) {
            logToFile("Transaction {$transaction_id} not found.");
            continue; // skip to the next transaction
        }

        
        if ($action === 'bet') {
            $balanceChange += $amount;
        } else if ($action === 'win') {
            $balanceChange -= $amount;
        } else if ($action === 'refund') {
            $balanceChange -= $amount;
        }

        // Remove the transaction
        if (!deleteTransaction($transaction_id)) {
            logToFile("Failed to delete transaction: {$transaction_id}");
            continue;  // skip to the next transaction
        }
        
        $rdata['rollback_transactions'][] = $transaction_id;
    }

    $slotegrator = [
        "action" => 'rollback',
        "amount" => $balanceChange,
        "player_id" => $player_id,
        "transaction_id" => $req['transaction_id'],
        "balance_before" => $user['bakiye'],
        "balance_after" => $user['bakiye'] + $balanceChange
    ];

    $fields = implode(", ", array_keys($slotegrator));
    $values = "'" . implode("', '", array_map(function($value) use ($conn) {
        return $conn->real_escape_string($value);
    }, array_values($slotegrator))) . "'";

    $sql = "INSERT INTO transactions ($fields) VALUES ($values)";
    if (!$conn->query($sql)) {
        $logData = "Error: " . $conn->error . "\nSQL Query: " . $sql . "\n\n";
        file_put_contents('error_log.txt', $logData, FILE_APPEND);
        respondError('INTERNAL_ERROR', 'Database insert error.');
    }

    $new_balance = $user['bakiye'] + $balanceChange;
    if (!$conn->query("UPDATE `admin` SET bakiye = '$new_balance' WHERE id = '$player_id'")) {
        respondError('INTERNAL_ERROR', 'Error updating balance in database.');
    }

    $rdata['balance'] = number_format($new_balance, 4, '.', '');
    $rdata['transaction_id'] = $req['transaction_id'];

    echo json_encode($rdata);
    exit;
}


function hataYaniti2($errorCode, $description) {
    header('Content-Type: application/json');
    echo json_encode([
        "error_code" => $errorCode,
        "error_description" => $description
    ]);
    exit;
}

function yanitla2($balance, $transaction_id, $rollbackedTxns) {
    header('Content-Type: application/json');
    echo json_encode([
        "balance" => number_format($balance, 4, '.', ''),
        "transaction_id" => $transaction_id,
        "rollback_transactions" => $rollbackedTxns
    ]);
    exit;
}

function deleteTransaction($txn_id) {
    global $conn;
    return $conn->query("DELETE FROM transactions WHERE transaction_id = '$txn_id'");
}

function respondError($errorCode, $description) {
    header('Content-Type: application/json');
    echo json_encode([
        "error_code" => $errorCode,
        "error_description" => $description
    ]);
    exit;
}



$conn->close();
?>