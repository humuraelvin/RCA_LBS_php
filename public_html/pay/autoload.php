<?php

  /*
  |--------------------------------------------------------------------------
  | CONFIG
  |--------------------------------------------------------------------------
  |
  | İlk olarak config.php dosyasında belirlenen ayarlar uygulamaya dahil edilir.
  |
  */
    include 'config.php';




  /*
  |--------------------------------------------------------------------------
  | FUNCTIONS
  |--------------------------------------------------------------------------
  |
  | Uygulamada kullanılacak temel fonksiyonlar yüklenir.
  |
  */
    include 'functions.php';




  /*
  |--------------------------------------------------------------------------
  | LIBRARY
  |--------------------------------------------------------------------------
  |
  | Hariç bırakılan kütüphaneler dahil edilir.
  |
  */
    include 'Library/Exception/Paginator.php';
    include 'Library/Exception/sCache.php';




  /*
  |--------------------------------------------------------------------------
  | CACHE SİSTEMİ
  |--------------------------------------------------------------------------
  |
  | Hariç bırakılan kütüphaneler dahil edilir.
  |
  */
    if(PSLUG0!='dashboard' and !$_POST and !$_GET)
    {
      $options = array(
      'time'     => CACHE_TIME,
      'dir'      => '../../Files/Cache',
      'buffer'   => CACHE_BUFFER,
      'load'     => CACHE_LOAD,
      'extension' => '.html'
      );
      $sCache = new sCache($options,CACHE);
    }




  /*
  |--------------------------------------------------------------------------
  | DİL DOSYASI
  |--------------------------------------------------------------------------
  |
  | Dil dosyası yüklenir.
  |
  */
    if(PSLUG0!='dashboard' and MULTILANG)
    {
      include 'Files/Terms/'.LANG.'.php';
    }



  /*
  |--------------------------------------------------------------------------
  | AUTOLOAD
  |--------------------------------------------------------------------------
  |
  | spl_autoload_register ile kullanılacak sınıflar çalıştırılır.
  |
  */
    spl_autoload_register(function($class)
    {
      $fixClass = explode('\\', $class);
      $sources  =
      array(
        "Config/".end($fixClass).".php",
        "Helper/".end($fixClass).".php",
        "Helper/Database/".end($fixClass).".php",
        "Library/".end($fixClass).".php",

      );
      foreach ($sources as $source)
      {
        if(file_exists($source))
        {
          require_once realpath(dirname(__FILE__)).'/'.$source;
        }
      }
    });




  /*
  |--------------------------------------------------------------------------
  | WORK AREA
  |--------------------------------------------------------------------------
  |
  echo '<pre>';

  $query = Library\Databasee::fetch("SELECT * FROM admin");
  echo '<pre>';
  print_r($query);
  */




  /*
  |--------------------------------------------------------------------------
  | PROCESS
  |--------------------------------------------------------------------------
  |
  | Uygulamaya çalışmaya başlarken yapılacak kontroller için Process sınıfı başlatılır.
  |
  */
  Config\Process::run();




  /*
  |--------------------------------------------------------------------------
  | ROUTER
  |--------------------------------------------------------------------------
  |
  | Rooter başlatılır.
  |
  */
    Config\Router::run();
