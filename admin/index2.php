<?php 
ob_start();
session_start();

/* Condition added by Yogi */
if(isset($_SESSION['default_url']) && $_SESSION['default_url'] != '')
{
	header("Location:".$_SESSION['default_url']);
	exit;
}	

include("dbclass/commonFunctions_class.php");
include("includes/header.php");
?>

<div id="printheader"></div>
<?php 
if($_SESSION['validUser'])
{

?>

<br/><br/><br/>

<div class="paddingtopbtm" align="center">
	<p style="color:#888">Welcome to</p> <br />
	<h1 style="font-size:35px; letter-spacing:6px;"> SUPER RECORDS </h1>
</div>

<?php 
}  
else
{
header("Location:index.php?msg=timeout");
}
include("includes/footer.php");
?>