<?php

class cookie{

  function get($name){

    return @$_COOKIE[$name];

  }

  function set($name,$value,$time=3600){

    return setcookie($name,$value,time()+$time,"/");

  }

}

