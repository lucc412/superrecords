<?php
    include 'dbclass/commonFunctions_class.php';
 ?>
<script language=javascript>

function validateTellafriend()
{
		       var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                        var mailcheck = document.tellafriend.youremail.value;
                        var friendmail = document.tellafriend.friendemail.value;

                if (tellafriend.yourname.value == ""){
			document.getElementById('erryourname').style.display='inline-block'
				tellafriend.yourname.focus()
				return false
			}
			else
			{
			document.getElementById('erryourname').style.display='none'
			}
                if (tellafriend.youremail.value == ""){
			document.getElementById('erryouremail').style.display='inline-block'
				tellafriend.youremail.focus()
				return false
			}
			else
			{
			document.getElementById('erryouremail').style.display='none'
			}
            if(filter.test(mailcheck)==false)
                {
                   document.getElementById('erryouremailvalid').style.display='inline-block';
                   tellafriend.youremail.focus();
                   return false;
                }
                else
                    {
                      document.getElementById('erryouremailvalid').style.display='none';
                    }

                if (tellafriend.friendname.value == ""){
			document.getElementById('errfriendname').style.display='inline-block'
				tellafriend.friendname.focus()
				return false
			}
			else
			{
			document.getElementById('errfriendname').style.display='none'
			}
                if (tellafriend.friendemail.value == ""){
			document.getElementById('errfriendemail').style.display='inline-block'
				tellafriend.friendemail.focus()
				return false
			}
			else
			{
			document.getElementById('errfriendemail').style.display='none'
			}
            if(filter.test(friendmail)==false)
                {
                   document.getElementById('errfriendemailvalid').style.display='inline-block';
                   tellafriend.friendemail.focus();
                   return false;
                }
                else {
                    document.getElementById('errfriendemailvalid').style.display='none';
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
	width:60%;
	height:150px;
}

 .button { color:white; background:url(images/buttonbg.jpg) repeat-x; margin:0px; font-weight:bold; cursor:pointer; height:18px; border:1px solid #000000; font-size:11px; font-family: Tahoma,Arial; }
table{ border:1px solid #00699C; }

</style>
<form name="tellafriend" method="post" action="tell-a-friend.php" onsubmit="return validateTellafriend()" enctype="multipart/form-data" autocomplete="off">
	   <table  width="100%" border="0"  align="center" >
                                     <tr>

                                                            <td colspan="2" align="right">
                                                                (<span class="red">*</span>)<span> Required Fields</span>
                                                            </td>
                                     </tr>
                                    <tr>
                                        <td align="right" valign="middle">
                                            <span>&nbsp; Your Name</span>
                                        </td>
                                        <td align="left" valign="middle" >

                                            <input name="yourname" type="text" size="25" id="yourname" value="<?php echo $_POST['yourname']  ?>" style="width: 175px;" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="erryourname" style="display:none; color:red;font-family: arial; font-size: 12px;">Required</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp; Your Email </span></td>

                                        <td align="left" valign="middle" >
                                            <input name="youremail" type="text" id="youremail" size="25" style="width: 175px;" value="<?php echo $_POST['youremail']; ?>" AUTOCOMPLETE="OFF"/>
                                            <font class="red">*</font>&nbsp;
                                         <div id="erryouremail" style="display:none; color:red;font-family: arial; font-size: 12px;">Required</div>
                                         <div id="erryouremailvalid" style="display:none; color:red;font-family: arial; font-size: 12px;">Invalid Email</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Friend's Name</span></td>
                                        <td align="left" valign="middle" >

                                            <input name="friendname" type="text" size="25" id="friendname" value="<?php echo $_POST['friendname']  ?>" style="width: 175px;" />
                                            <font class="red">*</font>
                                            <div id="errfriendname" style="display:none; color:red;font-family: arial; font-size: 12px;">Required</div>
									  </td>

                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp; Friend's Email </span></td>

                                        <td align="left" valign="middle" >
                                            <input name="friendemail" type="text" id="friendemail" size="25" style="width: 175px;" value="<?php echo $_POST['friendemail']; ?>" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="errfriendemail" style="display:none; color:red;font-family: arial; font-size: 12px;">Required</div>
                                            <div id="errfriendemailvalid" style="display:none; color:red;font-family: arial; font-size: 12px;">Invalid Email</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle">
                                            <input type="checkbox" name="receivecopy">
                                        </td>
                                        <td align="left" valign="middle" style="font-family:Arial,Tahoma,Verdana,Helvetica,sans-serif;font-size: 12px;">
                                            <label>Receive a copy</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle"></td>
                                        <td align="left" valign="middle" style="font-family:Arial,Tahoma,Verdana,Helvetica,sans-serif;"><label style="font-size:12px;">Note: Hotmail may send this mail to Junk mail folder</label></td>
                                    </tr>
                                    <tr>
                                        <td width="200px;">.</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;

                                            </td>
                                        <td>

                                            <input name="SubmitForm" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" style="background: none repeat scroll 0 0 #0356A4;
    border: 1px solid #043A6D;
    color: #FFFFFF;
    font: bold 12px Arial,Helvetica,sans-serif;
    padding: 3px;" value="Submit" />
                                            &nbsp;&nbsp;
                                            <input name="reset" type="reset" style="background: none repeat scroll 0 0 #0356A4;
    border: 1px solid #043A6D;
    color: #FFFFFF;
    font: bold 12px Arial,Helvetica,sans-serif;
    padding: 3px;" value="Clear" id="Reset1"/></td>
                                    </tr>
           </table>
</form>
	  <?php
      if ($_POST['SubmitForm']) {
            $mailcontent=$commonUses->getMailContent('TellAFriend');
                        //Get mail content
                      $message=$mailcontent['email_template'];
                      $emailTxt = $mailcontent['email_value'];
            $postmailTxt = $_POST['friendemail'];
            $to = $postmailTxt.",".$emailTxt;
            $from = $_POST['youremail'];
            $subject ="Invite friend";
        /*    $eol="\r\n";
            $headers .= 'From: '.$from.$eol;
            $headers .= 'Reply-To: '.$from.$eol;
            $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
            $message = str_replace("{%yourfriendname%}",$_POST['friendname'],$message);
            $message = str_replace("{%ClientName%}",$_SESSION['user'],$message);
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

          //  $status=mail($to , $subject, $message,$headers);
            //receive copy mail
            if($_POST['receivecopy']=="on")
            {
                $frndmailTxt = $_POST['youremail'];
                $to = $frndmailTxt.",".$emailTxt;
                $from = $_POST['youremail'];
                $subject ="Invite friend";
             /*   $eol="\r\n";
                $headers .= 'From: '.$from.$eol;
                $headers .= 'Reply-To: '.$from.$eol;
                $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
                $message = str_replace("{%yourfriendname%}",$_POST['friendname'],$message);
                $message = str_replace("{%ClientName%}",$_SESSION['user'],$message);
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
                        $receivestatus = $mail_object->send($to, $headers, $message);

              //  $receivestatus=mail($to , $subject, $message,$headers);
            }
            if($status==1)
            {
            echo "<script>
                    parent.document.location.href = 'http://www.superrecords.com.au/index.php?option=com_content&view=article&id=63';
                    </script>";
              }
      }
      ?> 