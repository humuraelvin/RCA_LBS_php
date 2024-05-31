<?php

class home extends controller {

    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
		$izinliler = explode(",", $GLOBALS["login"]);

        $this->admin->is_login();
   }

    

    function index() {		
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");


        $bannerlar = $this->db->result("select * from bannerlar order by `index` ASC");
        $bannerlar = json_decode(json_encode($bannerlar));

        $duyuru = $this->db->aresult("select * from duyuru where aktif = 1");
        $duyuru = json_decode(json_encode($duyuru));



        $this->view->display("login.tpl", get_defined_vars());
      
    }


    function Promotions()
    {
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");

        $promosyonlar = $this->db->result("select * from promosyonlar order by sira ASC");
        $promosyonlar = json_decode(json_encode($promosyonlar));

        $this->view->display("promotions.tpl",get_defined_vars());
    }



}