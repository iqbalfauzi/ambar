<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_ambar";
$link=mysql_connect($db_host,$db_user,$db_pass);
$db = mysql_select_db($db_name,$link);
if(!$db) die("Failed to connect to database");
$waktu=date("Y-m-d");
?>