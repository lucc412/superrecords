<?php
class Query {
 
	public function __construct() {
  
	}

	public function fetch_queries() {

		if(!empty($_REQUEST['lstCliType'])) {
			$appendWhrStr = "AND c1.client_id = {$_REQUEST['lstCliType']}";
		}

		if(!empty($_REQUEST['lstJob'])) {
			$appendWhrStr = "AND j1.job_id = {$_REQUEST['lstJob']}";
		}

		$qrySel = "SELECT t1.query_id, t1.query, t1.response,t1.report_file_path, t1.file_path, j1.job_name
					FROM queries t1, job j1, client c1
					WHERE t1.job_id = j1.job_id
					AND j1.client_id = c1.client_id
					AND t1.status = '0'
					AND t1.flag_post = 'Y'
					AND j1.discontinue_date IS NULL  
					AND c1.id = '{$_SESSION['PRACTICEID']}'
					{$appendWhrStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrQueries[$rowData['query_id']] = $rowData;
		}
		return $arrQueries;	
	}

	public function fetch_clients() {		

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

	function timeDiff($firstTime,$lastTime)
	{
		// convert to unix timestamps
		$firstTime=strtotime($firstTime);
		$lastTime=strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$timeDiff=$lastTime-$firstTime;
		$timeDiff = $timeDiff/60;
		// return the difference
		return $timeDiff;
	}

	public function fetchSentTime()
	{		
		$qrySel = "SELECT id, sent_time 
					FROM pr_practice 
					WHERE id = '{$_SESSION['PRACTICEID']}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult))
			$arrSentTime[] = $rowData['sent_time'];

		return $arrSentTime[0];	
	}
	
	public function updateSentTime($crnt_time)
	{
		$query = "UPDATE pr_practice
					SET sent_time = '".$crnt_time."' 
					WHERE id = '{$_SESSION['PRACTICEID']}'";
					
		mysql_query($query);			
	}

	public function fetch_jobs() {		

		if(!empty($_REQUEST['lstCliType'])) {
			$appendWhrStr = "AND c1.client_id = {$_REQUEST['lstCliType']}";
		}

		$qrySel = "SELECT j1.job_id, j1.job_name
					FROM job j1, client c1
					WHERE j1.client_id = c1.client_id
					AND c1.id = '{$_SESSION['PRACTICEID']}'
					AND j1.discontinue_date IS NULL
					AND j1.job_submitted = 'Y'
					{$appendWhrStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJobs[$rowData['job_id']] = $rowData['job_name'];
		}
		return $arrJobs;
	}

	public function fetch_manager_ids($practiceId) {
		$qrySel = "SELECT pr.sr_manager, pr.india_manager
					FROM pr_practice pr
					WHERE pr.id = {$practiceId}";

		$fetchResult = mysql_query($qrySel);  
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrManagerIds = $rowData;
		}

		return $arrManagerIds; 
	}

	public function fetchJobId($queryId) {		
 		$qrySel = "SELECT j.job_id jobId
					FROM job j, queries q
					WHERE j.job_id = q.job_id
					AND q.query_id = {$queryId}";

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);
		$jobId = $rowData['jobId'];
		
		return $jobId;
	}

	public function fetchType() {		
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

	public function sql_update($queryId) {	
		$responseDate = date('Y-m-d');

		$qryUpd = "UPDATE queries
					SET response = '" . addslashes($_REQUEST['txtResponse'.$queryId]) . "',date_answered= '" .$responseDate. "'
					WHERE query_id = '" . $queryId . "'";
			
		mysql_query($qryUpd);

		foreach($_FILES AS $fieldName => $imageInfo){
			if($fieldName == 'doc_'.$queryId) {
				$fileId = str_replace("doc_","",$fieldName);
				$origFileName = stripslashes($_FILES[$fieldName]['name']);
				$filePart = pathinfo($origFileName);
				$dbFileName = $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
				$folderPath = "../uploads/queries/" . $dbFileName;

				if(file_exists($_FILES[$fieldName]['tmp_name'])) {
					if(move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folderPath)) {
						$qryUpd = "UPDATE queries
									SET file_path = '" . $dbFileName . "'
									WHERE query_id = '" . $queryId . "'";
						mysql_query($qryUpd);
					}
				}
			}	
		}
	}

	public function sql_update_all($arrResponse) {
		$responseDate = date('Y-m-d');

		foreach($arrResponse AS $queryId => $strResponse) {
			$whenStr  .= " WHEN query_id = " . $queryId . " THEN '" . addslashes($strResponse) . "' ";
		}

		$qryUpd = "UPDATE queries 
					SET date_answered = '".$responseDate."', response = 
						CASE 
							{$whenStr} 
						END
					WHERE 2";

		mysql_query($qryUpd);

		foreach($_FILES AS $fieldName => $imageInfo) {
			foreach($arrResponse AS $queryId => $strResponse) {
				if($fieldName == 'doc_'.$queryId) {
					$fileId = str_replace("doc_","",$fieldName);
					$origFileName = stripslashes($_FILES[$fieldName]['name']);
					$filePart = pathinfo($origFileName);
					$dbFileName = $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
					$folderPath = "../uploads/queries/" . $dbFileName;

					if(file_exists($_FILES[$fieldName]['tmp_name'])) {
						if(move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folderPath)) {
							$qryUpd = "UPDATE queries
										SET file_path = '" . $dbFileName . "'
										WHERE query_id = '" . $queryId . "'";
							mysql_query($qryUpd);
						}
					}
				}
			}
		}
	}

	public function doc_download($fileName)
	{
		if($_REQUEST['flagType'] == 'PRQ')
			$folderPath = "../uploads/queries/" . $fileName;
		
		if($_REQUEST['flagType'] == 'SRQ')
			$folderPath = "../uploads/srqueries/" . $fileName;
			
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

	public function delete_doc($filePath) {
	
		$folderPath = "../uploads/queries/" . $filePath;
		if(file_exists($folderPath)) {
			unlink($folderPath);
			$qryUpd = "UPDATE queries
						SET file_path = NULL
						WHERE query_id = '" . $_REQUEST['queryId'] . "'";
			mysql_query($qryUpd);
		}
	}
}
?>