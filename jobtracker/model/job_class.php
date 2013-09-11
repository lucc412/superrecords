<?php
class Job {
 
	public function __construct() {
  
	}
  
	public function sql_select($fetchType=NULL) {
		
		if(!empty($fetchType) && $fetchType == 'pending') {
			$appendStr = 'AND t1.job_status_id <> 7 AND t1.job_submitted = "Y"';
			$orderByStr = 'ORDER BY t1.job_received desc';
		}
		else if(!empty($fetchType) && $fetchType == 'completed') {
			$appendStr = 'AND t1.job_status_id = 7 AND t1.job_submitted = "Y"';
			$orderByStr = 'ORDER BY t1.job_completed_date desc';
		}
		else if(!empty($fetchType) && $fetchType == 'saved') {
			$appendStr = 'AND t1.job_submitted = "N"';
			$orderByStr = 'ORDER BY t1.job_id desc';
		}
		else if(!empty($fetchType) && ($fetchType == 'document' || $fetchType == 'uploadDoc')) {
			$appendStr = 'AND t1.job_submitted = "Y"';
			$orderByStr = 'ORDER BY t1.job_id desc';
		}
                else if(!empty($fetchType) && ($fetchType == 'duplicate')) {
                    $jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];
                    $appendStr = "AND t1.job_name = '".$jobName."'";
		}
		if(!empty($_REQUEST['lstClientType'])) {
			$appendSelStr = "AND t1.client_id = {$_REQUEST['lstClientType']}";
		} 

		$qrySel = "SELECT t1.job_id, t1.job_name, DATE_FORMAT(t1.job_received, '%d/%m/%Y') job_received, DATE_FORMAT(t1.job_created_date, '%d/%m/%Y') job_created_date, DATE_FORMAT(t1.job_completed_date, '%d/%m/%Y') job_completed_date, t1.job_type_id, t1.client_id, t1.period, t1.job_status_id, t1.mas_Code, t1.notes, t1.job_genre, t1.setup_subfrm_id, t1.job_submitted
					FROM job t1, client c1
					WHERE c1.id = '{$_SESSION['PRACTICEID']}'
					AND t1.client_id = c1.client_id
					AND t1.discontinue_date IS NULL  
					{$appendStr} {$appendSelStr}
					{$orderByStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrjobs[$rowData['job_id']] = $rowData;
		}
		return $arrjobs;	
	}

	public function fetch_associated_clients() {

		$qrySel = "SELECT t1.client_id, t1.client_name
					FROM client t1
					WHERE t1.id = '{$_SESSION['PRACTICEID']}'
					ORDER BY t1.client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData['client_name'];
		}
		return $arrClients;	
	}


	public function fetch_manager_ids($jobId)
	{
		$qrySel = "SELECT c.sr_manager, c.india_manager
					FROM client c, job j
					WHERE c.client_id = j.client_id
					AND j.job_id = {$jobId}";

		$fetchResult = mysql_query($qrySel);  
		while($rowData = mysql_fetch_assoc($fetchResult))
			$arrIds[] = $rowData;

		return $arrIds; 
	}

	public function fetch_documents($jobId)
	{
		if($jobId)
			$strJobId = "AND t1.job_id = '{$jobId}'";
			
		if(!empty($_REQUEST['lstJob'])) {
			$appendWhrStr = "AND j1.job_id = {$_REQUEST['lstJob']}";
		}

		$qrySel = "SELECT t1.document_id, t1.document_title, t1.file_path, t1.file_path,j1.job_id, j1.job_name 
					FROM documents t1, job j1, client c1
					WHERE t1.job_id = j1.job_id
					AND j1.client_id = c1.client_id
					AND c1.id = '{$_SESSION['PRACTICEID']}' 
					{$strJobId} 
					{$appendWhrStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult))
			$arrDocs[$rowData['document_id']] = $rowData;

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

	public function fetch_queries($jobId) {		

		$qrySel = "SELECT count(*) qryCount
					FROM queries t1
					WHERE t1.job_id = '{$jobId}'
					AND t1.flag_post = 'Y'
					AND t1.status = '0'";

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_row($fetchResult);
		return $rowData[0];	
	}

	public function fetch_clients() {		

		$qrySel = "SELECT t1.client_id, t1.client_name
					FROM client t1
					WHERE id = '{$_SESSION['PRACTICEID']}'
					ORDER BY t1.client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData['client_name'];
		}
		return $arrClients;	
	}

	public function fetchClientType() {		
 		$qrySel = "SELECT ma.mas_Code, ma.mas_Description
					FROM mas_masteractivity ma, sub_subactivity sa
					WHERE ma.mas_Code = sa.sas_Code
					AND ma.display_in_practice = 'yes'
					AND sa.display_in_practice = 'yes'
					ORDER BY ma.mas_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClientType[$rowData['mas_Code']] = $rowData['mas_Description'];
		}
		return $arrClientType;
	}

	public function getAuditCliJobType() {		
 		$qrySel = "SELECT ma.mas_Description, sa.sub_Description
					FROM mas_masteractivity ma, sub_subactivity sa
					WHERE ma.mas_Code = sa.sas_Code
					AND ma.mas_Code = '25'
					AND sa.sub_Code = '11'";

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$arrAuditType['cliType'] = $rowData['mas_Description'];
		$arrAuditType['jobType'] = $rowData['sub_Description'];

		return $arrAuditType;
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

	public function sql_insert($details) {
            
        $clientId = $details['lstClientType'];
		$typeId = $details['lstJobType'];
		$period = $details['txtPeriod'];
		$cliType = $details['lstCliType'];
		$notes = $details['txtNotes'];
		$jobGenre = $details['type'];
		$setup_subfrm = $details['subfrmId'];

		if($jobGenre == 'COMPLIANCE') {
			$jobSubmitted = 'Y';
			$jobReceived = 'NOW()';
		}
		else {
			$jobSubmitted = 'N';
			$jobReceived = 'NULL';
		}

		$jobName = $clientId .'::'. $period .'::'. $typeId;
                if(empty($clientId) && empty($period))$jobName=NULL;
                    
		$qryIns = "INSERT INTO job(client_id, job_genre, job_submitted, mas_Code, job_type_id, period, notes, job_name, job_status_id, setup_subfrm_id, job_created_date, job_received)
					VALUES (
					'" . $clientId . "', 
					'" . $jobGenre . "', 
					'" . $jobSubmitted . "', 
					" . $cliType . ", 
					" . $typeId . ", 
					'" . $period . "',  
					'" . $notes . "',
					'" . $jobName . "',  
					1,   
					'".$setup_subfrm."',    
					NOW(),            
					".$jobReceived."         
					)";
                mysql_query($qryIns);
		$jobId = mysql_insert_id();

		// add source documents & new task if it is Compliance job
		if($jobGenre == "COMPLIANCE") {
			$this->add_task($typeId, $period, $_SESSION['PRACTICEID'], $clientId, $jobId, $cliType);
			$this->add_source_Docs($jobId);
		}
		
		return $jobId;
	}

	public function add_task($typeId, $period, $practiceId, $clientId, $jobId, $cliType) {
		$arrJobType = $this->fetchType();
		$arrClients = $this->fetch_associated_clients();

		$taskName = $arrClients[$clientId] . ' - ' . $period . ' - ' . $arrJobType[$typeId];
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code) 
					VALUES ('" . $taskName . "',
					'" . $practiceId . "',
					'" . $clientId . "',
					'" . $jobId . "',
					'" . $cliType . "',
					'" . $typeId . "'
					)";
		mysql_query($qryIns);			
	}

	public function add_new_task($practiceId, $jobId) {
		$arrJobType = $this->fetchType();
		$arrClients = $this->fetch_associated_clients();
		$arrJobData = $this->fetch_job_data($jobId);
		$taskName = $arrClients[$arrJobData['client_id']] . ' - ' . $arrJobData['period'] . ' - ' . $arrJobType[$arrJobData['job_type_id']];
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code) 
					VALUES ('" . $taskName . "',
					'" . $practiceId . "',
					'" . $arrJobData['client_id'] . "',
					'" . $jobId . "',
					'" . $arrJobData['mas_Code'] . "',
					'" . $arrJobData['job_type_id'] . "'
					)";
		mysql_query($qryIns);			
	}

	public function add_audit_Docs($jobId, $checklistId, $subchecklistId) {
		$qrySel = "SELECT max(document_id) docId 
					FROM documents";
		$objResult = mysql_query($qrySel);

		$arrInfo = mysql_fetch_assoc($objResult);
		$fileId = $arrInfo['docId'];
		$origFileName = stripslashes($_FILES['fileUpload']['name']);
		$filePart = pathinfo($origFileName);
		$fileName =  $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
		$folderPath = "../uploads/audit/" . $fileName;

		if(file_exists($_FILES['fileUpload']['tmp_name'])) {
			if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $folderPath)) {
				if(empty($subchecklistId)) {
					$qryIns = "INSERT INTO documents(job_id, checklist_id, file_path, date)
								VALUES(
								".$jobId.", 
								". $checklistId .", 
								'". addslashes($fileName) ."', 
								NOW() 
								)";
				}
				else if(!empty($subchecklistId)) {
					$qryIns = "INSERT INTO documents(job_id, checklist_id, subchecklist_id, file_path, date)
								VALUES(
								".$jobId.", 
								". $checklistId .", 
								". $subchecklistId .", 
								'". addslashes($fileName) ."', 
								NOW() 
								)";

				}
				mysql_query($qryIns);
			}
		}
	}

	public function update_job_completed($jobId) {
		$qryUpd = "Update job
					SET job_submitted = 'Y',
					job_received = NOW()
					WHERE job_id = {$jobId}";

		mysql_query($qryUpd);
	}

	public function fetch_job_data($jobId) {
		$qryUpd = "SELECT jb.period, jb.client_id, jb.mas_Code, jb.job_type_id
					FROM job jb
					WHERE jb.job_id = {$_SESSION['jobId']}";

		$objResult = mysql_query($qryUpd);
		while($rowInfo = mysql_fetch_assoc($objResult)) {
			$arrJobData = $rowInfo;
		}

		return $arrJobData;
	}

	public function add_audit_details($strInsert) {
		$qryIns = "INSERT INTO audit_form_status(job_id, subchecklist_id, upload_status, notes)
					VALUES".$strInsert;
		mysql_query($qryIns);
	}

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
									'". addslashes($_REQUEST['textSource_'.$uploadCnt]) ."', 
									'". addslashes($fileName) ."', 
									NOW() 
									)";
						mysql_query($qryIns);
					}
				}
			}
		}
	}

	public function upload_document()
	{
		$qrySel = "SELECT max(document_id) docId
					FROM documents";

		$objResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($objResult);
		$fileId = $arrInfo['docId'];

		$currentTime = date('Y-m-d H:i:s');

		$fileId++;
		$origFileName = stripslashes($_FILES['fileDoc']['name']);
		$filePart = pathinfo($origFileName);
		$fileName =  $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
		$folderPath = "../uploads/sourcedocs/" . $fileName;

		if(file_exists($_FILES['fileDoc']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['fileDoc']['tmp_name'], $folderPath))
			{
				$qryIns = "INSERT INTO documents(job_id, document_title, file_path, date)
						VALUES(
						".$_REQUEST['lstJob'].", 
						'". addslashes($_REQUEST['txtDocTitle']) ."', 
						'". addslashes($fileName) ."',
						'" . $currentTime . "'
						)";
				mysql_query($qryIns);
				$docId = mysql_insert_id();
			}
		}

		$qrySel = "SELECT date
					FROM documents
					WHERE document_id = {$docId}";

		$objRes = mysql_query($qrySel);
		$arrResult = mysql_fetch_row($objRes);
		$currentTime = $arrResult['0'];

		$returnPath = $origFileName . '~' . $currentTime;
		return $returnPath;
	}

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

	public function getAuditDocList($jobId, $checklistId) {
		$qrySel = "SELECT d.file_path, DATE_FORMAT(d.date, '%d/%m/%Y') date
					FROM documents d
					WHERE d.job_id = {$jobId}
					AND d.checklist_id = {$checklistId} 
					AND d.subchecklist_id = 0
					ORDER BY d.date desc";

		$objRes = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($objRes)) {
			$arrDocList[$rowData['file_path']] = $rowData['date'];
		}
		return $arrDocList;
	}

	public function getAuditSubDocList($jobId) {
		$qrySel = "SELECT d.file_path, d.subchecklist_id
					FROM documents d
					WHERE d.job_id = {$jobId}
					AND d.subchecklist_id <> 0
					ORDER BY d.date desc";

		$objRes = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($objRes)) {
			$arrDocList[$rowData['subchecklist_id']][] = $rowData['file_path'];
		}
		
		return $arrDocList;
	}

	public function sql_update() {	

		$jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];
		$jobGenre = $_REQUEST['type'];

		$qryUpd = "UPDATE job
				SET job_type_id = '" . $_REQUEST['lstJobType'] . "',
				mas_Code = '" . $_REQUEST['lstCliType'] . "',
				client_id = '" . $_REQUEST['lstClientType'] . "',
				period = '" . $_REQUEST['txtPeriod'] . "',
				notes = '" . $_REQUEST['txtNotes'] . "',
				job_name = '" . $jobName . "'
				WHERE job_id = '" . $_SESSION['jobId'] . "'";

		mysql_query($qryUpd);

		// upload documents here
		if($jobGenre == "COMPLIANCE")
			$this->add_source_Docs($_REQUEST['recid']);
	} 

	public function doc_download($fileName, $flagChecklist) {
	
		if($flagChecklist == 'S') {
			$folderPath = "../uploads/sourcedocs/" . $fileName;
		}
		else if($flagChecklist == 'R') {
			$folderPath = "../uploads/reports/" . $fileName;
		}
		else if($flagChecklist == 'A') {
			$folderPath = "../uploads/audit/" . $fileName;
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

		if($flagChecklist == 'S') {
			$folderPath = "../uploads/sourcedocs/" . $fileName;
		}
	
		if(file_exists($folderPath)) {
			unlink($folderPath);

			if($flagChecklist == 'S') {
				$qryDel = "DELETE FROM documents 
							WHERE document_id = '" . $_REQUEST['documentId'] . "'";
				mysql_query($qryDel);
			}
		}
	}

	public function getSubChecklistName($checklistId) {
		$qrySel = "SELECT ac.subchecklist_name
					FROM audit_subchecklist ac
					WHERE ac.subchecklist_id = ".$checklistId;

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$checklistName = $rowData['subchecklist_name'];

		return $checklistName;
	}

	public function getChecklistName($checklistId) {
		$qrySel = "SELECT ac.checklist_name
					FROM audit_checklist ac
					WHERE ac.checklist_id = ".$checklistId;

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$checklistName = $rowData['checklist_name'];

		return $checklistName;
	}

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

	public function getAuditSubChecklist($jobId, $flagSimple=false) {

		$qrySel = "SELECT ac.checklist_id, ac.checklist_name, aus.subchecklist_id, aus.subchecklist_name, IF(dc.checklist_id, 1, 0) uploadStatus
					FROM audit_subchecklist aus, audit_checklist_status acs, audit_checklist ac
					LEFT JOIN documents dc ON ac.checklist_id = dc.checklist_id AND dc.job_id = '{$jobId}' AND dc.subchecklist_id = 0
					WHERE ac.checklist_id = aus.checklist_id
					AND ac.checklist_id = acs.checklist_id
					AND acs.job_id = '{$jobId}'
					GROUP BY ac.checklist_order, aus.subchecklist_order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			if($flagSimple) 
				$arrSubchecklist[$rowData['checklist_name']][] = $rowData['subchecklist_name'];
			else 
				$arrSubchecklist[$rowData['checklist_id'].":".$rowData['checklist_name'].":".$rowData['uploadStatus']][$rowData['subchecklist_id']] = $rowData['subchecklist_name'];
		}

		return $arrSubchecklist;
	}

	public function fetchJobDetail($jobId) {		

		$qrySel = "SELECT j1.client_id, j1.period, j1.mas_Code, j1.job_type_id, j1.notes
					FROM job j1
					WHERE j1.job_id = '{$jobId}'";

		$fetchResult = mysql_query($qrySel);		
		$arrJobInfo = mysql_fetch_assoc($fetchResult);
		return $arrJobInfo;	
	}

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
        
	public function fetch_setup_forms() 
	{
		$frmQry = "SELECT * FROM setup_forms";
		$fetchResult = mysql_query($frmQry);		
		
		$subfrmQry = "SELECT * FROM setup_subforms";
		$fetchRow = mysql_query($subfrmQry);
		
		while($rowData = mysql_fetch_assoc($fetchResult)) 
		{
			$arrForms[$rowData['form_id']] = $rowData;
		}
		
		while($row = mysql_fetch_assoc($fetchRow)) 
		{
			$arrSubForms[$row['subform_id']] = $row;
		}
		
		foreach ($arrForms as $key => $value) 
		{
			foreach ($arrSubForms as $val) 
			{
				if($value['form_id'] == $val['form_id'])
					$arrForms[$value['form_id']]['subforms'][] = $val;
			}
		}
		
		// echo '<pre>';
        // print_r($arrForms);
        // echo '</pre>';
		return $arrForms;
	}

	public function sql_download_checklist($jobId) {
		$arrSubchecklist = $this->getAuditSubChecklist($jobId, true);

		?><html>
			<body><?
				$cntChckLst = A;
				echo"<table border='1' align='center' bgcolor='#F8F8F8' cellpadding='10'>";
				foreach($arrSubchecklist AS $checklistName => $subChecklist) {
					echo"<tr>";
					echo"<td style='font-weight:bold;font-size:15PX;color:#F05729; background-color:#074165;'>".$cntChckLst++."</td>";
					echo"<td style='font-weight:bold;font-size:15PX;color:#F05729; background-color:#074165;'>".stripslashes($checklistName)."</td>";
					echo"</tr>";
					$cntSubchckLst = 1;
					foreach($subChecklist AS $subChecklistName) {
						echo"<tr>";
						echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".$cntSubchckLst++."</td>";
						echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".$subChecklistName++."</td>";
						echo"</tr>";
					}
				}
				echo"</table>";

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
				header("Content-Type: application/force-download");
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment;filename=checklist.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
			?></body>
		</html><?
	}
}
?>