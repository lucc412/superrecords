<?php
class DOCUPLOAD {
 
	public function __construct() {
  
	}

        // fetch pending jobs 
	public function fetchJobs() {
		
		if(!empty($_REQUEST['lstClientType'])) {
			$appendSelStr = "AND t1.client_id = {$_REQUEST['lstClientType']}";
		} 

		$qrySel = "SELECT t1.job_id, CONCAT_WS(' - ', c1.client_name, t1.period, sa.sub_Description)job_name, t1.job_genre, DATE_FORMAT(t1.job_received, '%d/%m/%Y') job_received
                            FROM client c1, sub_subactivity sa, job t1
                            WHERE c1.id = '{$_SESSION['PRACTICEID']}'
                            AND t1.client_id = c1.client_id
                            AND t1.discontinue_date IS NULL  
                            AND t1.job_submitted = 'Y' 
                            AND t1.job_genre <> 'SETUP'
                            AND t1.job_type_id = sa.sub_Code
                            {$appendSelStr}
                            ORDER BY t1.job_id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrjobs[$rowData['job_id']] = $rowData;
		}
		return $arrjobs;	
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
        
}