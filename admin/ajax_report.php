<?
// include all required files for this screen
include 'dbclass/commonFunctions_class.php';
include 'dbclass/report_class.php';

// create class object for class function access
$objCallUsers = new SR_Report();

// call required class file functions 
$returnStr = "";

$colName = $_REQUEST['colName'];
$headerName = $_REQUEST['headerName'];
$key = $_REQUEST['key'];
$option = $_REQUEST['option'];
$typex = $_SESSION['ARRFIELDTYPEX'][$colName];

switch($_REQUEST['doAction']) {
    case 'showCondition': 

		// include file to display condition drop-down
		include(REPORTCONDITION);
    
    break;
    
  case 'showInputType': 
	
	// include file to display value drop-down / text box / calendar
	include(REPORTVALUE);

    break;
}

print($returnStr);
?>