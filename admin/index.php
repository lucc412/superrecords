<?php
ob_start();
session_start();
include("dbclass/commonFunctions_class.php");
if(!$_SESSION['validUser'])
{
function loginUser($username,$password)
{
  $sql = "SELECT a. * , b.aty_Description FROM stf_staff a LEFT JOIN aty_accesstype AS b ON b.aty_Code = a.stf_AccessType WHERE a.stf_Login='".$username."' and a.stf_Password='".$password."'";
  $stat = mysql_query($sql) or die(mysql_error());
  $res= mysql_num_rows($stat);
    $myip = $_SERVER['REMOTE_ADDR'];
    //$myip = '182.72.96.238';
   $sql1="SELECT stf_From_ip FROM stf_ipaddress WHERE stf_From_ip=INET_ATON('$myip')";
   $res1 =mysql_query($sql1);
    $ipaddress = @mysql_num_rows($res1);
	//$ipaddress=1;
if($ipaddress==0)
    {
       $ip_query = "SELECT stf_From_ip FROM stf_ipaddress WHERE stf_From_ip<=INET_ATON('$myip') AND stf_To_ip>=INET_ATON('$myip')";
     $store_query = mysql_query($ip_query);
      $ipaddress = @mysql_num_rows($store_query);
    }

if ($res != 1) $errorText = "Invalid username or password";
if ($ipaddress != 1) $errorText = "You are not authorized to log into the system. Please contact superrecords administrator.";
if ($res == 1 && $ipaddress == 1) {
//Check if user disabled
    if(@mysql_result( $stat,0,'stf_Disabled') == 'Y') {
        $_SESSION['validUser'] = false;
        $errorText = "Your Account is Inactive. Please contact the Administrator.";
        return $errorText;
    }
    else {
        $_SESSION['staffcode']=@mysql_result( $stat,0,'stf_Code') ;
        $_SESSION['user']=$username;
        $cookname = $_SESSION['user'];
        $_SESSION['password']=$password;
        $_SESSION['usertype']=@mysql_result( $stat,0,'aty_Description') ;
		$_SESSION['Viewall']=@mysql_result( $stat,0,'stf_Viewall') ;
		/* Added by Yogi Feb 2013 */
		$_SESSION['default_url'] = @mysql_result( $stat,0,'default_url') ;
		/* end */
        $_SESSION['userupload']=@mysql_result( $stat,0,'stf_Upload') ;
        $_SESSION['validUser'] = true;
        $sql =  mysql_query ('SELECT con_Email,con_Firstname FROM `con_contact` t1 LEFT JOIN stf_staff as t2 ON (t1.con_Code=t2.stf_CCode) where stf_Code='.$_SESSION['staffcode']);
        $result=mysql_fetch_row($sql);
           /*Get from address and first name of this staff*/
        $_SESSION['from'] = $result[0];
        $_SESSION['firstname']=$result[1];

        header('Cache-Control: public');
        //header("Location: ../administrator/index.php");
		header("Location: index2.php");
        exit;
    }
}
else
	{
	 $_SESSION['validUser'] = false;
	 return $errorText;
	}

    //remember username
}

?>
<html>
<head>
<LINK href="<?php echo $styleSheet; ?>stylesheet.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.form1.username.select();
		document.form1.username.focus();
	}
        function validateLogin()
        {
            if(form1.username.value == "")
                {
                    document.getElementById('errname').style.display='block';
                    form1.username.focus();
                    return false;
                }
                else {
                    document.getElementById('errname').style.display='none';
                }
            if(form1.password.value == "")
                {
                    document.getElementById('errpass').style.display='block';
                    form1.password.focus();
                    return false;
                }
                else {
                    document.getElementById('errpass').style.display='none';
                }

        }
</script>

</head>
<title>Login</title>
<body onLoad="setFocus()">
    <div class="loginimage"></div>
 <?php
$error = '0';
if (($_POST['submitBtn']=="Login")){
// Get user input
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
// Try to login the user
$error = loginUser($username,$password);
if(isset($error) && $error!="")
{
?>
<script>alert('<?php echo $error?>');</script>
<?php
}
}
/*   if (($_POST['remember'] == "remember")) {
   setcookie("cookname", $_POST['username'], time()+60*60*24*100, "/");
   echo $cookname  = $_COOKIE['cookname'];
   exit;
   } */
//$_COOKIE['remember'] = $_POST['remember'];
 
?>
<br />
<div align="center" style="margin-top:20px;padding-bottom:45px;"><a href="index.php">
	 <img src="../jobtracker/images_user/header-logo.png"></a>
</div>

<form action="index.php" method="post" name="form1" id="form1" onsubmit="return validateLogin()">
 <div align="center">
	
		<?php if($_GET['msg']!="" && isset($_GET['msg']))
			{
				?><div class="errorMsg" style="width:300px; margin-bottom:15px;"><?php
				   		echo "You have signed out successfully."; ?>
				  </div><?php
	  		}
 		?>
   <div align="center" class="logindiv">
   		<div class="loginheader">
			<span>Welcome to Admin Login</span>
		</div>
		
     <table cellpadding="10px" width="80%">
	  <tr>
        <td>
            <div align="right" style="font-size:11px;"><b>Username &nbsp;</b> </div>
		</td>
        <td>
            <input name="username" type="text"   id="username" value="<?php echo $_COOKIE['cookname']; ?>"/>&nbsp;<span style="color:red;">*</span>
		</td>
                <td><span id="errname" style="display:none; color:red;">Required</span></td>
      </tr>
      <tr>
        <td>
            <div align="right" style="font-size:11px;"><b>Password &nbsp;</b> </div>
		</td>
        <td>
			<input name="password" type="password"   id="password" value="" />&nbsp;<span style="color:red;">*</span>
		</td>
                <td><span id="errpass" style="display:none; color:red;">Required</span></td>
      </tr>
      <tr>
        <td colspan="2">
            <div align="left" style="position:relative; top:20px; left:44px;">
            	<p align="center">
                    <button name="submitBtn" type="submit" value="Login" class="button">Login</button>&nbsp;&nbsp;<span style="font-size:11px;">Forgot password?</span>&nbsp;&nbsp;<a href="#" onclick="window.open('forgot_password.php','subwindow','toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,menubar=no,resizable=yes,height=500,width=800');return false" style="text-decoration:none; color:#001590; font-size:12px; font-weight:bold;">Click here</a>
	          </p>
                  <div style="font-size:11px; margin-left:89px; position:relative; top:8px;">
					  <input class="checkboxClass" type="checkbox" name="remember" value="remember" <?php if($_COOKIE['remember']!=""){ echo "checked"; } else { echo ""; } ?>><a style="color:#000000;">Remember my username</a></div>

        	</div>
            <div align="center" style="border-radius:25px; width:460px; height:16px; font-size:11px; color:fff; background-color:#074165; position:relative; top:70px;">Copyright &copy; 2011 superrecords. All rights reserved</div>
            <br><br>
		</td>
      </tr>
	 </table>
    </div>
</div>
 </form>
</body>
</html>
<?php }  
else
{
header("Location:index2.php");
}

?>

