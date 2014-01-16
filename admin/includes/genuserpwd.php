<?php 
include("class.Database.php");
$conn=new Database();
if($_GET['contactname']!="")
{
$query="SELECT con_Firstname,con_Middlename,con_Lastname FROM `con_contact` where con_Code=".$_GET['contactname'];
$result=@mysql_query($query);
$firstname=strtolower(substr(@mysql_result( $result,0,'con_Firstname'),0,3)) ;
$middlename=strtolower(substr(@mysql_result( $result,0,'con_Middlename'),0,3)) ;
$lastname=strtolower(substr(@mysql_result( $result,0,'con_Lastname'),0,3)) ;
$username=$firstname.$middlename.$lastname;
$password=$firstname.rand(119,999);
echo $username.",".$password;
}
