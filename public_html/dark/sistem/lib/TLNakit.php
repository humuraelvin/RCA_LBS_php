<?php



	class TLNakit {

		

		public $uyeno 		= TLNAKIT_UYENO;

		public $password 	= TLNAKIT_PASSWORD; 

		public $apiurl		= "http://api.tlnakit.com/";

		

		public function __construct() {

			//

		}

		

		public function useCard ( $value ) {

			return $this->req([

				'method' => 'usecard',

				'uyeno' => $this->uyeno,

				'password' => $this->password,

				'kartno' => $value['kartno'],

				'tutar' => $value['tutar']

			]);

		}

		

		public function addBalance ( $value ) {

			return $this->req([

				'method' => 'addbalance',

				'uyeno' => $this->uyeno,

				'password' => $this->password,

				'username' => $value['username'],

				'tutar' => $value['tutar'],

				'transactionId' => rand(111111111,99999999)

			]);

		}

		

		public function nameInfo( $value ) {

			return $this->req([

				'method' => 'nameInfo',

				'uyeno' => $this->uyeno,

				'password' => $this->password,

				'username' => $value['username']

			]);

		}

		

		public function req( $params, $debug = false ) {

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiurl."?".http_build_query($params));

			

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch , CURLOPT_FOLLOWLOCATION , TRUE);

			$resp = curl_exec($ch);

			

			$xml = @(object) simplexml_load_string($resp);

			

			if ( $xml->error ) {

				return (object) ['error' => true, 'message' => (string)$xml->error->desc];

			} else return (object) ['success' => true];

			

			if ( $debug ) {

				print_r( curl_getinfo($ch) );

			}

		}

		

	}

	
