<?php


class LiveCasino extends controller {

    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $this->user = $this->load->library("user");
        $this->cookie = $this->load->library("cookie");

    }

    public function index() {
        $this->load->library('Mobile_Detect');
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();

        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");



        $casino_banners = $this->db->result("select * from casino_banners where live = 0 order by RAND()"); //order by `index` ASC
        $casino_banners = json_decode(json_encode($casino_banners));


        $detect = new Mobile_Detect();

        // Cihazın mobil olup olmadıın kontrol ediyoruz.
        if ($detect->isMobile()) {
            $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 1 AND is_mobile = 1 ORDER BY RAND()");
        } else {
            $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 1 AND is_mobile = 0 ORDER BY RAND()");
        }


//        $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 1 AND is_mobile = 0 ORDER BY RAND()");
        $casino_games = json_decode(json_encode($casino_games));
        
        $list = [];
        foreach ($casino_games as $games) {
            $section = $games->type;  // "type" alanını oyunun bölümü olarak kabul ediyoruz
            
            $list[$section][$games->id]['game_name'] = $games->name;
            $list[$section][$games->id]['game_type'] = $games->type;
            $list[$section][$games->id]['game_image'] = $games->image;
            $list[$section][$games->id]['game_section'] = $games->provider; 
            // Ek alanları da ekleyebilirsiniz, örnek olarak:
//            $list[$section][$games->id]['provider'] = $games->provider;
            // Ancak bu kod parçacığında belirtilen alanları ekledim. 
            // Diğerleri için benzeri bir yapı kullanarak devam edebilirsiniz.
        }

        $this->view->display("livecasinolive.tpl", get_defined_vars());
    }


    public function Slot() {
        $this->load->library('Mobile_Detect');
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();

        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");



        $casino_banners = $this->db->result("select * from casino_banners where live = 0 order by RAND()"); //order by `index` ASC
        $casino_banners = json_decode(json_encode($casino_banners));


        $detect = new Mobile_Detect();

        // Cihazın mobil olup olmadığını kontrol ediyoruz.
        if ($detect->isMobile()) {
            $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 0 AND is_mobile = 1 AND `type`= 'slots' ORDER BY RAND()");
        } else {
            $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 0 AND is_mobile = 0 AND `type`= 'slots' ORDER BY RAND()");
        }


//        $casino_games = $this->db->result("SELECT * FROM slotegrator_games WHERE has_lobby = 0 AND is_mobile = 0 AND `type`= 'slots' ORDER BY RAND()");
        $casino_games = json_decode(json_encode($casino_games));
        
        $list = [];
        foreach ($casino_games as $games) {
            $section = $games->type;  // "type" alanını oyunun bölümü olarak kabul ediyoruz
            
            $list[$section][$games->id]['game_name'] = $games->name;
            $list[$section][$games->id]['game_type'] = $games->type;
            $list[$section][$games->id]['game_image'] = $games->image;
            $list[$section][$games->id]['game_section'] = $games->provider; 
            // Ek alanları da ekleyebilirsiniz, rnek olarak:
//            $list[$section][$games->id]['provider'] = $games->provider;
            // Ancak bu kod parçacığnda belirtilen alanları ekledim. 
            // Diğerleri iin benzeri bir yapı kullanarak devam edebilirsiniz.
        }
        
        $this->view->display("livecasino.tpl", get_defined_vars());
    }




    public function Token($id){
        header('Content-Type: application/json');
        //Casino Bilgileri
        $casino_id = security($id);
        $find_casino = $this->db->aresult("SELECT * FROM slotegrator_games WHERE id = $casino_id");
        if (empty($find_casino)) { die("Casino xx Bulunamadı"); }
        $game_name = $find_casino['name'];
        $game_type = $find_casino['type'];
        $table_id = $find_casino['uuid'];
        $lang = "tr";
        $currency = "TRY";

        //uye Bilgileri
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
        $username = REDIS_KEY.'_'.$bilgi['username'];
        $username2 = $bilgi['username'];
        $email = $bilgi['email'];

        $host = $_SERVER['HTTP_HOST'];
        $url = '';
        if (empty($bilgi)) {
            $data = array("method" => "token", "user_id" => 0, "username" => "demo", "name" => "demo");
            $response = httpPost("http://$host", $data);
            $response = json_decode($response);
            echo $response;
        } else {
            $data = array("method" => "token", "user_id"=> $userid, "username" => $username2, "name" => $name, "email" => $email, "game_id" => $table_id, "currency" => $currency, "lang" => "en");
            $response = httpPost("https://$host/play.php", $data);
            //var_dump($response);die;
            //esponse = json_decode($response);
            $url = $response;
            // $url = "https://$host/play.php?user_id=".$userid."&game_id=".$table_id."&username=".$username2."&currency=".$currency."&lang=en&email=" . $email;
            // $this->db->update("hogaming_users", array("token" => $response->token), array("user_id" => $user_id));
        }
        
        // $data = ["code" => "1", "url" => $url, "token" => $response->token, "success" => true];
        $data = ["code" => "1", "url" => $url, "success" => true];
        echo json_encode($data);

    }
    function Game($id) {
        $casino_id = security($id);



        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");
        if(empty($bilgi)){
            die("Oyun oynamak için giriş yapınız.");
        }else{
          $find_casino = $this->db->aresult("SELECT * FROM casino_games WHERE id = $casino_id");
          if (empty($find_casino)) { die("Casino Bulunamadı"); }

          $this->view->display("opengame.tpl", get_defined_vars());
    	}
    }
}
?>