<?php
    include('dbclass/commonFunctions_class.php');
?>
<html>
    <head>
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
.red { color:#FF0000; font-size:9px}

 .button { 
     background:url(../images/submit.png) repeat-x; font-weight:bold; cursor:pointer; border: 0;
     width:67px; height:21px;
 }
  .clearbutton {
     background:url(../images/clear.png) repeat-x; font-weight:bold; cursor:pointer; border: 0;
     width:67px; height:21px;
 }

.style3 {color: #555555; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style4 {
	color: #FF9900;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 18px;
	text-align: justify;
	font-weight: bold;
}
.contents
{
color:#555555;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
line-height:18px;
text-align:justify;
}
.specialoffer
{
font-family:"Century Gothic";
font-size:24px;
font-weight:bold;
color:#fff;
padding-left:10px;
}
tr { padding:10px; }

</style>
    </head>
     <?php
      // Function to display form
       function showForm($errorcnt_name=false,$errorcmp_name=false,$errorEmail=false,$errorphone=false,$errorstates=false,$errorservices=false,$errorother=false,$errorinvalid=false){

      if ($errorcnt_name) $errorTextcnt_name = "Required";

      if ($errorcmp_name) $errorTextcmp_name = "Required";

      if ($errorEmail) $errorTextEmail = "Required";
	  
      if ($errorphone) $errorTextphone = "Required";

      if ($errorstates) $errorTextstates = "Required";
	  
      if ($errorservices)  $errorTextservices = "Required";

      if ($errorother)  $errorTextother= "Required";

      if ($errorinvalid)  $errorTextinvalid = "Invalid";

      echo '<form action="nett-offer-request.php" method="POST">';
	  ?>
	   <table>
                    <tr>
                          <td nowrap="nowrap" class="contents">
                              Contact Name&nbsp;<font class="red">*</font>&nbsp;
                          </td>
                          <td colspan="2" class="contents">
                                            <input name="cnt_name" type="text" size="19" id="cnt_name" value=""/>
					    <?php if ($errorcnt_name) echo "<span class='red'>$errorTextcnt_name</span>";?>
                          </td>
                    </tr>
                    <tr>
                          <td nowrap="nowrap" class="contents">
                                            Company Name&nbsp;<font class="red">*</font>&nbsp;
                          </td>
                          <td colspan="2" class="contents">

                                            <input name="cmp_name" type="text" size="19" id="cmp_name" value=""/>
                                         <?php if ($errorcmp_name) echo "<span class='red'>$errorTextcmp_name</span>";?>
			  </td>
                      </tr>
                      <tr>
                           <td nowrap="nowrap" class="contents">
                                            Email&nbsp;<font class="red">*</font>&nbsp;
                           </td>
                           <td colspan="2" class="contents">
                                            <input name="email" type="text" size="19" id="email" value="" />
                                            <?php if ($errorEmail) echo "<span class='red'>$errorTextEmail</span>";?>
                                            <?php if ($errorinvalid && !$errorEmail) echo "<span class='red'>$errorTextinvalid</span>";?>
                            </td>
                      </tr>

                      <tr>

                                        <td nowrap="nowrap" class="contents">
                                            Phone number&nbsp;<font class="red">*</font>&nbsp;
                                        </td>
                                        <td colspan="2" class="contents">
                                            <input name="phone" type="text" size="19" id="phone" onkeyup="validatephone(this);" value="" />
                                          <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?>
                                        </td>
                      </tr>
                      <tr>
                                        <td nowrap="nowrap" class="contents">State<font class="red">*</font>&nbsp;</td>
                                        <td colspan="2" class="contents">
                                            <select name="states" id="states">
                                                <option value=""></option>
                                                <option value="ACT">ACT</option>
                                                <option value="NSW">NSW</option>
                                                <option value="NT">NT</option>
                                                <option value="QLD">QLD</option>
                                                <option value="SA">SA</option>
                                                <option value="TAS">TAS</option>
                                                <option value="VIC">VIC</option>
                                                <option value="WA">WA</option>
                                            </select>
                                             <?php if ($errorstates) echo "<span class='red'>$errorTextstates</span>";?>
                                        </td>
                     </tr>
                     <tr>
                                        <td class="contents">Services Required&nbsp;<font class="red">*</font>&nbsp;</td>
                                        <td colspan="2">
                                            <select name="services" id="services" language="javascript"  onchange="return services_onclick()">
                                                <option value=""></option>
                                                <option value="Bookkeeping">Bookkeeping</option>
                                                <option value="Accounting & Tax">Accounting &amp; Tax</option>
                                                <option value="Both">Both</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <?php  if($errorother && !$errorservices) $style="display:block;width:104px;height:10px; white-space:nowrap"; else $style="display:none;width:104px;height:10px;white-space:nowrap ";
                                            if($_POST['services']=="other")
                                            $style="display:block;width:104px;height:10px;white-space:nowrap";
                                            else
                                            $style="display:none;width:104px;height:10px;white-space:nowrap";
                                            ?>
                                            <div id="divOthers" style="<?php echo $style?>" >
                                                <input name="other" type="text" size="19" id="other" value="" maxlength="50"/>
                                            </div>
                                            &nbsp;
                                            <?php if ($errorother && $_POST['services']=="other") echo "<span class='red'>$errorTextother</span>";?>
											<?php //} ?>
                                            <?php if ($errorservices ) echo "<span class='red'>$errorTextservices</span>";?>
                                        </td>
                     </tr>
                     <tr>
                                        <td nowrap="nowrap" class="contents">
                                            Message
                                        </td>
                                        <td colspan="2" class="contents">
                                            <textarea name="comments" id="comments" cols="15" rows="4"></textarea>
					</td>
                     </tr>
                     <tr>
                                        <td class="style3">PROMO CODE</td>
                                        <td colspan="2" class="style4">&nbsp;NETT OFFER OCT 10</td>
                     </tr>
                     <tr>
                                        <td colspan="2">
                                            </td>
                     </tr>
                     <tr>
                                        <td>&nbsp;

                                            </td>
                                        <td>

                                            <input name="SubmitForm" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" class="button" value="" />
                                            <input name="reset" type="submit" class="clearbutton" value="" id="Reset1" onclick="return others()"  /></td>
                       </tr>
              </table>
	  <?php
      echo '</form>';
      }
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
      if (!isset($_POST['SubmitForm'])) {
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
	  
      $cnt_name = isset($_POST['cnt_name']) ? trim($_POST['cnt_name']) : '';
      $cmp_name = isset($_POST['cmp_name']) ? trim($_POST['cmp_name']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone= isset($_POST['phone']) ? trim($_POST['phone']) : '';
      $states= isset($_POST['states']) ? trim($_POST['states']) : '';
      $services= isset($_POST['services']) ? trim($_POST['services']) : '';
      $other= isset($_POST['other']) ? trim($_POST['other']) : '';
	  
      $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';
 
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
//mail content
if(($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['other']!="") || ($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['services']!="" && $_POST['services']!="other"))
{
    $mailcontent=$commonUses->getMailContent($_POST['states']);
    //Get mail content
    $offermsg = "NETT OFFER OCT 10";
    $message=$mailcontent['email_template'];
    $from = "help@superrecords.com.au";
    $to = $mailcontent['email_value'];
    //$subject = $mailcontent['email_name'];
    $subject = "Request Free Quote- Befree";
   /* $eol="\r\n";
    $headers .= 'From: '.$from.$eol;
    $headers .= 'Reply-To: '.$from.$eol;
    $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%companyname%}",$_POST['cmp_name'],$message);
    $message = str_replace("{%contactname%}",$_POST['cnt_name'],$message);
    $message = str_replace("{%phonenumber%}",$_POST['phone'],$message);
    $message = str_replace("{%email%}",$_POST['email'],$message);
    $message = str_replace("{%contactstate%}",$_POST['states'],$message);
    $message = str_replace("{%servicesrequired%}", $_POST['services'],$message);
    $message = str_replace("{%contactaddress%}",$_POST['cnt_address'],$message);
    $message = str_replace("{%netoffer%}","PROMO CODE: ".$offermsg,$message);
    if($_POST['other']!="")
    {
       $message = str_replace("{%servicesother%}"," - : ".$_POST['other'],$message);
    }
    else {
        $message = str_replace("{%servicesother%}","",$message);
    }

    $message = str_replace("{%message%}",$_POST['comments'],$message);
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

  //  $status=mail($to ,$subject,$message,$headers);
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
    $smsmessage = str_replace("{%contactaddress%}",$_POST['cnt_address'],$smsmessage);
    $smsmessage = str_replace("{%contactstate%}",$_POST['states'],$smsmessage);
    $smsmessage = str_replace("{%servicesrequired%}", $_POST['services'],$smsmessage);
    $smsmessage = str_replace("{%netoffer%}","PROMO CODE: ".$offermsg,$smsmessage);
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
                        $smsstatus = $mail_object->send($to, $headers, $smsmessage);

      //  $smsstatus=mail($to,$subject,$smsmessage,$smsheaders);
    }
    if($smsmail2){
        $to = $smsmail2;
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
                        $smsstatus1 = $mail_object->send($to, $headers, $smsmessage);

        //$smsstatus1=mail($to,$subject,$smsmessage,$smsheaders);
    }
    //client mail
    if($_POST['email']!="")
    {
        $mailcontent=$commonUses->getMailContent('Thanking');
        //Get mail content
        $message=$mailcontent['email_template'];
        $emailTxt = $mailcontent['email_value'];
        $to = $email.",".$emailTxt;
        $frommail = "help@superrecords.com.au";
 /*   $eol="\r\n";
    $headers1 .= 'From: '.$frommail.$eol;
    $headers1 .= 'Reply-To: '.$frommail.$eol;
    $headers1.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%name%}",$_POST['cnt_name'],$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = "Thanks for your Interest";
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $clistatus = $mail_object->send($to, $headers, $message);

    //$clistatus=mail($to , "Thanks for your Interest", $message,$headers1);
    }
    if($status==1)
    {
        echo "<script>
            parent.location.href = '../special-nett-offer.html?msg=1';
            </script>";
      }
  }

  }
      ?> 