<?php
session_start();
include('dbclass/commonFunctions_class.php');
//print_r($_SESSION);
//echo $_SESSION['captchaval']; 
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
.button { color:white; background:url(../templates/admin/images/buttonbg.jpg) repeat-x; margin:0px; font-weight:bold; cursor:pointer; height:18px; border:1px solid #000000; font-size:11px; font-family: Tahoma,Arial; }

</style>
    </head>
    <body>
        <form name="freequote" action="request-free-quote-mail.php" method="POST" onSubmit="return checkCaptcha()">
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
                                            <div id="errname" style="display:none; color:red; margin:0px 0px 0px 20px;"><br/>Required</div>
                                            &nbsp;
											<?php if ($errorcnt_name) echo "<span class='red'>$errorTextcnt_name</span>";?>
											</td>
                                    </tr>

                                    <tr>
                                        <td width="115" align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormCompanyNameTitleCopy_1">Company Name</span>*</td>
                                        <td width="127" align="left" valign="middle" bgcolor="#F6F6F6">

                                            <input name="cmp_name" type="text" id="cmp_name" value="<?php echo $_POST['cmp_name']  ?>" style="width: 125px;" />
                                            <div id="errcmpname" style="display:none; color:red; margin:0px 0px 0px 20px;"><br/>Required</div>
                                            &nbsp;
                                         <?php if ($errorcmp_name) echo "<span class='red'>$errorTextcmp_name</span>";?>
										 </td>

                                    </tr>
                                    <tr>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormEmailAddressTitleCopy_1">&nbsp;Email *</span></td>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <input name="email" type="text" id="email" style="width: 125px;" value="<?php echo $_POST['email']; ?>" />
                                            <div id="erremail" style="display:none; color:red; margin:0px 0px 0px 20px;"><br/>Required</div>
                                            <div id="errcheck" style="display:none; color:red; margin:0px 0px 0px 20px;"><br/>Invalid</div>
                                            &nbsp;
                                         
											<?php if ($errorEmail) echo "<span class='red'>$errorTextEmail</span>";?>
											<?php if ($errorinvalid && !$errorEmail) echo "<span class='red'>$errorTextinvalid</span>";?>
											</td>
                                    </tr>
                                    <tr>

                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <span class="ContactFormPhoneNumber1TitleCopy_1">&nbsp;Phone *</span></td>
                                        <td align="left" valign="middle" bgcolor="#F6F6F6">
                                            <input name="phone" type="text" id="phone" style="width: 125px;" onKeyUp="validatephone(this);" value="<?php echo $_POST['phone']; ?>" />
                                            <div id="errphone" style="display:none; color:red; margin:0px 0px 0px 20px;"><br/>Required</div>
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
	<option value="SMSF service" <?php if($_POST['services']=="SMSF service") echo "selected";?>>SMSF service</option>
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
                                             <!--<img src="homecaptcha/captcha.php" class="form_captcha" style="display:none;" />--> <?php 
			include "homecaptcha/captcha.php";								 
			//print_r($_SESSION); ?>
                                            <div><img src="images/background.png" width="130" height="45" /><span style="font-weight:bold; font-size: 22px; letter-spacing: 2px; color: #37533d; position: relative; top: -32px; left: 18px; left /*\**/: -110px\9; top /*\**/: -15px\9;"><?php echo $_SESSION['captchaval']; ?></span></div>
                                        </td>
                                    </tr>
                                     <tr>
                                     <td align="left" valign="middle" bgcolor="#F6F6F6" style="font-size:11px;">Enter the Characters in the image above</td>
                                     <td align="left" valign="middle" bgcolor="#F6F6F6">
                                         <input type="text" name="captcha" id="captcha" value="" class="captcha" style="width: 125px;"/>
                                         <div id="errsecurity" style="display:none; color:red;"><br/>Required Security code</div>
                                         <input type="hidden" name="sec_sess" value="<?php echo $_SESSION['captchaval']; ?>" />
                                         
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
