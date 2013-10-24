<?php
class DOCUMENT {
 
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
        
        // fetch source documents
	public function fetch_documents()
	{
		$qrySel = "SELECT t1.document_id, t1.document_title, t1.file_path, t1.file_path,j1.job_id, j1.job_name, j1.job_genre
                            FROM documents t1, job j1, client c1
                            WHERE t1.job_id = j1.job_id
                            AND j1.client_id = c1.client_id
                            AND c1.id = '{$_SESSION['PRACTICEID']}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult))
			$arrDocs[$rowData['job_id']][$rowData['document_id']] = $rowData;

		return $arrDocs;	
	}
}