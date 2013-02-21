<?php
class timesheetDetails extends Database
{
    function sql_select()
    {
      global $order;
      global $ordtype;
      global $filter;
      global $filterfield;
      global $wholeonly;
      global $commonUses;
      
      $filterstr = $commonUses->sqlstr($filter);
      if (!$wholeonly && isset($wholeonly) && $filterstr!='')
      {
      $filterstr = "%" .$filterstr ."%";
      }
      if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
      {
       if($_GET['tid']!="" && isset($_GET['tid']))
       {
       $condition=" AND t1.`tis_Code`=".$_GET['tid'];
       }
       $sql = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_StaffCode`, CONCAT_WS(' ',lp5.`con_Firstname`,lp5.`con_Lastname`) AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode,lp4.`Code` AS `lp_tis_SubCode`, lp4.`sub_Description` AS lp_tis_SubActivity, t2.tis_Code  as lp_tis_DetailsCode, t2.tis_Units as lp_tis_Units FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT OUTER JOIN `con_contact` AS lp5 ON (lp1.`stf_CCode` = lp5.`con_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t2.`tis_SubActivity` = lp4.`sub_Code`) "." where `tis_StaffCode`=".$_SESSION['staffcode']." $condition) subq";
      }
      else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
      {
       if($_GET['tid']!="" && isset($_GET['tid']))
       {
       $condition=" where t1.`tis_Code`=".$_GET['tid'];
       }
       $sql = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_StaffCode`, CONCAT_WS(' ',lp5.`con_Firstname`,lp5.`con_Lastname`) AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode,lp4.`Code` AS `lp_tis_SubCode`, lp4.`sub_Description` AS lp_tis_SubActivity, t2.tis_Code  as lp_tis_DetailsCode, t2.tis_Units  as lp_tis_Units, t2.tis_NetUnits as lp_tis_NetUnits FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT OUTER JOIN `con_contact` AS lp5 ON (lp1.`stf_CCode` = lp5.`con_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t2.`tis_SubActivity` = lp4.`sub_Code`) $condition ) subq";
      }
      else
      {
       if($_GET['tid']!="" && isset($_GET['tid']))
       {
       $condition=" where t1.`tis_Code`=".$_GET['tid'];
       }
       $sql = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_StaffCode`, CONCAT_WS(' ',lp5.`con_Firstname`,lp5.`con_Lastname`) AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon`,lp2.`name` AS `lp_tis_CompanyName`, lp3.`mas_Description` AS lp_tis_MasterActivity, lp3.`Code` AS lp_tis_MasCode,lp4.`Code` AS `lp_tis_SubCode`, lp4.`sub_Description` AS lp_tis_SubActivity, t2.tis_Code  as lp_tis_DetailsCode, t2.tis_Units  as lp_tis_Units, t2.tis_NetUnits as lp_tis_NetUnits FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`) LEFT OUTER JOIN `con_contact` AS lp5 ON (lp1.`stf_CCode` = lp5.`con_Code`) LEFT JOIN tis_timesheetdetails AS t2 ON t1.tis_Code = t2.tis_TCode LEFT OUTER JOIN `jos_users` AS lp2 ON ( t2.`tis_ClientCode` = lp2.`cli_Code` ) LEFT OUTER JOIN mas_masteractivity AS lp3 ON ( t2.tis_MasterActivity = lp3.mas_Code ) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t2.`tis_SubActivity` = lp4.`sub_Code`) $condition ) subq";
      }
       if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
        $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
      } elseif (isset($filterstr) && $filterstr!='') {
        $sql .= " where (`tis_Code` like '" .$filterstr ."') or (`lp_tis_StaffCode` like '" .$filterstr ."') or (`tis_ArrivalTime` like '" .$filterstr ."') or (`tis_DepartureTime` like '" .$filterstr ."') or (`tis_Status` like '" .$filterstr ."') or (`tis_Notes` like '" .$filterstr ."') or (`tis_Date` like '" .$filterstr ."') or (`tis_Createdby` like '" .$filterstr ."') or (`tis_Createdon` like '" .$filterstr ."') or (`tis_Lastmodifiedby` like '" .$filterstr ."') or (`tis_Lastmodifiedon` like '" .$filterstr ."') or (`lp_tis_CompanyName` like '" .$filterstr ."') or (`lp_tis_MasterActivity` like '" .$filterstr ."') or (`lp_tis_SubActivity` like '" .$filterstr ."')";
      }
      if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
        else
      $sql.=" order by `tis_Date` desc";

      if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
        $res = mysql_query($sql) or die(mysql_error());
      return $res;
    }
    function sql_insert($access_file_level)
    {
      global $_POST;
      global $commonUses;
      
      $tis_Createdon=date( 'Y-m-d H:i:s' );
      $at_mysql=$_POST['at_hour'].":".$_POST['at_minute'].":".$_POST['at_second'];
      $dt_mysql=$_POST['dt_hour'].":".$_POST['dt_minute'].":".$_POST['dt_second'];
      $tis_Date=$commonUses->getDateFormat($_POST["tis_Date"]);
      //Insert header details
      if($_SESSION['usertype']=="Staff")
      $tis_StaffCode = $_SESSION["staffcode"];
      else
      $tis_StaffCode = $_POST["tis_StaffCode"];
        $sql = "insert into `tis_timesheet` ( `tis_StaffCode`, `tis_ArrivalTime`, `tis_DepartureTime`, `tis_Status`, `tis_Notes`, `tis_Date`,`tis_Createdby`, `tis_Createdon`) values ("  .$commonUses->sqlvalue($tis_StaffCode, false).", '" .$at_mysql."', '" .$dt_mysql."', " .$commonUses->sqlvalue(@$_POST["tis_Status"], false).", '" .str_replace("'","''",stripslashes(@$_POST["tis_Notes"]))."'," .$commonUses->sqlvalue($tis_Date, true).",'".$_SESSION['user']."', '" .$tis_Createdon."')";
        $result=mysql_query($sql) or die(mysql_error());
       if($result)
       {
      $result = (mysql_query ('select MAX(tis_Code) from tis_timesheet'));
       $row=mysql_fetch_row($result);
     $tis_TCode = $row[0];
       if($access_file_level['stf_Edit']=="Y")
      {
      if($_POST['tid']=="" && !isset($_POST['tid']))
       header("Location:tis_timesheet.php?a=edit&recid=".$tis_TCode);
      }
       else
       {
       header("Location:tis_timesheet.php");
      }
       }
    }
    function sql_update()
    {
      global $_POST;
      global $commonUses;
      
      $tis_Lastmodifiedon=date( 'Y-m-d H:i:s' );
      $at_mysql=$_POST['at_hour'].":".$_POST['at_minute'].":".$_POST['at_second'];
      $dt_mysql=$_POST['dt_hour'].":".$_POST['dt_minute'].":".$_POST['dt_second'];
      $tis_Date=$commonUses->getDateFormat($_POST["tis_Date"]);
      if($_SESSION['usertype']=="Staff")
      $tis_StaffCode = $_SESSION["staffcode"];
      else
      $tis_StaffCode = $_POST["tis_StaffCode"];
      $sql = "update `tis_timesheet` set  `tis_StaffCode`=" .$commonUses->sqlvalue($tis_StaffCode, false).", `tis_ArrivalTime`='" .$at_mysql."', `tis_DepartureTime`='" .$dt_mysql."', `tis_Status`=" .$commonUses->sqlvalue(@$_POST["tis_Status"], false).", `tis_Notes`='" .str_replace("'","''",stripslashes(@$_POST["tis_Notes"]))."', `tis_Date`=" .$commonUses->sqlvalue($tis_Date, true).",`tis_Lastmodifiedby`='" .$_SESSION['user']."', `tis_Lastmodifiedon`='" .$tis_Lastmodifiedon."' where " .$this->primarykeycondition_timesheet();
      $result=mysql_query($sql) or die(mysql_error());
      if($result)
      {
         if($_POST['tid']=="" && !isset($_POST['tid']))
                  header("Location:tis_timesheet.php?a=edit&recid=".$_POST['xtis_Code']);
             else
                  header("Location:tis_timesheet.php");
       }
    }
    function sql_update_details()
    {
        global $_POST;
        global $commonUses;
        
        if($_POST['action']=="insert_new") {
        if($_POST["tis_NetUnits_new"]!="" && isset($_POST["tis_NetUnits_new"]))
        {
          $details_sql = "insert into `tis_timesheetdetails` ( `tis_TCode`, `tis_ClientCode`, `tis_MasterActivity`, `tis_SubActivity`, `tis_Details`, `tis_Units`, `tis_NetUnits`, `tis_Comments`) values ("  .$commonUses->sqlvalue($_POST['xtis_Code'], false).",  " .$commonUses->sqlvalue(@$_POST["tis_ClientCode_new"], false)." ,  " .$commonUses->sqlvalue(@$_POST["tis_MasterActivity_new"], false)." , " .$commonUses->sqlvalue(@$_POST["tis_SubActivity_new"], false).", " .$commonUses->sqlvalue(str_replace("'","''",stripslashes(@$_POST["tis_Details_new"])), true).",  " .$commonUses->sqlvalue(@$_POST["tis_Units_new"], false).",  " .$commonUses->sqlvalue(@$_POST["tis_NetUnits_new"], false).",'" .str_replace("'","''",stripslashes(@$_POST["tis_Comments_new"]))."')";
        }
        else
        {
            $details_sql = "insert into `tis_timesheetdetails` ( `tis_TCode`, `tis_ClientCode`, `tis_MasterActivity`, `tis_SubActivity`, `tis_Details`, `tis_Units`, `tis_Comments`) values ("  .$commonUses->sqlvalue($_POST['xtis_Code'], false).",  " .$commonUses->sqlvalue(@$_POST["tis_ClientCode_new"], false)." ,  " .$commonUses->sqlvalue(@$_POST["tis_MasterActivity_new"], false)." , " .$commonUses->sqlvalue(@$_POST["tis_SubActivity_new"], false).", " .$commonUses->sqlvalue(str_replace("'","''",stripslashes(@$_POST["tis_Details_new"])), true).",  " .$commonUses->sqlvalue(@$_POST["tis_Units_new"], false).",'".str_replace("'","''",stripslashes(@$_POST["tis_Comments_new"]))."')";
        }
                $chk_duplicate=mysql_num_rows(mysql_query("select * from tis_timesheetdetails where tis_TCode=".$_POST['xtis_Code']." and tis_ClientCode=".$_POST['tis_ClientCode_new']." and tis_MasterActivity=".$_POST['tis_MasterActivity_new']." and tis_SubActivity=".$_POST['tis_SubActivity_new']." and tis_Units=".$_POST['tis_Units_new']));
                if(!$chk_duplicate)
                $details_result=mysql_query($details_sql);
            if (preg_match("/Duplicate entry/i", mysql_error())) {
                echo "<script language=\"JavaScript\">alert(\"Duplicate Client entry not allowed...\");history.back();</script>";
            }
            if($details_result) {
                             if($_POST['tid']!="")
                                header("Location:tis_timesheet.php");
                             else
                                header("Location:tis_timesheet.php?a=edit&recid=".$_POST['xtis_Code']);
            }
         }
        else {
            $arrSubActivity = array();
            $arrSubActivityNew = array();
            $j=0;
            if(is_array ( $_POST["tis_SubActivity"] )){
                $arrSubActivity = $_POST["tis_SubActivity"];
                for ($i =0; $i < count($arrSubActivity); $i++) {
                    if($arrSubActivity[$i]!=0){
                        $arrSubActivityNew[$j] = $arrSubActivity[$i];
                        $j=$j+1;
                    }
                }
            }
            for($i=0;$i<$_POST['count'];$i++) {

                $details_sql = "update `tis_timesheetdetails` set  `tis_ClientCode`=" .$commonUses->sqlvalue(@$_POST["tis_ClientCode"][$i], false).", `tis_MasterActivity`= " .$commonUses->sqlvalue(@$_POST["tis_MasterActivity"][$i], false)." , `tis_SubActivity`=" .$commonUses->sqlvalue($arrSubActivityNew[$i], false)." , `tis_Details`=" .$commonUses->sqlvalue(@$_POST["tis_Details"][$i], true).", `tis_Units`=" .$commonUses->sqlvalue(@$_POST["tis_Units"][$i], false).", `tis_NetUnits`=".$commonUses->sqlvalue(@$_POST["tis_NetUnits"][$i], false)." , `tis_Comments`='".str_replace("'","''",stripslashes(@$_POST["tis_Comments"][$i]))."' where tis_Code=" .$_POST['tis_Details_Code'][$i];
                mysql_query($details_sql) or die(mysql_error());
            }
                                         if($_POST['tid']!="" && isset($_POST['tid']))
                                            header("Location:tis_timesheet.php?a=edit&recid=".$_POST['recid']);
        }
    }
    function sql_delete($id)
    {
           $sql = "delete from `tis_timesheet` where tis_Code='".$id."'";
           if(!mysql_query($sql))
           echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
           $sql = "delete from `tis_timesheetdetails` where tis_TCode='".$id."'";
           if(!mysql_query($sql))
           echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
    }
    function sql_details_delete($id,$recid)
    {
            $sql = "delete from `tis_timesheetdetails` where tis_Code='".$id."'";
            $deleteresult=mysql_query($sql) or die(mysql_error());
          if($deleteresult)
           {
             header("Location:tis_timesheet.php?a=edit&recid=".$recid);
           }
    }
    function primarykeycondition_timesheet()
    {
          global $_POST;
          global $commonUses;
          $pk = "";
          $pk .= "(`tis_Code`";
          if (@$_POST["xtis_Code"] == "") {
            $pk .= " IS NULL";
          }else{
          $pk .= " = " .$commonUses->sqlvalue(@$_POST["xtis_Code"], false);
          };
          $pk .= ")";
          return $pk;
    }
 
 }
	$timesheetDbcontent = new timesheetDetails();
?>

