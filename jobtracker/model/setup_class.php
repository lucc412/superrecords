<?php
class SETUP {
 
	public function __construct() {
  
	}

        public function fetch_setup_forms() 
	{
		$frmQry = "SELECT * FROM setup_forms";
		$fetchResult = mysql_query($frmQry);		
		
		$subfrmQry = "SELECT * FROM setup_subforms";
		$fetchRow = mysql_query($subfrmQry);
		
		while($rowData = mysql_fetch_assoc($fetchResult)) 
		{
			$arrForms[$rowData['form_id']] = $rowData;
		}
		
		while($row = mysql_fetch_assoc($fetchRow)) 
		{
			$arrSubForms[$row['subform_id']] = $row;
		}
		
		foreach ($arrForms as $key => $value) 
		{
			foreach ($arrSubForms as $val) 
			{
				if($value['form_id'] == $val['form_id'])
					$arrForms[$value['form_id']]['subforms'][] = $val;
			}
		}
		
		return $arrForms;
	}
}