<?
//************************************************************************************************
//  Task          : Functions to validate different client name
//  Modified By   : Disha Goyal
//  Created on    : 07-Feb-13
//  Last Modified : 07-Feb-13
//************************************************************************************************

// include all required files for this screen
//include 'jobtracker/include/connection.php';
include $_SERVER['DOCUMENT_ROOT'].'jobtracker/include/connection.php';

// call required class file functions 
$returnStr = "";
$colName = $_REQUEST['colName'];
$inputValue = $_REQUEST['inputValue'];
$entityId = $_REQUEST['entityId'];

switch($_REQUEST['doAction']) {
    case 'checkUnique': 
    
        $inputValue = strtolower(trim($inputValue));
        $arrClientData = $_SESSION['CLIENTNAME'];
    
        if(!empty($arrClientData)) {
            if(!in_array($inputValue, $arrClientData)) {   
				$returnStr .= 'success';    
            } 
            else {
				$returnStr .= 'failure';          
            }
        }
        else {
            $returnStr .= 'success';          
        }
    break;
}

print($returnStr);
?>