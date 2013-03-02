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
													  else   { document.getElementById("myDiv").innerHTML= "'.JText::_( 'MOD_JMCONTACT_RECAPTCHA_INVALIDE').'" ;
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
<form method="post" action="" name="josForm"  id="myForm" class="form-validate" enctype="multipart/form-data"  onSubmit=" return checkcapcha(this);" >
	<!-- Email Starts -->
	<?php  if($params->get('Email') == 'Y' || $params->get('Email') == 'R') : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->Emaillbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Email" id="email" class="inputbox <?php  if($params->get('Email') == 'R' ) echo 'required validate-email';  ?>" value="" /></div>
		</div>
	<?php endif;  ?>
	<!-- Email ends -->

	<!-- Name -->
	<?php  if ($params->get('namestatus') == 'Y' || $params->get('namestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->namelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Name" id="Name" value="" class="inputbox <?php  if($params->get('namestatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php endif; ?>
	<!-- Name ends -->
	
	<!-- Company -->
	<?php  if ($params->get('companystatus') == 'Y' || $params->get('companystatus') == 'R') : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->companylbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Company" id="Company" value=""  class="inputbox <?php  if($params->get('companystatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Company ends -->
	
	<!-- Phone -->
	<?php  if ($params->get('phonestatus') == 'Y' || $params->get('phonestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->phonelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Phone" id="Phone" value="" class="inputbox <?php  if($params->get('phonestatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Phone Ends -->
	
	<!-- Mobile -->
	<?php  if ($params->get('mobilestatus') == 'Y' || $params->get('mobilestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->mobilelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Mobile" id="Mobile" value="" class="inputbox <?php  if($params->get('mobilestatus') == 'R' ) echo 'required validate-numeric';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Mobile ends -->

	<!-- Website -->
	<?php  if ($params->get('websitestatus') == 'Y' || $params->get('websitestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->websitelbl; ?>:</div>
			<div class="row_inner" id="input"><input type="text" name="Website" id="Website" value="" class="inputbox <?php  if($params->get('websitestatus') == 'R' ) echo 'required';  ?>" /></div>
		</div>
	<?php  endif; ?>
	<!-- Website Ends -->

	<!-- Message -->
	<?php  if ($params->get('messagestatus') == 'Y' || $params->get('messagestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="label"><?php  echo $result->messagelbl; ?>:</div>
			<div class="row_inner" id="input"><textarea cols="20" rows="4" name="Message" id="Message" class="inputbox <?php  if($params->get('messagestatus') == 'R' ) echo 'required';  ?>" ></textarea></div>
		</div>
	<?php  endif; ?>
	<!-- Message ends -->

	<!-- File Upload -->
		<?php  if ($params->get('filelbl_required') == 'Y' || $params->get('filelbl_required') == 'R') : ?>
<div class="formrow">

			
		<div class="row_inner" id="label"><?php  echo $result->filelbl; ?>:</div>
		<div class="row_inner" id="input"><input type="file" name="form_upload" id="form_upload" value="" class="inputbox <?php  if($params->get('filelbl_required') == 'R' ) echo 'required';  ?>" /></div>
	
</div>
	<?php  endif; ?>
	<!-- File Upload ends -->

	<!-- Recaptcha -->
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
	 endif; ?>
	<div class="formrow"><div id="myDiv" style="color: #CF1919;  font-weight: bold;   margin: 0 0 0 20px;   padding: 0 0 0 20px; "></div></div>
	<!-- Recaptcha ends -->
	
	<!-- Copy Me -->
	<?php  if ($params->get('copymestatus') == 'Y' && ($params->get('Email') == 'Y' || $params->get('Email') == 'R')) : ?>
		<div class="formrow" id="submit">
				<div class="row_inner" id="label"><?php   echo  $result->copymelabel ?></div>
				<div class="row_inner" id="input"><input type="checkbox" name="copyMe" id="copyMe" value="1" /></div>
		</div>
	<?php  endif; ?>
	<!-- Copy Me Ends -->
		
	<!-- Send & Reset button -->
	<div class="formrow" id="submit">	
		<?php
			if ($params->get('Reset_button') == 'Y' ) :
		?>
			<div class="row_inner" id="label">
				<input type="reset" name="Clear" id="Clear" value="Reset" class="button"/>
			</div>
		<?php  endif; ?>
		<div class="row_inner" id="input"><input type="hidden" name="chkpost" value="1" /><input type="submit" name="send" id="send" value="submit" class="button" />
		</div>
	</div>
	<!-- Send & Reset button Ends -->

	<div class="ptext"><?php echo $params->get('PostText') ;  ?></div>
</div>
</form>



<script language="javascript">
function myValidate() {
  
}
</script>
<!-- JM Contact Module by JM-Experts.com Ends -->