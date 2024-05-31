<?php

  Namespace Config;

  Use Helper\Database\DBGetSlug as DBGetSlug;
  Use Helper\DashboardPermission as Permission;
  Use Helper\User as User;
  Use Library\Database as DB;


  Class Process {

    Public Static Function URLRedirect()
    {
      $single = DB::single("SELECT redirect FROM sta_system_redirect WHERE url=?", array(SLUG));
      if($single->redirect)
      {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".PATH."/".$single->redirect);
        die();
      }
    }

    Public Static Function homeRedirect()
    {
      if(MULTILANG and !SLUG)
      {
        $browserLang = DB::rowCount("SELECT id FROM sta_system_langs WHERE code=? and status=?", array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2),1));
        if($browserLang)
        {
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".PATH."/".substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
          die();
        }
        else
        {
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".PATH."/tr");
          die();
        }
      }
    }

    Public Static Function noHTTP()
    {
      if(NO_HTTP)
      {
        if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
        {
          $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
          header('Location: ' . $redirect);
          exit();
        }
      }
    }

    Public Static Function noWWW()
    {
      if(NO_WWW)
      {
        if(substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.')
        {
          header("HTTP/1.1 301 Moved Permanently");
          header('Location: https://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
          exit;
        }
      }
    }

    Public Static Function noSLASH()
    {
      if(SLUG)
      {
        if(substr(PAGE_URL,-1)=='/')
        {
          $protocol = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".$protocol.rtrim(PAGE_URL, '/'));
          exit();
        }
      }
    }

    Public Static Function counter()
    {
      $todayControl = DB::rowCount("SELECT * FROM sta_system_statistic WHERE statisticTime=?",array(date("Y-m-d")));
      $getStatistic = DB::single("SELECT * FROM sta_system_statistic WHERE statisticTime=?",array(date("Y-m-d")));
      if(!$todayControl)
      {
        $insert = DB::insert("sta_system_statistic",array('statisticTime' => date("Y-m-d")));
        $update = DB::update("sta_system_statistic", array('statisticTotalVisitor' => $getStatistic->statisticTotalVisitor + 1,'statisticPageViews' => $getStatistic->statisticPageViews + 1), "statisticTime='".date("Y-m-d")."'");
      }
      else
      {
        if(!isset($_COOKIE["trackingControl"]))
        {
          $update = DB::update("sta_system_statistic", array('statisticTotalVisitor' => $getStatistic->statisticTotalVisitor + 1,'statisticPageViews' => $getStatistic->statisticPageViews + 1), "statisticTime='".date("Y-m-d")."'");
          setcookie("trackingControl", session_id(), time() + (86400));
        }
        else
        {
          $update = DB::update("sta_system_statistic", array('statisticPageViews' => $getStatistic->statisticPageViews + 1), "statisticTime='".date("Y-m-d")."'");
        }
      }
    }

    Public Static Function permission()
    {
      if(PSLUG0=='dashboard' and isset($_POST['add']))
      {
        if(!Permission::create($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
        {
          go(PATH_DASHBOARD.'/forbidden');
          die();
        }
      }
      if(PSLUG0=='dashboard' and isset($_POST['edit']))
      {
        if(!Permission::update($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
        {
          go(PATH_DASHBOARD.'/forbidden');
          die();
        }
      }
      if(PSLUG0=='dashboard' and PSLUG2=='delete')
      {
        if(!Permission::delete($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
        {
          go(PATH_DASHBOARD.'/forbidden');
          die();
        }
      }
      if(PSLUG0=='dashboard' and isset($_POST['deleteAll']))
      {
        if(!Permission::delete($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
        {
          go(PATH_DASHBOARD.'/forbidden');
          die();
        }
      }
      if(PSLUG0=='dashboard' and isset($_POST['complatedAll']))
      {
        if(!Permission::update($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
        {
          go(PATH_DASHBOARD.'/forbidden');
          die();
        }
      }

    }

    Public Static Function logout()
    {
      if(PSLUG0=='dashboard' AND PSLUG1=='logout')
      {
        unset($_SESSION['adminPermission']);
        unset($_SESSION['adminUserName']);
        unset($_SESSION['adminPassword']);
        go(PATH_DASHBOARD);
      }
    }

    Public Static Function logoutt()
    {
      if($_GET['logout']=='true')
      {
        unset($_SESSION['webLogin']);
        unset($_SESSION['webUsername']);
        unset($_SESSION['webPassword']);

        echo '<meta http-equiv="refresh" content="0;URL='.PATH.'" /> ';

      }
    }

    Public Static Function run()
    {
      self::URLRedirect();
      self::homeRedirect();
      self::noHTTP();
      self::noWWW();
      self::noSLASH();
      self::counter();
      self::permission();
      self::logout();
      self::logoutt();
    }

  }
