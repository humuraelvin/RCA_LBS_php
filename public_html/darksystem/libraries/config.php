<?php
class config{
  function __construct(){
    include(filepath(DOCUMENT_ROOT.CONFIG_FOLDER."/database.php"));
    include(filepath(DOCUMENT_ROOT.CONFIG_FOLDER."/config.php"));
    include(filepath(DOCUMENT_ROOT.CONFIG_FOLDER."/autoload.php"));
    $this->configitem=$config;
  }
  function get($item,$pm1=null,$pm2=null,$pm3=null,$pm4=null){
    if($pm1==null){
      return $this->configitem[$item];
    }elseif($pm2==null){
      return $this->configitem[$item][$pm1];
    }elseif($pm3==null){
      return $this->configitem[$item][$pm1][$pm2];
    }elseif($pm4==null){
      return $this->configitem[$item][$pm1][$pm2][$pm3];
    }else{
      return $this->configitem[$item][$pm1][$pm3][$pm3][$pm4];
    }
  }
}