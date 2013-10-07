<?
/*	
	Created By -> 10-Apr-13 [Dhiraj Sahu]
	Last Modified By -> 10-Apr-13 [Dhiraj Sahu]
	Description: This page is used for 'Job Report'	
*/

ob_start();
include 'dbclass/commonFunctions_class.php';
include 'dbclass/report_class.php';

if($_SESSION['validUser']) {

	//Get FormCode
	$formcode = $commonUses->getFormCode("Job Report");
	$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

	//If View, Add, Edit, Delete all set to N
	if($access_file_level == 0) {
		echo "You are not authorised to view this file.";
	}
	else {

		// class file object of dbclass/report_class.php
		$objCallUsers = new SR_Report();

		// function call to fetch typex of each field 
		$_SESSION['ARRFIELDTYPEX'] = $objCallUsers->fetch_field_details('job','field_type');

		// function call to fetch title of each field 
		$_SESSION['ARRDISPFIELDS'] = $objCallUsers->fetch_field_details('job','field_title');

		// set name of the main table for this report page
		$reportPageName = 'job';
		
		// set name of the title for this report page
		$reportPageTitle = 'Job Report';
		
		// set file path for this report path
		$reportPagePath = 'job_report.php';

		// to display report in output as per selected criterias
		if((isset($_REQUEST['submit']) && $_REQUEST['submit'] == "Display")) {

			// array of output fields 
			$arrSelected = $_REQUEST['lstSelected'];

			// form array of options for fields that are of DD type
			foreach($arrSelected AS $selectedColumn) {
				$fieldTypex = $_SESSION['ARRFIELDTYPEX'][$selectedColumn];
				if($fieldTypex == 'DD' || $fieldTypex == 'CB' || $fieldTypex == 'RF') {
					// include file to fetch options for drop-down
					include(REPORTDDOPTIONS);
				}
			} 
			
			// to display drop-down of saved reports
			include(REPORTSAVEDREPORT);

			// display generated report data as per selected criterias
			include(REPORTFETCH);
			include("views/report.php");
		}
		// generate CSV file here
		else if((isset($_REQUEST['generate']) && $_REQUEST['generate'] == "generate")) {

			?><html>
				<body><?
					$arrReportData = $_SESSION['REPORTDATA'];
					$flagDisplay = true;
					echo"<table border='1' align='center' bgcolor='#F8F8F8' cellpadding='10'>";
					foreach ($arrReportData AS $userId => $arrData) {
						if($flagDisplay) {
							echo"<tr><td style='font-weight:bold;font-size:15PX;color:#F05729;background-color:#074165;'>S.No.</td>";
							foreach($arrData AS $columnName => $columnValue) {
								$columnName = strtoupper($_SESSION['ARRDISPFIELDS'][$columnName]);
								echo"<td style='font-weight:bold;font-size:15PX;color:#F05729;background-color:#074165;'>".$columnName."</td>";
							}
							echo"</tr>";
							$flagDisplay = false;
						}
					}
					
					$srNoCount = 1;
					foreach($arrReportData AS $userId => $arrData) {
						echo"<tr><td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".$srNoCount++."</td>";
						foreach($arrData AS $columnName => $columnValue) {
							echo"<td style='background-color:#ffffff;color:rgb(0, 0, 0);font-weight:normal;font-size:11pt;'>".stripslashes($columnValue)."</td>";
						}
						echo"</tr>";
					}
					echo"</table>";

					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
					header("Content-Type: application/force-download");
					header("Content-type: application/octet-stream");
					header("Content-Disposition: attachment;filename=report.xls");
					header("Pragma: no-cache");
					header("Expires: 0");
				?></body>
			</html><?
		}
		// to save report
		else if(isset($_REQUEST['SaveReport']) && $_REQUEST['SaveReport'] == 'Save New Report') {
			for ($key=0; $key<5; $key++) {
				if(empty($_REQUEST['lstTypex' . $key]) || empty($_REQUEST['lstCondition' . $key]) ) continue;

				$repFields .= $_REQUEST['lstTypex' . $key] . ',';
				$repConditions .= $_REQUEST['lstCondition' . $key] . ',';
				
				$strCondVal = '';
				if(is_array($_REQUEST['conditionValue' . $key]))
				{
					$countArr = count($_REQUEST['conditionValue' . $key]);

					for ($i=0; $i<$countArr; $i++)
						$strCondVal .= "#".$_REQUEST['conditionValue' . $key][$i];
					
					$repValues .= $strCondVal . ',';
				}
				else
					$repValues .= $_REQUEST['conditionValue' . $key] . ',';

			}

			$userId = $_SESSION['staffcode'];
			$repName = $_REQUEST['txtReportName'];
			$repFields = rtrim($repFields, ',');
			$repConditions = rtrim($repConditions, ',');
			$repValues = rtrim($repValues, ',');
			$repOutputFields = implode(',', $_REQUEST['lstSelected']);

			// fetch all saved reports
			$arrSavedReports = $objCallUsers->fetch_saved_reports($reportPageName);

			$flagRepNameExist = false;
			if(!empty($arrSavedReports)) {
				foreach($arrSavedReports as $reportId => $arrReportDetail) {
					if($repName == $arrReportDetail['report_name']) {
						$flagRepNameExist = true;
						break;
					}
				}
			}

			if(!$flagRepNameExist) {
				$objCallUsers->saveReport($userId, $repName, $repFields, $repConditions, $repValues, $repOutputFields, $reportPageName);

				header('Location: job_report.php');
				exit;
			}
			else {
				header('Location: job_report.php?flagDuplicate=Y');
				exit;
			}
		}
		// to update saved report 
		else if(isset($_REQUEST['UpdateReport']) && $_REQUEST['UpdateReport'] == 'Update Report') {


			for ($key=0; $key<5; $key++) {
			if(empty($_REQUEST['lstTypex' . $key]) || empty($_REQUEST['lstCondition' . $key]) ) continue;

			$repFields .= $_REQUEST['lstTypex' . $key] . ',';
			$repConditions .= $_REQUEST['lstCondition' . $key] . ',';
			
			$strCondVal = '';
			if(is_array($_REQUEST['conditionValue' . $key]))
			{
				$countArr = count($_REQUEST['conditionValue' . $key]);

				for ($i=0; $i<$countArr; $i++)
					$strCondVal .= "#".$_REQUEST['conditionValue' . $key][$i];
				
				$repValues .= $strCondVal . ',';
			}
			else
				$repValues .= $_REQUEST['conditionValue' . $key] . ',';
		}

			$reportId = $_REQUEST['lstReport'];
			$repName = $_REQUEST['txtReportName'];
			$repFields = rtrim($repFields, ',');
			$repConditions = rtrim($repConditions, ',');
			$repValues = rtrim($repValues, ',');
			$repOutputFields = implode(',', $_REQUEST['lstSelected']);

			$objCallUsers->updateSaveReport($reportId, $repName, $repFields, $repConditions, $repValues, $repOutputFields);

			header('Location: job_report.php');
			exit;
		}
		// default case when page is loaded first time
		else {

			// to display drop-down of saved reports
			include(REPORTSAVEDREPORT);
			include("views/report.php");
		}
	}
}
else {
	header("Location:index.php?msg=timeout");
}
?>