<?php

class live extends controller {
	

	function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $izinliler = explode(",", $GLOBALS["login"]);
		$this->admin->is_login();
       
    }
    
	function index($id) {
        $id = security($id);
        $user = $this->admin->getinfo();
		$bilgi = $this->db->aresult("select * from admin where id='$user[id]'");
		$login = $this->admin->is_login();

		if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    		$mobile = 1;
    	} else { $mobile = 0; }
		$this->view->display("liveyeni.tpl",get_defined_vars());
	}

	function events($id) {
        $id = security($id);
        header("Location: /live");
    }

    function search(){
        $urlArr = parse_url( $_SERVER['REQUEST_URI'] );
        parse_str($urlArr['query'], $query);
        $q = security($query['q']);
        if ( strlen($q) < 2 ) {
            echo '2 karekterden fazla arayiniz.';
            die;
        }

        $results = $this->db->result("SELECT * FROM `maclar` WHERE CONCAT(evsahibi, ' ', deplasman) LIKE '%$q%' AND oynuyormu = '1' AND aktifmi = '1'");
        foreach ($results as $result) {
            echo '<li onclick="livedetails('.$result["id"].',true); GetTracker('.$result["id"].');left_close();" style="margin: -8px; border-bottom: 12px solid #ddd" class="ac_even"><b>'.$result["evsahibi"].' - '.$result["deplasman"].'</b></li>';
        }
    }


	
}
?>