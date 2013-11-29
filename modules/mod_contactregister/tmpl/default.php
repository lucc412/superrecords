<?php 
	
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' ); 
	
	JHTMLBehavior::formvalidation(); 
	$enablecap = $params->get('captchastatus');
	
	$document = &JFactory::getDocument();
	$document->addCustomTag('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>');
	$document->addScript(JURI::root() .'modules/mod_contactregister/tmpl/securimage/js/contactregister.js');
	$exist_url = JURI::root();
	
?>

<div class="quicklink" id="jmcontactform" style="height: 335px;">
<h1 class="title">Free Trial</h1>
<form method="post" action="" name="josForm"  id="myForm" class="form-validate" enctype="multipart/form-data"  onSubmit="return validation()" >
	<input type="hidden" name="hidMsg" id="hidMsg" value="N" />
	
	
	<!-- Name -->
		<div class="formrow">
			<div class="row_inner" id="input"><input type="text" name="Name" id="Name" value="<?php if(isset($_REQUEST['Name'])){echo $_REQUEST['Name'];}else{ echo 'Full Name *';}?>" class="inputbox" onfocus="clearText(this)" onblur="if(this.value == '') { this.value = 'Full Name *'; }" /></div>
		</div>
	<!-- Name ends -->

	<!-- Email Starts -->
		<div class="formrow">
			<div class="row_inner" id="input"><input type="text" name="Email" id="Email" class="inputbox" value="<?php if(isset($_REQUEST['Email'])){echo $_REQUEST['Email'];}else{ echo 'Email *';}?>"  onfocus="clearText(this)" onblur="if(this.value == '') { this.value = 'Email *'; }"/></div>
		</div>
	<!-- Email ends -->
	
	<!-- Phone -->
		<div class="formrow">
			<div class="row_inner" id="input"><input type="text" name="Telephone" id="Telephone" value="<?php if(isset($_REQUEST['Telephone'])){echo $_REQUEST['Telephone'];}else{ echo 'Telephone *';}?>" class="inputbox"  onfocus="clearText(this)" onblur="if(this.value == '') { this.value = 'Telephone *'; }"/></div>
		</div>
	<!-- Phone Ends -->

	<!-- Message -->
	<?php  //if ($params->get('messagestatus') == 'Y' || $params->get('messagestatus') == 'R' ) : ?>
		<div class="formrow">
			<div class="row_inner" id="input">
				<textarea cols="20" rows="2" style="height:25px;" name="Message" id="Message" class="inputbox" rows="4" cols="20" placeholder="<?php if(isset($_REQUEST['Message'])){echo $_REQUEST['Message'];}else{ echo 'Comments';}?>" ></textarea>
			</div>
		</div>
	<?php  //endif; ?>
	<!-- Message ends -->

	<!-- Recaptcha -->
	 <?php
	 if ($params->get('captchastatus') ){
	 	?><div class="formrow">
			<div class="row_inner" id="input">
				<img id="siimage" style="border: 1px solid #CCC; margin-right: 15px; border-radius: 4px; height:25px; width:140px; padding: 8px;" src="<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
				<div style="padding: 2px;height: auto;width: auto;position: relative;margin-top: 3px;">
					<object type="application/x-shockwave-flash" data="<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/images/audio_icon.png&amp;audio_file=<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/securimage_play.php" height="18" width="18">
					<param name="movie" value="<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/images/audio_icon.png&amp;audio_file=./securimage_play.php" />
					</object>
					&nbsp;
					<a tabindex="-1" style="border-style: none;background:none;right: 2px;top: 55%;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?=$exist_url?>modules/mod_contactregister/tmpl/securimage/images/refresh.png" alt="Reload Image" height="18" width="18" onclick="this.blur()" align="bottom" border="0" /></a>
					<br />
				</div>
				<input type="text" class="inputbox" style="margin-top: 5px; width:180px; margin-bottom: 0px" id="ct_captcha" name="ct_captcha" size="12" maxlength="8" value="<?php if(isset($_REQUEST['ct_captcha'])){echo $_REQUEST['ct_captcha'];}else{ echo 'Enter Code *';}?>"  onfocus="clearText(this)" onblur="if(this.value == '') { this.value = 'Enter Code *'; }"/>
				<span style="color:red; font-size:11px; font-weight: normal;"><? if(isset($_REQUEST['hidMsg']) && $_REQUEST['hidMsg'] == 'Y') echo '<script>document.getElementById("ct_captcha").className = "errclass";</script>';?></span>
			</div>
		  </div><?
	} ?>
	
	
	<!-- Recaptcha ends -->
	
	<!-- Send button -->
	<div class="formrow" id="submit">	
		<div class="row_inner" id="input">
			<button type="submit" value="submit" name="send" id="send">Submit</button>
		</div>
	</div>
	<!-- Send button Ends -->

	

</form>
</div>


<script language="javascript">
function myValidate() {
  
}
</script>
