<?php

  include '../config.php';
  include '../functions.php';
  spl_autoload_register(function($class)
  {
    $fixClass = explode('\\', $class);
    $sources  =
    array(
      "../Config/".end($fixClass).".php",
      "../Helper/".end($fixClass).".php",
      "../Helper/Database/".end($fixClass).".php",
      "../Library/".end($fixClass).".php",
    );
    foreach ($sources as $source)
    {
      if(file_exists($source))
      {
        require_once realpath(dirname(__FILE__)).'/'.$source;
      }
    }
  });
