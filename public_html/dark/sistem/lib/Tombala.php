<?php

	/*
	 * @author : Idris Kahraman
	 * @mail   : idriskhrmn@outlook.com
	 * @date   : 25.08.2016
	 * @file   : Tombala.php
	 # Tombala Service API #
	*/

	class Tombala {

		public $sellerId 	= '57bee098647e3478681b79c4';
		public $privateKey 	= 'hwSY027BXtXPNJhyOvCzY8NwTxt2PKDJ';

		public function __construct() {
			//
		}

		public function tombalaHash ( $array ) {
			$array['hash'] = md5 ( implode('', array_values( $array ) ) . $this->privateKey );
			return $array;
		}

		public function Token( $username ) {
			return $this->req([
				'method' => 'user/token',
				'sellerId' => $this->sellerId,
				'username' => $username
			])->data;
		}

		public function userCheck( $values ) {
			return $this->req([
				'method' => 'user/check',
				'sellerId' => $this->sellerId,
				'username' => $values['username']
			]);
		}

		public function userCreate( $values ) {
			return $this->req([
				'method' => 'user/create',
				'sellerId' => $this->sellerId,
				'username' => $values['username']
			]);
		}

		public function userDeposit( $values ) {
			return $this->req([
				'method' => 'user/deposit',
				'sellerId' => $this->sellerId,
				'username' => $values['username'],
				'amount' => $values['amount'],
				'token' => $this->Token( $values['username'] )
			]);
		}

		public function userDraw( $values ) {
			return $this->req([
				'method' => 'user/draw',
				'sellerId' => $this->sellerId,
				'username' => $values['username'],
				'amount' => $values['amount'],
				'token' => $this->Token( $values['username'] )
			]);
		}

		public function Lobby( $username ) {
			return 'https://tombalalive.com/service/' . $this->Token( $username );
		}

		public function req( $data ) {

			$method = $data['method'];
			unset( $data['method'] );

			$ch = curl_init();
			curl_setopt($ch , CURLOPT_URL, 'https://www.tombalalive.com/api/service/v1.1/' . $method);
			curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);
			curl_setopt($ch , CURLOPT_FOLLOWLOCATION , TRUE);
			curl_setopt($ch , CURLOPT_VERBOSE , true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch , CURLOPT_REFERER , 'https://marinbet.com');
			curl_setopt($ch , CURLOPT_USERAGENT , $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_HEADER, false);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->tombalaHash($data)));
			return json_decode( curl_exec($ch) );

		}

	}
