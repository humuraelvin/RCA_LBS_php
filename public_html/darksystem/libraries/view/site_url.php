<?php
function view_site_url($params){
  return '<?php echo BASE_URL."'.$params["url"].'";?>';
}
?>