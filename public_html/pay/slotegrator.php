<?php
class Database {
    private $host = "localhost";
    private $user = "atab_atabet";
    private $pass = "EDC0301cde*";
    private $dbname = "atab_atabet";
    
    private $conn;
    private $result;
    
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        $this->result = $this->conn->query($sql);
        return $this->result;
    }
    
    public function get_where($table, $conditions) {
        $sql = "SELECT * FROM $table WHERE ";
        $clauses = [];
        foreach ($conditions as $key => $value) {
            $clauses[] = "$key = '$value'";
        }
        $sql .= implode(' AND ', $clauses);
        $this->result = $this->query($sql);
        return $this;
    }
    
    public function row() {
        return $this->result->fetch_object();
    }
    

    public function insert($table, $data) {
        $keys = array_keys($data);
        $values = array_values($data);
        
        $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES ('" . implode("','", $values) . "')";
        if (!$this->query($sql)) {
            // Hata oluştuğunda sorguyu ve hata mesajını dosyaya yaz.
            $error_msg = "Error: " . $this->conn->error;
            file_put_contents('db_errors.txt', date("Y-m-d H:i:s") . ": " . $sql . " - " . $error_msg . PHP_EOL, FILE_APPEND);
        }
    }
    
    
    public function update($table, $data, $conditions) {
        $sql = "UPDATE $table SET ";
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "$key = '$value'";
        }
        $sql .= implode(', ', $setClauses);
        
        $whereClauses = [];
        foreach ($conditions as $key => $value) {
            $whereClauses[] = "$key = '$value'";
        }
        $sql .= " WHERE " . implode(' AND ', $whereClauses);
        
        // SQL sorgusunu dosyaya yazma işlemi
        file_put_contents('queries.txt', $sql . PHP_EOL, FILE_APPEND);
        
        $this->query($sql);
    }
    
    
    public function set($table, $key, $value, $conditions) {
        $sql = "UPDATE $table SET $key = '$value' WHERE ";
        $whereClauses = [];
        foreach ($conditions as $k => $v) {
            $whereClauses[] = "$k = '$v'";
        }
        $sql .= implode(' AND ', $whereClauses);
        
        // SQL sorgusunu dosyaya yazma işlemi (isteğe bağlı)
        file_put_contents('queries.txt', $sql . PHP_EOL, FILE_APPEND);
        
        $this->query($sql);
    }
    
    public function getBalance($userId) {
        $query = $this->get_where('admin', ['id' => $userId]);
        $result = $query->row();
        
        if ($result) {
            return $result->bakiye;
        } else {
            return 0;  // Varsayılan değeri 0 olarak belirleyin. Eğer oyuncuya ait bakiye bulunamazsa 0 döndürecek.
        }
    }
    
    public function close() {
        $this->conn->close();
    }
}
// Kullanım örneği:
$db = new Database();
//staging
// $merchantKey = '83af0916875c6948d76ef43a18c1224166d0ca0d';
//prodution
$merchantKey = '356d4ab8ff54500feea085bb1fff4fcc72ce3873';

$data = $_POST;
$headers = [
    'X-Merchant-Id' => $_SERVER['HTTP_X_MERCHANT_ID'],
    'X-Timestamp' => $_SERVER['HTTP_X_TIMESTAMP'],
    'X-Nonce' => $_SERVER['HTTP_X_NONCE']
];
$XSign = $_SERVER['HTTP_X_SIGN'];
$mergedParams = array_merge($data, $headers);
ksort($mergedParams);
$hashString = http_build_query($mergedParams);
$expectedSign = hash_hmac('sha1', $hashString, $merchantKey);
if ($XSign != $expectedSign) {
    $sonuc = array (
        "error_code"=>"INTERNAL_ERROR",
        "error_description"=>"Key Sign Error"
    );
    header('Content-Type: application/json');
    echo json_encode($sonuc);
    exit;
}

$userId = 0;
$users=$db->get_where('admin',array('id'=> $data['player_id']))->row();
if ($users) {
    $userId = $data['player_id'];
} else {
    $sonuc = array (
        "error_code" => "INTERNAL_ERROR",
        "error_description" => "Player Not Found"
    );
    header('Content-Type: application/json');
    echo json_encode($sonuc);
    exit;
}

$amount = 0;
if ($data['action'] == 'balance') {    
    $bakiyesonuc = array (
        "balance" => number_format($users->bakiye, 4, '.', ''),
    );
    header('Content-Type: application/json');
    echo json_encode($bakiyesonuc);
    exit;
} else {
    $amount = $data['amount'];
}

if ($data['action'] == 'bet') {
    $bet = floatval($amount);    
    $kontrol1 = $db->get_where('transactions', ['transaction_id' => $data['transaction_id']])->row();

    if ($kontrol1) {
        $bakiyesonuc4 = array (
            "transaction_id" => $kontrol1->bet_transaction_id,
            "balance" => number_format($users->bakiye, 4, '.', ''),
        );
        header('Content-Type: application/json');
        echo json_encode($bakiyesonuc4);
        exit;
    } 
    $balanceFirst = $users->bakiye;

    if ($balanceFirst >= $bet || $data['type'] == 'freespin') {
        $newBetBalance = floatval($balanceFirst - $bet);
        if ($data['type'] == 'freespin') {
            # ignore the balance deduction
            $newBetBalance = floatval($balanceFirst);
        }
        $db->update('admin', ['bakiye' => $newBetBalance], ['id' => $userId]);
        $transaction_id_res = md5(uniqid(mt_rand(), true));
        $data2 = array (
            'player_id' => $userId,
            'action' => $data['action'],
            'amount' => $data['amount'],
            'transaction_id' => $data['transaction_id'],
            'bet_transaction_id' => $transaction_id_res,
            'type' => $data['type'],
            'type' => $data['type'],
            'game_uuid' => $data['game_uuid'],
            'currency' => $data['currency'],
            'session_id' => $data['session_id'],
            'round_id' => $data['round_id'],
            'balance_before' => $balanceFirst,
            'balance_after' => $newBetBalance
        );    
        $db->insert('transactions', $data2);
        $bakiyesonuc5 = array (
            "transaction_id" => $transaction_id_res,
            "balance" => number_format($newBetBalance, 4, '.', ''),
        );
        header('Content-Type: application/json');
        echo json_encode($bakiyesonuc5);
        exit;
    } else {
        $bakiyesonuc1 = array (
            "error_code" => "INSUFFICIENT_FUNDS",
            "error_description" => "Not enough money to continue playing"
        );
        header('Content-Type: application/json');
        echo json_encode($bakiyesonuc1);
        exit;
    }
}
elseif ($data['action'] == 'win') {
    $kontrol = $db->get_where('transactions', ['transaction_id' => $data['transaction_id']])->row();
    if ($kontrol) {
        $finalBalance = $users->bakiye;
        $response = array(
            "transaction_id" => $kontrol->bet_transaction_id,
            "balance" => number_format($finalBalance, 4, '.', ''),
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $balanceBeforeWin = $db->get_where('admin', array('id' => $userId))->row()->bakiye;
    if ($amount != 0) {
        $newWinBalance = floatval($balanceBeforeWin + $amount);
        $db->update('admin', ['bakiye' => $newWinBalance], ['id' => $userId]);
    }
    $bakiyequery4 = $db->get_where('admin', array('id' => $userId));
    $yenibakiye = $bakiyequery4->row()->bakiye;

    $transaction_id_res = md5(uniqid(mt_rand(), true));

    $data2 = [
        'player_id' => $userId,
        'action' => $data['action'],
        'amount' => $data['amount'],
        'transaction_id' => $data['transaction_id'],
        'bet_transaction_id' => $transaction_id_res,
        'type' => $data['type'],
        'game_uuid' => $data['game_uuid'],
        'currency' => $data['currency'],
        'session_id' => $data['session_id'],
        'round_id' => $data['round_id'],
        'balance_before' => $balanceBeforeWin,
        'balance_after' => $yenibakiye
    ];
    $db->insert('transactions', $data2);
    
    $response = [
        "transaction_id" => $transaction_id_res,
        "balance" => number_format($yenibakiye, 4, '.', ''),
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

elseif ($data['action'] == 'refund') {
    // İlgili bet işlemi zaten refund edilip edilmediğini kontrol edelim.
    $kontrol = $db->get_where('transactions', [
        'transaction_id' => $data['transaction_id']
    ])->row();
    if ($kontrol) {
        $finalBalance = $users->bakiye;
        $response = [
            "balance" => number_format($finalBalance, 4, '.', ''),
            "transaction_id" => $kontrol->bet_transaction_id,
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;        
    } else {
        // Eğer refund işlemi yapılmamısa, işlemi gerçekleştirelim.
        // İlk olarak bet işleminin var olup olmadığını kontrol edelim.
        $bet_kontrol = $db->get_where('transactions', [
            'transaction_id' => $data['bet_transaction_id'],
            'action' => 'bet'
        ]);

        // Eğer bet işlemi mevcutsa, bakiyeyi güncelleyelim.
        if (!$bet_kontrol->row()) {
            // Refund işlemini transactions tablosuna kaydedelim.
            $transaction_id_res = md5(uniqid(mt_rand(), true));
            $data2 = [
                'player_id' => $userId,
                'action' => 'refunded',
                'amount' => $data['amount'],
                'transaction_id' => $data['bet_transaction_id'],
                'bet_transaction_id' => $transaction_id_res,
                'type' => $data['type'],
                'game_uuid' => $data['game_uuid'],
                'currency' => $data['currency'],
                'session_id' => $data['session_id'],
                'round_id' => $data['round_id'],
                'balance_before' => $users->bakiye,
                'balance_after' => $users->bakiye
            ];
            $db->insert('transactions', $data2);
            $response = [
                "balance" => number_format($users->bakiye, 4, '.', ''),
                "transaction_id" => $transaction_id_res
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            $refund_amount = floatval($data['amount']);  
            $balanceBeforeRefund = $users->bakiye;
            if ($refund_amount != 0) {
                $newBalance = floatval($balanceBeforeRefund + $refund_amount);
                $db->update('admin', ['bakiye' => $newBalance], ['id' => $userId]);
            }
            $bakiyequery4 = $db->get_where('admin', array('id' => $userId));
            $finalBalance = $bakiyequery4->row()->bakiye;
            $transaction_id_res = md5(uniqid(mt_rand(), true));
            $db->update('transactions', ['bet_transaction_id' => $transaction_id_res, 'action' => 'refund'], ['transaction_id' => $data['bet_transaction_id']]);
            $response = [
                "balance" => number_format($finalBalance, 4, '.', ''),
                "transaction_id" => $transaction_id_res
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}
elseif ($data['action'] == 'rollback') {
    
    // Eğer gelen transaction_id zaten varsa bakiyeyi ekrana yaz ve işlemi sonlandır.
    $transaction_history = $db->get_where('transactions', ["transaction_id" => $data['transaction_id']])->row();
    if ($transaction_history) {
        $finalBalance = $users->bakiye;
        $response = [
            "balance" => number_format($finalBalance, 4, '.', ''),
            "transaction_id" => $transaction_history->bet_transaction_id,
            "rollback_transactions" => []
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $rollback_transactions_res = array();
    $rollback_amount = 0;
    $rollback_transactions = $data['rollback_transactions'];
    foreach ($rollback_transactions as $rollback_tran) {
        $trans_action = $rollback_tran['action'];
        $trans_amount = $rollback_tran['amount'];
        $trans_id = $rollback_tran['transaction_id'];
        $toRollback_transaction_history = $db->get_where('transactions', ["transaction_id" => $trans_id, "action" => $trans_action])->row();
        
        if (!$toRollback_transaction_history) {
            # ignore & save the trans and return success with new trans_id
            $bakiyequery4 = $db->get_where('admin', array('id' => $userId));
            $balance = $bakiyequery4->row()->bakiye;
            $transaction_id_res = $trans_id;
            $data2 = [
                'player_id' => $userId,
                'action' => 'rollbacked',
                'amount' => $trans_amount,
                'transaction_id' => $trans_id,
                'bet_transaction_id' => $transaction_id_res,
                'type' => $rollback_tran['type'],
                'game_uuid' => $data['game_uuid'],
                'currency' => $data['currency'],
                'session_id' => $data['session_id'],
                'round_id' => $data['round_id'],
                'balance_before' => $balance,
                'balance_after' => $balance  // Bu değeri güncelleyeceğiz, bu yüzden önce başlangıç bakiyesi olarak belirttik.
            ];
            $db->insert('transactions', $data2);
            array_push($rollback_transactions_res, $transaction_id_res);
        } else {
            $bakiyequery4 = $db->get_where('admin', array('id' => $userId));
            $balanceBeforeRollback = $bakiyequery4->row()->bakiye;
            if($trans_action == 'bet')
            {
                #increase user balance and decrease in_amount
                $newBalance = floatval($balanceBeforeRollback + $trans_amount);
                $db->update('admin', ['bakiye' => $newBalance], ['id' => $userId]);
            }elseif ($trans_action == 'refund') {
                #decrease user balance and increase in_amount
                $newBalance = floatval($balanceBeforeRollback - $trans_amount);
                $db->update('admin', ['bakiye' => $newBalance], ['id' => $userId]);
            }elseif ($trans_action == 'win') {
                #decrease user balance and decrease out_amount
                $newWinBalance = floatval($balanceBeforeRollback - $trans_amount);
                $db->update('admin', ['bakiye' => $newWinBalance], ['id' => $userId]);
            }
            $transaction_id_res = $trans_id;
            array_push($rollback_transactions_res, $transaction_id_res);
            $rollback_amount += $trans_amount;
        }
    }

    $transaction_id_res = md5(uniqid(mt_rand(), true));
    $bakiyequery4 = $db->get_where('admin', array('id' => $userId));
    $finalBalance = $bakiyequery4->row()->bakiye;
    $data3 = [
        'player_id' => $userId,
        'action' => 'rollback',
        'amount' => $rollback_amount,
        'transaction_id' => $data['transaction_id'],
        'bet_transaction_id' => $transaction_id_res,
        'type' => $data['type'],
            'game_uuid' => $data['game_uuid'],
            'currency' => $data['currency'],
            'session_id' => $data['session_id'],
            'round_id' => $data['round_id'],
            'balance_before' => $users->bakiye,
            'balance_after' => $finalBalance
    ];
    $db->insert('transactions', $data3);
   
    $response = [
        "balance" => number_format($finalBalance, 4, '.', ''),
        "transaction_id" => $transaction_id_res,
        "rollback_transactions" => $rollback_transactions_res
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>