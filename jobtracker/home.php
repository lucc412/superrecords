<?php
include("include/common.php");
include(MODEL."home_class.php");
$objScr = new Home();
	
if(isset($_REQUEST['txtName']) && isset($_REQUEST['txtPassword'])) 
{
	$username = $_REQUEST['txtName'];
        $password = $_REQUEST['txtPassword'];

        // function call to check whether user is valid or not
	$practiceId = $objScr->check_valid_practice($username, $password);
	if(isset($_SESSION['PRACTICEID'])) unset($_SESSION['PRACTICEID']);
	$_SESSION['PRACTICEID'] = $practiceId;

	if(!empty($practiceId)) {
		$prName = $objScr->get_Practice_Name();
		if(isset($_SESSION['PRACTICE'])) unset($_SESSION['PRACTICE']);
		$_SESSION['PRACTICE'] = $prName;
		include(VIEW."home.php");
	}
	else {
		// file inclusion for displaying login form with error message
		header('Location: login.php?loginFail=Y');
	}
}
else if(isset($_REQUEST['flgFrgtPass']) && $_REQUEST['flgFrgtPass'] == "forgot") {
	
    $username = $_REQUEST['txtName'];
    $pracDtls = $objScr->forgot_practice($username);
    $pageUrl = basename($_SERVER['REQUEST_URI']);
    
    // check if event is active or inactive [This will return TRUE or FALSE as per result]
    $flagSet = getEventStatus($pageUrl);
    if($flagSet)
    {
        //$to = $pracDtls['email'];
        $event = get_email_info($pageUrl);
        $to = 'siddhesh.c@befreeit.com.au';
        $cc = $event['event_cc'];
        $subject = "Forgot Password Details";
        $msg = html_entity_decode($event['event_content']);
        $msg = str_replace("{User}", $_REQUEST['txtName'], $msg);
        $content = str_replace("{Password}", $pracDtls['password'], $msg);
        include_once(MAIL);
        send_mail($to, $cc, $subject, $content);
        echo '<script>window.close();</script>';
    }
}
else if(isset($_SESSION['PRACTICEID']) && isset($_SESSION['PRACTICE'])) {
	include(VIEW."home.php");
}
else {
	// file inclusion for displaying login form with error message
	header('Location: login.php?loginFail=Y');
}
?>