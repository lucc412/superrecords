<?php
class lrfDetails extends Database
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
          if(($_SESSION['usertype']=="Administrator" && ($_SESSION['Viewall']=="Y" || $_SESSION['Viewall']=="N")) || ($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y"))
          {
                $sql = "SELECT * FROM (SELECT t1.`lrf_Code`, t1.`lrf_StaffCode`, CONCAT_WS(' ',lp7.`con_Firstname`,lp7.`con_Lastname`) AS `lp_lrf_StaffCode`, t1.`lrf_From`, t1.`lrf_To`, t1.`lrf_Reason`, t1.`lrf_JobAlloted`, lp5.`stf_Login` AS `lp_lrf_JobAlloted`, t1.`lrf_Notes`, lp6.`lst_Description` as `lrf_Status_Desc`,lp6.`lst_Code` as `lrf_Status`, t1.`lrf_Createdby`, t1.`lrf_Createdon`, t1.`lrf_Lastmodifiedby`, t1.`lrf_Lastmodifiedon` FROM `lrf_leaverequestform` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`lrf_StaffCode` = lp1.`stf_Code`) LEFT OUTER JOIN `con_contact` AS lp7 ON (lp1.`stf_CCode` = lp7.`con_Code`) LEFT OUTER JOIN `lst_leaverequeststatus` AS lp6 ON (t1.`lrf_Status` = lp6.`lst_Code`) LEFT OUTER JOIN `stf_staff` AS lp5 ON (t1.`lrf_JobAlloted` = lp5.`stf_Code`)) subq";
            }
            else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
            {
                $sql = "SELECT * FROM (SELECT t1.`lrf_Code`, t1.`lrf_StaffCode`, lp1.`stf_Login` AS `lp_lrf_StaffCode`, t1.`lrf_From`, t1.`lrf_To`, t1.`lrf_Reason`, t1.`lrf_JobAlloted`, lp5.`stf_Login` AS `lp_lrf_JobAlloted`, t1.`lrf_Notes`, lp6.`lst_Description` as `lrf_Status_Desc`,lp6.`lst_Code` as `lrf_Status`, t1.`lrf_Createdby`, t1.`lrf_Createdon`, t1.`lrf_Lastmodifiedby`, t1.`lrf_Lastmodifiedon` FROM `lrf_leaverequestform` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`lrf_StaffCode` = lp1.`stf_Code`) LEFT OUTER JOIN `lst_leaverequeststatus` AS lp6 ON (t1.`lrf_Status` = lp6.`lst_Code`) LEFT OUTER JOIN `stf_staff` AS lp5 ON (t1.`lrf_JobAlloted` = lp5.`stf_Code`) where t1.`lrf_StaffCode`=".$_SESSION['staffcode'].") subq";
            }
            if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
                $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
            } elseif (isset($filterstr) && $filterstr!='') {
                $sql .= " where (`lrf_Code` like '" .$filterstr ."') or (`lp_lrf_StaffCode` like '" .$filterstr ."') or (`lrf_From` like '" .$filterstr ."') or (`lrf_To` like '" .$filterstr ."') or (`lrf_Reason` like '" .$filterstr ."') or (`lp_lrf_JobAlloted` like '" .$filterstr ."') or (`lrf_Notes` like '" .$filterstr ."') or (`lrf_Status_Desc` like '" .$filterstr ."') or (`lrf_Createdby` like '" .$filterstr ."') or (`lrf_Createdon` like '" .$filterstr ."') or (`lrf_Lastmodifiedby` like '" .$filterstr ."') or (`lrf_Lastmodifiedon` like '" .$filterstr ."')";
            }
            if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
            if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
            $res = mysql_query($sql) or die(mysql_error());
            return $res;
        }
        function sql_insert()
        {
          global $_POST;
          global $commonUses;
          $lrf_From=$commonUses->getDateFormat($_POST["lrf_From"]);
          $lrf_To=$commonUses->getDateFormat($_POST["lrf_To"]);
          $lrf_Createdon=date( 'Y-m-d H:i:s' );
          $sql = "insert into `lrf_leaverequestform` ( `lrf_StaffCode`, `lrf_From`, `lrf_To`, `lrf_Reason`, `lrf_JobAlloted`, `lrf_Notes`, `lrf_Status`, `lrf_Createdby`, `lrf_Createdon`) values (" .$commonUses->sqlvalue(@$_POST["lrf_StaffCode"], false).", '" .$lrf_From."', '" .$lrf_To."', " .$commonUses->sqlvalue(str_replace("'","''",@$_POST["lrf_Reason"]), true).", " .$commonUses->sqlvalue(@$_POST["lrf_JobAlloted"], false).", " .$commonUses->sqlvalue(str_replace("'","''",@$_POST["lrf_Notes"]), true).", '" .$commonUses->sqlvalue(@$_POST["lrf_Status"], false)."', '" .$_SESSION['user']."', '" .$lrf_Createdon."')";
          mysql_query($sql) or die(mysql_error());
           /* Send email to Administrator*/
           if($_SESSION['usertype']=="Staff")
           {
                   $emailtemprow =$commonUses->getToAddress('Leave Request Form');
                   // To address
                   $to=$emailtemprow['email_value'];
                   // Actual template message
                   $message=$emailtemprow['email_template'];
                   // Subject
                   $subject ="Super Records Leave Request Form From ".$_SESSION['firstname'];
                   //Replace {staff}
                   $message = str_replace("{staff}",$_SESSION['firstname'],$message);
                   //Replace {from}
                   $message = str_replace("{from}",$_POST["lrf_From"],$message);
                   //Replace {to}
                   $message = str_replace("{to}",$_POST["lrf_To"],$message);
                   //Replace {reason}
                   $message = str_replace("{reason}",$_POST["lrf_Reason"],$message);
                   $status=$commonUses->sendMail($to,$subject,$message);
                   if($status==1)
                         $msg="Your request has been sent to Super Records Admin.";
                         header("Location:lrf_leaverequestform.php?msg=".$msg);
            }
        }
        function sql_update()
        {
          global $_POST;
          global $commonUses;
          $lrf_From=$commonUses->getDateFormat($_POST["lrf_From"]);
          $lrf_To=$commonUses->getDateFormat($_POST["lrf_To"]);
          $lrf_Lastmodifiedon=date( 'Y-m-d H:i:s' );
          $sql = "update `lrf_leaverequestform` set  `lrf_StaffCode`=" .$commonUses->sqlvalue(@$_POST["lrf_StaffCode"], false).", `lrf_From`='" .$lrf_From."', `lrf_To`='" .$lrf_To."', `lrf_Reason`=" .$commonUses->sqlvalue(str_replace("'","''",@$_POST["lrf_Reason"]), true).", `lrf_JobAlloted`=" .$commonUses->sqlvalue(@$_POST["lrf_JobAlloted"], false).", `lrf_Notes`=" .$commonUses->sqlvalue(str_replace("'","''",@$_POST["lrf_Notes"]), true).", `lrf_Status`='" .$commonUses->sqlvalue(@$_POST["lrf_Status"], false)."', `lrf_Lastmodifiedby`='" .$_SESSION['user']."', `lrf_Lastmodifiedon`='" .$lrf_Lastmodifiedon ."' where " .$this->primarykeycondition();
          mysql_query($sql) or die(mysql_error());
           /* Send email to Administrator*/
           if($_SESSION['usertype']=="Staff")
           {
                   $emailtemprow =$commonUses->getToAddress('Leave Request Form - Update');
                   // To address
                   $to=$emailtemprow['email_value'];
                   // Actual template message
                   $message=$emailtemprow['email_template'];
                   // Subject
                   $subject ="Super Records Leave Request Form From ".$_SESSION['firstname'];
                   //Replace {staff}
                   $message = str_replace("{staff}",$_SESSION['firstname'],$message);
                   //Replace {from}
                   $message = str_replace("{from}",$_POST["lrf_From"],$message);
                   //Replace {to}
                   $message = str_replace("{to}",$_POST["lrf_To"],$message);
                   //Replace {reason}
                   $message = str_replace("{reason}",$_POST["lrf_Reason"],$message);
                   $status=$commonUses->sendMail($to,$subject,$message);
                   if($status==1)
                         $msg="Your request has been sent to Super Records Admin.";
                         header("Location:lrf_leaverequestform.php?msg=".$msg);
            }
        }
        function sql_delete($id)
        {
           $sql = "delete from `lrf_leaverequestform` where lrf_Code='".$id."'";
           if(!mysql_query($sql))
           echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
        }
        function primarykeycondition()
        {
          global $_POST;
          global $commonUses;
          $pk = "";
          $pk .= "(`lrf_Code`";
          if (@$_POST["xlrf_Code"] == "") {
            $pk .= " IS NULL";
          }else{
          $pk .= " = " .$commonUses->sqlvalue(@$_POST["xlrf_Code"], false);
          };
          $pk .= ")";
          return $pk;
        }

 }
	$leaverequestDbcontent = new lrfDetails();
?>

