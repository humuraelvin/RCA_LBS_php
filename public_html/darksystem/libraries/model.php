<?php
class model extends base{
  function model(){
	global $base;


	foreach($base["autoload"] as $value){
		$this->$value=&$base[$value];
	}


  }
  function _update($name){
	global $base;
	$this->$name=&$base[$name];
  }
}