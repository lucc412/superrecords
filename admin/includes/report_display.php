<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is module file used to generate reports
*/

$arrCondition = array();

// set request variables after updating report data
if(isset($_REQUEST['flagUpdate'])) {
	$arrOutputFields = array_shift(array_values($_SESSION['REPORTDATA']));
	$_REQUEST['lstSelected'] = array_keys($arrOutputFields);

	foreach($_SESSION['REPCRITERIA'] as $counterKey => $arrRepFieldInfo) {
		foreach($arrRepFieldInfo as $repField => $fieldValue) {
			if($repField == 'typex')
			$_REQUEST['lstTypex'.$counterKey] = $fieldValue;

			if($repField == 'condition')
			$_REQUEST['lstCondition'.$counterKey] = $fieldValue;
			
			if($repField == 'conditionValue')
			$_REQUEST['conditionValue'.$counterKey] = $fieldValue;
		}
	}
}

for ($key=0; $key<5; $key++) {
	if( empty($_REQUEST['lstTypex' . $key]) || empty($_REQUEST['lstCondition' . $key]) ) continue;

	$arrCondition[$key]['typex'] = $_REQUEST['lstTypex' . $key];
	$arrCondition[$key]['condition'] = $_REQUEST['lstCondition' . $key];

	if(!empty($_REQUEST['conditionValue' . $key])) {
		$arrCondition[$key]['conditionValue'] = $_REQUEST['conditionValue' . $key];
		if($_SESSION['ARRFIELDTYPEX'][$_REQUEST['lstTypex' . $key]] == 'CL') {
			$originalDate = $_REQUEST['conditionValue' . $key];
			$newDate = $commonUses->getDateFormat($originalDate);

			$arrCondition[$key]['conditionValue'] = $newDate;
		}
	}
	else if(!empty($_REQUEST['fromDate' . $key]) && !empty($_REQUEST['toDate' . $key])) {
		$fromDate= $_REQUEST['fromDate' . $key];
		$toDate= $_REQUEST['toDate' . $key];

		$newFromDate = $commonUses->getDateFormat($fromDate);
		$newToDate = $commonUses->getDateFormat($toDate);

		$arrCondition[$key]['fromDate'] = $newFromDate;
		$arrCondition[$key]['toDate'] = $newToDate;
	}
}

// set all conditions/criterias in session
if(isset($_SESSION['REPCRITERIA'])) unset($_SESSION['REPCRITERIA']);
$_SESSION['REPCRITERIA'] = $arrCondition;

// form a string of selected columns to be displayed in report
$strColumns = "";
foreach($arrSelected AS $value) {
	$strColumns .= 'tbl.' . $value . ",";
}
$strColumns = rtrim($strColumns, ",");

// form a string of selected columns to be displayed in report
if(!empty($arrCondition)) {
	foreach($arrCondition AS $key => $arrInfo) {
		$typex = $arrInfo['typex'];
		$condition = $arrInfo['condition'];
		$conditionValue = $arrInfo['conditionValue'];
		$usergroupId = $arrInfo['headerInfo'];
		$fromDate = $arrInfo['fromDate'];
		$toDate = $arrInfo['toDate'];

		$strCondition .= ' AND ';
		if($condition == 'Equal to' || $condition == 'On') {
			$strCondition .= "{$typex} = '{$conditionValue}' ";
		}
		elseif($condition == 'Not equal to') {
			$strCondition .= "{$typex} <> '{$conditionValue}' ";
		}
		elseif($condition == 'Starts with') {
			$strCondition .= "{$typex} LIKE '{$conditionValue}%' ";
		}
		elseif($condition == 'Contains any part of word') {
			$strCondition .= "{$typex} LIKE '%{$conditionValue}%' ";
		}
		elseif($condition == 'Before') {
			$strCondition .= "{$typex} < '{$conditionValue}' ";
		} 
		elseif($condition == 'After') {
			$strCondition .= "{$typex} > '{$conditionValue}' ";
		}
		elseif($condition == 'On or Before') {
			$strCondition .= "{$typex} <= '{$conditionValue}' ";
		}
		elseif($condition == 'On or After') {
			$strCondition .= "{$typex} >= '{$conditionValue}' ";
		}
		elseif($condition == 'In Between') {
			$strCondition .= "{$typex} BETWEEN '{$fromDate}' AND  '{$toDate}' "; 
		}
	}
}

// function call to display all users with their entity fields selected for pdf
$arrReportData = $objCallUsers->view_entity_report($strColumns, $strCondition, $arrDDOptions, $reportPageName);
?>