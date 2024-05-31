<?php

  include 'autoload.php';

  if(isset($_POST["continue"]))
  {
    go(PATH.'/Payments/PaymentMethod8.php?id='.$_POST['user'].'&price='.$_POST['amount']);
  }

  $method = Library\Database::single("SELECT * FROM sta_system_banks WHERE bankID=?", array(8));

  if(isset($_POST["send"]))
  {
    if(Library\Database::rowCount("SELECT * FROM sta_data_user WHERE username=?", array(post("username"))))
    {
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => Helper\Database\DBGetID::userUsername(post("username"), 'user_id'), 'payment_method' => 8, 'payment_amount' => $_POST['amount'], 'payment_status' => 0]);
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
      $insert     = Library\Database::insert("sta_data_user_payments", ['user_id' => $userID, 'payment_method' => 8, 'payment_amount' => $_POST['amount'], 'payment_status' => 0]);
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
            </a> Mefete <span class="font-weight-normal">ile yatırım yap</span>
          </div>
          <div class="card-body">
            <div class="alert alert-warning" role="alert"> Anında Mefete ile kolayca ve hızlıca para yatırabilir ve çekebilirsiniz. </div>
            <hr>

            <?php if($_GET['id'] and !$_GET['price']):?>
            <form method="post" action="">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label>Yatırmak İstediğiniz Tutari Giriniz*</label>
                  <div class="input-group mb-3">
                    <input type="text" name="amount" onkeyup="numExp()" class="form-control" placeholder="0.00" required>
                    <div class="input-group-append">
                      <span class="input-group-text">TRY</span>
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="user" value="<?=$_GET['id'];?>">
              <button type="submit" name="continue" class="btn btn-block btn-primary">Devam Et</button>
            </form>
            <?php endif;?>

            <?php if($_GET['id'] and $_GET['price']):?>
            <div class="py-1">
              <div class="py-1">
                <span>Hesap Sahibi:</span>
                <strong class="ml-1"><?=$method->accountName;?></strong>
              </div>
              <div class="py-1">
                <span>Hesap Numarası:</span>
                <strong class="ml-1"><?=$method->iban;?></strong>
              </div>
            </div>
            <hr>
            <form method="post" action="">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex align-items-center mb-3">
                    <div class="price-source"> <h4>Ödenecek Tutar</h4> </div>
                    <div class="ml-auto price"> <h3> <strong><?php echo $_GET['price'];?> TL</strong> </h3> </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="amount" value="<?php echo $_GET['price'];?>">
              <input type="hidden" name="username" value="<?=Helper\Database\DBGetID::userIdE($_GET['id'], 'username');?>">
              <input type="hidden" name="phone" value="<?=Helper\Database\DBGetID::userIdE($_GET['id'], 'telefon');?>">
              <button type="submit" name="send" class="btn btn-block btn-primary">Ödeme Yaptım</button>
            </form>
            <?php endif;?>
          </div>
        </div>
      </div>
      <div class="case py-4">
        <div class="text-center text-black-50">
          <i class="ion-locked mr-2"></i>Secure 256-bit TLS-encryption
        </div>
      </div>
    </div>
  </body>
</html>
