<?php
include("include/common.php");
include(MODEL."subaudit_upload_class.php");
$objScr = new Subauditupload();

$sql = $_REQUEST['sql'];
switch ($sql)
{
	case "uploadSubAuditDocs":
		$objScr->add_audit_Docs($_SESSION['jobId'],$_REQUEST['checklistId'],$_REQUEST['subchecklistId']);
		echo "<script>
			opener.parent.location.href = 'audit_subchecklist.php?checklistId=".$_REQUEST['checklistId']."';
			self.close();
		</script>";
		break;
}

$a = $_REQUEST['a'];
switch ($a) {
    default :
        $subchecklistName = $objScr->getSubChecklistName($_REQUEST['subchecklistId']);
        include(VIEW.'subaudit_upload.php');
        break;
}
?>