<?php
class input{
  function post($name){
    return @$_POST[$name];
  }
  function get($name){
    return @$_GET[$name];
  }
}
