<?php

  Namespace Project\Controller;

  Use Library\Database as DB;

  Class Login {

    Public Static Function user($columb)
    {
      $single = DB::single("SELECT $columb FROM sta_administrator WHERE username=? and password=?", array(post('username'),password(post('password'))));
      return $single->$columb;
    }

    Public Static Function connect()
    {
      if(isset($_POST['connect']))
      {
        if(p("username") and p("password"))
        {
          $userControl = DB::rowCount("SELECT * FROM sta_administrator WHERE username=? and password=?", array(post('username'),password(post('password'))));
          if($userControl)
          {
            $_SESSION['adminID']             = self::user("id");
            $_SESSION['adminPermission']     = self::user("permission");
            $_SESSION['adminUserName']       = post('username');
            $_SESSION['adminPassword']       = password(post('password'));
            alert("success", "Başarılı!","Hesabınıza giriş yaptınız. Yönlendiriliyorsunuz...");
            go(PATH_DASHBOARD."/home",1);
          }
          else
          {
            alert("error", "Hata!","Kullanıcı adı ya da şifre hatalı!");
          }
        }
        else
        {
          alert("warning", "Dikkat!", "Lütfen, Kullanıcı Adı ve Şifre alanlarını boş bırakmayınız.");
        }
      }
    }

  }
