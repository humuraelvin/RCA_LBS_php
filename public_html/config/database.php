<?php

define('DB_SERVER', "localhost");
define('DB_NAME', "atab_atabet");
define('DB_USER', "atab_atabet");
define('DB_PASSWORD', "EDC0301cde*");


$a["server"]=DB_SERVER;
$a["username"]=DB_USER;
$a["password"]=DB_PASSWORD;
$a["dbname"]=DB_NAME;
$a["driver"]="mysql";
$a["prefix"]="";
$config["database"]["default"]="0";
$config["database"][0]=$a; 