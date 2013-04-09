<?
$valueStr = "";
$arrCondition = array();

if($typex == 'TB' || $typex == 'TA') {   
	$valueStr .= 'Value<input type="text" name="conditionValue' . $key . '" id="conditionValue' . $key . '" value="' . $_REQUEST['conditionValue'.$key] . '" />';
}
else if($typex == 'DD' || $typex == 'CB') {
	$arrOptions = array();
	$selectedColumn = $colName;

	// include file to fetch options for drop-down
	include(REPORTDDOPTIONS);

	$arrOptions = $arrDDOptions[$selectedColumn];

	$valueStr .= 'Value<select name="conditionValue' . $key . '" id="conditionValue' . $key . '">';
	foreach ($arrOptions AS $intKey => $strOption) {
		$strSelected = "";
		if($_REQUEST['conditionValue'.$key] == $intKey) $strSelected = 'selected';
		$valueStr .= '<option ' . $strSelected . ' value=' . $intKey . '>' . $strOption . '</option>';
	}

	$valueStr .= '</select>';
}
// for calendar control
else if($typex == 'CL') {
	if($option != 'between') {
			// this function is called from include/php_functions.php file
		   $textBoxName = 'conditionValue' . $key;
		   $showCalendar = $commonUses->showCalendar($textBoxName, $_REQUEST['conditionValue'.$key]);
		   $valueStr .= 'Value' . $showCalendar . '&nbsp;';
	}
	else {
		   $fromName = 'fromDate' . $key;
		   $toName = 'toDate' . $key;
   
		   // this function is called from include/php_functions.php file
		   $showFromCalendar = $commonUses->showCalendar($fromName, $_REQUEST[$fromName]);
		   $showToCalendar = $commonUses->showCalendar($toName, $_REQUEST[$toName]);
   
		   $valueStr .= 'Value&nbsp;&nbsp;From' . $showFromCalendar . '&nbsp;';
		   $valueStr .= '&nbsp;&nbsp;To' . $showToCalendar . '&nbsp;';
	}
}
$returnStr = $valueStr;
?>