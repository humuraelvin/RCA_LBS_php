<?php

	/*
	 * # Ezugi #
	 * @file 	: ezugi.class.php
	 * @author  : Idris Kahraman
	 * @date    : 05.03.2017 02:32
	*/

	class Ezugi {

		public $AgentID;
		public $Username;
		public $Key = '5bc684c12eefb636b307dbff6c95f900';

		// URL's
		public $Register_URL 	= 'https://oms.eld88.com/agent_api/player/register.php';
		public $Login_URL    	= 'https://oms.eld88.com/agent_api/player/login.php';
		public $Deposit_URL 	= 'https://oms.eld88.com/agent_api/cashier/funds_transfer_to_player.php';
		public $Draw_URL 	= 'https://oms.eld88.com/agent_api/cashier/funds_transfer_from_player.php';
		public $Game_URL        = 'https://oms.eld88.com/agent_api/player/game_token.php';

		public function __construct( $config ) {
			$this->AgentID 	= $config['agent_id'];
			$this->Username = $config['username'];
		}

		public function register( $values ) {
			$query = [
				'agent_id' => $this->AgentID,
				'username' => $this->Username,
				'player_username' => $values['username'],
				'player_password' => $values['password'],
				'nickname' => $values['username'],
				'session_ip' => $_SERVER['REMOTE_ADDR']
			];

			return $this->req( [
				'url' 	=> $this->Register_URL,
				'query' => http_build_query($query) . '&request_token=' . $this->requestToken($query)
			] );
		}

		public function login( $values ) {
			$query = [
				'agent_id' => $this->AgentID,
				'username' => $this->Username,
				'player_username' => $values['username'],
				'player_password' => $values['password'],
				'session_ip' => $_SERVER['REMOTE_ADDR'],
				'login' => 'new'
			];

			return $this->req( [
				'url' 	=> $this->Login_URL,
				'query' => http_build_query($query) . '&request_token=' . $this->requestToken($query)
			] );
		}

		public function deposit ( $values ) {
			$query = [
				'agent_id' => $this->AgentID,
				'username' => $this->Username,
				'payment_method' => '1',
				'amount' => $values['amount'],
				'session_token' => $values['token']
			];

			return $this->req( [
				'url' 	=> $this->Deposit_URL,
				'query' => http_build_query($query) . '&request_token=' . $this->requestToken($query)
			] );
		}

		public function draw( $values ) {
			$query = [
				'agent_id' => $this->AgentID,
				'username' => $this->Username,
				'payment_method' => '1',
				'amount' => $values['amount'],
				'session_token' => $values['token']
			];

			return $this->req( [
				'url' 	=> $this->Draw_URL,
				'query' => http_build_query($query) . '&request_token=' . $this->requestToken($query)
			] );
		}

		public function games( $values ) {
			$query = [
				'agent_id' => $this->AgentID,
				'username' => $this->Username,
				'session_ip' => $_SERVER['REMOTE_ADDR'],
				'provider_id' => $values['provider_id'],
				'session_token' => $values['token']
			];

			return $this->req( [
				'url' 	=> $this->Game_URL,
				'query' => http_build_query($query) . '&request_token=' . $this->requestToken($query)
			] );
		}

		public function requestToken( $array ) {
			return hash('sha256' , $this->Key . http_build_query($array) );
		}

		public function req($parameters) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $parameters['url'] . '?' . $parameters['query']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters['query']);
			$req = json_decode( curl_exec( $ch ) );
			return $req;
		}

	}

?>
