<?php
class SavedJobs {
 
	public function __construct() {
  
	}
  
	public function fetch_saved_jobs() {
		
		if(!empty($_REQUEST['lstClientType'])) {
			$appendSelStr = "AND t1.client_id = {$_REQUEST['lstClientType']}";
		} 

		$qrySel = "SELECT t1.job_id, CONCAT_WS(' - ', c1.client_name, t1.period, sa.sub_Description)job_name, t1.job_genre, DATE_FORMAT(t1.job_created_date, '%d/%m/%Y') job_created_date, ss.subform_id, ss.subform_url
                            FROM client c1, sub_subactivity sa, job t1
                            LEFT JOIN setup_subforms ss ON t1.setup_subfrm_id = ss.subform_id
                            WHERE c1.id = '{$_SESSION['PRACTICEID']}'
                            AND t1.client_id = c1.client_id
                            AND t1.discontinue_date IS NULL  
                            AND t1.job_submitted = 'N'
                            AND t1.job_type_id = sa.sub_Code
                            {$appendSelStr}
                            ORDER BY t1.job_id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrjobs[$rowData['job_id']] = $rowData;
		}
		return $arrjobs;	
	}
}
?>