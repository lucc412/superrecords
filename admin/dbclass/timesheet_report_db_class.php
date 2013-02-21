<?php
class timesheetReportDetails extends Database
{
     function sql_select()
     {
      global $order;
      global $ordtype;
      global $filter;
      global $filterfield;
      global $wholeonly;
      global $commonUses;
      
      $where=array();
      $tis_FromDate=$commonUses->getDateFormat($_SESSION["tis_FromDate"]);
      $tis_ToDate=$commonUses->getDateFormat($_SESSION["tis_ToDate"]);
      $selectedmas=$_SESSION['tis_MasterActivityList'];
             if($selectedmas!="")
            {
             $selectedmas=$this->removeNullVal($selectedmas);
             $implodemas=implode(",",$selectedmas);
            }
            $selectedsub=$_SESSION['tis_SubActivityList'];
            if($selectedsub!="")
            {
             $selectedsub=$this->removeNullVal($selectedsub);
             $implodesub=implode(",",$selectedsub);
            }
            $selectedstaff=$_SESSION['tis_StaffList'];
            if($selectedstaff!="")
            {
             $selectedstaff=$this->removeNullVal($selectedstaff);
             $implodestaff=implode(",",$selectedstaff);
            }
            if($_SESSION['tis_StaffCode']!="")
            {
                    $implodestaff=$_SESSION['tis_StaffCode'];
            }
            if($tis_FromDate!="--" && $tis_ToDate=="--")
            {
            $where[]=" tis_Date = '".$tis_FromDate. "'";
            }
            if($tis_ToDate!="--" && $tis_FromDate=="--")
            {
            $where[]=" tis_Date = '".$tis_ToDate. "'";
            }
                    if($tis_FromDate!="--" && $tis_ToDate!="--")
            {
                    $where[]=" tis_Date >= '".$tis_FromDate. "' AND tis_Date <= '".$tis_ToDate. "'";
            }
            if($_SESSION['tis_ClientName']!="")
            {
            $where[]=" lp2.`name` like '%".$_SESSION['tis_ClientName']."%'";
            }
            if($_SESSION['tis_StatusList']!="")
            {
            $where[].=" t1.tis_Status =".$_SESSION['tis_StatusList'];
            }
            if($implodemas!="")
            {
            $where[].=" t2.tis_MasterActivity IN ( ".$implodemas." )";
            }
            if($implodesub!="")
            {
            $where[].=" t2.tis_SubActivity IN ( ".$implodesub." ) ";
            }
            if($implodestaff!="")
            {
            $where[].=" t1.tis_StaffCode IN ( ".$implodestaff." ) ";
            }
             if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
              {
              $where[].= " `tis_StaffCode`=".$_SESSION['staffcode'];
               }
             if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
             {
                $selectedstaff=$_SESSION['tis_StaffList'];
                if($selectedstaff!="")
                {
                 $selectedstaff=$this->removeNullVal($selectedstaff);
                 $implodestaff=implode(",",$selectedstaff);
                }
             }
            if($where!="")
            $where= implode(" AND ",$where);
       $filterstr = $commonUses->sqlstr($filter);
      if (!$wholeonly && isset($wholeonly) && $filterstr!='')
      {
      $filterstr = "%" .$filterstr ."%";
      }
      $common_sql="SELECT t1.`tis_Code`, t1.`tis_StaffCode`, lp1.`stf_Login` AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode, lp4.`sub_Description` AS lp_tis_SubActivity, lp4.`Code` AS lp_tis_SubCode, t2.tis_Units as lp_tis_Units,t2.tis_Details as `Details`  FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN sub_subactivity AS lp4 ON ( t2.tis_SubActivity = lp4.sub_Code ) WHERE ( $where )";
      $common_report_sql="SELECT t1.`tis_Date` as `Date`, lp1.`stf_Login` AS `User Name`, lp2.`name` AS `Client`, lp3.`mas_Description` AS `Master Activity`,lp4.`sub_Description` AS `Sub Activity`,t1.`tis_ArrivalTime` as `Arrival Time`, t1.`tis_DepartureTime` as `Departure Time`,t3.`tst_Description` AS `Status`, t2.tis_Units as `Units`, t2.tis_NetUnits as `NetUnits`, t2.tis_Details as `Details`, t1.`tis_Code`, t1.`tis_StaffCode`, lp1.`stf_Login` AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode, lp4.`sub_Description` AS lp_tis_SubActivity, lp4.`Code` AS lp_tis_SubCode, t2.tis_Units as lp_tis_Units,t2.tis_Details as `Details`, t2.tis_NetUnits as lp_tis_NetUnits FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `tst_timesheetstatus` AS t3 ON ( t3.`tst_Code` = t1.`tis_Status` )
    LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN sub_subactivity AS lp4 ON ( t2.tis_SubActivity = lp4.sub_Code ) WHERE ( $where )";
     if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N" && $_SESSION['Submit']=="Generate Report")
      {
       $sql = $common_sql;
      }
     else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y" && $_SESSION['Submit']=="Generate Report")
      {
          $sql = "SELECT t1.`tis_Code`, t1.`tis_StaffCode`, lp1.`stf_Login` AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode, lp4.`sub_Description` AS lp_tis_SubActivity, lp4.`Code` AS lp_tis_SubCode, t2.tis_Units  as lp_tis_Units, t2.tis_NetUnits as lp_tis_NetUnits,t2.tis_Details as `Details`  FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN sub_subactivity AS lp4 ON ( t2.tis_SubActivity = lp4.sub_Code )";
            if($where!="")
            $sql.="where ($where)";
      }

        else  if($_SESSION['usertype']=="Staff" && $_SESSION['Submit']=="Generate Excel Report")
      {
            $sql = $common_report_sql;
      }
      else if($_SESSION['usertype']=="Administrator" && $_SESSION['Submit']=="Generate Excel Report")
      {
         $sql = $common_report_sql;
      }
      else
      {
        $sql = "SELECT t1.`tis_Code`, t1.`tis_StaffCode`, lp1.`stf_Login` AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode, lp4.`sub_Description` AS lp_tis_SubActivity, lp4.`Code` AS lp_tis_SubCode, t2.tis_Units  as lp_tis_Units, t2.tis_NetUnits as lp_tis_NetUnits,t2.tis_Details as `Details`  FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN sub_subactivity AS lp4 ON ( t2.tis_SubActivity = lp4.sub_Code )";
            if($where!="")
            $sql.="where ($where)";
      }
             if (isset($order) && $order!='') {$sql .= " order by `" .$commonUses->sqlstr($order) ."`";}
      else if (isset($_SESSION['order']) && $_SESSION['order']!='') {$sql .= " order by `" .$commonUses->sqlstr($_SESSION['order']) ."`";}
      else {$sql .= " order by `tis_Date` desc";}

      if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
      else if (isset($_SESSION['type']) && $_SESSION['type']!='') $sql .= " " .$commonUses->sqlstr($_SESSION['type']);
        $res = mysql_query($sql) or die(mysql_error());
        $_SESSION['query']= "$sql";
      return $res;
    }
    function sql_delete($id)
    {
       $sql = "delete from `tis_timesheet` where tis_Code='".$id."'";
      if(!mysql_query($sql))
    echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
     }
     function sql_details_delete($id)
    {
       $sql = "delete from `tis_timesheetdetails` where tis_Code='".$id."'";
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
	$timesheetReportDbcontent = new timesheetReportDetails();
?>

