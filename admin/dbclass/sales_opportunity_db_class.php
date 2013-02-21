<?php
class CrossSalesDetails extends Database
{
                        // client table select query
                            function sql_select(&$count=0)
                            {
                                  global $order;
                                  global $ordtype;
                                  global $filter;
                                  global $filterfield;
                                  global $wholeonly;
                                  global $commonUses;
                                  global $CrossDbcontent;
                                  
                                      if($_GET['a']=="edit" && $_GET['recid']!="" && $cli_code!="" && $_GET['record']=="new")
                                      {
                                          $filter="";
                                          $order="";
                                          $ordtype="";
                                          $filterfield="";
                                          $wholeonly="";
                                      }
                                      $filterstr = $commonUses->sqlstr($filter);
                                        if($_GET['b']!="" && isset($_GET['b']))
                                      {
                                            $condition=" where t1.id=".$_GET['cli_code'];
                                      }
                                      else if($_SESSION['usertype']=="Staff" && $_GET['b']=="" && $_SESSION['Viewall']=="N")
                                      {
                                            $condition=" where (t1.`cso_sales_person` ='".$_SESSION['staffcode']."' OR t1.`cso_generated_lead` ='".$_SESSION['staffcode']."' OR t1.`cso_created_by` ='".$_SESSION['staffcode']."')";
                                      }
                                      if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
                                      
                                            $sql = "SELECT * FROM (SELECT t1.*, cls1.`cls_Description` AS `cli_lead_status`, lp14.`cst_Description` AS `lp_cli_Stage`, m1.`moc_Description` AS `lp_cli_MOC`, CONCAT(c1.`con_Firstname`,' ',c1.`con_Lastname`) AS `lp_cli_Salesperson`, j1.`name` AS `cso_client_name`, CONCAT(cn1.con_Firstname,' ',cn1.con_Lastname) AS `cso_contact_name`, CONCAT(c2.`con_Firstname`,' ',c2.`con_Lastname`) AS `cso_lead_person`, src.`src_Description` AS `source_name` FROM `cso_cross_sales_opportunity` AS t1 LEFT OUTER JOIN `stf_staff` AS s2 ON (t1.`cso_sales_person` = s2.`stf_Code`) LEFT OUTER JOIN `con_contact` AS c1 ON (s2.`stf_CCode` = c1.`con_Code`) LEFT OUTER JOIN `moc_methodofcontact` AS m1 ON (t1.`cso_method_of_contact` = m1.`moc_Code`) LEFT OUTER JOIN `cls_clientleadstatus` AS cls1 ON (t1.`cso_lead_status` = cls1.`cls_Code`) LEFT OUTER JOIN `cst_clientstatus` AS lp14 ON (t1.`cso_stage` = lp14.`cst_Code`) LEFT OUTER JOIN jos_users as j1 ON (t1.cso_client_code = j1.cli_Code) LEFT OUTER JOIN con_contact as cn1 ON (t1.cso_contact_code = cn1.con_Code) LEFT OUTER JOIN `stf_staff` AS s3 ON (t1.`cso_generated_lead` = s3.`stf_Code`) LEFT OUTER JOIN `con_contact` AS c2 ON (s3.`stf_CCode` = c2.`con_Code`) LEFT OUTER JOIN `src_source` AS src ON (t1.`cso_source` = src.`src_Code`) ".$condition." ) subq";

                                      if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='')
                                      {
                                                $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
                                                 if($_GET['a']=="edit")
                                                    $sql.=" and (id=".$_GET['cli_code'].")";
                                      } 
                                      elseif (isset($filterstr) && $filterstr!='')
                                      {
                                              if($_GET['a']=="edit")
                                                  $where=" where ((";
                                              else $where=" where(";
                                                    $sql .= $where."`cso_client_name` like '" .$filterstr ."' or (`lp_cli_Stage` like '" .$filterstr ."') or (`cli_lead_status` like '" .$filterstr ."') or (`cso_lead_person` like '" .$filterstr ."') or (`lp_cli_MOC` like '" .$filterstr ."') or (`lp_cli_Salesperson` like '" .$filterstr ."'))";
                                                /* Check access rights for client type only*/
                                             if($_GET['a']=="edit")
                                                $sql.=") and (id=".$_GET['cli_code'].")";
                                      }
                                      if($_GET['a']=="edit" && $filterstr=='' && $filterfield=="")
                                            $sql.=" where id=".$_GET['cli_code'];
                                      if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
                                      else $sql.=" GROUP BY id ORDER BY cso_modified_date desc";
                                   //   echo $sql; 
                                      if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
                                        $res = mysql_query($sql) or die(mysql_error());
                                        $count = mysql_num_rows($res);
                                        
                                      return $res;
                              }
                                // client insert follow
                                function sql_insert()
                                {
                                          global $_POST;
                                          global $access_file_level;
                                          global $commonUses;
                                          global $ClientEmailcontent;
                                          
                                          $last_contact_date = $commonUses->getDateFormat($_POST["cso_last_contact_date"]);
                                          $Createdon=date( 'Y-m-d H:i:s' );
                                          $future_contact_date = $commonUses->getDateFormat($_POST["cso_future_contact_date"]);
                                          $date_received = $commonUses->getDateFormat($_POST["cso_date_received"]);
                                          /*Get client type*/
                                          $fields=array('cso_client_code','cso_entity','cso_date_received','cso_stage','cso_lead_status');
                                          $postvalue=array(mysql_real_escape_string($_POST['cso_client_code']),mysql_real_escape_string($_POST['cso_entity']),mysql_real_escape_string($date_received),mysql_real_escape_string($_POST['cso_stage']),mysql_real_escape_string($_POST['cso_lead_status']));
                                          $where= " where ".$fields[0]."='".$postvalue[0]."' and ".$fields[1]."='".$postvalue[1]."' and ".$fields[2]."='".$postvalue[2]."' and ".$fields[3]."='".$postvalue[3]."' and ".$fields[4]."='".$postvalue[4]."'";
                                          $duplicate_entry = $commonUses->checkDuplicateMultiple('cso_cross_sales_opportunity',$fields,$postvalue,$where);
                                          if($duplicate_entry==0)
                                          {
                                                   $sql = "INSERT INTO `cso_cross_sales_opportunity` (`cso_client_code`, `cso_contact_code`, `cso_entity`, `cso_date_received`, `cso_day_received`, `cso_lead_status`, `cso_source`, `cso_stage`, `cso_generated_lead`, `cso_method_of_contact`, `cso_sales_person`, `cso_last_contact_date`, `cso_future_contact_date`, `cso_notes`, `cso_created_by`, `cso_created_date`, `cso_modified_by`, `cso_modified_date`) values ('".mysql_real_escape_string(@$_POST["cso_client_code"])."', '".mysql_real_escape_string(@$_POST["cso_contact_code"])."', '".mysql_real_escape_string(@$_POST["cso_entity"])."', '".mysql_real_escape_string($date_received)."', '".mysql_real_escape_string(@$_POST["cso_day_received"])."', '".mysql_real_escape_string(@$_POST["cso_lead_status"])."', '".mysql_real_escape_string(@$_POST["cso_source"])."', '".mysql_real_escape_string(@$_POST["cso_stage"])."', '".mysql_real_escape_string(@$_POST["cso_generated_lead"])."', '".mysql_real_escape_string(@$_POST["cso_method_of_contact"])."', '".mysql_real_escape_string(@$_POST["cso_sales_person"])."', '".mysql_real_escape_string($last_contact_date)."', '".mysql_real_escape_string($future_contact_date)."', '".mysql_real_escape_string(@$_POST["cso_notes"])."', '".mysql_real_escape_string($_SESSION[staffcode])."', '".mysql_real_escape_string($Createdon)."', '".mysql_real_escape_string($_SESSION[staffcode])."', '".mysql_real_escape_string($Createdon)."')";
                                                   $insertresult=mysql_query($sql) or die(mysql_error());
                                                    //Insert this service required code in details table
                                                           $selectedservice=$_POST['cso_service_required'];
                                                           if($selectedservice!="")
                                                           {
                                                               foreach($selectedservice as $v)
                                                               {
                                                                   $sql = "insert into `cli_allservicerequired` (`cli_ClientCode`, `cli_ServiceRequiredCode`, `cli_Form`) values (".$commonUses->sqlvalue($_POST['cso_client_code'], false).", ".$commonUses->sqlvalue($v, false).",'Sales Opportunity')";
                                                                   $insertResult=mysql_query($sql) or die(mysql_error());
                                                                }
                                                            }
                                                            if($insertresult) {
                                                                $ClientEmailcontent->newCrossSales($_POST['cso_generated_lead'],$_POST['cso_sales_person'],$date_received,$_POST['comp_name'],$_POST['cso_client_code'],$_POST['cso_method_of_contact']);
                                                            }
                                           }
                                 }
                                 //client update follow
                                    function sql_update()
                                    {
                                              global $_POST;
                                              global $access_file_level;
                                              global $commonUses;
                                              global $ClientEmailcontent;
                                              
                                              $last_contact_date = $commonUses->getDateFormat($_POST["cso_last_contact_date"]);
                                              $Lastmodifiedon=date( 'Y-m-d H:i:s' );
                                              $future_contact_date = $commonUses->getDateFormat($_POST["cso_future_contact_date"]);
                                              $date_received = $commonUses->getDateFormat($_POST["cso_date_received"]);
                                              
                                                 if($_POST['cso_client_code']!="")
                                                 {
                                                    $cso_Company=$_POST['cso_client_code'];
                                                 }
                                                 else if($_POST['cso_Company_old']!="" && $_POST['cso_client_code']=="")
                                                 {
                                                    $cso_Company=$_POST['cso_Company_old'];
                                                 }
                                                 else
                                                 {
                                                    $cso_Company="";
                                                 }
                                              
                                                        $sql = "UPDATE `cso_cross_sales_opportunity` SET `cso_client_code`='" .mysql_real_escape_string($cso_Company)."', `cso_contact_code`='" .mysql_real_escape_string(@$_POST["cso_contact_code"])."', `cso_entity`='" .mysql_real_escape_string(@$_POST["cso_entity"])."', `cso_date_received`='" .mysql_real_escape_string($date_received)."', `cso_day_received`='" .mysql_real_escape_string(@$_POST["cso_day_received"])."', `cso_lead_status`='" .mysql_real_escape_string(@$_POST["cso_lead_status"])."', `cso_source`='" .mysql_real_escape_string(@$_POST["cso_source"])."', `cso_stage`='" .mysql_real_escape_string(@$_POST["cso_stage"])."', `cso_generated_lead`='" .mysql_real_escape_string(@$_POST["cso_generated_lead"])."', `cso_method_of_contact`='" .mysql_real_escape_string(@$_POST["cso_method_of_contact"])."', `cso_sales_person`='" .mysql_real_escape_string(@$_POST["cso_sales_person"])."', `cso_last_contact_date`='" .mysql_real_escape_string($last_contact_date)."', `cso_future_contact_date`='".mysql_real_escape_string($future_contact_date)."', `cso_notes`='" .mysql_real_escape_string(@$_POST["cso_notes"])."', `cso_modified_by`='" .mysql_real_escape_string($_SESSION[staffcode])."', `cso_modified_date`='" .mysql_real_escape_string($Lastmodifiedon)."' where id=".$_POST['xcli_Code'];
                                                        mysql_query($sql) or die(mysql_error());
                                                        //Update service required code in details table
                                                         $selectedservice=$_POST['cso_service_required'];

                                                        if(count($selectedservice)>0)
                                                        {
                                                            $implodeservice=implode(",",$selectedservice);
                                                            mysql_query("Delete from `cli_allservicerequired` where cli_ClientCode=".$cso_Company." AND cli_Form='Sales Opportunity'");
                                                            foreach($selectedservice as $v)
                                                            {
                                                                $sql1="insert into `cli_allservicerequired` (`cli_ClientCode`, `cli_ServiceRequiredCode`, `cli_Form`) values (".$commonUses->sqlvalue($cso_Company, false).", ".$commonUses->sqlvalue($v, false).",'Sales Opportunity')";
                                                                $selectResult=mysql_query($sql1) or die(mysql_error());
                                                            }
                                                        }
                                                        if(($_POST['cso_lead_status']=='3' && $_POST['cso_lead_status']!=$_POST['cso_lead_status_old']) || ($_POST['cso_lead_status']=='7' && $_POST['cso_lead_status']!=$_POST['cso_lead_status_old'])) {
                                                            $ClientEmailcontent->crossSalesStatus($_POST['cso_generated_lead'],$_POST['cso_sales_person'],$date_received,$_POST['comp_name'],$cso_Company,$_POST['cso_lead_status']);
                                                        }
                                    }
                                        function sql_delete($id)
                                        {
                                                   $sql = "delete from `cso_cross_sales_opportunity` where id='".$id."'";
                                                   if(!mysql_query($sql))
                                                   echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
                                         }
                                            // multi service select
                                            function multiServiceSelect($svr_Code,$cli_code)
                                            {
                                                    global $typeLead;
                                                    global $typeClient;
                                                    global $typeCsigned;
                                                    global $typeDisCon;

                                                    if(isset($cli_code) && $cli_code!="")
                                                    {
                                                        $query2="SELECT * from  `cli_allservicerequired` where cli_ServiceRequiredCode=".$svr_Code." AND cli_ClientCode=".$cli_code." AND cli_Form='Sales Opportunity'";
                                                        $result2=mysql_query($query2);
                                                        if(@mysql_num_rows($result2)>0)
                                                        {
                                                            $selected="selected";
                                                        }
                                                    }
                                                    return $selected;
                                            }
                                            // inline save in grid
                                            function inlineSave()
                                            {
                                               global $commonUses;
                                                //Row update
                                                   $DateReceived=$_POST['cso_date_received'];
                                                   $cliStatus = $_POST['cso_lead_status'];
                                                   $cliStage = $_POST['cso_stage'];
                                                   $cliNotes = $_POST['cso_notes'];
                                                   $LastDate = $_POST['cso_last_contact_date'];
                                                   $rowid = $_GET['row_id'];
                                                   $FutureDate = $_POST['cso_future_contact_date'];
                                                   $current_date_received = $commonUses->getDateFormat($DateReceived[$rowid]);
                                                   $current_status = $cliStatus[$rowid];
                                                   $current_stage = $cliStage[$rowid];
                                                   $current_notes = $cliNotes[$rowid];
                                                   $current_last_date = $commonUses->getDateFormat($LastDate[$rowid]);
                                                   $current_future_date = $commonUses->getDateFormat($FutureDate[$rowid]);
                                                   $sql_update_notes =mysql_query("update `cso_cross_sales_opportunity` set `cso_date_received`='".$current_date_received."', `cso_lead_status`='".$current_status."', `cso_stage`='".$current_stage."', `cso_notes`='".$current_notes."', `cso_last_contact_date`='".$current_last_date."', `cso_future_contact_date`='".$current_future_date."' where id=".$rowid);
                                            }
}

	$CrossDbcontent = new CrossSalesDetails();
?>

