<?php
include(DOCUMENT_ROOT.SYSTEM_FOLDER."/core/func.php");
class base{
  function __construct(){
	global $base;
    loadlib("controller",0);
	loadlib("uri");
  }
}
$base["autoload"]=array("config","debug","db","view","input","load","model","sms","newdatabase");
foreach($base["autoload"] as $value){
	$base[$value]=loadlib($value);
}
if(DEBUG==1) $base["debug"]->add("base_class_start",__FILE__,__LINE__);

$basec=new base();


