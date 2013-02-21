<?php
    include('dbclass/commonFunction_class_for_enquiry.php');
	//include('mail.php');
?>
<?php
  
   
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
	 
   
      $cnt_name = isset($_POST['cnt_name']) ? trim($_POST['cnt_name']) : '';
      $cmp_name = isset($_POST['cmp_name']) ? trim($_POST['cmp_name']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone= isset($_POST['phone']) ? trim($_POST['phone']) : '';
	  $suburb= isset($_POST['suburb']) ? trim($_POST['suburb']) : '';
	  $post_code= isset($_POST['post_code']) ? trim($_POST['post_code']) : '';	 
	  
      $cnt_address= isset($_POST['cnt_address']) ? trim($_POST['cnt_address']) : '';	  
      $states= isset($_POST['states']) ? trim($_POST['states']) : '';
      $services= isset($_POST['services']) ? trim($_POST['services']) : '';
      $other= isset($_POST['other']) ? trim($_POST['other']) : '';
      $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';
 
  if(($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['other']!="" && $errorinvalid=="") || ($_POST['cnt_name']!="" && $_POST['cmp_name']!="" && $_POST['email']!="" && $_POST['phone']!="" && $_POST['states']!="" && $_POST['post_code']!="" && $errorinvalid==""))
      {
      
	  $_SESSION['enquiry_status'] = 1;
  

	
      $mailcontent=$commonUses->getMailContent($_POST['states']);
                        //Get mail content
       $message=$mailcontent['email_template'];
    $from = "help@superrecords.com.au";
	$to = $mailcontent['email_value'];
//    $to = $mailcontent['email_value'];
    if($services=="Both") $services = "Bookkeeping,Accounting & Tax";
    //$subject ="Contact From $cnt_name";
    $subject = "Request Free Quote- Super Records";

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
						//$to = $smsmail1;
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
        //$smsstatus=mail($to,$subject,$smsmessage,$smsheaders);
    }
    if($smsmail2){
						$to = $smsmail2;
        				//$to = $smsmail2;
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
    // datas stored Users lead record
switch ($services) {
    case 'Bookkeeping';
        $servicereq = array(11);
        break;
    case 'Accounting & Tax';
        $servicereq = array(7);
        break;
	case 'SMSF service';
        $servicereq = array(13);
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
	 
    $userqry = mysql_query("INSERT INTO jos_users (`cli_Type`,`name`,`email`,`block`,`cli_Phone`,`cli_DateReceived`,`cli_DayReceived`,`cli_PostalAddress`,`cli_State`,`cli_Notes`,`cli_Salesperson`,`cli_Createdby`,`cli_Createdon`,`cli_Lastmodifiedby`,`cli_Lastmodifiedon`,cli_City,cli_Postcode 	) values ('4','".str_replace("'","''",$cmp_name)."','".str_replace("'","''",$email)."','1','".str_replace("'","''",$phone)."','".$Createdon."','".$day."','".str_replace("'","''",$cnt_address)."','".$state."','".str_replace("'","''",$comments)."','52','".str_replace("'","''",$cnt_name)."','".$Createdon."','".str_replace("'","''",$cnt_name)."','".$Createdon."','".str_replace("'","''",$suburb)."','".str_replace("'","''",$post_code)."')");
      // insert client Code
      if($userqry){
           $result = (mysql_query ('select MAX(id) from jos_users'));
           $rowid=mysql_fetch_row($result);
           $cur_clicode = $rowid[0];
           $qry = "update jos_users set cli_Code=".$cur_clicode." where id=".$cur_clicode;
           $result = mysql_query($qry);
          
           $map_query = mysql_query("insert into jos_core_acl_aro(`section_value`,`value`,`order_value`,`name`,`hidden`) values('users'," . $cur_clicode . ",0,'" . $cnt_name . "',0)") or die(mysql_error());
                    $map_query_result = (mysql_query('SELECT LAST_INSERT_ID() FROM jos_core_acl_aro'));
                    $maprow = mysql_fetch_row($map_query_result);
                    $climapcode = $maprow[0];
                    /* jos_core_acl_groups_aro_map */
                    $map_group_query = mysql_query("insert into jos_core_acl_groups_aro_map(`group_id`,`section_value`,`aro_id`) values('18',''," . $climapcode . ")") or die(mysql_error());
      }
    // datas stored Client table
      $result = (mysql_query ('select MAX(cli_Code) from jos_users'));
      $row = @mysql_fetch_row($result);
      $userCode = $row[0];
    $conqry = mysql_query("INSERT INTO con_contact (`cli_Code`,`con_Type`,`con_Firstname`,`con_Company`) values ('".$userCode."','1','".str_replace("'","''",$cnt_name)."','".$userCode."')");
    /*foreach ($servicereq as $sid) {
        $serviceqry = mysql_query("INSERT INTO cli_allservicerequired (`cli_ClientCode`,`cli_ServiceRequiredCode`) values ('".$userCode."','".$sid."')");
    }*/
    
     echo "<script>
            parent.location.href = 'http://www.superrecords.com.au/index.php?option=com_content&Itemid=68&id=62&view=article';
            </script>";
   
      
	
      }

      ?>
<script src="js/jquery-1.3.2.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.validation.functions.js"></script>
<script src="js/jquery.blockUI.js"></script>
<link href="css/jquery.validate.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/style_new.css" rel="stylesheet" type="text/css" media="screen" />
<script>

$(function(){
		
		$("#cmp_name").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		$("#cnt_name").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		/*$("#cnt_address").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		$("#suburb").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});*/
		$("#post_code").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		$("#post_code").validate({
			 expression: "if (VAL.match(/^[0-9]*$/) && VAL) return true; else return false;",
                    message: "Numbers only"
		});

		$("#phone").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
 		$("#phone").validate({
                    expression: "if (VAL.match(/^[0-9]*$/) && VAL) return true; else return false;",
                    message: "Numbers only"
   		 });
              
		$("#email").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
                $("#email").validate({
			expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
			message: "Invalid email"
		});
		$("#states").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		/*$("#services").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});*/
               $("#captcha").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
		//$(".enquiry").validated(captcha_validation);
		$("#captcha").validate({
			expression: "if (VAL) return true; else return false;",
			message: "required"
		});
                
                $("#captcha").validate({
			expression: "if ((VAL == jQuery('#sec_sess').val()) && VAL) return true; else return false;",
			message: "Invalid Captcha"
		});
        $(".enquiry").validated(captcha_validation);

        
	
	
 }); 
 
 function captcha_validation(){     
    
        $("#hidden_process").css("display","block");
        document.enquiry.submit();
 }  
	
  
</script>


<style>
.red {
	color:#FF0000;
	font-size:9px
}
.button {
	color:white;
	background:url(../templates/admin/images/buttonbg.jpg) repeat-x;
	margin:0px;
	font-weight:bold;
	cursor:pointer;
	height:18px;
	border:1px solid #000000;
	font-size:11px;
	font-family: Tahoma, Arial;
}
</style>

<form name="enquiry"  class="enquiry" action="enquiry.php" method="post" _onsubmit="captcha_validation();"  >
  <table width="95%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
    <tr>
      <td><span style='color: #195C91;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    font-weight: bold;
    padding-left: 7px 0 0;'>Online Inquiry</span><br/></td>
      <td style="font-size:13px" height="35">All fields marked with <span style="color:#FF6001" >*</span> are required. <br/></td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Practice Name</span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><input name="cmp_name" type="text" size="45" id="cmp_name" class="input-box" value="<?php echo $_POST['cmp_name']  ?>" />
        &nbsp;
        <div id="errname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorcmp_name) echo "<span class='red'>$errorTextcmp_name</span>";?>
      </td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span> &nbsp;Contact Name</span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><input name="cnt_name" type="text" id="cnt_name" size="45"  class="input-box" value="<?php echo $_POST['cnt_name'];?>" />
        &nbsp;
        <div id="errcmpname" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorcnt_name) echo "<span class='red'>$errorTextcnt_name</span>";?>
      </td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Address</span> </div></td>
      <td align="left" valign="middle" ><textarea name="cnt_address" id="cnt_address" cols="45" style="height:80px !important;width:281px !important" class="input-box" rows="4"  ><?php echo $_POST['cnt_address']?></textarea>
        <div id="erraddress" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorcnt_address) echo "<span class='red'>$errorTextcnt_address</span>";?>
      </td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Suburb</span> </div></td>
      <td align="left" valign="middle" ><input name="suburb" type="text" id="suburb" size="45" class="input-box" value="<?php echo $_POST['suburb']; ?>" />
        &nbsp;
        <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?></td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Postcode</span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><input name="post_code" type="text" id="post_code" size="25" maxlength="4" class="input-box" value="<?php echo $_POST['post_code']; ?>" />
        &nbsp;
        <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?></td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;State </span> <font class="red">*</font></div>
         </td>
      <td align="left" valign="middle" ><select name="states" id="states" >
          <option value="">Select State</option>
          <option value="ACT" <?php if($_POST['states']=="ACT") echo "selected";?>>Australian Capital Territory</option>
          <option value="NSW" <?php if($_POST['states']=="NSW") echo "selected";?>>New South Wales</option>
          <option value="NT" <?php if($_POST['states']=="NT") echo "selected";?>>Northern Territory</option>
          <option value="QLD" <?php if($_POST['states']=="QLD") echo "selected";?>>Queensland</option>
          <option value="SA" <?php if($_POST['states']=="SA") echo "selected";?>>South Australia</option>
          <option value="TAS" <?php if($_POST['states']=="TAS") echo "selected";?>>Tasmania</option>
          <option value="VIC" <?php if($_POST['states']=="VIC") echo "selected";?>>Victoria</option>
          <option value="WA" <?php if($_POST['states']=="WA") echo "selected";?>>Western Australia</option>
        </select>
        &nbsp;
        <div id="errstate" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorstates) echo "<span class='red'>$errorTextstates</span>";?>
      </td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Phone number</span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><input name="phone" type="text" id="phone" size="45" class="input-box"  value="<?php echo $_POST['phone']; ?>" />
        &nbsp;
        <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php if ($errorphone) echo "<span class='red'>$errorTextphone</span>";?></td>
    </tr>
    <tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Email </span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><input name="email" type="text" id="email" size="45"  class="input-box" value="<?php echo $_POST['email']; ?>" />
        &nbsp;
        <div id="erremail" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <div id="errcheck" style="display:none; color:red; margin:0px 0px 0px 20px;">Invalid</div>
        <?php if ($errorEmail) echo "<span class='red'>$errorTextEmail</span>";?>
        <?php if ($errorinvalid && !$errorEmail) echo "<span class='red'>$errorTextinvalid</span>";?>
      </td>
    </tr>
    
    <!--tr>
      <td width="28%" height="35" align="right" valign="middle"   nowrap="nowrap"><div align="left"><span >&nbsp;Services Required</span> <font class="red">*</font></div></td>
      <td align="left" valign="middle" ><select name="services" id="services"   onchange="if(this.value=='other'){ $('#divOthers').show();}else{$('#divOthers').hide();}">
          <option value=""></option>
          <option value="Bookkeeping" <?php if($_POST['services']=="Bookkeeping") echo "selected";?>>Bookkeeping</option>
          <option value="Accounting & Tax" <?php if($_POST['services']=="Accounting & Tax") echo "selected";?>>Accounting &amp; Tax</option>
          <option value="SMSF service" <?php if($_POST['services']=="SMSF service") echo "selected";?>>SMSF service</option>
          <option value="Both" <?php if($_POST['services']=="Both") echo "selected";?>>Both</option>
          <option value="other" <?php if($_POST['services']=="other") echo "selected";?>>Other</option>
        </select>
        &nbsp;&nbsp;
        <div id="errservice" style="display:none; color:red; margin:0px 0px 0px 20px;">Required</div>
        <?php  if($errorother && !$errorservices) $style="display:block;width:104px;height:10px; white-space:nowrap"; else $style="display:none;width:104px;height:10px;white-space:nowrap "; 
if($_POST['services']=="other")
$style="display:block;width:104px;height:10px;white-space:nowrap";
else
$style="display:none;width:104px;height:10px;white-space:nowrap";
?>
        <?php //if($_POST['services']=="other") {?>
        <div id="divOthers" style="display:none"><br />
          <input name="other" type="text" id="other" class="input-box" value="<?php echo $_POST['other']; ?>" maxlength="30" />
          <br />
        </div>
        <?php if ($errorother && $_POST['services']=="other") echo "<span class='red'>$errorTextother</span>";?>
        <?php //} ?>
        <?php if ($errorservices ) echo "<span class='red'>$errorTextservices</span>";?>
      </td>
    </tr-->
    <!--tr>
      <td width="28%" height="35" align="right" valign="middle" ><div align="left"><span>&nbsp;Comments</span></div></td>
      <td align="left" valign="middle" ><textarea name="comments" id="comments"  class="input-box" cols="45" style="height:80px !important;width:281px !important" rows="4" ><?php echo $_POST['comments']?></textarea>
      </td>
    </tr-->
    <tr>
      <td width="28%" height="35" align="right" valign="middle"><div align="left"></div></td>
      <td align="left" valign="middle"><br />
         <?php 
         set_include_path($inc_path);?>
<?php include "captcha/captcha.php"; ?>
            <!-- <img src="captcha/captcha.php" class="form_captcha" /> -->
            <div><img src="images/background.png" width="130" height="45" /><span style="font-weight:bold; font-size: 22px; letter-spacing: 2px; color: #37533d; position: relative; top: -12px; left: -118px; left /*\**/: -110px\9; top /*\**/: -15px\9;"><?php echo $_SESSION['captchaval']; ?></span></div>   </td>
    </tr>
    <tr>
      <td height="35" align="right" valign="middle"><div align="left"><span>Enter the characters<br/>
          in the image above&nbsp;</span></div></td>
      <td align="left" valign="middle">
      	<input type="text" name="captcha" id="captcha" value="" class="input-box" size="45"/>
        <div id="errsecurity" style="display:none; color:red; margin:0px 0px 0px 20px;">Security code is incorrect</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"></div></td>
    </tr>
    
    
    <tr>
      <td><div align="left"></div></td>
      <td style="padding-left: 48px;"><input name="SubmitForm" type="submit" id="ctl00_ContentPlaceHolder1_Submit1" class="contact_us_submit_button" value=""
      style="background: url(images/submit.png) no-repeat left center;width:84px;height:29px;border:0px;" />
        &nbsp;&nbsp;
        <input name="reset" type="reset" class="button" value="" id="Reset1" style="border:0px;background: url(images/reset.png) no-repeat left center;width:84px;height:29px;"/>
<input type="hidden" name="sec_sess" id="sec_sess" value="<?php echo $_SESSION['captchaval']; ?>" />
<input type="hidden" name="hid_flag" id="hid_flag" value="" />
</td>
    </tr>
    <tr>
      <td><br/>
        <br></td>
    </tr>
  </table>
</form>

<div id="hidden_process" style="border: 0px solid red;
    display: none;
    height: 616px;
    left: -8px;
    position: relative;background-color: #7C7B7B;
    filter:alpha(opacity=50);
    -moz-opacity:0.5;
    -khtml-opacity: 0.5;
    opacity: 0.5;
    top: -656px;text-align: center;width:596px;padding-top: 200px;">
    <img src="images/loading_big.gif" ><br>
</div>
