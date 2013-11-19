<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8" />
        <title>
            PHP contact form script with reCaptcha
        </title>
        <meta name="author" content="Chris Planeta">
        <link rel="stylesheet" href="style/base.css" media="screen" />
    </head>
	<body>
		<?php
		// Script for the form has been downloaded from http://chrisplaneta.com/freebies/php_contact_form_script_with_recaptcha/

		//If the form is submitted:
		if(isset($_POST['submitted'])) {

		//load recaptcha file
		require_once('captcha/recaptchalib.php');

		//enter your recaptcha private key
		$privatekey = "6LcK7uASAAAAAFVgu8kA2JjI59ENHgxWuc0oilz9";
			
			//check recaptcha fields
			$resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);


			//Check to see if the invisible field has been filled in
			if(trim($_POST['checking']) !== '') {
				$blindError = true;
			} else {
				
				//Check to make sure that a contact name has been entered	
				$authorName = (filter_var($_POST['formAuthor'], FILTER_SANITIZE_STRING));
				if ($authorName == ""){
					$authorError = true;
					$hasError = true;
				}else{
					$formAuthor = $authorName;
				};
				
				
				//Check to make sure sure that a valid email address is submitted
				$authorEmail = (filter_var($_POST['formEmail'], FILTER_SANITIZE_EMAIL));
				if (!(filter_var($authorEmail, FILTER_VALIDATE_EMAIL))){
					$emailError = true;
					$hasError = true;
				} else{
					$formEmail = $authorEmail;
				};
					
				//Check to make sure the subject of the message has been entered
				$msgSubject = (filter_var($_POST['formSubject'], FILTER_SANITIZE_STRING));
				if ($msgSubject == ""){
					$subjectError = true;
					$hasError = true;
				}else{
					$formSubject = $msgSubject;
				};
				
				//Check to make sure content has been entered
				$msgContent = (filter_var($_POST['formContent'], FILTER_SANITIZE_STRING));
				if ($msgContent == ""){
					$commentError = true;
					$hasError = true;
				}else{
					$formContent = $msgContent;
				};
				
				// if all the fields have been entered correctly and there are no recaptcha errors build an email message
				if (($resp->is_valid) && (!isset($hasError))) {
					$emailTo = 'yourEmail@address.com'; // here you must enter the email address you want the email sent to
					$subject = 'A new message from: ' . $formAuthor . ' | ' . $formSubject; // This is how the subject of the email will look like
					$body = "Email: $formEmail \n\nContent: $formContent  \n\n$formAuthor"; // This is the body of the email
					$headers = 'From: <'.$formEmail.'>' . "\r\n" . 'Reply-To: ' . $formEmail . "\r\n" . 'Return-Path: ' . $formEmail; // Email headers
					
					//send email
					mail($emailTo, $subject, $body, $headers);
					
					// set a variable that confirms that an email has been sent
					$emailSent = true;
				}
				
				// if there are errors in captcha fields set an error variable
				if (!($resp->is_valid)){
					$captchaErrorMsg = true;
				}
			}
		} ?>
						
		<?php // if the page the variable "email sent" is set to true show confirmation instead of the form ?>
		<?php if(isset($emailSent) && $emailSent == true) { ?>
			<p>
				Your email was successfully sent. I check my inbox all the time, so I should be in touch soon. 
			</p>
		<?php } else { ?>
		<?php // if there are errors in the form show a message ?>
			<?php if(isset($hasError) || isset($blindError)) { ?>
				<p>There was an error submitting the form. Please check all the marked fields.</p>
			<?php } ?>
			<?php // if there are recaptcha errors show a message ?>
			<?php if ($captchaErrorMsg){ ?>	
				<p>Captcha error. Please, type the check-words again.</p>
			<?php } ?>
			<?php 
			// here, you set what the recaptcha module should look like
			// possible options: red, white, blackglass and clean
			// more infor on customisation can be found here: http://code.google.com/intl/pl-PL/apis/recaptcha/docs/customization.html
			?>
			<script type="text/javascript">
				var RecaptchaOptions = {
					theme : 'clean'
				};
			</script>
			<?php
			// this is where the form starts
			// action attribute should contain url of the page with this form
			// more on that you can read here: http://www.w3schools.com/TAGS/att_form_action.asp
			?>
			<form id="contactForm" action="" method="post">
				<div id="singleParagraphInputs">
					<div>
						<label for="formAuthor">
							Name
						</label>
						<input class="requiredField <?php if($authorError) { echo 'formError'; } ?>" type="text" name="formAuthor" id="formAuthor" value="<?php if(isset($_POST['formAuthor']))  echo $_POST['formAuthor'];?>" size="40" />
					</div>
					<div>
						<label for="formEmail">
							Email
						</label>
						<input class="requiredField <?php if($emailError) { echo 'formError'; } ?>" type="text" name="formEmail" id="formEmail" value="<?php if(isset($_POST['formEmail']))  echo $_POST['formEmail'];?>" size="40" />
					</div>
					<div>
						<label for="formSubject">
							Subject
						</label>
						<input class="requiredField <?php if($subjectError) { echo 'formError'; } ?>" type="text" name="formSubject" id="formSubject" value="<?php if(isset($_POST['formSubject']))  echo $_POST['formSubject'];?>" size="40" />
					</div>
				</div>
				<div id="commentTxt">
					<label for="formContent">
						Message
					</label>
					<textarea class="requiredField <?php if($commentError) { echo 'formError'; } ?>" id="formContent" name="formContent" cols="40" rows="5"><?php if(isset($_POST['formContent'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['formContent']); } else { echo $_POST['formContent']; } } ?></textarea>
					<?php 
					// this field is visible only to robots and screenreaders
					// if it is filled in it means that a human hasn't submitted this form thus it will be rejected
					?>
					<div id="screenReader">
						<label for="checking">
							If you want to submit this form, do not enter anything in this field
						</label>
						<input type="text" name="checking" id="checking" value="<?php if(isset($_POST['checking']))  echo $_POST['checking'];?>" />
					</div>
				</div>
				<?php
					// load recaptcha file
					require_once('captcha/recaptchalib.php');
					// enter your public key
					$publickey = "6LcK7uASAAAAAO6BBBRWKL_n-W6Mc0hidIrEtyZG";
					// display recaptcha test fields
					echo recaptcha_get_html($publickey);
				?>
				<input type="hidden" name="submitted" id="submitted" value="true" />
				<?php // submit button ?>
				<input type="submit" value="Send Message" tabindex="5" id="submit" name="submit">
			</form>
		<?php } // yay! that's all folks! ?>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.js">
		</script>
        <script src="js/custom.js" type="text/javascript">
		</script>
	</body>
</html>
