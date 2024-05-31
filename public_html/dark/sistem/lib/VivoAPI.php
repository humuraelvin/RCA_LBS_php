<?php

	class VivoAPI {

		public $casinoId    = VIVO_CASINO_ID;
		public $operatorId;
		public $serverId 		= VIVO_SERVER_ID;
		public $passKey 		= VIVO_PASS_KEY;
		public $AccountNumber 	= VIVO_ACCOUNT_NUMBER;
		public $AccountPin 		= VIVO_ACCOUNT_PIN;
		public $requestUrl 		= 'https://1vivo.com/IntegrationRequestHttp.aspx';
		public $requestArray 	= [];

		public function __construct($keys) {
			$this->operatorId 	= $keys['operatorId'];
			$this->requestArray['CasinoID'] = $this->casinoId;
			$this->requestArray['OperatorID'] = $this->operatorId;
			$this->requestArray['AccountNumber'] = $this->AccountNumber;
			$this->requestArray['AccountPin'] = $this->AccountPin;
		}

		#
		public function get($source, $key) {
			preg_match('~<'.$key.'>(.*?)</'.$key.'>~s', $source, $response);
			return (isset($response[1])) ? $response[1] : false;
		}
		## .

		public function deposit($arr) {
			$this->requestArray['UserName'] = $arr['username'];
			$this->requestArray['UserPWD']  = $arr['password'];
			$this->requestArray['UserID']   = $arr['id'];
			$this->requestArray['Amount']   = $arr['amount'];
			$this->requestArray['TransactionType'] = 'DEPOSIT';
			$this->requestArray['TransactionID'] = rand(111111111,	999999999);

			return $this->req();
		}

		public function draw($arr) {
			$this->requestArray['UserName'] = $arr['username'];
			$this->requestArray['UserPWD']  = $arr['password'];
			$this->requestArray['UserID']   = $arr['id'];
			$this->requestArray['Amount']   = $arr['amount'];
			$this->requestArray['TransactionType'] = 'WITHDRAW';
			$this->requestArray['TransactionID'] = rand(111111111,	999999999);

			return $this->req();
		}

		public function info($arr, $key = 'Token') {
			$req = file_get_contents('http://www.1vivo.com/flash/loginplayer.aspx?LoginName='.$arr['username'].'&PlayerPassword='.$arr['password'].'&OperatorID='.$this->operatorId);
			preg_match_all('~(.*?)=(.*?),~s', $req, $matches);
			$index = array_search($key, $matches[1]);
			return $matches[2][$index];
		}

		public function req() {

			$request_hash = '';
			foreach ( array_values($this->requestArray) as $value ) {
				$request_hash.=$value;
			}

			$this->requestArray['Hash'] = md5( $request_hash . '.' . $this->passKey );

			$ch = curl_init();

			curl_setopt($ch , CURLOPT_URL, $this->requestUrl . '?' . http_build_query($this->requestArray));
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

			$request = curl_exec($ch);

			return ['code' => $this->get($request, 'StatusCode'), 'result' => $this->get($request, 'Description'), 'amount' => $this->get($request, 'Amount')];

		}

	}
