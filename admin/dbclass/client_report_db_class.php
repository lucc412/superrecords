<?php
class clireportDetails extends Database
{
        function sql_select()
        {
          global $order;
          global $ordtype;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $commonUses;
          
         $cli_DateFrom=$commonUses->getDateFormat($_SESSION["cli_DateFrom"]);
         $cli_DateTo=$commonUses->getDateFormat($_SESSION["cli_DateTo"]);
         $cli_CompanyName=$_SESSION["cli_CompanyName"];
         $cli_State=$_SESSION["cli_State"];
            /*All drop down values*/
            $selectedtype=$this->remove_empty($_SESSION['cli_Type']);
                if($selectedtype!="")
                {
                    $implodetype=implode(",",$selectedtype);
                }
                $selectedstage=$this->remove_empty($_SESSION['cli_Stage']);
                if($selectedstage!="")
                {
                    $implodestage=implode(",",$selectedstage);
                }
                $selectedsalesperson=$this->remove_empty($_SESSION['cli_Salesperson']);
                if($selectedsalesperson!="")
                {
                    $implodesalesperson=implode(",",$selectedsalesperson);
                }
                if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
                {
                        if($_SESSION['staffcode']!="")
                        {
                                $implodesalesperson=$_SESSION['staffcode'];
                        }
                }
                if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                {
                        $selectedsalesperson=$this->remove_empty($_SESSION['cli_Salesperson']);
                        if($selectedsalesperson!="")
                        {
                         $implodesalesperson=implode(",",$selectedsalesperson);
                        }
                }
                $selectedstatus=$this->remove_empty($_SESSION['cli_Status']);
                if($selectedstatus!="")
                {
                    $implodestatus=stripslashes(implode(",",$selectedstatus));
                    $implodestatus=str_replace("\\",'',$implodestatus);
                }
                $filterstr = $commonUses->sqlstr($filter);
                  if (!$wholeonly && isset($wholeonly) && $filterstr!='')
                  {
                    $filterstr = "%" .$filterstr ."%";
                  }
                 if($_SESSION['Submit']=="Generate Excel Report")
                 {
                        $sql= "SELECT * FROM (SELECT t1.`name` as `Company Name`,st1.`cst_Description` as `State`,lp1.`cty_Description` AS `Client Type`,lp14.`cst_Description` AS `Stage`,   c1.`con_Firstname` AS `Salesperson FirstName`, c1.`con_Lastname` AS `Salesperson LastName`,cls1.`cls_Description` AS `Status`, lp15.stf_CCode ,t1.`cli_Code`, t1.`cli_Type`, lp1.`cty_Description` AS `lp_cli_Type`, t1.`name`, t1.`cli_PostalAddress`, t1.`cli_Address`,t1.`cli_Build`, t1.`cli_City`, t1.`cli_State`, st1.`cst_Description` as `lp_cli_State`, t1.`cli_Postcode`, t1.`cli_Country`, t1.`cli_Phone`, t1.`cli_Mobile`, t1.`cli_Fax`, t1.`email`, t1.`cli_Website`, t1.`cli_DateReceived`, t1.`cli_Status`, t1.`cli_Stage`, lp14.`cst_Description` AS `lp_cli_Stage`, cls1.`cls_Description` AS `cli_Lead_Status`, t1.`cli_Notes`, t1.`cli_PhysicalFileId`, t1.`cli_MYOBSerialNo`, t1.`cli_DiscontinuedDate`, t1.`cli_DiscontinuedReason`, t1.`cli_LastReportsSent`, t1.`cli_Createdby`, t1.`cli_Createdon`, t1.`cli_Lastmodifiedby`, t1.`cli_Lastmodifiedon`, t1.`cli_Source`, t1.`cli_MOC`, t1.`cli_Salesperson`, s1.`src_Description` AS `lp_cli_Source`, m1.`moc_Description` AS `lp_cli_MOC`, t1.`cli_Lastdate`, c1.`con_Firstname` AS `lp_cli_Salesperson_fname`, c1.`con_Lastname` AS `lp_cli_Salesperson_lname` FROM `jos_users` AS t1 LEFT OUTER JOIN `cty_clienttype` AS lp1 ON (t1.`cli_Type` = lp1.`cty_Code`) LEFT OUTER JOIN `src_source` AS s1 ON (t1.`cli_Source` = s1.`src_Code`)  LEFT OUTER JOIN `moc_methodofcontact` AS m1 ON (t1.`cli_MOC` = m1.`moc_Code`) LEFT OUTER JOIN `cst_clientstatus` AS lp14 ON (t1.`cli_Stage` = lp14.`cst_Code`) LEFT OUTER JOIN `cls_clientleadstatus` AS cls1 ON (t1.`cli_Status` = cls1.`cls_Code`) LEFT OUTER JOIN `stf_staff` AS lp15 ON ( t1.`cli_SalesPerson` = lp15.`stf_Code` ) LEFT OUTER JOIN `con_contact` AS c1 ON ( lp15.`stf_CCode` = c1.`con_Code` ) LEFT OUTER JOIN `cli_state` AS st1 ON ( t1.`cli_State` = st1.`cst_Code` )";
                 }
                else
                {
                         $sql= "SELECT * FROM (SELECT lp15.stf_CCode ,t1.`cli_Code`, t1.`cli_Type`, lp1.`cty_Description` AS `lp_cli_Type`, t1.`name`, t1.`cli_PostalAddress`, t1.`cli_Address`,t1.`cli_Build`, t1.`cli_City`, t1.`cli_State`, st1.`cst_Description` as `lp_cli_State`, t1.`cli_Postcode`, t1.`cli_Country`, t1.`cli_Phone`, t1.`cli_Mobile`, t1.`cli_Fax`, t1.`email`, t1.`cli_Website`, t1.`cli_DateReceived`, t1.`cli_Status`, t1.`cli_Stage`, lp14.`cst_Description` AS `lp_cli_Stage`, cls1.`cls_Description` AS `cli_Lead_Status`, t1.`cli_Notes`, t1.`cli_PhysicalFileId`, t1.`cli_MYOBSerialNo`, t1.`cli_DiscontinuedDate`, t1.`cli_DiscontinuedReason`, t1.`cli_LastReportsSent`, t1.`cli_Createdby`, t1.`cli_Createdon`, t1.`cli_Lastmodifiedby`, t1.`cli_Lastmodifiedon`, t1.`cli_Source`, t1.`cli_MOC`, t1.`cli_Salesperson`, s1.`src_Description` AS `lp_cli_Source`, m1.`moc_Description` AS `lp_cli_MOC`, t1.`cli_Lastdate`, c1.`con_Firstname` AS `lp_cli_Salesperson_fname`, c1.`con_Lastname` AS `lp_cli_Salesperson_lname` FROM `jos_users` AS t1 LEFT OUTER JOIN `cty_clienttype` AS lp1 ON (t1.`cli_Type` = lp1.`cty_Code`) LEFT OUTER JOIN `src_source` AS s1 ON (t1.`cli_Source` = s1.`src_Code`)   LEFT OUTER JOIN `moc_methodofcontact` AS m1 ON (t1.`cli_MOC` = m1.`moc_Code`) LEFT OUTER JOIN `cst_clientstatus` AS lp14 ON (t1.`cli_Stage` = lp14.`cst_Code`) LEFT OUTER JOIN `cls_clientleadstatus` AS cls1 ON (t1.`cli_Status` = cls1.`cls_Code`) LEFT OUTER JOIN `stf_staff` AS lp15 ON ( t1. `cli_SalesPerson` = lp15. `stf_Code` ) LEFT OUTER JOIN `con_contact` AS c1 ON ( lp15.stf_CCode = c1. `con_Code` ) LEFT OUTER JOIN `cli_state` AS st1 ON ( t1.`cli_State` = st1.`cst_Code` )) subq";
                }
                if($cli_DateFrom!="--" || $cli_DateTo!="--")
                {

                        if($cli_DateFrom!="--" && $cli_DateTo=="--")
                        $sql.=" WHERE (cli_DateReceived = '".$cli_DateFrom. "')";
                        else if($cli_DateFrom=="--" && $cli_DateTo!="--")
                        $sql.=" WHERE (cli_DateReceived = '".$cli_DateTo. "')";
                        else if($cli_DateFrom!="--" && $cli_DateTo!="--")
                        $sql.=" WHERE (cli_DateReceived >= '".$cli_DateFrom. "' AND cli_DateReceived <= '".$cli_DateTo. "')";

                }
                if($_SESSION['cli_CompanyName']!="" || $_SESSION['cli_State']!="" || $implodetype!="" || $implodestage!="" || $implodesalesperson!="" || $implodestatus!="")
                {
                   if($cli_DateFrom=="--" && $cli_DateTo=="--")
                   $sql.=" where (";
                       else
                       $sql.=" AND (";
                }
                if($_SESSION['cli_CompanyName']!="")
                {
                        $where[]=" `name` like '%".$_SESSION['cli_CompanyName']."%'";
                }
                if($_SESSION['cli_State']!="")
                {
                        $where[]=" `cli_State`=".$_SESSION['cli_State'];
                }
                if($implodetype!="")
                {
                        $where[]=" cli_Type IN ( ".$implodetype." ) ";
                }
                if($implodestage!="")
                {
                        $where[]=" cli_Stage IN ( ".$implodestage." )";
                }
                if($implodesalesperson!="")
                {
                        $where[]=" cli_Salesperson IN ( ".$implodesalesperson." ) ";
                }
                if($implodestatus!="")
                {
                        $where[]=" cli_Status IN ( ".$implodestatus." ) ";
                }
                if($_SESSION['cli_CompanyName']!="" || $_SESSION['cli_State']!="" || $implodetype!="" || $implodestage!="" || $implodesalesperson!="" || $implodestatus!="")
                {
                    if($where!="")
                    $sql.= implode(" AND ",$where);
                    $sql.=")";
                }
                if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
                else if (isset($_SESSION['order']) && $_SESSION['order']!='') $sql .= " order by `" .$commonUses->sqlstr($_SESSION['order']) ."`";
                if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
                else if (isset($_SESSION['type']) && $_SESSION['type']!='') $sql .= " " .$commonUses->sqlstr($_SESSION['type']);
                if($_SESSION['Submit']=="Generate Excel Report")
                {
                    $sql.=") subq";
                }
                $res = mysql_query($sql) or die(mysql_error());
                      $_SESSION['query']= "$sql";

          return $res;
        }
        function sql_delete($id)
        {
            $sql = "delete from `jos_users` where cli_Code='".$id."'";
            if(!mysql_query($sql))
            echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
         }
         function remove_empty($array)
         {
             if(is_array($array))
             {
              foreach($array as $key => $value) {
              if($value == "") {
                unset($array[$key]);
              }
            }
            $new_array= array_values($array);
            return $new_array;
            }
         }
 }
	$clireportDbcontent = new clireportDetails();
?>

