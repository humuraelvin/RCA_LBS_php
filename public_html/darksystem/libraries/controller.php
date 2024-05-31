<?php
class controller extends base{

    public static $promotions;

    function controller(){
        global $base;
        foreach($base["autoload"] as $value){
            $this->$value=&$base[$value];
        }

        $NewDatabase = new NewDatabase();
        $this->pdo = $NewDatabase->getConnection();





        //Domain Yönlendirme
        $darkquerystring = explode("/",$_SERVER['QUERY_STRING'])[0];

        $filter = ['ccb=BronGamingLoad'];

        if (!in_array($darkquerystring, $filter) ) {
            $domains = $this->db->aresult("SELECT * FROM domain WHERE status = 1");
            if ($_SERVER["SERVER_NAME"] != $domains['name']) {
                header("Location: http://".$domains['name'].$_SERVER["REQUEST_URI"]);
            }
        }

        $xml_services = $this->db->result("SELECT * FROM odd_services WHERE active = 1");
        define('SITE_MATCH_LIST', $xml_services[0]['list']);
        define('SITE_MATCH_ODDS', $xml_services[0]['odds']);




        /* Log */
        $Log = [];

        $this->admin = $this->load->model("admin");

        $Invalid_Query = [
            'ccb=ajax/get_info',
            'ccb=playgonetwork/play_list',
            'ccb=as2su1max2433/alparslanozgur',
            'ccb=services/promotionsList',
            'ccb=as2su1max2433/darkAlparslan',
            'ccb=playgonetwork/play_result',
            'ccb=services/getLiveMatches',
            'ccb=services/livematchtracker',
            'ccb=sports/mycoupons',

        ];

        if ( !in_array($_SERVER['QUERY_STRING'], $Invalid_Query) AND $_SERVER['HTTP_COOKIE'] != '' AND !isset(explode('livedetails/', $_SERVER['QUERY_STRING'])[1])) {

            $Log['http_code'] = http_response_code();
            $Log['request_method'] = $_SERVER['REQUEST_METHOD'];
            $Log['ip'] =  getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                    getenv('HTTP_X_FORWARDED')?:
                        getenv('HTTP_FORWARDED_FOR')?:
                            getenv('HTTP_FORWARDED')?:
                                getenv('REMOTE_ADDR');
            $Log['ajax'] = (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) ? 1 : 0;
            $Log['post_args'] = ( $_SERVER['REQUEST_METHOD'] == 'POST' ) ? json_encode($_POST) : 0;
            $Log['url'] = $_SERVER['REQUEST_URI'];
            $Log['request_time'] = $_SERVER['REQUEST_TIME'];
            $Log['cookie'] = $_SERVER['HTTP_COOKIE'];
            $Log['session'] = json_encode($_SESSION);
            $Log['query_string'] = $_SERVER['QUERY_STRING'];
            $Log['user'] = ( $this->admin->is_login() == '1' ) ? 0 : json_encode($this->admin->getinfo());
            $Log['user_id'] = ( $this->admin->is_login() == '1' ) ? 0 : $this->admin->user_id();

            $this->db->insert("server_logs", $Log);

        }
    }
    function _update($name){
        global $base;
        $this->$name=&$base[$name];
    }
}