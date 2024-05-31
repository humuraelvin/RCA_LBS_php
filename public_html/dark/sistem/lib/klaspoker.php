<?php





	class KlasPoker {



		public $MerchantId;

		public $PrivateKey;

		public $responseType = 'json';

		public $db;

		private $apiUrl = 'http://api.newpoker.klasgaming.com/';



		function __construct() {

			$this->MerchantId = POKER_MERCHANT_ID;

			$this->PrivateKey = POKER_PRIVATE_KEY;



			//$this->db = new PDO('mysql:host=localhost;dbname=mikanosb_mika', 'mikanosb_mika', '221187as', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

		}



		/*

		 * test method

		*/

		public function testMethod() {

			return $this->sendRequest([

				'method' => 'testMethod',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType

			]);

		}



		/*

		 * create member

		*/

		public function createMember( $values ) {

			$request = $this->sendRequest([

				'method' => 'createMember',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'memberId' => $values->memberId,

				'username' => $values->username,

				'firstName' => $values->firstName,

				'lastName' => $values->lastName,

				'email' => $values->email,

				'ipAddress' => $values->ipAddress

			]);

			return $request;

		}



		/*

		 * update member

		*/

		public function updateMember( $values ) {

			return $this->sendRequest([

				'method' => 'updateMember',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username,

				'firstName' => $values->firstName,

				'lastName' => $values->lastName,

				'email' => $values->email,

				'state' => $values->state

			]);

		}



		/*

		 * get member balance

		*/

		public function getMemberBalance( $values ) {

			return $this->sendRequest([

				'method' => 'getMemberBalance',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/*

		 * get member status

		*/

		public function getMemberStatus( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getMemberStatus',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/*

		 * get member rakeback

		*/

		public function getMemberRakeBack( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getMemberRakeBack',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/* get member game counts */

		public function getMemberGameCounts( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getMemberGameCounts',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/* Deposit */

		public function deposit( $values )

		{

			$request = $this->sendRequest([

				'method' 	 => 'deposit',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username,

				'amount' => $values->amount,

				'transactionId' => $values->transactionId,

				'ipAddress' => $values->ipAddress



			]);



			return $request;

		}



		/* Draw */

		public function drawRequest( $values )

		{

			$request = $this->sendRequest([

				'method' 	 => 'drawRequest',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username,

				'amount' => $values->amount,

				'transactionId' => $values->transactionId,

				'ipAddress' => $values->ipAddress



			]);



			return $request;

		}





		/* getDrawRequestState */

		public function getDrawRequestState( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getDrawRequestState',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'transactionId' => $values->transactionId



			]);

		}





		/* getDepositState */

		public function getDepositState( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getDepositState',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'transactionId' => $values->transactionId



			]);

		}



		/* getGameHistory */

		public function getGameHistory( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getGameHistory',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username,

				'startDate' => $values->startDate,

				'finishDate' => $values->finishDate

			]);

		}



		/* getGameDetails */

		public function getGameDetails( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getGameDetails',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->gameId

			]);

		}



		/* getOnlineMembers */

		public function getOnlineMembers( ) {

			return $this->sendRequest([

				'method' 	 => 'getOnlineMembers',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType

			]);

		}



		/* getActiveGames */

		public function getActiveGames( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getActiveGames',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/* getTotalMemberBalances */

		public function getTotalMemberBalances( ) {

			return $this->sendRequest([

				'method' 	 => 'getTotalMemberBalances',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType

			]);

		}



		/* getTotalRake */

		public function getTotalRake( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getTotalRake',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'startDate' => $values->startDate,

				'finishDate' => $values->finishDate

			]);

		}



		/* createLobbyToken */

		public function createLobbyToken( $values ) {

			return $this->sendRequest([

				'method' => 'createLobbyToken',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		public function connectLobby( $values ) {

			return $this->sendRequest([

				'method' => 'connectLobby',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username,

				'token' => $values->token,

				'connectionId' => uniqid()

			]);

		}



		/* createLobbyURL */

		public function createLobbyURL( $values ) {

			return $this->sendRequest([

				'method' 	 => 'createLobbyURL',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/* createDesktopClientURL */

		public function createDesktopClientURL( $values ) {

			return $this->sendRequest([

				'method' 	 => 'createDesktopClientURL',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'username' => $values->username

			]);

		}



		/* getTotalRakeMemberList */

		public function getTotalRakeMemberList( $values ) {

			return $this->sendRequest([

				'method' 	 => 'getTotalRakeMemberList',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType,

				'startDate' => $values->startDate,

				'finishDate' => $values->finishDate

			]);

		}



		/* getOnlineMembersList */

		public function getOnlineMembersList() {

			return $this->sendRequest([

				'method' 	 => 'getOnlineMembersList',

				'merchantId' => $this->MerchantId,

				'responseType' => $this->responseType

			]);

		}





		/*

		 * generating hash

		*/

		public function hashSig($method, $values) {

			return md5( $method . $this->MerchantId . implode("", array_diff( $values , [$method, $this->MerchantId] ) ) . $this->PrivateKey );

		}



		public function sendRequest(array $data, $post = false) {

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '?' . http_build_query($data) . '&hash=' . $this->hashSig($data['method'], $data));

			curl_setopt($ch, CURLOPT_HEADER, false);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_VERBOSE, true);

			if ($post) {

				curl_setopt($ch, CURLOPT_POST, 1);

				// curl_setopt($ch, CURLOPT_POSTFIELDS, );

			} else {

				curl_setopt($ch, CURLOPT_HTTPGET, 1);

			}

			curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);

			curl_setopt($ch , CURLOPT_FOLLOWLOCATION , TRUE);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);

			$result = curl_exec($ch);

			return json_decode($result);

			curl_close($ch);

			//print_r($result);

		}







	}
