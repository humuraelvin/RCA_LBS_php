<?php

function loadlib($name,$return=1){
	if(!include_once(DOCUMENT_ROOT.SYSTEM_FOLDER."/libraries/".$name.".php")){
		error_message($name." isn't load");
	}
	if($return==1){
		return new $name;
	}
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function mobileDeviceControl(){
    if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
        return 1;
    } else {
       return 0;
    }
}

function response($status,$code,$message) {
    return json_encode([ 'status' => $status, 'code' => $code, 'message' => $message,]);
}

function randomToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

function permalink($str, $options = array())
{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
// Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
// Latin symbols
        '©' => '(c)',
// Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
// Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
// Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
// Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
// Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
// Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
// Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function security ($value){	
		$value = addslashes(htmlspecialchars(strip_tags($value)));
		return $value;	
}

function balance_control($deger) {
    if ( isset(explode('.', $deger)[1]) || isset(explode(',', $deger)[1])) {
        return true;
    }
    return false;
}

function httpPost($url,$params) {
    $postData = '';
    foreach($params as $k => $v) {
        $postData .= $k . '='.$v.'&';
    }
    rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

function generate_uuid() {
    return strtoupper(sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0C2f ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
    ));

}

function filepath($file){
  return $file;
}
 function error_message($message){
	  echo $message;
	  exit();
}
function nf($n){
 return number_format ($n,2);
}
function oranf($oran,$artis,$artis2=0){
	return nf($oran*1+$artis*1+$artis2*1);
}

function trh($post){
	if($_POST[$post]){
		return $_POST[$post];
	}else{
		return date("Y-m-d");
	}
}
	function azzcurl($adres){ 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$adres);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			return  curl_exec($ch);
	} 
	function macorancek($id){
			$sistem=$GLOBALS["botyer"];
			include_once(DOCUMENT_ROOT."config/".$sistem.".php");
			if($sistem=="bwin")	$ek="sistem=Bwin&";
			if($sistem=="hititbet")	$ek="sistem=Hititbet&";
			for($k=1;$k<4;$k++){ 
				$adres=$GLOBALS["canlidetay".$k];
				$cek=azzcurl($adres."?".$ek."cacheSure=3&macID=".$id);
				if(strpos($cek,"Oranlar")!==false){
					break;
				}
			}
			return $cek;
	}
	

	function canli1X2($id,$bwin,$canli)
	{
		if($canli == 1) {$r = "1X2";}
		if($canli == 88) {$r = "Kim kazanır?";}
		
		
		$url232 = "http://tr.live.bwin.com/GetMultiEventData.ashx?lang=7&cts=0&cs=75A900F4&n=1&eids=$bwin&mbo=0&diff=0&r=1407180144714";
		$kaynak12 = file_get_contents($url232);
		$kaynak1 = simplexml_load_string($kaynak12);
		$ilkbu=$kaynak1->LiveEvents->E->Games->G;
		foreach($ilkbu as $ilk){		
		if ($ilk->attributes()->N == $r) {
		foreach($ilk->R as $val){
		if ($ilk->attributes()->N == $r and $val->attributes()->N == "1") {
						
						$ceri=$val->attributes()->O0;
						$metin = explode('{"0":"',$ceri);
						if ($ilk->attributes()->GameIsVisible == 0) {
							
							$oran1 ='<i  class="fa fa-lock"></i>';
							$click1='';
						}
						else
						{
							$oran1 =$metin[0];
							//$click1='onclick="addsliplive(\''.$id.'\',\''.base64_encode("1X2").'\',\''.base64_encode("1").'\',\''.$oran1.'\');"';
							$click1='onclick="addsliplive(\''.sifrele($id.'___1X2___1___'.$oran1).'\');"';

						}
			
					}
		
		if ($ilk->attributes()->N == $r and $val->attributes()->N == "X") {
						
						$ceri=$val->attributes()->O0;
						$metin = explode('{"0":"',$ceri);
						if ($ilk->attributes()->GameIsVisible == 0) {
							
							$oran0 ='<i  class="fa fa-lock"></i>';
							$click0='';
						}
						else
						{
							$oran0 =$metin[0];
							//$click0='onclick="addsliplive(\''.$id.'\',\''.base64_encode("1X2").'\',\''.base64_encode("X").'\',\''.$oran0.'\');"';
							$click0='onclick="addsliplive(\''.sifrele($id.'___1X2___X___'.$oran0).'\');"';

						}
			
					}
		
		if ($ilk->attributes()->N == $r and $val->attributes()->N == "2") {
						
						$ceri=$val->attributes()->O0;
						$metin = explode('{"0":"',$ceri);
						if ($ilk->attributes()->GameIsVisible == 0) {
							
							$oran2 ='<i  class="fa fa-lock"></i>';
							$click2='';
						}
						else
						{
							$oran2 =$metin[0];
							//$click2='onclick="addsliplive(\''.$id.'\',\''.base64_encode("1X2").'\',\''.base64_encode("2").'\',\''.$oran2.'\');"';
							$click2='onclick="addsliplive(\''.sifrele($id.'___1X2___2___'.$oran2).'\');"';
						}
			
					}
		
		
				}
			}
		}
		
		return $oran1.":".$oran0.":".$oran2.":".$click1.":".$click0.":".$click2;
	}
	
	
	
	




function sifrele($value) {
  $key = 'ringo';
  $iv = mcrypt_create_iv(
   mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
   MCRYPT_DEV_URANDOM
  );

  $encrypted = base64_encode(
   $iv .
   mcrypt_encrypt(
    MCRYPT_RIJNDAEL_128,
    hash('sha256', $key, true),
    $value,
    MCRYPT_MODE_CBC,
    $iv
   )
  );
  return str_replace(array('+', '/'), array('-', '_'), $encrypted);
 }
 
 function sifrecoz( $value ) {
  $key = 'ringo';
  $data = base64_decode(str_replace(array('-', '_'), array('+', '/'), $value));
  $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

  $decrypted = rtrim(
   mcrypt_decrypt(
    MCRYPT_RIJNDAEL_128,
    hash('sha256', $key, true),
    substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
    MCRYPT_MODE_CBC,
    $iv
   ),
   "\0"
  );
  return $decrypted;
 } 
	
	
	
	
	
	
	
	
	