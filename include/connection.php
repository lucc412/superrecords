<?php
ini_set("display_errors", "0");
session_start();
// connect localhost connection
$dbConn = mysql_connect("localhost","root","");
if (!$dbConn) {
	die('Could not connect: ' . mysql_error());
}

//select a database to work with
$db_selected = mysql_select_db("superrec_dev1", $dbConn);
if (!$db_selected) {
	die ('cant use superrec_dev database : ' . mysql_error());
}
?>