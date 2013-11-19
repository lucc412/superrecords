<?php

    defined('_JEXEC') or die('No Access Allowed');
    jimport( 'joomla.filesystem.file' );
    
    require_once dirname(__FILE__).'/helper.php';

    $freetrialhandler = new modFreeTrialHelper();
    $session =& JFactory::getSession();
    
    $app = JFactory::getApplication();
    
    $freetrialhandler->initialize($params);
    
    if(isset($_POST) && !empty($_POST))
    {
        // check Captcha and Mail Functionality
        $cCheck = $freetrialhandler->process_registration_form();
        
        if($cCheck)
        {
            $thankmsg = "Thank You for Registration";
            $url = $params->get('success-url');
            $app->redirect($url,$thankmsg);

        }else{

            $capMsg = "Invalid Code Entered";
            $url = $params->get('failure-url');
            $_REQUEST['hidMsg'] = 'Y';
        }
    }    
    require JModuleHelper::getLayoutPath('mod_freetrial',$params->get('Layout','default'));
?>
