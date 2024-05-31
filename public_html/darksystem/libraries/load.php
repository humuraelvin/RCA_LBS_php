<?php
class load{
    function model($function,$content=null){
		global $base;
		if($content==null){$content=ACTIVE_CONTENT;}
		include_once(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/model/".$function.".php"));
		$base["models"][]=$function;
		if(isset($GLOBALS["file"])){
			$base[$function]=&new $function();
			$GLOBALS["file"]->_update($function);
		}else{
			return new $function();
		}
    }
    function library($function){
	  global $base;
      include_once(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/libraries/".$function.".php"));
      $base[$function]=&new $function();
	  if(isset($base["models"])){
		  foreach($base["models"] as $model){
			if(isset($base[$model])) $base[$model]->_update($function);
		  }
	  } 
	  if(isset($GLOBALS["file"])){
		$GLOBALS["file"]->_update($function);
	  }else{
		return new $function();
	  }
    }
}
?>