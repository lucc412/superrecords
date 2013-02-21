<?php
class wrkReportDetails extends Database
{

    function sql_select()
    {
      global $order;
      global $ordtype;
      global $filter;
      global $filterfield;
      global $wholeonly;
      global $commonUses;

     $wrk_FromDate=$commonUses->getDateFormat($_SESSION["wrk_FromDate"]);
     $wrk_ToDate=$commonUses->getDateFormat($_SESSION["wrk_ToDate"]);
     $wrk_ExdateFrom=$commonUses->getDateFormat($_SESSION["wrk_ExdateFrom"]);
     $wrk_ExdateTo=$commonUses->getDateFormat($_SESSION["wrk_ExdateTo"]);
     $cli_cat = $_SESSION["cli_Category"];
     $selectedmas=$_SESSION['wrk_MasterActivityList'];
     if($selectedmas!="")
     {
        $selectedmas=$this->removeNullVal($selectedmas);
        $implodemas=implode(",",$selectedmas);
     }
     $selectedsub=$_SESSION['wrk_SubActivityList'];
     if($selectedsub!="")
     {
        $selectedsub=$this->removeNullVal($selectedsub);
        $implodesub=implode(",",$selectedsub);
     }
     $selectedstaff=$_SESSION['wrk_StaffList'];
     if($selectedstaff!="")
     {
        $selectedstaff=$this->removeNullVal($selectedstaff);
        $implodestaff=implode(",",$selectedstaff);
     }
     $selectedteam=$_SESSION['wrk_TeamList'];
     if($selectedteam!="")
     {
        $selectedteam=$this->removeNullVal($selectedteam);
        $implodeteam=implode(",",$selectedteam);
     }
     $selectedmanager=$_SESSION['wrk_ManagerList'];
     if($selectedmanager!="")
     {
        $selectedmanager=$this->removeNullVal($selectedmanager);
        $implodemanager=implode(",",$selectedmanager);
     }
     $selectedsenior=$_SESSION['wrk_SeniorList'];
     if($selectedsenior!="")
     {
        $selectedsenior=$this->removeNullVal($selectedsenior);
        $implodesenior=implode(",",$selectedsenior);
     }
     $selectedstatus=$_SESSION['wrk_StatusList'];
     if($selectedstatus!="")
     {
        $selectedstatus=$this->removeNullVal($selectedstatus);
        $implodestatus=implode(",",$selectedstatus);
     }
     if($_SESSION['wrk_StaffCode']!="")
     {
        $implodestaff=$_SESSION['wrk_StaffCode'];
     }
     $filterstr = $commonUses->sqlstr($filter);
     if (!$wholeonly && isset($wholeonly) && $filterstr!='')
     {
        $filterstr = "%" .$filterstr ."%";
     }
       $common_sql="SELECT * FROM (SELECT w1.wrk_Code, w1.wrk_ClientCode, w1.wrk_ClientContact, w1.wrk_DueTime, w1.wrk_ClosedDate, w1.wrk_MasterActivity,
                    w1.wrk_ClosureReason, w1.wrk_HoursSpent, w1.wrk_Details, w1.wrk_Resolution, w1.wrk_Notes, w1.wrk_TeamInChargeNotes, w1.wrk_RelatedCases,
                    w1.wrk_Recurring, w1.wrk_Schedule, w1.wrk_Date, w1.wrk_Day, w1.wrk_Createdby, w1.wrk_Createdon, w1.wrk_Lastmodifiedby, w1.wrk_Lastmodifiedon,
                    lp1.`stf_Login` AS `lp_wrk_StaffInCharge`, lp4.`stf_Login` AS `lp_wrk_TeamInCharge`, lp5.`stf_Login` AS `lp_wrk_ManagerInCharge`, lp10.`stf_Login` AS `lp_wrk_SeniorInCharge`,
                    c1.con_Firstname AS lp_wrk_ClientContact, p1.prc_Description AS lp_wrk_Schedule, w2.`wst_Description` AS `lp_wrk_Status`,
                    lp2.`name` AS `lp_wrk_CompanyName`, lp2.`cli_Category`,
                    w1.wrk_ManagerInChrge, w1.wrk_SeniorInCharge, w1.wrk_TeamInCharge, 	w1.wrk_StaffInCharge, w1.wrk_Status, w1.wrk_priority, w1.wrk_SubActivity, w1.wrk_DueDate, w1.wrk_InternalDueDate, lp3.`mas_Description` as lp_wrk_MasterActivity, lp3.`Code` as lp_wrk_MasCode, lp6.`sub_Description` as lp_wrk_SubActivity, lp6.`Code` as lp_wrk_SubCode, p.`pri_Description` as lp_wrk_priority, lp22.cty_Description,lp2.`cli_Type` FROM `wrk_worksheet` AS w1
                    LEFT OUTER JOIN `stf_staff` AS lp1 ON ( w1.`wrk_StaffInCharge` = lp1.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp4 ON ( w1.`wrk_TeamInCharge` = lp4.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp5 ON ( w1.`wrk_ManagerInChrge` = lp5.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp10 ON ( w1.`wrk_SeniorInCharge` = lp10.`stf_Code` )
                    LEFT OUTER JOIN `wst_worksheetstatus` AS w2 ON ( w1.`wrk_Status` = w2.`wst_Code` )
                    LEFT OUTER JOIN `con_contact` AS c1 ON ( w1.`wrk_ClientContact` = c1.`con_Code` )
                    LEFT OUTER JOIN `prc_processcycle` AS p1 ON ( w1.`wrk_Schedule` = p1.`prc_Code` )
                    LEFT OUTER JOIN `jos_users` AS lp2 ON ( w1.`wrk_ClientCode` = lp2.`cli_Code` )
                    LEFT OUTER JOIN mas_masteractivity AS lp3 ON (w1.wrk_MasterActivity = lp3.mas_Code)
                    LEFT OUTER JOIN pri_priority AS p ON (w1.wrk_Priority = p.pri_Code)
                    LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp2.`cli_Type`  = lp22. `cty_Code` )  ";

                    $common_report_sql="SELECT * FROM (SELECT lp2.`name` AS `Client`,lp2.`cli_Category` AS `Category`,CONCAT(c2.con_Firstname,' ', c2.con_Lastname) as `Team In Charge`,CONCAT(c3.con_Firstname,' ', c3.con_Lastname) as `Staff In Charge`, p.`pri_Description` as `Priority`, CONCAT_WS('-', lp3.Code,lp3.mas_Description) as `Master Activity`, CONCAT_WS('-', lp6.Code,lp6.sub_Description) as `Sub Activity`, w1.wrk_Details as `Last Reports Sent`, w1.wrk_Notes as `Current Job in Hand`,w1.wrk_TeamInChargeNotes as `Team Incharge Notes`,w1.wrk_DueDate as `External Due Date`, w1.wrk_InternalDueDate as `Befree Due Date`, w2.`wst_Description` AS `Status`, w1.wrk_Code, w1.wrk_ClientCode, w1.wrk_ClientContact, w1.wrk_DueTime, w1.wrk_ClosedDate, w1.wrk_MasterActivity, w1.wrk_ClosureReason, w1.wrk_HoursSpent, w1.wrk_Details , w1.wrk_Resolution, w1.wrk_TeamInChargeNotes, w1.wrk_RelatedCases, w1.wrk_Recurring, w1.wrk_Schedule, w1.wrk_Notes, w1.wrk_Date, w2.`wst_Description` AS `lp_wrk_Status`, w1.wrk_Day, w1.wrk_Createdby, w1.wrk_Createdon, w1.wrk_Lastmodifiedby, w1.wrk_Lastmodifiedon, w1.wrk_ManagerInChrge, w1.wrk_SeniorInCharge, w1.wrk_TeamInCharge, w1.wrk_StaffInCharge, w1.wrk_Status, w1.wrk_priority, w1.wrk_SubActivity, w1.wrk_DueDate, w1.wrk_InternalDueDate, lp2.`name` AS `lp_wrk_CompanyName`, lp3.`mas_Description` as lp_wrk_MasterActivity, lp3.`Code` as lp_wrk_MasCode, lp6.`sub_Description` as lp_wrk_SubActivity, lp6.`Code` as lp_wrk_SubCode, p.`pri_Description` as lp_wrk_priority,lp2.`cli_Category` FROM `wrk_worksheet` AS w1
                    LEFT OUTER JOIN `stf_staff` AS lp1 ON ( w1.`wrk_StaffInCharge` = lp1.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp4 ON ( w1.`wrk_TeamInCharge` = lp4.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp5 ON ( w1.`wrk_ManagerInChrge` = lp5.`stf_Code` )
                    LEFT OUTER JOIN `stf_staff` AS lp10 ON ( w1.`wrk_SeniorInCharge` = lp10.`stf_Code` )
                    LEFT OUTER JOIN `wst_worksheetstatus` AS w2 ON ( w1.`wrk_Status` = w2.`wst_Code` )
                    LEFT OUTER JOIN `con_contact` AS c1 ON ( w1.`wrk_ClientContact` = c1.`con_Code` )
                    LEFT OUTER JOIN `con_contact` AS c2 ON ( c2.`con_Code`  = lp4.`stf_CCode`)
                    LEFT OUTER JOIN `con_contact` AS c3 ON ( c3.`con_Code`  = lp1.`stf_CCode` )
                    LEFT OUTER JOIN `prc_processcycle` AS p1 ON ( w1.`wrk_Schedule` = p1.`prc_Code` )
                    LEFT OUTER JOIN `jos_users` AS lp2 ON ( w1.`wrk_ClientCode` = lp2.`cli_Code` )
                    LEFT OUTER JOIN mas_masteractivity AS lp3 ON (w1.wrk_MasterActivity = lp3.mas_Code)
                    LEFT OUTER JOIN pri_priority AS p ON (w1.wrk_Priority = p.pri_Code)
                    LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp2.`cli_Type`  = lp22. `cty_Code` ) ";

         if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N" && $_SESSION['Submit']=="Generate Report")
        {
                    $sql=$common_sql."  LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code)  where  lp22.cty_Description !='Discontinued'  AND (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode'].")) subq ";
        }
        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y" && $_SESSION['Submit']=="Generate Report")
        {
                    $sql=$common_sql." LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code) where  lp22.cty_Description !='Discontinued') subq ";
        }
        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N" && $_SESSION['Submit']=="Generate Excel Report")
        {
                    $sql=$common_report_sql."  LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code)  where  lp22.cty_Description !='Discontinued'  AND (wrk_StaffInCharge=".$_SESSION['staffcode']." or wrk_ManagerInChrge=".$_SESSION['staffcode']." or wrk_SeniorInCharge=".$_SESSION['staffcode']." or wrk_TeamInCharge=".$_SESSION['staffcode']."))  subq ";
        }
        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y" && $_SESSION['Submit']=="Generate Excel Report")
        {
                    $sql=$common_report_sql." LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code) where  lp22.cty_Description !='Discontinued') subq ";
        }
        else  if($_SESSION['usertype']=="Administrator" && $_SESSION['Submit']=="Generate Excel Report")
        {
                    $sql=$common_report_sql." LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code) where  lp22.cty_Description !='Discontinued') subq ";
        }
        else
        {
            $sql=$common_sql." LEFT OUTER JOIN sub_subactivity AS lp6 ON (w1.wrk_SubActivity = lp6.sub_Code) where  lp22.cty_Description !='Discontinued') subq ";
        }
        $sql.="WHERE 1=1";
        if($wrk_FromDate!="--" || $wrk_ToDate!="--")
        {
                    if($wrk_FromDate!="--" && $wrk_ToDate=="--")
                    $sql.=" AND (wrk_InternalDueDate = '".$wrk_FromDate. "')";
                    else if($wrk_FromDate=="--" && $wrk_ToDate!="--")
                    $sql.=" AND (wrk_InternalDueDate = '".$wrk_ToDate. "')";
                    else if($wrk_FromDate!="--" && $wrk_ToDate!="--")
                    $sql.=" AND (wrk_InternalDueDate >= '".$wrk_FromDate. "' AND wrk_InternalDueDate <= '".$wrk_ToDate. "')";
         }
        if($wrk_ExdateFrom!="--" || $wrk_ExdateTo!="--")
        {
                    if($wrk_ExdateFrom!="--" && $wrk_ExdateTo=="--")
                    $sql.=" AND (wrk_DueDate = '".$wrk_ExdateFrom. "')";
                    else if($wrk_ExdateFrom=="--" && $wrk_ExdateTo!="--")
                    $sql.=" AND (wrk_DueDate = '".$wrk_ExdateTo. "')";
                    else if($wrk_ExdateFrom!="--" && $wrk_ExdateTo!="--")
                    $sql.=" AND (wrk_DueDate >= '".$wrk_ExdateFrom. "' AND wrk_DueDate <= '".$wrk_ExdateTo. "')";

         }

         if(($_SESSION['wrk_ClientName']!="" || $implodemas!="" || $implodesub!="" || $implodestaff!="" || $implodeteam!="" || $implodemanager!="" || $implodesenior!="" || $implodestatus!="" || $cli_cat!="" ))
         {
             if(($wrk_FromDate=="--" && $wrk_ToDate=="--") || ($wrk_ExdateFrom=="--" && $wrk_ExdateTo=="--"))
                $sql.=" AND (";
               else
               $sql.=" AND (";
         }
         if($_SESSION['wrk_ClientName']!="")
         {
                    $where[]=" `lp_wrk_CompanyName` like '%".$_SESSION['wrk_ClientName']."%'";
         }
         if($implodestatus!="")
         {
                    $where[]=" wrk_Status IN ( ".$implodestatus." ) ";
         }
         if($implodemas!="")
         {
                    $where[]=" wrk_MasterActivity IN ( ".$implodemas." )";
         }
         if($implodesub!="")
         {
                    $where[]=" wrk_SubActivity IN ( ".$implodesub." ) ";
         }
         if($implodestaff!="")
         {
                    $where[]=" wrk_StaffInCharge IN ( ".$implodestaff." ) ";
         }
         if($implodeteam!="")
         {
                    $where[]=" wrk_TeamInCharge IN ( ".$implodeteam." ) ";
         }
         if($implodemanager!="")
         {
                    $where[]=" wrk_ManagerInChrge IN ( ".$implodemanager." ) ";
         }
         if($implodesenior!="")
         {
                    $where[]=" wrk_SeniorInCharge IN ( ".$implodesenior." ) ";
         }
         if($cli_cat!="")
         {
                    $where[]=" cli_Category= ".$_SESSION['cli_Category'];
         }

         if($_SESSION['wrk_ClientName']!="" || $implodemas!="" || $implodesub!="" || $implodestaff!="" || $implodeteam!="" || $implodemanager!="" || $implodesenior!="" || $implodestatus!="" || $cli_cat!="")
         {
            if($where!="")
            $sql.= implode(" AND ",$where);
            $sql.=")";
         }
         if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
         else if (isset($_SESSION['order']) && $_SESSION['order']!='') $sql .= " order by `" .$commonUses->sqlstr($_SESSION['order']) ."`";
         if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
         else if (isset($_SESSION['type']) && $_SESSION['type']!='') $sql .= " " .$commonUses->sqlstr($_SESSION['type']);
             $res = mysql_query($sql) or die(mysql_error());
                $_SESSION['query']= "$sql";
      return $res;
    }
    function sql_delete($id)
    {
       $sql = "delete from `wrk_worksheet` where wrk_Code='".$id."'";
       if(!mysql_query($sql))
       echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
    }
    function removeNullVal($arr)
    {
        foreach ($arr as $key => $value) {
          if (is_null($value) || $value=="") {
            unset($arr[$key]);
          }
        }
        return $arr;
    }

}
	$wrkReportDbcontent = new wrkReportDetails();
?>

