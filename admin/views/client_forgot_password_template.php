<?php
session_start();
    include 'dbclass/commonFunctions_class.php';
    $usermail = $_POST['email'];
if($_POST['Submitbut']=="Submit")
{
    $pass_qry = "select username,email,password from jos_users where email='".$usermail."'";
    $res_qry = mysql_query($pass_qry);
    $pass_result = mysql_num_rows($res_qry);
    if($pass_result)
    {
        $userpass = @mysql_fetch_array($res_qry);
        $username = $userpass['username'];
        $useremail = $userpass['email'];
        $password = $userpass['password'];
        $mailcontent=$commonUses->getMailContent('ForgotPassword');
                        //Get mail content
                      $message=$mailcontent['email_template'];
                      $to = $usermail;
     /*   $from = "info@befree.com.au";
        $to = $usermail;
        $eol="\r\n";
        $headers .= 'From: '.$from.$eol;
        $headers .= 'Reply-To: '.$from.$eol;
        $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n";

      */
        $message = str_replace("{%user%}","Client",$message);
        $message = str_replace("{%email%}",$useremail,$message);
        $message = str_replace("{%password%}",$password,$message);
       // $status=mail($to , "Recovery password", $message,$headers);
                        $headers["From"]    = "info@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = "Recovery password";
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $body = $message;
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "admin@befree.com.au";
                        $params["password"] = "g1tas1ta";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                         $status = $mail_object->send($to, $headers, $body);

        header('Location: client_forgot_password.php?msg=pass');
    }
    else {
        echo "<div style='font-size:12px; color:red; position:relative; left:290px; top:45px;'>"."did not match"."</div>";
    }
}
if($_GET['msg']=="pass")
{
    echo "<div style='font-size:13px; color:red; text-align:center;'>"."Password sent your email"."</div>";
}
?>
<script type="text/javascript">
function checkValidate()
{
    var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var mailcheck = document.forgotpassForm.email.value;
    if(document.forgotpassForm.email.value=="")
        {
            document.getElementById('erremail').style.display='block';
            document.forgotpassForm.email.focus();
            return false;
        }
        else {
            document.getElementById('erremail').style.display='none';
        }
        if(filter.test(mailcheck)==false)
            {
                document.getElementById('errinvalid').style.display='block';
                document.forgotpassForm.email.focus();
                return false;
            }
            else {
                document.getElementById('errinvalid').style.display='none';
            }
}
</script>
<style>
input, select, textarea { font-size:11px; color:#444444; font-family:Verdana,Arial,Tahoma; }
input, select, textarea { border:1px solid #D6D5D5; padding:1px; }

span
{
color:#3C3C3C;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
padding:6px;
}
.red { color:#FF0000; font-size:9px}
#form textarea{
	width:100%;
	height:150px;
}

 .button { color:white; background:url(../templates/admin/images/buttonbg.jpg) repeat-x; margin:0px; font-weight:bold; cursor:pointer; height:18px; border:1px solid #000000; font-size:11px; font-family: Tahoma,Arial; }
</style>
<form name="forgotpassForm" action="client_forgot_password.php" method="post" onSubmit="return checkValidate()" autocomplete="off">
	   <table border="0" width="100%">
                                     <tr>

                                                            <td colspan="2" align="right">
                                                                (<span class="red">*</span>)<span> Required Fields</span>
                                                            </td>
                                     </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Email</span></td>
                                        <td align="left" valign="middle" >

                                            <input name="email" type="text" size="25" id="email" value="<?php echo $_POST['email']  ?>" style="width: 175px;" />
                                            <font class="red">*</font>&nbsp;
                                        </td>
                                        <td>
                                            <a id="erremail" style="display:none; color: red; font-size: 11px; ">Required</a>
                                            <a id="errinvalid" style="display:none; color: red; font-size: 11px; ">invalid email</a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>&nbsp;

                                            </td>
                                        <td>

                                            <input name="Submitbut" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" class="button" value="Submit" />
                                            &nbsp;&nbsp;
                                            <input name="reset" type="reset" class="button" value="Clear" id="Reset1" /></td>
                                    </tr>
                             </table>
</form>
