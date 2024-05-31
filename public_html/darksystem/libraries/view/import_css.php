<?php
function view_import_css($params){
  $exp=explode("/",$params["file"]);
		return '<?php echo \'<link type="text/css" rel="stylesheet" href="\'.BASE_URL."content/".$GLOBALS["tema"].\'/css/'.$exp[0].'" />\';?>';
}
?>