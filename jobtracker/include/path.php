<?
    define("ERRORICON", "<img src='images_user/errorIcon.gif' />");
    define("EDITICON", "<img src='images_user/edit.png' height='25px' width='22px'>");
    define('DBCONNECT',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/connection.php');
    define('TOPBAR',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/topbar.php');
    define('FOOTER',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/footer.php');
    define('PDF',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/library/html2fpdf/html2fpdf.php');
    define('MAIL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/send_mail.php');
    define('PHPFUNCTION',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/include/php_functions.php');
    define('MODEL',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/model/');
    define('VIEW',$_SERVER['DOCUMENT_ROOT'].'/jobtracker/view/');

    //ESignup tool 
    define("DIR", $_SERVER['DOCUMENT_ROOT'].'/jobtracker/');
    define("SERVER", "http://" . $_SERVER['HTTP_HOST']);
//    define("MODEL", DIR.'/model/');
//    define("VIEW", DIR.'/view/');
//    define("TOPBAR",DIR. '/include/topbar_new.php');
    define("TOPBAR1",DIR. '/include/topbar_existing.php');
//    define("FOOTER",DIR. '/include/footer.php');
    define("LOGO", SERVER. '/images/logo.png');
?>