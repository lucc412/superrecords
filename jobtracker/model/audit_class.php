<?php
class Audit {
 
	public function __construct() {
  
	}

        // show client type as SMSF & job type as Audit Only in add/edit case
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

        // insert new job
	public function sql_insert() 
        {
		$jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];
                    
		$qryIns = "INSERT INTO job(client_id, job_genre, mas_Code, job_type_id, period, notes, job_name, job_status_id, job_created_date)
                            VALUES (
                            '" . $_REQUEST['lstClientType'] . "', 
                            'AUDIT', 
                            " . $_REQUEST['lstCliType'] . ", 
                            " . $_REQUEST['lstJobType'] . ", 
                            '" . $_REQUEST['txtPeriod'] . "',  
                            '" . $_REQUEST['txtNotes'] . "',
                            '" . $jobName . "',  
                            1,      
                            '".date('Y-m-d')."'
                            )";
                
                mysql_query($qryIns);
		$jobId = mysql_insert_id();
                
		return $jobId;
	}

        // update job table
	public function sql_update() {	

		$jobName = $_REQUEST['lstClientType'] .'::'. $_REQUEST['txtPeriod'] .'::'. $_REQUEST['lstJobType'];
		$qryUpd = "UPDATE job
				SET job_type_id = '" . $_REQUEST['lstJobType'] . "',
				mas_Code = '" . $_REQUEST['lstCliType'] . "',
				client_id = '" . $_REQUEST['lstClientType'] . "',
				period = '" . $_REQUEST['txtPeriod'] . "',
				notes = '" . $_REQUEST['txtNotes'] . "',
				job_name = '" . $jobName . "'
				WHERE job_id = '" . $_SESSION['jobId'] . "'";

		mysql_query($qryUpd);
	} 

        // show job details in edit case
	public function fetchJobDetail($jobId) {		

		$qrySel = "SELECT j1.client_id, j1.period, j1.mas_Code, j1.job_type_id, j1.notes, c1.client_name
                            FROM job j1, client c1
                            WHERE j1.job_id = '{$jobId}'
                            AND j1.client_id = c1.client_id";

		$fetchResult = mysql_query($qrySel);		
		$arrJobInfo = mysql_fetch_assoc($fetchResult);
		return $arrJobInfo;	
	}
}
?>