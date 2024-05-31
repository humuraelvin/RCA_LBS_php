<?php
class view{
  function display($__file,$__var){
      foreach($__var as $__name=>$__vari){$$__name=$__vari;}
      unset($__var);unset($__name);unset($__vari);
	if(!file_exists(DOCUMENT_ROOT.SYSTEM_FOLDER."/cache/view/".$GLOBALS["tema"]."_".$__file.".php") || defined("DEBUG")){
      $this->tpl=file_get_contents(filepath(DOCUMENT_ROOT.CONTENT_FOLDER."/".$GLOBALS["tema"]."/view/".$__file));
      /////////////////////
      //////Literal//////////
      preg_match_all('#\{literal\}(.*?)\{\/literal\}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){
	    $this->tpl=str_replace("{literal}".$value[1]."{/literal}",str_replace(array("{","}"),array("\ccb\\","/ccb/"),$value[1]),$this->tpl);
      }
      ////////PHP////////////////
       preg_match_all('#\{php\}(.*?)\{\/php\}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){
	    $this->tpl=str_replace("{php}".$value[1]."{/php}","<?php ".str_replace(array("{","}"),array("\ccb\\","/ccb/"),$value[1])." ?>",$this->tpl);
      }
      ///////// IF	 /////////////////
      preg_match_all('#{if (.*?)}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){
		$value1[1]=str_replace(array("eq","neq"),array("==","!="),$value[1]);
		$this->tpl=str_replace("{if ".$value[1]."}","<?php if(".$value1[1].")\ccb\ ?>",$this->tpl);
      }
	  preg_match_all('#{elseif (.*?)}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){
		$value1[1]=str_replace(array("eq","neq"),array("==","!="),$value[1]);
	  $this->tpl=str_replace("{elseif ".$value[1]."}","<?php /ccb/elseif(".$value1[1].")\ccb\ ?>",$this->tpl);
      }
      $this->tpl=str_replace("{/if}","<?php /ccb/ ?>",$this->tpl);
      $this->tpl=str_replace("{else}","<?php /ccb/else\ccb\?>",$this->tpl);
      ///////////VARIABLE//////////////
      preg_match_all('#{\$(.*?)}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){
	    if(strpos($value[1],"+")!==false || strpos($value[1],"-")!==false|| strpos($value[1],"*")!==false){
            $this->tpl=str_replace('{$'.$value[1]."}",'<?php echo $'.$value[1].";?>",$this->tpl);
        }else{
            $this->tpl=str_replace('{$'.$value[1]."}",'<?php if(isset($'.$value[1].')) \ccb\ echo $'.$value[1].";/ccb/?>",$this->tpl);
        }
      }
      ///////////////////Functions////////
      preg_match_all('#{(.*?)}#si',$this->tpl,$p,PREG_SET_ORDER);
      foreach($p as $key=>$value){	
	$func=current(explode(" ",$value[1]));
	if(substr($func,0,1)!="/"){  
	  if(!strpos($this->tpl,"{/".$func."}")){
	    $this->tpl=str_replace('{'.$value[1]."}",$this->load($value[1]),$this->tpl);
	  }else{
	    preg_match_all('#{'.$func.'(.*?)}(.*?){\/'.$func.'}#si',$this->tpl,$pz,PREG_SET_ORDER);
	    $this->tpl=str_replace('{'.$value[1]."}".$pz[0][2]."{/".$func."}",$this->load($value[1],$pz[0][2]),$this->tpl);
	  }
	}
      }
      ///////}ccb} {ccb{///
      $this->tpl=str_replace(array("\ccb\\","/ccb/"),array("{","}"),$this->tpl);
      ////////////////////
      touch(DOCUMENT_ROOT.SYSTEM_FOLDER."/cache/view/".$GLOBALS["tema"]."_".$__file.".php");
      $open=fopen(DOCUMENT_ROOT.SYSTEM_FOLDER."/cache/view/".$GLOBALS["tema"]."_".$__file.".php","w+");
      fwrite($open,$this->tpl);
      fclose($open);
	  }
	  //eval($this->tpl);
      include(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/cache/view/".$GLOBALS["tema"]."_".$__file.".php"));
  }
  function load($libraries,$block=null){
      $exp=explode(" ",$libraries,2);
      foreach($exp as $key=>$value){
	  if($key==0){
	    $func=$value;
	  }else{
	    preg_match_all('#(.*?)="(.*?)"#si',$value,$expo,PREG_SET_ORDER);
	    foreach($expo as $exp2){
	      $param[trim($exp2[1])]=trim($exp2[2]);
	    }
	  }
      }
      $funct="view_".$func;
      if(!function_exists($funct)){
	@include(filepath(DOCUMENT_ROOT.SYSTEM_FOLDER."/libraries/view/".$func.".php"));
      }
      if(function_exists($funct)){
	return  @$funct($param,$block);
      }else{
	return "<?php echo $libraries ; ?>";
      }
  }	
}
