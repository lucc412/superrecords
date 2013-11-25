<?php
	
	
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	jimport( 'joomla.filesystem.file' );
	// Include the syndicate functions only once
	require_once( dirname(__FILE__).DS.'helper.php' );
	$contacthandler = new modContactRegisterHelper();
	$session =& JFactory::getSession();
	
	$result = $contacthandler->initialize($params);
	 		
	if(isset($_POST) && !empty($_POST))
	{
		// check Captcha and Mail Functionality
		$cCheck = $contacthandler->process_si_contact_form();
		$app =& JFactory::getApplication();
		
		if($cCheck)
		{
			$thankmsg = $contacthandler->thankyouMessage();
			$url = 'thank-you-page.html';
			$app->redirect($url,$thankmsg);
		
		}else{
			
			$capMsg = "Invalid Code Entered";
			$url = 'index.php';
			$_REQUEST['hidMsg'] = 'Y';
		}
	}

	require( JModuleHelper::getLayoutPath( 'mod_contactregister' ) );

?>


