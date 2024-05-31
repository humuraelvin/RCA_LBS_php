<?php

  include 'autoload.php';

  $banks = Library\Database::fetch("SELECT * FROM sta_system_banks WHERE bankID=?", array(5));

  if(isset($_POST["send"]))
  {
    if(Library\Database::rowCount("SELECT * FROM sta_data_user WHERE username=?", array(post("username"))))
    {
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => Helper\Database\DBGetID::userUsername(post("username"), 'user_id'), 'payment_method' => 5, 'payment_amount' => $_POST['amount'], 'payment_status' => 0, 'payment_bank' => $_POST['bank']]);
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
      $insertUser = Library\Database::insert("sta_data_user", ['username' => p('username'), 'password' => password(p('password')), 'destroy_password' => p('password'), 'phone' => p('phone')]);
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => $userID, 'payment_method' => 5, 'payment_amount' => $_POST['amount'], 'payment_status' => 0, 'payment_bank' => $_POST['bank']]);
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
            <a href="javascript:;" onclick="Route.push('main')" class="text-dark pr-2">
              <i class="ion-chevron-left"></i>
            </a> Havale <span class="font-weight-normal">ile yatırım yap</span>
          </div>
          <div class="card-body">
            <form method="post" action="">
              <div class="row flex-column-reverse flex-sm-row">
                <div class="col-12 col-sm-7">
                  <label>Banka Seçiniz</label>
                  <div class="input-group mb-3">
                    <select name="bank" class="form-control" id="select" required>
                      <option value="" disabled="">Banka seçiniz</option>
                      <?php foreach ($banks as $item): ?>
                        <option value="<?=str_replace(" ", "", $item->bank_name);?>"><?=$item->bank_name;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="d-flex align-items-center mb-3 pt-2">
                    <label class="radio mr-4">
                      <input type="radio" name="where_from" value="atm" checked="">
                      <span for="radio" class="ml-2">ATM</span>
                    </label>
                    <label class="radio m-l-25">
                      <input type="radio" name="where_from" value="bank">
                      <span for="radio" class="ml-2">Banka</span>
                    </label>
                  </div>
                  <label>Kullanıcı Adı</label>
                  <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" required>
                  </div>
                  <label>Ad Soyad</label>
                  <div class="input-group mb-3">
                    <input type="text" name="full_name" class="form-control" required>
                  </div>
                  <label>Transfer Saati</label>
                  <div class="input-group mb-3">
                    <input type="text" name="transfer_time" class="form-control" placeholder="10:20" required>
                  </div>
                  <label>Tutar</label>
                  <div class="input-group mb-3">
                    <input type="text" name="amount" onkeyup="numExp()" class="form-control" placeholder="0.00" required>
                    <div class="input-group-append">
                      <span class="input-group-text">TRY</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-5">
                  <?php foreach ($banks as $item): ?>
                    <ul class="list-group mb-4 bank<?=str_replace(" ", "", $item->bank_name);?>">
                      <li class="list-group-item list-group-item-info px-3">
                        <span>Banka Bilgileri</span>
                      </li>
                      <li class="list-group-item list-group-item-info px-3">
                        <strong>Hesap Sahibi</strong>
                        <p class="mb-0 mt-1" id="account-holder"><?=$item->accountName;?></p>
                      </li>
                      <li class="list-group-item list-group-item-info px-3">
                        <strong>Iban</strong>
                        <p class="mb-0 mt-1" id="iban"><?=$item->iban;?></p>
                      </li>
                    </ul>
                  <?php endforeach; ?>
                </div>
              </div>
              <hr>
              <button type="submit" name="send" class="btn btn-block btn-primary">Ödeme Bildirim Gönder</button>
            </form>
          </div>
        </div>
      </div>
      <div class="case py-4">
        <div class="text-center text-black-50">
          <i class="ion-locked mr-2"></i>Secure 256-bit TLS-encryption
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(function () {
      $('.list-group').hide();
      $('#select').on("change",function () {
        $('.list-group').hide();
        $('.bank'+$(this).val()).show();
      }).val("2");
    });
  </script>
  </body>
</html>
