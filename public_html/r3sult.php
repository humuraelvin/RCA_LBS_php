<?php

$data = json_decode(file_get_contents("php://input"), true);

$response = [];

$mysqli = new mysqli('localhost', 'atab_atabet', 'EDC0301cde*', 'atab_atabet');

if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

foreach ($data as $item) {
    $coupon_id = $item['id'];
    $eventid = $item['match_id'];
    $sonuc = 0; // Başlangıç değeri
    $sport_id = $item['sport_id'];

    // Önce veritabanından radarid kontrol ettir
    $query = $mysqli->prepare("SELECT radarid FROM maclar WHERE mackodu = ?");
    $query->bind_param('s', $eventid); // 's' demek string anlamına gelir
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    if (isset($row['radarid']) && !empty($row['radarid']) && $row['radarid'] != '0') {

        $radarid = $row['radarid'];
        //print_r($radarid . "<br>");
    } else {
        $siteContent = @file_get_contents("https://eu-offering-api.kambicdn.com/offering/v2018/ub/statistics/event/" . $eventid . ".json?externalEventProvider=EP_BETRADAR");
        if ($siteContent === false) {
            $response[$coupon_id] = ["error" => "Cannot fetch BetRadar data for Event ID: " . $eventid];
            continue;
        }
        $site = json_decode($siteContent, true);
        if (empty($site['eventMapping'][0]['externalId'])) {
            $response[$coupon_id] = ["error" => "Invalid BetRadar ID for Event ID: " . $eventid];
            continue;
        }
        $radarid = $site['eventMapping'][0]['externalId'];
        // radarid'yi veritabanına güncelle
        $update = $mysqli->prepare("UPDATE maclar SET radarid = ? WHERE mackodu = ?");
        $update->bind_param('ss', $radarid, $eventid);
        $update->execute();
    }

    //$radarid = "43044201";
    $radarContent = @file_get_contents("https://lmt.fn.sportradar.com/demolmt/en/Etc:UTC/gismo/match_timelinedelta/" . $radarid);

    if ($radarContent === false) {
        $response[$coupon_id] = [
            "error" => "Cannot fetch radar data for Radar ID: " . $radarid
        ];
        continue;
    }

    $radarsite = json_decode($radarContent);

//    var_dump($radarsite);

    $othome = isset($radarsite->doc[0]->data->match->periods->ot->home) ? $radarsite->doc[0]->data->match->periods->ot->home : null;
    $otaway = isset($radarsite->doc[0]->data->match->periods->ot->away) ? $radarsite->doc[0]->data->match->periods->ot->away : null;

    $fthome = $radarsite->doc[0]->data->match->periods->ft->home;
    $ftaway = $radarsite->doc[0]->data->match->periods->ft->away;

    $periodValues = [];

    $macdurum = $radarsite->doc[0]->data->match->matchstatus;
    $periodsayisi = $radarsite->doc[0]->data->match->numberofperiods;
    $mevcutperiod = $radarsite->doc[0]->data->match->p;
//    $ilkyari = $periodsayisi / 2;
    $bahis = $item['description']; 
    $secim = $item['type']; 
    for ($i = 1; $i < $periodsayisi; $i++) {
        ${"p" . $i . "home"} = $radarsite->doc[0]->data->match->periods->{"p" . $i}->home;
        ${"p" . $i . "away"} = $radarsite->doc[0]->data->match->periods->{"p" . $i}->away;

        if ($periodsayisi == 2) {
            $periodValues['ilkyarihome'] = ${"p" . $i . "home"};
            $periodValues['ilkyariaway'] = ${"p" . $i . "away"};
        } elseif ($periodsayisi == 4) {
            $periodValues['ilkceyrek' . $i] = ${"p" . $i . "home"};
            $periodValues['ilkceyrekp' . $i . 'home'] = ${"p" . $i . "home"};
            $periodValues['ilkceyrekp' . $i . 'away'] = ${"p" . $i . "away"};
        }
    }

    if ($periodsayisi == 4) {
        $periodValues['ilkyarihome'] = $periodValues['ilkceyrekp1home'] + $periodValues['ilkceyrekp2home'];
        $periodValues['ilkyariaway'] = $periodValues['ilkceyrekp1away'] + $periodValues['ilkceyrekp2away'];
    }


    $sonuc = 0; // Başlangıçta sonucu belirsiz olarak ayarlıyoruz.


    //Maç Sonucu Sonuçlar Başla
    $tur = $secim;
    $grup = $bahis;
    $ft_ev = $radarsite->doc[0]->data->match->result->home;
    $ft_konuk = $radarsite->doc[0]->data->match->result->away;

    $toplamgolev = $fthome;  // başlangıçta ft değerine eşit olacak
    $toplamgolkonuk = $ftaway; // başlangıçta ft değerine eşit olacak
    $toplam_1ceyrek = $ilkceyrekhome + $ilkceyrekaway;


    // Eğer othome ve otaway değerleri mevcutsa (yani null değilse) toplam değerlere eklenir.
    if($othome !== null) {
        $toplamgolev += $othome;
    }
    if($otaway !== null) {
        $toplamgolkonuk += $otaway;
    }

    $toplamgoller = $toplamgolev + $toplamgolkonuk;

    $skor = $toplamgolev . "-" . $toplamgolkonuk;


    $ikinciyari_gol_evsahibi = $toplamgolev - $periodValues['ilkyarihome'];
    $ikinciyari_gol_misafir = $toplamgolkonuk - $periodValues['ilkyariaway'];
    $ikinciyari_toplam_gol = $ikinciyari_gol_evsahibi + $ikinciyari_gol_misafir;
    $toplam_1yari = $periodValues['ilkyarihome'] + $periodValues['ilkyariaway'];


    if (strpos($grup, 'Toplam Gol - 2. Yarı') !== false && $macdurum == "result") {
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
    
        $limit = (float) $matches[1]; // Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
    
        if ($secimim == "Üst") {
            if ($ikinciyari_toplam_gol > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($ikinciyari_toplam_gol < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }


    if ($grup == "Total Points Tek/Çift - Including Overtime" && $macdurum == "result") {
        if ($toplamgoller % 2 == 0) { // Gol sayısı çift
            if ($secim == "Çift") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } else { // Gol sayısı tek
            if ($secim == "Tek") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }

    if (strpos($grup, 'Uzatmalar Dahil Toplam Puan/Sayı/Gol') !== false && $macdurum == "result") {
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
        
        $limit = (float) $matches[1]; // Puan/Sayı/Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
        
        if ($secimim == "Üst") {
            if ($toplamgoller > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($toplamgoller < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }
    
    

    if ($grup == "1X2" && $macdurum == "result") {
        if ($tur == "1" && $ft_ev > $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } elseif ($tur == "2" && $ft_ev < $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } elseif ($tur == "X" && $ft_ev == $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2;
            $mesaj = "Kaybetti";
        }
    }
    

    if ($grup == "Tam Zaman" && $macdurum == "result") {
        if ($tur == "1" && $ft_ev > $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } elseif ($tur == "2" && $ft_ev < $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } elseif ($tur == "X" && $ft_ev == $ft_konuk) {
            $sonuc = 1;
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2;
            $mesaj = "Kaybetti";
        }
    }

    if ($grup == "Toplam Goller Tek/Çift"  && $macdurum == "result") {
        if ($toplamgoller % 2 == 0) {
            // Goller çift sayıda
            if ($secim == "Çift") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } else {
            // Goller tek sayıda
            if ($secim == "Tek") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }

    if (strpos($grup, 'Toplam Goller') !== false && $macdurum == "result") { 
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $tur, $matches);
    
        $limit = (float) $matches[1]; // Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
    
        if ($secimim == "Üst") {
            if ($toplamgoller > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($toplamgoller < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }


    if (strpos($grup, 'Total Games') !== false && $macdurum == "result") { 
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $tur, $matches);
    
        $limit = (float) $matches[1]; // Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
    
        if ($secimim == "Üst") {
            if ($toplamgoller > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($toplamgoller < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }


    if ($grup == "Both Teams To Score" && $macdurum == "result") {
        // Her iki takım da gol atmışsa
        if ($toplamgolev > 0 && $toplamgolkonuk > 0) {
            if ($secim == "Evet") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
        // Her iki takımdan en az biri gol atmadıysa
        else {
            if ($secim == "Hayır") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }

    if ($grup == "Misafir to win and both teams to score" && $macdurum == "result") {
        // Misafir takım kazanmış ve her iki takım da gol atmışsa
        if ($toplamgolkonuk > $toplamgolev && $toplamgolev > 0 && $toplamgolkonuk > 0) {
            if ($secim == "Evet") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
        // Diğer durumlar (Misafir takım kazanmamış veya her iki takım da gol atmamış)
        else {
            if ($secim == "Hayır") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }


    if ($grup == "Ev Sahibi to win and both teams to score" && $macdurum == "result") {
        // Ev sahibi takım kazanmış ve her iki takım da gol atmışsa
        if ($toplamgolev > $toplamgolkonuk && $toplamgolev > 0 && $toplamgolkonuk > 0) {
            if ($secim == "Evet") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
        // Diğer durumlar (Ev sahibi takım kazanmamış veya her iki takım da gol atmamış)
        else {
            if ($secim == "Hayır") {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }
    
    
    if ($grup == "Çift Avantaj" && $macdurum == "result") {
        // 1X: Ev sahibi kazanır ya da berabere biter
        if ($secim == "1X") {
            if ($ft_ev >= $ft_konuk) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
        // 12: Ev sahibi ya da misafir kazanır
        elseif ($secim == "12") {
            if ($ft_ev != $ft_konuk) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
        // X2: Berabere ya da misafir kazanır
        elseif ($secim == "X2") {
            if ($ft_ev <= $ft_konuk) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }
    


    if ($grup == "Toplam Gol - Ev Sahibi" && $macdurum == "result") {
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
        
        $limit = (float) $matches[1]; // Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
        
        if ($secimim == "Üst") {
            if ($toplamgolev > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($toplamgolev < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }

    
    if ($grup == "Toplam Gol - Misafir" && $macdurum == "result") {
        preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
        
        $limit = (float) $matches[1]; // Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
        $secimim = $matches[2]; // "Alt" ya da "Üst"
        
        if ($secimim == "Üst") {
            if ($toplamgolkonuk > $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secimim == "Alt") {
            if ($toplamgolkonuk < $limit) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }


    if ($grup == "Doğru Skor" && $macdurum == "result") {
        if ($skor == $secim) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }


    if ($grup == "Correct Score" && $macdurum == "result") {
        if ($skor == $secim) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }



    if ($grup == "Draw and both teams to score" && $macdurum == "result") {
        if ($secim == "Evet") {
            if ($toplamgolev > 0 && $toplamgolkonuk > 0 && $toplamgolev == $toplamgolkonuk) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secim == "Hayır") {
            if ($toplamgolev == 0 || $toplamgolkonuk == 0 || $toplamgolev != $toplamgolkonuk) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }

    
    if ($grup == "Yarı Devre" && $macdurum == "result") {
        if ($secim == "1") {
            if ($periodValues['ilkyarihome'] > $periodValues['ilkyariaway']) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secim == "X") {
            if ($periodValues['ilkyarihome'] == $periodValues['ilkyariaway']) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        } elseif ($secim == "2") {
            if ($periodValues['ilkyarihome'] < $periodValues['ilkyariaway']) {
                $sonuc = 1; // Kazandı
                $mesaj = "Kazandı";
            } else {
                $sonuc = 2; // Kaybetti
                $mesaj = "Kaybetti";
            }
        }
    }
    

    if ($grup == "Yarı Devre/Tam Zaman" && $macdurum == "result") {
        list($yariDevreSecim, $tamZamanSecim) = explode("/", $secim);
    
        // İlk yarı sonucunu kontrol et
        $ilkYariSonuc = "X";
        if ($periodValues['ilkyarihome'] > $periodValues['ilkyariaway']) {
            $ilkYariSonuc = "1";
        } elseif ($periodValues['ilkyarihome'] < $periodValues['ilkyariaway']) {
            $ilkYariSonuc = "2";
        }
    
        // Tam zaman sonucunu kontrol et
        $tamZamanSonuc = "X";
        if ($ft_ev > $ft_konuk) {
            $tamZamanSonuc = "1";
        } elseif ($ft_ev < $ft_konuk) {
            $tamZamanSonuc = "2";
        }
    
        if ($ilkYariSonuc == $yariDevreSecim && $tamZamanSonuc == $tamZamanSecim) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }

    
    if ($grup == "Beraberlik; Bahisler İade Edilir" && $macdurum == "result") {
        if ($ft_ev == $ft_konuk) {
            $sonuc = 5; // Beraberlik, iade
            $mesaj = "Beraberlik; İade";
        } else if ($secim == "1" && $ft_ev > $ft_konuk) {
            $sonuc = 1; // Ev sahibi kazandı
            $mesaj = "Kazandı";
        } else if ($secim == "2" && $ft_ev < $ft_konuk) {
            $sonuc = 1; // Misafir kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }

    if (strpos($grup, 'Toplam Puan/Sayı/Gol - 1. Çeyrek') !== false && $macdurum == "result") {
    preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
    
    $limit = (float) $matches[1]; // Puan/Sayı/Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
    $secimim = $matches[2]; // "Alt" ya da "Üst"
    
    if ($secimim == "Üst") {
        if ($toplam_1ceyrek > $limit) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    } elseif ($secimim == "Alt") {
        if ($toplam_1ceyrek < $limit) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }
}





if ($grup == 'Toplam Puan/Sayı/Gol - 1. Yarı' && $macdurum == "result") {
    preg_match('/(\d+\.?\d*) (Alt|Üst)/', $secim, $matches);
    
    $limit = (float) $matches[1]; // Puan/Sayı/Gol limiti (örn: 0.5, 1.5, 2.5 vs.)
    $secimim = $matches[2]; // "Alt" ya da "Üst"
    
    if ($secimim == "Üst") {
        if ($toplam_1yari > $limit) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    } elseif ($secimim == "Alt") {
        if ($toplam_1yari < $limit) {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }
}



if ($grup == "Maç Oranı" && $macdurum == "result") {
    // Ev sahibi takım kazanmışsa
    if ($toplamgolev > $toplamgolkonuk) {
        if ($secim == "Ev Sahibi") {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }
    // Misafir takım kazanmışsa
    elseif ($toplamgolev < $toplamgolkonuk) {
        if ($secim == "Misafir") {
            $sonuc = 1; // Kazandı
            $mesaj = "Kazandı";
        } else {
            $sonuc = 2; // Kaybetti
            $mesaj = "Kaybetti";
        }
    }
    // Beraberlik durumu
    else {
        $sonuc = 2; // Kaybetti, çünkü sadece "Ev Sahibi" ve "Misafir" seçenekleri var
        $mesaj = "Kaybetti";
    }
}

    
    //Maç Sonucu Sonuçlar Bitir


        //Canlı Sonuçlar Başla
        
        if ($grup == "1X2" && $macdurum == "live") {

        }
    
    
        //Canlı Sonuçlar Bitir


if (!isset($response[$coupon_id]['error'])) {
    $response[$coupon_id] = array_merge(
        [
            "result" => [
                "Message" => $mesaj,
                "Code" => $sonuc  // Hata olduğunda $sonuc 0 olarak dönecektir.
            ]
        ],
        $periodValues
    );
} else {
    // Hata durumu için de sonucu ekliyoruz
    $response[$coupon_id]['result']['Code'] = $sonuc;
}
}

$mysqli->close();

header("Content-Type: application/json");
echo json_encode($response);