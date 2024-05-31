<?php

class paycallback extends controller {
  function __construct() {
      parent::controller();


  }

    function index() {
        $this->log_raw_request();
        echo 'Test';
    }

    private function log_raw_request() {
      $raw_post_data = file_get_contents('php://input');
      $get_data = $_GET;
  
      $output = [
          'method' => $_SERVER['REQUEST_METHOD'],
          'raw_data' => $raw_post_data ? $raw_post_data : $get_data,  // Eğer raw_post_data boşsa, GET verisini kullan
          'timestamp' => date("Y-m-d H:i:s"),
      ];
  
      file_put_contents('request_log.txt', json_encode($output) . PHP_EOL, FILE_APPEND);
  }

  
}