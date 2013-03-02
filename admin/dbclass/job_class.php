<?php
//************************************************************************************************
//  Task          : Class and Functions required for Jobs, Documents, Reports, Queries, Job status
//	  			    and Job type.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 01-Jan-2013
//  Last Modified : 16-Jan-2013
//************************************************************************************************  

class Job_Class extends Database
{ 	
	public function __construct()
	{
		$this->arrJob = $this->fetchJob();
		$this->arrJobStatus = $this->fetchJobStatus();
		$this->arrClient = $this->fetchClient();
		$this->arrClientType = $this->fetchClientType();
		$this->arrPractice = $this->fetchPractice();
		$this->arrPracticeName = $this->fetchPracticeName();
		$this->arrJobType = $this->fetchJobType();
	}	

	public function fetchPracticeName() {		

		$qrySel = "SELECT id, name 
					FROM pr_practice
					ORDER BY name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractice[$rowData['id']] = $rowData['name'];
		}
		return $arrPractice;	
	} 
	// Function to fetch all Documents
	public function sql_select() {		
		$qrySel = "SELECT * FROM documents ORDER BY document_id";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrDocument[$rowData['document_id']] = $rowData;
		}
		return $arrDocument;	
	}
	
	// Function to fetch all Jobs or fetches Jobs based on arguments
	public function fetchJob() {

		if($_REQUEST['filter_field'] == 'practice') {
			$fromStr = ", pr_practice p1";
			if(!$_REQUEST['wholeonly']) {
				$whereStr = "AND c1.id = p1.id
							AND p1.name LIKE '%".$_REQUEST['filter']."%'";
			}
			else {
				$whereStr = "AND c1.id = p1.id
							AND p1.name = '".$_REQUEST['filter']."'";
			}
		}
		else if($_REQUEST['filter_field'] == 'job') {
			$fromStr = ", sub_subactivity sa";
			if(!$_REQUEST['wholeonly']) {
				$whereStr = "AND (c1.client_name LIKE '%".$_REQUEST['filter']."%'
							OR sa.sub_Description LIKE '%".$_REQUEST['filter']."%'
							OR j1.period LIKE '%".$_REQUEST['filter']."%')
							AND sa.sub_Code = j1.job_type_id";
			}
			else {
				$whereStr = "AND (c1.client_name = '".$_REQUEST['filter']."'
							OR sa.sub_Description = '".$_REQUEST['filter']."'
							OR j1.period = '".$_REQUEST['filter']."'";
			}
		}
		else if($_REQUEST['filter_field'] == 'status') {
			$fromStr = ", job_status s1";
			if(!$_REQUEST['wholeonly']) {
				$whereStr = "AND j1.job_status_id = s1.job_status_id
							AND s1.job_status LIKE '%".$_REQUEST['filter']."%'";
			}
			else {
				$whereStr = "AND j1.job_status_id = s1.job_status_id
							AND s1.job_status = '".$_REQUEST['filter']."'";
			}
		}

		$qrySel = "SELECT j1.job_id, j1.job_name, j1.client_id, j1.job_status_id, j1.job_type_id,				j1.job_due_date, j1.job_received, c1.id, j1.period
					FROM job j1, client c1 {$fromStr}
					WHERE j1.client_id = c1.client_id 
					AND j1.discontinue_date IS NULL  
					{$whereStr}
					GROUP BY j1.job_id
					ORDER BY job_id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJob[$rowData['job_id']] = $rowData;
		}
		return $arrJob;	
	} 
	
	// Function to fetch all Job types
	public function fetchJobType() {
		$qrySel = "SELECT sa.sub_Code, sa.sub_Description
					FROM mas_masteractivity ma, sub_subactivity sa
					WHERE ma.mas_Code = sa.sas_Code
					ORDER BY sa.sub_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['sub_Code']] = $rowData['sub_Description'];
		}
		return $arrTypes;
	} 

	// Function to fetch all Queries
	public function fetchPracticeId($jobId)
	{
		$qrySel = "SELECT pr.id practiceId
					FROM job jb, client cl, pr_practice pr
					WHERE jb.client_id = cl.client_id
					AND cl.id = pr.id";

		$fetchResult = mysql_query($qrySel);		
		$fetchRow = mysql_fetch_row($fetchResult);
		$practiceId = $fetchRow[0];

		return $practiceId;
	} 
	
	// Function to fetch all Queries
	public function fetchQueries()
	{
		$qrySel = "SELECT * FROM queries";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrQuery[$rowData['query_id']] = $rowData;
		}
		return $arrQuery;	
	} 
	
	// Function to Add new Query
	public function add_query()
	{
		$jobId = $_REQUEST["jobId"];
		$value = $_REQUEST["txtQuery"];
		
		$qrySel = "INSERT INTO queries(job_id, query) VALUES({$jobId}, '{$value}')";
		mysql_query($qrySel);		
	} 
	
	// Function to fetch all Job status
	public function fetchJobStatus()
	{
		$qrySel = "SELECT * FROM job_status";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJobStatus[$rowData['job_status_id']] = $rowData;
		}
		return $arrJobStatus;	
	} 
	
	// Function to fetch all Practices
	public function fetchPractice() {		

		$qrySel = "SELECT * FROM pr_practice ORDER BY name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractice[$rowData['id']] = $rowData;
		}
		return $arrPractice;	
	} 
	
	// Function to fetch all Clients
	public function fetchClient()
	{	
		$qrySel = "SELECT *	FROM client ORDER BY client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClient[$rowData['client_id']] = $rowData;
		}
		return $arrClient;	
	}  
	
	// Function to fetch Client Type
	public function fetchClientType()
	{	
		$qrySel = "SELECT mas_Code, mas_Description, mas_Order	FROM mas_masteractivity ORDER BY mas_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClientType[$rowData['mas_Code']] = $rowData['mas_Description'];
		}
		return $arrClientType;	
	}  
	
	// Function to fetch all Documents
	public function fetchDocument()
	{	
		$qrySel = "SELECT *	FROM documents";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrDocument[$rowData['document_id']] = $rowData;
		}
		return $arrDocument;
	} 

	// Function to fetch all Documents
	public function fetchChecklists()
	{	
		$qrySel = "SELECT job_id, checklist, checklist_status, job_received
					FROM job WHERE discontinue_date IS NULL ";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrDocument[$rowData['job_id']] = $rowData;
		}
		return $arrDocument;	
	} 
	
	// Function to fetch all Reports
	public function fetchReport()
	{	
		$qrySel = "SELECT *	FROM reports";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrReport[$rowData['report_id']] = $rowData;
		}
		return $arrReport;	
	} 
	
	// Update Job status and Due date of Job
	public function sql_update($jobId)
	{
		global $commonUses;
		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);
		
	    $qryUpd = "UPDATE job 
					SET job_status_id=".$_REQUEST["lstJobStatus"].", 
						job_due_date='".$dateSignedUp."' 
				   WHERE job_id=".$jobId;
		mysql_query($qryUpd);
	}
	
	// Update viewed status with 1 in Document table
	public function update_document($docId)
	{
		$qryUpd = "UPDATE documents 
					SET viewed = 1 
					WHERE document_id=".$docId;
		mysql_query($qryUpd);
	}

	// Update viewed status with 1 in Document table
	public function update_checklist_status($jobId)
	{
		$qryUpd = "UPDATE job 
					SET checklist_status = 1 
					WHERE job_id=".$jobId;
		mysql_query($qryUpd);
	}
	
	// Update Queries
	public function update_query($queryId)
	{
		$strQuery = $_REQUEST["txtQuery".$queryId];
		$strStatus = $_REQUEST["rdStatus".$queryId];
		
		$qrySel = "UPDATE queries SET query='{$strQuery}', status='{$strStatus}' WHERE query_id=".$queryId;
		mysql_query($qrySel);
	}
	
	// Discontinue Job
	public function discontinue_job($queryId)
	{
		// set discontinue date of jobs 
		$qryUpdate = "UPDATE job SET discontinue_date=NOW() WHERE job_id=".$_REQUEST["jobId"];
		mysql_query($qryUpdate);

		// set discontinue date of task 
		$qryDel = "UPDATE task SET discontinue_date=NOW() WHERE job_id=".$_REQUEST["jobId"];
		mysql_query($qryDel);
	}
	
//************************************************************************************************
//  Task          : Function to Insert new Job
//  Modified By   : Dhiraj Sahu 
//  Created on    : 15-Jan-2013
//  Last Modified : 15-Jan-2013
//************************************************************************************************  

	public function insert_job()
	{
		$jobName = $_REQUEST["lstClient"]."::".$_REQUEST["txtPeriod"]."::".$_REQUEST["lstJob"];
		
		$client_Id = $_REQUEST["lstClient"];
		$period = $_REQUEST["txtPeriod"];
		$masCode = $_REQUEST["lstClientType"];
		$jobType = $_REQUEST["lstJob"];

		$qryIns = "INSERT INTO job(client_id, mas_Code, job_type_id, period, job_name, job_status_id, sr_manager, job_received)
					VALUES (
					" . $client_Id . ", 
					" . $masCode . ", 
					" . $jobType . ", 
					'" . $period . "',  
					'" . $jobName . "',  
					1,   
					208,
					NOW()
					)";

		mysql_query($qryIns);
		$jobId = mysql_insert_id();

		$this->add_task($jobType, $period, $_REQUEST["lstPractice"], $client_Id, $jobId);
		
		// upload documents & checklist here
		$this->add_checkList($jobId);
		$this->add_source_Docs($jobId);
		
		//return true;
	}
	
	public function add_task($typeId, $period, $practiceId, $clientId, $jobId) {
		
		$taskName = $this->arrClient[$clientId] . ' - ' . $period . ' - ' . $this->arrJobType[$typeId];
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id) 
					VALUES ('" . $taskName . "',
					'" . $practiceId . "',
					'" . $clientId . "',
					'" . $jobId . "'
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

	
//************************************************************************************************
//  Task          : Function to download file
//  Modified By   : Dhiraj Sahu 
//  Created on    : 01-Jan-2013
//  Last Modified : 08-Jan-2013
//************************************************************************************************  
	
	public function doc_download($fileName)
	{
		if($_REQUEST['flagType'] == 'C'){
			$folderPath = "../uploads/checklists/" . $fileName;
		}
		else if($_REQUEST['flagType'] == 'S') {
			$folderPath = "../uploads/sourcedocs/" . $fileName;
		}
		else if($_REQUEST['flagType'] == 'R') {
			$folderPath = "../uploads/reports/" . $fileName;
		}
		else if($_REQUEST['flagType'] == 'Q') {
			$folderPath = "../uploads/queries/" . $fileName;
		}

		$arrFileName = explode('~', $fileName);
		$origFileName = $arrFileName[1];
	
		header("Expires: 0");  
		header("Last-Modified: " . gmdate("D, d M Y H:i(worry)") . " GMT");  
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

//************************************************************************************************
//  Task          : Function to upload file
//  Modified By   : Dhiraj Sahu 
//  Created on    : 07-Jan-2013
//  Last Modified : 07-Jan-2013
//************************************************************************************************  
 	public function upload_report()
 	{
		$jobId = $_REQUEST["jobId"];		
		$date = date("Y-m-d");	
		$title = $_REQUEST["txtReportTitle"];
	
		// Fetching last report ID.
		$qrySel = "SELECT max(report_id) as reportId FROM reports";
		$fetchResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($fetchResult);
  		$fileId = $arrInfo['reportId'];
		$fileId = $fileId + 1;

		$origFileName = stripslashes($_FILES['fileReport']['name']);
		$filePart = pathinfo($origFileName);
		
		$rnd = rand(1111,9999);
		$dbFileName = $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
		$folderPath = "../uploads/reports/" . $dbFileName;

		if(file_exists($_FILES['fileReport']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['fileReport']['tmp_name'], $folderPath))
			{
				// Inserting file name in Table in file_path field.
				$qryInsert = "INSERT INTO reports(job_id, date, file_path, report_title) VALUES({$jobId}, '{$date}', '{$dbFileName}', '{$title}')";
				mysql_query($qryInsert);	
			}
		}
	} 

}
?>