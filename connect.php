<?php

$host="localhost";
$userDB="Helpdesk_Kmutnb";
$password="Helpdesk_Kmutnb61";
$dbname="helpdesk";

$dbcon=@mysql_connect($host,$userDB,$password);
//$con = mysqli_connect("localhost",$userDB,$password,$dbname);
if(!$dbcon){
  echo "<script>alert('disconnect database !');history.back();</script>";
  exit();
  }

  mysql_select_db($dbname);

  mysql_query("SET NAMES UTF8");

  mysql_query("SET character_set_results=utf8");
  mysql_query("SET character_set_client=utf8");
  mysql_query("SET character_set_connection=utf8");

?>
