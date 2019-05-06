<?php
include_once ("config/database.php");

$file = str_replace("/aula/", "", $_SERVER["REQUEST_URI"]);

$array = explode("?", $file);
$file = $array[0];
if(is_file("$file.php")){
    include_once ("header.html");
    include_once ("$file.php");
    include_once ("footer.html");
}