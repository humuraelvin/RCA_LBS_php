<?php

class sports extends controller {
    
    function __construct() {
        parent::controller();
        $this->admin = $this->load->model("admin");
        $izinliler = explode(",", $GLOBALS["login"]);
        $this->admin->is_login();


    }

    function logout() {
        $this->admin->logout();
        header("Location: " . BASE_URL);
    }

    function referer_logout() {
        setcookie("username", "");
        unset($_SESSION["altim_id"]);
        Header("Location:" . $_SERVER['HTTP_REFERER']);
    }

    function index() {
        $ustleri = $this->admin->ustum();
        $user = $this->admin->getinfo();
        $login = $this->admin->is_login();
        //$bulten = $this->db->result("select * from maclar where canli ='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' order by tarih asc LIMIT 20");
        $bulten = $this->db->result("select * from maclar where canli ='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' order by tarih asc LIMIT 20");

        $this->view->display("sports.tpl", get_defined_vars());
    }




    function livedetails($id) {
        $id = security($id);


        $odds_settings = $this->db->result("SELECT * FROM settings WHERE `key` = 'live_odds' ");
        $odds_percent = $odds_settings[0]['value'];
        $odds_data = json_decode($odds_percent);
        $operation = $odds_data[0];
        $percent = $odds_data[1];
        
        $mac = $this->db->aresult("select * from maclar where id='$id'");
        $sira = array("1" => "0", "0" => "1", "2" => "2");

        if ($mac["oynuyormu"] == 0) {
            echo "<img src='/images/stopBahis.png' width='100%'>";
            exit;
        }
        $this->view->display("canliayrinti.tpl", get_defined_vars());
    }

    function livedetailsodds($id) {
        $id = security($id);

        $mac = $this->db->aresult("select * from maclar where id='$id'");
        $sira = array("1" => "0", "0" => "1", "2" => "2");

        if ($mac["oynuyormu"] == 0) {
            echo "<img src='/images/stopBahis.png' width='100%'>";
            exit;
        }

        $this->view->display("canliayrintioran.tpl", get_defined_vars());
    }

    function canli_ayrinti($id) {
        $id = security($id);

        $userid = $this->admin->user_id();
        $orans = array();
        $ustleri = $this->admin->ustum();
        $sira = array("1" => "0", "0" => "1", "2" => "2");
        $bilgi = $this->db->aresult("select * from admin where id='$userid'");
        if ($bilgi["canli"] == "1") {
            die("Canlı oynayamazsınız");
        }
        if ($bilgi["canlidk"] == 0) {
            $mac = $this->db->aresult("select * from maclar where id='$id'");
        } else {
            $mac = $this->db->aresult("select * from maclar where id='$id' and dakika < '" . $bilgi["canlidk"] . "'");
        }
        if (!$mac["id"]) {
            echo "<img src='/images/stopBahis.png' width='100%'>";
            exit;
        }
        if ($mac["oynuyormu"] == 0) {
            echo "<img src='/images/stopBahis.png' width='100%'>";
            exit;
        }
        $yeroran = $GLOBALS["botyer"];
        $gizli = $this->db->result("select * from gizlioran where userid in (" . implode(",", $ustleri) . ")");
        $duzelt = $this->db->result("select * from oranduzelt where userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "oranid");
        $gizliler = array();
        foreach ($gizli as $z) {
            $gizliler[] = $z["oranid"];
        }
        $bot = simplexml_load_string(macorancek($mac["botid"]));
        if ($yeroran == "bwin") {
            $detay = $bot->Detay->attributes();
            $olay = $bot->Detay->olay;
            //  print_r($bot);
            $oranlars = array();
            foreach ($bot->Oranlar->Oran as $za) {
                $at = $za->attributes();
                for ($k = 0; $k < 3; $k++) {
                    $oranlars[] = $at["oran_tur"] . " " . $k;
                    $al[$at["oran_tur"] . " " . $k] = $at;
                }
            }
        } else {
            $bot = simplexml_load_string(macorancek($mac["botid"]));
            $oranlars = array();
            foreach ($bot->Oran as $za) {
                $at = $za->attributes();
                for ($k = 0; $k < 3; $k++) {
                    $oranlars[] = $at["oran_tur"] . " " . $k;
                    $al[$at["oran_tur"] . " " . $k] = $at;
                }
            }
        }
        $oranzz = $this->db->result("select * from oranlar where $yeroran in ('" . implode("','", $oranlars) . "') and canli=1");
        foreach ($oranzz as $op) {
            $oranid[$op[$yeroran]] = $op;
            $oranzzz[] = $op["id"];
        }
        $za = $this->db->result("select * from mac_oranlar where user_id in (" . implode(",", $ustleri) . ") and macid='$mac[id]' order by field(user_id," . implode(",", $ustleri) . ")");
        foreach ($za as $zaz) {
            $mac_oranlars[$zaz["oranid"]] = $zaz;
        }
        foreach ($al as $ty => $at) {
            $orani = $oranid[$ty];
            $zaz = $mac_oranlars[$orani["id"]];
            if ($orani["pasif"] != 1 && !in_array($orani["id"], $gizliler)) {
                $oranads[$orani["id"]] = $orani;
                $exp = explode(" ", $orani[$yeroran]);
                $z = array("oran" => oranf((string) $at["oran" . $exp[1]], $zaz["artis"], $duzelt[$orani["id"]]["miktar"]), "oranid" => $orani["id"], "aktifmi" => $at["aktifmi"], "macid" => $mac["id"]);
                $orans[$exp[0]][$sira[$exp[1]]] = $z;
            }
        }

        $this->view->display("canliayrinti.tpl", get_defined_vars());
    }

    function livematchs($ajax = 0) {
        $id = security($ajax);


        $userid = "1";
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");

        $simdi = date("Y-m-d\TH:i:s\Z");
        $bulten = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
        $gelecek = $this->db->result("select * from maclar where canli=1 and  tarih > '" . date("Y-m-d\TH:i:s\Z") . "' and sistem='$GLOBALS[botyer]' order by tarih asc");

        $bultenbasket = $this->db->result("select * from maclar where canli=88 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
        $gelecekbasket = $this->db->result("select * from maclar where canli=88 and  tarih > '" . date("Y-m-d\TH:i:s\Z") . "' and sistem='$GLOBALS[botyer]' order by tarih asc");

        $bultenvoleybol = $this->db->result("select * from maclar where canli=888 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
        $gelecekvoleybol = $this->db->result("select * from maclar where canli=888 and  tarih > '" . date("Y-m-d\TH:i:s\Z") . "' and sistem='$GLOBALS[botyer]' order by tarih asc");


        $this->view->display("canli.tpl", get_defined_vars());
    }

    function livematchsright($ajax = 0) {
        $id = security($ajax);


        $userid = "1";
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");

        if ($bilgi["canlidk"] == 0) {
            $simdi = date("Y-m-d\TH:i:s\Z");
            $bultenz = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
        } else {
            $bultenz = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' and dakika < '" . $bilgi["canlidk"] . "' order by ulkeid DESC");
        }

        foreach ($bultenz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenz as $k => $bul) {
            $zaz = $b[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bulten[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzz = $this->db->result("select * from maclar where canli=77 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzz = $this->db->result("select * from maclar where canli=77 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzz as $k => $bul) {
            $zaz = $bb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenbas[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzz = $this->db->result("select * from maclar where canli=88 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzz = $this->db->result("select * from maclar where canli=88 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzz as $k => $bul) {
            $zaz = $bbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenbasket[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzzz = $this->db->result("select * from maclar where canli=99 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzzz = $this->db->result("select * from maclar where canli=99 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzzz as $k => $bul) {
            $zaz = $bbbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenvoley[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzzzz = $this->db->result("select * from maclar where canli=98 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzzzz = $this->db->result("select * from maclar where canli=98 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbbbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzzzz as $k => $bul) {
            $zaz = $bbbbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenhentbol[$bul["id"]] = $bul;
            }
        }



        $ilk=current($bulten);
        $ilk2=current($bultenbas);
        $ilk3=current($bultenbasket);
        $ilk4=current($bultenvoley);
        $ilk5=current($bultenhentbol);
        $this->view->display("canli_index.tpl", get_defined_vars());
    }

    function livematchsleft($ajax) {

        $id = security($id);

        $userid = "1";
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");

        if ($bilgi["canlidk"] == 0) {
            $simdi = date("Y-m-d\TH:i:s\Z");
            $bultenz = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' order by ulkeid DESC");
        } else {
            $bultenz = $this->db->result("select * from maclar where canli=1 and oynuyormu=1 and sistem='$GLOBALS[botyer]' and dakika < '" . $bilgi["canlidk"] . "' order by ulkeid DESC");
        }

        foreach ($bultenz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenz as $k => $bul) {
            $zaz = $b[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bulten[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzz = $this->db->result("select * from maclar where canli=77 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzz = $this->db->result("select * from maclar where canli=77 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzz as $k => $bul) {
            $zaz = $bb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenbas[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzz = $this->db->result("select * from maclar where canli=88 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzz = $this->db->result("select * from maclar where canli=88 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzz as $k => $bul) {
            $zaz = $bbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenbasket[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzzz = $this->db->result("select * from maclar where canli=99 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzzz = $this->db->result("select * from maclar where canli=99 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzzz as $k => $bul) {
            $zaz = $bbbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenvoley[$bul["id"]] = $bul;
            }
        }


        if ($bilgi["canlidk"] == 0) {
            $bultenzzzzz = $this->db->result("select * from maclar where canli=98 and oynuyormu=1  order by ulkeid DESC");
        } else {
            $bultenzzzzz = $this->db->result("select * from maclar where canli=98 and oynuyormu=1 order by ulkeid DESC");
        }

        foreach ($bultenzzzzz as $k => $bul) {
            $idler[] = $bul["id"];
        }
        $bbbbb = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") order by field(userid," . implode(",", $ustleri) . ")", "macid");

        foreach ($bultenzzzzz as $k => $bul) {
            $zaz = $bbbbb[$bul["id"]];
            if ($zaz["iptal"] != 1) {
                $bultenhentbol[$bul["id"]] = $bul;
            }
        }



        $ilk=current($bulten);
        $ilk2=current($bultenbas);
        $ilk3=current($bultenbasket);
        $ilk4=current($bultenvoley);
        $ilk5=current($bultenhentbol);
        $this->view->display("canli_index_sol.tpl", get_defined_vars());
    }

    function CountryMatch($ulke,$canli)
    {
        $ulke = security($ulke);
        $canli = security($canli);

        $idda = 1;
        global $base;
        $canli = $canli;
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");
        $acentasi = $this->db->aresult("select * from admin where id in ($bilgi[parent],'$userid') and type='acenta'");

        $base["debug"]->add("Bülten başlar", __FILE__, __LINE__);

        $_POST['mantican'] = security($_POST['mantican']);
        $_POST['zlig'] = security($_POST['zlig']);
        $_POST['takim'] = security($_POST['takim']);


        $where = "";

        if (isset($_POST["takim"]) and $_POST["takim"]) {
            $where = " and (evsahibi like '%$_POST[takim]%' or deplasman like '%$_POST[takim]%' )";
        }
        if ($canli == 0) {
            if ($GLOBALS["bulten"]) {
                $where .=" and sistem ='{$GLOBALS["bulten"]}'";
            } else {
                $where .=" and sistem ='hitit'";
            }
        }
        if (isset($_POST["mackodu"]) and $_POST["mackodu"]) {
            if ($idda == 1) {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            } else {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            }
        }
        if (isset($_POST["tarih"]) and $_POST["tarih"]) {
            $wtarih = " and tarih >'" . security( $_POST["tarih"] ) . " 00:00:00' and  tarih <'" . security( $_POST["tarih"] ) . " 23:59:59'";
        }
        if (isset($_POST["saat"]) and $_POST["saat"]) {
            $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["saat"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
        }
        if (isset($_POST["ztrh"]) && $_POST["ztrh"] != "0") {
            if ($_POST["ztrh"] == "1" || $_POST["ztrh"] == "3" || $_POST["ztrh"] == "6" || $_POST["ztrh"] == "12") {
                $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["ztrh"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
            } else {
                $where.=" and tarih >'" . security( $_POST["ztrh"] ) . " 00:00:00' and  tarih <'" . security( $_POST["ztrh"] ) . " 23:59:59'";
            }
        }
        if (isset($_POST["mantican"])) {
            if ($idda == 1) {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            } else {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            }
        }
//  echo $where .=" and lig='$_POST[zlig]'";
        if ($ulke !="") {
            if($ulke == "Düello ligi")
            {
                $where .=" and lig='$_POST[zlig]'";

            }
            else
            {
                $where .=" and ulkeisim='$ulke'";

            }


        }
        if ($idda == 0) {
            $where .=" and iddaakod!=0";
        } else {
            $where .=" and mackodu!='' and mackodu!='0'";
        }
        $base["debug"]->add("Bülten 2", __FILE__, __LINE__);
        $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . $wtarih . " order by tarih asc");

        if (count($bultenz) == 0) {
            $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . " order by mackodu asc");
        }
        $ligler = $this->db->result("select ulkeisim from maclar where canli='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' $wbere group by ulkeisim");
        $base["debug"]->add("Bülten 3", __FILE__, __LINE__);
        $tarihs = $this->db->result("select  CONCAT( CONCAT( YEAR(  `tarih`  ) , '-' ) , CONCAT( CONCAT( MONTH(  `tarih`  ) , '-' ) , DAY(  `tarih` ) ) ) AS tarihz from maclar where tarih>'" . date("Y-m-d\TH:i:s\Z") . "'  $where group by tarihz");
        foreach ($tarihs as $key => $z) {
            $tarihs[$key]["tarihz"] = date("Y-m-d", strtotime($z["tarihz"]));
        }
        $base["debug"]->add("Bülten 4", __FILE__, __LINE__);
        $ustleri = $this->admin->ustum();
        foreach ($bultenz as $k => $bul) {
            if ($idda == 1) {
                $k = $bul["mackodu"];
            } else {
                $k = $bul["iddaakod"];
            }
            $bulten[$k] = $bul;
            if (strlen($bulten[$k]["evsahibi"]) > 50)
                $bulten[$k]["evsahibi"] = substr($bulten[$k]["evsahibi"], 0, 50) . "...";
            if (strlen($bulten[$k]["deplasman"]) > 50)
                $bulten[$k]["deplasman"] = substr($bulten[$k]["deplasman"], 0, 50) . "...";
            $idler[] = $bul["id"];
        }
        if ($idler) {
            $ustlerim = $ustleri;
            arsort($ustlerim);
            $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and canli=0 order by id");
            foreach ($b as $z) {
                if (!$orz[$z["macid"]])
                    $orz[$z["macid"]] = $z;
            }
            if (count($b) == 0)
                die("Bir sorun oluştu. Hata kodu : 12385");
            $duzelt = $this->db->result("select * from oranduzelt where userid in (" . implode(",", $ustleri) . ") and oranid in (1,0,2,181,182,207,208,241,242) order by field(userid," . implode(",", $ustleri) . ")", "oranid");
            foreach ($bulten as $k => $bul) {
                $b = $orz[$bul["id"]];

                unset($b["tarih"]);
                unset($b["id"]);
                $bulten[$k] = array_merge($bul, $b);
                $bulten[$k]["0"] = oranf($b["0"], $b["0a"], $duzelt[0]["miktar"]);
                $bulten[$k]["1"] = oranf($b["1"], $b["1a"], $duzelt[1]["miktar"]);
                $bulten[$k]["2"] = oranf($b["2"], $b["2a"], $duzelt[2]["miktar"]);
                if (!$b or $b["iptal"] == "1")
                    unset($bulten[$k]);
            }

            $gizli = $this->db->result("select * from gizlioran where userid in (" . implode(",", $ustlerim) . ") order by field(userid," . implode(",", $ustleri) . ")");
            $gizliler = array();
            foreach ($gizli as $z) {
                $gizliler[] = $z["oranid"];
            }


            $idr = array();
            if ($canli != 2) {
                if (!in_array(181, $gizliler)) {
                    $idr[] = 181;
                }
                if (!in_array(182, $gizliler)) {
                    $idr[] = 182;
                }
                if (!in_array(207, $gizliler)) {
                    $idr[] = 207;
                }
                if (!in_array(208, $gizliler)) {
                    $idr[] = 208;
                }
                if (!in_array(209, $gizliler)) {
                    $idr[] = 209;
                }
            } else {
                if (!in_array(241, $gizliler)) {
                    $idr[] = 241;
                }
                if (!in_array(242, $gizliler)) {
                    $idr[] = 242;
                }
            }

            if ($idr[0]) {
                //echo "select id,oran,macid,oranid,user_id,artis from mac_oranlar where macid in(".implode(",",$idler).") and oranid in (".implode(",",$idr).") and user_id in (".implode(",",$ustleri).") order by field(user_id,".implode(",",$ustleri).")";
                $az = $this->db->result("select id,oran,macid,oranid,user_id,artis,aciklama from mac_oranlar where macid in(" . implode(",", $idler) . ") and oranid in (" . implode(",", $idr) . ") and user_id in (" . implode(",", $ustleri) . ") order by field(user_id," . implode(",", $ustleri) . ")");
                //echo mysql_error();
                //echo $this->db->last_query();
                foreach ($az as $z) {
                    if (!$oranii[$z["macid"]][$z["oranid"]]["id"]) {
                        $oranii[$z["macid"]][$z["oranid"]] = $z;
                        $oranii[$z["macid"]][$z["oranid"]]["oran"] = $oranii[$z["macid"]][$z["oranid"]]["oran"] + $duzelt[$z["oranid"]]["miktar"] * 1;
                    }
                }
            }
        }

        if($canli==0)
            $icon="kos k10_1";

        if($canli==2)
            $icon="kos k15_1";
        if($canli==5)
            $icon="kos k11_1";
        if($canli==15)
            $icon="kos k1012_1";
        if($canli==12)
            $icon="kos k40_1";
        if($canli==6)
            $icon="kos k1002_1";
        if($canli==22)
            $icon="kos k1016_1";

        function kacoranvar($ule)
        {

            $kcm = mysql_query("select id from mac_oranlar where macid='$ule'");
            $aded= mysql_num_rows($kcm);
            return $aded;
        }




        $base["debug"]->add("Bülten 5", __FILE__, __LINE__);

        $this->view->display("bulten.tpl", get_defined_vars());

        $base["debug"]->add("Bülten 6", __FILE__, __LINE__);

    }

    function LeagueMatch($lig_id,$canli)
    {
        $lig_id = security($lig_id);
        $canli = security($canli);

        $idda = 1;
        global $base;
        $canli = $canli;
        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");
        $acentasi = $this->db->aresult("select * from admin where id in ($bilgi[parent],'$userid') and type='acenta'");

        $base["debug"]->add("Bülten başlar", __FILE__, __LINE__);

        $_POST['mantican'] = security($_POST['mantican']);
        $_POST['mackodu'] = security($_POST['mackodu']);
        $_POST['takim'] = security($_POST['takim']);
        $_POST['zlig'] = security($_POST['zlig']);
        $where = "";

        if (isset($_POST["takim"]) and $_POST["takim"]) {
            $where = " and (evsahibi like '%$_POST[takim]%' or deplasman like '%$_POST[takim]%' )";
        }
        if ($canli == 0) {
            if ($GLOBALS["bulten"]) {
                $where .=" and sistem ='{$GLOBALS["bulten"]}'";
            } else {
                $where .=" and sistem ='hitit'";
            }
        }
        if (isset($_POST["mackodu"]) and $_POST["mackodu"]) {
            if ($idda == 1) {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            } else {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            }
        }
        if (isset($_POST["tarih"]) and $_POST["tarih"]) {
            $wtarih = " and tarih >'" . security( $_POST["tarih"] ) . " 00:00:00' and  tarih <'" . security( $_POST["tarih"] ) . " 23:59:59'";
        }
        if (isset($_POST["saat"]) and $_POST["saat"]) {
            $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["saat"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
        }
        if (isset($_POST["ztrh"]) && $_POST["ztrh"] != "0") {
            if ($_POST["ztrh"] == "1" || $_POST["ztrh"] == "3" || $_POST["ztrh"] == "6" || $_POST["ztrh"] == "12") {
                $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["ztrh"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
            } else {
                $where.=" and tarih >'" . security($_POST["ztrh"]) . " 00:00:00' and  tarih <'" . security($_POST["ztrh"]) . " 23:59:59'";
            }
        }
        if (isset($_POST["mantican"])) {
            if ($idda == 1) {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            } else {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            }
        }
        //  echo $where .=" and lig='$_POST[zlig]'";

        $where .=" and lig_id='$lig_id'";

        if ($idda == 0) {
            $where .=" and iddaakod!=0";
        } else {
            $where .=" and mackodu!='' and mackodu!='0'";
        }
        $base["debug"]->add("Bülten 2", __FILE__, __LINE__);
        $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . $wtarih . " order by tarih asc");

        if (count($bultenz) == 0) {
            $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . " order by tarih asc");
        }
        $ligler = $this->db->result("select ulkeisim from maclar where canli='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' $wbere group by ulkeisim");
        $base["debug"]->add("Bülten 3", __FILE__, __LINE__);
        $tarihs = $this->db->result("select  CONCAT( CONCAT( YEAR(  `tarih`  ) , '-' ) , CONCAT( CONCAT( MONTH(  `tarih`  ) , '-' ) , DAY(  `tarih` ) ) ) AS tarihz from maclar where tarih>'" . date("Y-m-d\TH:i:s\Z") . "'  $where group by tarihz");
        foreach ($tarihs as $key => $z) {
            $tarihs[$key]["tarihz"] = date("Y-m-d", strtotime($z["tarihz"]));
        }
        $base["debug"]->add("Bülten 4", __FILE__, __LINE__);
        $ustleri = $this->admin->ustum();
        foreach ($bultenz as $k => $bul) {
            if ($idda == 1) {
                $k = $bul["mackodu"];
            } else {
                $k = $bul["iddaakod"];
            }
            $bulten[$k] = $bul;
            if (strlen($bulten[$k]["evsahibi"]) > 50)
                $bulten[$k]["evsahibi"] = substr($bulten[$k]["evsahibi"], 0, 50) . "...";
            if (strlen($bulten[$k]["deplasman"]) > 50)
                $bulten[$k]["deplasman"] = substr($bulten[$k]["deplasman"], 0, 50) . "...";
            $idler[] = $bul["id"];
        }
        if ($idler) {
            $ustlerim = $ustleri;
            arsort($ustlerim);
            $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and canli=0 order by id");
            foreach ($b as $z) {
                if (!$orz[$z["macid"]])
                    $orz[$z["macid"]] = $z;
            }
            if (count($b) == 0)
                die("Bir sorun oluştu. Hata kodu : 12386");
            $duzelt = $this->db->result("select * from oranduzelt where userid in (" . implode(",", $ustleri) . ") and oranid in (1,0,2,181,182,207,208,241,242) order by field(userid," . implode(",", $ustleri) . ")", "oranid");
            foreach ($bulten as $k => $bul) {
                $b = $orz[$bul["id"]];

                unset($b["tarih"]);
                unset($b["id"]);
                $bulten[$k] = array_merge($bul, $b);
                $bulten[$k]["0"] = oranf($b["0"], $b["0a"], $duzelt[0]["miktar"]);
                $bulten[$k]["1"] = oranf($b["1"], $b["1a"], $duzelt[1]["miktar"]);
                $bulten[$k]["2"] = oranf($b["2"], $b["2a"], $duzelt[2]["miktar"]);
                if (!$b or $b["iptal"] == "1")
                    unset($bulten[$k]);
            }

            $gizli = $this->db->result("select * from gizlioran where userid in (" . implode(",", $ustlerim) . ") order by field(userid," . implode(",", $ustleri) . ")");
            $gizliler = array();
            foreach ($gizli as $z) {
                $gizliler[] = $z["oranid"];
            }


            $idr = array();
            if ($canli != 2) {
                if (!in_array(181, $gizliler)) {
                    $idr[] = 181;
                }
                if (!in_array(182, $gizliler)) {
                    $idr[] = 182;
                }
                if (!in_array(207, $gizliler)) {
                    $idr[] = 207;
                }
                if (!in_array(208, $gizliler)) {
                    $idr[] = 208;
                }
                if (!in_array(209, $gizliler)) {
                    $idr[] = 209;
                }
            } else {
                if (!in_array(241, $gizliler)) {
                    $idr[] = 241;
                }
                if (!in_array(242, $gizliler)) {
                    $idr[] = 242;
                }
            }

            if ($idr[0]) {
                //echo "select id,oran,macid,oranid,user_id,artis from mac_oranlar where macid in(".implode(",",$idler).") and oranid in (".implode(",",$idr).") and user_id in (".implode(",",$ustleri).") order by field(user_id,".implode(",",$ustleri).")";
                $az = $this->db->result("select id,oran,macid,oranid,user_id,artis,aciklama from mac_oranlar where macid in(" . implode(",", $idler) . ") and oranid in (" . implode(",", $idr) . ") and user_id in (" . implode(",", $ustleri) . ") order by field(user_id," . implode(",", $ustleri) . ")");
                //echo mysql_error();
                //echo $this->db->last_query();
                foreach ($az as $z) {
                    if (!$oranii[$z["macid"]][$z["oranid"]]["id"]) {
                        $oranii[$z["macid"]][$z["oranid"]] = $z;
                        $oranii[$z["macid"]][$z["oranid"]]["oran"] = $oranii[$z["macid"]][$z["oranid"]]["oran"] + $duzelt[$z["oranid"]]["miktar"] * 1;
                    }
                }
            }
        }

        if($canli==0)
            $icon="kos k10_1";

        if($canli==2)
            $icon="kos k15_1";
        if($canli==5)
            $icon="kos k11_1";
        if($canli==15)
            $icon="kos k1012_1";
        if($canli==12)
            $icon="kos k40_1";
        if($canli==6)
            $icon="kos k1002_1";
        if($canli==22)
            $icon="kos k1016_1";

        function kacoranvar($ule)
        {

            $kcm = mysql_query("select id from mac_oranlar where macid='$ule'");
            $aded= mysql_num_rows($kcm);
            return $aded;
        }




        $base["debug"]->add("Bülten 5", __FILE__, __LINE__);

        $this->view->display("bulten.tpl", get_defined_vars());

        $base["debug"]->add("Bülten 6", __FILE__, __LINE__);

    }

    function matchdetails($id)
    {
        $id = security($id);
        $id = mysql_real_escape_string($id);
        $bid = mysql_query("select botid,evsahibi,deplasman,tarih from maclar where id='$id'");
        $oki = mysql_fetch_array($bid);
        $betradar = $oki["botid"];
        $oranlar = file_get_contents("http://62.210.27.35/oranlar/".$betradar.".json");

        function nokta($t)
        {
            $tbu = str_replace(",",".",$t);
            return $tbu;
        }

        $this->view->display("matchdetails.tpl", get_defined_vars());
    }

    function bulten($idda = 1, $canli = 0,$trh=0) {
        global $base;


        $idda = security($idda);
        $canli = security($canli);
        $trh = security($trh);

        $userid = $this->admin->user_id();
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");
        $acentasi = $this->db->aresult("select * from admin where id in ($bilgi[parent],'$userid') and type='acenta'");

        if ($acentasi["basketyetki"] == "0" && $canli == "2") {
            die("<b>Listelenecek Karşılaşma Bulunamadı</b>");
        }
        $base["debug"]->add("Bülten başlar", __FILE__, __LINE__);

        $_POST['mackodu'] = security($_POST['mackodu']);
        $_POST['mantican'] = security($_POST['mantican']);
        $_POST['takim'] = security($_POST['takim']);
        $_POST['zlig'] = security($_POST['zlig']);

        $where = "";

        if (isset($_POST["takim"]) and $_POST["takim"]) {
            $where = " and (evsahibi like '%$_POST[takim]%' or deplasman like '%$_POST[takim]%' )";
        }
        if ($canli == 0) {
            if ($GLOBALS["bulten"]) {
                $where .=" and sistem ='{$GLOBALS["bulten"]}'";
            } else {
                $where .=" and sistem ='hitit'";
            }
        }
        if (isset($_POST["mackodu"]) and $_POST["mackodu"]) {
            if ($idda == 1) {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            } else {
                $where .=" and iddaakod ='{$_POST["mackodu"]}'";
            }
        }
        if (isset($_POST["tarih"]) and $_POST["tarih"]) {
            $wtarih = " and tarih >'" .  security($_POST["tarih"]) . " 00:00:00' and  tarih <'" . security($_POST["tarih"]) . " 23:59:59'";
        }
        if (isset($_POST["saat"]) and $_POST["saat"]) {
            $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["saat"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
        }
        if (isset($_POST["ztrh"]) && $_POST["ztrh"] != "0") {
            if ($_POST["ztrh"] == "1" || $_POST["ztrh"] == "3" || $_POST["ztrh"] == "6" || $_POST["ztrh"] == "12") {
                $where .=" and tarih <'" . date("Y-m-d\TH:i:s\Z", time() + 3600 * $_POST["ztrh"]) . "' and  tarih >'" . date("Y-m-d\TH:i:s\Z") . "'";
            } else {
                $where.=" and tarih >'" . security($_POST["ztrh"]) . " 00:00:00' and  tarih <'" . security($_POST["ztrh"]) . " 23:59:59'";
            }
        }
        if (isset($_POST["mantican"])) {
            if ($idda == 1) {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            } else {
                $where .=" and ( evsahibi like '%$_POST[mantican]%' or deplasman like '%$_POST[mantican]%' or iddaakod like '$_POST[mantican]%')";
            }
        }
//  echo $where .=" and lig='$_POST[zlig]'";
        if ($_POST["zlig"]) {
            if($_POST["zlig"] == "Düello ligi")
            {
                $where .=" and lig='$_POST[zlig]'";

            }
            else
            {
                $where .=" and lig='$_POST[zlig]'";

            }


        }
        if ($idda == 0) {
            $where .=" and iddaakod!=0";
        } else {
            $where .=" and mackodu!='' and mackodu!='0'";
        }
        $base["debug"]->add("Bülten 2", __FILE__, __LINE__);
        $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . $wtarih . " order by tarih asc LIMIT 100");

        if (count($bultenz) == 0) {
            $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . " order by tarih asc LIMIT 100");
        }
        $ligler = $this->db->result("select ulkeisim from maclar where canli='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' $wbere group by ulkeisim");
        $base["debug"]->add("Bülten 3", __FILE__, __LINE__);
        $tarihs = $this->db->result("select  CONCAT( CONCAT( YEAR(  `tarih`  ) , '-' ) , CONCAT( CONCAT( MONTH(  `tarih`  ) , '-' ) , DAY(  `tarih` ) ) ) AS tarihz from maclar where tarih>'" . date("Y-m-d\TH:i:s\Z") . "'  $where group by tarihz");
        foreach ($tarihs as $key => $z) {
            $tarihs[$key]["tarihz"] = date("Y-m-d", strtotime($z["tarihz"]));
        }
        $base["debug"]->add("Bülten 4", __FILE__, __LINE__);
        $ustleri = $this->admin->ustum();
        foreach ($bultenz as $k => $bul) {
            if ($idda == 1) {
                $k = $bul["mackodu"];
            } else {
                $k = $bul["iddaakod"];
            }
            $bulten[$k] = $bul;
            if (strlen($bulten[$k]["evsahibi"]) > 50)
                $bulten[$k]["evsahibi"] = substr($bulten[$k]["evsahibi"], 0, 50) . "...";
            if (strlen($bulten[$k]["deplasman"]) > 50)
                $bulten[$k]["deplasman"] = substr($bulten[$k]["deplasman"], 0, 50) . "...";
            $idler[] = $bul["id"];
        }
        if ($idler) {
            $ustlerim = $ustleri;
            arsort($ustlerim);
            $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and canli=0 order by id");
            foreach ($b as $z) {
                if (!$orz[$z["macid"]])
                    $orz[$z["macid"]] = $z;
            }
            if (count($b) == 0)
                die("Bir sorun oluştu. Hata kodu : 12387");
            $duzelt = $this->db->result("select * from oranduzelt where userid in (" . implode(",", $ustleri) . ") and oranid in (1,0,2,181,182,207,208,241,242) order by field(userid," . implode(",", $ustleri) . ")", "oranid");
            foreach ($bulten as $k => $bul) {
                $b = $orz[$bul["id"]];

                unset($b["tarih"]);
                unset($b["id"]);
                $bulten[$k] = array_merge($bul, $b);
                $bulten[$k]["0"] = oranf($b["0"], $b["0a"], $duzelt[0]["miktar"]);
                $bulten[$k]["1"] = oranf($b["1"], $b["1a"], $duzelt[1]["miktar"]);
                $bulten[$k]["2"] = oranf($b["2"], $b["2a"], $duzelt[2]["miktar"]);
                if (!$b or $b["iptal"] == "1")
                    unset($bulten[$k]);
            }

            $gizli = $this->db->result("select * from gizlioran where userid in (" . implode(",", $ustlerim) . ") order by field(userid," . implode(",", $ustleri) . ")");
            $gizliler = array();
            foreach ($gizli as $z) {
                $gizliler[] = $z["oranid"];
            }


            $idr = array();
            if ($canli != 2) {
                if (!in_array(181, $gizliler)) {
                    $idr[] = 181;
                }
                if (!in_array(182, $gizliler)) {
                    $idr[] = 182;
                }
                if (!in_array(207, $gizliler)) {
                    $idr[] = 207;
                }
                if (!in_array(208, $gizliler)) {
                    $idr[] = 208;
                }
                if (!in_array(209, $gizliler)) {
                    $idr[] = 209;
                }
            } else {
                if (!in_array(241, $gizliler)) {
                    $idr[] = 241;
                }
                if (!in_array(242, $gizliler)) {
                    $idr[] = 242;
                }
            }

            if ($idr[0]) {
                //echo "select id,oran,macid,oranid,user_id,artis from mac_oranlar where macid in(".implode(",",$idler).") and oranid in (".implode(",",$idr).") and user_id in (".implode(",",$ustleri).") order by field(user_id,".implode(",",$ustleri).")";
                $az = $this->db->result("select id,oran,macid,oranid,user_id,artis,aciklama from mac_oranlar where macid in(" . implode(",", $idler) . ") and oranid in (" . implode(",", $idr) . ") and user_id in (" . implode(",", $ustleri) . ") order by field(user_id," . implode(",", $ustleri) . ")");
                //echo mysql_error();
                //echo $this->db->last_query();
                foreach ($az as $z) {
                    if (!$oranii[$z["macid"]][$z["oranid"]]["id"]) {
                        $oranii[$z["macid"]][$z["oranid"]] = $z;
                        $oranii[$z["macid"]][$z["oranid"]]["oran"] = $oranii[$z["macid"]][$z["oranid"]]["oran"] + $duzelt[$z["oranid"]]["miktar"] * 1;
                    }
                }
            }
        }

        function kacoranvar($ule)
        {

            $kcm = mysql_query("select id from mac_oranlar where macid='$ule'");
            $aded= mysql_num_rows($kcm);
            return $aded;
        }


        if($canli==0)
            $icon="kos k10_1";

        if($canli==2)
            $icon="kos k15_1";
        if($canli==5)
            $icon="kos k11_1";
        if($canli==15)
            $icon="kos k1012_1";
        if($canli==4)
            $icon="kos k40_1";
        if($canli==6)
            $icon="kos k1002_1";
        if($canli==22)
            $icon="kos k1016_1";



        $base["debug"]->add("Bülten 5", __FILE__, __LINE__);

        $this->view->display("bulten.tpl", get_defined_vars());

        $base["debug"]->add("Bülten 6", __FILE__, __LINE__);
    }

    function upcomingevents($canli=0,$idda = 1)
    {
        $canli = security($canli);
        $idda = security($idda);


        global $base;
        $userid = 1;
        $bilgi = $this->db->aresult("select * from admin where id='$userid' and type='bayi'");
        $acentasi = $this->db->aresult("select * from admin where id in ($bilgi[parent],'$userid') and type='acenta'");
        $base["debug"]->add("Bülten başlar", __FILE__, __LINE__);
        $where = "";
        $base["debug"]->add("Bülten 2", __FILE__, __LINE__);
        $bultenz = $this->db->result("select * from maclar where canli='$canli' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "'" . $where . $wtarih . " order by tarih  LIMIT 15");
        $ligler = $this->db->result("select ulkeisim from maclar where canli='0' and tarih>'" . date("Y-m-d\TH:i:s\Z") . "' $wbere group by ulkeisim");
        $base["debug"]->add("Bülten 3", __FILE__, __LINE__);
        $tarihs = $this->db->result("select  CONCAT( CONCAT( YEAR(  `tarih`  ) , '-' ) , CONCAT( CONCAT( MONTH(  `tarih`  ) , '-' ) , DAY(  `tarih` ) ) ) AS tarihz from maclar where tarih>'" . date("Y-m-d\TH:i:s\Z") . "'  $where group by tarihz");
        foreach ($tarihs as $key => $z) {
            $tarihs[$key]["tarihz"] = date("Y-m-d", strtotime($z["tarihz"]));
        }
        $base["debug"]->add("Bülten 4", __FILE__, __LINE__);
        $ustleri = $this->admin->ustum();
        foreach ($bultenz as $k => $bul) {
            if ($idda == 1) {
                $k = $bul["mackodu"];
            } else {
                $k = $bul["iddaakod"];
            }
            $bulten[$k] = $bul;
            if (strlen($bulten[$k]["evsahibi"]) > 50)
                $bulten[$k]["evsahibi"] = substr($bulten[$k]["evsahibi"], 0, 50) . "...";
            if (strlen($bulten[$k]["deplasman"]) > 50)
                $bulten[$k]["deplasman"] = substr($bulten[$k]["deplasman"], 0, 50) . "...";
            $idler[] = $bul["id"];
        }
        if ($idler) {
            $ustlerim = $ustleri;
            arsort($ustlerim);
            $b = $this->db->result("select * from mac_oran where macid in (" . implode(",", $idler) . ") and userid in (" . implode(",", $ustleri) . ") and canli=0 order by field(userid," . implode(",", $ustleri) . ")");
            foreach ($b as $z) {
                if (!$orz[$z["macid"]])
                    $orz[$z["macid"]] = $z;
            }
            if (count($b) == 0)
                die("Bir sorun oluştu. Hata kodu : 12318");
            $duzelt = $this->db->result("select * from oranduzelt where userid in (" . implode(",", $ustleri) . ") and oranid in (1,0,2,181,182,207,208,241,242) order by field(userid," . implode(",", $ustleri) . ")", "oranid");
            foreach ($bulten as $k => $bul) {
                $b = $orz[$bul["id"]];

                unset($b["tarih"]);
                unset($b["id"]);
                $bulten[$k] = array_merge($bul, $b);
                $bulten[$k]["0"] = oranf($b["0"], $b["0a"], $duzelt[0]["miktar"]);
                $bulten[$k]["1"] = oranf($b["1"], $b["1a"], $duzelt[1]["miktar"]);
                $bulten[$k]["2"] = oranf($b["2"], $b["2a"], $duzelt[2]["miktar"]);
                if (!$b or $b["iptal"] == "1")
                    unset($bulten[$k]);
            }

            $gizli = $this->db->result("select * from gizlioran where userid in (" . implode(",", $ustlerim) . ") order by field(userid," . implode(",", $ustleri) . ")");
            $gizliler = array();
            foreach ($gizli as $z) {
                $gizliler[] = $z["oranid"];
            }


            $idr = array();


            if ($idr[0]) {
                //echo "select id,oran,macid,oranid,user_id,artis from mac_oranlar where macid in(".implode(",",$idler).") and oranid in (".implode(",",$idr).") and user_id in (".implode(",",$ustleri).") order by field(user_id,".implode(",",$ustleri).")";
                $az = $this->db->result("select id,oran,macid,oranid,user_id,artis,aciklama from mac_oranlar where macid in(" . implode(",", $idler) . ") and oranid in (" . implode(",", $idr) . ") and user_id in (" . implode(",", $ustleri) . ") order by field(user_id," . implode(",", $ustleri) . ")");
                //echo mysql_error();
                //echo $this->db->last_query();
                foreach ($az as $z) {
                    if (!$oranii[$z["macid"]][$z["oranid"]]["id"]) {
                        $oranii[$z["macid"]][$z["oranid"]] = $z;
                        $oranii[$z["macid"]][$z["oranid"]]["oran"] = $oranii[$z["macid"]][$z["oranid"]]["oran"] + $duzelt[$z["oranid"]]["miktar"] * 1;
                    }
                }
            }
        }

        function kacoranvar($ule)
        {

            $kcm = mysql_query("select id from mac_oranlar where macid='$ule'");
            $aded= mysql_num_rows($kcm);
            return $aded;
        }

        $this->view->display("indextur.tpl",get_defined_vars());

    }

    function mycoupons()
    {
        $toporan = 1;
        $this->load->library("cookie");
        if ($this->cookie->get("coupons")) {
            $kupon = $this->cookie->get("coupons");
            $kupon = json_decode(sifrecoz($kupon));
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
            if ($GLOBALS["mackodu"] == "iddaa")
                $mac["mackodu"] = $mac["iddaakod"];
            if (!$mac["mackodu"]) {
                $mac["mackodu"] = $mac["botid"];
            }
            $okupon[$k]["tur"] = $za->orantur;
            $okupon[$k]["grup"] = $za->orangrup;

            $okupon[$k]["mbs"] = $mac["mbs"];
            $okupon[$k]["evsahibi"] = $mac["evsahibi"];
            $okupon[$k]["deplasman"] = $mac["deplasman"];
            $okupon[$k]["oran"] = $za->oran;
            $okupon[$k]["id"] = $k;
            $okupon[$k]["canli"] = $mac["canli"];
            $okupon[$k]["oranadi"] = $oran["id"];
            $toporan*=$za->oran;
        }

        $this->view->display("mycoupons.tpl",get_defined_vars());
    }

    function removematch($id) {
        $this->load->library("cookie");
        if ($this->cookie->get("coupons")) {
            $kupon = $this->cookie->get("coupons");
            $kupon = json_decode(sifrecoz($kupon));
        } else {
            $kupon = array();
        }
        unset($kupon->$id);
        $kupon = sifrele(json_encode($kupon));
        $this->cookie->set("coupons", $kupon);
    }

    function addmatchlive($oranid,$orangrup,$orantur,$oran) {

        $oranid = security($oranid);
        $orangrup = security($orangrup);
        $orantur = security($orantur);
        $oran = security($oran);


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
            $kupon[$macid] = array("orangrup" => base64_decode($orangrup),"orantur" => base64_decode($tur), "oranid" => $oranid, "oran" => $orani);
        } else {
            $kupon->$macid = array("orangrup" => base64_decode($orangrup),"orantur" => base64_decode($tur), "oranid" => $oranid, "oran" => $orani);
        }
        $kupon = sifrele(json_encode($kupon));
        $this->cookie->set("coupons", $kupon);
        $id = $macid;
        $this->view->display("amacekle.tpl", get_defined_vars());
    }

}
?>