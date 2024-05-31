<?php
class type extends model{
  function __construct(){
     parent::model();
  }
  ///////////////TEXT///////////777
  function text_add($name,$value){
    return "<input type='text' name='$name' />";
  }
  function text_edit($data,$name,$value){
    return "<input type='text' name='$name' value='$data' />";
  }
  function text_list($data,$name,$value){
    return $data;
  }   
  ///////////////Check///////////777
  function check_add($name,$value){
    return "<input type='checkbox'  name='$name' value='1' />";
  }
  function check_edit($data,$name,$value){
    $return="<select name='$name'><option value='0'>Hayır</option><option ";
	if($data=="1"){$return .='selected="selected" ';}
	$return .="value='1'>Evet</option>";
	$return.="</select>";
	return $return;
  }
  function check_list($data,$name,$value){
    if($data==1){
		return "evet";
	}else{
		return "hayır";
	}
  } 
    ///////////////Upload///////////777
  function picupload_add($name,$value){
    $rand=rand(1,999999);
	return '
	<div id="yukleresim'.$rand.'"></div>
    <input id="file_upload'.$rand.'" type="file" />
	<script>$(document).ready(function() {picupload("'.$rand.'","'.$name.'");});</script>';
  }
  function picupload_list($data,$name,$value){
   return '<img src="http://ezgiselorganizasyon.com/photo/'.$data.'" width=100 />';
  }
  function picupload_edit($data,$name,$value){
	$rand=rand(1,999999);
	return '
	<div id="yukleresim'.$rand.'"><img src="http://ezgiselorganizasyon.com/photo/'.$data.'" width=150/><input type="hidden" name="'.$name.'" value="'.$data.'"/></div>
    <input id="file_upload'.$rand.'" type="file" />
	<script>$(document).ready(function() {picupload("'.$rand.'","'.$name.'");});</script>';
  }
    ///////////////TEXTAREA///////////
  function textarea_add($name,$value){
    return "<textarea name='$name' id='textarea$rand'></textarea>".'<script>$("#textarea'.$rand.'").ckeditor({ "language": "tr", "toolbar":[ [ "Bold", "Italic", "Underline", "Strike"]]} );</script>';
  }
  function textarea_edit($data,$name,$value){
	$rand=rand(1,9999999999);
    return "<textarea name='$name' id='textarea$rand'>$data</textarea>".'<script>$("#textarea'.$rand.'").ckeditor({ "language": "tr", "toolbar":[ [ "Bold", "Italic", "Underline", "Strike"]]} );</script>';
  }
  function textarea_list($data,$name,$value){
    return substr(strip_tags($data),0,100);
  }
 ///////////////CODE///////////
  function code_add($name,$value){
    return "";
  }
  function code_edit($data,$name,$value){
	return "";
  }
  function code_list($data,$name,$value,$fdata){
    $values=json_decode($value);
     return str_replace("{id}",$fdata["d"]["id"],$values->code);;
  }
    ///////////////LİSTSQL///////////
  function listsql_list($data,$name,$value){
    $values=json_decode($value);
    $a="listql_".$name;
    $this->$a=$this->db->result($values->sql);
    foreach($this->$a as $z){
      if($z["zname"]==$data){ return $z["zvalue"];break;}
    }
    return $values->null;
  }
  function listsql_edit($data,$name,$value){
    $values=json_decode($value);
    $a="listql_".$name;
    $this->$a=$this->db->result($values->sql);
    $return="<select name='$name'><option value=''>".$values->null."</option>";
    foreach($this->$a as $z){
      $return.="<option value='$z[zname]'";
      if($z["zname"]==$data){ $return.=" selected='selected'; ";}
      $return.=">".$z["zvalue"]."</option>";
    }
    $return.="</select>";
    return $return;
  }
    function listsql_add($name,$value){
    $values=json_decode($value);
    $a="listql_".$name;
    $this->$a=$this->db->result($values->sql);
    $return="<select name='$name'><option value=''>".$values->null."</option>";
    foreach($this->$a as $z){
      $return.="<option value='$z[zname]'";
      $return.=">".$z["zvalue"]."</option>";
    }
    $return.="</select>";
    return $return;
  }
}
?>