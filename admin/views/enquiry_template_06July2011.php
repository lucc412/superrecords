<?php
    include('dbclass/commonFunctions_class.php');
?>
<script src="captcha/js/jquery.min.js"></script>
<script src="captcha/js/md5.js"></script>

<script src="captcha/js/enquiry.js"></script>

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
table{ border:1px solid #00699C; }

</style>
     <?php
      // Function to display form
    /*   function showForm($errorcnt_name=false,$errorcmp_name=false,$errorEmail=false,$errorphone=false,$errorcnt_address=false,$errorstates=false,$errorservices=false,$errorother=false,$errorinvalid=false){

      if ($errorcnt_name) $errorTextcnt_name = "Required";

      if ($errorcmp_name) $errorTextcmp_name = "Required";

      if ($errorEmail) $errorTextEmail = "Required";
	  
      if ($errorphone) $errorTextphone = "Required";

      if ($errorcnt_address) $errorTextcnt_address = "Required";

      if ($errorstates) $errorTextstates = "Required";
	  
      if ($errorservices)  $errorTextservices = "Required";

      if ($errorother)  $errorTextother= "Required";

      if ($errorinvalid)  $errorTextinvalid = "Invalid";

      echo '<form action="enquiry.php" method="POST">';
      */
	  ?>
<form name="enquiry" action="enquiry.php" method="post" onSubmit="return checkCaptcha()">
	   <table border="0" width="65%" align="center" >
                                <tr>
                                                            <td colspan="2" align="center" height="25" style="color: #FFF; background-color: #00699C;">
                                                                <b><span style="color:white;">Enquire Now!</span></b></td>
                                                        </tr>
                                     <tr>

                                                            <td colspan="2" align="right">
                                                                (<span class="red">*</span>)<span> Required Fields</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><br/></td>
                                                        </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Business Name</span></td>
                                        <td align="left" valign="middle" >

                                            <input name="cmp_name" type="text" size="25" id="cmp_name" value="<?php echo $_POST['cmp_name']  ?>" style="width: 175px;" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="errname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                         <?php if ($errorcmp_name) echo "<span class='red'>$errorTextcmp_name</span>";?>
									  </td>

                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                           <span> &nbsp;Contact Name</span></td>
                                        <td align="left" valign="middle" >
                                            <input name="cnt_name" type="text" id="cnt_name" size="25"  value="<?php echo $_POST['cnt_name'];?>" style="width: 175px;" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="errcmpname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
											<?php if ($errorcnt_name) echo "<span class='red'>$errorTextcnt_name</span>";?>
											</td>
                                    </tr>
<tr>

                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Phone number</span></td>
                                        <td align="left" valign="middle" >
                                            <input name="phone" type="text" id="phone" size="25" style="width: 175px;" onkeyup="validatephone(this);" value="<?php echo $_POST['phone']; ?>" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                          <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?>
</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Email </span></td>

                                        <td align="left" valign="middle" >
                                            <input name="email" type="text" id="email" size="25" style="width: 175px;" value="<?php echo $_POST['email']; ?>" />
                                            <font class="red">*</font>&nbsp;
                                            <div id="erremail" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            <div id="errcheck" style="display:none; color:red; margin:0px 0px 0px 20px;">Invalid</div>
                                         
											<?php if ($errorEmail) echo "<span class='red'>$errorTextEmail</span>";?>
											<?php if ($errorinvalid && !$errorEmail) echo "<span class='red'>$errorTextinvalid</span>";?>
											</td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Contact Address</span></td>
                                        <td align="left" valign="middle" >
                                            <textarea name="cnt_address" id="cnt_address" style="width: 175px;" cols="25" rows="4" class="texbox width" ><?php echo $_POST['cnt_address']?></textarea><font class="red">*</font>&nbsp;
                                            <div id="erraddress" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            <?php if ($errorcnt_address) echo "<span class='red'>$errorTextcnt_address</span>";?>
									
											</td>

                                    </tr>
                            <tr>
                                        <td align="right" valign="middle" ><span>&nbsp;State </span></td>

                                        <td align="left" valign="middle" >
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
                                            <font class="red">*</font>&nbsp;
                                            <div id="errstate" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                             <?php if ($errorstates) echo "<span class='red'>$errorTextstates</span>";?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle"   nowrap="nowrap"><span >&nbsp;Services Required</span></td>

                                        <td align="left" valign="middle" >
                                            <select name="services" id="services" language="javascript"  onchange="return services_onclick()">
	<option value="0"></option>
	<option value="Bookkeeping" <?php if($_POST['services']=="Bookkeeping") echo "selected";?>>Bookkeeping</option>
	<option value="Accounting & Tax" <?php if($_POST['services']=="Accounting & Tax") echo "selected";?>>Accounting &amp; Tax</option>
	<option value="Both" <?php if($_POST['services']=="Both") echo "selected";?>>Both</option>

	<option value="other" <?php if($_POST['services']=="other") echo "selected";?>>Other</option>
</select>&nbsp;<font class="red">*</font>&nbsp;
<div id="errservice" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
<?php  if($errorother && !$errorservices) $style="display:block;width:104px;height:10px; white-space:nowrap"; else $style="display:none;width:104px;height:10px;white-space:nowrap "; 
if($_POST['services']=="other")
$style="display:block;width:104px;height:10px;white-space:nowrap";
else
$style="display:none;width:104px;height:10px;white-space:nowrap";
?>
											<?php //if($_POST['services']=="other") {?>
                                            <div id="divOthers" style="<?php echo $style?>" >
                                                <input name="other" type="text" id="other" class="texbox width" value="<?php echo $_POST['other']; ?>" maxlength="30" style="width: 125px;" />
                                                <font class="red">*</font>&nbsp;
                                                <div id="errother" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
                                            </div>
                                            &nbsp;
                                            <?php if ($errorother && $_POST['services']=="other") echo "<span class='red'>$errorTextother</span>";?>
											<?php //} ?>
                                            <?php if ($errorservices ) echo "<span class='red'>$errorTextservices</span>";?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle" >
                                            <span>&nbsp;Comments</span></td>
                                        <td align="left" valign="middle" >

                                            <textarea name="comments" id="comments" style="width: 175px;" cols="25" rows="4" class="texbox width" ><?php echo $_POST['comments']?></textarea>
											</td>

                                    </tr>
                                    <tr>
                                        <td align="right" valign="middle"></td>
                                        <td align="left" valign="middle">
                                            <img src="captcha/captcha.php" class="form_captcha" />
                                        </td>
                                    </tr>
                                     <tr>
                                         <td align="right" valign="middle"><span>Enter the Characters<br/> in the image above&nbsp;</span></td>
                                     <td align="left" valign="middle">
                                         <input type="text" name="captcha" id="captcha" value="" class="captcha" style="width: 125px;"/>
                                         <div id="errsecurity" style="display:none; color:red; margin:0px 0px 0px 20px;">Security code is incorrect</div>
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

                                            <input name="SubmitForm" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" class="button" value="Submit" />
                                            &nbsp;&nbsp;
                                            <input name="reset" type="reset" class="button" value="Clear" id="Reset1" onclick="return others()"  /></td>
                                    </tr>
                                    <tr>
                                        <td><br/><br></td>
                                    </tr>
                             </table>
</form>
	  <?php
  
   //   echo '</form>';
   //   }
	  
	  
	  
	  if(isset($_POST['reset']))
	  {
	  $_POST['cnt_name']="";
	  $_POST['cmp_name']="";
	  $_POST['email']="";
	  $_POST['phone']="";
      $_POST['cnt_address']="";
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
      $errorcnt_address= false;
      $errorstates = false;
      $errorservices = false;
      $errorother = false;

      $errorinvalid = false;
	  */
      $cnt_name = isset($_POST['cnt_name']) ? trim($_POST['cnt_name']) : '';
      $cmp_name = isset($_POST['cmp_name']) ? trim($_POST['cmp_name']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone= isset($_POST['phone']) ? trim($_POST['phone']) : '';
      $cnt_address= isset($_POST['cnt_address']) ? trim($_POST['cnt_address']) : '';	  
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
      if (strlen($cnt_address)<1) $errorcnt_address = true;	  
      if (strlen($states)<1) $errorstates = true;
      if (strlen($services)<1) $errorservices = true;
      if (strlen($other)<1) $errorother = true;
	  
       if ($errorcnt_name || $errorcmp_name ||  $errorEmail || $errorphone || $errorcnt_address || $errorstates || $errorservices || $errorother || $errorinvalid) {
      showForm($errorcnt_name,$errorcmp_name,$errorEmail,$errorphone,$errorcnt_address,$errorstates,$errorservices,$errorother,$errorinvalid);

      }  
  } */
//mail content
  if(($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['cnt_address']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['other']!="" && $errorinvalid=="") || ($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['cnt_address']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['services']!="other" && $errorinvalid==""))
      {
      $mailcontent=$commonUses->getMailContent($_POST['states']);
                        //Get mail content
                      $message=$mailcontent['email_template'];
    $from = "info@superrecords.com.au";
    $to = $mailcontent['email_value'];
    if($services=="Both") $services = "Bookkeeping,Accounting & Tax";
    //$subject ="Contact From $cnt_name";
    $subject = "Request Free Quote- Super Records";
/*    $eol="\r\n";
    $headers .= 'From: '.$from.$eol;
    $headers .= 'Reply-To: '.$from.$eol;
    $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
                        $headers["From"]    = "info@superrecords.com.au";
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

    $message = str_replace("{%companyname%}",$_POST['cmp_name'],$message);
    $message = str_replace("{%contactname%}",$_POST['cnt_name'],$message);
    $message = str_replace("{%phonenumber%}",$_POST['phone'],$message);
    $message = str_replace("{%email%}",$_POST['email'],$message);
    $message = str_replace("{%contactaddress%}","A: ".$_POST['cnt_address'],$message);
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
    $status = $mail_object->send($to, $headers, $message);
    //$status=mail($to ,$subject,$message,$headers);
    // sms mail content
    $smsmailcontent=$commonUses->smsMailContent($_POST['states']);
    $smsmessage=$smsmailcontent['email_template'];
    $tomail = $smsmailcontent['email_value'];
    $expmail = explode(",",$tomail);
  /*  $eol="\r\n";
    $smsheaders .= 'From: '.$from.$eol;
    $smsheaders .= 'Reply-To: '.$from.$eol;
    $smsheaders.= "Content-Type: text/plain; charset=\"windows-1251\"\r\n"; */
    $smsmessage = str_replace("{%contactname%}",$_POST['cnt_name'],$smsmessage);
    $smsmessage = str_replace("{%companyname%}",$_POST['cmp_name'],$smsmessage);
    $smsmessage = str_replace("{%phonenumber%}",$_POST['phone'],$smsmessage);
    $smsmessage = str_replace("{%email%}",$_POST['email'],$smsmessage);
    $smsmessage = str_replace("{%contactaddress%}","A: ".$_POST['cnt_address'],$smsmessage);
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
                        $headers["From"]    = "info@superrecords.com.au";
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
                        $headers["From"]    = "info@superrecords.com.au";
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

      //  $smsstatus1=mail($to,$subject,$smsmessage,$smsheaders);
    }
    //client mail
    if($_POST['email']!="")
    {
        $mailcontent=$commonUses->getMailContent('Thanking');
        //Get mail content
        $message=$mailcontent['email_template'];
        $emailTxt = $mailcontent['email_value'];
        $to = $_POST['email'].",".$emailTxt;
     /*   $frommail = "info@befree.com.au";
    $eol="\r\n";
    $headers1 .= 'From: '.$frommail.$eol;
    $headers1 .= 'Reply-To: '.$frommail.$eol;
    $headers1.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%name%}",$_POST['cnt_name'],$message);
                        $headers["From"]    = "info@superrecords.com.au";
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
    $userqry = mysql_query("INSERT INTO jos_users (`cli_Type`,`name`,`email`,`block`,`cli_Phone`,`cli_DateReceived`,`cli_DayReceived`,`cli_PostalAddress`,`cli_State`,`cli_Notes`,`cli_Salesperson`,`cli_Createdon`,`cli_Lastmodifiedon`) values ('4','".str_replace("'","''",$cmp_name)."','".str_replace("'","''",$email)."','1','".str_replace("'","''",$phone)."','".$Createdon."','".$day."','".str_replace("'","''",$cnt_address)."','".$state."','".str_replace("'","''",$comments)."','52','".$Createdon."','".$Createdon."')");
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
            parent.location.href = '../Submit-Mail.html';
            </script>";
      }
      }

      ?> 