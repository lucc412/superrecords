<?php
/*------------------------------------------------------------------------
# mod_jmcontact - JM contact Module
# ------------------------------------------------------------------------
# author    JM-Experts.com
# copyright Copyright (C) 2011 JM-Experts.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
// no direct access
	defined('_JEXEC') or die('Restricted access');


	jimport( 'joomla.filesystem.file' );
// current directory constant
	define('upload_DIR', dirname(__FILE__));
	
	// Include the syndicate functions only once
	if($params->get('layout') == 'default'){
require_once( upload_DIR . DIRECTORY_SEPARATOR . 'helper'. DIRECTORY_SEPARATOR .'helper.php' );

	$msg = '';
	$form = new modjoomEmailForm();
	$objFORM = new _joomform();
	$result = $form->initialise($params);
	
	if(isset($_POST['chkpost'])){
	$res = $form->_sendmail();
	if($res){
	$thankmsg = $form->thankyouMessage();

	$app =& JFactory::getApplication();
	//echo $url;redirect
		 $url = $params->get('redirecturl');
		
		$app->redirect($url,$thankmsg);
	}
	else
	$msg = $form->formatErrorMessage();
	}
}	
	if($params->get('layout') == 'business')
	{
	require_once( upload_DIR . DIRECTORY_SEPARATOR . 'helper'. DIRECTORY_SEPARATOR .'helper2.php' );

	$msg = '';
	$form = new modjoomEmailForm();
	$objFORM = new _joomform();
	$result = $form->initialise($params);
	
	if(isset($_POST['chkpost'])){
	$res = $form->_sendmail();
	if($res){
	$thankmsg = $form->thankyouMessage();

	$app =& JFactory::getApplication();
	//echo $url;redirect
		 $url = $params->get('redirecturl');
		
		$app->redirect($url,$thankmsg);
	}
	else
	$msg = $form->formatErrorMessage();
	}
	
}
	
require JModuleHelper::getLayoutPath('mod_jmcontact', $params->get('layout', 'default'));
	
	
	?>
	
	