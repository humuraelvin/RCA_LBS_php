<?php
class uri extends base{
	function __construct(){
		global $base;
		$this->config=&$base["config"];
		if(!defined("ACTIVE_CONTENT")){
		if(isset($_GET["ccb"])){
		  $address=$_GET["ccb"];
		}elseif(isset($_SERVER["PATH_INFO"])){
		  $address=substr($_SERVER["PATH_INFO"],1);
		}

		$address = security($address);

		if(isset($address)){
			 $explode=explode("/",$address);
			if(file_exists(DOCUMENT_ROOT.CONTENT_FOLDER."/".$explode[0])){
				  define("ACTIVE_CONTENT",$explode[0]);
				  $file=@security($explode[1]);
				  $function=@security($explode[2]);
				  $parametre=@security($explode[3]);
				  $parametre2=@security($explode[4]);
				  $parametre3=@security($explode[5]);
				  $parametre4=@security($explode[6]);
				  $parametre5=@security($explode[7]);
			}else{
				  define("ACTIVE_CONTENT",DEFAULT_CONTENT);
				  $file=security($explode[0]);
				  $function=@security($explode[1]);
				  $parametre=@security($explode[2]);
				  $parametre2=@security($explode[3]);
				  $parametre3=@security($explode[4]);
				  $parametre4=@security($explode[5]);
				  $parametre5=@security($explode[6]);
			}
		}else{
			  define("ACTIVE_CONTENT",DEFAULT_CONTENT);
			  $file=$this->config->get("default_contoller");
		}
		if(empty($file)){$file="home";}
		if(empty($function)){$function="index";}
		 $GLOBALS["function"]=$function;
		if(!file_exists(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/controller/".$file.".php"))){
			error_message("404");
		}else{
		  include(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/controller/".$file.".php"));
		  $GLOBALS["file"]=new $file;
		  if(isset($parametre5)){
			  $GLOBALS["file"]->$function($parametre,$parametre2,$parametre3,$parametre4,$parametre5);
		  }elseif(isset($parametre4)){
			  $GLOBALS["file"]->$function($parametre,$parametre2,$parametre3,$parametre4);
		  }elseif(isset($parametre3)){
			  $GLOBALS["file"]->$function($parametre,$parametre2,$parametre3);
		  }elseif(isset($parametre2)){
			  $GLOBALS["file"]->$function($parametre,$parametre2);
		  }elseif(isset($parametre)){
			  $GLOBALS["file"]->$function($parametre);
		  }else{
			  $GLOBALS["file"]->$function();
		  }
		}
		}
	}
}
