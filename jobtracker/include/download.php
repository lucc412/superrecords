<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$fileName = $_REQUEST['fileName'];
switch ($_REQUEST['folderPath']) {
    
    case 'S': $folderPath = "../../uploads/sourcedocs/" . $fileName;
        break;
    
    case 'R': $folderPath = "../../uploads/reports/" . $fileName;
        break;
    
    case 'A': $folderPath = "../../uploads/audit/" . $fileName;
        break;
    
    case 'ST': $folderPath = "../../uploads/setup/" . $fileName;
        break;
    
    case 'T': $folderPath = "../../uploads/templates/" . $fileName;
        break;
    
    case 'PRQ': $folderPath = "../../uploads/queries/" . $fileName;
        break;
    
    case 'SRQ': $folderPath = "../../uploads/srqueries/" . $fileName;
        break;
}

$arrFileName = explode('~', $fileName);
$origFileName = $arrFileName[1];
header("Expires: 0");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Pragma: "); 
header("Cache-Control: ");
header("Content-Type: application/force-download");  
// tell file size  
header('Content-length: '.filesize($folderPath));  
// set file name  
header('Content-disposition: attachment; filename="'.$origFileName.'"');  
readfile($folderPath);  

// Exit script. So that no useless data is output-ed.  
exit;   
	
?>
