<?php
	error_reporting(0);
	$anaDizin = realpath( dirname(__FILE__).'/..');
	require_once $anaDizin."/sistem/sistem.php";
    require_once $anaDizin."/sistem/lib/GoogleAuthenticator.php";

	$tip = @p('tip');
	$json = array();

	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && @$_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest") {
	  die("Isteginiz gecersizdir. Lutfen tekrar deneyiniz.");
	}

	if ( db_yonetici() AND db_yonetici()['status'] == '1' ) {
		session_destroy();
		die(json_encode(['error' => 'Islem basarisiz.']));
	}

	Switch ($tip)
	{
        case "adminGenelRapor":

            if ($_POST) {
                $baslangic = p('baslangic');
                $bitis = p('bitis');
            }

            $start = p('baslangic')." 00:00:00";
            $end = p('bitis')." 23:59:00";


            //YATIRIM
            $deposit = $db->query("SELECT SUM(miktar) FROM parayatir where durum='1' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $deposit = $deposit->fetch();

            //ÇEKİM
            $withdraw = $db->query("SELECT SUM(miktar) FROM paracek where durum='2' && 
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $withdraw = $withdraw->fetch();

            //TOPLAM BAHİS
            $totalbet = $db->query("SELECT SUM(miktar) FROM kupon where
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $totalbet = $totalbet->fetch();

            //KAZANAN BAHİS
            $winningbet = $db->query("SELECT SUM(odeme) FROM kupon where durum='1' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $winningbet = $winningbet->fetch();

            //KAYBEDEN BAHİS
            $loserbet = $db->query("SELECT SUM(miktar) FROM kupon where durum='2' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $loserbet = $loserbet->fetch();

            //BEKLEYEN BAHİS
            $pendingbet = $db->query("SELECT SUM(miktar) FROM kupon where durum='0' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $pendingbet = $pendingbet->fetch();

            //IADE BAHİS
            $returnbet = $db->query("SELECT SUM(miktar) FROM kupon where durum='3' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $returnbet = $returnbet->fetch();

            $betprofit = $totalbet['SUM(miktar)'] - ( $winningbet['SUM(odeme)'] +  $pendingbet['SUM(miktar)'] + $returnbet['SUM(miktar)']);

            $betcommission = $betprofit * 0.10;


            $hogamingdeposit = $db->query("SELECT SUM(tutar) as total FROM log where islemad='Bakiye Transferi ( Ana Bakiye -> Casino )' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $hogamingdeposit = $hogamingdeposit->fetch();

            $hogamingwithdraw = $db->query("SELECT SUM(tutar) as total FROM log where islemad='Bakiye Transferi ( Casino -> Ana Bakiye )' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $hogamingwithdraw = $hogamingwithdraw->fetch();


            $livegamesdeposit = $db->query("SELECT SUM(tutar) as total FROM log where islemad='Bakiye Transferi ( Ana Bakiye -> Tombala )' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $livegamesdeposit = $livegamesdeposit->fetch();

            $livegameswithdraw = $db->query("SELECT SUM(tutar) as total FROM log where islemad='Bakiye Transferi ( Tombala -> Ana Bakiye )' &&
			( UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) > UNIX_TIMESTAMP('$start') && UNIX_TIMESTAMP(str_to_date(tarih,'%Y-%m-%d %H:%i:%s')) < UNIX_TIMESTAMP('$end') ) order by id DESC");
            $livegameswithdraw = $livegameswithdraw->fetch();


            $report= [
                "finance" => [
                    "deposit" => $deposit['SUM(miktar)'],
                    "withdraw" => $withdraw['SUM(miktar)'],
                    "remaining" => $deposit['SUM(miktar)'] - $withdraw['SUM(miktar)'],
                ],
                "sportsbook" => [
                    "total" => $totalbet['SUM(miktar)'],
                    "winning" => round($winningbet['SUM(odeme)'],2),
                    "loser" => $loserbet['SUM(miktar)'],
                    "pending" => $pendingbet['SUM(miktar)'],
                    "return" => $returnbet['SUM(miktar)'],
                    "profit" => round($betprofit,2),
                    "commission" => round($betcommission,2),
                ],
                "casino" => [
                    "hogaming" => [
                        "deposit" => $hogamingdeposit['total'],
                        "withdraw" => $hogamingwithdraw['total'],
                        "total" => $hogamingdeposit['total'] - $hogamingwithdraw['total']
                    ],
                ],
                "bingo" => [
                    "livegames" => [
                        "deposit" => $livegamesdeposit['total'],
                        "withdraw" => $livegameswithdraw['total'],
                        "total" => $livegamesdeposit['total'] - $livegameswithdraw['total']
                    ],
                ]
            ];

            echo json_encode($report);
            die();

            break;

        case "kullaniciBakiyeleri":
            if ( session('admin_oturum') AND limit_kontrol(90) ) {
                error_reporting(0);
                sleep(1);

                $game = p('game');
                $uyeid = p('id');

                $kullaniciBul = $db->prepare("select * from admin where id = ?");

                $kullaniciBul->execute([ $uyeid ]);

                $kullanici = $kullaniciBul->fetchAll( PDO::FETCH_ASSOC )[0];


                if ( $game == "hogaming" )
                {
                    $data = array("method" => "balance", "key" => HOGAMING_KEY, "secret" => HOGAMING_SECRET, "username" => $kullanici['username'], "name" => $kullanici['name']);
                    $response = httpPost("https://hogaming.iyzibet.com",$data);
                    $response = json_decode($response);
                    $balance = $response->balance;
                }


                $json['success'] = true;
                $json['balance'] = round($balance, 2);
            } else {
                $json['success'] = false;
                $json['balance'] = "Erişim Yasak";
            }
            break;
		case "adminPing":
			if (session('admin_oturum')) {
				$ping = $db->query("
					SELECT
					(
						SELECT id FROM paracek ORDER BY id DESC LIMIT 1
					) AS paracek_id,
					(
					   SELECT id FROM parayatir ORDER BY id DESC LIMIT 1
					) AS parayatir_id,
                    (
                        SELECT COUNT(id) FROM paracek WHERE durum = 0 || durum = 1
                    ) AS paracek_toplam,
                    (
                    	SELECT COUNT(id) FROM parayatir WHERE durum = 0
                    ) AS parayatir_toplam
				");
				$row = $ping->fetch();

				$json['success'] = true;
				$json['paracek_id'] = (int)$row['paracek_id'];
				$json['parayatir_id'] = (int)$row['parayatir_id'];
				$json['parayatir_toplam'] = (int)$row['parayatir_toplam'];
				$json['paracek_toplam'] = (int)$row['paracek_toplam'];
			}
		break;
        case "adminGiris":
            if (!session('admin_oturum')) {
                $username = p('username');
                $password = p('password');
                $code = p('code');
                //$captcha = p('g-recaptcha-response');

                /*
                if ($code == "code") {
                    if (!$captcha) { $json['error'] = 'Lütfen robot olmadığınızı doğrulayınız.';die(json_encode($json)); }
                    $kontrol = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LesLTsUAAAAAEVVN99_MIBe_jnldJXRqSE9i8Zx&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                    $kontrol = json_decode($kontrol);
                    if (!$kontrol->success) { $json['error'] = 'Lütfen robot olmadığınızı doğrulayınız.';die(json_encode($json)); }
                }*/


                $hash_password = md5($password);

                if (!empty($username) AND !empty($password)) {
                    $adminBul = $db->prepare("
						SELECT * FROM yonetici
						WHERE username = ? AND password = ? AND status = '0'
						LIMIT 1
					");
                    if ( $adminBul->execute(array($username, $hash_password)) )  {
                        if ($adminBul->rowCount() > 0) {
                            $admin = $adminBul->fetchAll(PDO::FETCH_ASSOC);
                            $secretKey = $admin[0]['secret'];

                            if ($code == "code") { $json['code'] = true;die(json_encode($json)); }
                            if (empty($code)) { $json['error'] = 'Lütfen doğrulama kodu bölümünü doldurunuz.';die(json_encode($json)); }
                            if (!ctype_digit($code)) { $json['error'] = 'Doğrulama kodu sayılardan oluşmaladır.';die(json_encode($json)); }
                            if (strlen($code) != 6) { $json['error'] = 'Doğrulama kodu 6 karakterden oluşmalıdır.';die(json_encode($json)); }

                            $ga = new PHPGangsta_GoogleAuthenticator();
                            $checkResult = $ga->verifyCode($secretKey, $code, 2);
                            if (!$checkResult) {
                                $json['error'] = 'Doğrulama kodu geçersiz.';die(json_encode($json));
                            }
                            //Session Verme
                            $adminSession = array();
                            $admin[0]['admin_oturum'] = true;
                            foreach ($admin[0] as $key => $value) {
                                $adminSession[$key] = $value;
                            }
                            session_olustur($adminSession);
                            $json['success'] = true;
                            yLogInsert(['aciklama' => 'Sisteme giriş yaptı']);
                            //Session Verme


                        } else $json['error'] = 'Lütfen bilgileri kontrol ediniz.';
                    }
                } else $json['error'] = 'Lütfen tüm alanları doldurunuz.';
            }
            break;
		case "adminKuponGrafik":
			if (session('admin_oturum')) {
				if (!empty(p('baslangic')) AND !empty(p('bitis'))) {

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
					$kuponGrafik->bindValue(":tarih1",  p('baslangic') );
					$kuponGrafik->bindValue(":tarih2", p('bitis') );
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

					if (!empty($grafikArray)) {

						$json['success'] = true;
						$json['results'] = $grafikArray;

					} else $json['error'] = 'Veri mevcut değil!';

				} else $json['error'] = 'Lütfen tüm alanları doldurunuz.';
			}
		break;
		case "adminKullaniciSayfa":
			if (session('admin_oturum')) {

				$kullanicilar = $db->prepare("
					SELECT * FROM admin
					ORDER BY id DESC
				");
				$kullanicilar->execute();
				$toplamKullanici = $kullanicilar->rowCount();

				$limit = 100;
				$toplam_sayfa = ceil( $toplamKullanici / $limit );

				$kullanicilar = $db->prepare("
					SELECT * FROM admin
					ORDER BY id DESC
					LIMIT ?, ?
				");
				$kullanicilar->bindValue(1, (p('page') * $limit - $limit), PDO::PARAM_INT);
				$kullanicilar->bindValue(2, $limit, PDO::PARAM_INT);

				if ($kullanicilar->execute() === true) {
					if ($kullanicilar->rowCount() > 0) {
						$json['success'] = true;
						$json['list'] = $kullanicilar->fetchAll(PDO::FETCH_ASSOC);
						$json['pages'] = [
							(int)p('page') - 1,
							(int)p('page') + 1
						];
					} else $json['error'] = 'Daha fazla kullanıcı buluanamadı!';
				} else $json['error'] = 'Bir hata meydana geldi!';
			}
		break;
		case "adminKullaniciAra":
			if (session('admin_oturum')) {
				if (strlen(p('kelime')) > 0) {

					$ara = $db->prepare("
						SELECT * FROM admin
						WHERE ".p('sutun')." LIKE ?
					");
					if ($ara->execute(['%' . p('kelime') . '%']) === true) {
						if ($ara->rowCount() > 0) {
							$json['results'] = $ara->fetchAll(PDO::FETCH_ASSOC);
							$json['success'] = true;
						} else $json['error'] = 'Sonuç buluanamadı!';
					}

				} else $json['error'] = 'Lütfen kelime giriniz.';
			}
		break;
		case "adminKullaniciSifreDegistir":
			if (session('admin_oturum')) {
				$id = p('id');
				$sifre = p('password');

				if (!empty($sifre)) {
					$guncelle = $db->prepare("
						UPDATE admin SET password = ?, sifresi = ?  WHERE id = ?
					");
					if ($guncelle->execute([md5($sifre), $sifre, $id]) === true) {
						$json['success'] = true;
                        yLogInsert(['aciklama' => '{'.$id . '} Numaralı Kullanıcının Şifresi Güncellendi.']);
                    } else $json['error'] = 'Bir hata meydana geldi.';
				} else $json['error'] = 'Lütfen boş bırakmayınız.';
			}
		break;
		case "adminPromosSil":
			if ( session('admin_oturum') AND limit_kontrol(3) ) {
				$id = p('id');

				$delete = $db->prepare("DELETE FROM uye_bonuslar WHERE id = ?");
				if ($delete->execute([$id]) === true) {
					$json['success'] = true;
                    yLogInsert(['aciklama' => '{'.$id . '} Numaralı Kullanıcının Bonusunu Sildi.']);
				} else $json['error'] = 'Bir hata meydana geldi.';
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBakiyeGonder":
			if (session('admin_oturum') AND (@p('method') == '1' AND limit_kontrol(7) ) || (@p('method') == '2' AND limit_kontrol(8)) ) {

				$id 		= p('kullanici');
				$bakiye 	= p('bakiye');
				$method		= p('method');
				$aciklama 	= p('aciklama');

				if (!empty($bakiye) AND $id != '0') {

					$mevcutBakiye = $db->prepare("
						SELECT * FROM admin
						WHERE id = ?
					");
					$mevcutBakiye->execute([$id]);
					$mevcutBakiye = $mevcutBakiye->fetchAll()[0]['bakiye'];

					if ($method == '1') {
						// Yatır
						$update = $db->prepare("
							UPDATE admin
							SET bakiye = bakiye + ? WHERE id = ?
						");
					} else {
						// Çek
						$update = $db->prepare("
							UPDATE admin
							SET bakiye = bakiye - ? WHERE id = ?
						");
					}

					if ($update->execute([$bakiye, $id]) === true)
					{
						$json['success'] = true;
						$json['bakiye'] = mf( ( $method == '1' ) ? (int)$mevcutBakiye + $bakiye : (int)$mevcutBakiye - $bakiye );

						// LOG //
						logInsert([
							'userid' => $id,
							'islemad' => $bakiye . ' TL bakiye '.($method == '1' ? 'eklendi.' : 'çıkartıldı.').' (Açıklama: '.$aciklama.')',
							'tutar' => ( $method == '1' ) ? $bakiye : $bakiye * -1,
							'oncekibakiye' => $mevcutBakiye,
							'sonrakibakiye' => ( $method == '1' ) ? (int)$mevcutBakiye + $bakiye : (int)$mevcutBakiye - $bakiye,
						]);

						yLogInsert(['aciklama' => '{'.$id . '} kullanıcısına ' . $bakiye . ' TL '.$darkislem = ($method == 1) ? "Ekledi" : "Çıkarıldı".'.']);

					} else $json['error'] = 'İşlem sırasında bir hata meydana geldi.';

				} else $json['error'] = 'Lütfen tüm alanları doldurunuz.';

			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminKuponGuncelle":
			if (session('admin_oturum') AND ( @p('durum') == '1' AND limit_kontrol(19) ) || ( ( @p('durum') == '2' || @p('durum') == '0' ) AND limit_kontrol(20) ) ) {
				$id = p('id');
				$durum = p('durum');

				if ($durum == "0") {
					$kupon = $db->prepare("
					SELECT * FROM kupon WHERE id = ? AND durum != '331'
				");
				}
				else
				{
					$kupon = $db->prepare("
					SELECT * FROM kupon WHERE id = ? AND durum = '0'
				");
				}

				if ($kupon->execute([$id]) === true) {
					if ($kupon->rowCount() > 0) {
						$kupon = $kupon->fetch();

						if ($kupon['durum'] == 1) {

					if ( $db->query("UPDATE admin SET bakiye = bakiye - ".$kupon['miktar'] * $kupon['oran']." WHERE id = '".$kupon['userid']."'") ) {
									$json['aktarim'] = true;
					}

				}


						$guncelle = $db->prepare("UPDATE kupon SET durum = ? WHERE id = ? ");
						if ($guncelle->execute([$durum, $id]) === true) {
							$json['success'] = true;
							$json['id'] = $id;

							$mevcutBakiye = $db->prepare("
								SELECT * FROM admin
								WHERE id = ?
							");
							$mevcutBakiye->execute([$kupon['userid']]);
							$mevcutBakiye = $mevcutBakiye->fetchAll()[0]['bakiye'];

							if ( $durum == 1 ) {
								// Kazandi.
								if ( $db->query("UPDATE admin SET bakiye = bakiye + ".$kupon['miktar'] * $kupon['oran']." WHERE id = '".$kupon['userid']."'") ) {
									$json['aktarim'] = true;
								}

								logInsert([
									'userid' => $kupon['userid'],
									'islemad' => $kupon['id'] . " nolu kupon kazandı.",
									'tutar' => $kupon['miktar'] * $kupon['oran'],
									'oncekibakiye' => $mevcutBakiye,
									'sonrakibakiye' => $mevcutBakiye + ($kupon['miktar'] * $kupon['oran']),
								]);

							}

							if ( $durum == 1 ) {
								$descriptions = $kupon['id'] . ' numaralı kuponu kazandı olarak güncelledi.';
							} else if ( $durum == 0 ) {
								$descriptions = $kupon['id'] . ' numaralı kuponu beklemede olarak güncelledi.';
							} else if ( $durum == 2 ) {
								$descriptions = $kupon['id'] . ' numaralı kuponu kaybetti olarak güncelledi.';
							}

							yLogInsert([
								'aciklama' => $descriptions
							]);

						} else $json['error'] = 'İşlem sırasında bir hata meydana geldi.';
					}
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminKuponMacGuncelle":
			if ( session('admin_oturum') AND in_array(@p('durum'), [0,1,2]) ) {
				$id 		= p('id');
				$durum 	= p('durum');

				$mac = $db->prepare("SELECT * FROM kupon_mac WHERE id = ?");
				if ( $mac->execute([$id]) ) {
					if ( $mac->rowCount() > 0 ) {
						$guncelle = $db->prepare("UPDATE kupon_mac SET sonuc = ? WHERE id = ?");
						if ($guncelle->execute([$durum, $id])) {
							$json['success'] = true;
							$json['id'] = $id;
						} else $json['error'] = 'Sistem hatasi!';
					}
				} else $json['error'] = 'Sistem hatasi!';
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminKuponIade":
			if (session('admin_oturum') AND limit_kontrol(21) ) {
				$id = p('id');

				$kupon = $db->prepare("
					SELECT k.id AS kuponid, k.*, a.* FROM kupon AS k
					INNER JOIN admin AS a
					ON k.userid = a.id
					WHERE k.id = ?
				");
				if ($kupon->execute([$id]) === true) {
					if ($kupon->rowCount() > 0) {
						$kupon = $kupon->fetch();

						if ($kupon["iptal"] != "1") {
							if ($kupon["iptal"] == 0) {
								$miktari = 0;
								if ($kupon["durum"] == 1) {
									$db->query("UPDATE admin SET bakiye = bakiye - " . ($kupon['miktar'] * $kupon['oran']) . " WHERE id = '".$kupon['userid']."'");
									$miktari = ($kupon["miktar"] * $kupon["oran"]) * -1;
								}

								$db->query("update admin set bakiye = bakiye + ".$kupon['miktar']." where id='".$kupon['userid']."'");
								$db->query("UPDATE kupon SET iptal = 1 WHERE id = '".$kupon['kuponid']."'");
								$db->query("UPDATE kupon SET durum = 3 WHERE id = '".$kupon['kuponid']."'");

								$mevcutBakiye = $kupon['bakiye'];
								$miktari+=$kupon["miktar"];

								$json['success'] = true;
								$json['log'] = true;
								$json['miktar'] = $miktari;

								// LOG
								logInsert([
									'userid' => $kupon['userid'],
									'islemad' => $kupon['kuponid'] . " Nolu Kuponun İptal Bedeli!",
									'tutar' => $miktari,
									'oncekibakiye' => $mevcutBakiye,
									'sonrakibakiye' => $mevcutBakiye + $miktari,
								]);

								yLogInsert([
									'aciklama' => $kupon['kuponid'] . ' numaralı kuponu iade etti.'
								]);

							}
						} else {
							$json['error'] = 'Bu Kupon Daha Önce İade Edilmiştir!';
						}
					} else $json['error'] = 'Geçersiz kupon. (#'.$id.')';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminKuponMacIade":
			if (session('admin_oturum') AND limit_kontrol(21) ) {
				$id = p('id');

				$db->query("UPDATE kupon_mac SET oran = 1, sonuc = 3 WHERE id = '".$id."'");

				$kupon = $db->prepare("SELECT * FROM kupon_mac WHERE id = ?");
				$kupon->execute([p('id')]);
				$kupon = $kupon->fetch();
				$kuponid = $kupon['kuponid'];

				$maclar = $db->query("SELECT * FROM kupon_mac WHERE kuponid = '".$kupon['kuponid']."' ")->fetchAll();
				$oran = "1";
				foreach ($maclar as $kupmac) {
					 $kupmac['oran'];
					$oran = $kupmac['oran'] * $oran;
				}

				$db->query("UPDATE kupon SET oran  = '$oran' WHERE id = '".$kupon['kuponid']."'");
				$json['success'] = true;
				$json['log'] = true;

			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminAutoComplete_uye":
			if (session('admin_oturum')) {
				$kelime = p('kelime');

				$uyeAra = $db->prepare("
					SELECT * FROM admin
					WHERE username LIKE ?
				");
				if ($uyeAra->execute( ['%'.$kelime.'%'] ) === true) {
					$json['success'] = true;
					$json['results'][0] = [
						'id' => 0,
						'name' => 'Tüm Üyeler'
					];
					foreach ($uyeAra->fetchAll(PDO::FETCH_ASSOC) as $uye) {
						$json['results'][] = [
							'id' => $uye['id'],
							'name' => $uye['username'],
							'username' => $uye['username'],
							'bakiye' => $uye['bakiye'],
							'sms' => $uye['sms']
						];
					}
				}
			}
		break;
		case "adminAutoComplete_kupon":
			if (session('admin_oturum')) {
				$kelime = p('kelime');

				$uyeAra = $db->prepare("
					SELECT * FROM kupon
					WHERE id LIKE ?
				");
				if ($uyeAra->execute( ['%'.$kelime.'%'] ) === true) {
					$json['success'] = true;
					$json['results'][0] = [
						'id' => 0,
						'name' => 'Tüm Kuponlar'
					];
					foreach ($uyeAra->fetchAll(PDO::FETCH_ASSOC) as $uye) {
						$json['results'][] = [
							'id' => $uye['id'],
							'name' => $uye['id'],
							'username' => $uye['id'],
							'bakiye' => $uye['id'],
							'sms' => $uye['id']
						];
					}
				}
			}
		break;
		case "adminCanliMacDuzenle":
			if (session('admin_oturum')) {
				$user_id = 0;
				$mac_id = p('id');
				$value = p('value');

				$ids = $db->prepare("SELECT id FROM admin");
				$ids->execute();

				foreach ($ids->fetchAll() as $id) {
					$mac_oran = $db->query("SELECT * FROM mac_oran WHERE macid = '".$mac_id."' AND userid='".$user_id."' ")->fetchAll();
					if (count($mac_oran) > 1) {
						break;
					}
				}

				$mac_oran = $mac_oran[0];

				$veri = [];
				$veri["macid"] = $mac_id;
				$veri["userid"] = $user_id;
				$veri["1"] = $mac_oran[1];
				$veri["2"] = $mac_oran[2];
				$veri["0"] = $mac_oran[0];
				$veri["1a"] = $mac_oran["1a"];
				$veri["2a"] = $mac_oran["2a"];
				$veri["0a"] = $mac_oran["0a"];
				$veri["mbs"] = $mac_oran["mbs"];
				$veri["iptal"] = $value;
				$veri["tarih"] = date("Y-m-d H:i:s");
				$veri["canli"] = $mac_oran["canli"];

				$mac_kontrol = $db->query("select * from mac_oran where  macid='".$mac_id."' and userid='".$user_id."'")->fetchAll();
				if (count($mac_kontrol) > 0) {
					$update = $db->prepare("
						UPDATE mac_oran
						SET `macid` = ?, `userid` = ?, `1` = ?, `2` = ?, `0` = ?, `1a` = ?, `2a` = ?, `0a` = ?, `mbs` = ?, `iptal` = ?, `tarih` = ?, `canli` = ?
						WHERE `id` = ?
					");
					if ( $update->execute([
						$veri['macid'],
						$veri['userid'],
						$veri['1'],
						$veri['2'],
						$veri['0'],
						$veri['1a'],
						$veri['2a'],
						$veri['0a'],
						$veri['mbs'],
						$veri['iptal'],
						$veri['tarih'],
						$veri['canli'],
						$mac_kontrol[0]['id']
					]) ) {
						$json['success'] = true;
					} else $json['error'] = true;
					$json['update'] = true;
				} else {
					$update = $db->prepare("
						INSERT INTO mac_oran
						(macid, userid, 1, 2, 0, 1a, 2a, 0a, mbs, iptal, tarih, canli) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
						WHERE id = ?
					");
					if ( $update->execute([
						$veri['macid'],
						$veri['userid'],
						$veri['1'],
						$veri['2'],
						$veri['0'],
						$veri['1a'],
						$veri['2a'],
						$veri['0a'],
						$veri['mbs'],
						$veri['iptal'],
						$veri['tarih'],
						$veri['canli'],
						$mac_kontrol[0]['id']
					]) ) {
						$json['success'] = true;
					} else $json['error'] = true;
					$json['insert'] = true;
				}


			}
		break;
		case "adminMacGuncelle":
			if (session('admin_oturum') AND limit_kontrol(25) ) {

				$id = $_POST['id'];
				$oran1 = $_POST['1'];
				$oran0 = $_POST['0'];
				$oran2 = $_POST['2'];
				$mbs = "2";

				$oran_kontrol = $db->query("select * from mac_oran where  macid='".$id."'")->fetchAll();
				if ($oran_kontrol[0]['id']) {


					$update = $db->prepare("UPDATE mac_oran SET `1` = ?, `2` = ?, `0` = ?  WHERE macid = ?");

							if ($update->execute([$oran1,$oran2,$oran0,$id]) === true) {
								$json['mac_oran'] = true;
							}

				}

				$json['success'] = true;
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminMacBultenGuncelle":
			if (session('admin_oturum') AND limit_kontrol(23) ) {
				if (is_numeric(p('id'))) {
					$id = p('id');
					$value = p('value');

					$mac = $db->prepare("SELECT * FROM maclar WHERE id = ?");
					if ($mac->execute([$id]) === true) {
						if ($mac->rowCount() > 0) {
							$update = $db->prepare("UPDATE maclar SET iptal = ? WHERE id = ?");

							if ($update->execute([$value, $id]) === true) {
								$json['success'] = true;
							} else $json['error'] = 'Güncellenirken bir hata meydana geldi.';
						}
					} else $json['error'] = 'Bir hata meydana geldi.';
				} else $json['error'] = 'ID gecersiz.';
 			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaYatirimTalepOnayla":
			if ( session('admin_oturum') AND limit_kontrol(27) ) {
				if (is_numeric(p('id'))) {
					$talep = $db->prepare("SELECT A.*, B.bonusadi, B.yuzde, B.cevrim, B.oran, B.durum AS bonus_durum, B.id AS bonus_id FROM `parayatir` AS A INNER JOIN bonuslar AS B ON A.bonus = B.id WHERE A.id = ?");
					if ($talep->execute([p('id')]) === true) {
						if ($talep->rowCount() > 0) {
							$talep = $talep->fetch();
							if ($talep['durum'] == '0') {
								$kullanici = kullanici( $talep['uye'] );

								// bonus
								$bonusu = $talep['miktar'] * $talep['yuzde'] / 100;

								// update
								$db->query("UPDATE admin SET bakiye = bakiye + ".$talep['miktar']." WHERE id='".$talep['uye']."'");
								$db->query("UPDATE parayatir SET durum = '1' WHERE id='".$talep['id']."'");
								logInsert([
									'userid' => $talep['uye'],
									'islemad' => 'Para Yatırma İşlemi',
									'tutar' => $talep['miktar'],
									'oncekibakiye' => $kullanici['bakiye'],
									'sonrakibakiye' => (int)$kullanici['bakiye'] + (int)$talep['miktar'],
								]);

								// bonus update
								$db->query("UPDATE admin SET bakiye = bakiye + ".$bonusu." WHERE id='".$talep['uye']."'");
								logInsert([
									'userid' => $talep['uye'],
									'islemad' => $bonusu . " TL Bonus Yüklendi. (".$talep['bonusadi'].")",
									'tutar' => $bonusu,
									'oncekibakiye' => (int)$kullanici['bakiye'] + (int)$talep['miktar'],
									'sonrakibakiye' => ( (int)$kullanici['bakiye'] + (int)$talep['miktar'] ) + $bonusu
 								]);

								//mysql_query("insert into uye_bonuslar (uye,bonus) values ('$uye','$bonusid')");
								if ($talep['bonus_id'] != '5') {
									$db->query("INSERT INTO uye_bonuslar (uye, bonus) VALUES ('".$kullanici['id']."', '".$talep['bonus_id']."')");
								}

								yLogInsert([
									'aciklama' => $talep['id'] . ' numaralı yatırımı onayladı.'
								]);

								$json['success'] = true;
							} else $json['error'] = 'Daha önceden onaylanmış işlem!';
						} else $json['error'] = 'Geçersiz bir talep.';
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaYatirimTalepSil":
			if (session('admin_oturum') AND limit_kontrol(28)) {
				if (is_numeric(p('id'))) {
					$talep = $db->prepare("SELECT * FROM parayatir WHERE id = ?");
					if ($talep->execute([p('id')]) === true) {
						if ($talep->rowCount() > 0) {
							$talep = $talep->fetch();
							if ($talep['durum'] == '0') {
								$kullanici = kullanici( $talep['uye'] );
								// update
								$db->query("UPDATE parayatir SET durum = '2' WHERE id='".$talep['id']."'");
								$json['success'] = true;

								yLogInsert([
									'aciklama' => $talep['id'] . ' numaralı yatırımı iptal etti.'
								]);

							} else $json['error'] = 'Daha önceden onaylanmış işlem!';
						} else $json['error'] = 'Geçersiz bir talep.';
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaCekimTalepOnayla":
			if (session('admin_oturum') AND limit_kontrol(32)) {
				if (is_numeric(p('id'))) {
					$talep = $db->prepare("SELECT * FROM paracek WHERE id = ?");
					if ($talep->execute([p('id')]) === true) {
						if ($talep->rowCount() > 0) {
							$talep = $talep->fetch();
							if ($talep['durum'] == '1') {
								$kullanici = kullanici( $talep['uye'] );
								// update

								yLogInsert([
									'aciklama' => $talep['id'] . ' numaralı çekimi onayladı.'
								]);

								if ($talep['turu'] == 'TLNAKIT') {

									 $TLNakit = new TLNakit;
									 $tldeposit = $TLNakit->addBalance(['username' => $talep['hesap'],'tutar' => $talep['miktar']]);

									 if (isset($tldeposit->success)) {

									 	$db->query("UPDATE paracek SET durum = '2' WHERE id='".$talep['id']."'");
										$json['success'] = true;
									 }

									else {
									 	$json['error'] = $tldeposit->message;
									 }
								}

								else
								{
									$db->query("UPDATE paracek SET durum = '2' WHERE id='".$talep['id']."'");
									logInsert([
									'userid' => $talep['uye'],
									'islemad' => 'Para Çekme İşleminiz Tamamlandı',
									'tutar' => $talep['miktar'],
									'oncekibakiye' => $kullanici['bakiye'],
									'sonrakibakiye' => (int)$kullanici['bakiye'],
								]);
									$json['success'] = true;
								}




							} else $json['error'] = 'Daha önceden onaylanmış işlem!';
						} else $json['error'] = 'Geçersiz bir talep.';
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaCekimTalepBekleyen":
			if (session('admin_oturum') AND limit_kontrol(35) ) {
				if (is_numeric(p('id'))) {
					$talep = $db->prepare("SELECT * FROM paracek WHERE id = ?");
					if ($talep->execute([p('id')]) === true) {
						if ($talep->rowCount() > 0) {
							$talep = $talep->fetch();
							if ($talep['durum'] == '0') {
								$kullanici = kullanici( $talep['uye'] );
								// update
								
								yLogInsert([
									'aciklama' => $talep['id'] . ' numaralı çekimi beklemeye aldı.'
								]);
								
								$db->query("UPDATE paracek SET durum = '1' WHERE id='".$talep['id']."'");
																	logInsert([
									'userid' => $talep['uye'],
									'islemad' => 'Çekim Talebi İşleme Alındı',
									'tutar' => $talep['miktar'],
									'oncekibakiye' => $kullanici['bakiye'],
									'sonrakibakiye' => $kullanici['bakiye'],
								]);
								$json['success'] = true;
							} else $json['error'] = 'Daha önceden işlem yapılmış!';
						} else $json['error'] = 'Geçersiz bir talep.';
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaCekimTalepSil":
			if (session('admin_oturum') AND limit_kontrol(33)) {
				if (is_numeric(p('id'))) {
					$talep = $db->prepare("SELECT * FROM paracek WHERE id = ?");
					if ($talep->execute([p('id')]) === true) {
						if ($talep->rowCount() > 0) {
							$talep = $talep->fetch();
							if ($talep['durum'] == '0' || $talep['durum'] == '1') {
								$kullanici = kullanici( $talep['uye'] );
								// update
								yLogInsert([
									'aciklama' => $talep['id'] . ' numaralı çekim talebini iptal etti.'
								]);
								$db->query("UPDATE admin SET bakiye = bakiye + ".$talep['miktar']." WHERE id='".$talep['uye']."'");
								$db->query("UPDATE paracek SET durum = '3' WHERE id='".$talep['id']."'");
																	logInsert([
									'userid' => $talep['uye'],
									'islemad' => 'Çekim Talebi İptal Edildi',
									'tutar' => $talep['miktar'],
									'oncekibakiye' => $kullanici['bakiye'],
									'sonrakibakiye' => $kullanici['bakiye']+$talep['miktar'],
								]);								
								$json['success'] = true;
							} else $json['error'] = 'Daha önceden onaylanmış işlem!';
						} else $json['error'] = 'Geçersiz bir talep.';
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak';
		break;
		case "adminBankaCekimTalepNot":
			if (session('admin_oturum')) {
				if (is_numeric(p('id'))) {

					$id = p('id');
					$not = p('not');

					$check = $db->prepare("SELECT * FROM paracek WHERE id = ?");
					if ($check->execute([$id]) === true) {
						if ($check->rowCount() > 0) {
							$update = $db->prepare("UPDATE paracek SET notttttt = ? WHERE id = ?");
							if ($update->execute([$not, $id]) === true) {
								$json['success'] = true;
							} else $json['error'] = 'Bir hata meydana geldi.';
						}
					}

				}
			}
		break;
		case "adminKullaniciTab_FormGuncelle":
			if (session('admin_oturum') AND limit_kontrol(44)) {
				unset($_POST['tip']);

			   $izin = ['name',
                        'tc',
                        'dt',
                        'durum',
                        'email',
                        'telefon',
                        'il',
                        'sms_giris',
                        'oyunlara_giris',
                        'poker',
                        'betongames',
                        'livecasino',
                        'casino',
                        'tombala',
                        'okey',
                        'sports',
                        'deposit',
                        'withdraw',
                        'affiliate',
                        'affiliatepercent',
                        'minkupon',
                        'minoran',
                        'maxkupon',
                        'maxoran',
                        'minmac',
                        'maxmac',
                        'affiliateid',
                        'sportsLimit',
                        'TcOnay'
                 ];

				$sql = 'UPDATE admin SET ';
				foreach ($_POST as $key => $value) {
					if ($key != 'id' AND in_array($key, $izin)) {
						$sql.= $key . ' = :'.$key.',';
					}
				}
				$sql = rtrim($sql, ',');
				$sql .= ' WHERE id = :id';

				$update = $db->prepare($sql);

				foreach ($_POST as $key => $value) {
					$update->bindValue(':' . $key, $value);
				}

				$drkid = p('id');

				if ($update->execute() === true) {
					$json['success'] = true;
					//$json['sql'] = $sql;
                    yLogInsert(['aciklama' => '{'.$drkid. '} Numaralı Kullanıcının Profil Bilgilerini Güncelledi.']);
                } else $json['error'] = true;

			} else $json['error'] = 'Erişim Yasak';
		break;
		case "adminKullaniciTab_LimitEkle":
			if (session('admin_oturum') AND limit_kontrol(42)) {
				$kullanici_id = p('user');
				$izin_id = p('permission');

				$izin = $db->prepare("SELECT * FROM admin_permissions WHERE permission_id = :id");
				$izin->bindValue(":id", $izin_id);
				$izin->execute();

				$drkname =  $izin->fetchAll()[0]['permission_name'];
				if ($izin->rowCount() > 0)
				{
					$ekle = $db->prepare("INSERT INTO admin_role_permissions (user_id, permission_id) VALUES (?,?)");
					if ($ekle->execute([ $kullanici_id, $izin_id ]) === true) {
						$json['success'] = true;
                        yLogInsert(['aciklama' => '{'.$kullanici_id . '} Numaralı Yöneticiye Yeni Yetki Ekledi.( '.$drkname.' )']);
                    } else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminKullaniciTab_LimitSil":
			if (session('admin_oturum')  AND limit_kontrol(43)) {
				$kullanici_id = p('user');
				$izin_id = p('permission');

				$izin = $db->prepare("SELECT * FROM admin_permissions WHERE permission_id = :id");
				$izin->bindValue(":id", $izin_id); $izin->execute();

				if ($izin->rowCount() > 0)
				{
					$ekle = $db->prepare("DELETE FROM admin_role_permissions WHERE user_id = ? AND permission_id = ?");
					if ($ekle->execute([ $kullanici_id, $izin_id ]) === true) {
						$json['success'] = true;
                        yLogInsert(['aciklama' => '{'.$kullanici_id . '} Numaralı Yöneticisinden Yetki Sildi.']);
					} else $json['error'] = 'Bir hata meydana geldi.';
				}
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBonusGonder":
			if (session('admin_oturum') AND limit_kontrol(46)) {
				$kullanici_id = p('id');
				$bonus		  = p('bonus');
				$bakiye		  = p('bakiye');

				$bonusBul = $db->query("SELECT * FROM bonuslar WHERE id = '". $bonus ."'")->fetch();
				$kullanici = kullanici( $kullanici_id );

				if (empty($bakiye)) {
					$json['error'] = 'Lütfen boş alanları doldurunuz.';
				} else {

					// bonus check
					if ($db->query("SELECT * FROM uye_bonuslar WHERE uye = '".$kullanici_id."' AND bonus = '6'")->rowCount() > 0) {
						$json['error'] = 'Bu bonus mevcuttur.';
					} else {

						// bonus
						$bonusu = $bakiye * $bonusBul['yuzde'] / 100;

						## Son Bonus ##
						$sonBonus = $db->query("SELECT uye_bonuslar.*, bonuslar.*, uye_bonuslar.tarih AS uye_bonus_tarih FROM uye_bonuslar INNER JOIN bonuslar ON uye_bonuslar.bonus = bonuslar.id WHERE uye_bonuslar.uye=  '".$kullanici_id."' ORDER BY uye_bonuslar.id DESC LIMIT 0,1")->fetch();
						$yatirdigi = $db->query("select * from parayatir where bonus='".$sonBonus['id']."' and uye='".$kullanici_id."' order by id DESC LIMIT 0,1")->fetch();
						$yatanpara = $yatirdigi["miktar"];

						$aldigibonusu = $yatanpara*$sonBonus['yuzde']/100*$sonBonus['cevrim'];

						$oynadiklari = $db->query("SELECT SUM(miktar) FROM kupon where oran > '".$sonBonus['oran']."' and tarih > '".$sonBonus['uye_bonus_tarih']."' and userid='".$kullanici_id."' and iptal ='0'")->fetch();
						$oynanan = $oynadiklari['SUM(miktar)'];
						$sukadaroyun = $aldigibonusu-$oynanan;

						if($aldigibonusu > $oynanan) {
							$json['error'] = 'Bonus çevrimi tamamlanmadıgı için bonus ekleyemezsiniz.';
						} else {
							//$db->query("UPDATE admin SET bakiye = bakiye + ".$bakiye." WHERE id='".$kullanici_id."'");
							$db->query("UPDATE admin SET bakiye = bakiye + ".$bonusu." WHERE id='".$kullanici_id."'");

							logInsert([
								'userid' => $kullanici_id,
								'islemad' => $bonusu . " TL Bonus Yüklendi. (".$bonusBul['bonusadi'].")",
								'tutar' => $bonusu,
								'oncekibakiye' => (int)$kullanici['bakiye'],
								'sonrakibakiye' =>(int)$kullanici['bakiye'] + $bonusu
							]);

                            yLogInsert(['aciklama' => '{'.$kullanici_id . '} kullanıcısına ' . $bonusu . ' TL bonus ekledi. ('.$bonusBul['bonusadi'].')']);

                            if ($bonus != '5') {
								$db->query("INSERT INTO uye_bonuslar (uye, bonus) VALUES ('".$kullanici['id']."', '".$bonus."')");
							}

							$json['success'] = true;
						}

					}

				}

				//// bonus
				//$bonusu = $talep['miktar'] * $talep['yuzde'] / 100;
				$json[] = $_POST;
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBannerUpload":
			if ( session('admin_oturum') )
			{
				$banner = $_FILES['banner'];
				$path 	= realpath( dirname(__FILE__).'/../..' ) . '/uploads/banners/';

				$mimeTypes = ["image/gif","image/png","image/jpeg","image/pjpeg"];
				$Extenstions = ['jpg', 'png', 'gif', 'jpeg'];
				$fileEx = pathinfo($banner['name'], PATHINFO_EXTENSION);

				if (in_array($banner["type"], $mimeTypes) AND in_array( $fileEx, $Extenstions )) {
					$name = uniqid('banner_');
					if ( move_uploaded_file($banner["tmp_name"], $path . $name . '.' . $fileEx) ) {

						preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $getDomain);

						$domain = explode(".", $_SERVER["HTTP_HOST"]);
					$newbeturl = $domain[1].".".$domain[2];

						$json['success'] = true;
						$json['url'] = 'http://www.'.$newbeturl.'/uploads/banners/' . $name . '.' . $fileEx;
						$urx = '/uploads/banners/' . $name . '.' . $fileEx;
						$db->query("INSERT INTO bannerlar (url,`index`) VALUES ('".$urx."', '1')");

					} else $json['error'] = 'Resim yuklenirken bir hata meydana geldi!';
				} else $json['error'] = 'Lutfen belirlenen formatlarda yukleme yapiniz. ' . json_encode($Extenstions);
			} else $json['error'] = 'Bir hata meydana geldi.';
		break;
		case "adminBannerGuncelle":
			if ( session('admin_oturum') ) {
				unset( $_POST['tip'] );

				foreach ( $_POST as $id => $index ) {
					$db->query("UPDATE bannerlar SET `index` = '".$index."' WHERE id = '".$id."'");
				}

				$json['success'] = true;

			}
		break;
		case "adminBannerGizle":
			if ( session('admin_oturum') ) {
				$db->query("UPDATE bannerlar SET `index` = 0 WHERE id = '".p('id')."'");
			}
		break;
		case "adminBannerSil":
			if ( session('admin_oturum') ) {
				$db->query("DELETE FROM bannerlar WHERE id = '".p('id')."'");
				$json['success'] = true;
			}
		break;
		case "adminYoneticiEkle":
			if ( session('admin_oturum') AND limit_kontrol(47) ) {

				if ( empty(p('username')) || empty(p('password')) || empty(p('name')) ) {
					$json['error'] = 'Lütfen tüm alanları doldurunuz.';
				} else {
					$check = $db->query("SELECT * FROM yonetici WHERE username = '".p('username')."'");
					if ( !isset($check->fetch()['id']) ) {
						$insert = $db->query("INSERT INTO yonetici (username,password,sifre,status,name) VALUES ('".p('username')."', '".md5(p('password'))."', '".p('password')."', '0', '".p('name')."')");

						$json['success'] = true;
						$json['user_id'] = (int) $db->lastInsertId();
						$json['name'] = p('name');
						$json['username'] = p('username');

						yLogInsert([
							'aciklama' => p('name'). ', adlı yeni yönetici ekledi.'
						]);

					} else $json['error'] = 'Bu kullanıcı sistemde mevcut!';
				}

			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminYoneticiSil":
			// $json['error'] = 'Erişim Yasak!';
			if ( session('admin_oturum') AND limit_kontrol(48) ) {
				if ( !empty(p('id')) ) {
					$check = $db->query("SELECT * FROM yonetici WHERE id = '".p('id')."'");
					if ( isset($check->fetch()['id']) ) {
						$delete = $db->query("UPDATE yonetici SET status = '1' WHERE id = '".p('id')."'");

						$json['success'] = true;
						$json['user_id'] = p('id');

						yLogInsert([
							'aciklama' => p('id'). ', yöneticiyi sildi.'
						]);

					} else $json['error'] = 'Bu kullanıcı sistemde mevcut değil!';
				}
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminYonetimSifreGuncelle":
			if ( session('admin_oturum') ) {
				if ( !empty(p('password')) ) {
					$check = $db->query("SELECT * FROM yonetici WHERE id = '".p('id')."'");
					$user_id = @$check->fetch()['id'];
					if ( isset($user_id) ) {

						if ( limit_kontrol(59) ) {
							$update = $db->query("UPDATE yonetici SET password = '".md5(p('password'))."', sifre = '".p('password')."' WHERE id = '".p('id')."'");
							$json['success'] = true;

							yLogInsert([
								'aciklama' => p('id'). ', yöneticinin şifresini güncelledi.'
							]);

						} else {
							if ( $user_id == session('id') ) {
								$update = $db->query("UPDATE yonetici SET password = '".md5(p('password'))."', sifre = '".p('password')."' WHERE id = '".session('id')."'");
								$json['success'] = true;

								yLogInsert([
									'aciklama' => p('id'). ', yöneticinin şifresini güncelledi.'
								]);

							} else $json['error'] = 'Yetki eksik, lütfen üst yönetici ile görüşün.';
						}

					} else $json['error'] = 'Kullanıcı mevcut değil.';
				} else $json['error'] = 'Lütfen boş alan bırakmayınız.';
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminBonusSil":
			if ( session('admin_oturum') AND limit_kontrol(65) ) {
				$check = $db->query("SELECT * FROM bonuslar WHERE id = '".p('id')."'");
				if ( isset($check->fetch()['id']) ) {
					$db->query("DELETE FROM bonuslar WHERE id = '".p('id')."'");
					$json['success'] = true;
				} else $json['error'] = 'Geçersiz bonus.';
			} else $json['error'] = 'Erişim yasak!';
		break;
        case "adminDomainGuncelle":
            if ( session('admin_oturum') AND limit_kontrol(84) ) {
                    $db->query("UPDATE domain SET status = '0' ");
                    $db->query("UPDATE domain SET status = '1' WHERE id = '".p('id')."'");
                    $json['success'] = true;
                yLogInsert(['aciklama' => 'Domain Güncelleme İşlemi Başlattı.']);

            } else $json['error'] = 'Erişim yasak!';
        break;
        case "adminSiteSettings":
            if ( session('admin_oturum') AND limit_kontrol(99) ) {
                    $db->query("UPDATE odd_services SET active = '0' ");
                    $db->query("UPDATE odd_services SET active = '1' WHERE id = '".p('bot')."'");
                    $json['success'] = true;
                yLogInsert(['aciklama' => 'Canlı Oran Servisini Değiştirdi.']);

            } else $json['error'] = 'Erişim yasak!';
        break;
        case "adminSettings":
            if ( session('admin_oturum') AND limit_kontrol(99) ) {
                    $name = p('bet');

                    $live_odds_type = p('live_odds_type');
                    $live_odds = p('live_odds');
                    $live_odds = "[\"$live_odds_type\",$live_odds]";
                    $update_live_odds = $db->prepare("UPDATE settings SET `value` = ? WHERE `key` = 'live_odds' ");
                    $update_live_odds->execute([$live_odds]);

                    $pre_odds_type = p('pre_odds_type');
                    $pre_odds = p('pre_odds');
                    $pre_odds = "[\"$pre_odds_type\",$pre_odds]";
                    $update_pre_odds = $db->prepare("UPDATE settings SET `value` = ? WHERE `key` = 'pre_odds' ");
                    $update_pre_odds->execute([$pre_odds]);


                    $db->query("UPDATE settings SET `value` = $name WHERE `key` = 'bet' ");
                    $json['success'] = true;
                yLogInsert(['aciklama' => 'Oran Değiştirme işlemi Başarıyla Tamamlandı.']);

            } else $json['error'] = 'Erişim yasak!';
        break;
		case "adminBonusEkle":
			if ( session('admin_oturum') AND limit_kontrol(64) ) {

				if ( !empty(p('baslik')) AND !empty(p('yuzde')) ) {
					if ( is_numeric(p('yuzde')) ) {
						$db->query("INSERT INTO bonuslar (bonusadi, yuzde, cevrim, durum, oran) VALUES ('".p('baslik')."', '".p('yuzde')."', '11', '1', '2')");

						$json['success'] = true;
						$json['id'] = $db->lastInsertId();
					} else $json['error'] = 'Lütfen yüzde olarak sayı giriniz.';
				} else $json['error'] = 'Boş alan bırakmayınız.';

			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminBankaHesabiGuncelle":
			if ( session('admin_oturum') AND limit_kontrol(71) ) {

				$id = p('id');

				$update = $db->prepare("
					UPDATE
						sitebanka
					SET adsoyad = :adsoyad,
						sube = :sube,
						hesap = :hesap,
						iban = :iban,
						durum = :durum,
						deposit = :deposit,
						withdraw = :withdraw,
						mobiletransfer = :mobiletransfer
					WHERE id = :id
				");

				$update->bindValue(":adsoyad", p('adsoyad'));
				$update->bindValue(":sube", p('sube'));
				$update->bindValue(":hesap", p('hesap'));
				$update->bindValue(":iban", p('iban'));
				$update->bindValue(":durum", p('durum'));
				$update->bindValue(":deposit", p('deposit'));
				$update->bindValue(":withdraw", p('withdraw'));
				$update->bindValue(":mobiletransfer", p('mobiletransfer'));
				$update->bindValue(":id", $id);

				if ( $update->execute() === true  ) {
					$json['success'] = true;
					$json['bank_id'] = $id;
					$json['user_id'] = session('id');

                    yLogInsert(['aciklama' => '{'.$id . '} Numaralı Banka Hesabını Güncelledi.']);

                } else $json['error'] = 'Bir hata meydana geldi.';

			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaHesabiEkle":
			if ( session('admin_oturum') AND limit_kontrol(69) )
			{
				$adsoyad = p('adsoyad');
				$banka = p('banka');
				$sube = p('sube');
				$hesap = p('hesap');
				$iban = p('iban');
				$durum = p('durum');
				$deposit = p('deposit');
				$withdraw = p('withdraw');
				$mobiletransfer = p('mobiletransfer');

				if (empty($adsoyad)) {
					$json['error'] = 'Ad - Soyad bos bırakmayınız.';
				} else if ( empty($banka) ) {
					$json['error'] = 'Banka adını boş bırakmayınız.';
				} else {

					$add = $db->prepare("
						INSERT INTO sitebanka
						(
							adsoyad, banka, sube, hesap, iban, durum, deposit, withdraw, mobiletransfer
						) VALUES (
							?, ?, ?, ? , ? , ? , ? , ? , ?
						)
					");

					if ( $add->execute([
						$adsoyad, $banka, $sube, $hesap, $iban, $durum, $deposit, $withdraw, $mobiletransfer
					]) === true ) {
						$json['success'] = true;
						$json['bank_id'] = $db->lastInsertId();
                        yLogInsert(['aciklama' => '{'.$banka . '} Banka Hesabını Ekledi.']);

                    } else $json['êrror'] = 'Bir hata meydana geldi.';

				}

			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminBankaHesabiSil":
			if ( session('admin_oturum') AND limit_kontrol(70) ) {
				$id = p('id');
				if (!empty($id)) {
					$banka = $db->query("SELECT * FROM sitebanka WHERE id = '".$id."'");
					if ( $banka->rowCount() > 0 ) {
						$delete = $db->query("DELETE FROM sitebanka WHERE id = '".$id."'");
						$json['success'] = true;
                        yLogInsert(['aciklama' => '{'.$id . '} Numaralı Banka Hesabını Sildi.']);

                    } else $json['error'] = 'Bir hata meydana geldi.';
				} else $json['error'] = 'Bir hata meydana geldi.';
			} else $json['error'] = 'Erişim Yasak!';
		break;
		case "adminKullaniciBanEkle":
			if ( session('admin_oturum') AND limit_kontrol(73) ) {
				$id = p('id');
				$not = p('not');
				$tarih = date('Y-m-d H:i:s');
				if (!empty($id) || !empty($not)) {
					$uye = $db->query("SELECT * FROM admin WHERE id = '".$id."'")->fetch();
					if ( isset($uye['id']) AND $uye['durum'] != 1 ) {
						$ekle = $db->prepare("
							INSERT INTO admin_bans (
								`yonetici_id`, `kullanici_id`, `not`, `tarih`
							) VALUES (?,?,?,?)
						");
						if ( $ekle->execute([session('id'), $id, $not, $tarih]) === true ) {
							$json['success'] = true;
							$json['ban_id'] = $db->lastInsertId();
							$json['date'] = $tarih;
							$json['user'] = [
								'username' => $uye['username']
							];
							$json['admin'] = [
								'username' => session('username')
							];
						} else $json['error'] = 'Sistemde bir hata meydana geldi!';
					} else $json['error'] = 'Kullanıcı durumu şu an aktif, lütfen pasif hale getiriniz.';
				} else $json['error'] = 'Bir boş alan bırakmayınız!';
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminPromotionUpload":
			if ( session('admin_oturum') AND limit_kontrol(75) ) {
				$promotion = $_FILES['promotion'];
				$path 	= realpath( dirname(__FILE__).'/../..' ) . '/uploads/promotions/';

				$mimeTypes = ["image/gif","image/png","image/jpeg","image/pjpeg"];
				$Extenstions = ['jpg', 'png', 'gif', 'jpeg'];
				$fileEx = pathinfo($promotion['name'], PATHINFO_EXTENSION);

				if (in_array($promotion["type"], $mimeTypes) AND in_array( $fileEx, $Extenstions )) {
					$name = uniqid('banner_');
					if ( move_uploaded_file($promotion["tmp_name"], $path . $name . '.' . $fileEx) ) {

						preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $getDomain);

						$domain = explode(".", $_SERVER["HTTP_HOST"]);
						$newbeturl = $domain[1].".".$domain[2];

						$json['success'] = true;
						$json['url'] = 'http://www.'.$newbeturl.'/uploads/promotions/' . $name . '.' . $fileEx;
						$urx = '/uploads/promotions/' . $name . '.' . $fileEx;

						$db->query("
							INSERT INTO promosyonlar (durum, resim, sira) VALUES ('1', '".$urx."', '1')
						");


						$json['promotion_id'] = $db->lastInsertId();

					} else $json['error'] = 'Resim yuklenirken bir hata meydana geldi!';
				} else $json['error'] = 'Lutfen belirlenen formatlarda yukleme yapiniz. ' . json_encode($Extenstions);
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminPromosyonGuncelle":
			if ( session('admin_oturum') AND limit_kontrol(77) ) {
				$id = p('id');
				$baslik = p('baslik');
				$icerik = p('icerik');

				if ( !empty($baslik) AND !empty($icerik) ) {

					$seourl = sef_link($baslik);

					$update = $db->prepare("UPDATE promosyonlar SET baslik = ?, icerik = ?, seourl = ? WHERE id = '".$id."'");
					$update->execute([
						$baslik, $icerik, $seourl
					]);
					$json['success'] = $update;
				} else $json['error'] = 'Boş alan bırakmayınız!';
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminPromosyonIndexGuncelle":
			if ( session('admin_oturum') ) {
				unset( $_POST['tip'] );

				foreach ( $_POST as $id => $index ) {
					$db->query("UPDATE promosyonlar SET `sira` = '".$index."' WHERE id = '".$id."'");
				}

				$json['success'] = true;
			}
		break;
		case "adminPromosyonPencere":
			if ( session('admin_oturum') ) {
				$id = p('id');

				$promosyon = $db->query("SELECT * FROM promosyonlar WHERE id = '".$id."'");
				if ($promosyon->rowCount() > 0) {
					$promosyon = $promosyon->fetch();
					$json['success'] = true;
					$json['promotion'] = [
						'id' => p('id'),
						'title' => $promosyon['baslik'],
						'content' => $promosyon['icerik'],
						'url' => $promosyon['seourl']
					];
				} else $json['error'] = 'Bir hata meydana geldi!';
			}
		break;
		case "adminPromosyonGizle":
			if ( session('admin_oturum') ) {
				$db->query("UPDATE promosyonlar SET `sira` = 0 WHERE id = '".p('id')."'");
			}
		break;
		case "adminPromosyonSil":
			if ( session('admin_oturum') AND limit_kontrol(76)) {
				$id = p('id');
				$promosyon = $db->query("SELECT * FROM promosyonlar WHERE id = '".$id."'");
				if ( $promosyon->rowCount() > 0 ) {
					$db->query("DELETE FROM promosyonlar WHERE id = '".$id."'");
					$json['success'] = true;
				}
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminDuyuruEkle":
			if ( session('admin_oturum') AND limit_kontrol(81) ) {
				$icerik = p('icerik');
				$aktif = p('aktif');

				if ( empty($icerik) ) {
					$json['error'] = 'Lütfen boş alan bırakmayınız.';
				} else {
					if ($aktif == 1) {
						$db->query("UPDATE duyuru SET aktif = 0");
					}

					$ekle = $db->prepare("INSERT INTO duyuru (aktif, icerik, userid) VALUES (?,?,?)");
					if ( $ekle->execute([$aktif,$icerik,session('id')]) === true) {
						$id = $db->lastInsertId();
						$json['success'] = true;
						$json['id'] = $id;
						$json['html'] = '<tr><td>'.$id.'</td><td>'.$icerik.'</td><td><select name="aktif" id="aktif" class="form-control duyuruDuzenle"><option data-id="'.$id.'" value="1" '. ( ($aktif == 1) ? 'selected' : null ).'>Aktif</option><option data-id="'.$id.'" value="0" '. ( ($aktif == 0) ? 'selected' : null ).'>Pasif</option></select></td><td><button class="btn btn-danger btn-xs admin-action" data-action="adminDuyuruSil" data-id="'.$id.'"><i class="fa fa-remove"></i></button></td></tr>';
					} else $json['error'] = 'Sistemde hata meydana geldi.';
				}
			}  else $json['error'] = 'Erişim yasak!';
		break;
		case "adminDuyuruSil":
			if ( session('admin_oturum') AND limit_kontrol(82) ) {
				$id = p('id');

				if ($id) {
					$db->query("DELETE FROM duyuru WHERE id = '".$id."'");
					$json['success'] = true;
				} else $json['error'] = 'Bir hata meydana geldi.';
			} else $json['error'] = 'Erişim yasak!';
		break;
		case "adminDuyuruAktifDuzenle":
			if ( session('admin_oturum') ) {
				$id = p('id');
				$aktif = p('aktif');

				if ($id) {
					if ($aktif == 1) { $db->query("UPDATE duyuru SET aktif = 0"); }
					$db->query("UPDATE duyuru SET `aktif` = '".$aktif."' WHERE id = '".$id."'");
					$json['success'] = true;
				}
			}
		break;
		case "ulkeListele":
			sleep(2);
			if ( session('admin_oturum') ) {
				$id = p ('id');

				if ($id || $id == 0) {
					$json['success'] = true;
					$json['data'] = $db->query("SELECT * FROM dark_country WHERE sportid = '".$id."' ORDER BY listindex ASC")->fetchAll();
				} else $json['error'] = true;

			}
		break;
		case "ligListele":
			sleep(2);
			if ( session('admin_oturum') ) {
				$id = p ('id');

				if ($id || $id == 0) {
					$json['success'] = true;
					$json['data'] = $db->query("SELECT * FROM dark_leagues WHERE countryid = '".$id."' ORDER BY listindex ASC")->fetchAll();
				} else $json['error'] = true;

			}
		break;
		case "adminSporIndexGuncelle":
			if ( session('admin_oturum') AND limit_kontrol(83) ) {
				unset( $_POST['tip'] );

				foreach ( $_POST as $id => $index ) {
					$db->query("UPDATE `dark_sports` SET `listindex`= '".$index."' WHERE sportid = '".$id."'");
				}

				$json['success'] = true;
			} else $json['error'] = 'Yetkiniz bulunmamaktadir.';
		break;
		case "adminUlkeIndexGuncelle":
			if ( session('admin_oturum') AND limit_kontrol(83) ) {
				unset( $_POST['tip'] );

				foreach ( $_POST as $id => $index ) {
					$db->query("UPDATE `dark_country` SET `listindex`= '".$index."' WHERE countryid = '".$id."'");
				}

				$json['success'] = true;
			} else $json['error'] = 'Yetkiniz bulunmamaktadir.';
		break;
		case "adminLigIndexGuncelle":
			if ( session('admin_oturum') AND limit_kontrol(83) ) {
				unset( $_POST['tip'] );

				foreach ( $_POST as $id => $index ) {
					$db->query("UPDATE `dark_leagues` SET `listindex`= '".$index."' WHERE leaguesid = '".$id."'");
				}

				$json['success'] = true;
			} else $json['error'] = 'Yetkiniz bulunmamaktadir.';
		break;
		case "adminPopulerLig":
			if ( session('admin_oturum') AND limit_kontrol(83) ) {
				$id = p('id');
				$type = p('type');
				$lig = $db->query("SELECT * FROM dark_leagues WHERE id = '".$id."'");

				if ( $lig->rowCount() > 0 ) {
					if ( $type == 'add' ) {
						$db->query("UPDATE dark_leagues SET popular = 1 WHERE id = '".$id."'");
						$json['popular'] = 1;
					} else {
						$db->query("UPDATE dark_leagues SET popular = 0 WHERE id = '".$id."'");
						$json['popular'] = 0;
					}
					$json['success'] = true;
				}
			} else $json['error'] = 'Yetkiniz bulunmamaktadir.';
		break;
		case "ipUsers":
			sleep(2);
			if ( session('admin_oturum') AND limit_kontrol(37) ) {

				$baslangic = strtotime($_POST['date'][0]);
				$bitis     = strtotime($_POST['date'][1]);

				$kullanicilar = $db->query("
					SELECT ip,login_time, GROUP_CONCAT(DISTINCT admin_id)
						FROM admin_session
						WHERE login_time BETWEEN $baslangic AND $bitis
						GROUP BY ip
					HAVING COUNT(DISTINCT admin_id) > 1
					ORDER BY COUNT(DISTINCT admin_id) DESC
				")->fetchAll();

				$list = [];
				foreach ( $kullanicilar as $kullanici )
				{
					$kullaniciRow = explode(',', $kullanici[2]);
					foreach ($kullaniciRow as $id) {
						$list[$kullanici['ip']][] = $db->query("SELECT id,username FROM admin WHERE id = '".$id."'")->fetch();
					}
				}
				$json['success'] = true;
				$json['list'] = $list;
			}
		break;

        case "adminSportActive":
            if (session('admin_oturum') AND limit_kontrol(100) ) {
                $id = p('id');
                $status = p('durum');
                $name = p('name');

                if ($name == "sport") {
                    $table = "dark_sports";
                } elseif ($name == "country") {
                    $table = "dark_country";
                } elseif ($name == "leagues") {
                    $table = "dark_leagues";
                } else {
                    $json['success'] = false;
                    $json['error'] = "Geçersiz Parametre girdiniz.";
                    echo json_encode( $json );
                    die();
                }

                $guncelle = $db->prepare("UPDATE $table SET status = ? WHERE id = ?");

                if ($guncelle->execute([$status, $id]) === true) {
                    $json['success'] = true;
                }

            }  else $json['error'] = 'Yetkiniz bulunmamaktadir.';
        break;

        case "adminSportLimit":
            if (session('admin_oturum') AND limit_kontrol(100) ) {
                $id = p('id');
                $amount = p('amount');
                $name = p('name');

                if ($name == "sport") {
                    $table = "dark_sports";
                } elseif ($name == "country") {
                    $table = "dark_country";
                } elseif ($name == "leagues") {
                    $table = "dark_leagues";
                } else {
                    $json['success'] = false;
                    $json['error'] = "Geçersiz Parametre girdiniz.";
                    echo json_encode( $json );
                    die();
                }

                $guncelle = $db->prepare("UPDATE $table SET coupon_limit = ? WHERE id = ?");

                if ($guncelle->execute([$amount, $id]) === true) {
                    $json['success'] = true;
                }

            }  else $json['error'] = 'Yetkiniz bulunmamaktadir.';
        break;

        case "cacheClear":
            if (session('admin_oturum') AND limit_kontrol(101) ) {
                sleep(5);
                $redis = new Redis();
                $redis->connect('127.0.0.1', 6379);
                $redis->auth(REDIS_PASSWORD);

                $items = ['promotions','casinobanners','casinogames','slotbanners','slotgames','homepagebanners','notice'];

                foreach ($items as $item) {
                    $redis->del(REDIS_KEY.'_'.$item);
                    $json['success'] = true;
                }
                $redis->close();

                yLogInsert(['aciklama' => 'Önbellek Temizlendi.']);


            }  else $json['error'] = 'Yetkiniz bulunmamaktadir.';
            break;
	}

	echo json_encode( $json );
