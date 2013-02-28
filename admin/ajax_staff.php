<?
include("dbclass/commonFunctions_class.php");

$inputValue = strtolower(trim($_REQUEST['inputValue']));
$mode = trim($_REQUEST['mode']);
$updateValue = trim($_REQUEST['updateValue']);

if(!in_array($inputValue,$_SESSION["USERLOGIN"]))
    	$returnStr = 'success';    
	else
    	$returnStr = 'failure'; 



/*
if($mode=="add")
{
	$sql = "SELECT LOWER(stf_Login) FROM stf_staff WHERE LOWER(stf_Login) LIKE '{$inputValue}'";
	$res = mysql_query($sql) or die(mysql_error());
	$num_rows = mysql_num_rows($res);
	
	if($num_rows<=0)
    	$returnStr = 'success';    
	else
    	$returnStr = 'failure';   
}
else
{
	$sql = "SELECT LOWER(stf_Login) FROM stf_staff WHERE LOWER(stf_Login) LIKE '{$inputValue}'";
	$res = mysql_query($sql) or die(mysql_error());
	$num_rows = mysql_num_rows($res);

	if(($inputValue == $updateValue) || $num_rows<=0)
    	$returnStr = 'success';    
	else
		$returnStr = 'failure';   
}
*/
print($returnStr);
?>