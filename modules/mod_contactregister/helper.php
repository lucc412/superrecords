<?php

class modContactRegisterHelper
{
	
	protected $fromEmail= '';
	
	public function initialize($params) 
	{
		$this->admin_email =  $params->get('admin-email');
		/*$this->cc =           $params->get('cc-email');
		$this->bcc =          $params->get('bcc-email');*/
		$this->subject =      $params->get('subject');
		$this->thankmsg =     'Thank You';
		$this->session =& JFactory::getSession();
		return $this;
	}
	
	function process_si_contact_form()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
	        // if the form has been submitted

	        foreach($_POST as $key => $value) {
		      if (!is_array($key)) {
		      	// sanitize the input data
		        if ($key != 'Message') $value = strip_tags($value);
		        $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
		      }
		    }
			
	        $name    = $_POST['Name'];        // name from the form
	        $email   = @$_POST['Email'];   // email from the form
	        $phone = @$_POST['Telephone']; // the Telephone from the form
	        $message = @$_POST['Message']; // the message from the form
	        $captcha = @$_POST['ct_captcha']; // the user's entry for the captcha code
	        $name    = substr($name, 0, 64);  // limit name to 64 characters
	
			$flagSubmit = TRUE;

	        // Only try to validate the captcha if the form has no errors
	        // This is especially important for ajax calls
	        if ($flagSubmit) {
				require_once dirname(__FILE__) .DS.'tmpl/securimage/securimage.php';
				$securimage = new Securimage();
				
				if ($securimage->check($captcha) == false) {
	                //$errors = 'Invalid Code Entered';
					$flagSubmit = FALSE;
	            }
	        }

	        if ($flagSubmit) {
	            // no errors, send the form
				$from = "noreply@superrecords.com.au";
	            $message = "An enquiry has been submitted from <a>www.superrecords.com.au</a>.<br /><br />"
	                     . "Full Name: $name<br />"
	                     . "Email: $email<br />"
	                     . "Telephone: $phone<br />"
	                     . "Comments: $message<br />"
	                     . "IP Address: {$_SERVER['REMOTE_ADDR']}";

	            $headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'To:'.$this->admin_email.'' . "\r\n";
				$headers .= 'From:'.$from.''. "\r\n";
					
				// mail functionality	
				$mail_status = mail($this->admin_email, $this->subject, $message, $headers);
				
					
	        }
			return $flagSubmit;
	    } 
	} 
	// function process_si_contact_form() ends
	public function thankyouMessage(){
	
	
	 $msg = "Thank You";

	return $msg;
	
	}
	
}

?>