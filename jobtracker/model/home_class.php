<?php

class Home {
 
	public function __construct() {
  
	}
  
	public function check_valid_practice($username, $password) {
		$qrySel = "SELECT pr.id
                    FROM pr_practice pr
                    WHERE pr.email = '$username' 
                    AND pr.password = '$password' ";
	
		$fetchResult = mysql_query($qrySel);
		$rowData = mysql_fetch_assoc($fetchResult);
		$practiceId = $rowData['id'];
		return $practiceId;
	}

	public function get_Practice_Name() {
		$qrySel = "SELECT pr.name
                    FROM pr_practice pr
                    WHERE pr.id = ".$_SESSION['PRACTICEID'];
	
		$fetchResult = mysql_query($qrySel);
		$rowData = mysql_fetch_assoc($fetchResult);
		$prName = $rowData['name'];
		return $prName;
	}
        
        
        public function fetch_practice_password($username) {
		$qrySel = "SELECT pr.password
                    FROM pr_practice pr
                    WHERE pr.email = '$username'";
	
		$fetchResult = mysql_query($qrySel);
		$rowData = mysql_fetch_assoc($fetchResult);
		$prPassword = $rowData['password'];
		return $prPassword;
	}
}
?>