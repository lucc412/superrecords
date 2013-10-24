<?php
class AuditChecklist {
 
	public function __construct() {
  
	}

        // get checklist list
	public function getAuditChecklist($jobId) {

		$qrySel = "SELECT ac.checklist_id, ac.checklist_name, aus.subchecklist_id, aus.subchecklist_name, IF(acs.checklist_id, 1, 0) chcklstStatus
                            FROM audit_subchecklist aus, audit_checklist ac
                            LEFT JOIN audit_checklist_status acs ON ac.checklist_id = acs.checklist_id AND acs.job_id = '{$jobId}'
                            WHERE ac.checklist_id = aus.checklist_id
                            GROUP BY ac.checklist_order, aus.subchecklist_order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrChecklist[$rowData['checklist_id']] = $rowData['checklist_name'].":".$rowData['chcklstStatus'];
		}

		return $arrChecklist;
	}

        // get selected checklist list
	public function fetch_existing_checklist_selection($jobId) {
		$qrySel = "SELECT acs.checklist_id
                            FROM audit_checklist_status acs
                            WHERE acs.job_id = '{$jobId}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSelChckList[] = $rowData['checklist_id'];
		}
		return $arrSelChckList;	
	}

        // insert checklist selection into table
	public function sql_checklist_selection($arrAddChckList, $arrRemChckList, $jobId) {
		if(!empty($arrAddChckList)) {
			$insChcklst = "INSERT INTO audit_checklist_status (job_id, checklist_id) VALUES";
			foreach($arrAddChckList AS $checklistId) {
				$insChcklst .= "({$jobId}, {$checklistId}),";
			}
			$insChcklst = stringrtrim($insChcklst, ",");
			//print $insChcklst;
			mysql_query($insChcklst);	

		}

		if(!empty($arrRemChckList)) {
			$delChcklst = "DELETE FROM audit_checklist_status WHERE job_id = {$jobId} AND checklist_id IN (";
			foreach($arrRemChckList AS $checklistId) {
				$delChcklst .= "'{$checklistId}',";
			}
			$delChcklst = stringrtrim($delChcklst, ",");
			$delChcklst .= ")";
			//print $delChcklst;
			mysql_query($delChcklst);	
		}
	}
}
?>