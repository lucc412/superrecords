<?
include("../include/connection.php");

if($_REQUEST['a'] == 'logout') {
	unset($_SESSION['PRACTICEID']);
	unset($_SESSION['PRACTICE']);
	header('Location: login.php');
}

if(isset($_SESSION['PRACTICEID'])) {
	header('Location: home.php');
}
else {
	include("../view/login.php");
}
?>