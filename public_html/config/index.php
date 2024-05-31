<?
    function curl($adres, $post = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $adres);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        if ($post != 0) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        return curl_exec($ch);
    }
	
	
	/*$sistem = "xcanli2";
        $cek = json_decode(curl("https://imp-api.iyzigaming.com/game.php?user_id=263976&game_id=3002"));
        echo "<pre>";
        foreach ($cek->events as $k => $z) {

            $veri = array();
            $at["id"] = $k;
            $at["evsahibi_isim"] = current(explode("-", $z->label));
            $at["misafir_isim"] = end(explode("-", $z->label));
            echo "--";
            echo $at["skor"] = trim(str_replace(array(":", " "), array("-", ""), $z->score->score_str));
            echo "--";
            $at["dakika"] = ceil(trim(str_replace(":", "-", $z->timer->elapsed)) / 60);
            print_r($at);
            $gun = current(explode(",", $z->date));
            $saat = current(explode(".", end(explode(",", $z->date))));
            $ekle = 0;
            $tarih = explode("-", str_replace(".", "-", trim(end(explode(",", $z->date)))));
            $tarih = date("Y-m-d H:i:s", strtotime(date("Y") . "-" . $tarih[1] . "-" . $tarih[0] . " " . $z->expires . ":00") + 3600);
            $at["dakika"] = trim(str_replace(":", "-", $z->timer->duration));
            $skor = explode("-", $at["skor"]);
			echo $at["tarih"] = $tarih;
           
        }
      
*/

/*$xml = curl("http://tr.live.bwin.com/V2GetLiveEventsWithMainbets.aspx?n=1&label=1&cts=0&lang=7&cs=75A900F7&r=1423668305708");
$maclar = simplexml_load_string($xml);
*/
$xml = '<S SID="4"><E EventID="4226516" LeagueID="3630" N="Iraklis FC - Panionios" EventDate="2015-02-11T14:00:00" EventDateUTC="2015-02-11T14:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Iraklis FC" P2N="Panionios" P1NS="Iraklis" P2NS="Panionios" NumMarkets="19" GroupID="601382" LeagueN="Kupa" RegID="18" RegN="Yunanistan"><Games><G GameID="93900940" N="1X2" GameIsVisible="0" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309426470" RV="1" N="1" O0="1.01" /><R RID="309426471" RV="1" N="X" O0="12.50" /><R RID="309426472" RV="1" N="2" O0="101.00" /></G></Games></E><E EventID="4227641" LeagueID="9473" N="NK Vinogradar - HNK Hajduk Split" EventDate="2015-02-11T14:00:00" EventDateUTC="2015-02-11T14:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="NK Vinogradar" P2N="HNK Hajduk Split" P1NS="" P2NS="Hajduk Split" NumMarkets="19" GroupID="601616" LeagueN="Kupa" RegID="50" RegN="Hırvatistan"><Games><G GameID="93958414" N="1X2" GameIsVisible="0" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309595731" RV="1" N="1" O0="101.00" /><R RID="309595732" RV="1" N="X" O0="12.50" /><R RID="309595733" RV="1" N="2" O0="1.01" /></G></Games></E><E EventID="4228202" LeagueID="6094" N="GKS Tychy - Odra Opole" EventDate="2015-02-11T14:00:00" EventDateUTC="2015-02-11T14:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="GKS Tychy" P2N="Odra Opole" P1NS="" P2NS="" NumMarkets="11" GroupID="601697" LeagueN="&#214;zel Ma&#231;lar" RegID="6" RegN="D&#252;nya"><Games><G GameID="93979382" N="1X2" GameIsVisible="0" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309673140" RV="1" N="1" O0="1.01" /><R RID="309673141" RV="1" N="X" O0="9.00" /><R RID="309673142" RV="1" N="2" O0="101.00" /></G></Games></E><E EventID="4229296" LeagueID="2762" N="Bursaspor - Başakşehir" EventDate="2015-02-11T14:00:00" EventDateUTC="2015-02-11T14:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Bursaspor" P2N="Başakşehir" P1NS="Bursa" P2NS="" NumMarkets="52" GroupID="601842" LeagueN="T&#252;rkiye Kupası" RegID="31" RegN="T&#252;rkiye"><Games><G GameID="94031731" N="1X2" GameIsVisible="1" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309830237" RV="1" N="1" O0="3.25" /><R RID="309830238" RV="1" N="X" O0="1.57" /><R RID="309830239" RV="1" N="2" O0="7.50" /></G></Games></E><E EventID="4227656" LeagueID="7326" N="Omonia Nicosia - Karmiotissa Polemidion" EventDate="2015-02-11T15:00:00" EventDateUTC="2015-02-11T15:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Omonia Nicosia" P2N="Karmiotissa Polemidion" P1NS="Omonia" P2NS="Karmiotissa" NumMarkets="17" GroupID="601628" LeagueN="Cyprus Cup" RegID="58" RegN="Kıbrıs Rum Kesimi"><Games><G GameID="93958657" N="1X2" GameIsVisible="1" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309596418" RV="1" N="1" O0="1.04" /><R RID="309596419" RV="1" N="X" O0="9.50" /><R RID="309596420" RV="1" N="2" O0="29.00" /></G></Games></E><E EventID="4227657" LeagueID="7326" N="Othellos - AEK Larnaca" EventDate="2015-02-11T15:00:00" EventDateUTC="2015-02-11T15:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Othellos" P2N="AEK Larnaca" P1NS="" P2NS="" NumMarkets="47" GroupID="601629" LeagueN="Cyprus Cup" RegID="58" RegN="Kıbrıs Rum Kesimi"><Games><G GameID="93958679" N="1X2" GameIsVisible="1" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309596517" RV="1" N="1" O0="7.25" /><R RID="309596518" RV="1" N="X" O0="2.80" /><R RID="309596519" RV="1" N="2" O0="1.65" /></G></Games></E><E EventID="4228197" LeagueID="6094" N="Lokomotiv Moskova - Videoton FC (tarafsız saha)" EventDate="2015-02-11T15:00:00" EventDateUTC="2015-02-11T15:00:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Lokomotiv Moskova" P2N="Videoton FC" P1NS="(L.Moskova)" P2NS="Videoton" NumMarkets="47" GroupID="601692" LeagueN="&#214;zel Ma&#231;lar" RegID="6" RegN="D&#252;nya"><Games><G GameID="93979272" N="1X2" GameIsVisible="1" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309672645" RV="1" N="1" O0="1.95" /><R RID="309672646" RV="1" N="X" O0="2.65" /><R RID="309672647" RV="1" N="2" O0="4.50" /></G></Games></E><E EventID="4228196" LeagueID="6094" N="Dinamo Kiev - Puskas FC (tarafsız saha)" EventDate="2015-02-11T15:30:00" EventDateUTC="2015-02-11T15:30:00" Score="0-0" GameState="" ShowGameState="1" ShowScore="1" ShowTime="1" GameBeginTimeStampGMT="1900-01-01T00:00:00" GameStoppedTimeStampGMT="1900-01-01T00:00:00" GameStopped="0" GameBeginTimeStampUTC="1900-01-01T00:00:00" GameStoppedTimeStampUTC="1900-01-01T00:00:00" P1N="Dinamo Kiev" P2N="Puskas FC" P1NS="Dinamo Kiev" P2NS="" NumMarkets="57" GroupID="601691" LeagueN="&#214;zel Ma&#231;lar" RegID="6" RegN="D&#252;nya"><Games><G GameID="93979250" N="1X2" GameIsVisible="1" CP="9" GameTemplate="17" UsePlayerNames="1"><R RID="309672546" RV="1" N="1" O0="1.42" /><R RID="309672547" RV="1" N="X" O0="3.70" /><R RID="309672548" RV="1" N="2" O0="7.50" /></G></Games></E></S>';
echo $xml;
 $kod = simplexml_load_string($xml);
        //shuffle($kod->E);
        foreach ($kod->E as $z) {
            $za = $z->attributes();
			echo $za["EventID"]."<br />";
			
		}

?>