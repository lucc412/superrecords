<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is class file for all reports page	
*/

class SR_Report {
 
	// class constructor
	public function __construct() {

	}
	
	// This will fetch all fields and it's typex / title
	public function fetch_field_details($reportPageName, $fieldInfo) {
		$qrySel = "SELECT rf.field_name, rf.{$fieldInfo}
                            FROM report_fields rf
                            WHERE rf.page_name = '{$reportPageName}'
                            ORDER BY rf.field_order ";
		$fetchResult = mysql_query($qrySel);
		
		while($row = mysql_fetch_assoc($fetchResult))
             $arrColumns[$row['field_name']] = $row[$fieldInfo];    

		return $arrColumns;
	}
  
  	// This will generate report function
	public function view_entity_report($strColumns, $flagOtherTable, $strCondition, $arrDDOptions, $reportPageName) {

		if($_SESSION["usertype"] == "Staff") {
			$flagOtherTable = true;
			$staffId = $_SESSION["staffcode"];

			switch($reportPageName) {

				// for lead page report case
				case "lead":
					if($staffId != '112' && $staffId != '114') {
						$strWhere ="AND tbl.sr_manager=".$staffId;
					}
				break;
				
				// for practice page report case
				case "pr_practice":
						$strWhere = "AND ( tbl.sr_manager = ".$staffId." 
							OR tbl.india_manager = ".$staffId."
							OR tbl.sales_person = ".$staffId."
							OR tbl.audit_manager = ".$staffId.")";
				break;

				// for client page report case
				case "client":
						$strWhere = "AND (pr.sr_manager=".$staffId." 
							OR pr.india_manager=".$staffId." 
                                                        OR pr.audit_manager=".$staffId."
							OR tbl.team_member=".$staffId ." 
                                                        OR tbl.sr_accnt_comp=".$staffId ." 
                                                        OR tbl.sr_accnt_audit=".$staffId ." 
							OR pr.sales_person=".$staffId . ")";
				break;	

				// for job page report case
				case "job":
						$strWhere = "AND (pr.sr_manager=".$staffId." 
							OR pr.india_manager=".$staffId." 
							OR pr.audit_manager=".$staffId." 
							OR cl.team_member=".$staffId ." 
							OR cl.sr_accnt_comp=".$staffId ." 
							OR cl.sr_accnt_audit=".$staffId ." 
							OR pr.sales_person=".$staffId . ")";
				break;

				// for task page report case
				case "task":
						$strWhere = "AND (pr.sr_manager=".$staffId." 
							OR pr.india_manager=".$staffId." 
							OR pr.audit_manager=".$staffId." 
							OR cl.team_member=".$staffId ." 
							OR cl.sr_accnt_comp=".$staffId ." 
							OR cl.sr_accnt_audit=".$staffId ." 
							OR pr.sales_person=".$staffId . ")";
				break;
			}
		}

		// set where condition for the query [to fetch sr manager, india manager, team member]
		if(!empty($flagOtherTable)) {
			$strAnd = '';
			
			switch($reportPageName) {

				// for client page report case
				case "client":
						$otherTable = ", pr_practice pr";
						$strAnd = "	AND tbl.id = pr.id";
				break;

				// for job page report case
				case "job":
						$otherTable = ", client cl, pr_practice pr";
						$strAnd = "	AND tbl.client_id = cl.client_id
									AND cl.id = pr.id";
				break;

				// for task page report case
				case "task":
						$otherTable = ",job j, client cl, pr_practice pr";
						$strAnd = "	AND tbl.job_id = j.job_id
									AND j.client_id = cl.client_id
									AND cl.id = pr.id";
				break;
			}
		}

		// order by clause
		switch($reportPageName)
		{
			// for lead page report case
			case "lead":
				$orderBy = "ORDER BY tbl.id desc";
				break;
			
			// for client page report case
			case "client":
					$orderBy = "ORDER BY tbl.client_id desc";
				break;	
			
			// for job page report case
			case "job":
					$strFirstWhr = "AND tbl.discontinue_date IS NULL AND tbl.job_submitted = 'Y'";
					$orderBy = "ORDER BY tbl.job_id desc";
				break;			  
				 
			// for practice page report case
			case "pr_practice":
					$orderBy = "ORDER BY tbl.id desc";
				break;	
				
			// for task page report case
			case "task":
					$strFirstWhr = "AND tbl.discontinue_date = '0000-00-00' ";
					$orderBy = "ORDER BY tbl.task_id desc";
				break;
		}

		$qrySel = "SELECT {$strColumns}
				   FROM {$reportPageName} tbl {$otherTable}
				   WHERE 1
				   {$strFirstWhr}
				   {$strWhere}
				   {$strAnd}
				   {$strCondition}
				   {$orderBy}";
			
		$fetchResult = mysql_query($qrySel);
		while($row = mysql_fetch_assoc($fetchResult)) {
			$returnSet[] = $row;
		}

		if(isset($_SESSION['OUTPUTDATA'])) unset($_SESSION['OUTPUTDATA']);
		$_SESSION['OUTPUTDATA'] = $returnSet;

		include(REPORTDISPLAY);

		return $arrReturn;
	}

	// This will fetch possible options of fields DD control type
	public function fetch_dd_options($tableName, $selField1, $selField2, $tableOrder=NULL, $strWhere=NULL) 
	{
		if(!empty($tableOrder))
			$strOrder = "ORDER BY tbl.{$tableOrder}";
		
		if(!empty($strWhere))
			$strWhere = "WHERE ".$strWhere;
		
		$qrySel = "SELECT tbl.{$selField1}, tbl.{$selField2}
					FROM {$tableName} tbl 
					{$strWhere}
					{$strOrder}";
	
		$fetchResult = mysql_query($qrySel);
		$totRows = mysql_num_rows($fetchResult);

		if(!empty($totRows)) {
			while($row = mysql_fetch_assoc($fetchResult)) {
				$returnSet[$row[$selField1]] = $row[$selField2]; 
			}
		}
		
		return $returnSet;
  	}

	// This will fetch employees contact information
	public function fetchEmployees($designationId) {
	
		$qrySel = "SELECT stf_Code, CONCAT_WS(' ',c1.con_Firstname, c1.con_Lastname) empName 
                            FROM stf_staff t1, aty_accesstype t2, con_contact c1
                            WHERE t1.stf_AccessType = t2.aty_Code 
                            AND t1.stf_CCode = c1.con_Code 
                            AND t2.aty_Description like 'Staff'
                            AND c1.con_Designation = '{$designationId}'
                            ORDER BY c1.con_Firstname";
		 
		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSrManager[$rowData['stf_Code']] = $rowData['empName'];
		}
		
		return $arrSrManager;	
	} 

	// This will fetch job names
	public function fetchJobName($selectedColumn) {
	
		$qrySel = "SELECT j.job_id, CONCAT_WS(' - ', c.client_name, j.period, m.sub_Description) jobName, j.job_name
                            FROM job j, client c, sub_subactivity m
                            WHERE j.client_id = c.client_id
                            AND j.job_type_id = m.sub_code
                            AND j.discontinue_date IS NULL";
		 
		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult))
		{
			$arrJobName[$rowData[$selectedColumn]] = $rowData['jobName'];
		}
		return $arrJobName;	
	} 

	// This will fetch all saved reports
	public function fetch_saved_reports($reportPageName) {
		$qrySel = "SELECT * 
                            FROM sr_savereport
                            WHERE user_id = ".$_SESSION['staffcode']."
                            AND report_page_name = '{$reportPageName}'
                            ORDER BY report_name";
	
		$fetchResult = mysql_query($qrySel);
		while($rowInfo = mysql_fetch_assoc($fetchResult)) {
			$arrSavedReports[$rowInfo['report_id']] = $rowInfo;
		}

		return $arrSavedReports;
	}

	// This will insert all fields for save report
	public function saveReport($userId, $repName, $repFields, $repConditions, $repValues, $repOutputFields, $reportPageName) {

		$qrySel = "INSERT INTO sr_savereport(user_id, report_name, report_fields, report_conditions, report_values, report_outputfields, report_page_name)
                            VALUES('{$userId}', 
                                    '" . addslashes($repName) . "', 
                                    '{$repFields}', 
                                    '{$repConditions}', 
                                    '" . addslashes($repValues) . "', 
                                    '{$repOutputFields}',
                                    '{$reportPageName}'
                            )";
			
		mysql_query($qrySel);
	}

	// This will update saved report
	public function updateSaveReport($reportId, $repName, $repFields, $repConditions, $repValues, $repOutputFields) {

		$qryUpd = "UPDATE sr_savereport
                            SET report_fields = '{$repFields}',
                            report_conditions = '{$repConditions}',
                            report_values = '" . addslashes($repValues) . "', 
                            report_outputfields = '{$repOutputFields}',
                            report_name = '" . addslashes($repName) . "'
                            WHERE report_id = '{$reportId}'";

		mysql_query($qryUpd);
	}
}
?>