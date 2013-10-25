<?php

class Template {
 
	public function __construct() {
  
	}
    
    public function fetch_template() {
		$qrySel = "SELECT tm.tmpl_name, tm.tmpl_desc, tm.tmpl_filepath
                    FROM template tm
                    ORDER BY tm.tmpl_order";
	
		$fetchResult = mysql_query($qrySel);
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTemplate[] = $rowData;
		}
		return $arrTemplate;
	}
}
?>