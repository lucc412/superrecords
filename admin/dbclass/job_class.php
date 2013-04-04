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

		if($_REQUEST['filter_field'] == 'all') {
			$fromStr = ", pr_practice p1, sub_subactivity sa, job_status s1";
			if(!$_REQUEST['wholeonly']) {
				$whereStr = "AND ((c1.id = p1.id	AND p1.name LIKE '%".$_REQUEST['filter']."%')
						OR ((c1.client_name LIKE '%".$_REQUEST['filter']."%'
							OR sa.sub_Description LIKE '%".$_REQUEST['filter']."%'
							OR j1.period LIKE '%".$_REQUEST['filter']."%') 
							AND sa.sub_Code = j1.job_type_id) 
						OR (j1.job_status_id = s1.job_status_id
							AND s1.job_status LIKE '%".$_REQUEST['filter']."%'))";
			}
			else {
				$whereStr = "AND ((c1.id = p1.id	AND p1.name LIKE '".$_REQUEST['filter']."')
						OR ((c1.client_name LIKE '".$_REQUEST['filter']."'
							OR sa.sub_Description LIKE '".$_REQUEST['filter']."'
							OR j1.period LIKE '".$_REQUEST['filter']."') 
							AND sa.sub_Code = j1.job_type_id) 
						OR (j1.job_status_id = s1.job_status_id
							AND s1.job_status LIKE '".$_REQUEST['filter']."'))";
			}
		}
		else if($_REQUEST['filter_field'] == 'practice') {
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
		
		
		if($_SESSION["usertype"] == "Staff") {
			$userId = $_SESSION["staffcode"];
			
			if($_REQUEST['filter_field'] != 'practice' && $_REQUEST['filter_field'] != 'all')
				$strFrom = ",pr_practice p1";
				
			$strWhere = " AND p1.id = c1.id
						  AND (p1.sr_manager=".$userId." 
						  OR p1.india_manager=".$userId." 
						  OR p1.team_member=".$userId.")";
		}
					
		$qrySel = "SELECT j1.job_id, j1.job_name, j1.client_id, j1.job_status_id, j1.job_type_id,			            j1.job_due_date, j1.job_received, c1.id, j1.period, j1.notes 
					FROM job j1, client c1 {$fromStr} {$strFrom}
					WHERE j1.client_id = c1.client_id 
					AND j1.discontinue_date IS NULL
					{$strWhere} 
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
					AND cl.id = pr.id
					AND jb.job_id = {$jobId}";

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

	// function to fetch contact name as per user email address
	public function fetchFromName($email) {		

		$qrySel = "SELECT CONCAT_WS(' ', con_Firstname, con_Middlename, con_Lastname) contactName
					FROM con_contact
					WHERE con_email = '{$email}'";

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$contactName = $rowData['contactName'];
		
		return $contactName;	
	} 

	// fetch sr manager, india manager, sales manager, team member for selected practice
	function sql_select_panel($itemId)
	{
		$sql = "SELECT id, sr_manager, team_member, india_manager, sales_person
				FROM pr_practice
				WHERE id=".$itemId;
				
		$res = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($res);

		if(!empty($count))
		{
			// fetch array of name of all employees
			$arrEmployees = $this->fetchEmployees();

			$rowData = mysql_fetch_assoc($res);
			$srManager = $arrEmployees[$rowData['sr_manager']];
			$salesPrson = $arrEmployees[$rowData['sales_person']];
			$inManager = $arrEmployees[$rowData['india_manager']];
			$teamMember = $arrEmployees[$rowData['team_member']];

			// set string of srManager, salesPrson, inManager, teamMember
			$strReturn = $srManager .'~'. $salesPrson .'~'. $inManager.'~'. $teamMember;
		}
		return $strReturn;
	}

	function fetchEmployees() {	

		$qrySel = "SELECT ss.stf_Code, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) staffName 
					 FROM stf_staff ss, con_contact cc
					 WHERE ss.stf_CCode = cc.con_Code ";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['stf_Code']] = $rowData['staffName'];
		}
		return $arrEmployees;	
	}
	
	// Function to Add new Query
	public function add_query()
	{
	
		$jobId = $_REQUEST["jobId"];
		$value = $_REQUEST["txtQuery"];
		
		$qrySel = "INSERT INTO queries(job_id, query,date_added) VALUES({$jobId}, '{$value}',NOW())";
		
		mysql_query($qrySel);
		
		// Fetching last report ID.
		$qrySel = "SELECT max(query_id) as queryId FROM queries";
		$fetchResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($fetchResult);
  		$fileId = $arrInfo['queryId'];

		$origFileName = stripslashes($_FILES['fileReport']['name']);
		$filePart = pathinfo($origFileName);
		
		$dbFileName = $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
		$folderPath = "../uploads/srqueries/" . $dbFileName;

		if(file_exists($_FILES['fileReport']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['fileReport']['tmp_name'], $folderPath))
			{	
				// Inserting file name in Table in file_path field.
				$qryUpdate = "UPDATE queries SET report_file_path='{$dbFileName}'  
				               WHERE query_id={$fileId}";

				mysql_query($qryUpdate);
			}
		}
	} 
	
	// Function to fetch all Job status
	public function fetchJobStatus()
	{
		$qrySel = "SELECT * FROM job_status js ORDER BY js.order";

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
						job_due_date='". $dateSignedUp ."' 
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

	// Update Queries
	public function update_query($queryId)
	{
		$strQuery = $_REQUEST["txtQuery".$queryId];
		$strStatus = $_REQUEST["rdStatus".$queryId];
		
		$qrySel = "UPDATE queries 
					SET query='{$strQuery}', 
						status='{$strStatus}' 
					WHERE query_id=".$queryId;
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
	
	// Delete Query
	public function delete_query()
	{
		$qrySel = "SELECT report_file_path FROM queries WHERE query_id=".$_REQUEST["queryId"];

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult))
			$fileName[] = $rowData["report_file_path"];

		$file = "../uploads/srqueries/" . $fileName[0];
		unlink($file);

		$qryDel = "DELETE FROM queries WHERE query_id=".$_REQUEST["queryId"];
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
		$notes = $_REQUEST['txtNotes'];

		$qryIns = "INSERT INTO job(client_id, mas_Code, job_type_id, period, notes, job_name, job_status_id, job_received)
					VALUES (
					" . $client_Id . ", 
					" . $masCode . ", 
					" . $jobType . ", 
					'" . $period . "',  
					'" . $notes . "',
					'" . $jobName . "',  
					1,  
					NOW()
					)";

		mysql_query($qryIns);
		$jobId = mysql_insert_id();

		$this->add_task($jobType, $period, $_REQUEST["lstPractice"], $client_Id, $jobId);
		
		$this->add_source_Docs($jobId);
		
		return $jobId;
	}
	
	public function add_task($typeId, $period, $practiceId, $clientId, $jobId) {
		
		$taskName = $this->arrClient[$clientId]["client_name"] . ' - ' . $period . ' - ' . $this->arrJobType[$typeId];
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id) 
					VALUES ('" . $taskName . "',
					'" . $practiceId . "',
					'" . $clientId . "',
					'" . $jobId . "'
					)";
		mysql_query($qryIns);			
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
		if($_REQUEST['flagType'] == 'S')
			$folderPath = "../uploads/sourcedocs/" . $fileName;
				
		if($_REQUEST['flagType'] == 'R')
			$folderPath = "../uploads/reports/" . $fileName;
				
		if($_REQUEST['flagType'] == 'Q')
			$folderPath = "../uploads/queries/" . $fileName;
		
		if($_REQUEST['flagType'] == 'SRQ')
			$folderPath = "../uploads/srqueries/" . $fileName;
			
		$arrFileName = explode('~', $fileName);
		$origFileName = $arrFileName[1];

		ob_clean();
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
	
	public function send_mail_practice($jobId)
	{
		 $query ="UPDATE job
				  SET sent_mail_date=NOW()
				  WHERE job_id='$jobId'
  				 ";
		$runQuery = mysql_query($query);
	}
	
	public function view_send_mail_practice($jobId)
	{
		$query ="SELECT sent_mail_date
				 FROM job
				 WHERE job_id='$jobId'
				";
		$runQuery = mysql_query($query);
		
		$sent_mail_date = mysql_fetch_assoc($runQuery);
		$sent_mail_date = $sent_mail_date['sent_mail_date'];
		return $sent_mail_date ;
	}
	

}
?>