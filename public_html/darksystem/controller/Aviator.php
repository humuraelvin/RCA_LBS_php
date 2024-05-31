<?php
class Aviator extends controller {

    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $this->user = $this->load->library("user");
        $this->cookie = $this->load->library("cookie");

    }

    public function index() {
        // var_dump('aviator.php');die;
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $host = $_SERVER['HTTP_HOST'];

        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");
        //call play.php to call /gameinit for aviator game
        if ($cookie_username != '') {
            $game_id = '9d9b5b34389337d4e43568b4ba2d56be97de447a'; // Aviatrix game
            $currency = 'TRY';
            $data = array("method" => "aviator", "user_id"=> $userid, "username" => $cookie_username, "game_id" => $game_id, "currency" => $currency, "lang" => "tr");
            $iframe_url = httpPost("https://$host/play.php", $data);
            $this->view->display("aviator.tpl", get_defined_vars());
        }
    }
}
?>
