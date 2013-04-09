<?
if(!empty($returnSet)) {
	$tableCount = 0;
	foreach($returnSet as $key => $arrInfo) {
		foreach($arrInfo as $fieldName => $fieldValue) {
			
			// for drop-down control type
			if($_SESSION['ARRFIELDTYPEX'][$fieldName] == 'DD') {
				$arrReturn[$key][$fieldName] = $arrDDOptions[$fieldName][$fieldValue];
			}
			// for calendar control type
			else if($_SESSION['ARRFIELDTYPEX'][$fieldName] == 'CL') {
				$dateField = "";
				if (isset($fieldValue) && $fieldValue != "") {
					if($fieldValue != "0000-00-00 00:00:00") {
						$dateField = date("d/m/Y",strtotime($fieldValue)); 
					}
				}
				$arrReturn[$key][$fieldName] = $dateField;
			}
			// for text area control type
			else if($_SESSION['ARRFIELDTYPEX'][$fieldName] == 'TA') {
				$arrReturn[$key][$fieldName] = nl2br($fieldValue);
			}
			else {
				$arrReturn[$key][$fieldName] = $fieldValue;
			}
		}
	}
}
?>