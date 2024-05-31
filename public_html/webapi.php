<?php
//PHP İle RESTful API Yapımı
require_once("baglan.php");

header("Content-Type:application/json; charset=utf-8");

$talep = $_SERVER["REQUEST_METHOD"];
parse_str(file_get_contents("php://input"), $veriler);

function islem($icerik)
{
    $islem = $icerik;
    $sonuc = json_encode($islem);
    echo $sonuc;
}

if ($veriler["token"] != sha1(md5("mehmet"))) {
    islem(NULL, 901, "Yetkisiz Erişim!");
}

if ($talep == "GET") {
    $sorgu = $baglan->query("select * from slotegrator_games where has_lobby=$veriler[has_lobby]", PDO::FETCH_ASSOC);
    // $sorgu = $baglan->query("select * from slotegrator_games where type='live dealer'", PDO::FETCH_ASSOC);
    if ($sorgu->rowCount() > 0) {
        foreach ($sorgu as $satir) {
            $onlinecasino[] = array(
                "id" => $satir["id"], 
                "uuid" => $satir["uuid"], 
                "name" => $satir["name"], 
                "image" => $satir["image"], 
                "type" => $satir["type"], 
                "provider" => $satir["provider"], 
                "has_lobby" => $satir["has_lobby"], 
                "is_mobile" => $satir["is_mobile"], 
                "has_tables" => $satir["has_tables"]
            );
        }
        islem($onlinecasino);
    } else {
        islem(NULL, 902, "Kayıt Bulunamadı!");
    }
} else if ($talep == "POST") {
    $sorgu = $baglan->prepare("insert into slotegrator_games values (?,?,?,?)");
    $sorgu->execute(array(NULL, $veriler["name"], $veriler["uuid"], $veriler["type"]));
    if ($sorgu->rowCount() > 0) {
        islem(array($veriler), 900, "Kayıt Eklendi!");
    } else {
        islem(NULL, 903, "Kayıt Eklenemedi!");
    }
} else if ($talep == "PUT") {
    $sorgu = $baglan->prepare("update slotegrator_games set name=?, uuid=?, image=? where id=?");
    $sorgu->execute(array($veriler["name"], $veriler["uuid"], $veriler["image"], $veriler["id"]));
    if ($sorgu->rowCount() > 0) {
        islem(array($veriler), 900, "Kayıt Güncellendi!");
    } else {
        islem(NULL, 904, "Kayıt Güncellenemedi!");
    }
} else if ($talep == "DELETE") {
    $sorgu = $baglan->prepare("delete from slotegrator_games where id=?");
    $sorgu->execute(array($veriler["id"]));
    if ($sorgu->rowCount() > 0) {
        islem(array($veriler), 900, "Kayıt Silindi!");
    } else {
        islem(NULL, 905, "Kayıt Silinemedi!");
    }
} else {
    islem(NULL, 906, "Hatalı İşlem!");
}
