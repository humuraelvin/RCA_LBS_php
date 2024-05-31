<?php

  ini_set('session.cookie_httponly', 1);
  ini_set('session.use_only_cookies', 1);
  ini_set('session.cookie_secure', 1);

  session_start();

  $params = session_get_cookie_params();
  setcookie("PHPSESSID", session_id(), 0, $params["path"], $params["domain"], false, true);


  /*
  |--------------------------------------------------------------------------
  | GZIP
  |--------------------------------------------------------------------------
  |
  | Tarayıcıya gönderilen içeriğin boyutunu azaltarak istemciye içerik aktarımını hızlandırabilir. Ancak uygulamanızı / web sitenizi hızlandırmaz.
  |
  */
    //ob_start("ob_gzhandler");




  /*
  |--------------------------------------------------------------------------
  | BUFFER
  |--------------------------------------------------------------------------
  |
  | HTML kodlarını sıkıştırarak tek satır haline getirir.
  |

    Function buffer($buffer)
    {
      return preg_replace('/\s+/', ' ', $buffer);
    }
    ob_start('buffer');
  */





  /*
  |--------------------------------------------------------------------------
  | ERROR RAPORTING
  |--------------------------------------------------------------------------
  |
  | Hangi PHP hatalarının raporlanacağını tanımlar.
  | 0 : tüm hataları gizler.
  | E_ALL ^ E_NOTICE : Basit hatalar hariç diğer tüm hataları raporlar.
  |
  */
    error_reporting(0);
    //error_reporting(E_ALL ^ E_NOTICE);
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);




  /*
  |--------------------------------------------------------------------------
  | PATHS
  |--------------------------------------------------------------------------
  |
  | Website path, assets, dashboard ve upload erişim noktaları tanımlanmıştır.
  |
  */
    define("HTTP", "https://");
    define("PATH", HTTP."pay.atabet.bet");
    define("PATH_ASSET", PATH."/Project/Frontend/View/Assets");
    define("PATH_ASSET_MOBILE", PATH."/Project/Mobile/View/Assets");
    define("PATH_UPLOAD", PATH."/Files/Upload");
    define("PATH_MODULE", PATH."/Module");
    define("PATH_DASHBOARD", PATH."/dashboard");
    define("PATH_DASHBOARD_ASSET", PATH."/Project/Backend/View/Assets");




  /*
  |--------------------------------------------------------------------------
  | API
  |--------------------------------------------------------------------------
  |
  | Projede kullanılacak apiler buradan tanımlanacaktır.
  |
  */
    define("API", "Xxxxxx");




  /*
  |--------------------------------------------------------------------------
  | DATABASE
  |--------------------------------------------------------------------------
  |
  | Database bağlantı ayarları bu kısımdan yapılacaktır.
  |
  */
    define("DB_HOST", "localhost");
    define("DB_NAME", "atab_pay");
    define("DB_USER", "atab_pay");
    define("DB_PASS", "EDC0301cde*");

    define("DB_HOST2", "localhost");
    define("DB_NAME2", "atab_atabet");
    define("DB_USER2", "atab_atabet");
    define("DB_PASS2", 'EDC0301cde*');


  /*
  |--------------------------------------------------------------------------
  | SMTP
  |--------------------------------------------------------------------------
  |
  | Smtp ayarları buradn yapılacaktır.
  |
  */
    define("SMTP_HOST", "127.0.0.1");
    define("SMTP_PORT", "587");
    define("SMTP_SECURE", "");
    define("SMTP_USERNAME", "info@xx.com");
    define("SMTP_PASSWORD", "xx");




  /*
  |--------------------------------------------------------------------------
  | ROBOTS
  |--------------------------------------------------------------------------
  |
  | Robots meta tag ayarları buradan yapılır.
  |
  */
    define("ROBOTSMETA", "index, follow");
    //define("ROBOTSMETA", "noindex");




  /*
  |--------------------------------------------------------------------------
  | CACHE
  |--------------------------------------------------------------------------
  |
  | Cache tanımlamaları buradan yapılır.
  |
  */
    define("CACHE", FALSE);
    define("CACHE_TIME", 86400);
    define("CACHE_BUFFER", FALSE);
    define("CACHE_LOAD", TRUE);




  /*
  |--------------------------------------------------------------------------
  | DİĞER TANIMLAMALAR
  |--------------------------------------------------------------------------
  |
  | Diğer tüm tanımlamalar buradan yapılacaktır.
  |
  */
    define("MULTILANG", false);
    define("NO_HTTP", false);
    define("NO_WWW", false);
    define("IP_ADRESS", $_SERVER['REMOTE_ADDR']);
    define("PAGE_URL", $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);



  /*
  |--------------------------------------------------------------------------
  | SLUG & LANG
  |--------------------------------------------------------------------------
  |
  | URL yapılanması bu kısımdan yapılacaktır.
  |
  */
  $SLUG_PATH  = str_replace("/xxx/", "", $_SERVER['REDIRECT_URL']); //SCRIPT_URL
  $SLUG_PATH  = ltrim($SLUG_PATH, "/");
  $SLUG_PARSE = explode('/', $SLUG_PATH);
  define("PSLUG0", $SLUG_PARSE[0]);
  define("PSLUG1", $SLUG_PARSE[1]);
  define("PSLUG2", $SLUG_PARSE[2]);
  define("PSLUG3", $SLUG_PARSE[3]);
  define("PSLUG4", $SLUG_PARSE[4]);
  define("LANG",   $SLUG_PARSE[0]);
  define("SLUG",   $SLUG_PATH);
