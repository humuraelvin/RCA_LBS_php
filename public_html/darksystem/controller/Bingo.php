<?php

class Bingo extends controller {

    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $this->user = $this->load->library("user");
        $this->cookie = $this->load->library("cookie");
    }

    public function index(){
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");
        $user_id = $bilgi['id'];
        $name = $bilgi['name'];
        $username = $bilgi['username'];

        if (empty($bilgi)) {
            $data = array("method" => "token", "key" => LIVEGAMES_KEY, "secret" => LIVEGAMES_SECRET, "username" => "demo", "name" => "demo");
            $response = httpPost("https://livegames.brongaming.com",$data);
            $response = json_decode($response);
        } else {
            $user_control = $this->db->aresult("SELECT * FROM livegames_users WHERE user_id = $userid");
            if ( isset($user_control['id']) ) {
                $data = array("method" => "token", "key" => LIVEGAMES_KEY, "secret" => LIVEGAMES_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
                $this->db->update("livegames_users", array("token" => $response->token), array("user_id" => $user_id));
            } else {
                $data = array("method" => "token", "key" => LIVEGAMES_KEY, "secret" => LIVEGAMES_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
                if ($response->success == true) {
                    $addUser = $this->db->insert('livegames_users', ['user_id' => $user_id, 'token' => $response->token]);
                    if (!$addUser) {
                        die("DB hatasi, lutfen bildiriniz.");
                    }
                }
            }
        }

        $this->view->display("bingo.tpl", get_defined_vars());

    }




    public function Transfer() {


        //üye Bilgileri
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");

        if (empty($bilgi)) { die("Üye Girişi Yapınız."); }

        $user_id = $bilgi['id'];
        $name = $bilgi['name'];
        $username = $bilgi['username'];

        $amount = security($_POST["amount"]);
        $method = security($_POST["method"]);

        $artibakiye = $bilgi["bakiye"] + $amount;
        $eksibakiye = $bilgi["bakiye"] - $amount;

        if (balance_control($amount)) { die("Lütfen Miktarı Kontrol Edin."); }
        if($amount < 1) { die("Lütfen Miktarı Boş Bırakmayınız."); }

        if ($bilgi['tombala'] == '0') { die("Transfer erişiminiz kapatılmıştır.Lütfen canlı destek ile iletişime geçiniz."); }


        if ($method == "Deposit") {

            if($eksibakiye < 0) { die("Bakiyeniz bu işlem için yeterli değildir."); }
            if ($amount > $bilgi["bakiye"]) { die("Bakiyeniz bu işlem için yeterli değildir."); }
            $user_control = $this->db->aresult("SELECT * FROM livegames_users WHERE user_id = $userid");

            if ( isset($user_control['id']) ) {
                $data = array("method" => "deposit", "key" => LIVEGAMES_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name, "amount" => $amount);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
            } else {
                $data = array("method" => "token", "key" => LIVEGAMES_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
                if ($response->success == true) {
                    $addUser = $this->db->insert('livegames_users', ['user_id' => $user_id, 'token' => $response->token]);
                    if (!$addUser) {
                        die("DB hatasi, lutfen bildiriniz.");
                    }
                }
                $data = array("method" => "deposit", "key" => LIVEGAMES_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name, "amount" => $amount);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
            }

            if ($response->success == 1) {
                $balanceupdate = $this->db->update("admin", array("bakiye" => $eksibakiye), array("id" => $user_id));
                if ($balanceupdate == false) { die("Bir Hata Oluştu."); }

                $this->db->insert("log", array(
                    "islemad" => "Bakiye Transferi ( Ana Bakiye -> Tombala )",
                    "userid" => $userid,
                    "tutar" => $amount,
                    "tarih" => date("Y-m-d H:i:s"),
                    "oncekibakiye" =>$bilgi["bakiye"],
                    "sonrakibakiye" =>$bilgi["bakiye"] -  $amount
                ));
                die("Bakiye Başarıyla Aktarıldı");
            } else {
                die($response->description);
            }

        } elseif ( $method == "Withdraw" ) {

            $user_control = $this->db->aresult("SELECT * FROM livegames_users WHERE user_id = $userid");
            if ( isset($user_control['id']) ) {
                $data = array("method" => "balance", "key" => LIVEGAMES_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
                $balance = $response->balance;
            } else {
                $balance = "0.00";
            }
            if (($balance == 0) || empty($balance)) { die("Bakiyeniz Bu İşlem İçin Yetersizdir."); }
            if($amount > $balance) { die("Transfer Edeceğiniz Tutar Casino Bakiyenizden Büyük Olamaz."); }

            $data = array("method" => "withdraw", "key" => LIVEGAMES_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name, "amount" => $amount);
            $response = httpPost("https://livegames.brongaming.com",$data);
            $response = json_decode($response);

            if ($response->success == 1) {
                $balanceupdate = $this->db->update("admin", array("bakiye" => $artibakiye), array("id" => $user_id));
                if ($balanceupdate == false) { die("Bir Hata Oluştu."); }

                $this->db->insert("log", array(
                    "islemad" => "Bakiye Transferi ( Tombala -> Ana Bakiye )",
                    "userid" => $userid,
                    "tutar" => $amount,
                    "tarih" => date("Y-m-d H:i:s"),
                    "oncekibakiye" =>$bilgi["bakiye"],
                    "sonrakibakiye" =>$bilgi["bakiye"] + $amount
                ));
                die("Bakiye Başarıyla Aktarıldı");
            } else {
                die($response->description);
            }
        }
    }
    
    
    
    


}

?>