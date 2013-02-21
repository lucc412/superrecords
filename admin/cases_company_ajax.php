<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
  $cliname =  $_POST['name'];
  
    $rep_qry = "SELECT client_name FROM `client` WHERE client_name='".$cliname."'";
    $rep_result = mysql_query($rep_qry);
    $code = @mysql_fetch_array($rep_result);
          $cont = $code['client_name'];
  echo $cont;
?>