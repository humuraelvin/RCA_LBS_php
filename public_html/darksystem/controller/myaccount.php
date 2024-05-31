<?php
class myaccount extends controller {


    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $this->user = $this->load->library("user");
        $izinliler = explode(",", $GLOBALS["login"]);
        if ($this->admin->is_login() == 1 && !in_array($GLOBALS["function"], $izinliler)) {
            if ($GLOBALS["login"] == "") {
                echo 'Oturumunuz sonlanmistir, lutfen giris yapiniz.';
                exit;
            } else {
                echo 'Oturumunuz sonlanmistir, lutfen giris yapiniz.';
                die();
            }
        }
    }

    function index() {
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");
        $userids = $bilgi['id'];
        $pokerusers=mysql_query("Select * from klaspoker_users where mid='$userids'");
        $varmiacaba = mysql_num_rows($pokerusers);
        $row = mysql_fetch_assoc($pokerusers);
        $this->view->display("myaccount.tpl",get_defined_vars());
    }

    function get_info() {
        $get_info = $this->db->aresult("SELECT id,username, name, bakiye, sportToken FROM admin WHERE id = '".$this->admin->user_id()."'");
        $get_info['bakiye'] = nf( $get_info['bakiye'] );
        echo json_encode($get_info);
    }

    function mycoupons() {
        $toporan = 1;
        $this->load->library("cookie");
        if ($this->cookie->get("kupon")) {
            $kupon = $this->cookie->get("kupon");
            $kupon = json_decode(base64_decode($kupon));
        } else {
            $kupon = array();
        }

        foreach ($kupon as $k => $za) {
            if ($za->canli == 1) {
                if (($za->orantur == "0" or $za->orantur == "1" or $za->orantur == "2")) {
                    $oran = $this->db->aresult("select * from mac_oran where id='$za[oranid]' and canli='$za[canli]'");
                } else {
                    $oran = $this->db->aresult("select * from mac_oranlar where id='$za[oranid]' and canli='$za[canli]'");
                }
            } else {
                $oran["macid"] = $k;
            }
            $mac = $this->db->aresult("select * from maclar where id='$k'");
            if ($GLOBALS["mackodu"] == "iddaa") {
                $mac["mackodu"] = $mac["iddaakod"];
            }

            if (!$mac["mackodu"]) {
                $mac["mackodu"] = $mac["botid"];
            }

            $canlivarmi = end($this->db->aresult("select * from maclar where id='$k' and canli='1'"));
            if($canlivarmi>0) {
                $cvarmi = "var";
            }

            $okupon[$k]["tur"] = $za->orantur;

            if ($GLOBALS["kisaad"] == "kisaad" && ($za->orantur == "0" or $za->orantur == "1" or $za->orantur == "2")) {
                $okupon[$k]["tur"] = "MS " . $za->orantur;
                $okupon[$k]["mbs"] = $mac["mbs"];
                $okupon[$k]["evsahibi"] = $mac["evsahibi"];
                $okupon[$k]["deplasman"] = $mac["deplasman"];
                $okupon[$k]["oran"] = $za->oran;
                $okupon[$k]["id"] = $k;
                $okupon[$k]["macid"] = $k;
                $toporan*=$za->oran;
            }
        }
        $this->view->display("mycoupons.tpl",get_defined_vars());
    }

    function removematch($id) {
        $this->load->library("cookie");
        if ($this->cookie->get("coupon")) {
            $kupon = $this->cookie->get("kupon");
            $kupon = json_decode(base64_decode($kupon));
        } else {
            $kupon = array();
        }
        unset($kupon->$id);
        $kupon = base64_encode(json_encode($kupon));
        $this->cookie->set("kupon", $kupon);
    }

    function oddsVeri($id) {
        $url = SITE_MATCH_ODDS.$id;
        $bukaynak = file_get_contents($url);
        $xml = new SimpleXMLElement($bukaynak);
        return $xml;
    }

    function radarScore($id) {
        $url = "https://lmt.fn.sportradar.com/betinaction/tr/Europe:Istanbul/gismo/match_timeline/".$id;
        $data = file_get_contents($url);
        $data = json_decode($data);
        $match = $data->doc[0]->data->match;
        $msh = $match->result->home;
        $msa = $match->result->away;
        $ms = $msh.":".$msa;
        return $ms;
    }

    function live_odds_update($odd) {
        $odds_settings = $this->db->result("SELECT * FROM settings WHERE `key` = 'live_odds' ");
        $odds_percent = $odds_settings[0]['value'];
        $odds_data = json_decode($odds_percent);
        $operation = $odds_data[0];
        $percent = $odds_data[1];

        if ($operation == "increase") {
            $new_odd = round( ( (float)$odd + ( (float)$odd * (float)$percent ) ),2);
        } else if ($operation == "decrease") {
            $new_odd = round( ( (float)$odd - ( (float)$odd * (float)$percent ) ),2);
        }
        return $new_odd;
    }

    function savecoupon() {

        $siteSettings = $this->db->result("SELECT * FROM settings WHERE `key` = 'bet' ");
        $siteSettingsBet = $siteSettings[0]['value'];
        if ($siteSettingsBet == "0") {
            die("Şuan bahis alınamamaktadır.");
        }

        $ustleri = $this->admin->ustum();
        $miktar = round($this->input->post("miktar"));
        $userid = $this->admin->user_id();

        $bilgi = $this->db->aresult("select * from admin where id='$userid'");

        $ozSportLimit = $bilgi['sportsLimit'];

        if ($bilgi['sports'] == 0) {
            die("Bahis yapma yetkiniz bulunmamaktadır.");
        }

        if ($miktar > $bilgi["bakiye"]) {
            die("Bakiyeniz yetersiz");
            die();
        }



        $dakika = $bilgi["canlidk"];

        if ($bilgi["normalbahis"] == 1 && ($bilgi["type"] == "bayi" || $bilgi["type"] == "acenta"))
            die("Normal bahis oynama izniniz yok");
        if ($bilgi["minkupon"] > $miktar and $bilgi["minkupon"] != 0)
            die("Minimum " . $bilgi["minkupon"] . " TL oyanabilirsiniz");
        if ($bilgi["maxkupon"] < $miktar and $bilgi["maxkupon"] != 0)
            die("Maximum " . $bilgi["maxkupon"] . " TL oyanabilirsiniz");
        if (2000 < $miktar and $bilgi["maxkupon"] == 0)
            die("Maximum 2000 TL oyanabilirsiniz");

        if ($miktar) {
            $rand = rand(1, 9999999);
            $orani = "1";
            $canli = "0";

            if ($miktar > ($bilgi["bakiye"] * 1 + $bilgi["bonus"] * 1)) {
                die("Bakiyeniz yetersiz");
            }

            $orankontrols = security($_POST['retain_selection']);


            $this->load->library("cookie");

            if ($this->cookie->get("coupons")) {
                $kupon = $this->cookie->get("coupons");
                $kupon = json_decode(sifrecoz($kupon));
                $smskupon = $kupon;
            } else { $kupon = array(); }

            $macsayi = count((array) $kupon);

            $live_match_found = 0;
            foreach ($kupon as $k => $za) {
                $m = $this->db->aresult("select * from maclar where id='$za->oranid'");
                if ($m["canlimi"] == 1) { $live_match_found++; }
            }

            if ($live_match_found > 0) {
                sleep(8);
            } else {
                sleep(2);
            }



            foreach ($kupon as $k => $za) {
                $mmid = $za->oranid;
                $m = $this->db->aresult("select * from maclar where id='$mmid'");
                $mac = $this->db->aresult("select * from mac_oran where macid='$k' and userid in (" . implode(",", $ustleri) . ") and canli!=1 order by field(userid," . implode(",", $ustleri) . ") limit 1");
                $limit = $this->db->aresult("select * from maclimit where macid='$k' and userid='$userid'");




                if ($m["canlimi"] != "1" && (!$m["id"] || strtotime($m["tarih"]) < time()))
                    die($m["evsahibi"] . "-" . $m["deplasman"] . " maçı şuan aktif değil");

                //MAÇ CANLI İSE
                if ($m["canlimi"] == "1") {

                    $oranimbu = "1";

                    if($m["oynuyormu"] !=1 )
                    {
                        die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçına Şuan Bahis Alınamamaktadır.");
                    }

                   // $kaynak = $this->oddsVeri($m["botid"]);
                   $url = "https://atabet.bet/livematchdetail.php?matchid=" . $m["botid"];
                   try {
                    $bukaynak = file_get_contents($url);
                    if (!$bukaynak) {
                        throw new Exception("URL içeriği alınamadı.");
                    }
                
                    $kaynak = simplexml_load_string($bukaynak);
                    if (!$kaynak) {
                        throw new Exception("XML yüklenemedi.");
                    }
                } catch (Exception $e) {
                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                }
                
                // XML hata ayıklaması
                $errors = libxml_get_errors();
                foreach ($errors as $error) {
                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                }


                    $betxRadarId = $kaynak->MatchDetails->E->attributes()->BetRadarID;


                    $ilkbu=$kaynak->MatchDetails->E->Games->G;

                    foreach($ilkbu as $ilk){
                        $grup = $za->orangrup;

                        foreach($ilk->R as $val){
                            if ($ilk->attributes()->Name == $grup && $val->attributes()->Name ==  $za->orantur) {
                                $sonoran = $val->attributes()->O0;
                                $oranimbu = "1";
                                $oranimbu = $sonoran;
                                $oranimbu = $this->live_odds_update($oranimbu);


                                if ($val->attributes()->GameIsVisible == 0 or $val->attributes()->O0< 1.01) {
                                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                                    $oranimbu = "1";
                                } else {
                                    //İkinci kontrol
                                   // $kaynaks = $this->oddsVeri($m["botid"]);
                                   $urls = "https://atabet.bet/livematchdetail.php?matchid=" . $m["botid"];
                                   try {
                                    $bukaynaks = file_get_contents($urls);
                                    if (!$bukaynaks) {
                                        throw new Exception("URL içeriği alınamadı.");
                                    }
                                
                                    $kaynaks = simplexml_load_string($bukaynaks);
                                    if (!$kaynaks) {
                                        throw new Exception("XML yüklenemedi.");
                                    }
                                } catch (Exception $e) {
                                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                                }
                                
                                // XML hata ayıklaması
                                $errors = libxml_get_errors();
                                foreach ($errors as $error) {
                                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                                }
                                    
                                    $ilkbus=$kaynaks->MatchDetails->E->Games->G;
                                    foreach($ilkbus as $ilks){
                                        $grups = $za->orangrup;
                                        foreach($ilks->R as $vals){
                                            if ($ilks->attributes()->Name == $grups && $vals->attributes()->Name ==  $za->orantur) {
                                                $sonorans = $vals->attributes()->O0;
                                                $oranimbu = "1";
                                                $oranimbu = $sonorans;
                                                $oranimbu = $this->live_odds_update($oranimbu);

//                                                $radarScore = $this->radarScore($betxRadarId);
//
//                                                if ($radarScore != $m["skor"]) {
//                                                    die($m["evsahibi"] . "-" . $m["deplasman"] . " - A " .$m["skor"]." - B " .$radarScore." Maçına Şuan Bahis Alınamamaktadır!");
//                                                }

                                                if ($orankontrols != "on") {
                                                    if ($za->oran != $vals->attributes()->O0) {
                                                        die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçına Ait Oranlar Değişmiştir!");
                                                    }
                                                }

                                                if ($vals->attributes()->GameIsVisible == 0 or $vals->attributes()->O0 < 1.01) {
                                                    die("Oynadığınız Maçın Oranı Askıda veya Geçersiz Oran");
                                                    $oranimbu = "1";
                                                }
                                                else {
                                                    $oranimbu = "1";
                                                    $oranimbu = $vals->attributes()->O0;
                                                    $oranimbu = $this->live_odds_update($oranimbu);
                                                }
                                            }
                                        }

                                    }
                                    //İkinci Kontrol
                                }

                            }
                        }
                    }

                    $darkdk = $m["dakika"];
                    $darkskor = $m["skor"];

                }
                //MAÇ CANLI İSE

                else {
                    $maci = array();
                    $oranimbu = $za->oran;
                    if ($mac["iptal"] == "1"){
                        die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı Aktif Değil!");
                    }
                    $darkdk = "0";
                    $darkskor = "0-0";
                }

                $darkmaxkupon = $bilgi['maxkupon'];
                $darkmackodu = $m["mackodu"];
                $darkKuponMiktar = $miktar;

                $darkkuponmac = $this->db->result("SELECT * FROM kupon_mac WHERE mackodu = '".$darkmackodu."' && userid = '".$userid."' ");

                if ($darkkuponmac) {
                    $darkMiktar = 0;
                    foreach ($darkkuponmac as $key => $dark) {
                        $darkkupon = $this->db->aresult("SELECT * FROM kupon WHERE id = '".$dark['kuponid']."' ");
                        $darkMiktar += $darkkupon['miktar'];

                    }
                }
                $darkkalanLimit = $darkmaxkupon - $darkMiktar;

                if ($darkkalanLimit < "0") {
                    $darkkalanLimit = "0";
                    die($m["evsahibi"] . "-" . $m["deplasman"] . " maçı için limitiniz kalmamıştır.");
                }
                if ($darkKuponMiktar > $darkkalanLimit) {
                    die($m["evsahibi"] . "-" . $m["deplasman"] . " maçı için kalan limitiniz ".$darkkalanLimit. " TL' dir.");
                }


                #-- LİMİTLEME --#
                $ozMatchSportId = $m["canli"];
                $ozMatchUlkeId = $m["ulkeid"];
                $ozMatchLigId = $m["lig_id"];

                #-- LİG LİMİT --#
                $ozLeagues = $this->db->result("SELECT * FROM dark_leagues WHERE sportid = '".$ozMatchSportId."' AND countryid = '".$ozMatchUlkeId."' AND leaguesid = '".$ozMatchLigId."' ");
                $ozCoupon_limit = $ozLeagues[0]['coupon_limit'];
                if ($ozLeagues[0]['status'] == 0 ) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı Bahis Alımına Kapalıdır."); }
                $darkLimit = ( $ozCoupon_limit * $ozSportLimit ) / 100;
                $darkLimit = $darkLimit - $darkMiktar;
                if ($darkKuponMiktar > $darkLimit) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı İçin Lig Limitiniz ".$darkLimit." TL' dir."); }
                #-- LİG LİMİT --#

                #-- ÜLKE LİMİT --#
                $ozCountry = $this->db->result("SELECT * FROM dark_country WHERE sportid = '".$ozMatchSportId."' AND countryid = '".$ozMatchUlkeId."' ");
                $ozCoupon_limit = $ozCountry[0]['coupon_limit'];
                if ($ozCountry[0]['status'] == 0 ) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı Bahis Alımına Kapalıdır."); }
                $darkLimit = ( $ozCoupon_limit * $ozSportLimit ) / 100;
                $darkLimit = $darkLimit - $darkMiktar;
                if ($darkKuponMiktar > $darkLimit) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı İçin Ülke Limitiniz ".$darkLimit." TL' dir."); }
                #-- ÜLKE LİMİT --#

                #-- SPOR LİMİT --#
                $ozSports = $this->db->result("SELECT * FROM dark_sports WHERE sportid = '".$ozMatchSportId."' ");
                $ozCoupon_limit = $ozSports[0]['coupon_limit'];
                if ($ozSports[0]['status'] == 0 ) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı Bahis Alımına Kapalıdır."); }
                $darkLimit = ( $ozCoupon_limit * $ozSportLimit ) / 100;
                $darkLimit = $darkLimit - $darkMiktar;
                if ($darkKuponMiktar > $darkLimit) { die($m["evsahibi"] . "-" . $m["deplasman"] . " Maçı İçin Spor Limitiniz ".$darkLimit." TL' dir."); }
                #-- SPOR LİMİT --#






                #-- LİMİTLEME --#



                if ($mac["mbs"] > $macsayi && $m["canlimi"] != "1") {
                    die("MBS oranina göre eksik maç girdiniz");
                }

                if($oranimbu < 1.01) {
                    die($m["evsahibi"] . "-" . $m["deplasman"] . " Karşılaşmasına Ait Kuponunuzda Geçersiz Oran Bulunmaktadır");
                }


                $grup = $za->orangrup;

                $kuponz[$k] = array(
                    "oranid" => $za->oranid,
                    "oran" => $oranimbu,
                    "aciklamasi" => $grup,
                    "tur" => $za->orantur,
                    "macid" => $m["id"],
                    "canli" => $m["canli"],
                    "sport_id" => $m["canli"],
                    "canlidakika" => $darkdk,
                    "skor" => $darkskor,
                    "evsahibi" => $m["evsahibi"],
                    "deplasman" => $m["deplasman"],
                    "mackodu" => $m["mackodu"],
                    "matchdate" => $m["tarih"]
                );

                $orani = (double) $oranimbu * (double) $orani;
            }

            if ($bilgi["maxkazanc"] < ($miktar * $orani) && $bilgi["maxkazanc"] != 0)
                die("Max kazanç " . $bilgi["maxkazanc"] . " TL olabilir.");

            if ($bilgi["minoran"] > ($orani) && $bilgi["minoran"] != 0)
                die("Minumum $bilgi[minoran] oynayabilirsiniz.");

            if ($bilgi["maxmac"] < ($macsayi) && $bilgi["maxmac"] != 0)
                die("Max maç sayısı " . $bilgi["maxmac"] . "  olabilir.");

            if (15 < $macsayi)
                die("Max maç sayısı 15  olabilir.");

            if (0 == $macsayi || count($kuponz) == 0)
                die("Boş kupon yapamazsınız.");

            mysql_query('START TRANSACTION;');

            $this->db->insert("kupon", array(
                "userid" => $userid,
                "canli" => $canli,
                "ip" => $this->user->ip(),
                "ad" => $ad,
                "miktar" => $miktar,
                "oran" => $orani,
                "odeme" => $miktar * $orani,
                "tarih" => date("Y-m-d H:i:s"),
                "toplam" => $macsayi
            ));

            $kuponid = mysql_insert_id();
            foreach ($kuponz as $l) {
                $l["userid"] = $userid;
                $l["kuponid"] = $kuponid;
                $l["tarih"] = date("Y-m-d H:i:s");
                $this->db->insert("kupon_mac", $l);
            }

            $sonmac = end(mysql_fetch_array(mysql_query("select maclar.id from kupon_mac inner join maclar on kupon_mac.macid=maclar.id  where kuponid='$kuponid' order by maclar.tarih asc limit 1")));
            $tarih = strtotime(end(mysql_fetch_array(mysql_query("select tarih from maclar where id='$sonmac'"))));
            mysql_query("update kupon set sonmactarih='$tarih' where id='$kuponid'");

            $this->db->query("update admin set bakiye=bakiye-$miktar where id='$userid'");

            $this->admin->log("$kuponid Nolu Kupon Yatırıldı", $miktar * -1);
            error_reporting(1);
            mysql_query('COMMIT');
            $this->db->query('COMMIT');
            echo "ok";
        }
    }

    function AstroPay() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }

        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $astroCardno = security($_POST["astroCardno"]);
        $astroCardCode = security($_POST["astroCardCode"]);
        $astroMonth = security($_POST["astroMonth"]);
        $astroYear = security($_POST["astroYear"]);
        $astroMoney = security($_POST["astroMoney"]);
        $astroMoneyTl = security($_POST["astroMoney"]);

        if(empty($astroCardno)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Numara Bölümünü Doldurun."}');}
        if(empty($astroCardCode)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Kod Bölümünü Doldurun."}');}
        if(empty($astroMonth)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Ay Bölümünü Doldurun."}');}
        if(empty($astroYear)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Yıl Bölümünü Doldurun."}');}
        if(empty($astroMoney)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Tutar Bölümünü Doldurun."}');}

        if (!is_numeric($astroCardno)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Bilgilerini Kontrol Ediniz."}'); }
        if (!is_numeric($astroCardCode)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Bilgilerini Kontrol Ediniz."}'); }
        if (!is_numeric($astroMonth)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Ay Bölümünü Kontrol Ediniz."}'); }
        if (!is_numeric($astroYear)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Yıl Bölümünü Kontrol Ediniz."}'); }
        if (!is_numeric($astroMoney)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Kart Tutar Bilgilerini Kontrol Ediniz."}'); }

        if(strlen($astroCardno) > "25" || strlen($astroCardCode) > "25" || strlen($astroMonth) > "3" || strlen($astroYear) > "5" || strlen($astroMoney) > "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bilgileri Kontrol Ediniz!"}');}


        $data = file_get_contents("https://www.doviz.com/api/v1/currencies/USD/latest");
        $data = json_decode($data);
        $rate = $data->buying;
        $amount = $astroMoney * $rate;
        $newamount = $amount - ( $amount * 0.01);
        $newamount = number_format($newamount, 2, '.', '');
        if ($rate) {
            $astroMoney = $newamount;
        } else {
            echo '{"vResult":"FALSE","vHeader":"Error","vContent":"Kur Bulunamadı!"}';
            die();
        }

        $aciklama = "Kart No : $astroCardno </br>
                     Kart Kodu : $astroCardCode </br>
                     Kart Ay : $astroMonth </br>
                     Kart Yıl : $astroYear </br>
                     Kart Tutar TL: $astroMoney TL</br>
                     Kart Tutar Dolar: $astroMoneyTl Dolar";

        $deposit = $this->db->insert("parayatir", array(
            "uye" => $user_id,
            "adsoyad" => "",
            "banka" => "ASTROPAY",
            "miktar" => $astroMoney,
            "tur" => "ASTROPAY",
            "aciklama" => $aciklama,
            "bonus" => "5",
            "note" => "",
        ));


        if ($deposit) {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
        } else {
            echo '{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu!"}';
        }
    }

    function logout() {
        $this->admin->logout();
        header("Location: " . BASE_URL);
    }

    function DepositOk() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }

        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $bankasi = "BANKA_ODEMESI";

        $bonus = "5";
        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["namesurname"]);
        $para = security($_POST["money"]);
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;

        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(empty($_POST["time"])) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen İşlem Saatini Yazınız"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 250) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 250 TL Yatırabilirsiniz!"}');}
        if($para > 100000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 100000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','HAVALE','$bonus', '$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

$url = 'https://pay.hizlicapapara.com/iframe/v1/new/bank';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }

    function PaparaDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "PAPARA";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["paparanamesurname"]);
        $para = security($_POST["paparamoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','PAPARA','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/new/papara';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }



    function PaparaIBANDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "PAPARA_IBAN";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["paparaibannamesurname"]);
        $para = security($_POST["paparaibanmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','PAPARA_IBAN','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/create/papara_iban';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }


    
    function hizlikartDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "KREDİKARTI";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["kartnamesurname"]);
        $para = security($_POST["kartmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','KREDİKARTI','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/new/card';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }





    
    function hizlifastDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "FAST";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["fastnamesurname"]);
        $para = security($_POST["fastmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','FAST','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/create/fast';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }




        
    function hizlitoslaDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "TOSLA";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["toslanamesurname"]);
        $para = security($_POST["toslamoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','TOSLA','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/create/tosla';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }



        
    function hizlikriptoDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "KRIPTO";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["kriptonamesurname"]);
        $para = security($_POST["kriptomoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','KRIPTO','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/create/crypto';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


    }    



    
    function hizlimefeteDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "MEFETE";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["mefetenamesurname"]);
        $para = security($_POST["mefetemoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        $refid = uniqid();
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','MEFETE','$bonus','$refid')");
       // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

       $url = 'https://pay.hizlicapapara.com/iframe/v1/create/mefete';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
    'token' => $token,
    'refid' => $refid,
    'namesurname' => $nameSurname,
    'username' => $username,
    'amount' => number_format($amount, 2, '.', ''),
    'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
    echo json_encode([
        'vResult' => 'TRUE',
        'redirectUrl' => $responseArray['url']
    ]);
    exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


}    




function hizlipaycellDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "PAYCELL";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["paycellnamesurname"]);
    $para = security($_POST["paycellmoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','PAYCELL','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/paycell';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


}    


function hizlipepleDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "PEPLE";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["peplenamesurname"]);
    $para = security($_POST["peplemoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','PEPLE','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/peple';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


}    



function hizlipayfixDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "PAYFIX";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["payfixnamesurname"]);
    $para = security($_POST["payfixmoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','PAYFIX','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/payfix';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}



// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';


}    





function hizlicepbankDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "CEPBANK";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["cepbanknamesurname"]);
    $para = security($_POST["cepbankmoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','CEPBANK','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/cepbank';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}
// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';

}    




function hizlikassaDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "KASSA";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["kassanamesurname"]);
    $para = security($_POST["kassamoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','KASSA','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/kassa';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}
// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';

}    






function hizlicmtDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "CMT";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["cmtnamesurname"]);
    $para = security($_POST["cmtmoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','CMT','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/cmt';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}
// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';

}    




function hizlinaysDeposit() {
    $user_id = $this->admin->user_id();
    $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
    if ($userinfo['deposit'] == "0") {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
    }
    $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
    if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

    $bankasi = "NAYS";

    $bonus = "5";

    if ($bonus == 6) {
        $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
        if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
    }
    $adisoyadi = security($_POST["naysnamesurname"]);
    $para = security($_POST["naysmoney"]);
    if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
    $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
    $bonusu = $para * $bonusbul['yuzde'] / 100;
    if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
    } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
    }

    if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
    if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
    if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
    if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
    if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
    $refid = uniqid();
    mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus,refid) values ('$user_id','$adisoyadi','$bankasi','$para','NAYS','$bonus','$refid')");
   // echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';

   $url = 'https://pay.hizlicapapara.com/iframe/v1/create/nays';

$token = $GLOBALS["pay_token"];
$secret = $GLOBALS["pay_secret"];
$nameSurname = $userinfo['name'];
$username = $userinfo['username'];
$amount = (double)$para;
$sha256 = hash_hmac('sha256', ( $token . $refid), $secret);

$fields = [
'token' => $token,
'refid' => $refid,
'namesurname' => $nameSurname,
'username' => $username,
'amount' => number_format($amount, 2, '.', ''),
'sha256' => $sha256
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Eğer SSL sertifikasıyla ilgili bir sorun yaşarsanız bu satırı kullanabilirsiniz, ancak güvenlik için ideal değildir.

$response = curl_exec($ch);

if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$responseArray = json_decode($response, true);

if (isset($responseArray['status']) && $responseArray['status'] === true) {
echo json_encode([
    'vResult' => 'TRUE',
    'redirectUrl' => $responseArray['url']
]);
exit;
}
// Yönlendirme olmazsa cevabı ekrana yaz
echo '{"vResult":"TRUE","vHeader":"Error","vContent":"'.$response.'"}';

}    




    function pepleDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "PEPLE";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["peplenamesurname"]);
        $para = security($_POST["peplemoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 100000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 100000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','PEPLE','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }
    
    function bitcoinDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "Bitcoin";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["bitcoinnamesurname"]);
        $para = security($_POST["bitcoinmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 500 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','BİTCOİN','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }
    
    function tetherDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "Tether";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["tethernamesurname"]);
        $para = security($_POST["tethermoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','Tether','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }
    
    function mefeteDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "MEFETE";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["mefetenamesurname"]);
        $para = security($_POST["mefetemoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','MEFETE','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }
    
    function jetonDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "JETON";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["jetonnamesurname"]);
        $para = security($_POST["jetonmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1.000.000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','JETON','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

    function cmtDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "CMT CÜZDAN";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["cmtnamesurname"]);
        $para = security($_POST["cmtmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 200) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 200 TL Yatırabilirsiniz!"}');}
        if($para > 1000000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 1000000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','CMT CÜZDAN','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

    function payfixDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "PAYFIX";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["payfixnamesurname"]);
        $para = security($_POST["payfixmoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 25) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 25 TL Yatırabilirsiniz!"}');}
        if($para > 100000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 100000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','PAYFIX','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

        function paraodeDeposit() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $bankasi = "PARAAODE";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $adisoyadi = security($_POST["paraodenamesurname"]);
        $para = security($_POST["paraodemoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($adisoyadi) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Adını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 50) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 50 TL Yatırabilirsiniz!"}');}
        if($para > 100000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 100000 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$adisoyadi','$bankasi','$para','Para ODE','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

    function CreditCard() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}

        $name = $userinfo['name'];

        $bankasi = "KREDIKARTI";

        $bonus = "5";

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }
        $phone = security($_POST["creditTel"]);
        $para = security($_POST["creditMoney"]);
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;
        if ($bonus['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonus['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if(empty($bankasi)) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($phone) < "5") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Telefon Nuramaras Bölümünü Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 500 TL Yatırabilirsiniz!"}');}
        if($para > 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 500 TL Yatırabilirsiniz!"}');}
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,bonus) values ('$user_id','$name','$phone','$para','KREDI KARTI','$bonus')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

    function MobileBankOk() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $varmi = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $bankasi = 	security($_POST["bank"]);
        $bankasi = $this->db->aresult("SELECT * FROM sitebanka WHERE id = '".$bankasi."'");
        $bankasi = $bankasi['banka'];
        $gtel = 	security($_POST["gtel"]);
        $bonus = 	"5";
        $atel = 	security($_POST["atel"]);
        $atc = 		security($_POST["atc"]);
        $referans = security($_POST["referans"]);
        $para =     security($_POST["money"]);
        $note = 	security($_POST["note"]);
        $bonusbul = $this->db->aresult("SELECT * FROM bonuslar WHERE id = '".$bonus."'");
        $bonusu = $para * $bonusbul['yuzde'] / 100;

        if ($bonus == 6) {
            $varmibonus = mysql_num_rows(mysql_query("select * from parayatir where uye='$user_id' and bonus='6'"));
            if($varmibonus > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Seçtiğiniz Bonusu Daha Önce Kullandığınız İçin Tekrar Alamazsınız.!!!"}');}
        }

        if ($bonusbul['yuzde'] == 25 AND $bonusu > 300) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 300 bonus olabilir. Miktarınızı düşürün."}');
        } else if ($bonusbul['yuzde'] == 15 AND $bonusu > 500) {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Max 500 bonus olabilir. Miktarınızı düşürün."}');
        }

        if($bankasi == "0") 		{die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Bankayı Seçiniz"}');}
        if(strlen($gtel) < "9") 	{die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Gönderen Telefon Numarasını Kontrol Ediniz!"}');}
        if(strlen($atel) < "9") 	{die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Alıcı Telefon Numarasını Kontrol Ediniz!"}');}
        if(strlen($referans) < "1") {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Şifre(Referans) Alanını Kontrol Ediniz!"}');}
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 20) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 20 TL Yatırabilirsiniz!"}');}
        if($para > 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 500 TL Yatırabilirsiniz!"}');}
        $aciklamasi .= "Gönderen Tel:".$gtel."<br/><br/>";
        $aciklamasi .= "Alıcı Tel:".$atel."<br/><br/>";
        $aciklamasi .= "Alıcı T.C:".$atc."<br/><br/>";
        $aciklamasi .= "Şifre veya Referans:".$referans."<br/>";
        mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,aciklama,bonus,note) values ('$user_id','$adisoyadi','$bankasi','$para','CEPBANK','$aciklamasi','$bonus','$note')");
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Yatırma Talebiniz İşleme Alınmıştır!"}';
    }

    function Tlnakit() {
        die('{"vResult":"FALSE","vHeader":"Error","vContent":"Şuan işlem yapılamamaktadır."}');

        $user_id = $this->admin->user_id();

        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['deposit'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        require 'TLNakit.php';
        $TLNakit = new TLNakit;
        $cardno = mysql_real_escape_string($_POST["cardno"]);
        $quantity = mysql_real_escape_string($_POST["quantity"]);

        if ( !is_numeric($cardno) ) {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bilgiler Hatalı"}';
            die();
        }

        if ( !is_numeric($quantity) ) {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bilgiler Hatalı"}';
            die();
        }

        if ( strlen($cardno) > 25) {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bilgiler Hatalı"}';
            die();
        }

        if ( strlen($quantity) > 25) {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bilgiler Hatalı"}';
            die();
        }



        $tldeposit = $TLNakit->useCard(
            ['kartno' => $cardno,
                'tutar' => $quantity ]);

        if ($tldeposit->error == "1") {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bilgiler Hatalı"}';
        }

        elseif ($tldeposit->success == "1") {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Yatırımınız Onaylanmıştır."}';
            mysql_query("insert into parayatir (uye,adsoyad,banka,miktar,tur,aciklama,bonus,durum) values ('$user_id','TLNAKIT','TLNAKIT','$quantity','TLNAKIT','TLNAKIT','5','1')");
            $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
            mysql_query("update admin set bakiye=bakiye+$quantity where id='$user_id'");
            $si=date("Y-m-d H:i:s");
            $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
            mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Para Yatırma (TLNAKIT)','$quantity','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
        }
        else
        {
            echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Bir Hata Meydana Geldi."}';
        }
    }

    function PaparaWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantity"]);
        $hesap = security($_POST["cardno"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 250) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 250 TL Çekim Yapabilirsiniz!"}');}
        if($para > 500000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 50.0000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','PAPARA','$para','PAPARA','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }
    
    
    function PepleWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantitypeple"]);
        $hesap = security($_POST["cardnopeple"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 100) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 100 TL Çekim Yapabilirsiniz!"}');}
        if($para > 50000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 50000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','PEPLE','$para','PEPLE','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }
    
    function btcWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantitybtc"]);
        $hesap = security($_POST["btcno"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 500 TL Çekim Yapabilirsiniz!"}');}
        if($para > 500000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 500000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','BITCOIN','$para','BITCOIN','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }
    
    function tetherWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantitytether"]);
        $hesap = security($_POST["tetherno"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 500) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 500 TL Çekim Yapabilirsiniz!"}');}
        if($para > 500000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 500000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','TETHER','$para','TETHER','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }
    
    function cmtWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantitycmt"]);
        $hesap = security($_POST["cardnocmt"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 250) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 250 TL Çekim Yapabilirsiniz!"}');}
        if($para > 500000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 500000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','CMT','$para','CMT','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }

    function payfixWithdraw () {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $para = security($_POST["quantitypayfix"]);
        $hesap = security($_POST["cardnopayfix"]);

        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 100) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 100 TL Çekim Yapabilirsiniz!"}');}
        if($para > 50000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 50000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','PAYFİX','$para','PAYFİX','-','$hesap','-')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }

    function WithDrawOk() {
        $user_id = $this->admin->user_id();
        $userinfo = $this->db->aresult("select * from admin where id='$user_id'");
        if ($userinfo['withdraw'] == "0") {
            die('{"vResult":"FALSE","vHeader":"Error","vContent":"Hata Oluştu, Lütfen Canlı Destek ile İletişime Geçiniz."}');
        }
        $bakbakalim = mysql_query("select * from uye_bonuslar where uye='$user_id'");
        $varmiki = mysql_num_rows($bakbakalim);
        if($varmiki > 0)  {
            $uyeninbonusu = $this->db->aresult("select * from uye_bonuslar where uye='$user_id' ORDER BY id DESC LIMIT 0,1");
            $bonusno = $uyeninbonusu["bonus"];
            $bonustarih = $uyeninbonusu["tarih"];
            $bonusdetay = $this->db->aresult("select * from bonuslar where id='$bonusno'");
            $yuzdesi = $bonusdetay["yuzde"];
            $cevrim = $bonusdetay["cevrim"];
            $oransart = $bonusdetay["oran"];
            $yatirdigi = $this->db->aresult("select * from parayatir where bonus='$bonusno' and uye='$user_id' order by id DESC LIMIT 0,1");
            $yatanpara = $yatirdigi["miktar"];
            $aldigibonusu = $yatanpara*$yuzdesi/100*$cevrim;
            $oynadigikuponlari = mysql_query("SELECT SUM(miktar) FROM kupon where oran > '$oransart' and tarih > '$bonustarih' and userid='$user_id' and iptal ='0'");
            $oynadiklari = mysql_fetch_array($oynadigikuponlari);
            $oynanan = $oynadiklari['SUM(miktar)'];
            $sukadaroyun = $aldigibonusu-$oynanan;
            if($aldigibonusu > $oynanan) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bonus Çevriminiz Tamamlanmadığından Dolayı Çekim Talebi Veremezsiniz!.Çevriminizi Tamamlamak İçin '.$sukadaroyun.' TRY Bahis Yapmanız Gerekmektedir."}');}
        }

        $tarihi = mysql_fetch_array(mysql_query("select * from paracek where uye='$user_id' and durum='1' order by id DESC LIMIT 0,1"));
        $start = $tarihi["tarih"];
        $cekimtarihi = date('Y-m-d H:i:s',strtotime('+24 hour',strtotime($start)));
        $simdi = date("Y-m-d H:i:s");
        $varmi = mysql_num_rows(mysql_query("select * from paracek where uye='$user_id' and durum='0'"));
        if($varmi > 0) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bekleyen Çekim Talebiniz Bulunmaktadır.Lütfen Bekleyiniz!"}');}
        $para = security($_POST["money"]);
        $sonbakiyever = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        if($sonbakiyever["bakiye"] < $para) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Bakiyeniz Bu İşlem İçin Yeterli Değildir!"}');}
        $bankasi = security($_POST["bank"]);
        $bankasi = $this->db->aresult("SELECT * FROM sitebanka WHERE id = '".$bankasi."'");
        $bankasi = $bankasi['banka'];
        $para = security($_POST["money"]);
        $hesap = security($_POST["hesap"]);
        $sube = security($_POST["sube"]);
        $iban = security($_POST["iban"]);
        if ( $para %10 != "0" ) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Yalnızca 10 ve katlarına talep verebilirsiniz!"}');  }
        if (!is_numeric($para)) { die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Edin."}'); }
        if(strlen($para) < 1) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Lütfen Miktarı Kontrol Ediniz!"}');}
        if($para < 250) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Minimum 250 TL Çekim Yapabilirsiniz!"}');}
        if($para > 50000) {die('{"vResult":"FALSE","vHeader":"Error","vContent":"Maximum 50000 TL Çekim Yapabilirsiniz!"}');}
        mysql_query("update admin set bakiye=bakiye-$para where id='$user_id'");
        mysql_query("insert into paracek (uye,banka,miktar,turu,sube,hesap,iban) values ('$user_id','$bankasi','$para','HAVALE','$sube','$hesap','$iban')");
        $si=date("Y-m-d H:i:s");
        $sonbakiyever2 = mysql_fetch_array(mysql_query("select bakiye from admin where id='$user_id'"));
        echo '{"vResult":"TRUE","vHeader":"Error","vContent":"Para Çekim Talebiniz İşleme Alınmıştır!"}';
        mysql_query("insert into log (userid,islemad,tutar,oncekibakiye,sonrakibakiye,tarih) values ('$user_id','Yeni Para Çekme İşlemi','$para','$sonbakiyever[bakiye]','$sonbakiyever2[bakiye]','$si')");
    }
    


    function couponsdetail($id) {
        $id = security($id);
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid' ");
        $maclar = $this->db->result("select * from kupon_mac where kuponid='$id'");
        $kupon = $this->db->aresult("select * from kupon where id='$id' AND userid = '$userid'");
        if (empty($kupon)) {
            die("access denied.");
        }
        $admin = $this->db->aresult("select * from admin where id='$kupon[userid]' ");

        if ($kupon["iptal"] == 1) {
            $sonuc = array("İptal", "İptal", "İptal");
        } else {
            $sonuc = array("Devam ediyor", "Kazandı", "Kaybetti");
        }

        foreach ($maclar as $a => $b) {
            if ($b["iptal"] == 1)
                $maclar[$a]["oran"] = 1;
        }
        $this->view->display("kuponmac.tpl", get_defined_vars());
    }

    function changepassword() {
        $userid = $this->admin->user_id();
        $u = $this->db->aresult("select * from admin where id='$userid'");
        $old_password = security($_POST['old_password']);
        $password = security($_POST['new_password']);
        $password_repeat =  security($_POST['new_password_repeat']);

        if ($u["password"] != md5(security($old_password)) )
            die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Eski Şifrenizi Yanlış Girdiniz."}');
        if (strlen($password) < 6)
            die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Yeni şifrenizin 6 karakterden büyük olması gerekiyor."}');
        if (strlen($password) > 12)
            die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Yeni şifrenizin 12 karakterden küçük olması gerekiyor."}');
        if ($password != $password_repeat)
            die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Şifreler Eşleşmiyor."}');

        $update = $this->db->update("admin", array("password" => md5($password), "sifresi" => $password ), array("id" => $userid));
        if ($update) {
            die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Şifreniz Güncellendi."}');
        }
        else
        {  die ('{"vResult":"TRUE","vHeader":"Error","vContent":"Hata Oluştu."}'); }
    }

    function transactions() {
        $user_id = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$user_id'");

        if (!isset($_POST['from']) AND !isset($_POST['to'])) {
            $tarih2 =  date("Y-m-d");
            $tarih1 = date('Y-m-d',strtotime(date("Y-m-d") . "-30 days"));
        } else {
            $tarih2 = security( $_POST['to'] );
            $tarih1 = security( $_POST['from'] );
        }
        $detaylar = $this->db->result("select * from log where userid='$user_id' and tarih > '$tarih1 00:00:00' and tarih <'$tarih2 23:59:59' order by id desc");
        $islem = mysql_fetch_array(mysql_query("select log from id where id='$id'"));
        $this->view->display("mytransactions.tpl",get_defined_vars());
    }

    function coupons() {
        $user_id = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$user_id'");
        if (!isset($_POST['from']) AND !isset($_POST['to'])) {
            $tarih2 =  date("Y-m-d");
            $tarih1 = date('Y-m-d',strtotime(date("Y-m-d") . "-30 days"));
        } else {
            $tarih2 = security( $_POST['to'] );
            $tarih1 = security( $_POST['from'] );
        }
        $kuponlar = $this->db->result("select * from kupon where userid='$user_id' and tarih > '$tarih1 00:00:00' and tarih <'$tarih2 23:59:59' order by id DESC");
        $this->view->display("kupon.tpl",get_defined_vars());
    }

    function withdraw() {
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");
        $bonuslar = $this->db->result("select * from bonuslar where durum='1' order by id DESC");
        $bankalar = $this->db->result("select * from sitebanka where durum='1' && withdraw='1' order by banka ASC");
        $this->view->display("withdraw.tpl",get_defined_vars());
        
        
    }

    function deposit() {
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");
        $bonuslar = $this->db->result("select * from bonuslar where durum='1' order by id DESC");
        $bankalar = $this->db->result("select * from sitebanka where durum='1' && deposit='1' order by banka ASC");
        $cepbankalar = $this->db->result("select * from sitebanka where durum='1' && mobiletransfer='1' order by banka ASC");
        $bkmbankalar = $this->db->result("select * from sitebanka where durum='1' && bkm='1' order by banka ASC");
        $qrbankalar = $this->db->result("select * from sitebanka where durum='1' && qr='1' order by banka ASC");
        $this->view->display("deposit.tpl",get_defined_vars());
    }

    function transfer() {
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");
        $this->view->display("transfer.tpl", get_defined_vars());
    }

    function balanceinfo() {
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        $userid = $this->admin->user_id();
        $user_cookie = @security($_SESSION['username']);
        $cookie_id       = @explode('__', $user_cookie)[0];
        $cookie_username = @explode('__', $user_cookie)[1];
        $cookie_password = @explode('__', $user_cookie)[2];
        $bilgi = $this->db->aresult("select * from admin where username='$cookie_username' && password = '$cookie_password'");
        $user_id = $bilgi['id'];
        $name = $bilgi['name'];
        $username = REDIS_KEY.'_'.$bilgi['username'];

        if (empty($bilgi)) {
            $data = array("method" => "balance", "key" => HOGAMING_KEY, "secret" => HOGAMING_SECRET, "username" => "demo", "name" => "demo");
            $response = httpPost("http://hoapi.ntwsoft.com",$data);
            $response = json_decode($response);
            $balance = $response->balance;
        } else {
            $user_control = $this->db->aresult("SELECT * FROM hogaming_users WHERE user_id = $userid");
            if ( isset($user_control['id']) ) {
                $data = array("method" => "balance", "key" => HOGAMING_KEY, "secret" => HOGAMING_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("http://hoapi.ntwsoft.com",$data);
                $response = json_decode($response);
                $balance = $response->balance;
            } else {
                $balance = "0.00";
            }
        }

        if (empty($bilgi)) {
            $data = array("method" => "balance", "key" => LIVEGAMES_KEY, "secret" => LIVEGAMES_SECRET, "username" => "demo", "name" => "demo");
            $response = httpPost("https://livegames.brongaming.com",$data);
            $response = json_decode($response);
            $bingo_balance = $response->balance;
        } else {
            $user_control = $this->db->aresult("SELECT * FROM livegames_users WHERE user_id = $userid");
            if ( isset($user_control['id']) ) {
                $data = array("method" => "balance", "key" => LIVEGAMES_KEY, "secret" => LIVEGAMES_SECRET, "username" => $username, "name" => $name);
                $response = httpPost("https://livegames.brongaming.com",$data);
                $response = json_decode($response);
                $bingo_balance = $response->balance;
            } else {
                $bingo_balance = "0.00";
            }
        }

        $match = $arrayName = array('casino' => nf($balance), 'bingo' => nf($bingo_balance), 'user' => nf($bilgi['bakiye']));
        echo json_encode($match);
    }

    function nullChange ($value) {
        if ($value ==  "") {
            return $value = "0";
        } else {
            return $value = round($value,2);
        }
    }

    function affiliate($user = null) {
        $user = security($user);

        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");

        if ( $bilgi['affiliate'] != 1 ) { header("Location: /myaccount"); die(); }

        if (!isset($_POST['from']) AND !isset($_POST['to'])) {
            $tarih2 =  date("Y-m-d");
            $tarih1 = date('Y-m-d',strtotime(date("Y-m-d") . "-1 days"));
        } else {
            $tarih2 = security( $_POST['to'] );
            $tarih1 = security( $_POST['from'] );

        }
        $baslangic = $tarih1." 00:00:00";
        $bitis = $tarih2." 23:59:00";
        $where = "&& ( UNIX_TIMESTAMP(str_to_date(date,'%Y-%m-%d %H:%i:%s')) >= UNIX_TIMESTAMP('$baslangic') && UNIX_TIMESTAMP(str_to_date(date,'%Y-%m-%d %H:%i:%s')) <= UNIX_TIMESTAMP('$bitis') )";
        $affiliates = $this->db->result("select id, name, username, affiliateid, bakiye, kayit_tarih from admin where affiliateid='$userid'order by bakiye DESC Limit 2500");

        $json['success'] = true;
        $json['seller'] = $bilgi['username'];
        $json['percent'] = $bilgi['affiliatepercent'];
        $list = [];
        $totalcommission = "0";

        if ($user == "users") {

            foreach ($affiliates as $affiliate) {

                $uyeDetay = $this->db->result("SELECT SUM(betTotal), SUM(betPending), SUM(betWon), SUM(betLost), SUM(betReturn), SUM(financeDeposit), SUM(financeWithdraw), SUM(Bonus) FROM affiliate where userid = '".$affiliate['id']."' $where order by id DESC")[0];

                $totbahis = $uyeDetay['SUM(betTotal)'];
                $bekbahis = $uyeDetay['SUM(betPending)'];
                $kazbahis = $uyeDetay['SUM(betWon)'];
                $kaybahis = $uyeDetay['SUM(betLost)'];
                $iadbahis = $uyeDetay['SUM(betReturn)'];
                $guncelbonus = $uyeDetay['SUM(Bonus)'];
                $bahiskari = $totbahis - ($bekbahis + $kazbahis + $iadbahis);
                $bahiskari2 = $bahiskari - $guncelbonus;
                $komisyon = ( ($bahiskari2 / 100) * $bilgi['affiliatepercent'] ) ;


                $list['users'][$affiliate['username']]['id'] = $affiliate['id'];
                $list['users'][$affiliate['username']]['username'] = $affiliate['username'];
                $list['users'][$affiliate['username']]['name'] = $affiliate['name'];
                $list['users'][$affiliate['username']]['balance'] = $this->nullChange($affiliate['bakiye'],2);
                $list['users'][$affiliate['username']]['registration'] = $affiliate['kayit_tarih'];
                $list['users'][$affiliate['username']]['bet']['total'] = $this->nullChange($totbahis);
                $list['users'][$affiliate['username']]['bet']['pending'] = $this->nullChange($bekbahis);
                $list['users'][$affiliate['username']]['bet']['won'] = $this->nullChange($kazbahis);
                $list['users'][$affiliate['username']]['bet']['lost'] = $this->nullChange($kaybahis);
                $list['users'][$affiliate['username']]['bet']['return'] = $this->nullChange($iadbahis);
                $list['users'][$affiliate['username']]['bet']['profit'] = $this->nullChange($bahiskari);
                $list['users'][$affiliate['username']]['finance']['deposit'] = $this->nullChange($uyeDetay['SUM(financeDeposit)']);
                $list['users'][$affiliate['username']]['finance']['mobiletransfer'] = $this->nullChange($uyeDetay['SUM(financeMobileTransfer)']);
                $list['users'][$affiliate['username']]['finance']['withdraw'] = $this->nullChange($uyeDetay['SUM(financeWithdraw)']);
                $list['users'][$affiliate['username']]['bonus'] = $this->nullChange($guncelbonus);
                $list['users'][$affiliate['username']]['netprofit'] = $this->nullChange($bahiskari2);
                $list['users'][$affiliate['username']]['commission'] = $this->nullChange($komisyon);
                $totalcommission = $totalcommission + $komisyon;
            }

        }

        $json['totalCommission'] = round($totalcommission,2);
        $list = str_replace('null','0',$list);
        $json['list'] = $list;

        $affiliatelink = "https://".$_SERVER["HTTP_HOST"]."/signin?ref=".$bilgi['id'];
        $this->view->display("affiliate.tpl",get_defined_vars());
    }



}

?>