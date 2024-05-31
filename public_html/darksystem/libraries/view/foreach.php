<?php
function view_foreach($params=array(),$block=null){
    $sonuc='<?php foreach('.$params["from"].' as $'.$params["key"].' => $'.$params["item"].')\ccb\ ?>';
    $sonuc.=$block;
    $sonuc.='<?php /ccb/ ?>';
    return $sonuc;
}