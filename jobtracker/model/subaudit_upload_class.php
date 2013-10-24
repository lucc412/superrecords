<?php
class Subauditupload {
 
	public function __construct() {
  
	}

        // upload audit documents - single checklist & multiple docs upload 
	public function add_audit_Docs($jobId, $checklistId=NULL, $subchecklistId=NULL) {
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
                            $qryDel = "DELETE * FROM audit_form_status WHERE job_id=".$jobId." AND subchecklist_id=".$subchecklistId;
                            mysql_query($qryDel);
                            $qryStatus = "INSERT INTO audit_form_status(job_id, subchecklist_id, upload_status)
                                            VALUES(
                                            ".$jobId.", 
                                            ". $subchecklistId .", 
                                            'ATTACHED')";
                            mysql_query($qryStatus);

                            $qryIns = "INSERT INTO documents(job_id, document_title, checklist_id, subchecklist_id, file_path, date)
                                        VALUES(
                                        ".$jobId.", 
                                        '". addslashes($_REQUEST['fileTitle']) ."', 
                                        ". $checklistId .", 
                                        ". $subchecklistId .", 
                                        '". addslashes($fileName) ."', 
                                        '".$currentTime."'
                                        )";
                            mysql_query($qryIns);
			}
		}
	}

        // get name of subchecklist on the basis of subchecklist id
	public function getSubChecklistName($checklistId) {
		$qrySel = "SELECT ac.subchecklist_name
                            FROM audit_subchecklist ac
                            WHERE ac.subchecklist_id = ".$checklistId;

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$checklistName = $rowData['subchecklist_name'];

		return $checklistName;
	}
}
?>