<?
$conditionStr = "";
$arrCondition = array();

if($typex == 'TB' || $typex == 'TA') {
	$arrCondition = array("Equal to","Not equal to","Starts with","Contains any part of word");
}
else if($typex == 'DD' || $typex == 'CB') {
	$arrCondition = array("Equal to","Not equal to");
}
else if($typex == 'CL') {
	$arrCondition = array('On','Before','After','On or Before','On or After','In Between');
}
else {
	$arrCondition = array('--Please Select--');
}

$conditionStr .= 'Condition<select name="lstCondition' . $key . '" id="lstCondition' . $key . '" onchange="javascript:addDateTextbox(this.value,' . ' \'' . $colName . '\',' . $key . ')">';
    
foreach ($arrCondition AS $condition) {
	$strSelected = "";
	if($_REQUEST['lstCondition'.$key] == $condition) $strSelected = 'selected';
	$conditionStr .= '<option ' . $strSelected . '>' . $condition . '</option>';
}

$conditionStr .= '</select>';
$returnStr = $conditionStr;
?>