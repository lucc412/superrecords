<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is module file used to display value in Report conditions
*/

$valueStr = "";
$arrCondition = array();

if($typex == 'TB' || $typex == 'TA') {   
	$valueStr .= 'Value<input type="text" name="conditionValue' . $key . '" id="conditionValue' . $key . '" value="' . $_REQUEST['conditionValue'.$key] . '" />';
}
else if($typex == 'DD' || $typex == 'CB' || $typex == 'RF') {
	$arrOptions = array();
	$selectedColumn = $colName;

	// include file to fetch options for drop-down
	include(REPORTDDOPTIONS);

	$arrOptions = $arrDDOptions[$selectedColumn];
	
	$selectMultiple = '';
	$selectMultipleHeight = '';
	$selectName = '';
	
	if($typex == 'CB')
	{
		$selectMultiple = 'multiple="multiple"';
		$selectMultipleHeight = ' style="height:36px; margin-bottom:-16px;"';
		$selectName = '[]';
	}

	$valueStr .= 'Value<select '.$selectMultiple.$selectMultipleHeight.' name="conditionValue' . $key .$selectName. '" id="conditionValue' . $key . '">';
	foreach ($arrOptions AS $intKey => $strOption) {
		$strSelected = "";
		if($typex == 'CB')
		{
			if(in_array($intKey,$_REQUEST['conditionValue'.$key])) $strSelected = 'selected';
		}
		if($typex == 'CB' && strstr($_REQUEST['conditionValue'.$key],"#"))
		{
			$arrDDFieldVal = explode("#",$_REQUEST['conditionValue'.$key]);	
			if(in_array($intKey,$arrDDFieldVal)) $strSelected = 'selected';
		}
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