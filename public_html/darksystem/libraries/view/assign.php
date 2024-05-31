<?php
function view_assign($params=array(),$block=null){
    return "<?php $".$params["var"]."=".$params["value"]."; ?>";
}
?>