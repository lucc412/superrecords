<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is module file used to fetch data of reports
*/

if(!empty($returnSet)) {
	$tableCount = 0;
	foreach($returnSet as $key => $arrInfo) {
		foreach($arrInfo as $fieldName => $fieldValue) {
			$fieldTypex = $_SESSION['ARRFIELDTYPEX'][$fieldName];
			
			// for drop-down control type
			if($fieldTypex == 'DD' || $fieldTypex == 'RF') {
				$arrReturn[$key][$fieldName] = $arrDDOptions[$fieldName][$fieldValue];
			}
			
			// for drop-down control type
			else if($fieldTypex == 'CB') {
				$arrCBId = explode(",",$fieldValue);
				
				$strCBData = '';
				for($i=0; $i<count($arrCBId); $i++)
					$strCBData .= $arrDDOptions[$fieldName][$arrCBId[$i]].", ";
					
				$strCBData = rtrim($strCBData,", ");					
				$arrReturn[$key][$fieldName] = $strCBData;
			}
			
			// for calendar control type
			else if($fieldTypex == 'CL') {
				$dateField = "";
				if (isset($fieldValue) && $fieldValue != "") {
					if($fieldValue != "0000-00-00 00:00:00") {
						$dateField = date("d/m/Y",strtotime($fieldValue)); 
					}
				}
				$arrReturn[$key][$fieldName] = $dateField;
			}
			// for text area control type
			else if($fieldTypex == 'TA') {
				$arrReturn[$key][$fieldName] = nl2br($fieldValue);
			}
			else {
				$arrReturn[$key][$fieldName] = $fieldValue;
			}
		}
	}
}
?>