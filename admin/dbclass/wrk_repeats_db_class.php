<?php
class repeatsDetails extends Database
{
        function sql_select()
        {
          global $order;
          global $ordtype;
          global $filtertext;
          global $filterfieldrepeat;
          global $wholeonly;
          global $commonUses;

            $filterstr = $commonUses->sqlstr($filtertext);
            if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
            if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
            {
              $condition = " where lp22.cty_Description !='Discontinued' AND ((t1.wrk_StaffInCharge=".$_SESSION['staffcode']." or t1.wrk_ManagerInChrge=".$_SESSION['staffcode']." or t1.wrk_SeniorInCharge=".$_SESSION['staffcode']." or t1.wrk_TeamInCharge=".$_SESSION['staffcode']."))";
            }
            else $condition = " where lp22.cty_Description !='Discontinued'";
            $sql="SELECT lp22.cty_Description ,t2.* , t1.*, lp3.`mas_Description` AS `lp_wrk_MasterActivity` , lp4.`sub_Description` AS `lp_wrk_SubActivity` , lp1.`name` AS `lp_wrk_CompanyName`, lp5.`pri_Description` AS `lp_wrk_Priority`,lp2.`con_Firstname` AS `lp_wrk_ClientContact`, lp7.`stf_Login` AS `lp_wrk_TeamInCharge`,lp8.`stf_Login` AS `lp_wrk_StaffInCharge`, lp9.`stf_Login` AS `lp_wrk_ManagerInChrge`,lp10.`stf_Login` AS `lp_wrk_SeniorInCharge`,DATEDIFF( rpt_end, CURDATE()) as rpt_end_date  FROM `worksheet_repeats` t1 LEFT JOIN wrk_worksheet AS t2 ON ( t2.wrk_Rptid = t1.rpt_id ) LEFT OUTER JOIN `jos_users` AS lp1 ON ( t1.`wrk_ClientCode` = lp1.`cli_Code` ) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON ( t1.`wrk_MasterActivity` = lp3.`mas_Code` ) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON ( t1.`wrk_SubActivity` = lp4.`sub_Code` ) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`) LEFT OUTER JOIN `stf_staff` AS lp7 ON (t1.`wrk_TeamInCharge` = lp7.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp8 ON (t1.`wrk_StaffInCharge` = lp8.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp9 ON (t1.`wrk_ManagerInChrge` = lp9.`stf_Code`) LEFT OUTER JOIN `stf_staff` AS lp10 ON (t1.`wrk_SeniorInCharge` = lp10.`stf_Code`) LEFT OUTER JOIN `con_contact` AS con7 ON ( lp7. `stf_CCode` = con7. `con_Code` ) LEFT OUTER JOIN `con_contact` AS con9 ON ( lp9. `stf_CCode` = con9. `con_Code` ) LEFT OUTER JOIN `con_contact` AS con10 ON ( lp10. `stf_CCode` = con10. `con_Code` ) LEFT OUTER JOIN `con_contact` AS con8 ON ( lp8. `stf_CCode` = con8. `con_Code` ) LEFT OUTER JOIN `cty_clienttype` AS lp22 ON ( lp1. `cli_Type` = lp22. `cty_Code` )".$condition;
            if (isset($filterstr) && $filterstr!='' && isset($filterfieldrepeat) && $filterfieldrepeat!='' && $filterfieldrepeat!="teamincharge" && $filterfieldrepeat!="staffincharge" && $filterfieldrepeat!="managerincharge" && $filterfieldrepeat!="seniorincharge" && $filterfieldrepeat!="allfields") {
                $sql .= " AND " .$commonUses->sqlstr($filterfieldrepeat) ." like '" .$filterstr ."'";
            }
            elseif ($filterfieldrepeat=="teamincharge") {
                $sql .= " AND CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfieldrepeat=="staffincharge") {
                $sql .= " AND CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfieldrepeat=="managerincharge") {
                $sql .= " AND CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfieldrepeat=="seniorincharge") {
                $sql .= " AND CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."'";
            }
            elseif ($filterfieldrepeat=="allfields") {
                $sql .= " AND ((`rpt_id` like '" .$filterstr ."') or (`rpt_type` like '" .$filterstr ."') or (`rpt_end` like '" .$filterstr ."') or (`rpt_endtime` like '" .$filterstr ."') or (`rpt_frequency` like '" .$filterstr ."') or (`rpt_days` like '" .$filterstr ."') or (`rpt_bymonth` like '" .$filterstr ."') or (`rpt_bymonthday` like '" .$filterstr ."') or (`rpt_byday` like '" .$filterstr ."') or (`rpt_bysetpos` like '" .$filterstr ."') or (`rpt_byweekno` like '" .$filterstr ."') or (`rpt_byyearday` like '" .$filterstr ."') or (`rpt_wkst` like '" .$filterstr ."') or (`rpt_count` like '" .$filterstr ."') or  (lp3.`mas_Description` like '" .$filterstr ."') or (lp4.`sub_Description` like '" .$filterstr ."') or (lp3.`mas_Description` like '" .$filterstr ."') or ( lp4.`sub_Description`  like '" .$filterstr ."') or (lp1.`name` like '" .$filterstr ."') or (lp5.`pri_Description` like '" .$filterstr ."') or (lp2.`con_Firstname` like '" .$filterstr ."') or (CONCAT(con7.con_Firstname,' ', con7.con_Lastname) like '" .$filterstr ."') or (CONCAT(con8.con_Firstname,' ', con8.con_Lastname) like '" .$filterstr ."') or (CONCAT(con9.con_Firstname,' ', con9.con_Lastname) like '" .$filterstr ."') or (CONCAT(con10.con_Firstname,' ', con10.con_Lastname) like '" .$filterstr ."'))";
            }
            $sql.=" Group by t2.`wrk_Rptid`";
            if (isset($order) && $order!='')
              $sql .= " order by `" .$commonUses->sqlstr($order) ."`" ;
            else
            $sql .= " order by rpt_end ASC";
             if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
             $res = mysql_query($sql) or die(mysql_error());
            return $res;
        }
        function copyDel()
        {
            global $access_file_level;

                              if($access_file_level['stf_Delete']=="Y")
                              {
                                   if($_POST['checkbox']!="") {
                                       for($i=0;$i<$_POST['count'];$i++){
                                          $del_id = $_POST['checkbox'][$i];
                                            mysql_query("delete from wrk_worksheet where wrk_Code=".$del_id);
                                         }
                                      }
                                      else {
                                          mysql_query("delete from wrk_worksheet where wrk_Code=".$_POST['wrkcode']);
                                       }
                                       if($i==$_POST['count'])
                                         mysql_query("delete from worksheet_repeats where rpt_id=".$_POST['rpt_id']);
                                         ?>
                                          <script>
                                                window.close();self.close();
                                                if (window.opener && !window.opener.closed) {
                                                window.opener.location.reload();
                                            }
                                            </script>
                                            <?php
                                    }
                                     else
                                     {
                                          echo "You are not authorised to delete the record.";
                                     }

        }
 }
	$repeatsDbcontent = new repeatsDetails();
?>

