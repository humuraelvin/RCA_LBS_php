<?php

class signin extends controller {


    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $izinliler = explode(",", $GLOBALS["login"]);

    }


    function index($ref="")
    {
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();

        $ref = explode('=', security($_SERVER['REQUEST_URI']))[1];
        if ($ref) {
            setcookie("ref", $ref);
            $ref = explode('=', security($_SERVER['REQUEST_URI']))[1];
        } else {
            $ref = $_COOKIE['ref'];
        }





        if ( $login == 1 ) {
            $this->view->display("newcustomer.tpl", get_defined_vars());
        } else header("Location:" . BASE_URL);
    }




}
?>