<?php
class Aviator extends controller {

    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $this->user = $this->load->library("user");
        $this->cookie = $this->load->library("cookie");

    }

    public function index() {
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();

        $user_cookie = @$_SESSION['username'];
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");
        
        $this->view->display("jetx.tpl", get_defined_vars());
    }



}
?>
