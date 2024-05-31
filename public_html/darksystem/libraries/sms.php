<?php
class sms {

    //put your code here
    public function smsGonder($numara, $mesaj) {
        $numaralar = array("$numara"); // İSTEDİĞİNİZ ADET NUMARAYI EKLEYEBİLİRSİNİZ
        $mesaj = $mesaj; // MESAJINIZ BURAYA GELECEK 
        $baslik = "WinBet90"; // BAŞLIK BURAYA GELECEK

        $veriler = array(
            'apiNo' => '1',
            'user' => '5326985612',
//            'pass' => '7969822',
            'mesaj' => $mesaj,
            'numaralar' => $numaralar,
            'baslik' => $baslik,
        );

        $out = $this->sms_gonder("http://kurecell.com.tr/kurecellapiV2/api-center/", $veriler);
        return $out;
    }

    function sms_gonder($Url, $strRequest) {

        $ch = curl_init();
        $veri = http_build_query($strRequest);
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $veri);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
?>