<?php

namespace LiveGames\ClientApi;

if (!class_exists('\Firebase\JWT\JWT')) {
	require_once("lib/jwt/BeforeValidException.php");
	require_once("lib/jwt/ExpiredException.php");
	require_once("lib/jwt/SignatureInvalidException.php");
	require_once("lib/jwt/JWT.php");
}

use \Firebase\JWT\JWT;

class Api
{
	public $apiUrl = 'http://api.livegames.io/api';
	public $expire = 86400;

	public $user = null;

	public $apiKey = false;
	public $apiSecret = false;

	public $token = null;
	public $tokenObj;

	public $lastError;
	public $lastResult;
	public $lastResponse;

	function __construct($user = false, $apiKey = false, $apiSecret = false, $options = false)
	{
		JWT::$leeway = 5;

		if ($options) {
			if (isset($options["debug"])) {
				$this->apiUrl = 'http://api.livegames.com/api';
			}
			if (isset($options["apiUrl"])) {
				$this->apiUrl = $options["apiUrl"];
			}
		}

		if (!$user || !$apiKey || !$apiSecret) {
			$this->lastError = new \Exception("INVALID_CONFIG", 400);
		} else {
			$this->user = !is_array($user) && !is_bool($user) ? ['id' => $user] : array_filter($user);
			$this->apiKey = $apiKey;
			$this->apiSecret = $apiSecret;

			if ($options && isset($options["site.prefix"]) && $this->user) {
				$this->user['id'] = $options["site.prefix"] . '.' . $this->user['id'];
			}

			$this->tokenObj = $this->buildToken();
			$this->token = JWT::encode($this->tokenObj, $this->apiSecret);
		}

		return $this;
	}

	private function buildToken($addClaim = [])
	{
		if ($this->user && !empty($this->user)) {
			$tm = time();
			$token = array_merge([
				"user" => $this->user, //false || usrObj
				"apiKey" => $this->apiKey,
				"game" => "tombala",
				//"aud" => "CLIENT_HOST", (optional)
				//"nbf" => time(),
				"iat" => $tm,
				"exp" => $tm + $this->expire,
				"jti" => hash('crc32', $this->apiKey . $tm)
			], $addClaim);
			return $token;
		} else {
			$this->lastError = new \Exception("USER_NOT_PROVIDED", 400);
		}
	}

	/**
	 * Hata var mı?
	 *
	 * @return mixed
	 */
	public function hasError()
	{
		return !!$this->lastError;
	}


	/**
	 * Kullanıcı var mı yok mu kontrol eder.
	 *
	 * @return mixed
	 */
	public function checkUser()
	{
		return $this->callRequest('v1/check');
	}

	/**
	 * Kullanıcının son bakiyesini döndürür.
	 *
	 * @return mixed
	 */
	public function getWallet() //aka Balance
	{
		return $this->callRequest('v1/wallet');
	}


	/**
	 * Yeni Kullanıcı yaratır.
	 *
	 * UserData Keys =>
	 *  - id
	 *  - parent
	 *  - name
	 *  - surname
	 *  - email
	 *  - phone
	 * @return mixed
	 * @throws \Exception
	 */
	public function createUser()
	{
		if (!is_array($this->user)) {
			throw new \Exception("USER_OBJECT_NOT_FOUND");
		}
		return $this->callRequest('v1/create');
	}


	/**
	 * Verilen Parent kullanıcısından bakiye çekilerek diğer kullanıcıya aktarılır.
	 *
	 * @param $amount
	 * @return mixed
	 * @throws \Exception
	 */
	public function deposit($amount)
	{
		if (is_array($this->user) && array_key_exists("id", $this->user)) {
			$tokenObj = $this->buildToken(['req' => ['amount' => $amount]]);
			$token = JWT::encode($tokenObj, $this->apiSecret);
			return $this->callRequest('v1/deposit', array('token' => $token));
		} else {
			if (!array_key_exists("parent", $this->user))
				throw new \Exception("INVALID_USER_PARENT");
			elseif (!array_key_exists("id", $this->user))
				throw new \Exception("INVALID_USER_ID");
		}

	}


	/**
	 * Kullanıcının cüzdanından bakiye düşülecektir.
	 *
	 * @param $amount
	 * @return mixed
	 * @throws \Exception
	 */
	public function withdraw($amount)
	{
		if (is_array($this->user) && array_key_exists("parent", $this->user) && array_key_exists("id", $this->user)) {
			$tokenObj = $this->buildToken(['req' => ['amount' => $amount]]);
			$token = JWT::encode($tokenObj, $this->apiSecret);
			return $this->callRequest('v1/withdraw', array('token' => $token));
		} else {
			throw new \Exception("INVALID_USER");
		}
	}


	public function jackpot($room = false)
	{
		return $this->callRequest('stats/jackpot', array('room' => $room));
	}


	public function transactions()
	{
		return $this->callRequest('v1/transactions');
	}

	public function logs()
	{
		return $this->callRequest('v1/logs');
	}

	/**
	 * Son kazananlar listesi
	 *
	 *  postArray Params
	 *    "crit" => ["totalWon" => "> 10", "lastWon" => "> 10"]
	 *    "sort" => ["updatedAt" => "desc"]
	 *    "limit" => 10
	 *    "skip" => 0
	 *
	 * @param $q
	 * @return mixed
	 */
	public function lastWinners($q = [])
	{
		return $this->callRequest('stats/lastWinners', $q);
	}

	/**
	 * En Çok Kazananlar listesi
	 *
	 *  postArray Params
	 *    "crit" => ["totalWon" => "> 10", "lastWon" => "> 10"]
	 *    "sort" => ["updatedAt" => "desc"]
	 *    "limit" => 10
	 *    "skip" => 0
	 *
	 * @param $q
	 * @return mixed
	 */
	public function mostWinners($q = [])
	{
		return $this->callRequest('stats/mostWinners', $q);
	}

	//Yukarıdaki parametreler bu
	public function mostWinnerNumbers($q = [])
	{
		return $this->callRequest('stats/mostWinnerNumbers', $q);
	}

	public function mostDrawnNumbers($q = [])
	{
		return $this->callRequest('stats/mostDrawnNumbers', $q);
	}

	public function mostWinnerCards($q = [])
	{
		return $this->callRequest('stats/mostWinnerCards', $q);
	}

	protected function callRequest($service, $q = [])
	{
		if (!array_key_exists("token", $q)) {
			$q["token"] = $this->token;
		} else {
			$this->token = $q["token"];
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/' . $service);
		curl_setopt($ch, CURLOPT_POST, count($q));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($q));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);

		if (@$_SERVER["HTTP_REFERER"]) {
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_REFERER"]);
		} else if (@$_SERVER["HTTP_ORIGIN"]) {
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_ORIGIN"]);
		} else if (@$_SERVER["HTTP_HOST"]) {
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_HOST"]);
		}

		$this->lastResponse = curl_exec($ch);
		$this->lastResult = json_decode($this->lastResponse);

		curl_close($ch);
		return $this->lastResult;
	}
}