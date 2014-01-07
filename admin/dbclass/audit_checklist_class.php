<?php
//************************************************************************************************
//  Task          : Class and Functions required for Task management
//  Modified By   : Nishant Bhatt 
//  Created on    : 3-Jan-2014
//  Last Modified : 3-Jan-2014 
//************************************************************************************************  
class Audit_checklist extends Database { 	
	public function __construct() {
		//$this->arrChecklist = $this->fetchChecklist();
  	}	

	public function fetchChecklist()
	{
		if(isset($_SESSION["filter"])){
			if(isset($_SESSION["filter"]) && $_SESSION["wholeonly"] == true)
				$search = " WHERE checklist_name = '".$_SESSION["filter"]."'";
			else
				$search = " WHERE checklist_name like '%".$_SESSION["filter"]."%'";
		}
			
		$qrySel = "SELECT checklist_id cid, checklist_name name, checklist_order corder FROM audit_checklist ".$search." order by checklist_order";

		$fetchResult = mysql_query($qrySel);				
		return $fetchResult;	
	} 
	
	public function fetchSubChecklist($parent_id) {		
		if(isset($_SESSION["filter"])){
				if(isset($_SESSION["filter"]) && $_SESSION["wholeonly"] == true)
					$search = " AND subchecklist_name = '".$_SESSION["filter"]."'";
				else
					$search = " AND subchecklist_name like '%".$_SESSION["filter"]."%'";
		}
		
		$qrySel = "SELECT subchecklist_id sid, checklist_id cid, subchecklist_name name, subchecklist_order corder FROM audit_subchecklist
					WHERE checklist_id = ".$parent_id.$search."
					ORDER BY subchecklist_order";

		$fetchResult = mysql_query($qrySel);		
		return $fetchResult;	
	} 

	public function getFetchCheckListById($id) {		
		$qrySel = "SELECT checklist_id cid, checklist_name name, checklist_order corder FROM audit_checklist 
				WHERE checklist_id = ".$id;
		$fetchResult = mysql_query($qrySel);	
		$fetchResult  = mysql_fetch_array($fetchResult);			
		return $fetchResult;	
	}

	public function getFetchSubCheckListById($id) {	
		$qrySel = "SELECT subchecklist_id sid, checklist_id cid, subchecklist_name name, subchecklist_order corder FROM audit_subchecklist WHERE subchecklist_id = ".$id;
		$fetchResult = mysql_query($qrySel);	
		$fetchResult  = mysql_fetch_array($fetchResult);			
		return $fetchResult;	
	}
	public function maxorder_cid() {		
		$qrySel = "SELECT count(*) corder FROM audit_checklist order by checklist_order";
		$fetchResult = mysql_query($qrySel);
		$fetchResult  = mysql_fetch_object($fetchResult);
		return $fetchResult->corder;	
	}
	
	public function maxorder_sid($pid) {		
		$qrySel = "SELECT count(*) sorder FROM audit_subchecklist WHERE checklist_id =".$pid;
		$fetchResult = mysql_query($qrySel);
		$fetchResult  = mysql_fetch_object($fetchResult);
		return $fetchResult->sorder;	
	}
	
	public function sql_insert($name, $order, $parent_ids) {
		if($parent_ids == 0)		 {		
			$qryIns = "INSERT INTO audit_checklist(checklist_name, checklist_order)
					VALUES (
					'" . $name . "', 
					'" . $order . "'
					)";
		} else {
			$qryIns = "INSERT INTO audit_subchecklist(checklist_id, subchecklist_name, subchecklist_order)
					VALUES (
					".$parent_ids.",
					'" . $name . "', 
					'" . $order . "'
					)";
		}
		mysql_query($qryIns);
	} 

	public function sql_update($name,$parent_ids,$id,$order)
	{		
		if($parent_ids == 0) {

			$qryUpd = "UPDATE audit_checklist
					SET checklist_name = '" . addslashes($name) . "',
					checklist_order = ".$order." 
					WHERE checklist_id = " . $id;
		}
		else {
			$qryUpd = "UPDATE audit_subchecklist
					SET subchecklist_name = '" . addslashes($name) . "',
					checklist_id = '" . $parent_ids . "',
					subchecklist_order = ".$order." 
					WHERE subchecklist_id = '" . $id . "'";
		}			
		mysql_query($qryUpd);	
	}
	
	public function sql_update_order($id,$order, $parent_ids)
	{		
		if($parent_ids == 0) {

			$qryUpd = "UPDATE audit_checklist
					SET checklist_order = ".$order. "
					WHERE checklist_id = " . $id;
		}
		else {
			$qryUpd = "UPDATE audit_subchecklist
					SET subchecklist_order = " . $order . "
					WHERE subchecklist_id = " . $id;
		}			
		mysql_query($qryUpd);	
	}
	
	public function sql_delete_checklist($id) {
		$qryDel = "delete from audit_checklist where checklist_id='".$id."'";
		mysql_query($qryDel);
	}
	
	public function sql_delete_subchecklist($id) {
		$qryDel = "delete from audit_subchecklist where subchecklist_id='".$id."'";
		mysql_query($qryDel);
	}
}
?>