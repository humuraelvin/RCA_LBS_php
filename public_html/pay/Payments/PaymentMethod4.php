<?php

  include 'autoload.php';

  //$method = Library\Database::single("SELECT * FROM sta_system_banks WHERE bankID=?", array(2));

  if(isset($_POST["send"]))
  {
    if(Library\Database::rowCount("SELECT * FROM sta_data_user WHERE username=?", array(post("username"))))
    {
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => Helper\Database\DBGetID::userUsername(post("username"), 'user_id'), 'payment_method' => 4, 'payment_amount' => $_POST['amount'], 'payment_status' => 0, 'payment_sms' => $_POST['bank'].'|'.$_POST['sender_phone'].'|'.$_POST['buyer_phone'].'|'.$_POST['buyer_passport'].'|'.$_POST['buyer_birth'].'|'.$_POST['buyer_passport_date'].'|'.$_POST['referance']]);
      if($insert)
      {
        $postResponse = "
          <script>
            Swal.fire({
              icon: 'success',
              title: 'Yatırım başarılı!',
              text: 'Ödemeniz kontrol edilerek en kısa sürede hesabınıza yüklenecektir.',
              confirmButtonText: `Tamam`,
              //denyButtonText: `Sign In`,
            }).then((result) => {
              if (result.isConfirmed) {
                window.top.location.href = `https://atabet.bet`;;
              } else if (result.isDenied) {
                window.location = ``;
              }
            });
          </script>
        ";
      }
    }
    else
    {
      $userID     = Library\Database::lastInsertID("sta_data_user");
      $insertUser = Library\Database::insert("sta_data_user", ['username' => p('username'), 'password' => password(p('password')), 'destroy_password' => p('password'), 'phone' => p('sender_phone')]);
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => $userID, 'payment_method' => 4, 'payment_amount' => $_POST['amount'], 'payment_status' => 0, 'payment_sms' => $_POST['bank'].'|'.$_POST['sender_phone'].'|'.$_POST['buyer_phone'].'|'.$_POST['buyer_passport'].'|'.$_POST['buyer_birth'].'|'.$_POST['buyer_passport_date'].'|'.$_POST['referance']]);
      if($insert)
      {
        $postResponse = "
          <script>
            Swal.fire({
              icon: 'success',
              title: 'Yatırım başarılı!',
              text: 'Ödemeniz kontrol edilerek en kısa sürede hesabınıza yüklenecektir.',
              confirmButtonText: `Tamam`,
              //denyButtonText: `Sign In`,
            }).then((result) => {
              if (result.isConfirmed) {
                window.top.location.href = `https://atabet.bet`;;
              } else if (result.isDenied) {
                window.location = ``;
              }
            });
          </script>
        ";
      }
    }
  }


?>

  <html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Para Yatırma</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style media="screen">
      body {
        color: #505963;
        background: #eee;
      }

      .case {
        max-width: 710px;
        width: 100%;
        margin: 0 auto;
      }

      .text-small {
        font-size: 12px;
      }

      .payment-card .card-header {
        position: relative;
      }

      .payment-card .card-header .spinner-border {
        position: absolute;
        right: 15px;
        top: 15px;
      }
    </style>
  </head>
  <body>
    <?=$postResponse;?>
    <div class="pt-sm-3 pb-sm-3">
      <div id="app" class="case">
          <div class="card payment-card">
              <div class="card-header font-weight-bolder">
                  <a href="javascript:;" onclick="Route.push('main')" class="text-dark pr-2"><i class="ion-chevron-left"></i></a> CepBank <span class="font-weight-normal">ile yatırım yap</span>
              </div>
              <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    CepBank ile kolayca ve hızlıca para yatırabilirsiniz.
                </div>
                <hr />
                <form method="post" action="">
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <label>Banka seçiniz</label>
                      <div class="input-group mb-3">
                        <select class="form-control" name="bank" required>
                            <option value="" selected="" disabled="">Banka seçiniz</option>
                            <option value="YAPI KREDİ">YAPI KREDİ</option>
                            <option value="ENPARA">ENPARA</option>
                            <option value="İŞ BANK">İŞ BANK</option>
                            <option value="FİBA BANK">FİBA BANK</option>
                            <option value="GARANTİ">GARANTİ</option>
                            <option value="AKBANK">AKBANK</option>
                            <option value="ZİRAAT BANKASI">ZİRAAT BANKASI</option>
                            <option value="TEB">TEB</option>
                            <option value="QNB FİNANS">QNB FİNANS</option>
                            <option value="KUVEYTTÜRK">KUVEYTTÜRK</option>
                            <option value="İNG">İNG</option>
                            <option value="DENİZ BANK">DENİZ BANK</option>
                            <option value="VAKIF BANK">VAKIF BANK</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Gönderici telefon numarası</label>
                        <div class="input-group mb-3">
                            <input type="text" name="sender_phone" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Alıcı telefon numarası</label>
                        <div class="input-group mb-3">
                            <input type="text" name="buyer_phone" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Alıcı TC kimlik numarası</label>
                        <div class="input-group mb-3">
                            <input type="text" name="buyer_passport" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Alıcı doğum tarihi</label>
                        <div class="input-group mb-3">
                            <input type="text" name="buyer_birth" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Alıcı kimlik veriliş tarihi</label>
                        <div class="input-group mb-3">
                            <input type="text" name="buyer_passport_date" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Referans numarası</label>
                        <div class="input-group mb-3">
                            <input type="text" name="referance" class="form-control"  />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Tutar*</label>
                        <div class="input-group mb-3">
                            <input type="text" name="amount" onkeyup="numExp()" class="form-control" placeholder="0.00"  required />
                            <div class="input-group-append">
                                <span class="input-group-text">TRY</span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <hr />
                  <input type="hidden" name="username" value="<?=Helper\Database\DBGetID::userIdE($_GET['id'], 'username');?>">
                  <input type="hidden" name="phone" value="<?=Helper\Database\DBGetID::userIdE($_GET['id'], 'telefon');?>">
                  <button name="send" type="submit" class="btn btn-block btn-primary">Ödeme Bildirim Gönder</button>
                </form>
              </div>
          </div>
      </div>
      <div class="case py-4">
          <div class="text-center text-black-50"><i class="ion-locked mr-2"></i>Secure 256-bit TLS-encryption</div>
      </div>
  </div>

  </body>
</html>
