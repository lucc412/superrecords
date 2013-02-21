<?php 
ob_start();
    include 'dbclass/commonFunctions_class.php';
    
if($_POST['submail'] == "submit")
{
				$user_email = $_POST['email'];
                                $querydoc = "select u.username,u.email,u.custom_password as password,c.con_Firstname,c.con_Lastname,c.con_Email from jos_users AS u LEFT OUTER JOIN stf_staff AS s ON(u.sendEmail = s.stf_Code) LEFT OUTER JOIN con_contact AS c ON(s.stf_CCode = con_Code) where c.con_Email like'%$user_email%'";
                                $result = mysql_query($querydoc);
                                $pass_result = mysql_num_rows($result);
                                if($pass_result) {
                                $usermail = @mysql_fetch_array($result);
                                $emailval = $_POST['email'];
                                $userpass = $usermail['password'];
                                $username = $usermail['username'];
                                $fnamelname = $usermail['con_Firstname']." ".$usermail['con_Lastname'];
                                $mailcontent=$commonUses->getMailContent('ForgotPassword');
                                    //Get mail content
                                $message=$mailcontent['email_template'];
				$to = $user_email;
                              //  $from = "info@befree.com.au";
				$subject = "Recovery password";
                             /*   $eol="\r\n";
                                $headers .= 'From: '.$from.$eol;
                                $headers .= 'Reply-To: '.$from.$eol;
                                $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
                                $message = str_replace("{%user%}",$fnamelname,$message);
                                $message = str_replace("{%email%}",$username,$message);
                                $message = str_replace("{%password%}",$userpass,$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $status = $mail_object->send($to, $headers, $message);

			 	//$status = mail($to, $subject, $message, $headers);
                                echo '<div style="position:relative; top:260px; left:310px; color:red;">'."Mail send successfully. Please check your mail address".'</div>';
                                }
                                else {
                                        echo "<div style='font-size:12px; color:red; position:relative; left:520px; top:280px;'>"."did not match"."</div>";
                                }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="css/stylesheet.css" rel="stylesheet" type="text/css">
<title>Super Records</title>
<script language="javascript" type="text/javascript">
    function validateMail()
    {
       var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
       var mailcheck = document.form1.email.value;
       var form = document.form1;
       if(form.email.value == "")
            {
                document.getElementById('erremail').style.display='block';
                form.email.focus();
                return false;
            }
            else {
                document.getElementById('erremail').style.display='none';
            }
            if(filter.test(mailcheck)==false)
                {
                   document.getElementById('errcheck').style.display='block';
                   form.email.focus();
                   return false;
                }
    }
</script>

</head>

<body>
    <img src="images/header-logo.png" style="margin-left:20px;"/>
	<br /><br /><br />
    <div class="frmheading" align="center">
		<h1>Forgot Password</h1>
	</div>

   
<form name="form1" action="forgot_password.php" method="post" onsubmit="return validateMail()">
  <div align="center">
	 <div align="center" style="margin-top:100px;">
		<table width="360px;">
            <tr>
                <td>
                    <div style="font-size:12px; font-weight:bold;">Email</div>
                </td>
                <td>
                    <div><input type="text" name="email">&nbsp;&nbsp;<span style="color:red;">*</span></div>
                </td>
                <td><span style="display:none; color:red;" id="erremail">Required</span><span style="display:none; color:red;" id="errcheck">invalid email</span></td>
            </tr>
			
			<tr><td>&nbsp;</td></tr>
			
            <tr>
                <td><div style="position:relative;"><button type="submit" name="submail" value="submit" class="button">Submit</button></div></td>
                <td><div style="position:relative;">&nbsp;<button type="button" value="close" class="button" onClick="javascript:window.close();">Close</button></div></td>
            </tr>
        </table>
      </div>
  </div>
   </form>
</body>
</html>
