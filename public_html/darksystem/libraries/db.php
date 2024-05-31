<?php
function recursive_escape(&$value) {
	if (is_array($value)){
		return array_map('recursive_escape', $value);
	}else{
		return mysql_real_escape_string($value);
	}
}
class db{
    function __construct(){
		global $base;
		$autoload=$base["config"]->get("autoload","database");
		$config=$base["config"]->get("database");
		foreach($autoload as $v){
		  include_once(DOCUMENT_ROOT.SYSTEM_FOLDER."/libraries/db/".$v.".php");
		  $z="db_".$v;
		  $this->$v=new $z();
		}
		$this->config=$config;
		//if($_COOKIE["username"] || $_POST["username"]){
			$this->connect($config["default"]);
			$_POST = array_map('recursive_escape', $_POST);
			$_GET = array_map('recursive_escape', $_GET);
			$_COOKIE = array_map('recursive_escape', $_COOKIE);
			if($GLOBALS["site_kapali"]=="1"){
				echo $GLOBALS["site_kapali_aciklama"];exit;
			}
		//}
     }
	
    function connect($z){
		$z=$this->config[$z];
		$this->$z["driver"]->connect($z);
		$this->active=$z;
		$this->active_driver=$z["driver"];
    }
    function query($z){
      $drive=$this->active_driver;
	return $this->$drive->query($z);
    }
	   function last_query(){
      $drive=$this->active_driver;
	return $this->$drive->last_query();
    }
    function delete($z,$a=null){
      $drive=$this->active_driver;
      return $this->$drive->delete($z,$a);
    }
    function insert($from,$z){
      $drive=$this->active_driver;
      return $this->$drive->insert($from,$z);
    }
	function insert_id(){
      $drive=$this->active_driver;
      return $this->$drive->insert_id();
    }
    function update($from,$z,$where=null){
      $drive=$this->active_driver;
      return $this->$drive->update($from,$z,$where);
    }
    function result($z,$key=0){
      $drive=$this->active_driver;
      return $this->$drive->result($z,$key);
    }
    function aresult($z){
      $drive=$this->active_driver;
      return $this->$drive->aresult($z);
    }
}
?>