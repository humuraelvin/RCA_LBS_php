<?php



	/* @author : Idris Kahraman */



	class betOn {


		public $operatorId 	= BETON_OPERATOR_ID;

		public $privateKey 	= BETON_PRIVATE_KEY;

		public $apiUrl 		= 'http://betgames.tv/ext/multiwallet_api/';



		public function __construct() {

			//

		}



		public function betOnHash( $values ) {

			return 'accessPassword=' . strtoupper(md5($this->privateKey . http_build_query($values))) . '&' . http_build_query($values);

		}



		/* createAccount */

		public function createAccount( $values ) {

			return $this->req([

				'method' => __FUNCTION__,

				'operatorId' => $this->operatorId,

				'username' => $values['username'],

				'currencyCode' => 'try',

				'userPassword' => $values['userPassword'],

			]);

		}



		/* getAccountBalance */

		public function getAccountBalance( $values ) {

			return $this->req([

				'method' => __FUNCTION__,

				'operatorId' => $this->operatorId,

				'username' => $values['username']

			]);

		}



		public function accountDeposit( $values ) {

			return $this->req([

				'method' => __FUNCTION__,

				'operatorId' => $this->operatorId,

				'username' => $values['username'],

				'amount' => $values['amount'],

				'transactionID' => $values['transactionID'],

				'currencyCode' => 'try'

			]);

		}



		public function accountWithdrawal( $values ) {

			return $this->req([

				'method' => __FUNCTION__,

				'operatorId' => $this->operatorId,

				'username' => $values['username'],

				'amount' => $values['amount'],

				'transactionID' => $values['transactionID'],

				'currencyCode' => 'try'

			]);

		}



		public function registerToken( $values ) {

			return $this->req([

				'method' => __FUNCTION__,

				'operatorId' => $this->operatorId,

				'username' => $values['username']

			]);

		}



		public function req ( $data ) {



			$method = $data['method'];

			unset( $data['method'] );



			$ch = curl_init();

			curl_setopt($ch , CURLOPT_URL, $this->apiUrl . $method . '/?' . $this->betOnHash( $data ));

			curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , FALSE);

			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);

			curl_setopt($ch , CURLOPT_FOLLOWLOCATION , TRUE);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);

			curl_setopt($ch , CURLOPT_VERBOSE , true);



			return json_decode(json_encode((array)simplexml_load_string( curl_exec($ch) )));

		}



	}
