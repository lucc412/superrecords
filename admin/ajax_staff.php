<?
include("dbclass/commonFunctions_class.php");

$inputValue = strtolower(trim($_REQUEST['inputValue']));
$mode = trim($_REQUEST['mode']);
$updateValue = trim($_REQUEST['updateValue']);

if(!in_array($inputValue,$_SESSION["USERLOGIN"]))
    	$returnStr = 'success';    
else
    	$returnStr = 'failure'; 

print($returnStr);
?>