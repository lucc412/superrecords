<?php

    defined('_JEXEC') or die('No Access Allowed');

    $anujMessage = $params->get('anujMessage');

    require_once dirname(__FILE__).'/helper.php';

    $freetrialhandler = new modFreeTrialHelper();
    $session =& JFactory::getSession();
    
    if(isset($_POST) && !empty($_POST))
    {
        // check Captcha and Mail Functionality
        $cCheck = $freetrialhandler->process_registration_form();
        $app =& JFactory::getApplication();
        var_dump($cCheck);
        if($cCheck)
        {
            $thankmsg = "Thank You for Registration";
            $url = 'free-trial-thank-you.html';
            $app->redirect($url,$thankmsg);

        }else{

            $capMsg = "Invalid Code Entered";
            $url = 'free-trial-registration.html';
            $_REQUEST['hidMsg'] = 'Y';
        }
    }    
    
//    require( JModuleHelper::getLayoutPath( 'mod_freetrial' ) );
    require JModuleHelper::getLayoutPath('mod_freetrial',$params->get('Layout','default'));
?>
