<?php
class user{

    function ip() {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        return security($_SERVER['REMOTE_ADDR']);
    }
	
	function os(){
		$oses = array (
		'iPhone' => '(iPhone)',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Linux'=>'(Linux)|(X11)',
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);
	$userAgent = ($_SERVER['HTTP_USER_AGENT']);
	foreach($oses as $os=>$pattern){
		if(eregi($pattern, $userAgent)) { 
			return security($os);
		}
	}
	}
	function browser(){
		$browsers = array(
			'firefox', 'msie', 'opera', 'chrome', 'safari', 'mozilla', 'seamonkey', 'konqueror', 'netscape',
			'gecko', 'navigator', 'mosaic', 'lynx', 'amaya', 'omniweb', 'avant', 'camino', 'flock', 'aol'
		  );

	  if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$user_agent = security($user_agent);
		foreach($browsers as $_browser) {
		  if (preg_match("/($_browser)[\/ ]?([0-9.]*)/", $user_agent, $match)) {
			return $match[1]."(".$match[2].")";
			break;
		  }
		}
	}
		return 0;
	}

}