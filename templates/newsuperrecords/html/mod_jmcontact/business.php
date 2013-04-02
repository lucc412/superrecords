<?php
/*------------------------------------------------------------------------
# mod_jmcontact - JM contact Module
# ------------------------------------------------------------------------
# author    JM-Experts.com
# copyright Copyright (C) 2011 JM-Experts.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
echo '<!-- JM Contact Module by JM-Experts.com Starts -->';
$document = &JFactory::getDocument();
require_once(dirname(__FILE__).DS.'element/recaptchalib.php');
$publickey = $params->get('public');
$privatekey= $params->get('private');
$error='';
 JHTMLBehavior::formvalidation(); 
	$enablecap = $params->get('enablecap');
//$document->addScript(JURI::root() .'modules/mod_jmcontact/tmpl/element/jquery.min.js');
$exist_url = JURI::root();
$stylesheeturl = $exist_url.'modules/mod_jmcontact/tmpl/css/styles.css';
$document->addStyleSheet($stylesheeturl);

$document->addCustomTag('<script type="text/javascript">

   function checkcapcha(josForm){
   
    if (!document.formvalidator.isValid(josForm)) {
     
       return false;
   }
  
  
  if ('.$enablecap.'){
        var chell=   document.getElementById("recaptcha_challenge_field").value;

       var resp = document.getElementById("recaptcha_response_field").value ;
       var prikey = "'.$privatekey.'";
       document.getElementById("myDiv").innerHTML="";


var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();

  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {

  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
                            var responss = xmlhttp.responseText;
                            //alert (responss);
                             if(responss =="false2"){
                                       document.getElementById("myDiv").innerHTML= "'.JText::_( 'Invalid Private Key').'" ;
                                    }else{
                                       if(responss == "true" ) 
									   {
											document.josForm.submit();
                                                      }
													  else   { document.getElementById("myDiv").innerHTML= "'.JText::_( 'Invalid Captcha').'" ;
                                                                Recaptcha.reload ();
                                    }
                                    }
    }else  document.getElementById("myDiv").innerHTML= "<img src=\"'.$exist_url.'modules/mod_jmcontact/tmpl/element/loads.gif\" border=\"0\">" ;
  }

xmlhttp.open("GET","'.$exist_url.'modules/mod_jmcontact/tmpl/element/captchacheck.php?field1="+chell+"&field2="+resp+"&field3="+prikey,true);
xmlhttp.send();

   return false;
 }
}

function validation()
{
	var name = document.getElementById("Name").value;
	var email =document.getElementById("Email").value;
	var phone = document.getElementById("Telephone").value;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if(name == "")
	{
		alert("Please specify Name");
		document.getElementById("Name").focus();
		return false;
	}
	else if(email == "")
	{
		alert("Please specify Email Address");
		document.getElementById("Email").focus();
		return false;
	}
	else if(reg.test(email) == false)
	{
        alert("Please specify valid Email Address");
		document.getElementById("Email").focus();
		return false;
	}
	else if(phone == "")
	{
		alert("Please specify Phone Number");
		document.getElementById("Telephone").focus();
		return false;
	}
	else if((isNaN(phone)))
	{
		alert("Please specify Phone Number in digits only");
		document.getElementById("Telephone").value="";
		document.getElementById("Telephone").focus();
		return false;
	}
	else
	{
		
		return true;
	}
}
</script>');

function jm_getthem($params)
{
		switch ($params->get('jmtheme'))
		{
			case '0':
				return 'red';
				break;
			case '1':
				return 'white';
				break;
			case '2':
				return 'blackglass';
				break;
			case '3':
				return 'clean';
				break;
		}
}

?>

<div class="<?php echo $params->get('moduleclass_sfx');?>" id="jmcontactform">
<div class="ptext"><?php echo $params->get('pretext') ;  ?></div>
<div><?php echo $msg;   ?></div>
<h1 class="title">Learn More</h1>
<form method="post" action="" name="josForm"  id="myForm" class="form-validate" enctype="multipart/form-data"  onSubmit="return validation()" >
	
	<!-- Name -->
	<?php  if ($params->get('bnamestatus') == 'Y' || $params->get('bnamestatus') == 'R' ) : ?>
		<div class="formrow">
			<!--<div class="row_inner" id="label"><?php  echo $result->namelbl; ?>:</div>-->
			<div class="row_inner" id="input">
			<input type="text" name="Name" id="Name" title="Enter Name" value="" class="inputbox cleardefault <?php  if($params->get('bnamestatus') == 'R' ) echo '';  ?>" /></div>
		</div>
	<?php endif; ?>
	<!-- Name Ends-->
	<!-- Company -->
	<?php  if ($params->get('bcompanystatus') == 'Y' || $params->get('bcompanystatus') == 'R') : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->companylbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Company" id="Company" value=""  class="inputbox <?php  if($params->get('bcompanystatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Company ends -->

	<!-- Phone -->
	<?php  if ($params->get('bphonestatus') == 'Y' || $params->get('bphonestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->phonelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Phone" id="Phone" value="" class="inputbox <?php  if($params->get('bphonestatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Phone ends -->
	
	<!-- Email Starts -->
	<?php  if($params->get('bEmail') == 'Y' || $params->get('bEmail') == 'R') : ?>
		<div class="formrow">
			<!--<div class="row_inner" id="label"><?php  echo $result->Emaillbl; ?>:</div>-->
			<div class="row_inner" id="input"><input  type="text" name="Email" id="Email" class="inputbox <?php  if($params->get('bEmail') == 'R' ) echo '';  ?>" title="Enter Email Address" value="" /></div>
		</div>
	<?php endif;  ?>
	<!-- Email ends -->
	
	
	<!-- Mobile -->
	<?php  if ($params->get('bmobilestatus') == 'Y' || $params->get('bmobilestatus') == 'R' ) : ?>
		<div class="formrow">
			<!--<div class="row_inner" id="label"><?php  echo $result->mobilelbl; ?>:</div>-->
			<div class="row_inner" id="input"><input  type="text" name="Mobile" id="Telephone" title="Enter Phone Number" value="" class="inputbox <?php  if($params->get('bmobilestatus') == 'R' ) echo 'validate-numeric';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Mobile Ends -->
		
	<!-- Website -->
	<?php  if ($params->get('bwebsitestatus') == 'Y' || $params->get('bwebsitestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->websitelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Website" id="Website" value="" class="inputbox <?php  if($params->get('bwebsitestatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Website Ends-->

	<!-- custom Field first -->
	<?php  if ($params->get('customfieldfirst_status') == 'Y' || $params->get('customfieldfirst_status') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $params->get('customfieldfirst'); ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="customfieldfirst" id="customfieldfirst" value="" class="inputbox <?php  if($params->get('customfieldfirst_status') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- custom Field First end -->

	<!-- custom Field Second -->
	<?php  if ($params->get('customfieldsecond_status') == 'Y' || $params->get('customfieldsecond_status') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $params->get('customfieldsecond'); ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="customfieldsecond" id="customfieldsecond" value="" class="inputbox <?php  if($params->get('customfieldsecond_status') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- custom Field Second end -->
	<!-- Mesage -->
	<?php  if ($params->get('bmessagestatus') == 'Y' || $params->get('bmessagestatus') == 'R' ) : ?>
		<div class="formrow">
			<!--<div class="row_inner" id="label"><?php  echo $result->messagelbl; ?>:</div>-->
			<div class="row_inner" id="input">
			<textarea title="Enter comments" name="Message" id="Message" class="inputbox <?php  if($params->get('bmessagestatus') == 'R' ) echo 'required';  ?>" cols="20" rows="4"></textarea></div>
		</div>
	<?php  endif; ?>
	<!-- Mesage Ends-->
	<!-- Upload -->

	<?php  if ($params->get('bfilelbl_required') == 'Y' || $params->get('bfilelbl_required') == 'R') : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->filelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="file" name="form_upload" id="form_upload" value="" class="inputbox <?php  if($params->get('bfilelbl_required') == 'R' ) echo 'required';  ?>"  /></div>
		</div>
		<?php  endif; ?>
	<!-- Ipload Ends -->
	<!-- captcha -->
	 <?php
		 if ($params->get('enablecap') ) :
		 echo '<div class="formrow"><div class="row_inner" id="label">Captcha:</div><div class="row_inner" id="input">';
			  if($publickey && $privatekey):
							$theme= jm_getthem($params);

							echo recaptcha_get_html($publickey, $error, $theme);
							echo'<div style="height:130px; margin:0px; padding0px;"> </div>';
			  else: echo '<div style="color:red;font-weight:bold; margin:0px; padding0px;">'.JText::_( 'Enter a valid Recaptcha Public and Private key.').'</div>';
			  endif;
			 echo '</div></div>';

		 endif; ?><br> 
		<div class="formrow"><div id="myDiv" style="color: #CF1919;  font-weight: bold;   margin: 0 0 0 20px;   padding: 0 0 0 20px; "></div></div>
	<!-- captcha -->
	<!-- copy me -->

	<?php  if ($params->get('copymestatus') == 'Y' && ($params->get('bEmail') == 'Y' || $params->get('bEmail') == 'R')) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php   echo  $result->copymelabel ?></div>
			<div class="row_inner" id="input"><input type="checkbox" name="copyMe" id="copyMe" value="1" /></div>
		</div>
	<?php  endif; ?>
	<!-- copy me ends -->

	<!-- Send & Reset button -->
		<div class="formrow" id="submit">	
			<?php
			if ($params->get('Reset_button') == 'Y' ) :
			?>
			<div class="row_inner" id="label"><input type="reset" name="Clear" id="Clear" value="Reset" class="button" /></div>
			<?php  endif; ?>
			<div class="row_inner" id="input"><input type="hidden" name="chkpost" value="1" />
			<button type="submit" value="submit" name="send" id="send">Submit</button></div>
		</div>
	<!-- Send & Reset button Ends -->




</form>
<div class="ptext"><?php echo $params->get('PostText') ;  ?></div>

</div>
<script language="javascript">
function myValidate() {
  
}
</script>
<!-- JM Contact Module by JM-Experts.com Ends -->