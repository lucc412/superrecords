<?php
class Job {
 
	public function __construct() {
  
	}
  
	public function sql_select($fetchType=NULL) {
		
		if(!empty($fetchType) && $fetchType == 'pending') {
			$appendStr = 'AND t1.job_status_id <> 7';
		}
		else if(!empty($fetchType) && $fetchType == 'completed') {
			$appendStr = 'AND t1.job_status_id = 7';
		}

		if(!empty($_REQUEST['lstClientType'])) {
			$appendSelStr = "AND t1.client_id = {$_REQUEST['lstClientType']}";
		}

		$qrySel = "SELECT t1.job_id, t1.job_name, t1.job_received, t1.job_type_id, t1.client_id, t1.period, t1.job_status_id, t1.checklist, t1.mas_Code
					FROM job t1, client c1
					WHERE c1.id = '{$_SESSION['PRACTICEID']}'
					AND t1.client_id = c1.client_id
					AND t1.discontinue_date IS NULL  
					{$appendStr} {$appendSelStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrjobs[$rowData['job_id']] = $rowData;
		}
		return $arrjobs;	
	}

	public function fetch_associated_clients($fetchType=NULL) {

		$qrySel = "SELECT t1.client_id, t1.client_name
					FROM client t1
					WHERE t1.id = '{$_SESSION['PRACTICEID']}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData['client_name'];
		}
		return $arrClients;	
	}

	public function fetch_documents($jobId) {		

		$qrySel = "SELECT t1.document_id, t1.document_title, t1.file_path
					FROM documents t1
					WHERE t1.job_id = '{$jobId}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrDocs[$rowData['document_id']] = $rowData;
		}
		return $arrDocs;	
	}

	public function fetch_reports($jobId) {		

		$qrySel = "SELECT t1.report_id, t1.report_title, t1.file_path
					FROM reports t1
					WHERE t1.job_id = '{$jobId}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrDocs[$rowData['report_id']] = $rowData;
		}
		return $arrDocs;	
	}

	public function fetch_clients() {		

		$qrySel = "SELECT t1.client_id, t1.client_name
					FROM client t1
					WHERE id = '{$_SESSION['PRACTICEID']}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData['client_name'];
		}
		return $arrClients;	
	}

	public function fetchClientType() {		
 		$qrySel = "SELECT ma.mas_Code, ma.mas_Description
					FROM mas_masteractivity ma
					WHERE ma.display_in_practice = 'yes'
					ORDER BY ma.mas_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClientType[$rowData['mas_Code']] = $rowData['mas_Description'];
		}
		return $arrClientType;
	}

	public function fetchType($masCode=NULL) {		
		if(!empty($masCode)) {
			$appendStr = "AND ma.mas_Code = {$masCode}";
		}

 		$qrySel = "SELECT sa.sub_Code, sa.sub_Description
					FROM mas_masteractivity ma, sub_subactivity sa
					WHERE ma.mas_Code = sa.sas_Code
					AND sa.display_in_practice = 'yes'
					{$appendStr}
					ORDER BY sa.sub_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['sub_Code']] = $rowData['sub_Description'];
		}
		return $arrTypes;
	}

	public function fetchStatus() {		

		$qrySel = "SELECT ct.job_status_id, ct.job_status
					FROM job_status ct";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJobStatus[$rowData['job_status_id']] = $rowData['job_status'];
		}
		return $arrJobStatus;
	}

	public function sql_insert() {
		$clientId = $_REQUEST['lstClientType'];
		$typeId = $_REQUEST['lstJobType'];
		$period = $_REQUEST['txtPeriod'];
		$cliType = $_REQUEST['lstCliType'];

		$jobName = $clientId .'::'. $period .'::'. $typeId;

		$qryIns = "INSERT INTO job(client_id, mas_Code, job_type_id, period, job_name, job_status_id, sr_manager, job_received)
					VALUES (
					" . $clientId . ", 
					" . $cliType . ", 
					" . $typeId . ", 
					'" . $period . "',  
					'" . $jobName . "',  
					1,   
					113,
					NOW()
					)";

		mysql_query($qryIns);
		
		
		$jobId = mysql_insert_id();

		$this->add_task($typeId, $period, $_SESSION['PRACTICEID'], $clientId, $jobId, $cliType, $typeId);
		
		// upload documents & checklist here
		$this->add_checkList($jobId);
		$this->add_source_Docs($jobId);
		
		return true;
	}

	public function add_task($typeId, $period, $practiceId, $clientId, $jobId, $cliType, $typeId) {
		$arrJobType = $this->fetchType();
		$arrClients = $this->fetch_associated_clients();

		$taskName = $arrClients[$clientId] . ' - ' . $period . ' - ' . $arrJobType[$typeId];
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, manager_id) 
					VALUES ('" . $taskName . "',
					'" . $practiceId . "',
					'" . $clientId . "',
					'" . $jobId . "',
					'" . $cliType . "',
					'" . $typeId . "',
					'113'
					)";
		mysql_query($qryIns);			
	}

	public function add_checkList($jobId) {
		foreach($_FILES AS $fieldName => $imageInfo){
			if($fieldName == 'fileChecklist') {
				$origFileName = stripslashes($_FILES[$fieldName]['name']);
				$filePart = pathinfo($origFileName);
				$dbFileName = $jobId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
				$folderPath = "../uploads/checklists/" . $dbFileName;

				if(file_exists($_FILES[$fieldName]['tmp_name'])) {
					if(move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folderPath)) {
						$qryUpd = "UPDATE job
									SET checklist = '" . $dbFileName . "'
									WHERE job_id = '" . $jobId . "'";
						mysql_query($qryUpd);
					}
				}
			}	
		}
	}

	public function add_source_Docs($jobId) {

		$qrySel = "SELECT max(document_id) docId 
					FROM documents";
		$objResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($objResult);
		$fileId = $arrInfo['docId'];

		foreach($_FILES AS $fieldName => $imageInfo){
			if(strstr($fieldName, 'sourceDoc_')) {
				$fileId++;
				$uploadCnt = str_replace('sourceDoc_', '',$fieldName);
				$origFileName = stripslashes($_FILES[$fieldName]['name']);
				$filePart = pathinfo($origFileName);
				$fileName =  $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
				$folderPath = "../uploads/sourcedocs/" . $fileName;

				if(file_exists($_FILES[$fieldName]['tmp_name'])) {
					if(move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folderPath)) {
						$qryIns = "INSERT INTO documents(job_id, document_title, file_path, date)
									VALUES(
									".$jobId.", 
									'".$_REQUEST['textSource_'.$uploadCnt]."', 
									'".$fileName."', 
									NOW() 
									)";
						mysql_query($qryIns);
					}
				}
			}
		}
	}

	public function sql_update() {	

		$jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];

		$qryUpd = "UPDATE job
				SET job_type_id = '" . $_REQUEST['lstJobType'] . "',
				mas_Code = '" . $_REQUEST['lstCliType'] . "',
				client_id = '" . $_REQUEST['lstClientType'] . "',
				period = '" . $_REQUEST['txtPeriod'] . "',
				job_name = '" . $jobName . "'
				WHERE job_id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);

		// upload documents & checklist here
		$this->add_checkList($_REQUEST['recid']);
		$this->add_source_Docs($_REQUEST['recid']);

		return $returnstr;
	} 

	public function doc_download($fileName, $flagChecklist) {
	
		if($flagChecklist == 'C') {
			$folderPath = "../uploads/checklists/" . $fileName;
		}
		else if($flagChecklist == 'S') {
			$folderPath = "../uploads/sourcedocs/" . $fileName;
		}
		else if($flagChecklist == 'R') {
			$folderPath = "../uploads/reports/" . $fileName;
		}

		$arrFileName = explode('~', $fileName);
		$origFileName = $arrFileName[1];
		header("Expires: 0");  
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
		header("Cache-Control: no-store, no-cache, must-revalidate");  
		header("Cache-Control: post-check=0, pre-check=0", false);  
		header("Pragma: no-cache");
		header("Content-type: application/doc");  
		// tell file size  
		header('Content-length: '.filesize($folderPath));  
		// set file name  
		header('Content-disposition: attachment; filename="'.$origFileName.'"');  
		readfile($folderPath);  
		 
		// Exit script. So that no useless data is output-ed.  
		exit;   
	}

	public function delete_doc($fileName, $flagChecklist) {

		if($flagChecklist == 'C') {
			$folderPath = "../uploads/checklists/" . $fileName;
		}
		else if($flagChecklist == 'S') {
			$folderPath = "../uploads/sourcedocs/" . $fileName;
		}
	
		if(file_exists($folderPath)) {
			unlink($folderPath);

			if($flagChecklist == 'C') {
				$qryUpd = "UPDATE job
							SET checklist = NULL
							WHERE job_id = '" . $_REQUEST['recid'] . "'";
				mysql_query($qryUpd);
			}
			else if($flagChecklist == 'S') {
				$qryDel = "DELETE FROM documents 
							WHERE document_id = '" . $_REQUEST['documentId'] . "'";
				mysql_query($qryDel);
			}
		}
	}
}
?>