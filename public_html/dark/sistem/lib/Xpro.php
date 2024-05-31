<?php



	/*

	 * @date   : 27.07.2016

	 * @file   : class.xpro.php

	 ========== xProGaming =========

	*/



	class xPro {



		public $opId;

		public $opName;

		public $privateKey;

		public $db;

		private $apiUrl = 'https://api.xprogaming.com/Services/ExternalApi.svc';

		public $language;

		public $gameProvider;

		public $currency;



		function __construct($values) {

			$this->opName = 'TK-SW-MikanosBet-TRY';

			$this->opId = XPRO_OPERATOR_ID;

			$this->privateKey = XPRO_PRIVATE_KEY;

			$this->language = 'tr';

			$this->gameProvider = 'MicroMarkets';

			$this->currency = 'TRY';



			//$this->db = new PDO('mysql:host=localhost;dbname=mikanosb_mika', 'mikanosb_mika', '221187as', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

		}



		/*

		 * create account

		*/

		public function createAccount( $values ) {

			$request = $this->sendRequest([

				'method' => 'createAccount',

				'operatorId' => $this->opId,

				'username' => $values->username,

				'userPassword' => $values->userPassword,

				'firstName' => $values->firstName,

				'lastName' => $values->lastName,

				'accountID' => $values->accountID,

				'isExternalWallet' => $values->isExternalWallet,

				'Nickname' => $values->Nickname,

			]);

			if ($request->errorCode == 0) {

				return (object) $request;

			} else {

				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];

			}

		}



		/*

		 * get account balance

		*/

		public function getAccountBalance ($values) {

			$request = $this->sendRequest([

				'method' => 'getAccountBalance',

				'operatorId' => $this->opId,

				'username' => $values->username

			]);

			if ($request->errorCode == 0) {

				return (object) $request;

			} else {

				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];

			}

		}



		/*

		 * accountDeposit

		*/

		public function accountDeposit ($values) {

			$request = $this->sendRequest([

				'method' => 'accountDeposit',

				'operatorId' => $this->opId,

				'username' => $values->username,

				'amount' => $values->amount,

				'transactionID' => uniqid()

			]);

			if ($request->errorCode == 0) {

				return (object) $request;

			} else {

				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];

			}

		}



		/*

		 * accountWithdrawal

		*/

		public function accountWithdrawal ($values) {

			$request = $this->sendRequest([

				'method' => 'accountWithdrawal',

				'operatorId' => $this->opId,

				'username' => $values->username,

				'amount' => $values->amount,

				'transactionID' => uniqid(),

				'currency' => $this->currency

			]);

			if ($request->errorCode == 0) {

				return (object) $request;

			} else {

				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];

			}

		}



		/*

		 * getExternalGameURL

		*/

		public function getExternalGameURL ($values) {

			$request = $this->sendRequest([

				'method' => 'getExternalGameURL',

				'operatorId' => $this->opId,

				'username' => $values->username,

				'gameId' => $values->gameId ,

				'gameProvider' => $this->gameProvider,

				'language' => $this->language,

			]);

			if ($request->errorCode == 0) {

				return (object) $request;

			} else {

				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];

			}

		}


		public function getExternalGamesList ($values = array()) {

			$request = $this->sendRequest([
				'method' => 'getExternalGamesList',
				'operatorId' => $this->opId,
				'gameProvider' => 'BetSoft',
				'platformType' => 'All'
			]);

			if ($request->errorCode == 0) {
				return (object) $request;
			} else {
				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];
			}

		}

		public function registerToken( $values ) {
			$request = $this->sendRequest([
				'method' => 'registerToken',
				'operatorId' => $this->opId,
				'username' => $values->username,
				'props' => $values->props,
				'limitsetid' => $values->limitsetid
			]);

			return $request;
		}

		public function getGamesListWithLimits ($values) {

			$request = $this->sendRequest([
				'method' => 'getGamesListWithLimits',
				'operatorId' => $this->opId,
				'username' => $values->username,
				'gameType' => 0,
				'onlineOnly' => true
			]);

			if ($request->errorCode == 0) {
				return (object) $request;
			} else {
				return (object) [ 'error' => true, 'message' => $this->errCode( (int) $request->errorCode ) ];
			}

		}

		public function gameHash ( $values ) {
			return strtoupper( md5 ( $this->privateKey . implode('', array_values( $values ) ) ) );
		}

		/*

		 * generating error

		*/

		public function errCode($index) {

			$errors = array(

				0 	=> "Tebrikler! ��leminiz ba�ar� ile ger�ekle�tirildi.",

				1 	=> "Ge�ersiz bakiye!",

				2 	=> "Live Casino hesab�m�zda b�yle bir kullan�c� bulunamad�.",

				3 	=> "Live Casino kullan�c� hesab�n�z aktifle�tirilemedi. Hata: Hesap kullan�mda.",

				4 	=> "Live Casino kullan�c� hesab�n�z aktifle�tirilemedi. Hata: Kullan�c� ad� kullan�mda, ba�ka bir kullan�c� se�in.",

				5 	=> "Eksik bilgi g�nderildi.",

				6 	=> "Yetkilendirme hatas�.",

				7 	=> "Giri� ba�ar�s�z.",

				8 	=> "Yasakl� kullan�c�.",

				9 	=> "Birden �ok hareket bulundu.",

				10 	=> "Ge�ersiz transfer miktar�.",

				11 	=> "Transfer talebi olu�tururken hata.",

				13 	=> "Hareket reddedildi.",

				15 	=> "Kullan�c� g�ncelle�tirirken hata.",

				16 	=> "Bu E-Posta adresi kullan�mda.",

				18 	=> "Para transferi yaparken hata: Hareket uyu�mazl���.",

				20 	=> "Ge�ersiz tarih aral���.",

				100 => "Bilinmeyen hata.",

				998 => "Bakiye g�ncellenemedi.",

				998 => "Hesap hareketi eklenemedi.",

				999 => "Veritaban� hatas�."

			);

			return $errors[ $index ];

		}



		/*

		 * generating hash

		*/

		public function hashSig($values) {

			$hash = $this->privateKey.''.http_build_query($values);

			$hash = strtoupper(md5( $hash ));



			$post = 'accessPassword='.$hash.'&'.http_build_query($values);

			return $post;

		}



		public function deleteMethod($arr) {

			return array_splice($arr, 1,count($arr));

		}



		public function sendRequest(array $data, $post = true) {

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/' . $data['method']);

			curl_setopt($ch, CURLOPT_HEADER, false);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_VERBOSE, true);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);

			if ($post) {

				curl_setopt($ch, CURLOPT_POST, 1);

				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->hashSig( $this->deleteMethod($data) ) );

			}

			curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);

			curl_setopt($ch , CURLOPT_FOLLOWLOCATION , TRUE);

			$result = curl_exec($ch);

			$xml = @(object) simplexml_load_string($result);

			return $xml;

			curl_close($ch);

		}







	}
