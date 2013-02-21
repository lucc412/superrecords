<?php
class worksheetDbquery extends Database
{

		function sql_select($clientCode="",&$count,&$filter,&$filterfield,&$wholeonly)
		{
		  if($clientCode > 0)
		  {
			   $client_cond = " AND lp1.`cli_Code` = '$clientCode'";
		  }
		  else
		  {
			 $client_cond = "";
		  }
		  global $order;
		  global $ordtype;
                  global $commonUses;
                 
		  $filterstr = $commonUses->sqlstr($filter);
		  if (!$wholeonly && isset($wholeonly) && $filterstr!='0')
		  {
		  $filterstr = "%" .$filterstr ."%";
		  }
		  if($_SESSION['usertype']=="Administrator")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		    $sql = "SELECT * FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, t1.`wrk_crmnotes`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition.") subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" AND wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" AND wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" and lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, t1.`wrk_crmnotes`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` )  where (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode'].") ".$reportcondition." )   subq";
		  }
		  else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, t1.`wrk_crmnotes`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition.") subq";
		  }

		if (isset($filterstr) && $filterstr!='0' && isset($filterfield) && $filterfield!='0') {
			$sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
		  } elseif (isset($filterstr) && $filterstr) {
			$sql .= " where (`wrk_Code` like '" .$filterstr ."') or (`lp_wrk_ClientCode` like '" .$filterstr ."') or (`lp_wrk_ClientContact` like '" .$filterstr ."') or (`lp_wrk_MasterActivity` like '" .$filterstr ."') or (`lp_wrk_SubActivity` like '" .$filterstr ."') or (`lp_wrk_Priority` like '" .$filterstr ."') or (`lp_wrk_Status` like '" .$filterstr ."') or (`lp_wrk_TeamInCharge` like '" .$filterstr ."') or (`lp_wrk_StaffInCharge` like '" .$filterstr ."') or (`lp_wrk_ManagerInChrge` like '" .$filterstr ."') or (`lp_wrk_SeniorInCharge` like '" .$filterstr ."') or (`wrk_DueDate` like '" .$filterstr ."') or (`wrk_InternalDueDate` like '" .$filterstr ."') or (`wrk_DueTime` like '" .$filterstr ."') or (`wrk_ClosedDate` like '" .$filterstr ."') or (`wrk_ClosureReason` like '" .$filterstr ."') or (`wrk_HoursSpent` like '" .$filterstr ."') or (`wrk_Details` like '" .$filterstr ."') or (`wrk_Resolution` like '" .$filterstr ."') or (`wrk_Notes` like '" .$filterstr ."') or (`wrk_TeamInChargeNotes` like '" .$filterstr ."') or (`wrk_RelatedCases` like '" .$filterstr ."') or (`wrk_Recurring` like '" .$filterstr ."') or (`lp_wrk_Schedule` like '" .$filterstr ."') or (`wrk_Date` like '" .$filterstr ."') or (`wrk_Day` like '" .$filterstr ."') or (`wrk_Createdby` like '" .$filterstr ."') or (`wrk_Createdon` like '" .$filterstr ."') or (`wrk_Lastmodifiedby` like '" .$filterstr ."') or (`wrk_Lastmodifiedon` like '" .$filterstr ."')";
		  }
		  if (isset($order) && $order!='')
			  $sql .= " order by `" .$commonUses->sqlstr($order) ."`" ;
		  else
			 $sql .= " order by wrk_InternalDueDate ASC";
		   if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
	 	   $res = mysql_query($sql) or die(mysql_error());
                    $count = mysql_num_rows($res);
		   return $res;
		}
		// record count
		function sql_getrecordcount($clientCode="")
		{
		  global $order;
		  global $ordtype;
		  global $filter;
		  global $filterfield;
		  global $wholeonly;
		  global $commonUses;
                  
		  if($clientCode > 0)
		  {
			   $client_cond = " AND lp1.`cli_Code` = '$clientCode'";
		  }
		  else
		  {
			 $client_cond = "";
		  }
		  $filterstr = $commonUses->sqlstr($filter);
		  $filterstr = $commonUses->sqlstr($filter);
		  if (!$wholeonly && isset($wholeonly) && $filterstr!='')
		  {
		  $filterstr = "%" .$filterstr ."%";
		  }
		   if($_SESSION['usertype']=="Administrator")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT count(*) FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition.") subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" AND wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" AND wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
			else
		  {
			$reportcondition=" AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
			$sql = "SELECT count(*) FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) where (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode'].") ".$reportcondition." )   subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT count(*) FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` )  ".$reportcondition.")  subq";
		  }
		  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
			$sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
		  } elseif (isset($filterstr) && $filterstr!='') {
			$sql .= " where (`wrk_Code` like '" .$filterstr ."') or (`lp_wrk_ClientCode` like '" .$filterstr ."') or (`lp_wrk_ClientContact` like '" .$filterstr ."') or (`lp_wrk_MasterActivity` like '" .$filterstr ."') or (`lp_wrk_SubActivity` like '" .$filterstr ."') or (`lp_wrk_Priority` like '" .$filterstr ."') or (`lp_wrk_Status` like '" .$filterstr ."') or (`lp_wrk_TeamInCharge` like '" .$filterstr ."') or (`lp_wrk_StaffInCharge` like '" .$filterstr ."') or (`lp_wrk_ManagerInChrge` like '" .$filterstr ."') or (`lp_wrk_SeniorInCharge` like '" .$filterstr ."') or (`wrk_DueDate` like '" .$filterstr ."') or (`wrk_InternalDueDate` like '" .$filterstr ."') or  (`wrk_DueTime` like '" .$filterstr ."') or (`wrk_ClosedDate` like '" .$filterstr ."') or (`wrk_ClosureReason` like '" .$filterstr ."') or (`wrk_HoursSpent` like '" .$filterstr ."') or (`wrk_Details` like '" .$filterstr ."') or (`wrk_Resolution` like '" .$filterstr ."') or (`wrk_Notes` like '" .$filterstr ."') or (`wrk_TeamInChargeNotes` like '" .$filterstr ."') or (`wrk_RelatedCases` like '" .$filterstr ."') or (`wrk_Recurring` like '" .$filterstr ."') or (`lp_wrk_Schedule` like '" .$filterstr ."') or (`wrk_Date` like '" .$filterstr ."') or (`wrk_Day` like '" .$filterstr ."') or (`wrk_Createdby` like '" .$filterstr ."') or (`wrk_Createdon` like '" .$filterstr ."') or (`wrk_Lastmodifiedby` like '" .$filterstr ."') or (`wrk_Lastmodifiedon` like '" .$filterstr ."')";
		  }
		  $res = mysql_query($sql) or die(mysql_error());
		  $row = mysql_fetch_assoc($res);
		  reset($row);
		  return current($row);
		}
		function sql_select_users(&$count)
		{
		  global $order;
		  global $ordtype;
		  global $filter;
		  global $filterfield;
		  global $wholeonly;
                  global $commonUses;

		  if($clientCode > 0)
		  {
			   $client_cond = " AND lp1.`cli_Code` = '$clientCode'";
		  }
		  else
		  {
			 $client_cond = "";
		  }
		  $filterstr = $commonUses->sqlstr($filter);
		  if (!$wholeonly && isset($wholeonly) && $filterstr!='')
		  {
		  $filterstr = "%" .$filterstr ."%";
		  }
		  if($_SESSION['usertype']=="Administrator")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			 $reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		   $sql = "SELECT * FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode` AS `wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition." ) subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" AND wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" AND wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
			else
		  {
			$reportcondition=" and lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode` AS `wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` )  where (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode'].") ".$reportcondition."  )   subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
		  {
		  if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode` AS `wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition."  ) subq";
		  }
		if ((isset($filterstr) && $filterstr!='') && (isset($filterfield) && $filterfield)) {
			$sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
		  } elseif (isset($filterstr) && $filterstr!='') {
			$sql .= " where (`wrk_Code` like '" .$filterstr ."') or (`lp_wrk_ClientCode` like '" .$filterstr ."') or (`lp_wrk_ClientContact` like '" .$filterstr ."') or (`lp_wrk_MasterActivity` like '" .$filterstr ."') or (`lp_wrk_SubActivity` like '" .$filterstr ."') or (`lp_wrk_Priority` like '" .$filterstr ."') or (`lp_wrk_Status` like '" .$filterstr ."') or (`lp_wrk_TeamInCharge` like '" .$filterstr ."') or (`lp_wrk_StaffInCharge` like '" .$filterstr ."') or (`lp_wrk_ManagerInChrge` like '" .$filterstr ."') or (`lp_wrk_SeniorInCharge` like '" .$filterstr ."') or (`wrk_DueDate` like '" .$filterstr ."') or (`wrk_InternalDueDate` like '" .$filterstr ."') or (`wrk_DueTime` like '" .$filterstr ."') or (`wrk_ClosedDate` like '" .$filterstr ."') or (`wrk_ClosureReason` like '" .$filterstr ."') or (`wrk_HoursSpent` like '" .$filterstr ."') or (`wrk_Details` like '" .$filterstr ."') or (`wrk_Resolution` like '" .$filterstr ."') or (`wrk_Notes` like '" .$filterstr ."') or (`wrk_TeamInChargeNotes` like '" .$filterstr ."') or (`wrk_RelatedCases` like '" .$filterstr ."') or (`wrk_Recurring` like '" .$filterstr ."') or (`lp_wrk_Schedule` like '" .$filterstr ."') or (`wrk_Date` like '" .$filterstr ."') or (`wrk_Day` like '" .$filterstr ."') or (`wrk_Createdby` like '" .$filterstr ."') or (`wrk_Createdon` like '" .$filterstr ."') or (`wrk_Lastmodifiedby` like '" .$filterstr ."') or (`wrk_Lastmodifiedon` like '" .$filterstr ."')";
		  }
		 $sql .= " Group By wrk_ClientCode";
         
		   $res = mysql_query($sql) or die(mysql_error());
		   $count = mysql_num_rows($res);
		   
		   return $res;
		}
		function sql_getrecordcount_users()
		{
		  global $order;
		  global $ordtype;
		  global $filter;
		  global $filterfield;
		  global $wholeonly;
                  global $commonUses;
                  
		  if($clientCode > 0)
		  {
			   $client_cond = " AND lp1.`cli_Code` = '$clientCode'";
		  }
		  else
		  {
			 $client_cond = "";
		  }
		  $filterstr = $commonUses->sqlstr($filter);
		  $filterstr = $commonUses->sqlstr($filter);
		  if (!$wholeonly && isset($wholeonly) && $filterstr!='')
		  {
		  $filterstr = "%" .$filterstr ."%";
		  }
		   if($_SESSION['usertype']=="Administrator")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode` AS `wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) ".$reportcondition." ) subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" AND wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" AND wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
			$sql = "SELECT * FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` ) where (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode'].") ".$reportcondition." )   subq";
		  }
		   else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
		  {
			if($_GET['wid']!="" && isset($_GET['wid']))
		  {
		  $reportcondition=" where wrk_Code=".$_GET['wid']." AND lp22.cty_Description !='Discontinued'";
		  }
		  elseif($_GET['recid']!="" && ($_GET['a']=="edit" || $_GET['a']=="view"))
		  {
			  $reportcondition=" where wrk_Code=".$_GET['recid']." AND lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  else
		  {
			$reportcondition=" where lp22.cty_Description !='Discontinued' AND t1.wrk_ClosedDate ='0000-00-00'";
		  }
		  $sql = "SELECT * FROM (SELECT  lp22.cty_Description ,t1.`wrk_Rptid`,t1.`wrk_Code`, t1.`wrk_ClientCode`, lp1.`name` AS `lp_wrk_ClientCode`, t1.`wrk_ClientContact`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`, t1.`wrk_MasterActivity`, t1.`wrk_crmnotes`, lp3.`mas_Description` AS `lp_wrk_MasterActivity`, lp3.`Code` AS `lp_wrk_Code`, t1.`wrk_SubActivity`, lp4.`sub_Description` AS `lp_wrk_SubActivity`, lp4.`Code` AS `lp_wrk_subCode`, t1.`wrk_Priority`, lp5.`pri_Description` AS `lp_wrk_Priority`, t1.`wrk_Status`, lp6.`wst_Description` AS `lp_wrk_Status`, t1.`wrk_TeamInCharge`, CONCAT_WS(' ',cp7.`con_Firstname`,cp7.`con_Lastname`) AS `lp_wrk_TeamInCharge`, t1.`wrk_StaffInCharge`, CONCAT_WS(' ',cp8.`con_Firstname`,cp8.`con_Lastname`) AS `lp_wrk_StaffInCharge`, t1.`wrk_ManagerInChrge`, CONCAT_WS(' ',cp9.`con_Firstname`,cp9.`con_Lastname`) AS `lp_wrk_ManagerInChrge`, t1.`wrk_SeniorInCharge`, CONCAT_WS(' ',cp10.`con_Firstname`,cp10.`con_Lastname`) AS `lp_wrk_SeniorInCharge`, t1.`wrk_DueDate`, t1.`wrk_InternalDueDate`, t1.`wrk_DueTime`, t1.`wrk_ClosedDate`, t1.`wrk_ClosureReason`, t1.`wrk_HoursSpent`, t1.`wrk_Details`, t1.`wrk_Resolution`, t1.`wrk_Notes`, t1.`wrk_TeamInChargeNotes`, t1.`wrk_RelatedCases`, t1.`wrk_Recurring`, t1.`wrk_Schedule`, lp21.`prc_Description` AS `lp_wrk_Schedule`, t1.`wrk_Date`, t1.`wrk_Day`, t1.`wrk_Createdby`, t1.`wrk_Createdon`, t1.`wrk_Lastmodifiedby`, t1.`wrk_Lastmodifiedon` FROM `wrk_worksheet` AS t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code` $client_cond) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `wst_worksheetstatus` AS lp6 ON (t1.`wrk_Status` = lp6.`wst_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS cp7 ON (lp7.`stf_CCode` = cp7.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp8 ON (lp8.`stf_CCode` = cp8.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp9 ON (lp9.`stf_CCode` = cp9.`con_Code`) LEFT OUTER JOIN `con_contact` AS cp10 ON (lp10.`stf_CCode` = cp10.`con_Code`) LEFT OUTER JOIN `prc_processcycle` AS lp21 ON (t1.`wrk_Schedule` = lp21.`prc_Code`) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` )  ".$reportcondition." )  subq";
		  }
		  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
			$sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
		  } elseif (isset($filterstr) && $filterstr!='') {
			$sql .= " where (`wrk_Code` like '" .$filterstr ."') or (`lp_wrk_ClientCode` like '" .$filterstr ."') or (`lp_wrk_ClientContact` like '" .$filterstr ."') or (`lp_wrk_MasterActivity` like '" .$filterstr ."') or (`lp_wrk_SubActivity` like '" .$filterstr ."') or (`lp_wrk_Priority` like '" .$filterstr ."') or (`lp_wrk_Status` like '" .$filterstr ."') or (`lp_wrk_TeamInCharge` like '" .$filterstr ."') or (`lp_wrk_StaffInCharge` like '" .$filterstr ."') or (`lp_wrk_ManagerInChrge` like '" .$filterstr ."') or (`lp_wrk_SeniorInCharge` like '" .$filterstr ."') or (`wrk_DueDate` like '" .$filterstr ."') or (`wrk_InternalDueDate` like '" .$filterstr ."') or (`wrk_DueTime` like '" .$filterstr ."') or (`wrk_ClosedDate` like '" .$filterstr ."') or (`wrk_ClosureReason` like '" .$filterstr ."') or (`wrk_HoursSpent` like '" .$filterstr ."') or (`wrk_Details` like '" .$filterstr ."') or (`wrk_Resolution` like '" .$filterstr ."') or (`wrk_Notes` like '" .$filterstr ."') or (`wrk_TeamInChargeNotes` like '" .$filterstr ."') or (`wrk_RelatedCases` like '" .$filterstr ."') or (`wrk_Recurring` like '" .$filterstr ."') or (`lp_wrk_Schedule` like '" .$filterstr ."') or (`wrk_Date` like '" .$filterstr ."') or (`wrk_Day` like '" .$filterstr ."') or (`wrk_Createdby` like '" .$filterstr ."') or (`wrk_Createdon` like '" .$filterstr ."') or (`wrk_Lastmodifiedby` like '" .$filterstr ."') or (`wrk_Lastmodifiedon` like '" .$filterstr ."')";
		  }
		  $sql .= " Group By wrk_ClientCode";
		  $res = mysql_query($sql) or die(mysql_error());
		  return mysql_num_rows($res);
		}
		function sql_insert()
		{
			global $_POST;
                        global $commonUses;
			
			$wrk_DueDate=$commonUses->getDateFormat($_POST["wrk_DueDate"]);
			$wrk_InternalDueDate=$commonUses->getDateFormat($_POST["wrk_InternalDueDate"]);
			$wrk_ClosedDate=$commonUses->getDateFormat($_POST["wrk_ClosedDate"]);
			$wrk_Date=$commonUses->getDateFormat($_POST["wrk_Date"]);
			$wrk_DueTime=$_POST['hour'].":".$_POST['minute'].":".$_POST['second'];
			$wrk_Createdon=date( 'Y-m-d H:i:s' );
				 if($_POST['wrk_SubActivity']!="")
				{
				 $_POST["wrk_SubActivity"]=$_POST['wrk_SubActivity'];
				}
				else if($_POST['wrk_SubActivity_old']!="" && $_POST['wrk_SubActivity']=="")
				{
				 $_POST["wrk_SubActivity"]=$_POST['wrk_SubActivity_old'];
				}
				   if($_POST['wrk_ClientCode']!="")
				{
				 $_POST["wrk_ClientCode"]=$_POST['wrk_ClientCode'];
				}
				else if($_POST['wrk_ClientCode_old']!="" && $_POST['wrk_ClientCode']=="")
				{
				 $_POST["wrk_ClientCode"]=$_POST['wrk_ClientCode_old'];
				}
				   if($_POST['wrk_ClientContact']!="")
				{
				 $_POST["wrk_ClientContact"]=$_POST['wrk_ClientContact'];
				}
				else if($_POST['wrk_ClientContact_old']!="" && $_POST['wrk_ClientContact']=="")
				{
				 $_POST["wrk_ClientContact"]=$_POST['wrk_ClientContact_old'];
				}
			 //Insert Repeats Details
				 if($_POST[ 'rpt_type' ]!='none')
				   $rptid= $this->insertRepeats();
				   if($rptid!="")
					$wrk_Rptid=$rptid;
				   else
					$wrk_Rptid=0;
			//insert master worksheet details
					$sql = "insert into `wrk_worksheet` ( `wrk_Rptid`,`wrk_ClientCode`, `wrk_ClientContact`, `wrk_MasterActivity`,
								`wrk_SubActivity`, `wrk_crmnotes`, `wrk_Priority`, `wrk_Status`, `wrk_TeamInCharge`, `wrk_StaffInCharge`,
								`wrk_ManagerInChrge`, `wrk_SeniorInCharge`, `wrk_DueDate`, `wrk_InternalDueDate`, `wrk_DueTime`, `wrk_ClosedDate`, `wrk_ClosureReason`,
								`wrk_HoursSpent`, `wrk_Details`, `wrk_Resolution`, `wrk_Notes`, `wrk_TeamInChargeNotes`,
								`wrk_RelatedCases`, `wrk_Recurring`, `wrk_Schedule`, `wrk_Date`, `wrk_Day`, `wrk_Createdby`,
								`wrk_Createdon`) values (".$wrk_Rptid."," .$commonUses->sqlvalue(@$_POST["wrk_ClientCode"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_ClientContact"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_MasterActivity"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_SubActivity"], false).",
                                                                '" .mysql_real_escape_string(@$_POST["wrk_crmnotes"])."',
								" .$commonUses->sqlvalue(@$_POST["wrk_Priority"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_Status"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_TeamInCharge"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_StaffInCharge"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_ManagerInChrge"], false).",
                                                                " .$commonUses->sqlvalue(@$_POST["wrk_SeniorInCharge"], false).",    
								'" .$wrk_DueDate."', '" .$wrk_InternalDueDate."', '" .$wrk_DueTime."', '" .$wrk_ClosedDate."',
								'" .mysql_real_escape_string(@$_POST["wrk_ClosureReason"])."',
								" . ($_POST["wrk_HoursSpent"]==null?'0.00':$_POST["wrk_HoursSpent"]).",
								'" .mysql_real_escape_string(@$_POST["wrk_Details"])."',
								'" .mysql_real_escape_string(@$_POST["wrk_Resolution"])."', '" .mysql_real_escape_string(@$_POST["wrk_Notes"])."',
								'" .mysql_real_escape_string(@$_POST["wrk_TeamInChargeNotes"])."',
								'" .mysql_real_escape_string(@$_POST["wrk_RelatedCases"])."',
								'" .mysql_real_escape_string(@$_POST["wrk_Recurring"])."', " .($_POST["wrk_Schedule"]==null?'1':$_POST["wrk_Schedule"]).",
								'" .$wrk_Date."', '" .mysql_real_escape_string(@$_POST["wrk_Day"])."',
								'" .$_SESSION['user']."', '" .$wrk_Createdon."')";
				 				$insert_result = mysql_query($sql) or die(mysql_error());
					if($_POST['copyid'] && insert_result)
				 	{
					?>
					<script>
							  window.close();self.close();
							 if (window.opener && !window.opener.closed) {
							window.opener.location.href = "wrk_worksheet.php";
						}
					</script>
		<?php
				 }
		}/*End of function sql_insert*/
		// worksheet update
		function sql_update()
		{
		  global $_POST;
                  global $commonUses;
			  $wrk_DueDate=$commonUses->getDateFormat($_POST["wrk_DueDate"]);
			  $wrk_InternalDueDate=$commonUses->getDateFormat($_POST["wrk_InternalDueDate"]);
			  $wrk_ClosedDate=$commonUses->getDateFormat($_POST["wrk_ClosedDate"]);
			  $wrk_Date=$commonUses->getDateFormat($_POST["wrk_Date"]);
			  $wrk_DueTime=$_POST['hour'].":".$_POST['minute'].":".$_POST['second'];
			  $wrk_Lastmodifiedon=date( 'Y-m-d H:i:s' );
			if($_POST['wrk_SubActivity']!="")
			{
			 $wrk_SubActivity=$_POST['wrk_SubActivity'];
			}
			else if($_POST['wrk_SubActivity_old']!="" && $_POST['wrk_SubActivity']=="")
			{
			 $wrk_SubActivity=$_POST['wrk_SubActivity_old'];
			}
			   if($_POST['wrk_ClientCode']!="")
			{
			 $wrk_ClientCode=$_POST['wrk_ClientCode'];
			}
			else if($_POST['wrk_ClientCode_old']!="" && $_POST['wrk_ClientCode']=="")
			{
			 $wrk_ClientCode=$_POST['wrk_ClientCode_old'];
			}
			   if($_POST['wrk_ClientContact']!="")
			{
			 $wrk_ClientContact=$_POST['wrk_ClientContact'];
			}
			else if($_POST['wrk_ClientContact_old']!="" && $_POST['wrk_ClientContact']=="")
			{
			 $wrk_ClientContact=$_POST['wrk_ClientContact_old'];
			}
			 //Insert Repeats Details
			 if($_POST[ 'rpt_type' ]!='none')
			   $rptid= $this->insertRepeats();
			   if($rptid!="")
				$wrk_Rptid=$rptid;
			   else
				$wrk_Rptid=0;

                           if($_POST["wrk_MasterActivity"]=="15") $crmnotes = $_POST['wrk_crmnotes'];
                           else $crmnotes = "";
		   $sql = "update `wrk_worksheet` set `wrk_Rptid`=" .$wrk_Rptid.",  `wrk_ClientCode`=" .$commonUses->sqlvalue(@$wrk_ClientCode, false).", `wrk_ClientContact`=" .$commonUses->sqlvalue(@$wrk_ClientContact, false).", `wrk_MasterActivity`=" .$commonUses->sqlvalue(@$_POST["wrk_MasterActivity"], false).", `wrk_SubActivity`=" .$commonUses->sqlvalue(@$wrk_SubActivity, false).", `wrk_crmnotes`='" .mysql_real_escape_string(@$crmnotes)."', `wrk_Priority`=" .$commonUses->sqlvalue(@$_POST["wrk_Priority"], false).", `wrk_Status`=" .$commonUses->sqlvalue(@$_POST["wrk_Status"], false).", `wrk_TeamInCharge`=" .$commonUses->sqlvalue(@$_POST["wrk_TeamInCharge"], false).", `wrk_StaffInCharge`=" .$commonUses->sqlvalue(@$_POST["wrk_StaffInCharge"], false).", `wrk_ManagerInChrge`=" .$commonUses->sqlvalue(@$_POST["wrk_ManagerInChrge"], false).", `wrk_SeniorInCharge`=" .$commonUses->sqlvalue(@$_POST["wrk_SeniorInCharge"], false).", `wrk_DueDate`='" .$wrk_DueDate."', `wrk_InternalDueDate`='" .$wrk_InternalDueDate."', `wrk_DueTime`='" .$wrk_DueTime."', `wrk_ClosedDate`='" .$wrk_ClosedDate."', `wrk_ClosureReason`='" .mysql_real_escape_string(@$_POST["wrk_ClosureReason"])."', `wrk_HoursSpent`=" .$commonUses->sqlvalue(@$_POST["wrk_HoursSpent"], false).", `wrk_Details`='" .mysql_real_escape_string(@$_POST["wrk_Details"])."', `wrk_Resolution`='" .mysql_real_escape_string(@$_POST["wrk_Resolution"])."', `wrk_Notes`='" .mysql_real_escape_string(@$_POST["wrk_Notes"])."', `wrk_TeamInChargeNotes`='" .mysql_real_escape_string(@$_POST["wrk_TeamInChargeNotes"])."', `wrk_RelatedCases`='" .mysql_real_escape_string(@$_POST["wrk_RelatedCases"])."', `wrk_Recurring`='" .mysql_real_escape_string(@$_POST["wrk_Recurring"])."', `wrk_Schedule`=" .$commonUses->sqlvalue(@$_POST["wrk_Schedule"], false).", `wrk_Date`=" .$commonUses->sqlvalue(@$_POST["wrk_Date"], true).", `wrk_Day`='" .mysql_real_escape_string(@$_POST["wrk_Day"])."',`wrk_Lastmodifiedby`='" .$_SESSION['user']."', `wrk_Lastmodifiedon`='" .$wrk_Lastmodifiedon ."' where " .$this->primarykeycondition();
			 mysql_query($sql) or die(mysql_error());
		}
		function sql_delete($id)
		{
		   $sql = "delete from `wrk_worksheet` where wrk_Code='".$id."'";
		  	if(!mysql_query($sql))
			echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
		}
		function primarykeycondition()
		{
			  global $_POST;
                          global $commonUses;
                          
			  $pk = "";
			  $pk .= "(`wrk_Code`";
			  if (@$_POST["xwrk_Code"] == "") {
				$pk .= " IS NULL";
			  }else{
			  $pk .= " = " .$commonUses->sqlvalue(@$_POST["xwrk_Code"], false);
			  };
			  $pk .= ")";
			  return $pk;
		}
		function insertRepeats()
		{
			global $_POST;
                        global $commonUses;
		
			$wrk_DueDate=$commonUses->getDateFormat($_POST["wrk_DueDate"]);
			$wrk_InternalDueDate=$commonUses->getDateFormat($_POST["wrk_InternalDueDate"]);
			$wrk_ClosedDate=$commonUses->getDateFormat($_POST["wrk_ClosedDate"]);
			$wrk_Date=$commonUses->getDateFormat($_POST["wrk_Date"]);
			$wrk_DueTime=$_POST['hour'].":".$_POST['minute'].":".$_POST['second'];
			$wrk_Createdon=date( 'Y-m-d H:i:s' );
			$ddate=explode("/",$_POST["wrk_InternalDueDate"]);
			$dyear=$ddate[2];
			$dmonth=$ddate[1];
			$dday=$ddate[0];
			$dpInternalDueDate=$dyear.$dmonth.$dday;
				if($_POST['wrk_SubActivity']!="")
				{
				 $_POST["wrk_SubActivity"]=$_POST['wrk_SubActivity'];
				}
				else if($_POST['wrk_SubActivity_old']!="" && $_POST['wrk_SubActivity']=="")
				{
				 $_POST["wrk_SubActivity"]=$_POST['wrk_SubActivity_old'];
				}
				   if($_POST['wrk_ClientCode']!="")
				{
				 $_POST["wrk_ClientCode"]=$_POST['wrk_ClientCode'];
				}
				else if($_POST['wrk_ClientCode_old']!="" && $_POST['wrk_ClientCode']=="")
				{
				 $_POST["wrk_ClientCode"]=$_POST['wrk_ClientCode_old'];
				}
				   if($_POST['wrk_ClientContact']!="")
				{
				 $_POST["wrk_ClientContact"]=$_POST['wrk_ClientContact'];
				}
				else if($_POST['wrk_ClientContact_old']!="" && $_POST['wrk_ClientContact']=="")
				{
				 $_POST["wrk_ClientContact"]=$_POST['wrk_ClientContact_old'];
				}
			$rpt_type = $_POST[ 'rpt_type' ];
			$rpt_hour = $_POST[ 'rpt_hour' ];
			$rpt_minute = $_POST[ 'rpt_minute' ];
			$rpt_ampm = $_POST[ 'rpt_ampm' ];
			$rpt_day = $_POST[ 'rpt_day' ]; 
			$rpt_month = $_POST[ 'rpt_month' ];
			$rpt_year = $_POST[ 'rpt_year' ];
			$rptmode = $_POST[ 'rptmode' ];
			$rpt_end_use = $_POST[ 'rpt_end_use' ];
			$rpt_start_use = $_POST[ 'rpt_start_use' ];
			$rpt_count = $_POST[ 'rpt_count' ];
			$rpt_freq = $_POST[ 'rpt_freq' ];
			$weekdays_only = $_POST[ 'weekdays_only' ];
			$wkst = $_POST[ 'wkst' ];
			$bydayList = $_POST[ 'bydayList' ];
			$bymonthdayList = $_POST[ 'bymonthdayList' ];
			$bysetposList = $_POST[ 'bysetposList' ];
			$bydayAll = $_POST[ 'bydayAll' ];
			$byday = $_POST[ 'byday' ];
			$bymonth = $_POST[ 'bymonth' ];
			$bysetpos = $_POST[ 'bysetpos' ];
			$bymonthday = $_POST[ 'bymonthday'];
			$byweekno = $_POST[ 'byweekno' ];
			$byyearday = $_POST[ 'byyearday' ];
			$exceptions = $_POST[ 'exceptions'];
			$timetype = $_POST[ 'timetype' ];
			$priority = $_POST[ 'priority'];
			$access = $_POST[ 'access' ];
			if($rpt_type!='none') {
				$byday_names = array ( 'SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA' );
				 $thisDay=$_POST[ 'rpt_startday' ];
				 $thisMonth=$_POST[ 'rpt_startmonth' ];
				 $thisYear=$_POST[ 'rpt_startyear' ];
                                 $startdate = $thisYear.$thisMonth.$thisDay;
				 $today =  mktime(0, 0, 0, $thisMonth, $thisDay, $thisYear);
                                 $intday =  mktime(0, 0, 0, $dmonth, $dday, $dyear);
				 if ( $rpt_type == 'weekly' || ! empty ( $rptmode ) ) {
					$bydayAr = explode ( ',', $bydayList );
					if ( ! empty ( $bydayAr ) ) {
						foreach ( $bydayAr as $bydayElement ) {
							if ( strlen ( $bydayElement ) > 2 )
								$bydayAll[] = $bydayElement;
						}
					}
					if ( ! empty ( $bydayAll ) ) {
						$bydayAll = array_unique ( $bydayAll );
						// Call special sort algorithm.
						usort ( $bydayAll, 'sort_byday' );
						$byday = implode ( ',', $bydayAll );
						// Strip off leading comma if present.
						if ( substr ( $byday, 0, 1 ) == ',' )
							$byday = substr ( $byday, 1 );
					}
				}
				// This allows users to select on weekdays if daily.
				if ( $rpt_type == 'daily' && ! empty ( $weekdays_only ) )
					$byday = 'MO,TU,WE,TH,FR';
		
				// Process only if expert mode and MonthbyDate or Yearly.
				if ( ( $rpt_type == 'monthlyByDate' || $rpt_type == 'yearly' ) && !
					empty ( $rptmode ) ) {
					 $bymonthdayAr = explode ( ',', $bymonthdayList );
					if ( ! empty ( $bymonthdayAr ) ) {
						sort ( $bymonthdayAr );
						$bymonthdayAr = array_unique ( $bymonthdayAr );
						$bymonthday = implode ( ',', $bymonthdayAr );
					}
					// Strip off leading comma if present.
					if ( substr ( $bymonthday, 0, 1 ) == ',' )
						$bymonthday = substr ( $bymonthday, 1 );
				}
				if ( $rpt_type == 'monthlyBySetPos' ) {
					$bysetposAr = explode ( ',', $bysetposList );
					if ( ! empty ( $bysetposAr ) ) {
						sort ( $bysetposAr );
						$bysetposAr = array_unique ( $bysetposAr );
						$bysetpos = implode ( ',', $bysetposAr );
					}
					// Strip off leading comma if present.
					if ( substr ( $bysetpos, 0, 1 ) == ',' )
						$bysetpos = substr ( $bysetpos, 1 );
				}
				// If expert mode not selected,
				// we need to set the basic value for monthlyByDay events.
				if ( $rpt_type == 'monthlyByDay' && empty ( $rptmode ) && empty ( $byday ) )
					$byday = ceil ( $dday / 7 ) . $byday_names[ date ( 'w', $intday ) ];
					$bymonth = ( empty ( $bymonth ) ? '' : implode ( ',', $bymonth ) );
				if ( ! empty ( $rpt_year ) && ! empty ( $rpt_month ) && ! empty ( $rpt_day) ) {
					$until = mktime ( '12', '00', 0, $rpt_month, $rpt_day, $rpt_year );
				}
					$dates = get_all_dates ( $today,
					$rpt_type, $rpt_freq,
					array ($bymonth,
					$byweekno,
					$byyearday,
					$bymonthday,
					$byday, $bysetposList),
					($rpt_count==null?99:$rpt_count), $until, $wkst,
					$exceptions ,
					'', '' , $dpInternalDueDate);
                                        
			}
					if($until!="")
					$rpt_end = gmdate ( 'Ymd', $until );
					$rpt_endtime = gmdate ( 'His', $until );
			   /*Get max repeat id from worksheet repeats table*/
			   $rpt_id_sql =  mysql_query ('SELECT MAX(rpt_id) FROM worksheet_repeats');
			   $rpt_id_result=mysql_fetch_row($rpt_id_sql);
			   $rpt_id = $rpt_id_result[0]+1;
			   /* Insert worksheet repeat details in worksheet_repeats table also the 8 fields of master worksheet details */
			   $rpt_sql="insert into worksheet_repeats(`rpt_id`,`rpt_type`, `rpt_end`, `rpt_endtime`,
							`rpt_frequency`, `rpt_bymonth`, `rpt_bymonthday`, `rpt_byday`,
							`rpt_bysetpos`, `rpt_byweekno`, `rpt_byyearday`, `rpt_wkst`, `rpt_count`,`wrk_ClientCode`,`wrk_ClientContact`,`wrk_MasterActivity`,
							`wrk_SubActivity`,`wrk_Priority`,`wrk_TeamInCharge`,`wrk_StaffInCharge`,`wrk_ManagerInChrge`,`wrk_SeniorInCharge`) values(
							".$commonUses->sqlvalue(@$rpt_id, false).",
							".$commonUses->sqlvalue(@$rpt_type, true).",
							".$commonUses->sqlvalue(@$rpt_end, false).",
							".$commonUses->sqlvalue(@$rpt_endtime, false).",
							".$commonUses->sqlvalue(@$rpt_freq, false).",
							".$commonUses->sqlvalue(@$bymonth, true).",
							".$commonUses->sqlvalue(@$bymonthday, true).",
							".$commonUses->sqlvalue(@$byday, true).",
							".$commonUses->sqlvalue(@$bysetposList, true).",
							".$commonUses->sqlvalue(@$byweekno, true).",
							".$commonUses->sqlvalue(@$byyearday, true).",
							".$commonUses->sqlvalue(@$wkst, true).",
							".$commonUses->sqlvalue(@$rpt_count, false).",
							".$commonUses->sqlvalue(@$_POST["wrk_ClientCode"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_ClientContact"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_MasterActivity"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_SubActivity"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_Priority"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_TeamInCharge"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_StaffInCharge"], false).",
							".$commonUses->sqlvalue(@$_POST["wrk_ManagerInChrge"], false).",
                                                        ".$commonUses->sqlvalue(@$_POST["wrk_SeniorInCharge"], false)."    
							)";
				$rpt_result= mysql_query($rpt_sql) or die(mysql_error());
                                for ( $i = 0, $datecnt = count ( $dates ); $i < $datecnt;$i++ )
						{
                                                        if ( isset ($dates[$i] ) )
							 {
                                                               $rdates[$i] = date ( 'Ymd', $dates[$i] );
                                                               $dates[$i] = date ( 'Y-m-d', $dates[$i] );
								if($startdate<=$rdates[$i])
								{
									$sql = "insert into `wrk_worksheet` ( `wrk_Rptid`,`wrk_ClientCode`, `wrk_ClientContact`, `wrk_MasterActivity`,
								`wrk_SubActivity`, `wrk_crmnotes`, `wrk_Priority`, `wrk_Status`, `wrk_TeamInCharge`, `wrk_StaffInCharge`,
								`wrk_ManagerInChrge`, `wrk_SeniorInCharge`, `wrk_DueDate`, `wrk_InternalDueDate`, `wrk_DueTime`, `wrk_ClosedDate`, `wrk_ClosureReason`,
								`wrk_HoursSpent`, `wrk_Details`, `wrk_Resolution`, `wrk_Notes`, `wrk_TeamInChargeNotes`,
								`wrk_RelatedCases`, `wrk_Recurring`, `wrk_Schedule`, `wrk_Date`, `wrk_Day`, `wrk_Createdby`,
								`wrk_Createdon`) values (
								" .$commonUses->sqlvalue(@$rpt_id, false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_ClientCode"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_ClientContact"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_MasterActivity"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_SubActivity"], false).",
                                                                '" .mysql_real_escape_string(@$_POST["wrk_crmnotes"])."',
								" .$commonUses->sqlvalue(@$_POST["wrk_Priority"], false).",
                                                                '11',    
								" .$commonUses->sqlvalue(@$_POST["wrk_TeamInCharge"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_StaffInCharge"], false).",
								" .$commonUses->sqlvalue(@$_POST["wrk_ManagerInChrge"], false).",
                                                                " .$commonUses->sqlvalue(@$_POST["wrk_SeniorInCharge"], false).",    
								'','" .$dates[$i]."', '" .$wrk_DueTime."', '',
								'',
								'0.00',
								'" .mysql_real_escape_string(@$_POST["wrk_Details"])."',
								'', '','','','Y','',
								'" .$wrk_Date."', '" .mysql_real_escape_string(@$_POST["wrk_Day"])."',
								'" .$_SESSION['user']."', '" .$wrk_Createdon."')";
									mysql_query($sql) or die(mysql_error());
								}
							}
						}/*End of for loop*/
						return $rpt_id;
		}
		// where condition		
		function getTypeCondition()
		{
			global $access_file_level;
			global $access_file_level_lead;
			global $access_file_level_consigned;
			global $access_file_level_discontinued;
			
			if($access_file_level['stf_View']=="Y")
			$type[]='Client';
			if($access_file_level_lead['stf_View']=="Y")
			$type[]='Lead';
			if($access_file_level_consigned['stf_View']=="Y")
			$type[]='Contract Signed';
			if($access_file_level_discontinued['stf_View']=="Y")
			$type[]='Discontinued';
			$typecondition=" lp1.`cty_Description` IN ("."'".implode("','",$type)."'".")";
			 return $typecondition;
		}
		// flag option
		function getFlag($filterstr)
		{
			global $access_file_level;
			global $access_file_level_lead;
			global $access_file_level_consigned;
			global $access_file_level_discontinued;
			
			if($access_file_level['stf_View']=="Y")
			{
			$pos1 = stripos("client", $filterstr);
			if ($pos1 !== false)
			$flag=1;
			}
			if($access_file_level_lead['stf_View']=="Y")
			{
			$pos1 = stripos("lead", $filterstr);
			if ($pos1 !== false)
			$flag=1;
			}
			if($access_file_level_consigned['stf_View']=="Y")
			{
			$pos1 = stripos("contract signed", $filterstr);
			if ($pos1 !== false)
			$flag=1;
			}
			if($access_file_level_discontinued['stf_View']=="Y")
			{
			$pos1 = stripos("discontinued", $filterstr);
			if ($pos1 !== false)
			$flag=1;
			}
			return $flag;
		}
		// grid update rows
		function gridUpdate()
		{
                    global $commonUses;
                    global $ClientEmailcontent;
                    //Inline edit Rows
			   $lastreport=$_POST['wrk_Details'];
			   $jobinhand = $_POST['wrk_Notes'];
			   $teamnotes = $_POST['wrk_TeamInChargeNotes'];
			   $befreeduedate = $_POST['wrk_DueDate'];
			   $internaldue = $_POST['wrk_InternalDueDate'];
			   $wrkstatus = $_POST['wrk_Status'];
                           $wrkstatusold = $_POST['wrk_Statusold'];
			   $rowid = $_GET['workcode'];
						$current_details = $lastreport[$rowid];
						$current_notes = $jobinhand[$rowid];
						$current_teamnotes = $teamnotes[$rowid];
						$current_duedate = $commonUses->getDateFormat($befreeduedate[$rowid]);
						$current_internalduedate = $commonUses->getDateFormat($internaldue[$rowid]);
						$current_workstatus = $wrkstatus[$rowid];
                                                $old_workstatus = $wrkstatusold[$rowid];
                                                if(($_SESSION['usertype']=="Staff" && $current_workstatus=="13" && $current_workstatus!=$old_workstatus))
                                                {
                                                    $ClientEmailcontent->worksheetTeamMail($rowid);
                                                }
						$sql_update_notes =mysql_query("update `wrk_worksheet` set `wrk_Details`='".mysql_real_escape_string($current_details)."', `wrk_Notes`='".mysql_real_escape_string($current_notes)."', `wrk_TeamInChargeNotes`='".mysql_real_escape_string($current_teamnotes)."', `wrk_DueDate`='".$current_duedate."', `wrk_InternalDueDate`='".$current_internalduedate."', `wrk_Status`='".$current_workstatus."' where wrk_Code=".$rowid);
		}
                // record delete
                function delRecord()
                {
                    global $access_file_level;
                            if($access_file_level['stf_Delete']=="Y") {
                                 for($i=0;$i<$_POST['count'];$i++) {
                                     $del_id = $_POST['checkbox'][$i];
                                     mysql_query("delete from wrk_worksheet where wrk_Code=".$del_id);
                                   //  echo $reid = "delete from wrk_worksheet where wrk_Code=".$del_id;
                                 }
                              
                             }

                }
}
$worksheetQuery = new worksheetDbquery();
?>