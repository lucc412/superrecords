<?php

    defined('_JEXEC') or die('No Access Allowed');
    jimport( 'joomla.filesystem.file' );
    
    // Include the syndicate functions only once
    require_once( dirname(__FILE__).DS.'helper.php' );
    $freetrialhandler = new modFreeTrialHelper();
    $session =& JFactory::getSession();
    
    $freetrialhandler->initialize($params);
    
    if(isset($_POST) && !empty($_POST))
    {
        // check Captcha and Mail Functionality
        $cCheck = $freetrialhandler->process_registration_form();
        $app = JFactory::getApplication();
        
        if($cCheck)
        {
            $thankmsg = "Thank You for Registration";
            $url = $params->get('success_url');
            $app->redirect($url,$thankmsg);

        }else{

            $capMsg = "Invalid Code Entered";
            $url = $params->get('failure_url');
            $_REQUEST['hidMsg'] = 'Y';
        }
    }    
    require JModuleHelper::getLayoutPath('mod_freetrial',$params->get('Layout','default'));
?>
