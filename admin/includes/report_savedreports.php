<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is module file used for save reports
*/

// function to fetch all saved reports
$arrSavedReports = $objCallUsers->fetch_saved_reports($reportPageName);

// function to fetch all selected report
if(!empty($_REQUEST['lstReport'])) {
	$arrSelectedReport = $arrSavedReports[$_REQUEST['lstReport']];

	foreach($arrSelectedReport as $repField => $repFieldValue) {
		if($repField == 'report_fields') {
			$arrRepField['report_fields'] = explode(',', $repFieldValue);
		}
		if($repField == 'report_conditions') {
			$arrRepField['report_conditions'] = explode(',', $repFieldValue);
		}
		if($repField == 'report_values') {
			$arrRepField['report_values'] = explode(',', $repFieldValue);
		}
		if($repField == 'report_outputfields') {
			$arrRepField['report_outputfields'] = explode(',', $repFieldValue);
		}
	}

	foreach($arrRepField as $repField => $arrRepFieldInfo) {
		foreach($arrRepFieldInfo as $counterKey => $fieldInfo) {
			if($repField == 'report_fields')
			$_REQUEST['lstTypex'.$counterKey] = $fieldInfo;

			if($repField == 'report_conditions')
			$_REQUEST['lstCondition'.$counterKey] = $fieldInfo;
			
			if($repField == 'report_values')
			$_REQUEST['conditionValue'.$counterKey] = $fieldInfo;

			if($repField == 'report_outputfields') {
				if(!in_array($fieldInfo, $_REQUEST['lstSelected'])) {
					$_REQUEST['lstSelected'][] = $fieldInfo;
				}
			}
		}
	}
}
?>