<?php
class Client {
 
	public function __construct() {
  
	}
  
	public function sql_select() {		

		$qrySel = "SELECT t1.client_name, t1.client_id, t1.client_received, t1.client_type_id
					FROM client t1
					WHERE id = '{$_SESSION['PRACTICEID']}'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData;
		}
		return $arrClients;	
	}

	public function fetch_client_name($recid=NULL) {
		
		if(!empty($recid)) $appendStr = "AND t1.client_id <> '{$recid}'";

		$qrySel = "SELECT t1.client_name
					FROM client t1
					WHERE id = '{$_SESSION['PRACTICEID']}'
					{$appendStr} ORDER BY t1.client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[] = $rowData['client_name'];
		}
		return $arrClients;	
	}

	public function fetchType() {		

		$qrySel = "SELECT ct.client_type_id, ct.client_type 
					FROM client_type ct
					ORDER BY ct.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['client_type_id']] = $rowData['client_type'];
		}
		return $arrTypes;
	}

	public function sql_insert() {

		$qryIns = "INSERT INTO client(client_type_id, client_name, id, sr_manager, client_received)
					VALUES (
					" . $_REQUEST['lstType'] . ", 
					'" . $_REQUEST['txtName'] . "', 
					" . $_SESSION['PRACTICEID'] . ", 
					113,
					NOW()
					)";

		mysql_query($qryIns);
		$clientId = mysql_insert_id();

		return $clientId;
	} 

	public function sql_update() {	

		$qryUpd = "UPDATE client
				SET client_type_id = '" . $_REQUEST['lstType'] . "',
				client_name = '" . $_REQUEST['txtName'] . "'
				WHERE client_id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);	
	} 
	
	
}
?>