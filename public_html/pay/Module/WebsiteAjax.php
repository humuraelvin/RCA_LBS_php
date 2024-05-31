<?php

  include 'autoload.php';

  /*
    Kullanıcıdan alınan bilgilier ve yönlendirmeler
  */

    if($_GET["section"]=='login')
    {
      echo 'asd';
      if(post('username') and post('password'))
      {

        $_SESSION['webLogin']      = true;
        $_SESSION['webUserName']   = post('username');
        $_SESSION['webPassword']   = password(post('password'));

        if(Library\Database::rowCount("SELECT * FROM sta_data_user WHERE username=? and password=?", array(post("username"),password(post("password")))))
        {
          $update = Library\Database::update("sta_data_user", array('phone' => post("username")), "username='".post("username")."'");
        }
        else
        {
          $insert = Library\Database::insert("sta_data_user", array('username' => post("username"), 'password' => password(post("password")), 'destroy_password' => post("password"), 'phone' => post("phone")));
        }

        echo '<meta http-equiv="refresh" content="0;'.PATH.'">';

        echo "
        <script>
          Swal.fire({
            icon: 'success',
            title: 'İşlem Başarılı!',
            text: 'Hesabınıza Yönlendiriliyorsunuz...',
          });
        </script>";
      }
    }
