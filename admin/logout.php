<?php
session_start();
include("dbclass/commonFunctions_class.php");
//Session variables of befree application
$query = "UPDATE jos_session SET userid=0"
   . "\n WHERE userid =62";
mysql_query($query);

$_SESSION['staffcode']="";
$_SESSION['user']="";
$_SESSION['password']="";
$_SESSION['usertype']="";
$_SESSION['validUser']="";
$_SESSION['validUser']="";
$_SESSION['timeout']="";

//Session variables of befree cms
$_SESSION['session_id']="";
$_SESSION['session_user_id']="";
$_SESSION['session_username']="";
$_SESSION['session_usertype']="";
$_SESSION['session_gid']="";
$_SESSION['session_logintime']="";
$_SESSION['session_username']="";
//if($_SESSION['usertype']=="Administrator")
//{
//}
session_destroy();
header("Location:index.php?msg=timeout");
?>