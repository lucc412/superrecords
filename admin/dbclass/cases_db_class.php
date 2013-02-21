<?php
class casesDetails extends Database
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
          if($_GET['b']!="" && isset($_GET['b']))
          {
             $condition=" where t1.cas_Code=".$_GET['cid'];
          }
          if($_SESSION['usertype']=="Staff" && $_GET['b']=="" && $_SESSION['Viewall']=="N")
          {
              $condition = " where (cas_StaffInCharge=".$_SESSION['staffcode']." or cas_ManagerInChrge=".$_SESSION['staffcode']." or cas_SeniorInCharge=".$_SESSION['staffcode']." or cas_TeamInCharge=".$_SESSION['staffcode']." or cas_AustraliaManager=".$_SESSION['staffcode']." or cas_BillingPerson=".$_SESSION['staffcode']." or cas_SalesPerson=".$_SESSION['staffcode'].")";
          }
            $sql = "SELECT t1.`cas_Code`, t1.`cas_ClientCode`, lp1.`client_name` AS `lp_cas_ClientCode`, t1.`cas_ClientContact`, lp2.`con_Firstname` AS `lp_cas_ClientContact`, t1.`cas_MasterActivity`, lp3.`mas_Description` AS `lp_cas_MasterActivity`, lp3.`Code` AS `lp_cas_Code`, t1.`cas_SubActivity`, lp4.`sub_Description` AS `lp_cas_SubActivity`, lp4.`Code` AS `lp_cas_subCode`, t1.`cas_Priority`, lp5.`pri_Description` AS `lp_cas_Priority`, t1.`cas_Status`, lp6.`cas_Description` AS `lp_cas_Status`, t1.`cas_TeamInCharge`, lp7.`stf_Login` AS `lp_cas_TeamInCharge`, t1.`cas_StaffInCharge`, lp8.`stf_Login` AS `lp_cas_StaffInCharge`, t1.`cas_ManagerInChrge`, t1.`cas_SeniorInCharge`, t1.`cas_AustraliaManager`, t1.`cas_BillingPerson`, t1.`cas_SalesPerson`, lp9.`stf_Login` AS `lp_cas_ManagerInChrge`, lp10.`stf_Login` AS `lp_cas_SeniorInCharge`, t1.`cas_ExternalDueDate`, t1.`cas_InternalDueDate`, t1.`cas_IssueDetails`, t1.`cas_ClientNotes`, t1.`cas_DueTime`, t1.`cas_ClosedDate`, t1.`cas_ClosureReason`, t1.`cas_HoursSpentDecimal`, t1.`cas_Issue_Occurred`, t1.`cas_Resolution`, t1.`cas_Notes`, t1.`cas_TeamInChargeNotes`, t1.`cas_Title`, t1.`cas_Createdby`, t1.`cas_Createdon`, t1.`cas_Lastmodifiedby`, t1.`cas_Lastmodifiedon`, t1.`cas_StatusCompletedon`, t1.`cas_StatusCompletedby`, t1.`cas_Type` FROM `cas_cases` AS t1 LEFT OUTER JOIN `client` AS lp1 ON (t1.`cas_ClientCode` = lp1.`client_id`) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`cas_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`cas_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`cas_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`cas_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `cas_casestatus` AS lp6 ON (t1.`cas_Status` = lp6.`cas_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`cas_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`cas_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`cas_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`cas_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS con7 ON (lp7.`stf_CCode` = con7.`con_Code`) LEFT OUTER JOIN `con_contact` AS con8 ON ( lp8. `stf_CCode` = con8. `con_Code` ) LEFT OUTER JOIN `con_contact` AS con9 ON ( lp9. `stf_CCode` = con9. `con_Code` ) LEFT OUTER JOIN `con_contact` AS con10 ON ( lp10. `stf_CCode` = con10. `con_Code` )".$condition;
          if($_SESSION['usertype']=="Administrator" || ($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")) {
            if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='' && $filterfield!="teamincharge" && $filterfield!="staffincharge" && $filterfield!="managerincharge" && $filterfield!="seniorincharge" && $filterfield!="allfields") {
                $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
          }
            elseif ($filterfield=="teamincharge") {
               $sql .= " where CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="staffincharge") {
               $sql .= " where CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="managerincharge") {
               $sql .= " where CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="seniorincharge") {
               $sql .= " where CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."'";
            }
              elseif ($filterfield=="allfields") {
              $sql .= " where (lp1.`name` like '" .$filterstr ."') or (t1.`cas_Code` like '" .$filterstr ."') or (lp3.`mas_Description` like '" .$filterstr ."') or (lp4.`sub_Description` like '" .$filterstr ."') or (lp5.`pri_Description` like '" .$filterstr ."') or (lp6.`cas_Description` like '" .$filterstr ."') or (CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."') or (CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."') or (CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."') or (CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."') or (`cas_ExternalDueDate` like '" .$filterstr ."') or (`cas_DueTime` like '" .$filterstr ."') or (`cas_ClosedDate` like '" .$filterstr ."')";
              }
        }
         if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N") {
            if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='' && $filterfield!="teamincharge" && $filterfield!="staffincharge" && $filterfield!="managerincharge" && $filterfield!="seniorincharge" && $filterfield!="allfields") {
            $sql .= " AND " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
          }
             elseif ($filterfield=="teamincharge") {
               $sql .= " AND CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="staffincharge") {
               $sql .= " AND CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="managerincharge") {
               $sql .= " AND CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfield=="seniorincharge") {
               $sql .= " AND CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."'";
            }
              elseif ($filterfield=="allfields") {
              $sql .= " AND ((lp1.`name` like '" .$filterstr ."') or (t1.`cas_Code` like '" .$filterstr ."') or (lp3.`mas_Description` like '" .$filterstr ."') or (lp4.`sub_Description` like '" .$filterstr ."') or (lp5.`pri_Description` like '" .$filterstr ."') or (lp6.`cas_Description` like '" .$filterstr ."') or (CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."') or (CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."') or (CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."') or (CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."') or (`cas_ExternalDueDate` like '" .$filterstr ."') or (`cas_DueTime` like '" .$filterstr ."') or (`cas_ClosedDate` like '" .$filterstr ."'))";
              }
        }
          if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
          else $sql .= " order by cas_Createdon desc,cas_Lastmodifiedon";
          //echo $sql;
          if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
             $res = mysql_query($sql) or die(mysql_error());
          return $res;
        }
        function historySelect()
        {
          global $order;
          global $ordtype;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $commonUses;

          $ccid = $_GET['cid'];
          $sql = "SELECT `cas_CCode`,`cas_ClientCode`,`cas_Description`,`cas_Lastmodifiedby`,`cas_Lastmodifiedon` FROM `cas_caseshistory` WHERE cas_CCode=".$ccid;
          $sql .= " order by cas_Lastmodifiedon desc";
          $res = mysql_query($sql) or die(mysql_error());
          return $res;
        }

        function sql_insert()
        {
          global $_POST;
          global $commonUses;
          global $ClientEmailcontent;
          
          $cas_InDueDate=$commonUses->getDateFormat($_POST["cas_InternalDueDate"]);
          $cas_DueDate=$commonUses->getDateFormat($_POST["cas_ExternalDueDate"]);
          $cas_ClosedDate=$commonUses->getDateFormat($_POST["cas_ClosedDate"]);
          $cas_DueTime=$_POST['hour'].":".$_POST['minute'].":".$_POST['second'];
          $cas_Createdon=date( 'Y-m-d H:i:s' );
          $cas_res = $_POST['cas_Resolution'];
          $cas_tit = $_POST['cas_Title'];
          if($_POST["cas_ClosedDate"]) $cas_close = $cas_ClosedDate; else $cas_close = "0000-00-00";
          if($cas_res) $cas_resol = "='".$_POST['cas_Resolution']."'"; else $cas_resol = " IS NULL";
          if($cas_tit) $cas_title = "='".$_POST['cas_Title']."'"; else $cas_title = " IS NULL";
          $qry = "SELECT * FROM cas_cases WHERE cas_ClientCode='".$_POST["cas_ClientCode"]."' AND cas_ClientContact='".$_POST["cas_ClientContact"]."' AND cas_MasterActivity='".$_POST["cas_MasterActivity"]."' AND cas_SubActivity='".$_POST['cas_SubActivity']."' AND cas_Priority='".$_POST['cas_Priority']."' AND cas_Status='".$_POST['cas_Status']."' AND cas_TeamInCharge='".$_POST['cas_TeamInCharge']."' AND cas_StaffInCharge='".$_POST['cas_StaffInCharge']."' AND cas_ManagerInChrge='".$_POST['cas_ManagerInChrge']."' AND cas_SeniorInCharge='".$_POST['cas_SeniorInCharge']."' AND cas_AustraliaManager='".$_POST['cas_AustraliaManager']."' AND cas_BillingPerson='".$_POST['cas_BillingPerson']."' AND cas_SalesPerson='".$_POST['cas_SalesPerson']."' AND cas_InternalDueDate='".$cas_InDueDate."' AND cas_ExternalDueDate='".$cas_DueDate."' AND cas_ClosedDate='".$cas_close."' AND cas_IssueDetails='".$_POST['cas_IssueDetails']."' AND cas_Resolution".$cas_resol." AND cas_Title".$cas_title;
          $res_qry = mysql_query($qry);
          $dup_row = @mysql_num_rows($res_qry);
          if($dup_row=="0") {
          if($_POST['cas_Type']) {
          $sql = "insert into `cas_cases` (`cas_ClientCode`, `cas_ClientContact`, `cas_MasterActivity`, `cas_SubActivity`, `cas_Priority`, `cas_Status`, `cas_TeamInCharge`, `cas_StaffInCharge`, `cas_ManagerInChrge`, `cas_SeniorInCharge`, `cas_AustraliaManager`, `cas_BillingPerson`, `cas_SalesPerson`, `cas_InternalDueDate`, `cas_ExternalDueDate`, `cas_DueTime`, `cas_IssueDetails`, `cas_ClosedDate`, `cas_ClosureReason`, `cas_HoursSpentDecimal`, `cas_Issue_Occurred`, `cas_Resolution`, `cas_Notes`, `cas_TeamInChargeNotes`, `cas_Title`, `cas_Type`, `cas_Createdby`, `cas_Createdon`, `cas_Flag`) values (" .$commonUses->sqlvalue(@$_POST["cas_ClientCode"], false).", " .$commonUses->sqlvalue(@$_POST["cas_ClientContact"], false).", " .$commonUses->sqlvalue(@$_POST["cas_MasterActivity"], false).", " .$commonUses->sqlvalue(@$_POST["cas_SubActivity"], false).", " .$commonUses->sqlvalue(@$_POST["cas_Priority"], false).", " .$commonUses->sqlvalue(@$_POST["cas_Status"], false).", " .$commonUses->sqlvalue(@$_POST["cas_TeamInCharge"], false).", " .$commonUses->sqlvalue(@$_POST["cas_StaffInCharge"], false).", " .$commonUses->sqlvalue(@$_POST["cas_ManagerInChrge"], false).", " .$commonUses->sqlvalue(@$_POST["cas_SeniorInCharge"], false).", " .$commonUses->sqlvalue(@$_POST["cas_AustraliaManager"], false).", " .$commonUses->sqlvalue(@$_POST["cas_BillingPerson"], false).", " .$commonUses->sqlvalue(@$_POST["cas_SalesPerson"], false).", " .$commonUses->sqlvalue($cas_InDueDate, true).", " .$commonUses->sqlvalue($cas_DueDate, true).", " .$commonUses->sqlvalue($cas_DueTime, true).", '" .mysql_real_escape_string(@$_POST["cas_IssueDetails"])."', " .$commonUses->sqlvalue($cas_ClosedDate, true).", '" .mysql_real_escape_string(@$_POST["cas_ClosureReason"])."', " .$commonUses->sqlvalue(@$_POST["cas_HoursSpentDecimal"], false).", '" .mysql_real_escape_string(@$_POST["cas_Issue_Occurred"])."', '" .mysql_real_escape_string(@$_POST["cas_Resolution"])."', '" .mysql_real_escape_string(@$_POST["cas_Notes"])."', '" .mysql_real_escape_string(@$_POST["cas_TeamInChargeNotes"])."', '" .mysql_real_escape_string(@$_POST["cas_Title"])."', " .$commonUses->sqlvalue(stripslashes(@$_POST["cas_Type"]), false).", '" .$_SESSION['staffcode']."', '" .$cas_Createdon."', 'Y')";
          mysql_query($sql) or die(mysql_error());
          // Last insert ID
                   $result = (mysql_query ('SELECT LAST_INSERT_ID() FROM cas_cases'));
                   $row=mysql_fetch_row($result);
                   $autoid = $row[0];
                    $sqlhistory = "insert into `cas_caseshistory` (`cas_CCode`, `cas_ClientCode`, `cas_Description`, `cas_Lastmodifiedby`, `cas_Lastmodifiedon`) values ('" .$autoid."', '" .$_POST["cas_ClientCode"]."', '" .str_replace("'","''",stripslashes($_POST["hisContent"]))."', '" .$_SESSION['staffcode']."', '" .$cas_Createdon."')";
                   $insert_result = mysql_query($sqlhistory) or die(mysql_error());
                   // insert action require table
                   $action_count = count($_POST['cas_ActionDetails']);
                   if($action_count>0) {
                       for($i=0;$i<$action_count;$i++) {
                           $action_details = $_POST['cas_ActionDetails'][$i];
                           $action_staff = $_POST['cas_Staff'][$i];
                           $action_query = "insert into cas_actionrequired (cas_Code,cas_ActionDetails,cas_Staff) values (".$autoid.",'".  mysql_real_escape_string($action_details)."','".  mysql_real_escape_string($action_staff)."')";
                           mysql_query($action_query);
                       }
                   }
                   
          if($insert_result)
          {
             echo $script_content = "<script>
                                    alert('Your Ticket number is - '+$autoid);
									window.location.href = 'cas_cases.php?a=reset';
                                </script>";
              $ClientEmailcontent->clientCasesMail($_POST["cas_ClientCode"],'new','admin',$_POST["cas_Priority"],$_POST['cas_IssueDetails'],$cas_InDueDate,$autoid,$_POST['cas_AustraliaManager'],$_POST['cas_TeamInCharge'],$_POST['cas_ManagerInChrge'],$_POST['cas_StaffInCharge'],$_POST['cas_Type']);
          }
          }
            else {
                            echo $script_content = "<script>
                                    alert('Ticket Type is Mandatory');
                                    window.history.back(-1);
                                </script>";                
            }
          
        }
        }
        function sql_update()
        {
              global $_POST;
              global $commonUses;
              global $ClientEmailcontent;

              $cas_InDueDate=$commonUses->getDateFormat($_POST["cas_InternalDueDate"]);
              $cas_DueDate=$commonUses->getDateFormat($_POST["cas_ExternalDueDate"]);
              if($_POST["cas_ClosedDate"]) $cas_ClosedDate=$commonUses->getDateFormat($_POST["cas_ClosedDate"]);
              $cas_DueTime=$_POST['hour'].":".$_POST['minute'].":".$_POST['second'];
              $cas_Lastmodifiedon=date( 'Y-m-d H:i:s' );
              $curstatus = $_POST['cas_Status'];
              $oldstatus = $_POST['cas_Statusold'];

              if($_POST['cas_SubActivity']!="")
             {
                $cas_SubActivity=$_POST['cas_SubActivity'];
             }
            else if($_POST['cas_SubActivity_old']!="" && $_POST['cas_SubActivity']=="")
            {
             $cas_SubActivity=$_POST['cas_SubActivity_old'];
            }
                 if($_POST['cas_ClientCode']!="")
            {
                $cas_ClientCode=$_POST['cas_ClientCode'];
            }
            else if($_POST['cas_ClientCode_old']!="" && $_POST['cas_ClientCode']=="")
            {
            $cas_ClientCode=$_POST['cas_ClientCode_old'];
            }
               if($_POST['cas_ClientContact']!="")
            {
             $cas_ClientContact=$_POST['cas_ClientContact'];
            }
            else if($_POST['cas_ClientContact_old']!="" && $_POST['cas_ClientContact']=="")
            {
             $cas_ClientContact=$_POST['cas_ClientContact_old'];
            }
            if($_POST['cas_Type']) {
               $sql = "update `cas_cases` set `cas_ClientCode`=" .$commonUses->sqlvalue(@$cas_ClientCode, false).", `cas_ClientContact`=" .$commonUses->sqlvalue(@$cas_ClientContact, false).", `cas_MasterActivity`=" .$commonUses->sqlvalue(@$_POST["cas_MasterActivity"], false).", `cas_SubActivity`=" .$commonUses->sqlvalue(@$cas_SubActivity, false).", `cas_Priority`=" .$commonUses->sqlvalue(@$_POST["cas_Priority"], false).", `cas_Status`=" .$commonUses->sqlvalue(@$_POST["cas_Status"], false).", `cas_TeamInCharge`=" .$commonUses->sqlvalue(@$_POST["cas_TeamInCharge"], false).", `cas_StaffInCharge`=" .$commonUses->sqlvalue(@$_POST["cas_StaffInCharge"], false).", `cas_ManagerInChrge`=" .$commonUses->sqlvalue(@$_POST["cas_ManagerInChrge"], false).", `cas_SeniorInCharge`=" .$commonUses->sqlvalue(@$_POST["cas_SeniorInCharge"], false).", `cas_AustraliaManager`=" .$commonUses->sqlvalue(@$_POST["cas_AustraliaManager"], false).", `cas_BillingPerson`=" .$commonUses->sqlvalue(@$_POST["cas_BillingPerson"], false).", `cas_SalesPerson`=" .$commonUses->sqlvalue(@$_POST["cas_SalesPerson"], false).", `cas_InternalDueDate`=" .$commonUses->sqlvalue($cas_InDueDate, true).", `cas_ExternalDueDate`=" .$commonUses->sqlvalue($cas_DueDate, true).", `cas_DueTime`=" .$commonUses->sqlvalue($cas_DueTime, true).", `cas_IssueDetails`='" .mysql_real_escape_string(@$_POST["cas_IssueDetails"])."', `cas_ClosedDate`=" .$commonUses->sqlvalue($cas_ClosedDate, true).", `cas_ClosureReason`='" .mysql_real_escape_string(@$_POST["cas_ClosureReason"])."', `cas_HoursSpentDecimal`=" .$commonUses->sqlvalue(@$_POST["cas_HoursSpentDecimal"], false).", `cas_Issue_Occurred`='" .mysql_real_escape_string(@$_POST["cas_Issue_Occurred"])."', `cas_Resolution`='" .mysql_real_escape_string(@$_POST["cas_Resolution"])."', `cas_Notes`='" .mysql_real_escape_string(@$_POST["cas_Notes"])."', `cas_TeamInChargeNotes`='" .mysql_real_escape_string(@$_POST["cas_TeamInChargeNotes"])."', `cas_Title`='" .mysql_real_escape_string(@$_POST["cas_Title"])."', `cas_Type`=" .$commonUses->sqlvalue(stripslashes(@$_POST["cas_Type"]), false).", `cas_Lastmodifiedby`='" .$_SESSION['staffcode']."', `cas_Lastmodifiedon`='" .$cas_Lastmodifiedon ."' where " .$this->primarykeycondition();
               $update_result = mysql_query($sql) or die(mysql_error());
			   
               // history
               $query = "SELECT cas_CCode FROM cas_caseshistory WHERE cas_CCode=".$_POST['xcas_Code']." AND cas_Lastmodifiedby='".$_SESSION['staffcode']."'";
               $result = mysql_query($query);
               $hid = mysql_num_rows($result);
              // insert history
               if($hid==0) {
                    $sqlhistory = "insert into `cas_caseshistory` (`cas_CCode`, `cas_ClientCode`, `cas_Description`, `cas_Lastmodifiedby`, `cas_Lastmodifiedon`) values ('" .$_POST["xcas_Code"]."', '" .$cas_ClientCode."', '" .mysql_real_escape_string($_POST["hisContent"])."', '" .$_SESSION['staffcode']."', '" .$cas_Lastmodifiedon."')";
                    mysql_query($sqlhistory) or die(mysql_error());
               }
               else {
                    $sqlhistory = "UPDATE `cas_caseshistory` SET `cas_CCode`='" .$_POST["xcas_Code"]."', `cas_ClientCode`='" .$cas_ClientCode."', `cas_Description`='" .mysql_real_escape_string($_POST["hisContent"])."' ,`cas_Lastmodifiedby`='" .$_SESSION['staffcode']."', `cas_Lastmodifiedon`='" .$cas_Lastmodifiedon."' WHERE cas_CCode=".$_POST['xcas_Code']." AND cas_Lastmodifiedby='".$_SESSION['staffcode']."'";
                    mysql_query($sqlhistory) or die(mysql_error());
               }
                   // update action require table
                   $action_count = count($_POST['cas_ActionDetails']);
                   if($action_count>0) {
                       $act_del = mysql_query("delete from cas_actionrequired where cas_Code=".$_POST["xcas_Code"]);
                       for($i=0;$i<$action_count;$i++) {
                           $action_details = $_POST['cas_ActionDetails'][$i];
                           $action_staff = $_POST['cas_Staff'][$i];
                           $action_query = "insert into cas_actionrequired (cas_Code,cas_ActionDetails,cas_Staff) values (".$_POST["xcas_Code"].",'".  mysql_real_escape_string($action_details)."','".  mysql_real_escape_string($action_staff)."')";
                           mysql_query($action_query);
                       }
                   }
				 
               // updated cases mail
               if(($curstatus!="3") && ($_POST['cas_Title']!=$_POST['cas_Titleold'] || $_POST['cas_ClientCode']!="" || $_POST['cas_MasterActivity']!=$_POST['cas_MasterActivityold'] || $_POST['cas_Priority']!=$_POST['cas_Priorityold'] || $_POST['cas_Status']!=$_POST['cas_Statusold'] || $_POST['cas_StaffInCharge']!=$_POST['cas_StaffInChargeold'] || $_POST['cas_TeamInCharge']!=$_POST['cas_TeamInChargeold'] || $_POST['cas_ManagerInChrge']!=$_POST['cas_ManagerInChrgeold'] || $_POST['cas_SeniorInCharge']!=$_POST['cas_SeniorInChargeold'] || $_POST['cas_AustraliaManager']!=$_POST['cas_AustraliaManagerold'] || $_POST['cas_BillingPerson']!=$_POST['cas_BillingPersonold'] || $_POST['cas_SalesPerson']!=$_POST['cas_SalesPersonold'] || $cas_InDueDate!=$_POST['cas_InternalDueDateold'] || $cas_DueDate!=$_POST['cas_ExternalDueDateold'] || $cas_DueTime!=$_POST['duetimeold'] || $_POST['cas_IssueDetails']!=$_POST['cas_IssueDetailsold'] || $_POST['cas_Resolution']!=$_POST['cas_Resolutionold']))
              {
                    $ClientEmailcontent->clientCasesMail($cas_ClientCode,'edit','admin',$_POST["cas_Priority"],$_POST['cas_IssueDetails'],$_POST["cas_InternalDueDate"],$_POST["xcas_Code"],$_POST['cas_AustraliaManager'],$_POST['cas_TeamInCharge'],$_POST['cas_ManagerInChrge'],$_POST['cas_StaffInCharge'],$_POST['cas_Type']);
              }
              // get issue created user
              $query = "SELECT cas_Createdby FROM cas_cases WHERE cas_Code=".$_POST["xcas_Code"];
              $result = mysql_query($query);
              $create = mysql_fetch_array($result);
              $createname = $create['cas_Createdby'];
               // status completed mail goes to client
               if(($curstatus=="3") && ($curstatus!=$oldstatus))
               {
                   // status update query
                   $query = "UPDATE cas_cases SET cas_StatusCompletedon='".$cas_Lastmodifiedon."',cas_StatusCompletedby='".$_SESSION['staffcode']."' WHERE " .$this->primarykeycondition();
                   mysql_query($query);
                    // status mail
                   $ClientEmailcontent->CaseStatusMail($cas_ClientCode,$_POST["cas_IssueDetails"],$_POST["cas_InternalDueDate"],$createname,$_POST['cas_AustraliaManager'],$_POST['cas_TeamInCharge'],$_POST["cas_Resolution"],'Status',$_POST['cas_Type'],$_POST['cas_ManagerInChrge'],$_POST['cas_StaffInCharge']);
               }
               if($_POST['cas_Type']=='2' && $_POST['cas_Type']!=$_POST['cas_Typeold']) {
                   $ClientEmailcontent->CaseStatusMail($cas_ClientCode,$_POST["cas_IssueDetails"],$_POST["cas_InternalDueDate"],$createname,$_POST['cas_AustraliaManager'],$_POST['cas_TeamInCharge'],$_POST["cas_Resolution"],'CaseType',$_POST['cas_Type'],$_POST['cas_ManagerInChrge'],$_POST['cas_StaffInCharge']);
               }
			}
            else {
                            echo $script_content = "<script>
                                    alert('Ticket Type is Mandatory');
                                    window.history.back(-1);
                                </script>";                
            }
        }
        function sql_delete($id)
        {
           $sql = "delete from `cas_cases` where cas_Code='".$id."'";
           if(!mysql_query($sql))
           echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
        }
        function primarykeycondition()
        {
              global $_POST;
              global $commonUses;
              
              $pk = "";
              $pk .= "(`cas_Code`";
              if (@$_POST["xcas_Code"] == "") {
              $pk .= " IS NULL";
              }else{
              $pk .= " = " .$commonUses->sqlvalue(@$_POST["xcas_Code"], false);
              };
              $pk .= ")";
              return $pk;
        }
 }
	$casesDbcontent = new casesDetails();
?>
