<?
/* for test site */
define("ENCRYPTION", "http://");

/* for live site */
//define("ENCRYPTION", "https://");

define("DIR", ENCRYPTION.$_SERVER['HTTP_HOST']."/jobtracker/");
define("EDITICON", "<img src='images/edit.png' height='25px' width='22px'>");
define("QUERY", "<img src='images/q.png'>");
define("UPLOAD", "<img src='images/upload.jpg'>");
define("CALENDARICON", "images/calendar.png");
define('DBCONNECT',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/connection.php');
define('TOPBAR',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/topbar.php');
define('HEADDATA',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/header.php');
define('FOOTER',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/footer.php');
define('BOTTOMDATA',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/bottomdata.php');
define('MAIL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/send_mail.php');
define('PDF',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/library/tcpdf/tcpdf.php');
define('PHPFUNCTION',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/php_functions.php');
define('MODEL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/model/');
define('VIEW',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/view/');
define('SETUPVIEW',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/setup/');
define('SETUPMODEL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/setup/');
define('UPLOADSETUP',$_SERVER['DOCUMENT_ROOT'].'/uploads/setup/');
define('DOWNLOAD',DIR.'include/download.php');
define("SETUPNAVIGATION",$_SERVER['DOCUMENT_ROOT'] . "/jobtracker/view/setup_navigation.php");
define("ICOPDF", "<img style='padding-right:2px' src='images/pdf.png'>");
define("ICOTXT", "<img style='padding-right:2px' src='images/txt.jpg'>");
define("ICODOC", "<img style='padding-right:2px' src='images/doc.png'>");
define("ICOZIP", "<img style='padding-right:2px' src='images/rar.png'>");
define("ICOXLS", "<img style='padding-right:2px' src='images/xls.png'>");
define("ICOMSG", "<img style='padding-right:2px' src='images/msg.png'>");
define("ICOIMG", "<img style='padding-right:2px' src='images/jpg.png'>");
define("ICOPPT", "<img style='padding-right:2px' src='images/ppt.png'>");
?>