<?php

namespace LiveGames\ClientApi;

if (!class_exists('\Firebase\JWT\JWT')) {
	require_once("lib/jwt/BeforeValidException.php");
	require_once("lib/jwt/ExpiredException.php");
	require_once("lib/jwt/SignatureInvalidException.php");
	require_once("lib/jwt/JWT.php");
}

use \Firebase\JWT\JWT;

class Handler
{

	public $expire = 86400;
	
	public $apiKey = false;
	public $apiSecret = false;

	public $postAction = false;
	public $postData = false;
	public $postSecurityKey = false;

	public $request = null;
	public $payload = [];
	public $lastResponse;

	public $errors = [];
	public $lastError;

	public $isValidRequest = false;

	function __construct($apiKey = false, $apiSecret = false, $options = false)
	{

		if (!$apiKey || !$apiSecret) {
			$this->addError(new \Exception("INVALID_CONFIG", 400));
		} else {
			$this->apiKey = $apiKey;
			$this->apiSecret = $apiSecret;
		}

		$this->postAction = $this->getParam('lgAction');
		if (!$this->postAction) {
			$this->addError(new \Exception("ACTION_NOT_FOUND", 400));
		}

		$this->postData = $this->getParam('lgData');
		if (!$this->postData) {
			$this->addError(new \Exception("DATA_NOT_FOUND", 400));
		} else {
			$this->postSecurityKey = $this->getParam('lgSec');
			if (!$this->postSecurityKey) { //jwt request
				try {
					$this->request = JWT::decode($this->postData, $this->apiSecret, ['HS256', 'HS384', 'HS512', 'RS256']);
				} catch (\Exception $ex) {
					$this->addError($ex);
				}
			} else {
				if ($this->makeSecurityKey($this->postData) != $this->postSecurityKey) {
					$this->addError(new \Exception("INVALID_SEC_KEY", 400));
				} else {
					try {
						if(is_string($this->postData))
							$this->request = json_decode($this->postData);
						else
							$this->request = (object)$this->postData;
					} catch (\Exception $ex) {
						$this->addError($ex);
					}
				}
			}
		}
		$this->checkRequest();
		return $this;
	}

	public function makeSecurityKey($data = [])
	{
		$data = (array)$data;
		ksort($data);
		$dataCollection = [];
		foreach ($data as $key => $val) {
			if (!is_array($val) && !is_bool($val) && !is_object($val)){
				array_push($dataCollection,$val);
			}
		}
		array_push($dataCollection,$this->apiSecret);
		return md5(implode(".", $dataCollection));
	}

	/**
	 * Hata var mı?
	 *
	 * @return mixed
	 */
	public function hasError()
	{
		return count($this->errors) > 0;
	}

	/**
	 * Hata ekle
	 *
	 * @return mixed
	 */
	public function addError(\Exception $err)
	{
		$this->errors[] = [$err->getMessage(), $err->getCode()];
		$this->lastError = $err;
		return $this;
	}

	public function getParam($paramName = false)
	{
		if (!$paramName && $_POST) {
			return $_POST;
		} else {

			if ($_POST && isset($_POST[$paramName])) {
				return $_POST[$paramName];
			} elseif ($_GET && isset($_GET[$paramName])) {
				return $_GET[$paramName];
			} elseif ($_REQUEST && isset($_REQUEST[$paramName])) {
				return $_REQUEST[$paramName];
			} else {
				return null;
			}
		}
	}

	public function setPayload($data = [])
	{
		if ($this->checkPayload($data)) {
			$this->payload = [
				'payload' => $data,
				'sec' => $this->makeSecurityKey($data),
				'errors' => $this->errors
			];
		}
		return $this;
	}

	public function checkPayload($data = [])
	{
		if (!$this->hasError()) {
			switch ($this->postAction) {
				case "GetWallet":
					if (!isset($data['credit'])) {
						$this->addError(new \Exception("REQUIRED:Payload:credit", 400));
					}
					break;
				case "UpdateWallet":
					if (!isset($data['id'])) {
						$this->addError(new \Exception("REQUIRED:Payload:id", 400));
					}
					break;
				case "Ping":
					break;
			}
		}
		return $this;
	}

	private function checkRequest()
	{
		if (!$this->hasError()) {

			switch ($this->postAction) {
				case "GetWallet":
					if (!property_exists($this->request, 'uid')) {
						$this->addError(new \Exception("REQUIRED:user", 400));
					}
					break;
				case "UpdateWallet":
					if (!property_exists($this->request, 'id')) {
						$this->addError(new \Exception("REQUIRED:transaction", 400));
					}
					break;
				case "Ping":
					break;
			}
		}
		$this->isValidRequest = !$this->hasError();
		return $this->isValidRequest;
	}

	/**
	 * Gelen isteği döndürür
	 *
	 * @return mixed
	 */
	public function getRequest()
	{
		if (!$this->hasError()) {
			return $this->request;
		} else {
			return new \stdClass();
		}
	}

	/**
	 * Cevabı döndürür
	 * @param bool $addJSONHeader
	 * @return mixed
	 * @throws \Exception
	 */
	public function getResponse($addJSONHeader = true)
	{
		if (empty($this->payload)) {
			$this->setPayload([]);
		}
		if (!$this->postSecurityKey) { //jwt
			$this->lastResponse = $this->buildResponseToken();
		} else {//secKey
			$this->lastResponse = $this->payload;
		}
		return json_encode(['response' => $this->lastResponse]);
	}

	private function buildResponseToken()
	{
		$tm = time();
		$token = array_merge([
			//"aud" => "CLIENT_HOST", (optional)
			//"nbf" => time(),
			"iat" => $tm,
			"exp" => $tm + $this->expire,
			//"jti" => hash('crc32', $this->apiKey . $tm)
		], $this->payload);
		return JWT::encode($token, $this->apiSecret);
	}

}
