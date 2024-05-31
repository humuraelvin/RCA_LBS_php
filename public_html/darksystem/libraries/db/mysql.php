<?php
class db_mysql{
  function connect($z){
      mysql_connect($z["server"],$z["username"],$z["password"]);
	  mysql_select_db($z["dbname"]);
      $this->dbconfig=$z;
      $this->query("SET NAMES 'utf8'");
      $this->query("SET CHARACTER SET utf8");
      $this->query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
      return true;
  }
  function query($query){
	    $this->last_query=str_replace("{prefix}",$this->dbconfig["prefix"],$query);
	    $time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
        $return=mysql_query($this->last_query);
	    $time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		if(defined("DEBUG")){
			global $base;
			$base["debug"]->add("SQL query: ".htmlentities(substr(mysql_real_escape_string($this->last_query),0,100))." (".$total_time." sn)",__FILE__,__LINE__);
		}
	//	echo "<!--".$this->last_query."-->";
      if(!$return){
		if(defined("DEBUG") && 1==2){
			die(" Mysql hatası :".$this->last_query);
		}else{
		//	die("Bulunamadı veya bir hata oluştu.");
		}
      }
      return $return;
  }
  function last_query(){
    return $this->last_query;
  }
  function delete($from,$where){
    return  $this->query("delete from ".$from." ".$this->where($where));
   }
  function result($z,$key){
    if(is_array($z)){
     $sql="select ".implode(",",$z["select"])." from ".$z["from"]." ".$this->where($z["from"]);
    }else{
      $sql=$z;
    }
    $query=$this->query($sql);
    while($f[]=$this->fetch($query));
    $f=array_filter($f);
	if(@$key!="0"){
		foreach($f as $k){
			@$za[$k[$key]]=$k;
		}
		@$f=$za;
	}
    return $f;
  }
  function aresult($z){
    return current(@$this->result($z));
  }
  function fetch($query){
    return @mysql_fetch_assoc($query);
  }
  function update($from,$z,$where){
      foreach($z as $key=>$value){
	$set[]="`$key` = '".$this->escape($value)."'";
      }
	return $this->query("update ".$from." set ".implode(",",$set).$this->where($where));
	
  }
  function insert($from,$z){
      foreach($z as $key=>$value){
	$ke[]=$key;
	$val[]=$this->escape($value);
      }
      return $this->query("INSERT INTO ".$from." (`".implode("`,`",$ke)."`)VALUES('".implode("','",$val)."')");
  }
  function insert_id(){
	return mysql_insert_id();
  }
  function escape($string){
      return mysql_real_escape_string($string);
  }
  function where($where=null){
    if(is_array($where)){
      foreach($where as $name=>$p){
	$w[]="`".$name."` = '".$this->escape($p)."'";
      }
      return "where ".implode(" AND ",$w);
    }else{
      return "";
    }
  }
}