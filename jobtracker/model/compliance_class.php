<?php
class COMPLIANCE {
 
	public function __construct() {
  
	}
  
	public function sql_select($fetchType=NULL) {
		
                if(!empty($fetchType) && ($fetchType == 'duplicate')) {
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

	public function fetchType($masCode=NULL) {		
		if(!empty($masCode)) {
			$appendStr = "AND ma.mas_Code = {$masCode}";
		}

 		$qrySel = "SELECT sa.sub_Code, sa.sub_Description
                            FROM mas_masteractivity ma, sub_subactivity sa
                            WHERE ma.mas_Code = sa.sas_Code
                            /*AND sa.display_in_practice = 'yes'*/
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

	public function sql_insert() 
        {
            $jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];

            $qryIns = "INSERT INTO job(client_id, job_genre, job_submitted, mas_Code, job_type_id, period, notes, job_name, job_status_id, job_created_date, job_received, job_due_date)
                        VALUES (
                        '" . $_REQUEST['lstClientType'] . "', 
                        'COMPLIANCE', 
                        'Y', 
                        " . $_REQUEST['lstCliType'] . ", 
                        " . $_REQUEST['lstJobType'] . ", 
                        '" . $_REQUEST['txtPeriod'] . "',  
                        '" . $_REQUEST['txtNotes'] . "',
                        '" . $jobName . "',  
                        1,     
                        '".date('Y-m-d')."',  
                        '".date('Y-m-d')."',
                        '".date('Y-m-d', strtotime("+2 week"))."'
                        )";

            mysql_query($qryIns);
            $jobId = mysql_insert_id();

            // add new task
            add_new_task($_REQUEST['lstJobType'], $jobId);
            
            // add source documents
            $this->add_source_Docs($jobId);

            return $jobId;
	}
        
	public function add_source_Docs($jobId) {

		$qrySel = "SELECT max(document_id) docId 
					FROM documents";
		$objResult = mysql_query($qrySel);
		$arrInfo = mysql_fetch_assoc($objResult);
		$fileId = $arrInfo['docId'];
		$currentTime = date('Y-m-d H:i:s');

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
									'".$currentTime."'
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
		$fileId++;
		$currentTime = date('Y-m-d H:i:s');
                
		$origFileName = stripslashes($_FILES['fileDoc']['name']);
		$filePart = pathinfo($origFileName);
		$fileName =  $fileId . '~' . $filePart['filename'] . '.' . $filePart['extension'];
                
                
                $jobQry = "SELECT job_genre FROM job WHERE job_id = ".$_REQUEST['lstJob'];        
                $objRes = mysql_query($jobQry);
		$jobData = mysql_fetch_assoc($objRes);
                $job_genre = $jobData['job_genre'];
                                
		if($job_genre == 'AUDIT')
			$folderPath = "../uploads/audit/" . $fileName;
		else if($job_genre == 'COMPLIANCE')
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
        
	public function fetchJobDetail($jobId) {		

		$qrySel = "SELECT j1.client_id, j1.period, j1.mas_Code, j1.job_type_id, j1.notes
                            FROM job j1
                            WHERE j1.job_id = '{$jobId}'";

		$fetchResult = mysql_query($qrySel);		
		$arrJobInfo = mysql_fetch_assoc($fetchResult);
		return $arrJobInfo;	
	}
}
?>