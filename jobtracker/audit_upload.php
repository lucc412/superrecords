<?php
include("include/common.php");
include(MODEL."audit_upload_class.php");
$objScr = new AuditMultiupload();

$sql = $_REQUEST['sql'];
switch ($sql)
{    
    case "uploadAuditDocs":			
            $objScr->add_audit_Docs($_SESSION['jobId']);
			exit;
            header('location: audit_upload.php');
            break;
}

$arrDocList = $objScr->getAuditDocList($_SESSION['jobId']);
include(VIEW.'audit_upload.php');
            

?>