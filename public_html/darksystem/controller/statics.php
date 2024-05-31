<?php

class statics extends controller {
	

	function __construct() {
        parent::controller();
	  	$this->admin=$this->load->model("admin");
	  	$this->user=$this->load->library("user");
	  	$this->cookie=$this->load->library("cookie");
    }


	function index() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
    }
	
	function livescore() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();		
  		$userid = $this->admin->user_id();
		$this->view->display("livescore.tpl", get_defined_vars());
	}

    
    function sss() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();		
  		$userid = $this->admin->user_id();
		$this->view->display("dark_sss.tpl", get_defined_vars());
    }
	
	function genelkurallar() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_genelkurallar.tpl", get_defined_vars());
    }

	function odemeyontemleri() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_odemeyontemleri.tpl", get_defined_vars());
    }

	function sorumluoyun() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_sorumluoyun.tpl", get_defined_vars());
    }

	function bahiskurallari() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_bahiskurallari.tpl", get_defined_vars());
    }

	function gizlilik() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_gizlilik.tpl", get_defined_vars());
    }

	function bizeulasin() {
		$user = $this->admin->getinfo();
		$login = $this->admin->is_login();
		$this->view->display("dark_bizeulasin.tpl", get_defined_vars());
    }


	
	
}
?>