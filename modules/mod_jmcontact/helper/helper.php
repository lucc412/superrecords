<?php
/*------------------------------------------------------------------------
# mod_jmcontact - JM contact Module
# ------------------------------------------------------------------------
# author    JM-Experts.com
# copyright Copyright (C) 2011 JM-Experts.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
class _joomform {
	public $to 			= array();
	
	public $cc 			= '';
	public $bcc 		= '';
	public $replyTo 	= '';
	public $attachment 	= '';
	public $subject 	= '';
	public $subjectlabel = '';
	public $Reset_button = '';
	public $body 		= '';
	public $dir 		= '';
	public $copyMe 		= '';
	public $error 		= '';
	public $copymelabel = '';
	public $namelbl    =    '';
	public $companylbl  =    '';
	public $phonelbl  =    '';
	public $websitelbl  =    '';
	public $messagelbl  =    '';
	public $filelbl  =    '';
	public $mobilelbl  =    '';
	public $Emaillbl  =    '';
	public $thankmsg = '';
}

class modjoomEmailForm {

	public $_obj			= '';
	protected $fromEmail 		= '';
	protected $_Classsfx = '';
	var $copyfile = '';
	var $message = '';
	var $attachment = '';
	public function initialise($params) 
	{
		$this->_obj 		 		= new _joomform();
		
	$this->_obj->cc =           $params->get('emailCC');
	$this->_obj->bcc =          $params->get('emailBCC');
	$this->_obj->namelbl =      $params->get('namelbl');
	$this->_obj->companylbl =   $params->get('companylbl');
	$this->_obj->phonelbl =     $params->get('phonelbl');
	$this->_obj->websitelbl =   $params->get('websitelbl');
	$this->_obj->messagelbl =   $params->get('messagelbl');
	$this->_obj->filelbl =      $params->get('filelbl');
	$this->_obj->mobilelbl =    $params->get('mobilelbl');
	$this->_obj->copymelabel =  $params->get('copymelabel');
	$this->_obj->subjectlabel = $params->get('subjectlabel');
	$this->_obj->to =           $params->get('emailTo');
	$this->_obj->Emaillbl =     $params->get('Emaillbl');
	$this->_obj->thankmsg =     $params->get('thankmsg');
		// Get XML params
		$this->_Classsfx 		= $params->get('moduleclass_sfx');
		
		
			
		$this->_obj->dir = upload_DIR .DIRECTORY_SEPARATOR .'upload'.DIRECTORY_SEPARATOR;
		return $this->_obj;
	}
	
	public function uploadAttachment()
	{
		
		//$result  = FALSE;
		//print_r($_FILES);
		// Capture filename
		 $fn = (isset($_FILES['form_upload']['name'])) ? basename(strip_tags($_FILES['form_upload']['name'])) : '';
		// use regex to check for allowed filenames
		if ($fn) {
		
		$componentParams = &JComponentHelper::getParams('com_media');
		$allowedExt1 = $componentParams->get('upload_extensions');
			
			 $allowedExt = explode(',',$allowedExt1);
			  $ext = strtoupper(strrchr($fn,'.'));
			
			if(1) {
			
				// Check to see if upload parameter specified
				if ( $_FILES['form_upload']['error'] == UPLOAD_ERR_OK ) {
					// Check to make sure file uploaded by upload process
					if ( is_uploaded_file ($_FILES['form_upload']['tmp_name'] ) ) {
						// Set filename to current directory
						$this->copyfile = $this->_obj->dir . time().$fn;
						// Copy file
						if ( move_uploaded_file ($_FILES['form_upload']['tmp_name'], $this->copyfile) ) {
							// Save name of file
							
							$result = $fn;
						} else {
							// Trap upload file handle errors
							$this->message = 'unable to upload file';
							return false;
						}
					} 
					else {
						// Failed security check
						$this->message = 'upload failure';
						return false;
					}
				} else
				{
				return false;
				}
			} 
			else {
				// Failed regex
				$this->message = 'Invalid file type';
				return false;
			}
		} 
		else {
			return false;
		}
		return true;
	}

	
	function _sendmail(){
	
		$this->fromEmail = (isset($_POST['Email'])) ?  $_POST['Email'] : '';
			
			
		$this->_obj->subject = $this->_obj->subjectlabel;
		
		$this->_obj->body =  'From: ' . $this->fromEmail;
		
		$this->_obj->body .= (isset($_POST['Name']))    ? "\n" .$this->_obj->namelbl .': ' . htmlspecialchars($_POST['Name']) : "";
		
		$this->_obj->body .= (isset($_POST['Company']))    ? "\n" .$this->_obj->companylbl .': ' . htmlspecialchars($_POST['Company']) : "";
		
		$this->_obj->body .= (isset($_POST['Phone']))    ? "\n" . $this->_obj->phonelbl .': ' . htmlspecialchars($_POST['Phone']) : "";
		
		$this->_obj->body .= (isset($_POST['Mobile']))    ? "\n" . $this->_obj->mobilelbl .': ' . htmlspecialchars($_POST['Mobile']) : "";
		
		$this->_obj->body .= (isset($_POST['Website']))    ? "\n" .$this->_obj->websitelbl .': ' . htmlspecialchars($_POST['Website']) : "";
		
		$this->_obj->body .= (isset($_POST['Message']))  ? "\n" .$this->_obj->messagelbl . ":\n" . htmlspecialchars($_POST['Message']) : "";
		
		//Get Client IP Address
		$remoteHost = $_SERVER['REMOTE_ADDR'];
		$this->_obj->body .= "\n" .'IP Address:' .$remoteHost ;
		
		// Strip slashes
		$this->_obj->body = stripslashes($this->_obj->body);
		
		// Filter for \n in subject
		$this->_obj->subject = str_replace("\n",'',$this->_obj->subject);
		
		
		
		// Send mail
		$message =& JFactory::getMailer();
		//echo $
		$message->addRecipient($this->_obj->to);
		$message->setSender($this->fromEmail);
		$message->setSubject($this->_obj->subject);
		$message->setBody($this->_obj->body);
		
		if ($this->_obj->cc) 				{ $message->addCC($this->_obj->cc); }
		if ($this->_obj->bcc) 				{ $message->addBCC($this->_obj->bcc); }
		
		if ($this->uploadAttachment()) { 
			// Formulate FN for attachment
			
			$message->addAttachment($this->copyfile); 
		}
		try {
			$sent = $message->send();
			$this->message = 'Email sent';
			$this->_obj->copyMe = (isset($_POST['copyMe'])) ? (int) $_POST['copyMe'] : 0;
			
			if ($this->_obj->copyMe) { 
				$message->ClearAllRecipients();
				$message->addRecipient($this->fromEmail);
				$sent = $message->send();
			}
			$result = TRUE;
		} catch (Exception $e) {
			$result = FALSE;
			$this->message = 'Failed to sending mail';
		}
		
		
		
		return $result;
	
	
	
	
	}
	public function formatErrorMessage($color='red')
	{
		
			$message = $this->message;
		
			return $message;
	}
	public function thankyouMessage(){
	
	
	 $msg = $this->_obj->thankmsg;

	return $msg;
	
	}
	
	
	
	
}	