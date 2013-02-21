<?php
class empcontactDetails extends Database
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
              if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
              $sql = "SELECT * FROM (SELECT t1.`con_Code`, t1.`con_Type`, lp1.`cnt_Description` AS `lp_con_Type`, t1.`con_Designation`, lp2.`dsg_Description` AS `lp_con_Designation`, lp3.`cst_Description` state_Description,  t1.`con_Salutation`, t1.`con_Firstname`, t1.`con_Middlename`, t1.`con_Lastname`, t1.`con_Company`,t1.`con_Build`, t1.`con_Address`, t1.`con_City`, t1.`con_State`, t1.`con_Postcode`, t1.`con_Country`, t1.`con_Phone`, t1.`con_Mobile`, t1.`con_Fax`, t1.`con_Email`, t1.`con_Notes`, t1.`con_Createdby`, t1.`con_Createdon`, t1.`con_Lastmodifiedby`, t1.`con_Lastmodifiedon` FROM `con_contact` AS t1 
			  LEFT OUTER JOIN `cnt_contacttype` AS lp1 ON (t1.`con_Type` = lp1.`cnt_Code`) 
			  LEFT OUTER JOIN `dsg_designation` AS lp2 ON (t1.`con_Designation` = lp2.`dsg_Code`) 
			  LEFT OUTER JOIN `cli_state` AS lp3 ON (t1.`con_State` = lp3.`cst_Code`) 
			  WHERE lp1.`cnt_Description` = 'Employee') subq";
              if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
                $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
              } elseif (isset($filterstr) && $filterstr!='') {
                $sql .= " where (`con_Code` like '" .$filterstr ."') or (`lp_con_Type` like '" .$filterstr ."') or (`lp_con_Designation` like '" .$filterstr ."') or (`con_Firstname` like '" .$filterstr ."') or (`con_Middlename` like '" .$filterstr ."') or (`con_Lastname` like '" .$filterstr ."') 
				or (`con_Address` like '" .$filterstr ."') or (`con_City` like '" .$filterstr ."') 
				or (`con_State` like '" .$filterstr ."') or (`con_Postcode` like '" .$filterstr ."') 
				or (`con_Country` like '" .$filterstr ."') or (`con_Phone` like '" .$filterstr ."') 
				or (`con_Mobile` like '" .$filterstr ."') or (`con_Fax` like '" .$filterstr ."') 
				or (`con_Email` like '" .$filterstr ."') or (`con_Notes` like '" .$filterstr ."') 
				or (`con_Createdby` like '" .$filterstr ."') or (`con_Createdon` like '" .$filterstr ."') 
				or (`con_Lastmodifiedby` like '" .$filterstr ."') or (`con_Lastmodifiedon` like '" .$filterstr ."')";
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
          $con_Createdon=date( 'Y-m-d H:i:s' );
          $fields=array('con_Firstname','con_Lastname','con_Build');
          $postvalue=array(mysql_real_escape_string($_POST["con_Firstname"]),mysql_real_escape_string($_POST["con_Lastname"]),mysql_real_escape_string($_POST["con_Build"]));
          $where= " where ".$fields[0]."='".$postvalue[0]."' and ".$fields[1]."='".$postvalue[1]."' and ".$fields[2]."='".$postvalue[2]."'";
          $duplicate_entry = $commonUses->checkDuplicateMultiple('con_contact',$fields,$postvalue,$where);
          if($duplicate_entry==0)
          {
              $sql = "insert into `con_contact` (`con_Code`, `con_Type`, `con_Designation`, `con_Salutation`, `con_Firstname`, `con_Middlename`, `con_Lastname`, `con_Company`, `con_Build`, `con_Address`, `con_City`, `con_State`, `con_Postcode`, `con_Country`, `con_Phone`, `con_Mobile`, `con_Fax`, `con_Email`, `con_Notes`, `con_Createdby`, `con_Createdon`) values (" .$commonUses->sqlvalue(@$_POST["con_Code"], false).", " .$commonUses->sqlvalue(@$_POST["con_Type"], false).", " .$commonUses->sqlvalue(@$_POST["con_Designation"], false).", '" .stripslashes(@$_POST["con_Salutation"]) ."', '" .mysql_real_escape_string(@$_POST["con_Firstname"]) ."', '" .mysql_real_escape_string(@$_POST["con_Middlename"]) ."', '" .mysql_real_escape_string(@$_POST["con_Lastname"]) ."', '" .mysql_real_escape_string(@$_POST["con_Company"])."', '" .mysql_real_escape_string(@$_POST["con_Build"]) ."','" .mysql_real_escape_string(@$_POST["con_Address"]) ."', '" .mysql_real_escape_string(@$_POST["con_City"])."', '" .mysql_real_escape_string(@$_POST["con_State"])."', '" .mysql_real_escape_string(@$_POST["con_Postcode"])."', '" .mysql_real_escape_string(@$_POST["con_Country"])."', '" .mysql_real_escape_string(@$_POST["con_Phone"])."', '" .mysql_real_escape_string(@$_POST["con_Mobile"])."', '" .mysql_real_escape_string($_POST["con_Fax"])."', '" .mysql_real_escape_string(@$_POST["con_Email"])."', '" .mysql_real_escape_string(@$_POST["con_Notes"]) ."', '" .$_SESSION['user']."', '" .$con_Createdon."')";
              mysql_query($sql) or die(mysql_error());
          }
        }

        function sql_update()
        {
          global $_POST;
          global $commonUses;
            $Lastmodifiedon=date( 'Y-m-d H:i:s' );
             if($_POST['con_Company']!="")
             {
                $con_Company=$_POST['con_Company'];
             }
             else if($_POST['con_Company_old']!="" && $_POST['con_Company']=="")
             {
                $con_Company=$_POST['con_Company_old'];
             }
             else
             {
                $con_Company="";
             }
                  $sql = "update `con_contact` set `con_Type`=" .$commonUses->sqlvalue(@$_POST["con_Type"], false).", `con_Designation`=" .$commonUses->sqlvalue(@$_POST["con_Designation"], false).", `con_Salutation`='" .stripslashes(@$_POST["con_Salutation"]) ."', `con_Firstname`='" .mysql_real_escape_string(@$_POST["con_Firstname"]) ."', `con_Middlename`='" .mysql_real_escape_string(@$_POST["con_Middlename"]) ."', `con_Lastname`='" .mysql_real_escape_string(@$_POST["con_Lastname"]) ."', `con_Company`='" .mysql_real_escape_string($con_Company)."', `con_Address`='" .mysql_real_escape_string(@$_POST["con_Address"]) ."', `con_Build`='" .mysql_real_escape_string(@$_POST["con_Build"]) ."',`con_City`='" .mysql_real_escape_string(@$_POST["con_City"])."', `con_State`='" .mysql_real_escape_string(@$_POST["con_State"])."', `con_Postcode`='" .mysql_real_escape_string(@$_POST["con_Postcode"])."', `con_Country`='" .mysql_real_escape_string(@$_POST["con_Country"])."', `con_Phone`='" .mysql_real_escape_string(@$_POST["con_Phone"])."', `con_Mobile`='" .mysql_real_escape_string(@$_POST["con_Mobile"])."', `con_Fax`='" .mysql_real_escape_string(@$_POST["con_Fax"])."', `con_Email`='" .mysql_real_escape_string(@$_POST["con_Email"])."', `con_Notes`='" .mysql_real_escape_string(@$_POST["con_Notes"]) ."', `con_Lastmodifiedby`='" .$_SESSION['user']."', `con_Lastmodifiedon`='" .$con_Lastmodifiedon."' where " .$this->primarykeycondition();
                 mysql_query($sql) or die(mysql_error());
        }
        function sql_delete($id)
        {
           $sql = "delete from `con_contact` where con_Code='".$id."'";
           if(!mysql_query($sql))
           echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
         }
        function primarykeycondition()
        {
          global $_POST;
          global $commonUses;
          $pk = "";
          $pk .= "(`con_Code`";
          if (@$_POST["xcon_Code"] == "") {
            $pk .= " IS NULL";
          }else{
            $pk .= " = " .$commonUses->sqlvalue(@$_POST["xcon_Code"], false);
          };
          $pk .= ")";
          return $pk;
        }

 }
	$empcontactDbcontent = new empcontactDetails();
?>

