<?php
class debug{
	function add($name,$file,$line){
		@$this->load[$name]=array("time"=>microtime(),"file"=>end(explode("\\",$file)),"line"=>$line);
	}
	function toint($time){
		$time = explode(" ", $time); 
		return $time[1] + $time[0];
	}
	function show(){
		$return="<table width=100%>";
		foreach($this->load as $var=>$value){
			$return .="<tr><td>" .($this->toint($value["time"])-$this->toint(BEGIN_TIME))."sn<td><td>".$var."</td><td>".$value["file"]."(".$value["line"].")</td></tr>";
		}
		$return .="<tr><td>" .($this->toint(microtime())-$this->toint(BEGIN_TIME))."sn<td><td>end</td><td>debug.php(".__LINE__.")</td></tr>";
		$return.="</table>";
		$return ='<script>__debug = window.open("","DEBUG","width=680,height=600,resizable,scrollbars=yes");
		__debug.document.write(\''.$return.'\');
		__debug.document.close();</script>';
		echo $return;
	}
}