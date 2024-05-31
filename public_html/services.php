<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

class services extends controller {

    function __construct() {
      parent::controller();
      $this->admin=$this->load->model("admin");
	  $this->user=$this->load->library("user");
	  $this->cookie=$this->load->library("cookie");
    }

    function index() {
        $this->view->display("login.tpl", get_defined_vars());
    }

    public function detay($id)
    {
        $id = security($id);
        $url = "https://lmt.fn.sportradar.com/Betano/tr/Etc:UTC/gismo/match_timeline/$id";
        $data = file_get_contents($url);
        $events = json_decode($data);

        echo "<b style='color:green'>Ev Sahibi = </b>".$events->doc[0]->data->match->teams->home->name." </br> <b style='color:green'>Misafir = </b>".$events->doc[0]->data->match->teams->away->name."</br>";
        echo "<b style='color:red;'>Kazanan = </b>".$events->doc[0]->data->match->result->winner."</br>";
        echo "</br>";

        foreach ($events->doc[0]->data->events as $key => $event) {
            echo "<b>Id = </b>".$event->_id."</br>";
            echo "<b>Durum = </b>".$event->name."</br>";

            if ($event->result->home) {
                echo "<b style='color: #e48d26;font-weight: bold;font-size: 20px;'>Skor = ".$event->result->home." - ".$event->result->away."</b></br>";
            }

            if ($event->type == "periodscore") {
                echo "<b>Period Skor = </b>".$event->periodscore->home." - ".$event->periodscore->away."</br>";
            }

            if ($event->time > 0) {
                echo "<b>Dakika = </b>".$event->time."</br>";
            }

            echo "</br>";
        }

    }





	function c($value) {
		return str_replace([

			'!', 'plus'

		], [

			'.', '+'

		], $value);

	}

	public function getBetRadar($id) {
		echo file_get_contents('https://lmt.fn.sportradar.com/betinaction/tr/Europe:Istanbul/gismo/match_timeline/' . $id);
	}

	function replace_tr($text) {
		$text = trim($text);
		$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
		$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
		$new_text = str_replace($search,$replace,$text);
		return $new_text;
	}

    public function premenu(){
        header('Content-Type: application/json');
        $json['success'] = true;
        $date = date("Y-m-d\TH:i:s\Z");
        $query = $this->db->result("SELECT * FROM dark_sports WHERE status = 1 AND live = 0 ORDER BY listindex ASC");
        foreach ($query as $sports) {
			//$bulten = $this->db->result("select * from maclar where canli ='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' order by tarih asc LIMIT 20");

           // $count = mysql_query("SELECT * FROM maclar WHERE iptal = 0 && canli = '".$sports['sportid']."' && REPLACE(REPLACE(tarih, 'T', ' '), 'Z', '') > '$date'");
			$count = mysql_query("SELECT * FROM maclar WHERE iptal = 0 && canli = '".$sports['sportid']."' && tarih>'" . date("Y-m-d\TH:i:s\Z") . "'");

            $list[] = [
                'id' => $sports['id'],
                'sportid' => $sports['sportid'],
                'name' => substr($sports['name'],0,15),
                'icon' => $sports['icon'],
                'count' => mysql_num_rows($count),
                'status' => $sports['status']
            ];
        }
        $json['list'] = $list;
        echo json_encode($json);

    }

	public function preCountry(){
		$sportid = security($_POST['id']);
		header('Content-Type: application/json');
		$json['success'] = true;
		$date = date("Y-m-d\TH:i:s\Z");
		$query = $this->db->result("SELECT * FROM dark_country WHERE sportid = '".$sportid."' && status = 1 && live = 0 ORDER BY listindex ASC");
		foreach ($query as $country) {
			$count = mysql_query("SELECT * FROM maclar WHERE iptal = 0 && canli = '".$country['sportid']."' && ulkeid = '".$country['countryid']."' && tarih > '".$date."'");

			$list[] = [
				'id' => $country['id'],
				'countryid' => $country['countryid'],
				'name' => $country['name'],
				'slug' => strtolower($country['slug']),
				'count' => mysql_num_rows($count),
				'status' => $county['status']
			];

		}
		$json['list'] = $list;
		echo json_encode($json);
	}

	public function preLeagues(){
		$sportid = security($_POST['sportid']);
		$countryid = security($_POST['countryid']);
		header('Content-Type: application/json');
		$json['success'] = true;
		$date = date("Y-m-d\TH:i:s\Z");
		$query = $this->db->result("SELECT * FROM dark_leagues WHERE sportid = '".$sportid."' && countryid = '".$countryid."' && status = 1 && live = 0 ORDER BY listindex ASC");
		foreach ($query as $leagues) {
			$count = mysql_query("SELECT * FROM maclar WHERE iptal = 0 && canli = '".$leagues['sportid']."' && ulkeid = '".$leagues['countryid']."' && lig_id = '".$leagues['leaguesid']."' && tarih > '".$date."'  ");
			
			$list[] = [
				'id' => $leagues['id'],
				'leaguesid' => $leagues['leaguesid'],
				'countryid' => $leagues['countryid'],
				'name' => $leagues['name'],
				'count' => mysql_num_rows( $count ),
				'status' => $leagues['status'],
				'listindex' => $leagues['listindex']
			];

		}
		$json['list'] = $list;
		echo json_encode($json);

	}


	function getLiveMatches() {
		header('Content-Type: application/json');

		$json['success'] = true;
		$list = [];
		$sports = [
		"1" => "Futbol",
		"88" => "Basketbol",
		"352" => "Buz Hokeyi",
		"351" => "Tenis",
		"356" => "Voleybol",
		"353" => "Hentbol",
		"354" => "Snooker",
		"355" => "Kriket",
		"357" => "Ragbi",
		"358" => "Salon Futbolu",
		"359" => "Amerikan Futbolu",
		"360" => "Badminton",
		"361" => "Masa Tenisi",
		"362" => "Plaj Voleybolu",
		"363" => "Beyzbol",
        "364" => "E-Sports",
        "365" => "Bowls",
        "366" => "Squash",
        "367" => "Dart",
        "401" => "FIFA VR",
        "402" => "NBA2K VR",
        "403" => "Rocket League",
        "404" => "Football VR",
        "405" => "Basketball VR",

		];


		function strpos_arr($haystack, $needle) {
		    if(!is_array($needle)) $needle = array($needle);
		    foreach($needle as $what) {
		        if(($pos = strpos($haystack, $what))!==false) return $pos;
		    }
		    return false;
		}


		$query = $this->db->result("SELECT * FROM maclar WHERE aktifmi = 1 ORDER BY canli ASC");

		foreach ($query as $match) {

			if ( !strpos_arr($match['evsahibi'], $filter) && !strpos_arr($match['ulke'], $filter) && !strpos_arr($match['deplasman'], @$filter) ) {

			$list[$sports[$match['canli']]][$match['id']]['id'] = $match['id'];
			$list[$sports[$match['canli']]][$match['id']]['country_id'] = $match['ulkeid'];
			$list[$sports[$match['canli']]][$match['id']]['score'] = $match['skor'];
			$list[$sports[$match['canli']]][$match['id']]['minute'] = $match['dakika'];
			$list[$sports[$match['canli']]][$match['id']]['home'] = $match['evsahibi'];
			$list[$sports[$match['canli']]][$match['id']]['visitor'] = $match['deplasman'];
			$list[$sports[$match['canli']]][$match['id']]['stream'] = ( $match['streamid'] == '' ) ? 1 : 0;
			$list[$sports[$match['canli']]][$match['id']]['country_slug'] = $this->replace_tr($match['ulke']);
			$list[$sports[$match['canli']]][$match['id']]['country_name'] = $match['ulke'];
			$list[$sports[$match['canli']]][$match['id']]['sport_id'] = $match['canli'];
			$list[$sports[$match['canli']]][$match['id']]['detail'] = $match['suredetay'];

			}
		}

		$json['list'] = $list;

		echo json_encode($json);
	}

    function matchdetails()	{
        function nokta($t) {
            $tbu = str_replace(",",".",$t);
            return $tbu;
        }

        $id = $_POST["MatchID"];
        $bid = mysql_query("select * from maclar where id='$id'");
        $oki = mysql_fetch_array($bid);
        $pluskod = $oki["pluskod"];

        $url = $this->matchplus($pluskod);
        $xml = simplexml_load_string($url);
        $this->view->display("matchdetails.tpl", get_defined_vars());

    }

    function oddtr ( $text ) {
        $odd = ['Avrupa Handikap' => 'Handikap'];
        return str_replace(array_keys($odd), $odd, $text);
    }

    function array_has_dupes($array) {
        return count($array) !== count(array_unique($array));
    }

	function oddNamechange($name) {
		$liste = [
			"1st Half" => "İlk Yarı",
			"2nd Half" => "2. Yarı",
			"Üst/Alt" => "Alt/Üst Toplam Gol",
			"Alt/Üst İlk Yarı" => "Alt/Üst İlk Yarı Toplam Gol",
			"Over" => "Üst",
			"Under" => "Alt",
			"Even" => "Çift",
			"Odd" => "Tek",
			"Yes" => "Evet",
			"No" => "Hayır",
			"Total Goals by" => "Toplam Gol - ",
			"Total Goals" => "Toplam Gol",
			"Correct Score" => "Doğru Skor",
			// Diğer çeviriler buraya eklenebilir.
		];
	
		return str_replace(array_keys($liste), array_values($liste), $name);
	}
	


    function matchplus($id) {
//        $id = security($id);

		$host = $_SERVER['HTTP_HOST'];
		$url = "https://".$host."/matchdetail.php?matchid=" . $id;

        $List = file_get_contents($url);
        $getList = json_decode( $List );
        $xml = new SimpleXMLElement('<ROOT />');
        $MatchDetails = $xml->addChild('MatchDetails');
		$sport = $getList->events[0]->sport;
		$homeTeamName = $getList->events[0]->homeName;
		$awayTeamName = $getList->events[0]->awayName;
		
		switch ($sport) {
			case 'FOOTBALL':
			$sportid = 0;
			break;
			case 'BASKETBALL':
			$sportid = 12;
			break;
			case 'VOLLEYBALL':
			$sportid = 19;
			break;
			case 'TENNIS':
			$sportid = 4;
			break;
			case 'BASEBALL':
			$sportid = 13;
			break;
			case 'TABLE_TENNIS':
			$sportid = 34;
			break;
			default:
			$sportid = 9999;
			break;
			}
		$state = $getList->events[0]->state;
		switch ($state) {
			case 'STARTED':
			$state = 1;
			break;
			default:
			$state = 0;
			break;
		} 

        $Event = $MatchDetails->addChild('E');
        $Event['Id'] = $getList->events[0]->id;
        $Event['Sport'] = $getList->events[0]->sport;
        $Event['SportId'] = $sportid;
        $Event['Home'] = $getList->events[0]->homeName;
        $Event['Away'] = $getList->events[0]->awayName;
        $Event['Date'] = $getList->events[0]->start;
        $Event['Live'] = $state;
        $Event['BetRadarID'] = $getList->events[0]->id;

        # oran saydırıcı
        $count = [];


        $filter = ['Maç Bahisi', 'Maç Bahisi (1,2)', 'Handicap', 'Handicap - 1st Half', 'Handicap - 2nd Half', 'Asian Total'];


        $Games = $Event->addChild('Games');

		foreach ($getList->betOffers as $list) {
			if (strpos($list->criterion->label, $homeTeamName) !== false) {
				$list->criterion->label = str_replace($homeTeamName, "Ev Sahibi", $list->criterion->label);
			}
			if (strpos($list->criterion->label, $awayTeamName) !== false) {
				$list->criterion->label = str_replace($awayTeamName, "Misafir", $list->criterion->label);
			}
			if (!in_array($list->criterion->label, $filter)) {
				$G = $Games->addChild('Game');
				$G['Id'] = $list->id;
				$G['Name'] = $this->oddNamechange($list->criterion->label);
				$G['Columns'] = count($list->outcomes);
		
				foreach ($list->outcomes as $Odds) {
					$R = $G->addChild('Odds');
					$R['Id'] = $Odds->betOfferId;
		
					$oddName = trim($Odds->label);
		
					if ($oddName == $homeTeamName) {
						$oddName = "Ev Sahibi";
					} elseif ($oddName == $awayTeamName) {
						$oddName = "Misafir";
					}
		
					// 'Handikap' veya 'Handicap' kontrolü
					if (stripos($list->criterion->label, 'Handikap') !== false || stripos($list->criterion->label, 'Handicap') !== false) {
						$oddName = ($Odds->line / 1000) . ' ' . $oddName;
					}
		
					if(in_array($oddName, ["Over", "Under", "Alt", "Üst"])) {
						$oddValue = $Odds->line / 1000;
						$oddName = $oddValue . " " . $this->oddNamechange($oddName); // Sıra değişti
					} else {
						$oddName = $this->oddNamechange($oddName);
					}
		
					$R['Name'] = $oddName;
					$R['Odds'] = $Odds->odds / 1000;
				}
			}
		}
		
        return $xml->asXML();
    }


	function tckimlik($tckimlik){
	    $olmaz=array('11111111110','22222222220','33333333330','44444444440','55555555550','66666666660','7777777770','88888888880','99999999990');
	    if($tckimlik[0]==0 or !ctype_digit($tckimlik) or strlen($tckimlik)!=11){ return false;  }
	    else{
	        for($a=0;$a<9;$a=$a+2){ $ilkt=$ilkt+$tckimlik[$a]; }
	        for($a=1;$a<9;$a=$a+2){ $sont=$sont+$tckimlik[$a]; }
	        for($a=0;$a<10;$a=$a+1){ $tumt=$tumt+$tckimlik[$a]; }
	        if(($ilkt*7-$sont)%10!=$tckimlik[9] or $tumt%10!=$tckimlik[10]){ return false; }
	        else{
	            foreach($olmaz as $olurmu){ if($tckimlik==$olurmu){ return false; } }
	            return true;
				}
			}
	}
	function freespin_get() {
		$host = $_SERVER['HTTP_HOST'];
		$currency = 'TRY';
		$game_id = 'f5470d59bedf4dfca216bb37f8c2e3ff';
		$data = array("method" => "freespinGet", "game_id" => $game_id, "currency" => $currency);
		$response = httpPost("https://$host/play.php", $data);
		echo('here is freespin_get');
		var_dump($response);die;
	}
	function freespin_set($player_id, $player_name) {
		$host = $_SERVER['HTTP_HOST'];
		// $player_id = 264371;
		// $player_name = 'eyyttt';
		$currency = 'TRY';
		$game_id = 'f5470d59bedf4dfca216bb37f8c2e3ff'; //sweet bonanza mobile
		$quantity = 250;
		$data = array(
			"method" => "freespinSet",
			"player_id" => $player_id,
			"player_name" => $player_name,
			"currency" => $currency,
			"game_id" => $game_id,
			"quantity" => $quantity,
		);
		$response = httpPost("https://$host/play.php", $data);
		echo "freespin_set res:".$response;
	}

	function signin() {
	$username = trim(security($_POST["username"]));
	$email = trim(security($_POST["email"]));
	$phone = trim(security($_POST["phone"]));
	$name = trim(security($_POST["name"]));
	$surname = trim(security($_POST["surname"]));
	$password = trim(security($_POST["password"]));
	$password2 = trim(security($_POST["password2"]));
	$day = trim(security($_POST["day"]));
	$month = trim(security($_POST["month"]));
	$year = trim(security($_POST["year"]));
	$ref = trim(security($_POST["ref"]));
	$il = trim(security($_POST["il"]));
	// $bonusadds = trim(security($_POST["bonusadds"]));
	$tamadi = $name." ".$surname;
	$a=$this->db->aresult("select * from admin where username='$username'");
	//$b=$this->db->aresult("select * from admin where tc='$tc'");
	$e=$this->db->aresult("select * from admin where email='$email'");
	//if(preg_match('/[^a-zA-Z]/', $username) != false ) die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı adınızda türkçe karakter bulunamaz."}');
	//if(ctype_lower($username) != true) die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı adınız yalnız küçük harflerden oluşabilir."}');
	if ( empty($email) ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Mail Bölümünü Doldurun."}'); }
	if( $e["id"]!=0 ){ die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Farklı Bir E-Mail Adresi Giriniz."}');}
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {} else { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen geçerli bir mail giriniz."}'); }
	if( $username=='' || !isset($_POST["username"]) ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kullanıcı Adınızı Giriniz."}'); }
	if( $a["id"]!=0 ){ die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı adı kullanılıyor."}');}
	if (preg_match('/[^a-zA-Z0-9]/', $username)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı Adınızda Türkçe Karakter Bulunamaz."}'); }
	if ( empty($password) ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Şifre Bölümünü Doldurun."}'); }
	if ( $password != $password2 ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Girdiğiniz Şifreler Eşleşmiyor."}'); }
	if (empty($name)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen isim bölümünü doldurunuz!"}'); }
	if (empty($day) || empty($month) || empty($year)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Doğum Tarihi Bölümünü Doldurun!"}'); }
	if (empty($surname)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen soyisim bölümünü doldurunuz!"}'); }
	if (empty($il)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen il bölümünü doldurunuz!"}'); }
	if (strlen($phone) != 10) die('{"vResult":"FALSE","vHeader":"Error","vContent":"Telefon numaranız 10 karakterden uzunluğunda olmalıdır."}');

	$date = new DateTime('2023-08-30T16:25:20Z');
	$formattedDate = $date->format('Y-m-d H:i:s');

	$veri=array();
	$veri["username"]=$username;
	$veri["password"]=security(md5($_POST["password"]));
	$veri["sifresi"]=security($_POST["password"]);
	$veri["email"]=security($_POST["email"]);
	$veri["name"]=security($tamadi);
	$veri["telefon"]=security($_POST["phone"]);
	$veri["il"]=security($_POST["il"]);
	$veri["parent"]="1";
	$veri["type"]="bayi";
	$veri["dt"]=security($_POST["year"])."-".security($_POST["month"])."-".security($_POST["day"]);
	$veri["durum"] = 0;
	//20 tl ilk uyeli bonus
	$veri["bakiye"] = 0;
    $veri["canli"] = 0;
    $veri["normalbahis"] = 0;
    $veri["kuponiptal"] = 1;
    $veri["orandegis"] = 1;
    $veri["canlikupongizle"] = 1;
    $veri["canliorandegis"] = 1;
    $veri["kupongizle"] = 1;
    $veri["canlidk"] = 85;
    $veri["minkupon"] = 1;
    $veri["maxkupon"] = 100000;
    $veri["maxkazanc"] = 250000;
    $veri["kazanoran"] = 30;
    $veri["maxoran"] = 10000;
    $veri["maxmac"] = 15;
    $veri["canlisure"] = 12;
    $veri['kayit_tarih'] = $formattedDate;
    $veri["affiliateid"] = $ref;
	//freespin sign addition
	//set freespin for uuid=f5470d59bedf4dfca216bb37f8c2e3ff, name = 'Sweet Bonanza Mobile'
    // $veri["bonusadds"] = 1;

	$this->db->insert("admin", $veri);
	//	echo $this->db->last_query();
	$user_id = $this->db->insert_id();

	$this->freespin_set($user_id, $username);

	$this->db->insert("{prefix}admin_session",
	array("admin_id"=>$user_id,
		  "ip"=>$this->user->ip(),
		  "browser"=>"chrome(68.0.3440.91)",
		  "login_time"=>time(),
		  "last_active"=>time(),
		  "os"=>"Linux",
		  "active"=>1));


	//ilk 20 tl bonus
    
/*
   $this->db->insert("log",
                   array("userid"=>$user_id,
                         "islemad"=> "20 TL Bonus Yüklendi. (Deneme Bonusu)",
                         "tutar"=> 20,
                         "tarih"=> date('Y-m-d\TH:i:s\Z'),
                         "oncekibakiye"=> 0,
                         "sonrakibakiye"=> 20)
   );

   $this->db->insert("uye_bonuslar",
       array("uye"=>$user_id,
           "bonus"=> "110",
           "tarih"=> date('Y-m-d\TH:i:s\Z') )
   );
   */
    //ilk 20 tl bonus


	$session_id=$this->db->insert_id();
	$this->cookie->set("username",  $session_id."__".$veri["username"]."__".$veri["password"]  );

	echo '{"vResult":"TRUE","vHeader":"Error","vContent":"ÜYELİK İŞLEMİNİZ TAMAMLANMIŞTIR."}';

   }

  	function login() {
		$girdimi = $this->admin->is_login();
		$username=$this->input->post("username");
		$password=md5($this->input->post("password"));
		$usernamee = security($username);
		$passwordd = security($password);

		/* bos alan kontrol */
		if($username == "") {
			die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı Adını Boş Bırakmayınız"}');
		}

		if($this->input->post("password") == "") {
			die('{"vResult":"FALSE","vHeader":"Error","vContent":"Şifrenizi Boş Bırakmayınız"}');
		}

		/* tekrar kontrol */
		if(isset($username) and isset($password) and $username and $password){

			/* kullanici ara */
			$users=$this->db->aresult("select * from admin where username='$usernamee' and password='$passwordd' and type='bayi' ");
			$user_durum = $users["durum"];

			// var ise
			if(isset($users["id"])){
				$user_id = $users["id"];
				$this->user_id=$user_id;

				if ( $user_durum == 0 ) {

					$this->db->insert("{prefix}admin_session",
					array("admin_id"=>$user_id,
						  "ip"=>$this->user->ip(),
						  "browser"=>"chrome(68.0.3440.91)",
						  "login_time"=>time(),
						  "last_active"=>time(),
						  "os"=>"Linux",
						  "active"=>1));
				  $session_id=$this->db->insert_id();

				//$this->cookie->set("username",  $session_id."__".$username."__".$password,time()+36000);

				$_SESSION['username'] = $session_id."__".$username."__".$password;

				unset($_SESSION["altim_id"]);
				$error=0;
				$yonlen =1;

				} else $error_durum = 2;

			} else{
				$error_durum=1;
			}

		} else{
			$error=1;
		}


		if($error_durum==1){
			die('{"vResult":"FALSE","vHeader":"Error","vContent":"Kullanıcı Adı veya Şifre Hatalı!"}');
		} else if ($error_durum == 2) {
			die('{"vResult":"FALSE","vHeader":"Error","vContent":"HESAP YONETICILER TARAFINDAN KILITLENDI, LUTFEN ILETISIME GECINIZ!"}');
		}elseif($error==1){
			$this->view->display("login.tpl",get_defined_vars());
		} else{
			if($yonlen==1) echo '{"vResult":"TRUE","vHeader":"Warning","vContent":"Giriş Başarılı"}';//header("location: ".BASE_URL);
		}
	}

    function domains($id=null){
		if($id==null){$id=$this->user_id;$this->domains="";}
		$ids=$this->db->aresult("select parent,domain from admin where id='".$id."'");
		if($ids["domain"]){
			return $ids["domain"];
		}else{
			 if($ids["parent"]==0){
				return "";
			 }else{
				return $this->domains($ids["parent"]);
			 }
		 }
    }

	function livematchs($ajax = 0) {
        $ajax = security($ajax);

        $userid = "1";
		$bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");
		$simdi = date("Y-m-d\TH:i:s\Z");
		$allbulten = $this->db->result("select * from maclar where oynuyormu=1 and sistem='$GLOBALS[botyer]' order by canli ASC");
		$bulten = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenbasket = $this->db->result("select * from maclar where canli=88 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultentenis = $this->db->result("select * from maclar where canli=351 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenbuzhokeyi = $this->db->result("select * from maclar where canli=352 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenhentbol = $this->db->result("select * from maclar where canli=353 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultensnooker = $this->db->result("select * from maclar where canli=354 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenkriket = $this->db->result("select * from maclar where canli=355 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenvoleybol = $this->db->result("select * from maclar where canli=356 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultenragbi = $this->db->result("select * from maclar where canli=357 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$bultensalonfutbolu = $this->db->result("select * from maclar where canli=358 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
		$this->view->display("canli.tpl", get_defined_vars());
	}



	function addmatch($oran) {
        $this->load->library("cookie");

        //Gelen Veri
		$oran = explode('___', sifrecoz($oran));
		$oranid = $oran[0];
		$orangrup = $oran[1];
		$orantur = $oran[2];
		$oran = $oran[3];

        $oranid = security($oranid);


        //Kupon Kontrolü ve Veriyi Parçaladık
		if($oran<1) { die(); }
        if ($this->cookie->get("coupons")) {
            $kupon = $this->cookie->get("coupons");
            $kupon = json_decode(sifrecoz($kupon));
            if (count($kupon) == 0) {
                $kupon = array();
                $bos = 1;
            }
        } else {
            $kupon = array();
            $bos = 1;
        }

        //Kontrol
        $userid = $this->admin->user_id();
        $ektur = "";
        $ustleri = $this->admin->ustum();
        $mac = $this->db->aresult("select * from maclar where id='$oranid' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'");
        $macid = $mac["id"];
		if($macid<1) { die(); }
        $tur = $orantur;
        $orani = $oran;


        //Aynı Oran Kontrolü
        foreach ($kupon as $key => $dark) {
            if ($key == $oranid) {
                //Maç Var
                if ( ($dark->orangrup == $orangrup) ) {
                    //Aynı Market
                    if ( $dark->orantur == $tur )  {
                        //Aynı Oran
                        $deletedMatches = 1;
                    }
                }
            }
        }


        if ($deletedMatches == 1) {
            unset($kupon->$oranid);
        } else {
            if ($bos == 1) {
                $kupon[$macid] = array("orangrup" => $orangrup,"orantur" => $tur, "oranid" => $oranid, "oran" => $orani);
            } else {
                $kupon->$macid = array("orangrup" => $orangrup,"orantur" => $tur, "oranid" => $oranid, "oran" => $orani);
            }
        }


        //Cookie Yazdık
        $kupon = sifrele(json_encode($kupon));
        $this->cookie->set("coupons", $kupon);
        $id = $macid;
        $this->view->display("amacekle.tpl", get_defined_vars());
    }

	function addmatchlive($oran) {
		$oran = explode('___', sifrecoz($oran));
		$oranid = $oran[0];
		$orangrup = $oran[1];
		$orantur = $oran[2];
		$oran = $oran[3];


        $oranid = security($oranid);

        $this->load->library("cookie");
        if ($this->cookie->get("coupons")) {
            $kupon = $this->cookie->get("coupons");
            $kupon = json_decode(sifrecoz($kupon));
            if (count($kupon) == 0) {
                $kupon = array();
                $bos = 1;
            }
        } else {
            $kupon = array();
            $bos = 1;
        }

        $userid = $this->admin->user_id();
        $ektur = "";
        $ustleri = $this->admin->ustum();
        $mac = $this->db->aresult("select * from maclar where id='$oranid'");
        $macid = $mac["id"];

        $tur = $orantur;
        $orani = $oran;
        if ($bos == 1) {
             $kupon[$macid] = array("orangrup" => $orangrup,"orantur" => $tur, "oranid" => $oranid, "oran" => $orani);
        } else {
            $kupon->$macid = array("orangrup" => $orangrup,"orantur" => $tur, "oranid" => $oranid, "oran" => $orani);
        }

        $kupon = sifrele(json_encode($kupon));
        $this->cookie->set("coupons", $kupon);
        $id = $macid;
        $this->view->display("amacekle.tpl", get_defined_vars());
    }

	function livematchtracker($id=0)
	{
		$id = security($_POST["matchid"]);
		$bilgi = $this->db->aresult("select * from maclar where id='$id'");
		$radarid = $bilgi['mackodu'];
		
//		$widgetUrl = 'https://developers.brongaming.com/GetEventDetails/'.$radarid;
//		$widgetData = file_get_contents($widgetUrl);
//		$xml = simplexml_load_string($widgetData);
//		$radarid=$xml->LiveEvents->E['BetRadarID'];
		


		if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    		$mobile = 1;
    	} else $mobile = 0;


    	if ($bilgi['streamid'] != "" && $mobile == 0) {
			echo '
		<div class="panel panel-default border-sm">
		      <div class="panel-heading" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter2" aria-expanded="true">
		        <h4></i>CANLI YAYIN</h4> <i class="pull-right icon-arrow-down"></i>
		      </div>
		      <div id="collapseFilter2" class="panel-collapse collapse in" aria-expanded="true">
		        <div class="panel-body">
		        		<div class="streamtab">
		        				<iframe src="http://bet.services/livestream.php?streamid='.$bilgi['streamid'].'&streaminfo='.$bilgi['streaminfo'].'" width="100%" height="400" scrolling="no" frameborder="0"></iframe>
		        		</div>
	        </div>
	      </div>
	    </div>';
		}
		echo '
		<div class="panel panel-default border-sm">
		      <div class="panel-heading" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" aria-expanded="true">
		        <h4> '.$bilgi['evsahibi'].' - '.$bilgi['deplasman'].'</h4> <i class="pull-right icon-arrow-up"></i>
		      </div>
		      <div id="collapseFilter" class="panel-collapse collapse in" aria-expanded="true">
		        <div class="panel-body">
		   			<iframe src="https://href.li/?https://cs.betradar.com/ls/widgets/?/nightbet/tr/Europe:Istanbul/page/widgets_lmts#matchId='.$radarid.'" width="100%" scrolling="no" frameborder="0" class="livematch-iframe" ></iframe></div>
		      </div>
		</div>';


	}

	function livematchtracker1($id=0)
	{
		$id = security($_POST["matchid"]);
		$bilgi = $this->db->aresult("select * from maclar where id='$id'");
		$radarid = $bilgi['mackodu'];
		
//		$widgetUrl = 'https://developers.brongaming.com/GetEventDetails/'.$radarid;
//		$widgetData = file_get_contents($widgetUrl);
//		$xml = simplexml_load_string($widgetData);
//		$radarid=$xml->LiveEvents->E['BetRadarID'];
		


		if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    		$mobile = 1;
    	} else $mobile = 0;


    	if ($bilgi['streamid'] != "" && $mobile == 0) {
			echo '
		<div class="panel panel-default border-sm">
		      <div class="panel-heading" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter2" aria-expanded="true">
		        <h4></i>CANLI YAYIN</h4> <i class="pull-right icon-arrow-down"></i>
		      </div>
		      <div id="collapseFilter2" class="panel-collapse collapse in" aria-expanded="true">
		        <div class="panel-body">
		        		<div class="streamtab">
		        				<iframe src="http://bet.services/livestream.php?streamid='.$bilgi['streamid'].'&streaminfo='.$bilgi['streaminfo'].'" width="100%" height="400" scrolling="no" frameborder="0"></iframe>
		        		</div>
	        </div>
	      </div>
	    </div>';
		}
		echo '
		<div class="panel panel-default border-sm">
		      <div id="collapseFilter" class="panel-collapse collapse in" aria-expanded="true">
		        <div class="panel-body">
		   			<iframe src="https://href.li/?https://cs.betradar.com/ls/widgets/?/nightbet/tr/Europe:Istanbul/page/widgets_lmts#matchId='.$radarid.'" width="100%" scrolling="no" frameborder="0" class="livematch-iframe1" ></iframe></div>
		      </div>
		</div>';


	}
	
	function search () {
			$ara = security($_POST["letter"]);
			$bulten = $this->db->result("select * from maclar where canli !='1' and tarih >'" . date("Y-m-d\TH:i:s\Z") . "' and (evsahibi LIKE '%$ara%' or deplasman LIKE '%$ara%') order by tarih asc LIMIT 50");
			$this->view->display("arama.tpl", get_defined_vars());
	}

	function filterhour () {
			$simdi = date("Y-m-d\TH:i:s\Z");
			$ara = security($_POST["type"]);
			if($ara == "1") {
				$newtimestamp = strtotime($simdi.' + 60 minute');
				$tarih = date('Y-m-d\TH:i:s\Z', $newtimestamp);
				$bulten = $this->db->result("select * from maclar where canlimi !='1' and tarih >'$simdi' and tarih < '$tarih'");
			}

			if($ara == "3") {
				$newtimestamp = strtotime($simdi.' + 180 minute');
				$tarih = date('Y-m-d\TH:i:s\Z', $newtimestamp);
				$bulten = $this->db->result("select * from maclar where canlimi !='1' and tarih >'$simdi' and tarih < '$tarih'");
			}

			if($ara == "6") {
				$newtimestamp = strtotime($simdi.' + 360 minute');
				$tarih = date('Y-m-d\TH:i:s\Z', $newtimestamp);
				$bulten = $this->db->result("select * from maclar where canlimi !='1' and tarih >'$simdi' and tarih < '$tarih'");
			}
			if($ara == "21") {
				$tarih = date('Y-m-d\T');
				$bulten = $this->db->result("select * from maclar where canlimi !='1' and tarih >'$simdi' and tarih LIKE '%$tarih%'");
			}
			if($ara == "86400") {
				$bulten = $this->db->result("select * from maclar where canlimi !='1' and tarih >'$simdi' LIMIT 0,120");
			}
			$this->view->display("arama.tpl", get_defined_vars());
	}

	function sifreureteci(){
		$karakterler = "1234567890abcdefghijKLMNOPQRSTuvwxyzABCDEFGHIJklmnopqrstUVWXYZ0987654321";
		$sifre = '';
			for($i=0;$i<8;$i++)
			{
				$sifre .= $karakterler{rand() % 72};
			}
		return $sifre;
	}
}