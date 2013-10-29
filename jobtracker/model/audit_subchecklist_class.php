<?php
class AuditSubchecklist {
 
	public function __construct() {
  
	}

        // set job submitted as Y
	public function update_job_completed($jobId) 
        {
            $qryUpd = "Update job 
                        SET job_submitted = 'Y',
                        job_received = '".date('Y-m-d')."',
                        job_due_date = '".date('Y-m-d', strtotime("+5 days"))."'    
                        WHERE job_id = {$jobId}";

            mysql_query($qryUpd);
	}

        // insert subchecklist details
	public function add_audit_details($strInsert) {
		$qryIns = "INSERT INTO audit_form_status(job_id, subchecklist_id, upload_status, notes)
			VALUES".$strInsert;
                
		mysql_query($qryIns);
	}

        // update subchecklist details
	public function edit_audit_details($arrSubForm, $jobId) {

		foreach($arrSubForm AS $subChecklistId => $checklistInfo) {
			$qryUpd = "UPDATE audit_form_status
                                    SET upload_status = '".$checklistInfo['status']."',
                                    notes = '".$checklistInfo['notes']."'
                                    WHERE subchecklist_id = ".$subChecklistId." 
                                    AND job_id = ".$jobId;
			mysql_query($qryUpd);
		}
	}

        // get audit subchecklist details
	public function getAuditDetails($jobId) {
		$qrySel = "SELECT af.subchecklist_id, af.upload_status, af.notes
                            FROM audit_form_status af
                            WHERE af.job_id = {$jobId}
                            ORDER BY af.subchecklist_id";

		$objRes = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($objRes)) {
			$arrDocDetails[$rowData['subchecklist_id']]['status'] = $rowData['upload_status'];
			$arrDocDetails[$rowData['subchecklist_id']]['notes'] = $rowData['notes'];
		}
		
		return $arrDocDetails;
	}

        // get audit docs details for subchecklist
	public function getAuditSubDocList($jobId) {
		$qrySel = "SELECT d.file_path, d.subchecklist_id, d.document_title
                            FROM documents d
                            WHERE d.job_id = {$jobId}
                            AND d.subchecklist_id <> 0
                            ORDER BY d.date desc";

		$objRes = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($objRes)) {
			$arrDocList[$rowData['subchecklist_id']][] = $rowData['file_path'].":".$rowData['document_title'];
		}
		
		return $arrDocList;
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

        // get subchecklist list
	public function getAuditSubChecklist($jobId, $flagSimple=false) {

		$qrySel = "SELECT ac.checklist_id, ac.checklist_name, aus.subchecklist_id, aus.subchecklist_name
                            FROM audit_subchecklist aus, audit_checklist_status acs, audit_checklist ac
                            WHERE ac.checklist_id = aus.checklist_id
                            AND ac.checklist_id = acs.checklist_id
                            AND acs.job_id = '{$jobId}'
                            GROUP BY ac.checklist_order, aus.subchecklist_order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			if($flagSimple) 
				$arrSubchecklist[$rowData['checklist_name']][] = $rowData['subchecklist_name'];
			else 
				$arrSubchecklist[$rowData['checklist_id'].":".$rowData['checklist_name']][$rowData['subchecklist_id']] = $rowData['subchecklist_name'];
		}

		return $arrSubchecklist;
	}

        // download selected checklist in word file
	public function sql_download_checklist($jobId) {
		$arrSubchecklist = $this->getAuditSubChecklist($jobId, true);
               
		$cntChckLst = A;
		echo "<html><body><table border='1' align='center' bgcolor='#F8F8F8' cellpadding='10'>";
		foreach($arrSubchecklist AS $checklistName => $subChecklist) {
			echo"<tr>";
			echo"<td style='font-weight:bold;font-size:15PX;color:#F05729;width:60px; background-color:#074165;'>".$cntChckLst++."</td>";
			echo"<td style='font-weight:bold;font-size:15PX;color:#F05729;width:600px; background-color:#074165;'>".stripslashes($checklistName)."</td>";
			echo"<td style='font-weight:bold;font-size:15PX;color:#F05729;width:100px;background-color:#074165;'>Yes/No/NA</td>";
			echo"</tr>";
			$cntSubchckLst = 1;
			foreach($subChecklist AS $subChecklistName) {
				echo"<tr>";
				echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".$cntSubchckLst++."</td>";
				echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".$subChecklistName++."</td>";
				echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'></td>";
				echo"</tr>";
			}
		}
		echo"</table></body></html>";

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Content-Type: application/force-download");
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment;filename=checklist.doc");
		header("Pragma: no-cache");
		header("Expires: 0");        
	}
}
?>