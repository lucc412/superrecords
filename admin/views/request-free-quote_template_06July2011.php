<?php
session_start();
    include('dbclass/commonFunctions_class.php');
?>
<html>
    <head>
<script src="homecaptcha/js/jquery.min.js"></script>
<script src="homecaptcha/js/md5.js"></script>

<script src="homecaptcha/js/main.js"></script>

<script language=javascript>

function services_onclick()
{
    var SelectOption=document.getElementById('services') ;
    var SelectedIndex=SelectOption.selectedIndex;
    var SelectedValue=SelectOption.value;

    var ServiceOther=document.getElementById('other');

    if (SelectedValue=="other")
    {
        document.getElementById("divOthers").style.display='';
        ServiceOther.value="";
    }
    else
    {
        document.getElementById("divOthers").style.display='none';
    }
}

function others()
{
    document.getElementById("divOthers").style.display='none';
    
}

function validateother()
{
    var SelectOption=document.getElementById('services') ;
    var SelectedIndex=SelectOption.selectedIndex;
    var SelectedValue=SelectOption.value;

    var Validateother=document.getElementById('rfcother');

    var ServiceOther=document.getElementById('other');

    if (SelectedValue=="other")
    {
        document.getElementById("divOthers").style.display='';
        if (ServiceOther.value=='')
        {
		alert(ServiceOther.value);
             return false;
        }
    }
    else
    {
        document.getElementById("divOthers").style.display='none';
         return true;
    }
}
function isPhoneChars(n) {
return /^[0-9 ()]*$/.test(n);
}

function validatephone(el) {
 if (!isPhoneChars(el.value)) {
el.value="";
return false;
} else {
return true;
}
}
        function change_parent_url(url)
        {
        alert(url);
        document.location=url;
        }
</script>
<style>
span.red
{
color:red;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
table { font-size:12px; color:#3C3C3C; font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; text-align:left; line-height: 150% }
.button { color:white; background:url(../templates/befree/images/buttonbg.jpg) repeat-x; margin:0px; font-weight:bold; cursor:pointer; height:18px; border:1px solid #000000; font-size:11px; font-family: Tahoma,Arial; }

</style>
    </head>
    <body>
     <?php
      // Function to display form
   /*    function showForm($errorcnt_name=false,$errorcmp_name=false,$errorEmail=false,$errorphone=false,$errorstates=false,$errorservices=false,$errorother=false,$errorinvalid=false){

      if ($errorcnt_name) $errorTextcnt_name = "Required";

      if ($errorcmp_name) $errorTextcmp_name = "Required";

      if ($errorEmail) $errorTextEmail = "Required";
	  
      if ($errorphone) $errorTextphone = "Required";

      if ($errorstates) $errorTextstates = "Required";
	  
      if ($errorservices)  $errorTextservices = "Required";

      if ($errorother)  $errorTextother= "Required";

      if ($errorinvalid)  $errorTextinvalid = "Invalid";

      echo '<form action="request-free-quote.php" method="POST">';
      */
	  ?>
        <form name="freequote" action="request-free-quote.php" method="POST" onSubmit="return checkCaptcha()">
	   <table border="0" width="100%">
                                <thead>
                                    <tr>
                                        <td colspan="2" style="color: rgb(255, 255, 255); background-color: rgb(0, 105, 156);"
                                            align="center">
                                            <b>Request Free Quote!</b></td>
                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            Contact Name*</td>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <input name="cnt_name" type="text" id="cnt_name"  value="<?php echo $_POST['cnt_name'];?>" style="width: 125px;" />
                                            <div id="errname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            &nbsp;
											<?php if ($errorcnt_name) echo "<span class='red'>$errorTextcnt_name</span>";?>
											</td>
                                    </tr>

                                    <tr>
                                        <td width="115" align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormCompanyNameTitleCopy_1">Company Name</span>*</td>
                                        <td width="127" align="left" valign="middle" bgcolor="#F6F6F6">

                                            <input name="cmp_name" type="text" id="cmp_name" value="<?php echo $_POST['cmp_name']  ?>" style="width: 125px;" />
                                            <div id="errcmpname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            &nbsp;
                                         <?php if ($errorcmp_name) echo "<span class='red'>$errorTextcmp_name</span>";?>
										 </td>

                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormEmailAddressTitleCopy_1">&nbsp;Email *</span></td>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <input name="email" type="text" id="email" style="width: 125px;" value="<?php echo $_POST['email']; ?>" />
                                            <div id="erremail" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            <div id="errcheck" style="display:none; color:red; margin:0px 0px 0px 20px;">Invalid</div>
                                            &nbsp;
                                         
											<?php if ($errorEmail) echo "<span class='red'>$errorTextEmail</span>";?>
											<?php if ($errorinvalid && !$errorEmail) echo "<span class='red'>$errorTextinvalid</span>";?>
											</td>
                                    </tr>
                                    <tr>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormPhoneNumber1TitleCopy_1">&nbsp;Phone *</span></td>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <input name="phone" type="text" id="phone" style="width: 125px;" onkeyup="validatephone(this);" value="<?php echo $_POST['phone']; ?>" />
                                            <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            &nbsp;

                                          <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?>
</td>
                                    </tr>
                            <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6"><span class="ContactFormState1TitleCopy_1">&nbsp;State *</span></td>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <select name="states" id="states">
	<option value="0">State</option>
	<option value="ACT" <?php if($_POST['states']=="ACT") echo "selected";?>>ACT</option>

	<option value="NSW" <?php if($_POST['states']=="NSW") echo "selected";?>>NSW</option>
	<option value="NT" <?php if($_POST['states']=="NT") echo "selected";?>>NT</option>
	<option value="QLD" <?php if($_POST['states']=="QLD") echo "selected";?>>QLD</option>
	<option value="SA" <?php if($_POST['states']=="SA") echo "selected";?>>SA</option>
	<option value="TAS" <?php if($_POST['states']=="TAS") echo "selected";?>>TAS</option>
	<option value="VIC" <?php if($_POST['states']=="VIC") echo "selected";?>>VIC</option>

	<option value="WA" <?php if($_POST['states']=="WA") echo "selected";?>>WA</option>
</select>
                                            <div id="errstate" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            &nbsp;
                                             <?php if ($errorstates) echo "<span class='red'>$errorTextstates</span>";?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6"  nowrap="nowrap"><span class="ContactFormServices1TitleCopy_1">&nbsp;Services Required*</span></td>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <select name="services" id="services" language="javascript"  onchange="return services_onclick()">
	<option value="0"></option>
	<option value="Bookkeeping" <?php if($_POST['services']=="Bookkeeping") echo "selected";?>>Bookkeeping</option>
	<option value="Accounting & Tax" <?php if($_POST['services']=="Accounting & Tax") echo "selected";?>>Accounting &amp; Tax</option>
	<option value="Both" <?php if($_POST['services']=="Both") echo "selected";?>>Both</option>

	<option value="other" <?php if($_POST['services']=="other") echo "selected";?>>Other</option>
</select>
        <div id="errservice" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
<?php  if($errorother && !$errorservices) $style="display:block;width:104px;height:20px"; else $style="display:none;width:104px;height:20px "; 
if($_POST['services']=="other")
$style="display:block;width:104px;height:20px";
else
$style="display:none;width:104px;height:20px";
?>
											<?php //if($_POST['services']=="other") {?>
                                            <div id="divOthers" style="<?php echo $style?>" >
                                                <input name="other" type="text" id="other" class="texbox width" value="<?php echo $_POST['other']; ?>" maxlength="30" style="width: 125px;" />
                                                <div id="errother" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                                &nbsp;
                                            </div>
                                            &nbsp;
                                            <?php if ($errorother && $_POST['services']=="other") echo "<span class='red'>$errorTextother</span>";?>
											<?php //} ?>
                                            <?php if ($errorservices ) echo "<span class='red'>$errorTextservices</span>";?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormMessageTitleCopy_1">&nbsp;Message</span></td>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">

                                            <textarea name="comments" id="comments" style="width: 125px;" rows="2" cols="5"><?php echo $_POST['comments']?></textarea>
											</td>

                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6"></td>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <img src="homecaptcha/captcha.php" class="form_captcha" />
                                        </td>
                                    </tr>
                                     <tr>
                                     <td align="left" valign="middle" bgcolor="#F6F6F6" style="font-size:11px;">Enter the Characters in the image above</td>
                                     <td align="left" valign="middle" bgcolor="#F6F6F6">
                                         <input type="text" name="captcha" id="captcha" value="" class="captcha" style="width: 125px;"/>
                                         <div id="errsecurity" style="display:none; color:red;">Required Security code</div>
                                     </td>
                                     </tr>
                                    <tr>
                                        <td colspan="2">
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;

                                            </td>
                                        <td>

                                            <input name="SubmitForm" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" class="button" value="Submit"/>
                                            &nbsp;&nbsp;
                                            <input name="reset" type="reset" class="button" value="Clear" id="Reset1" /></td>
                                    </tr>
                                </tbody>
                            </table>
        </form>
    </body>
</html>
	  <?php
  
   //   echo '</form>';
   //   }
	  
	  
	  
	  if(isset($_POST['reset']))
	  {
	  $_POST['cnt_name']="";
	  $_POST['cmp_name']="";
	  $_POST['email']="";
	  $_POST['phone']="";
      $_POST['states']="";
      $_POST['services']="";
      $_POST['other']="";
      $_POST['comments']="";
	  }
   /*   if (!isset($_POST['SubmitForm'])) {
       showForm();
      } else {
//Init error variables
      $errorcnt_name = false;
      $errorcmp_name = false;
      $errorEmail= false;	  
      $errorphone = false;
      $errorstates = false;
      $errorservices = false;
      $errorother = false;

      $errorinvalid = false;
	  */
      $cnt_name = isset($_POST['cnt_name']) ? trim($_POST['cnt_name']) : '';
      $cmp_name = isset($_POST['cmp_name']) ? trim($_POST['cmp_name']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone= isset($_POST['phone']) ? trim($_POST['phone']) : '';
      $states= isset($_POST['states']) ? trim($_POST['states']) : '';
      $services= isset($_POST['services']) ? trim($_POST['services']) : '';
      $other= isset($_POST['other']) ? trim($_POST['other']) : '';
      $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';
    /*
 
      if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) $errorinvalid = true;

      if (strlen($cnt_name)<1) $errorcnt_name = true;
      if (strlen($cmp_name)<1) $errorcmp_name = true;
      if (strlen($email)<1) $errorEmail = true;
      if (strlen($phone)<1) $errorphone = true;
      if (strlen($states)<1) $errorstates = true;
      if (strlen($services)<1) $errorservices = true;
      if (strlen($other)<1) $errorother = true;
	  
       if ($errorcnt_name || $errorcmp_name ||  $errorEmail || $errorphone || $errorstates || $errorservices || $errorother || $errorinvalid) {
      showForm($errorcnt_name,$errorcmp_name,$errorEmail,$errorphone,$errorstates,$errorservices,$errorother,$errorinvalid);

      }
  } */
//mail content
if($_POST['captcha']) {
if($_SESSION['captchaval']==md5($_POST['captcha']))
    {
   
    if(($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['other']!="" && $errorinvalid=="") || ($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['services']!="other" && $errorinvalid==""))
      {
                        $mailcontent=$commonUses->getMailContent($_POST['states']);
                        //Get mail content
                        $message=$mailcontent['email_template'];
    $fromadmin = "info@befree.com.au";
    $to = $mailcontent['email_value'];
    if($services=="Both") $services = "Bookkeeping,Accounting & Tax";
    //$subject ="Contact From $cnt_name";
    $subject = "Request Free Quote- Befree";
 /*   $eol="\r\n";
    $headers .= 'From: '.$fromadmin.$eol;
    $headers .= 'Reply-To: '.$fromadmin.$eol;
    $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%contactname%}",$_POST['cnt_name'],$message);
    $message = str_replace("{%companyname%}",$_POST['cmp_name'],$message);
    $message = str_replace("{%phonenumber%}",$_POST['phone'],$message);
    $message = str_replace("{%email%}",$_POST['email'],$message);
    $message = str_replace("{%contactaddress%}",$_POST['cnt_address'],$message);
    $message = str_replace("{%contactstate%}",$_POST['states'],$message);
    $message = str_replace("{%servicesrequired%}", $services,$message);
    $message = str_replace("{%netoffer%}",$offermsg,$message);
    if($_POST['other']!="")
    {
       $message = str_replace("{%servicesother%}"," - : ".$_POST['other'],$message);
    }
    else {
        $message = str_replace("{%servicesother%}","",$message);
    }

    $message = str_replace("{%message%}",$_POST['comments'],$message);
                        $headers["From"]    = "admin@befree.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "admin@befree.com.au";
                        $params["password"] = "g1tas1ta";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $status = $mail_object->send($to, $headers, $message);

  //  $status=mail($to ,$subject,$message,$headers);
    // sms mail content
    $smsmailcontent=$commonUses->smsMailContent($_POST['states']);
    $smsmessage=$smsmailcontent['email_template'];
    $tomail = $smsmailcontent['email_value'];
    $expmail = explode(",",$tomail);
  /*  $eol="\r\n";
    $smsheaders .= 'From: '.$fromadmin.$eol;
    $smsheaders .= 'Reply-To: '.$fromadmin.$eol;
    $smsheaders.= "Content-Type: text/plain; charset=\"windows-1251\"\r\n"; */
    $smsmessage = str_replace("{%contactname%}",$_POST['cnt_name'],$smsmessage);
    $smsmessage = str_replace("{%companyname%}",$_POST['cmp_name'],$smsmessage);
    $smsmessage = str_replace("{%phonenumber%}",$_POST['phone'],$smsmessage);
    $smsmessage = str_replace("{%email%}",$_POST['email'],$smsmessage);
    $smsmessage = str_replace("{%contactaddress%}",$_POST['cnt_address'],$smsmessage);
    $smsmessage = str_replace("{%contactstate%}",$_POST['states'],$smsmessage);
    $smsmessage = str_replace("{%servicesrequired%}", $services,$smsmessage);
    $smsmessage = str_replace("{%netoffer%}",$offermsg,$smsmessage);
    if($_POST['other']!="")
    {
       $smsmessage = str_replace("{%servicesother%}"," - : ".$_POST['other'],$smsmessage);
    }
    else {
        $smsmessage = str_replace("{%servicesother%}","",$smsmessage);
    }
    $smsmessage = str_replace("{%message%}",$_POST['comments'],$smsmessage);
    $smsmail1 = $expmail[0];
    $smsmail2 = $expmail[1];
    if($smsmail1){
        $to = $smsmail1;
                        $headers["From"]    = "admin@befree.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "admin@befree.com.au";
                        $params["password"] = "g1tas1ta";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $smsstatus = $mail_object->send($to, $headers, $smsmessage);

        //$smsstatus=mail($to,$subject,$smsmessage,$smsheaders);
    }
    if($smsmail2){
        $to = $smsmail2;
                        $headers["From"]    = "admin@befree.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "admin@befree.com.au";
                        $params["password"] = "g1tas1ta";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $smsstatus1 = $mail_object->send($to, $headers, $smsmessage);

      //  $smsstatus1=mail($to,$subject,$smsmessage,$smsheaders);
    }
    //Thank you mail
    if($_POST['email']!="")
    {
        $mailcontent=$commonUses->getMailContent('Thanking');
        //Get mail content
        $message=$mailcontent['email_template'];
        $emailTxt = $mailcontent['email_value'];
        $to = $_POST['email'].",".$emailTxt;
        $frommail = "info@befree.com.au";
  /*  $eol="\r\n";
    $headers1 .= 'From: '.$frommail.$eol;
    $headers1 .= 'Reply-To: '.$frommail.$eol;
    $headers1.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%name%}",$_POST['cnt_name'],$message);
                        $headers["From"]    = "admin@befree.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = "Thanks for your Interest";
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "admin@befree.com.au";
                        $params["password"] = "g1tas1ta";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $clistatus = $mail_object->send($to, $headers, $message);

    //$clistatus=mail($to , "Thanks for your Interest", $message,$headers1);
    }
    // datas stored Users lead record
switch ($services) {
    case 'Bookkeeping';
        $servicereq = array(11);
        break;
    case 'Accounting & Tax';
        $servicereq = array(7);
        break;
    case 'Both':
        $servicereq = array(7,11);
        break;
}
switch ($states)
{
    case 'ACT':
        $state = 7;
        break;
    case 'NSW':
        $state = 1;
        break;
    case 'NT':
        $state = 8;
        break;
    case 'QLD':
        $state = 2;
        break;
    case 'SA':
        $state = 3;
        break;
    case 'TAS':
        $state = 4;
        break;
    case 'VIC':
        $state = 5;
        break;
    case 'WA':
        $state = 6;
        break;
}
    $Createdon=date( 'Y-m-d H:i:s' );
    $tday = date("D");
    switch ($tday)
    {
        case 'Mon':
            $day = "Monday";
            break;
        case 'Tue':
            $day = "Tuesday";
            break;
        case 'Wed':
            $day = "Wednesday";
            break;
        case 'Thu':
            $day = "Thursday";
            break;
        case 'Fri':
            $day = "Friday";
            break;
        case 'Sat':
            $day = "Saturday";
            break;
        case 'Sun':
            $day = "Sunday";
            break;
    }
    if($services=="other") {
        $comments = "New Service :- ".$other.". Notes :- ".$comments;
    }
    $userqry = mysql_query("INSERT INTO jos_users (`cli_Type`,`name`,`email`,`block`,`cli_Phone`,`cli_DateReceived`,`cli_DayReceived`,`cli_State`,`cli_Notes`,`cli_Salesperson`,`cli_Createdon`,`cli_Lastmodifiedon`) values ('4','".str_replace("'","''",$cmp_name)."','".str_replace("'","''",$email)."','1','".str_replace("'","''",$phone)."','".$Createdon."','".$day."','".$state."','".str_replace("'","''",$comments)."','52','".$Createdon."','".$Createdon."')");
      // insert client Code
      if($userqry){
           $result = (mysql_query ('select MAX(id) from jos_users'));
           $rowid=mysql_fetch_row($result);
           $cur_clicode = $rowid[0];
           $qry = "update jos_users set cli_Code=".$cur_clicode." where id=".$cur_clicode;
           $result = mysql_query($qry);
      }
    // datas stored Client table
      $result = (mysql_query ('select MAX(cli_Code) from jos_users'));
      $row = @mysql_fetch_row($result);
      $userCode = $row[0];
    $conqry = mysql_query("INSERT INTO con_contact (`cli_Code`,`con_Type`,`con_Firstname`,`con_Company`) values ('".$userCode."','1','".str_replace("'","''",$cnt_name)."','".$userCode."')");
    foreach ($servicereq as $sid) {
        $serviceqry = mysql_query("INSERT INTO cli_allservicerequired (`cli_ClientCode`,`cli_ServiceRequiredCode`) values ('".$userCode."','".$sid."')");
    }
    if($status==1)
    {
    echo "<script>
            parent.location.href='../Submit-Mail.html';
            </script>";
      }
      } 
    }
    else echo "<div style='color:red; position:relative; left:115px; top:-53px; font-size:12px;'>Security code is incorrect</div>";
}
      ?> 