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

	public function doc_download($fileName) {
	
		$folderPath = "../uploads/template/" . $fileName;
		$arrFileName = stringToArray('~', $fileName);
		$origFileName = $arrFileName[1];
		header("Expires: 0");  
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
		header("Cache-Control: no-store, no-cache, must-revalidate");  
		header("Cache-Control: post-check=0, pre-check=0", false);  
		header("Pragma: no-cache");
		header("Content-type: application/doc");  
		// tell file size  
		header('Content-length: '.filesize($folderPath));  
		// set file name  
		header('Content-disposition: attachment; filename="'.$origFileName.'"');  
		readfile($folderPath);  
		 
		// Exit script. So that no useless data is output-ed.  
		exit;   
	}
}
?>