<?php
function view_import_js($params){
  		return '<?php echo \'<script type="text/javascript" src="\'.BASE_URL."content/".$GLOBALS["tema"].\'/js/'.$params["file"].'?d" ></script>\';?>';
}
?>