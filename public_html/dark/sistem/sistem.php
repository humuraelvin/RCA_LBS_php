<?php

// Tüm hataları raporla
error_reporting(E_ALL);

// Hata raporlamayı etkinleştir
ini_set('display_errors', 1);

// Ölümcül hatalar dahil, tüm hataların ekran üzerinde gösterilmesi
ini_set('display_startup_errors', 1);
	//echo !defined("GUVENLIK") ? die("Erişim Engellendi!") : null;
	error_reporting(1);
	require_once "ayar.php";
	require_once "fonksiyon.php";

	## Kullanıcı ##
	function kullanici($id = null) {
		global $db, $klaspoker, $klasokey, $Tombala, $betOn;
		$id = (!empty($id)) ? $id : session('id');
		if (session('admin_oturum')) {
			$kullanici = $db->prepare("SELECT * FROM admin WHERE id = ?");
			$kullanici->execute(array($id));



			// Poker Hesapları
			//$klaspoker = $klaspoker->getMemberBalance( (object) ['username' => '14248904204_18'] );
			//print_R($klaspoker);
			//$kullanici->fetchAll()[0]['klaspoker_balance'] = $klaspoker;

			return $kullanici->fetchAll()[0];
		}
	}

	## Kullanıcı Limitleri ##
	function limit_kontrol ( $permission_id ) {
		global $db;
		$id = session('id');
		$kontrol = $db->prepare("
			SELECT A.id,
			   P.permission_id,
			   P.permission_name
			FROM yonetici A,
			   admin_permissions P,
			   admin_role_permissions RP
			WHERE RP.permission_id = P.permission_id
			AND RP.user_id = A.id
			AND A.id = :id
			AND P.permission_id = :p_id
		");
		$kontrol->bindValue(":id", $id);
		$kontrol->bindValue(":p_id", $permission_id);
		$kontrol->execute();

		if ($kontrol->rowCount() > 0) {
			return true;
		} else return false;
	}

	function db_yonetici($id = null) {
		global $db, $klaspoker, $klasokey, $Tombala, $betOn;
		$id = (!empty($id)) ? $id : session('id');
		if (session('admin_oturum')) {
			$kullanici = $db->prepare("SELECT * FROM yonetici WHERE id = ?");
			$kullanici->execute(array($id));

			if ( $kullanici->rowCount() > 0 ) {
				return $kullanici->fetchAll()[0];
			} else return false;

		}
	}

	## Tema İçerik Fonksiyonu ##
	function tema_icerik() {

		global $db;
		$do = @g("do");

		$par = array_filter(explode('/', @g('par')));

		if ( db_yonetici() AND db_yonetici()['status'] == '1' ) {
			session_destroy();
			die("Lutfen tekrar deneyiniz.");
		}

		if (function_exists(@$par[0])) {
            if (in_array( strtolower($par[0]), get_defined_functions()['user'] )) {
                call_user_func(@$par[0], $par);
            } else { die(); }
		} else {
			if (session("admin_oturum")) {

				// Anasayfa //
				$tarihi = date("Y-m-d");

				$istatislikler = $db->prepare("
					SELECT  (
						SELECT COALESCE(SUM( bakiye ), 0)
						FROM   admin
						WHERE id != '1'
					) AS bakiye,
					(
						SELECT COALESCE(SUM( miktar ), 0)
						FROM   parayatir
						WHERE tarih LIKE :tarih AND durum = '1'
					) AS parayatir_miktar,
					(
						SELECT COALESCE(SUM( miktar ), 0)
						FROM   paracek
						WHERE tarih LIKE :tarih AND durum = '2'
					) AS paracek_miktar,
					(
						SELECT COALESCE(SUM( miktar ), 0)
						FROM kupon
						WHERE userid != '1' AND durum = '2' AND tarih LIKE :tarih
					) AS kaybeden_para,
					(
						SELECT COALESCE(SUM( miktar * oran ), 0)
						FROM kupon
						WHERE userid != '1' AND durum = '1' AND tarih LIKE :tarih
					) AS kazanan_para,
					(
						SELECT COALESCE(SUM( miktar ), 0)
						FROM kupon
						WHERE userid != '1' AND durum = '0' AND tarih LIKE :tarih
					) AS bekleyen_para,
					(
						SELECT COALESCE(SUM( miktar ), 0)
						FROM kupon
						WHERE userid != '1' AND durum != '3' AND iptal != '1' AND tarih LIKE :tarih
					) AS toppara,
					(
						SELECT COUNT(id) FROM admin
					) AS toplam_uye,
					(
						SELECT COUNT(id) FROM admin WHERE tarihi LIKE :tarih
					) AS toplam_uye_bugun,
					(
						SELECT COUNT(id) FROM kupon
					) AS toplam_kupon,
					(
						SELECT COUNT(id) FROM maclar
						WHERE oynuyormu='1' AND sistem= :botyer
					) AS toplam_canli,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '0' AND tarih > :tarih_saat AND sistem = :bulten ORDER BY mackodu ASC
					) AS futbol_mac,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '2' AND tarih > :tarih_saat ORDER BY mackodu ASC
					) AS basketbol_mac,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '3' AND tarih > :tarih_saat ORDER BY mackodu ASC
					) AS voleybol_mac,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '4' AND tarih > :tarih_saat ORDER BY mackodu ASC
					) AS hentbol_mac,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '5' AND tarih > :tarih_saat ORDER BY mackodu ASC
					) AS tenis_mac,
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli = '6' AND tarih > :tarih_saat ORDER BY mackodu ASC
					),
					(
						SELECT COUNT(id) FROM maclar
						WHERE canli='0' AND lig='Düello ligi' AND tarih>:tarih_saat AND sistem =:bulten ORDER BY mackodu ASC
					) AS duello_mac
					FROM   dual
				");
				$istatislikler->bindValue(":tarih", '%'.$tarihi.'%');
				$istatislikler->bindValue(":tarih_saat", date("Y-m-d H:i:s"));
				$istatislikler->bindValue(":bulten", $GLOBALS['bulten']);
				$istatislikler->bindValue(":botyer", $GLOBALS['botyer']);
				$istatislikler->execute();
				$rowIstatislikler = $istatislikler->fetchAll()[0];

				// Grafik Kupon //
				$kuponGrafik = $db->prepare("
					SELECT
					COUNT(*) AS ToplamKupon,
					(
						SELECT COUNT(*) FROM kupon B
						WHERE durum = '1' AND tarih LIKE CONCAT('%', A.tarih ,'%')
						GROUP BY date_format(tarih, '%Y-%m-%d')
					) AS ToplamKazanan,
					(
						SELECT COUNT(*) FROM kupon C
						WHERE durum = '0' AND tarih LIKE CONCAT('%', date_format(A.tarih, '%Y-%m-%d') , '%')
						GROUP BY date_format(tarih, '%Y-%m-%d')
					) AS ToplamBekleyen,
					(
						SELECT COUNT(*) FROM kupon C
						WHERE durum = '2' AND tarih LIKE CONCAT('%', date_format(A.tarih, '%Y-%m-%d') , '%')
						GROUP BY date_format(tarih, '%Y-%m-%d')
					) AS ToplamKaybeden, A.tarih AS KuponTarih FROM kupon A

					WHERE tarih BETWEEN :tarih1 AND :tarih2
					GROUP BY YEAR(tarih), MONTH(tarih), DAY(tarih)
				");
				$kuponGrafik->bindValue(":tarih1",  date('Y-m-d', strtotime('-7 day')) );
				$kuponGrafik->bindValue(":tarih2", date('Y-m-d', strtotime('+7 day')));
				$kuponGrafik->execute();
				$kuponGrafik = $kuponGrafik->fetchAll(PDO::FETCH_ASSOC);
				$grafikArray = [];

				foreach ($kuponGrafik as $key => $kupon) {
					$grafikArray[$key] = [
						'y' => date('Y-m-d', strtotime($kupon['KuponTarih'])),
						'a' => (int)$kupon['ToplamKupon'],
						'b' => (int)$kupon['ToplamBekleyen'],
						'c' => (int)$kupon['ToplamKazanan'],
						'd' => (int)$kupon['ToplamKaybeden']
					];
				}

				$grafikArray = json_encode($grafikArray);

				require TEMA . '/anasayfa.php';
			} else {
				require TEMA . '/giris.php';
			}
		}

	}

	## LOG ##
	function logInsert($array) {
		global $db;
		$insert = $db->prepare("
			INSERT INTO log (userid, islemad, tutar, tarih, oncekibakiye, sonrakibakiye) VALUES
			(?,?,?,?,?,?)
		");
		if ($insert->execute([$array['userid'], $array['islemad'], $array['tutar'], date("Y-m-d H:i:s"), $array['oncekibakiye'], $array['sonrakibakiye']]) === true) {
			return true;
		} else return false;
	}

	## YONETICI LOG ##
	function yLogInsert($array) {
		global $db;
		$insert = $db->prepare("
			INSERT INTO yonetici_logs
			( yonetici_id, aciklama, ip, tarih ) VALUES (?,?,?,?)
		");
		if ( $insert->execute([ session('id'), $array['aciklama'], GetIP(), date('Y-m-d H:i:s') ]) === true ) {
			return true;
		} else return false;
	}

	## Çıkış (function) ##
	function cikis() {
		if (session('admin_oturum')) {
			session_destroy();
			go(SITE_URL);
		} else go(SITE_URL);
	}

	## Kullanıcılar ##
	function kullanicilar($get) {

		global $db;

		if ( !limit_kontrol( 1 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$limit 			 = 500;
		$gorunecek_sayfa = 2;

		$kelime = @p('kelime');

		//
		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin
				WHERE ".p('sutun')." LIKE ? AND type != 'admin' ORDER BY name ASC
			");
			$kullanicilar->execute(['%' . $kelime . '%']);
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin WHERE type != 'admin'
				ORDER BY id DESC
			");
			$kullanicilar->execute();
		}
		$toplamKullanici = $kullanicilar->rowCount();

		$sayfa = (isset($get[1])) ? $get[1] : (@p('sayfa') ? p('sayfa') : 1);
		$toplam_sayfa = ceil( $toplamKullanici / $limit );
		$bas = ($sayfa - 1) * $limit;

		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin
				WHERE ".p('sutun')." LIKE ? AND type != 'admin'
				ORDER BY name ASC LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, '%' . $kelime . '%', PDO::PARAM_STR);
			$kullanicilar->bindValue(2, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(3, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin WHERE type != 'admin'
				ORDER BY id DESC
				LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(2, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		}

		require TEMA . '/kullanicilar.php';

	}


	function bayiler($get) {

		global $db;
		$functionName = __FUNCTION__;

		if ( !limit_kontrol( 1 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$limit 			 = 100;
		$gorunecek_sayfa = 2;

		$kelime = @p('kelime');

		//
		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin
				WHERE ".p('sutun')." LIKE ? AND type != 'admin' && affiliate = '1' ORDER BY name ASC
			");
			$kullanicilar->execute(['%' . $kelime . '%']);
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin WHERE type != 'admin' && affiliate = '1'
				ORDER BY id DESC
			");
			$kullanicilar->execute();
		}
		$toplamKullanici = $kullanicilar->rowCount();

		$sayfa = (isset($get[1])) ? $get[1] : (@p('sayfa') ? p('sayfa') : 1);
		$toplam_sayfa = ceil( $toplamKullanici / $limit );
		$bas = ($sayfa - 1) * $limit;

		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin
				WHERE ".p('sutun')." LIKE ? AND type != 'admin' && affiliate = '1'
				ORDER BY name ASC LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, '%' . $kelime . '%', PDO::PARAM_STR);
			$kullanicilar->bindValue(2, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(3, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM admin WHERE type != 'admin' && affiliate = '1'
				ORDER BY id DESC
				LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(2, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		}

		require TEMA . '/kullanicilar.php';

	}

	function bakiye_durumu() {
		global $db;

		if (!limit_kontrol(62)) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$kullanicilar = $db->query("SELECT * FROM admin  ORDER BY id DESC")->fetchAll();

		require TEMA . '/bakiye_durumu.php';

	}

	## Yönetim ##
	function yoneticiler() {
		global $db;

		if ( !limit_kontrol( 60 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$limit 			 = 100;
		$gorunecek_sayfa = 2;

		$kelime = @p('kelime');

		//
		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM yonetici
				WHERE ".p('sutun')." LIKE ? AND status = '0'
			");
			$kullanicilar->execute(['%' . $kelime . '%']);
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM yonetici WHERE status = '0'
				ORDER BY id DESC
			");
			$kullanicilar->execute();
		}
		$toplamKullanici = $kullanicilar->rowCount();

		$sayfa = (isset($get[1])) ? $get[1] : (@p('sayfa') ? p('sayfa') : 1);
		$toplam_sayfa = ceil( $toplamKullanici / $limit );
		$bas = ($sayfa - 1) * $limit;

		if (strlen($kelime) > 0) {
			$kullanicilar = $db->prepare("
				SELECT * FROM yonetici
				WHERE ".p('sutun')." LIKE ? AND status = '0'
				LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, '%' . $kelime . '%', PDO::PARAM_STR);
			$kullanicilar->bindValue(2, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(3, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		} else {
			$kullanicilar = $db->prepare("
				SELECT * FROM yonetici
				WHERE status = '0'
				ORDER BY id DESC
				LIMIT ?, ?
			");
			$kullanicilar->bindValue(1, $bas, PDO::PARAM_INT);
			$kullanicilar->bindValue(2, $limit, PDO::PARAM_INT);
			$kullanicilar->execute();
		}

		require TEMA . '/yoneticiler.php';
	}

	## Bakiye ##
	function bakiye($g)
	{
		global $db;

		$kullanicilar = $db->prepare("
			SELECT * FROM admin
			ORDER BY id DESC
		");
		$kullanicilar->execute();

		require TEMA . '/bakiye.php';
	}

	## Bakiye Özet ##
	function bakiye_ozet($g)
	{
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis		= @p('bitis');
		$filtre		= @p('filtre');
		$kullanici	= @p('kullanici');

		$where = ['1=1'];

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if (@$kullanici && $kullanici != '0')
			$where[] = "userid = '".$kullanici."'";
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";
		if ($filtre == "2") {
			$where[] = "islemad like '%Para Yatırma%'";
		} else if ($filtre == "3") {
			$where[] = "islemad like '%Para çekme%'";
		}

		if (!isset($g[1])) {
            $where[] = "(islemad like '%kupon%')";
        } else {
            $where[] = "(islemad not like '%kupon%')";

			// Hesap Özetleri
			if ( !limit_kontrol( 36 ) ) {
				require TEMA . '/erisim_yasak.php'; die();
			}
        }

		$where[] = "islemad not like '%Bonus%'";

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();

		$kullanicilar = $db->prepare("SELECT * FROM admin");
		$kullanicilar->execute();

		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));
		$kuponsay = $db->prepare("SELECT count(id) FROM log WHERE " . implode(" AND ", $where) . "  AND userid IN (" . $ids . ")");
		$kuponsay->execute();
		$kuponsay = end($kuponsay->fetchAll()[0]);

		$limit = 100;
		$sayfa = (@p('sayfa') ? p('sayfa') : 1);
		$toplam_sayfa = ceil( $kuponsay / $limit );
		$bas = ($sayfa - 1) * $limit;
		$gorunecek_sayfa = 2;
		$detaylar = $db->prepare("SELECT log.*,admin.username AS ad FROM log INNER JOIN admin ON admin.id=log.userid WHERE " . implode(" and ", $where) . "  AND userid IN (" . $ids . ") ORDER BY log.id DESC LIMIT $bas , $limit");
		$detaylar->execute();

		require TEMA . '/bakiye_ozet.php';
	}

	## Bakiye Rapor ##
	function bakiye_rapor ($g)
	{

		global $db;

		$baslangic = @p('baslangic');
		$kullanici = @p('kullanici');
		$bitis = @p('bitis');

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();

		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";
		if (@$kullanici || $kullanici != '0')
			$where[] = "userid = '".$kullanici."'";

		if (@$g[1] != 'detay') {
			$detaylar = $db->prepare("
				SELECT  SUM(miktar) AS toplam,count(id) AS kuponsay,userid,CONCAT( CONCAT( YEAR(  `tarih`  ) , '-' ) , CONCAT( CONCAT( MONTH(  `tarih`  ) , '-' ) , DAY(  `tarih` ) ) ) AS tarihz  FROM kupon WHERE " . implode(" and ", $where) . " GROUP BY tarihz
			");
			$detaylar->execute();
			$detaylar = $detaylar->fetchAll();

			foreach ($detaylar as $key => $value) {

				$bayi = $db->prepare("SELECT * FROM admin WHERE id = '".$value['userid']."' ");
				$bayi->execute();
				$bayi = $bayi->fetchAll();

				$detaylar[$key]["kullanici"] = $bayi[0]['username'];
				$detaylar[$key]["kazan"] = $db->query("select sum(miktar*oran) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=1 and tarih >'".$value['tarihz']." 00:00:00' and tarih <'".$value['tarihz']." 23:59:59' and " . implode(" and ", $where) . "")->fetch();
				$detaylar[$key]["kaybeden"] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=2 and tarih >'".$value['tarihz']." 00:00:00' and tarih <'".$value['tarihz']." 23:59:59' and " . implode(" and ", $where) . "")->fetch();
				$detaylar[$key]["devam"] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=0 and tarih >'".$value['tarihz']." 00:00:00' and tarih <'".$value['tarihz']." 23:59:59' and " . implode(" and ", $where) . "")->fetch();
				$detaylar[$key]["iptal"] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where  iptal=1 and tarih >'".$value['tarihz']." 00:00:00' and tarih <'".$value['tarihz']." 23:59:59' and " . implode(" and ", $where) . "")->fetch();

			}
		} else {

			if ( !limit_kontrol( 38 ) ) {
				require TEMA . '/erisim_yasak.php'; die();
			} // Detay Limit

			$detaylar = $db->prepare("select sum(miktar) as toplam,count(kupon.id) as kuponsay,userid,admin.username,admin.kazanoran from kupon inner join  admin on admin.id = userid where " . implode(" and ", $where) . " and iptal=0 group by userid order by username asc ");
			$detaylar->execute();
			$detaylar = $detaylar->fetchAll(PDO::FETCH_ASSOC);
			foreach ($detaylar as $key => $value) {
				$detaylar[$key]["komisyon"] = $value["kazanoran"];
				$detaylar[$key]["bayi"] 	= $value["username"];
			}
			$kazans[0] = $db->query("select  sum(miktar*oran) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=1  and " . implode(" and ", $where) . "  group by userid")->fetch();
			foreach ($kazans as $value) {
                $kazan[$value["userid"]] = $value;
            }
			$kaybedens[0] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=2 and " . implode(" and ", $where) . " group by userid")->fetch();
            foreach ($kaybedens as $value) {
                $kaybeden[$value["userid"]] = $value;
            }
            $devams[0] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where iptal = 0 and durum=0  and " . implode(" and ", $where) . " group by userid")->fetch();
            foreach ($devams as $value) {
                $devam[$value["userid"]] = $value;
            }
            $iptals[0] = $db->query("select sum(miktar) as toplam,count(id) as kuponsay,userid from kupon where iptal=1  and " . implode(" and ", $where) . " group by userid")->fetch();
            foreach ($iptals as $value) {
                $iptal[$value["userid"]] = $value;
            }
			foreach ($detaylar as $key => $value) {
                $detaylar[$key]["kazan"] = @$kazan[$value["userid"]];
                $detaylar[$key]["kaybeden"] = @$kaybeden[$value["userid"]];
                $detaylar[$key]["devam"] = @$devam[$value["userid"]];
                $detaylar[$key]["iptal"] = @$iptal[$value["userid"]];

				$dtoplam = $detaylar[$key]["toplam"];
                $dtoplams =$detaylar[$key]["kuponsay"];
                $dkazan = $detaylar[$key]["kazan"]["toplam"];
                $dkazans =$detaylar[$key]["kazan"]["kuponsay"];
                $ddevam = $detaylar[$key]["devam"]["toplam"];
                $ddevams =$detaylar[$key]["devam"]["kuponsay"];
                $dkaybeden =$detaylar[$key]["kaybeden"]["toplam"];
                $dkaybedens =$detaylar[$key]["kaybeden"]["kuponsay"];
				$dsonuc = $detaylar[$key]["toplam"] - round($detaylar[$key]["kazan"]["toplam"], 2) - $detaylar[$key]["devam"]["toplam"];
               }
		}

		$toplam = 0;
		$kom	= 0;

		$kullanicilar = $db->query("SELECT * FROM admin");

		require TEMA . '/bakiye_rapor.php';
	}

    function detailedReport() {
        global $db;

        $baslangic 	= @p('baslangic');
        $bitis 		= @p('bitis');
        $kullanici  = @p('kullanici');
        $tur  = ( @p('tur')  == "") ? 0 : @p('tur');



        if ($tur == "0") {
            $tursql = "islemad!= 's'";
        } elseif ($tur == "1") {
            $tursql = "islemad LIKE '%bakiye eklendi%'";
        } elseif ($tur == "2") {
            $tursql = "islemad LIKE '%bakiye çıkartıldı%'";
        } elseif ($tur == "3") {
            $tursql = "islemad= 'Rakeback Aktarma'";
        } elseif ($tur == "4") {
            $tursql = "islemad LIKE '%Bonus Yüklendi.%' && islemad!= '0 TL Bonus Yüklendi. (Bonussuz Yatırım)'";
        }

        if (!@$baslangic)
            $baslangic = date('Y-m-d');
        if (!@$bitis)
            $bitis		= date('Y-m-d');

        $kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

        $raporlar = $db->query("SELECT * FROM  `log` WHERE $tursql AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

        $totalrapor = $db->query("SELECT SUM(tutar) FROM  `log` WHERE $tursql AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql)->fetch();
        $toplambakiye =  $totalrapor['SUM(tutar)'];

        require TEMA . '/detailedreport.php';
    }


	## kupon_hareketleri ##
	function kupon_hareketleri() {
		global $db;

		$baslangic 	= @p('baslangic');
		$kullanici 	= @p('kullanici');
		$bitis 		= @p('bitis');

		$where = ["kesim = 0"];
		$where[] = "iptal = 0";

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();

		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";
		if (@$kullanici && $kullanici != '0')
			$where[] = "userid = '".$kullanici."'";

		$kullanicilar = $db->query("SELECT * FROM admin");
		$kupon = $db->query("SELECT COUNT(kupon.id) as kupon,userid,sum(miktar) as miktar,admin.username as userad FROM kupon inner join admin on admin.id = kupon.userid where " . implode(" and ", $where) . " and kupon.userid in (" . $ids . ") group by userid order by kupon desc");

		require TEMA . '/kupon_hareketleri.php';
	}

	## KUPONLAR ##
	function kuponlar($g) {

		global $db;

		if ( !limit_kontrol( 16 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		if ( !empty($_POST) AND !limit_kontrol(17) ) {
			require TEMA . '/erisim_yasak.php';
			die();
		}

		$desc 		= (@p('desc')) ? p('desc') : 'desc';
		$order		= 'id';
		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici 	= @p('kullanici');
		$url		= @$g[1];
		$mackodu	= @p('mackodu');
		$id 		= @p('id');
		$durum 		= @p('durum');

		$where = ["1=1"];

		$limit 			 = 100;
		$gorunecek_sayfa = 2;
		$sayfa 			 = (@p('sayfa')) ? p('sayfa') : 1;

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();
		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		if ( (@p('canli') || @p('canli') == '0' ) && @p('canli') != '') {
			if (p('canli') == "0") {
				$where[] = "canli= '0'";
			}
			if (p('canli') > 0) {
				$where[] = "canli = '1'";
			}
		}

		if (@$kullanici && $kullanici != '0')
			$where[] = "id = '".$kullanici."'";
		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";

        if ($durum == "0"){
            $where[] = "durum = 0";
        } elseif ($durum == 1){
            $where[] = "durum = 1";
        } elseif ($durum == 2){
            $where[] = "durum = 2";
        } elseif ($durum == 3){
            $where[] = "durum = 3";
        }


		if (isset($_POST["kesim"]) && implode(",", $_POST["kesim"]) != "")
			$where[] = "kesim in (" . implode(",", $_POST["kesim"]) . ")";

		if ($url == 'kazan') {
			$where[] = "durum=1  AND sil=0"; ## Kazanan Kuponları listeler.
		} else if ($url == 'devam') {
			$where[] = "durum=0  AND sil=0 and iptal=0"; ## Devam Eden kuponları listeler
		} else if ($url == 'kaybeden') {
			$where[] = "durum=2  AND sil=0"; ## Kaybeden kuponları listeler.
		} else if ($url == 'butun') {
			$where[] = "sil=0"; ## Bütün kuponları listeler
		} else if ($url == 'cop') {
			$where[] = "sil=1"; ## Silinen kuponları listeler
		}

		if ($mackodu) {
			$mac = $db->query("select kupon_mac.kuponid from kupon_mac inner join maclar on macid=maclar.id where maclar.botid like '".$mackodu."' or  maclar.mackodu like '".$mackodu."' group by kupon_mac.kuponid");
			$kupon[] = 0;
			foreach ($mac as $z) {
				$kuponid[] = $z["kuponid"];
			}
			$where[] = "id in (" . implode(",", $kuponid) . ")";
		}

		if ($id) {
			$where[] = "id= '".$id."'";
		}

		if ($url == 'ip') {
			$kuponsay = $db->query("select count(id) AS toplam from kupon where userid in (" . $ids . ") and " . implode(" and ", $where) . " order by $order $desc")->fetchAll();
			$toplam_sayfa = ceil($kuponsay[0]['toplam'] / $limit);
			$bas = ($sayfa - 1) * $limit;
			$kuponlar = $db->prepare("select * from kupon where userid in (" . $ids . ") and " . implode(" and ", $where) . " order by $order $desc");
			$kuponlart = $db->query("select * from kupon where iptal=0 and  userid in (" . $ids . ") and " . implode(" and ", $where) . " order by $order $desc ");
		} else {
			$kuponsay = $db->query("select count(id) AS toplam from kupon where userid in (" . $ids . ") and " . implode(" and ", $where) . "   order by $order $desc")->fetchAll();
			$toplam_sayfa = ceil($kuponsay[0]['toplam'] / $limit);
			$bas = ($sayfa - 1) * $limit;
			$kuponlar = $db->prepare("select * from kupon where userid in (" . $ids . ") and " . implode(" and ", $where) . "  order by $order $desc");
            $kuponlart = $db->query("select id,toplam,miktar,durum,oran,iptal,canli from kupon where  userid in (" . $ids . ") and " . implode(" and ", $where) . " limit 10000");
		}

		$kuponlar->execute();
		$kuponlar = $kuponlar->fetchAll();

		$kupid = array(0);

		foreach ($kuponlar as $kup) {
            $kupid[] = $kup["id"];
        }

		$td_kaz_a = $t_dev_a = $t_kay_a = $t_kay_m = $t_kaz_m = $t_dev_m = 0;
        $t_kaz_a = $td_dev_a = $td_kay_a = $td_kay_m = $td_kaz_m = $td_dev_m = 0;
        $t_canli = 0;
        $t_normal = 0;
        $t_iptal = 0;

        foreach ($kuponlart->fetchAll() as $k) {
            if ($k["iptal"] == "1") {
                $t_iptal++;
            }

			 if ($k["canli"] != "1") {
				$t_normal++;
			} else {
				$t_canli++;
			}
			$ms = $k["toplam"];
			if ($ms == 1) {
				if ($k["durum"] == "0") {
					$t_dev_a++;
					$t_dev_m+=$k["miktar"];
				} elseif ($k["durum"] == "1") {
					$t_kaz_m+=$k["miktar"];
					$t_kaz_a++;
				} elseif ($k["durum"] == "2") {
					$t_kay_m+=$k["miktar"];
					$t_kay_a++;
				}
			} else {
				if ($k["durum"] == "0") {
					$td_dev_a++;
					$td_dev_m+=$k["miktar"];
				} elseif ($k["durum"] == "1") {
					$td_kaz_m+=$k["miktar"];
					$td_kaz_a++;
				} elseif ($k["durum"] == "2") {
					$td_kay_m+=$k["miktar"];
					$td_kay_a++;
				}
			}
        }

		$toplam = 0;
		$kullanicilar = $db->query("SELECT * FROM admin");



		require TEMA . '/kuponlar.php';
	}

	## Bahis yoğunluğu ##
	function bahis_yogunlugu() {
		global $db;

		$kuponlar = $db->query("select count(kupon_mac.id) as  sayi ,kupon_mac.tur,kupon_mac.aciklamasi, sum(kupon.miktar) as miktar,maclar.deplasman as macd,maclar.id as manid ,maclar.evsahibi as mace,maclar.tarih as tarihi,maclar.botid as kodu from kupon_mac inner join kupon on kupon.id=kupon_mac.kuponid inner join maclar on maclar.id=kupon_mac.macid where kesim = 0 and kupon_mac.sonuc=0  and kupon.durum=0 and kupon_mac.kuponid!=0 and kupon.iptal=0 group by macid,tur order by sayi desc")->fetchAll();

		require TEMA . '/bahis_yogunlugu.php';
	}

	## Kupon Sayfası ##
	function kupon($id) {
		global $db;

		if ( !limit_kontrol( 18 ) ) {
			require TEMA . '/erisim_yasak.php';
			die();
		}

		$id = (isset($id[1])) ? $id[1] : die("access denied -> Error Code : 26");

		$user = kullanici();

		$maclar = $db->query("SELECT * FROM kupon_mac WHERE kuponid = '$id'")->fetchAll();
		$kupon  = $db->query("SELECT * FROM kupon WHERE id='$id' ")->fetch();

		if ($kupon["iptal"] == 1) {
            $sonuc = array("İptal", "İptal", "İptal");
        } else {
            $sonuc = array("Devam ediyor", "Kazandı", "Kaybetti");
        }

		foreach ($maclar as $a => $b) {
            if ($b["iptal"] == 1)
                $maclar[$a]["oran"] = 1;
        }

		require TEMA . '/kupon.php';
	}

	## Kullanıcı Finansal İşlemler ##
	function finansal_islemler($g) {
		global $db;

		$where = ["1=1"];

		$desc 		= (@p('desc')) ? p('desc') : 'desc';
		$order		= 'id';
		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici 	= @p('kullanici');
		$id 		= @$g[1];

		$limit 			 = 100;
		$gorunecek_sayfa = 2;
		$sayfa 			 = (@p('sayfa')) ? p('sayfa') : 1;
		$bas 			= ($sayfa - 1) * $limit;

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute([$id]);
		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		if (@$kullanici && $kullanici != '0')
			$where[] = "userid = '".$kullanici."'";
		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";

        $kuponsay = end($db->query("select count(id) from log where " . implode(" and ", $where) . "  and userid in (" . $ids . ")")->fetchAll())[0];
        $detaylar = $db->query("select log.*,admin.username as ad from log inner join admin on admin.id=log.userid where " . implode(" and ", $where) . "  and userid in (" . $ids . ") order by log.id desc limit $bas,$limit");

		$kullanicilar = $db->query("SELECT * FROM admin");
		$toplam_sayfa = ceil( $kuponsay / $limit );

		require TEMA . '/finansal_islemler.php';
	}

	## Sms EKLE ##
	function smsekle($g) {
		global $db;

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();
		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		$kullanicilar = $db->query("SELECT * FROM admin WHERE id in (" . $ids . ") AND type='bayi' ORDER BY username");

		require TEMA . '/smsekle.php';
	}



	## Mac Düzenle ##
	function mac_duzenle ($url) {
		global $db;

		if ( !limit_kontrol( 24 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$id = $url[1];

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();

		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

		$oranlar = $db->query("select * from oranlar order by id asc")->fetchAll();
		$mac = $db->query("select * from maclar where id='$id'")->fetch();
		$yeroran = SITE_BOTYER;
		$duzelt = $db->query("select * from oranduzelt where userid in (" . $ids . ") order by field(userid," . $ids . ")")->fetchAll();
		$gizli = $db->query("select * from gizlioran where userid in (" . $ids . ") ")->fetchAll();
		$gizliler = array();

		foreach ($gizli as $z) {
			$gizliler[] = $z["oranid"];
		}

		require TEMA . '/mac_duzenle.php';
	}

	function sportsLimit() {
        global $db;
        if ( !limit_kontrol( 100 ) ) { require TEMA . '/erisim_yasak.php'; die(); }

        $type = 0;
        if ($_POST) {
            $type = @p('type');
            if(!is_numeric($type))  {  die("Hatalı Paramatre"); }
        }
        
        $sports = $db->query("SELECT * FROM dark_sports WHERE live = $type ORDER BY listindex ASC");
        require TEMA . '/' . __FUNCTION__ . '.php';
    }

	function countryLimit() {
        global $db;
        if ( !limit_kontrol( 100 ) ) { require TEMA . '/erisim_yasak.php'; die(); }

        $type = 0;
        $sportid = 0;
        if ($_POST) {
            $type = @p('type');
            $sportid = @p('sportid');
            if(!is_numeric($type))  {  die("Hatalı Paramatre"); }
            if(!is_numeric($sportid))  {  die("Hatalı Paramatre"); }
        }

        $list = $db->query("SELECT * FROM dark_sports WHERE live = $type ORDER BY listindex ASC");
        $sports = $db->query("SELECT * FROM dark_country WHERE `live`=$type && `sportid`=$sportid ORDER BY listindex ASC");

        require TEMA . '/' . __FUNCTION__ . '.php';
    }

	function leagueLimit() {
        global $db;
        if ( !limit_kontrol( 100 ) ) { require TEMA . '/erisim_yasak.php'; die(); }

        $type = 0;
        $sportid = 0;
        if ($_POST) {
            $type = @p('type');
            $sportid = @p('sportid');
            $countryid = (isset($countryid)) ? 0 : @p('countryid');

        }

        $list = $db->query("SELECT * FROM dark_sports WHERE live = $type ORDER BY listindex ASC");
        $country = $db->query("SELECT * FROM dark_country WHERE live = $type && sportid = $sportid ORDER BY listindex ASC");

        if (!$_POST) {
            $country = $country->fetchAll(PDO::FETCH_ASSOC);
            $countryid = $country[0]['countryid'];

        }

        $sports = $db->query("SELECT * FROM dark_leagues WHERE live=$type && sportid=$sportid && countryid=$countryid ORDER BY listindex ASC");

        require TEMA . '/' . __FUNCTION__ . '.php';
    }

	## Online Üyeler ##
	function online() {
		global $db;

		if ( !limit_kontrol( 37 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$baslangic 	= @strtotime(p('baslangic'));
		$bitis 		= @strtotime(p('bitis'));

		$where = [];

		if (!@$baslangic)
			$baslangic = strtotime(date('Y-m-d'));
		if (!@$bitis)
			$bitis		= strtotime("+1 day", strtotime(date('Y-m-d')));
		if ($baslangic AND $bitis)
			$where[] = "login_time BETWEEN '".$baslangic."' AND '" . $bitis . "'";

		$ids = $db->prepare("SELECT id FROM admin");
		$ids->execute();

		$ids = implode(",", $ids->fetchAll(PDO::FETCH_COLUMN, 0));

        $online = $db->query("select admin_session.*,admin.username from admin_session inner join admin on admin_id=admin.id where admin_id in (" . $ids . ") and ".implode("and ", $where)." order by last_active desc")->fetchAll();

		require TEMA . '/online.php';
	}

	## Banka İşlemleri - Yatırma Talep ##
	function yatirmatalep() {
		global $db;

		if ( !limit_kontrol( 26 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$baslangic 	= @p('baslangic');
		$bitis 	= @p('bitis');
		$kullanici	= @p('kullanici');
		$tur		= @$_POST['tur'];
		$durum		= @p('durum');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if (@$kullanici && $kullanici != '0')
			$where[] = "A.uye = '".$kullanici."'";
		if ($baslangic AND $bitis)
			$where[] = "A.tarih >= '".$baslangic." 00:00:00' and A.tarih <= '".$bitis." 23:59:59'";
		if (@$tur && $tur != '0')
			$where[] = "A.tur REGEXP ('" . implode("|", $tur) . "')";
		if ($durum != '3') {
			$where[] = "A.durum = '".$durum."'";
		}

		$talep = $db->query("SELECT A.*, B.bonusadi, B.yuzde, B.cevrim, B.oran, B.durum AS bonus_durum FROM `parayatir` AS A INNER JOIN bonuslar AS B ON A.bonus = B.id WHERE " . implode(" AND ", $where) . " ORDER BY id DESC")->fetchAll();

		require TEMA . '/yatirmatalep.php';
	}

	## Banka İşlemleri - Çekme Talep ##
	function cekmetalep() {
		global $db;

		if ( !limit_kontrol( 31 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$baslangic 	= @p('baslangic');
		$bitis 	= @p('bitis');
		$kullanici	= @p('kullanici');
		$tur		= @$_POST['tur'];
		$durum		= @p('durum');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if (@$kullanici && $kullanici != '0')
			$where[] = "uye = '".$kullanici."'";
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";
		if (@$tur && $tur != '0')
			$where[] = "turu REGEXP ('" . implode("|", $tur) . "')";
		if ($durum != '4') {
			$where[] = "durum = '".$durum."'";


		}

		$rows = $db->query("SELECT * FROM paracek WHERE " . implode(" AND ", $where) . " ORDER BY id DESC")->fetchAll();

		require TEMA . '/cekmetalep.php';
	}

	## Banka İşlemleri - Yatırım Talep Detay ##
	function yatirim_talepdetay($id) {
		global $db;

		if ( !limit_kontrol( 29 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		if (is_numeric(@$id[1])) {
			$id = $id[1];
			$talep = $db->prepare("SELECT * FROM parayatir WHERE id = ?");
			if ($talep->execute([$id]) === true) {
				if ($talep->rowCount() > 0) {
					$talep = $talep->fetch();

					$kullanici = kullanici($talep['uye']);

					require TEMA . '/yatirim_talepdetay.php';
				}
			}
		} else die();
	}

	## Banka İşlemleri - Çekim Talep Detay ##
	function cekim_talepdetay($id) {
		global $db;

		if ( !limit_kontrol( 34 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		if (is_numeric(@$id[1])) {
			$id = $id[1];
			$talep = $db->prepare("SELECT * FROM paracek WHERE id = ?");
			if ($talep->execute([$id]) === true) {
				if ($talep->rowCount() > 0) {
					$talep = $talep->fetch();

					$kullanici = kullanici($talep['uye']);

					require TEMA . '/cekim_talepdetay.php';
				}
			}
		} else die();
	}

	function transfertalep() {
		global $db;

		$talep = $db->query("SELECT * FROM transferler ORDER BY id DESC")->fetchAll();

		require TEMA . '/transfertalep.php';
	}

	/* SMS Gonder */
	function sms_gonder() {

		if ( !limit_kontrol( 39 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/sms_gonder.php';
	}

	/* Kullanıcı Sayfası */
	function yonetici( $url ) {
		global $db;

		/* if ( !limit_kontrol( 4 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		} */

		$kullaniciBul = $db->prepare("
			SELECT * FROM yonetici
			WHERE yonetici.id = ?
		");
		$kullaniciBul->execute([ $url[1] ]);

		$uyeid = $url[1];

		if ($kullaniciBul->rowCount() > 0) {
			$kullanici = $kullaniciBul->fetchAll( PDO::FETCH_ASSOC )[0];

			if ( limit_kontrol(60) ) {
				require TEMA . '/yonetici.php';
			} else {
				if ( $kullanici['id'] == session('id') ) {
					require TEMA . '/yonetici.php';
				} else {
					require TEMA . '/erisim_yasak.php'; die();
				}
			}

		} else die("Sistemsel Bir Hata Oluştu.");
	}

	function yonetici_limit($kullanici) {
		global $db;

		if ( !limit_kontrol( 41 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$permissions = $db->query("SELECT * FROM admin_permissions");
		$user_permissions = $db->query("
			SELECT A.id,
			   P.permission_id,
			   P.permission_name
			FROM yonetici A,
			   admin_permissions P,
			   admin_role_permissions RP
			WHERE RP.permission_id = P.permission_id
			AND RP.user_id = A.id
			AND A.id = '".$kullanici['id']."'
		");

		$permissions_diff = [];
		$user_diff = [];
		$permissions_array = [];

		foreach ($permissions->fetchAll() as $p) {
			$permissions_diff[$p['permission_id']] = $p['permission_id'];
			$permissions_array[ $p['permission_id'] ] = $p['permission_name'];
		}

		$user_permissions = $user_permissions->fetchAll();

		foreach ($user_permissions as $p) {
			$user_diff[] = $p['permission_id'];
		}

		require TEMA . '/kullanici_limit.php';
	}

	function yonetici_hareketleri () {

		global $db;

		if ( !limit_kontrol(61) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$baslangic 	= @p('baslangic');
		$bitis 	= @p('bitis');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "L.tarih >= '".$baslangic." 00:00:00' and L.tarih <= '".$bitis." 23:59:59'";

		$logs = $db->query("SELECT L.*, Y.username FROM `yonetici_logs` AS L LEFT JOIN yonetici AS Y ON L.yonetici_id = Y.id WHERE " . implode(" AND ", $where) . " ORDER BY L.id DESC");

		require TEMA . '/yonetici_hareketleri.php';
	}

	/* Kullanıcı Sayfası */
	function profil( $url ) {
		global $db;

		if ( !limit_kontrol( 4 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}



		$kullaniciBul = $db->prepare("
			select admin.*, id as admin_id from admin where id = ?
		");
		
		$kullaniciBul->execute([ $url[1] ]);

		if ($kullaniciBul->rowCount() > 0) {
			$kullanici = $kullaniciBul->fetchAll( PDO::FETCH_ASSOC )[0];
			$logs = $db->prepare("SELECT * FROM log WHERE userid = ? ORDER BY id DESC LIMIT 4");
			$logs->execute([ $url[1] ]);
			$logs = $logs->fetchAll( PDO::FETCH_ASSOC );

			$yatirim_cekim = $db->prepare("
				SELECT (
					SELECT COALESCE(SUM( miktar ), 0) FROM parayatir WHERE uye = :id AND durum = 1
				) AS deposit,
				(
					SELECT COALESCE(SUM( miktar ), 0) FROM paracek WHERE uye = :id AND durum = 2
				) AS draw
				FROM   dual
			");
			$yatirim_cekim->bindValue(":id", $url[1]); $yatirim_cekim->execute(); $yatirim_cekim = $yatirim_cekim->fetch();

            $sessionFind = $db->prepare("SELECT * FROM admin_session WHERE admin_id = ? ORDER BY id DESC limit 1");
            $sessionFind->execute([$url[1]]);

            if ($sessionFind->rowCount() > 0) {
                $sessionx = $sessionFind->fetchAll(PDO::FETCH_ASSOC)[0];
                $lastLoginDate = $sessionx['last_active'];
                $lastLoginIp = $sessionx['ip'];
            }



			require TEMA . '/kullanici.php';
		} else die("Sistemsel Bir Hata Oluştu. Err 203");
	}

	function profil_duzenle($kullanici) {

		if ( !limit_kontrol( 5 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/kullanici_duzenle.php';
	}


	function profil_bonus($kullanici) {
		global $db;

		if ( !limit_kontrol( 5 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}



		require TEMA . '/kullanici_bonus.php';
	}

	function profil_betlimit($kullanici) {
		global $db;

		if ( !limit_kontrol( 5 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}



		require TEMA . '/kullanici_betlimit.php';
	}




	function profil_bakiye($kullanici) {

		global $db;

		if ( !limit_kontrol( 6 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/kullanici_bakiye.php';
	}


    function profil_bayiler($kullanici) {
        global $db;

        if ( !limit_kontrol( 5 ) ) {
            require TEMA . '/erisim_yasak.php'; die();
        }

        $baslangic 	= @p('baslangic');
        $bitis 		= @p('bitis');
        $tur		= @$_POST['tur'];


        if (!@$baslangic) { $baslangic = date('Y-m-d',strtotime(date("Y-m-d") . "-1 days")); }
        if (!@$bitis) { $bitis = date('Y-m-d'); }

        $baslangicx = $baslangic." 00:00:00";
        $bitisx = $bitis." 23:59:00";

        $where = "&& ( UNIX_TIMESTAMP(str_to_date(date,'%Y-%m-%d %H:%i:%s')) >= UNIX_TIMESTAMP('$baslangicx') && UNIX_TIMESTAMP(str_to_date(date,'%Y-%m-%d %H:%i:%s')) <= UNIX_TIMESTAMP('$bitisx') )";

        $talep = $db->query("SELECT id, name, username, affiliateid, bakiye, kayit_tarih from admin where affiliateid='".$kullanici['admin_id']."' order by bakiye DESC ")->fetchAll();

        require TEMA . '/kullanici_bayiler.php';
    }

    function nullChange ($value) {
        if ($value ==  "") {
            return $value = "0";
        } else {
            return $value = round($value,2);
        }
    }

	function profil_hareketler($kullanici) {

		if ( !limit_kontrol( 9 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$tur		= @$_POST['tur'];
		$durum		= @p('durum');
		$islem_tip	= @p('islem');

		$prefix = ($islem_tip == '1') ? 'A.' : null;

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = $prefix."tarih >= '".$baslangic." 00:00:00' and ".$prefix."tarih <= '".$bitis." 23:59:59'";

		if ($islem_tip != '3') {

			if (@$tur && $tur != '0')
				if ($islem_tip == '1') {
					$where[] = $prefix."tur REGEXP ('" . implode("|", $tur) . "')";
				} else $where[] = $prefix."turu REGEXP ('" . implode("|", $tur) . "')";
			if ($durum != '3') {
				$where[] = $prefix."durum = '".$durum."'";
			}

		} else {
			if (!empty($tur)) {
				$where[] = $prefix."islemad REGEXP ('" . implode("|", $tur) . "')";
			}
		}

		/* Kontroller */
		if ( ( $islem_tip == '1' AND !limit_kontrol(12) ) || ( $islem_tip == '2' AND !limit_kontrol(11) ) || ( $islem_tip == '3' AND !limit_kontrol(10) ) ) {
			require TEMA . '/erisim_yasak.php';
			die;
		}

		$table = ($islem_tip == '1') ? 'parayatir' : 'paracek';
		$buton = ($islem_tip == '1') ? ['onay' => 'adminBankaYatirimTalepOnayla', 'sil' => 'adminBankaYatirimTalepSil', 'detay' => 'adminBankaYatirimTalepDetay'] : ['onay' => 'adminBankaCekimTalepOnayla', 'sil' => 'adminBankaCekimTalepSil', 'detay' => 'adminBankaCekimTalepDetay'];

		if ($islem_tip != '3') {
			$where[] = "uye = '".$kullanici['admin_id']."'";
		} else $where[] = "userid = '".$kullanici['admin_id']."'";

		if ($islem_tip != '3') {
			// SELECT A.*, B.bonusadi, B.yuzde, B.cevrim, B.oran, B.durum AS bonus_durum FROM `parayatir` AS A INNER JOIN bonuslar AS B ON A.bonus = B.id
			if ( $table == 'parayatir' ) {
				$talep = $db->query("SELECT A.*, B.bonusadi, B.yuzde, B.cevrim, B.oran, B.durum AS bonus_durum FROM `parayatir` AS A INNER JOIN bonuslar AS B ON A.bonus = B.id WHERE " . implode(" AND ", $where) . " ORDER BY id DESC")->fetchAll();
			} else {
				$talep = $db->query("SELECT * FROM ".$table."  WHERE " . implode(" AND ", $where) . " ORDER BY id DESC")->fetchAll();
			}
		} else {
			$talep = $db->query("select log.*,admin.id AS uye_id from log inner join admin on admin.id=log.userid where " . implode(" and ", $where) . " order by log.id desc")->fetchAll();
		}

		//print_r( $db->query("select log.*,admin.username as ad from log inner join admin on admin.id=log.userid where " . implode(" and ", $where) . " order by log.id desc") );

		require TEMA . '/kullanici_hareketler.php';
	}

	function profil_sms() {

		if ( !limit_kontrol( 14 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/kullanici_sms.php';
	}

	function profil_bahis($kullanici) {

		if ( !limit_kontrol( 13 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$url		= @$g[1];
		$mackodu	= @p('mackodu');
		$id 		= @p('id');

		$where = [];

		if ( (@p('canli') || @p('canli') == '0' ) && @p('canli') != '') {
			if (p('canli') == "0") {
				$where[] = "canli= '0'";
			}
			if (p('canli') > 0) {
				$where[] = "canli = '1'";
			}
		}

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');
		if ($baslangic AND $bitis)
			$where[] = "tarih >= '".$baslangic." 00:00:00' and tarih <= '".$bitis." 23:59:59'";

		if (isset($_POST['durum']) && @$_POST['durum'] == 3){
			$where[] = "iptal in (1)";
		} else if (isset($_POST['durum']) AND @$_POST['durum'] != 0) {
			$where[] = "iptal=0 and durum = '".$_POST['durum']."'";
		}

		if (isset($_POST["kesim"]) && implode(",", $_POST["kesim"]) != "")
			$where[] = "kesim in (" . implode(",", $_POST["kesim"]) . ")";

		if ($mackodu) {
			$mac = $db->query("select kupon_mac.kuponid from kupon_mac inner join maclar on macid=maclar.id where maclar.botid like '".$mackodu."' or  maclar.mackodu like '".$mackodu."' group by kupon_mac.kuponid");
			$kupon[] = 0;
			foreach ($mac as $z) {
				$kuponid[] = $z["kuponid"];
			}
			$where[] = "id in (" . implode(",", $kuponid) . ")";
		}

		if ($id) {
			$where[] = "id= '".$id."'";
		}

		$where[] = "userid = " . $kullanici['admin_id'];

		if ($url == 'ip') {
			$kuponsay = $db->query("select count(id) AS toplam from kupon where " . implode(" and ", $where) . " order by id desc")->fetchAll();
			$kuponlar = $db->prepare("select * from kupon where " . implode(" and ", $where) . " order by id desc");
			$kuponlart = $db->query("select * from kupon where iptal=0 and  userid in (" . $ids . ") and " . implode(" and ", $where) . " order by id desc ");
		} else {
			$kuponsay = $db->query("select count(id) AS toplam from kupon where " . implode(" and ", $where) . " order by id desc")->fetchAll();
			$kuponlar = $db->prepare("select * from kupon where " . implode(" and ", $where) . "  order by id desc");
            $kuponlart = $db->query("select id,toplam,miktar,durum,oran,iptal,canli from kupon where " . implode(" and ", $where) . " limit 10000");
		}

		$kuponlar->execute();
		$kuponlar = $kuponlar->fetchAll();

		$kupid = array(0);

		foreach ($kuponlar as $kup) {
            $kupid[] = $kup["id"];
        }

		$td_kaz_a = $t_dev_a = $t_kay_a = $t_kay_m = $t_kaz_m = $t_dev_m = 0;
        $t_kaz_a = $td_dev_a = $td_kay_a = $td_kay_m = $td_kaz_m = $td_dev_m = 0;
        $t_canli = 0;
        $t_normal = 0;
        $t_iptal = 0;

        foreach ($kuponlart->fetchAll() as $k) {
            if ($k["iptal"] == "1") {
                $t_iptal++;
            }

			 if ($k["canli"] != "1") {
				$t_normal++;
			} else {
				$t_canli++;
			}
			$ms = $k["toplam"];
			if ($ms == 1) {
				if ($k["durum"] == "0") {
					$t_dev_a++;
					$t_dev_m+=$k["miktar"];
				} elseif ($k["durum"] == "1") {
					$t_kaz_m+=$k["miktar"];
					$t_kaz_a++;
				} elseif ($k["durum"] == "2") {
					$t_kay_m+=$k["miktar"];
					$t_kay_a++;
				}
			} else {
				if ($k["durum"] == "0") {
					$td_dev_a++;
					$td_dev_m+=$k["miktar"];
				} elseif ($k["durum"] == "1") {
					$td_kaz_m+=$k["miktar"];
					$td_kaz_a++;
				} elseif ($k["durum"] == "2") {
					$td_kay_m+=$k["miktar"];
					$td_kay_a++;
				}
			}
        }

		$toplam = 0;

		require TEMA . '/kullanici_bahis.php';
	}

	function profil_limit($kullanici) {
		global $db;

		die();

		if ( !limit_kontrol( 41 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$permissions = $db->query("SELECT * FROM admin_permissions");
		$user_permissions = $db->query("
			SELECT A.id,
			   P.permission_id,
			   P.permission_name
			FROM admin A,
			   admin_permissions P,
			   admin_role_permissions RP
			WHERE RP.permission_id = P.permission_id
			AND RP.user_id = A.id
			AND A.id = '".$kullanici['admin_id']."'
		");

		$permissions_diff = [];
		$user_diff = [];
		$permissions_array = [];

		foreach ($permissions->fetchAll() as $p) {
			$permissions_diff[$p['permission_id']] = $p['permission_id'];
			$permissions_array[ $p['permission_id'] ] = $p['permission_name'];
		}

		$user_permissions = $user_permissions->fetchAll();

		foreach ($user_permissions as $p) {
			$user_diff[] = $p['permission_id'];
		}

		require TEMA . '/kullanici_limit.php';
	}

	function profil_bans( $kullanici ) {
		global $db;

		if ( !limit_kontrol( 72 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$bans = $db->query("
			SELECT admin_bans.*, yonetici.*, admin_bans.id AS ban_id FROM admin_bans
			RIGHT JOIN yonetici
			ON admin_bans.yonetici_id = yonetici.id
			WHERE admin_bans.kullanici_id = '".$kullanici['admin_id']."'
		");

		require TEMA . '/kullanici_bans.php';

	}

	## Genel Rapor Sayfa ##
    function genel_rapor() {
        global $db;

        if ( !limit_kontrol( 45 ) ) {
            require TEMA . '/erisim_yasak.php'; die();
        }

        $baslangic 	= @p('baslangic');
        $bitis 		= @p('bitis');

        if (!@$baslangic)
            $baslangic = date('Y-m-d');
        if (!@$bitis)
            $bitis		= date('Y-m-d');

        $rapor = $db->query("
                SELECT  (
                    SELECT COALESCE(SUM( miktar ), 0) FROM parayatir
                    WHERE tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59' AND tur = 'HAVALE'
                ) AS gelen_havale,
                (
                    SELECT COALESCE(SUM( miktar ), 0) FROM paracek
                    WHERE tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59' AND turu = 'HAVALE'
                ) AS giden_havale,
                (
                    SELECT COALESCE(SUM(miktar),0) FROM parayatir
                    WHERE tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59' AND tur = 'CEPBANK'
                ) AS gelen_cepbank
                FROM dual
            ");
        $rapor = $rapor->fetch();

        require TEMA . '/genel_rapor.php';
    }

	## Banner Ekke ##
	function banner_ekle() {

		if ( !limit_kontrol( 57 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/banner_ekle.php';
	}

	## Banner Düzenle ##
	function banner_duzenle() {
		global $db;

		if ( !limit_kontrol( 57 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/banner_duzenle.php';
	}

	## Raporlama - Oyunlar ##
	function xpro_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%xpro%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_xpro.php';
	}

	function livegames_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%livegames%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_livegames.php';
	}

	function poker_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%poker%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_poker.php';
	}

	function okeytavla_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%okey%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_okeytavla.php';
	}

	function vivo_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%vivo%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_vivo.php';
	}

	function ezugi_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%ezugi%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_ezugi.php';
	}

	function beton_rapor() {
		global $db;

		$baslangic 	= @p('baslangic');
		$bitis 		= @p('bitis');
		$kullanici  = @p('kullanici');

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

		$raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%eBetOn%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

		require TEMA . '/oyun_rapor_beton.php';
	}

    function oyun_rapor_evolution() {
        global $db;

        $baslangic 	= @p('baslangic');
        $bitis 		= @p('bitis');
        $kullanici  = @p('kullanici');

        if (!@$baslangic)
            $baslangic = date('Y-m-d');
        if (!@$bitis)
            $bitis		= date('Y-m-d');

        $kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

        $raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%Evolution%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

        require TEMA . '/oyun_rapor_evo.php';
    }

    function oyun_rapor_sanal() {
        global $db;

        $baslangic 	= @p('baslangic');
        $bitis 		= @p('bitis');
        $kullanici  = @p('kullanici');

        if (!@$baslangic)
            $baslangic = date('Y-m-d');
        if (!@$bitis)
            $bitis		= date('Y-m-d');

        $kullanici_sql = ( $kullanici != 0 ) ? ' AND userid = "'.$kullanici.'"' : null;

        $raporlar = $db->query("SELECT * FROM  `log` WHERE islemad LIKE  '%Sanal%' AND tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59'". $kullanici_sql);

        require TEMA . '/oyun_rapor_sanal.php';
    }

	function bonuslar() {
		global $db;

		$bonuslar = $db->query("SELECT * FROM bonuslar WHERE id != 5")->fetchAll();

		require TEMA . '/bonuslar.php';
	}

    function domainler() {
        global $db;

        $domainler = $db->query("SELECT * FROM domain")->fetchAll();

        require TEMA . '/domainler.php';
    }

	## Banka Yönetim ##
	function banka_hesaplari() {
		global $db;

		if ( !limit_kontrol( 66 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$hesaplar = $db->query("SELECT * FROM sitebanka ORDER BY id DESC");

		require TEMA . '/banka_hesaplari.php';
	}

	function banka_ekle() {
		global $db;

		if ( !limit_kontrol( 67 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/banka_ekle.php';
	}

	## Promosyon Yönetim ##
	function promosyon_ekle() {
		global $db;

		if ( !limit_kontrol( 78 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		$promosyonlar = $db->query("SELECT * FROM promosyonlar ORDER BY sira ASC")->fetchAll();

		require TEMA . '/' . __FUNCTION__ . '.php';
	}

	## Duyuru Yönetim ##
	function duyurular() {
		global $db;

		if ( !limit_kontrol( 80 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/' . __FUNCTION__ . '.php';
	}

	##
	function siralama() {
		global $db;

		if ( !limit_kontrol( 83 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/' . __FUNCTION__ . '.php';
	}

	##
	function kullanici_yakala() {

		if ( !limit_kontrol( 37 ) ) {
			require TEMA . '/erisim_yasak.php'; die();
		}

		require TEMA . '/' . __FUNCTION__ . '.php';
	}

	function settings() {
        if ( !limit_kontrol( 99 ) ) {
            require TEMA . '/erisim_yasak.php'; die();
        }
        global $db;
        $odds_services = $db->query("SELECT * FROM odd_services ORDER BY id DESC");
        require TEMA . '/' . __FUNCTION__ . '.php';
    }

	function sitesettings() {
        if ( !limit_kontrol( 99 ) ) {
            require TEMA . '/erisim_yasak.php'; die();
        }
        global $db;
        $settings = $db->query("SELECT * FROM settings ORDER BY id ASC");
        $settings = $settings->fetchAll(PDO::FETCH_ASSOC);

        require TEMA . '/' . __FUNCTION__ . '.php';
    }

	##
	function kupon_sonucla() {
		global $db;

		$baslangic = @p('baslangic');
		$bitis = @p('bitis');
		$durum = (p('durum')) ? p('durum') : 0;
		$result = (p('result')) ? p('result') : 0;

		$where = [];

		if (!@$baslangic)
			$baslangic = date('Y-m-d');
		if (!@$bitis)
			$bitis		= date('Y-m-d');

		$query = $db->query("SELECT * FROM kupon_mac WHERE oran!= '1' && result = $result && tarih >= '".$baslangic . " 00:00:00' and tarih <= '".$bitis." 23:59:59' and sonuc = '".$durum."' ORDER BY id DESC");

		require TEMA . '/' . __FUNCTION__ . '.php';
	}