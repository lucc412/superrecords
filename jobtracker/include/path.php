<?
/* for live site */
//define("ENCRYPTION", "https://");

/* for test site */
define("ENCRYPTION", "http://");

define("DIR", ENCRYPTION.$_SERVER['HTTP_HOST']."/jobtracker/");
define('DBCONNECT',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/connection.php');

// image icon constants
define("EDITICON", "<img src='images/edit.png' height='25px' width='22px'>");
define("QUERY", "<img src='images/q.png'>");
define("UPLOAD", "<img src='images/upload.jpg'>");
define("CALENDARICON", DIR."images/calendar.png");
define("ICOPDF", "<img style='padding-right:2px' src='images/pdf.png'>");
define("ICOTXT", "<img style='padding-right:2px' src='images/txt.jpg'>");
define("ICODOC", "<img style='padding-right:2px' src='images/doc.png'>");
define("ICOZIP", "<img style='padding-right:2px' src='images/rar.png'>");
define("ICOXLS", "<img style='padding-right:2px' src='images/xls.png'>");
define("ICOMSG", "<img style='padding-right:2px' src='images/msg.png'>");
define("ICOIMG", "<img style='padding-right:2px' src='images/jpg.png'>");
define("ICOPPT", "<img style='padding-right:2px' src='images/ppt.png'>");
define("TICK", "<img src='images/yes.png'>");

// file path constants
define('TOPBAR',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/topbar.php');
define('HEADDATA',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/header.php');
define('FOOTER',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/footer.php');
define('BOTTOMDATA',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/bottomdata.php');
define('MAIL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/send_mail.php');
define('PDF',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/library/tcpdf/tcpdf.php');
define('PHPFUNCTION',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/php_functions.php');
define('MODEL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/model/');
define('VIEW',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/view/');
define('UPLOADSETUP',$_SERVER['DOCUMENT_ROOT'].'/uploads/setup/');
define('DOWNLOAD',DIR.'include/download.php');
define('PHPUPLODER',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/library/phpuploader/include_phpuploader.php');

// New SMSF
define("SETUPNAVIGATION",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/new_smsf/include/setup_navigation.php");

// Holding Trust
define("HOLDINGTRUSTNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/holding_trust/include/navigation.php");
define("HOLDINGTRUSTCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/holding_trust/include/content.php");

// Limited Recoursce Loan
define("LIMRECNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/limited_recourse/include/navigation.php");
define("LIMRECCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/limited_recourse/include/content.php");

// Standard Company & Special Company
define("STND_COMP_NAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/standard_company/include/navigation.php");

// Change Trustee
define("CHNGTRUSTEECONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/change_trustee/include/content.php");
define("CHNGTRUSTEENAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/change_trustee/include/navigation.php");

// Format for Trustee and Member Application
define("FRMTNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/trustee_and_membr_app/include/navigation.php");

// investment strategy
define("INVSTMNTSTRAGYNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/investment_strategy/include/navigation.php");

// Deed of variation
define("DEEDVARNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/deed_of_variation/include/navigation.php");
define("DEEDVARCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/deed_of_variation/include/content.php");

// Change Fund Name
define("CHNGFNDCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/change_fundname/include/content.php");
define("CHNGFNDNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/change_fundname/include/navigation.php");

// Format for account based pension
define("ACCPENSNCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/acc_bsd_pension/include/content.php");
define("ACCPENSNNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/acc_bsd_pension/include/navigation.php");


// Format for transition to Retirement Pension
define("RETPENSNNAV",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/trans_retrmnt_pension/include/navigation.php");

// death nomination
define("DEATHBENEFITNOMINATION",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/death_benefit_nomination/include/navigation.php");
// death nomination content
define("DEATHBENEFITNOMINATIONCONTENT",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/setup/death_benefit_nomination/include/content.php");

?>