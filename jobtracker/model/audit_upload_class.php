<?php
class AuditMultiupload {
 
	public function __construct() {
  
	}

        // get audit docs details for multiple uploaded docs
	public function getAuditDocList($jobId) {
		$qrySel = "SELECT d.file_path, DATE_FORMAT(d.date, '%d/%m/%Y') date, d.document_title
                            FROM documents d
                            WHERE d.job_id = {$jobId}
                            AND d.checklist_id = 0
                            AND d.subchecklist_id = 0
                            ORDER BY d.date desc";

		$objRes = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($objRes)) {
			$arrDocList[] = $rowData;
		}
		return $arrDocList;
	}

        // upload multiple audit documents
	public function add_audit_Docs($jobId) {
		$qrySel = "SELECT max(document_id) docId 
                            FROM documents";
		$objResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($objResult);
		$fileId = $arrInfo['docId'];
		$fileId++;

		$origFileName = stripslashes($_FILES['fileUpload']['name']);
		$filePart = pathinfo($origFileName);
		$fileName =  $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
		$folderPath = "../uploads/audit/" . $fileName;
		$currentTime = date('Y-m-d H:i:s');

		if(file_exists($_FILES['fileUpload']['tmp_name'])) {
			if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $folderPath)) {
                            $qryIns = "INSERT INTO documents(job_id, document_title, file_path, date)
                                        VALUES(
                                        ".$jobId.", 
                                        '". addslashes($_REQUEST['fileTitle']) ."', 
                                        '". addslashes($fileName) ."', 
                                        '".$currentTime."'
                                        )";
                            mysql_query($qryIns);
			}
		}
	}
}
?>