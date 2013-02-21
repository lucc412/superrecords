<?php
include '../common/class.Database.php';
class perminfoDbquery extends Database
{
    // setupsydney update
    function sql_update_setupdetails()
    {
        ob_start();
        global $_POST;
       //Update Lastmodified by and last modified date
               $set_Lastmodifiedon=date( 'Y-m-d H:i:s' );
               $sql = "update `set_psetup` set  `set_Lastmodifiedby`='" .$_SESSION['user']."', `set_Lastmodifiedon`='" .$set_Lastmodifiedon ."' where set_Code=".$_POST['xset_Code'];
               @mysql_query($sql) or die(mysql_error());
                $TaskVal = $_POST['set_TaskCode'];
                $val = explode(",",$TaskVal);
                $task_value_array = $_POST["set_TaskValue"];
                $task_value_pass = $_POST["set_TaskValue_pass"];
                $info_code_array = $_POST["set_PSCode"];
                $task_desc_array = $_POST["set_Remarks"];
                $task_infodetails_array = $_POST["set_Code"];
                foreach($val as $tid)
                {
                    $current_task_value = $task_value_array[$tid];
                    $current_task_pass = $task_value_pass[$tid];
                    if($current_task_pass!='') $current_task_value = $current_task_value."~".$current_task_pass;
                    $current_info_code = $info_code_array[$tid];
                    $current_task_desc = $task_desc_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];
                   $sql = "update `set_psetupdetails` set `set_PSCode`='" .$current_info_code."', `set_TaskCode`='" .$tid."', `set_TaskValue`='" .str_replace("'","''",stripslashes($current_task_value))."', `set_Remarks`='" .str_replace("'","''",stripslashes($current_task_desc))."', `set_CurrentStatusCredentials`='" .$_POST["set_CurrentStatusCredentials"][$i]."', `set_Completed`='" .$_POST["set_Completed"][$i]."', `set_Notes`='".str_replace("'","''",stripslashes(@$_POST["set_Notes"]))."', `set_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["set_IndiaNotes"]))."' where `set_Code`=".$current_infodetails_code;
                  $updateResult= mysql_query($sql) or die(mysql_error());
                }
                if($updateResult)
                {
                    header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Set up Syd ");
                }
    }
    // perminfo update
        function sql_update_pinfodetails()
        {
             global $_POST;

                   //Update Lastmodified by and last modified date
                   $inf_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `inf_pinfo` set  `inf_Lastmodifiedby`='" .$_SESSION['user']."', `inf_Lastmodifiedon`='" .$inf_Lastmodifiedon ."' where inf_Code=".$_POST['xinf_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['inf_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["inf_TaskValue"];
                    $info_code_array = $_POST["inf_PInfoCode"];
                    $task_desc_array = $_POST["inf_Description"];
                    $task_infodetails_array = $_POST["inf_Code"];
                    foreach($val as $tid)
                      {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `inf_pinfodetails` set `inf_PInfoCode`='" .$current_info_code."', `inf_TaskCode`='" .$tid."', `inf_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `inf_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `inf_Notes`='".str_replace("'","''",stripslashes(@$_POST["inf_Notes"]))."', `inf_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["inf_IndiaNotes"]))."' where inf_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                       }
                       if($updateResult)
                        {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Perm Info ");
                        }
        }
        // current status
        function sql_update_curstatusdetails()
        {
                global $_POST;

            //Update Lastmodified by and last modified date
                   $cst_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `cst_pcurrentstatus` set  `cst_Lastmodifiedby`='" .$_SESSION['user']."', `cst_Lastmodifiedon`='" .$cst_Lastmodifiedon ."' where cst_Code=".$_POST['xcst_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['cst_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["cst_TaskValue"];
                    $other_value = $_POST['other_Value'];
                    $info_code_array = $_POST["cst_PCSCode"];
                    $task_desc_array = $_POST["cst_Description"];
                    $task_infodetails_array = $_POST["cst_Code"];
                    foreach($val as $tid)
                    {
                      $current_task_value = $task_value_array[$tid];
                      $current_info_code = $info_code_array[$tid];
                      $current_task_desc = $task_desc_array[$tid];
                      $current_infodetails_code = $task_infodetails_array[$tid];
                      if($tid == 135)
                      {
                          $current_task_value = $current_task_value."~".$other_value[$tid];
                      }
                    $sql = "update `cst_pcurrentstatusdetails` set `cst_PCSCode`='" .$current_info_code."', `cst_TaskCode`='" .$tid."', `cst_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `cst_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `cst_Notes`='".str_replace("'","''",stripslashes(@$_POST["cst_Notes"]))."', `cst_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["cst_IndiaNotes"]))."' where cst_Code=" .$current_infodetails_code;
                    $updateResult= mysql_query($sql) or die(mysql_error());
                     }
                       if($updateResult)
                            {
                                header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Current Status ");
                            }
        }
        // backlog jobsheet update
        function sql_update_backlogdetails()
        {
          ob_start();
          global $_POST;
           //Update Lastmodified by and last modified date
                   $blj_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `blj_pbacklog` set  `blj_Lastmodifiedby`='" .$_SESSION['user']."', `blj_Lastmodifiedon`='" .$blj_Lastmodifiedon ."' where blj_Code=".$_POST['xblj_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['blj_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["blj_TaskValue"];
                    $info_code_array = $_POST["blj_PBLCode"];
                    $task_desc_array = $_POST["blj_Description"];
                    $task_infodetails_array = $_POST["blj_Code"];
                    $rel_value = $_POST["rel_Value"];
                    foreach($val as $tid)
                      {
                        $current_task_value = $task_value_array[$tid];
                        echo $rel_value[$tid];
                        if($tid == 375 )
                        {
                          $current_task_value = $task_value_array[$tid]."~".$rel_value[$tid];
                        }

                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                      $sql = "update `blj_pbacklogdetails` set `blj_PBLCode`='" .$current_info_code."', `blj_TaskCode`='" .$tid."', `blj_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `blj_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `blj_Notes`='".str_replace("'","''",stripslashes(@$_POST["blj_Notes"]))."', `blj_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["blj_IndiaNotes"]))."' where blj_Code=" .$current_infodetails_code;
                      $updateResult= mysql_query($sql) or die(mysql_error());
                       }
                       for($i=0;$i<$_POST['count'];$i++)
                      {
                            $sql = "update `bjs_sourcedocumentdetails` set `bjs_PBLCode`='" .$_POST["bjs_PBLCode"][$i]."', `bjs_SourceDocument`='" .str_replace("'","''",stripslashes(@$_POST["bjs_SourceDocument"][$i]))."', `bjs_MethodofDelivery`='" .str_replace("'","''",stripslashes(@$_POST["bjs_MethodofDelivery"][$i]))."'  where bjs_Code=" .$_POST['bjs_Code'][$i];
                            $sourceResult= mysql_query($sql) or die(mysql_error());
                       }
                       if($updateResult)
                            {
                                    header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Backlog ");
                            }
        }
        // general info update
        function sql_update_geninfodetails()
        {
            ob_start();
            global $_POST;
          //Update Lastmodified by and last modified date
                    $gif_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                    $sql = "update `gif_pgeneralinfo` set  `gif_Lastmodifiedby`='" .$_SESSION['user']."', `gif_Lastmodifiedon`='" .$gif_Lastmodifiedon ."' where gif_Code=".$_POST['xgif_Code'];
                    @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['gif_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["gif_TaskValue"];
                    $info_code_array = $_POST["gif_PGICode"];
                    $task_desc_array = $_POST["gif_Description"];
                    $task_infodetails_array = $_POST["gif_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                      $sql = "update `gif_pgeneralinfodetails` set `gif_PGICode`='" .$current_info_code."', `gif_TaskCode`='" .$tid."', `gif_TaskValue`='" .str_replace("'","''",stripslashes($current_task_value))."', `gif_Description`='" .str_replace("'","''",stripslashes($current_task_desc))."', `gif_Notes`='".str_replace("'","''",stripslashes(@$_POST["gif_Notes"]))."', `gif_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["gif_IndiaNotes"]))."' where gif_Code=" .$current_infodetails_code;
                      $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                   if($updateResult)
                   {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=General Info ");
                   }
        }
        // bank update
        function sql_update_bankdetails()
        {
            ob_start();
            global $_POST;
          //Update Lastmodified by and last modified date
                   $ban_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `ban_pbank` set  `ban_Lastmodifiedby`='" .$_SESSION['user']."', `ban_Lastmodifiedon`='" .$ban_Lastmodifiedon ."' where ban_Code=".$_POST['xban_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['ban_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["ban_TaskValue"];
                    $info_code_array = $_POST["ban_PBCode"];
                    $task_desc_array = $_POST["ban_Description"];
                    $task_infodetails_array = $_POST["ban_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `ban_pbankdetails` set `ban_PBCode`='" .$current_info_code."', `ban_TaskCode`='" .$tid."', `ban_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `ban_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `ban_Notes`='".str_replace("'","''",stripslashes(@$_POST["ban_Notes"]))."', `ban_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["ban_IndiaNotes"]))."' where ban_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                    }
                    if($updateResult)
                    {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Bank ");
                    }
        }
        // AR update
        function sql_update_ardetails()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $are_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `are_paccountsreceivable` set  `are_Lastmodifiedby`='" .$_SESSION['user']."', `are_Lastmodifiedon`='" .$are_Lastmodifiedon ."' where are_Code=".$_POST['xare_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['are_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["are_TaskValue"];
                    $info_code_array = $_POST["are_PARCode"];
                    $task_desc_array = $_POST["are_Description"];
                    $task_infodetails_array = $_POST["are_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `are_paccountsreceivable details` set `are_PARCode`='" .$current_info_code."', `are_TaskCode`='" .$tid."', `are_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `are_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `are_Notes`='".str_replace("'","''",stripslashes(@$_POST["are_Notes"]))."', `are_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["are_IndiaNotes"]))."' where are_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                   if($updateResult)
                        {
                        header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Investments ");
                        }
        }
        // AP update
        function sql_update_apdetails()
        {
                global $_POST;
                   $ape_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `ape_paccountspayable` set  `ape_Lastmodifiedby`='" .$_SESSION['user']."', `ape_Lastmodifiedon`='" .$ape_Lastmodifiedon ."' where ape_Code=".$_POST['xape_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['ape_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["ape_TaskValue"];
                    $info_code_array = $_POST["ape_PARCode"];
                    $task_desc_array = $_POST["ape_Description"];
                    $task_infodetails_array = $_POST["ape_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                       $sql = "update `ape_paccountspayabledetails` set `ape_PARCode`='" .$current_info_code."', `ape_TaskCode`='" .$tid."', `ape_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `ape_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `ape_Notes`='".str_replace("'","''",stripslashes(@$_POST["ape_Notes"]))."', `ape_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["ape_IndiaNotes"]))."' where ape_Code=" .$current_infodetails_code;
                       $updateResult= mysql_query($sql) or die(mysql_error());
                       }
                        if($updateResult)
                        {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=AP ");
                        }
        }
        // Payroll update
        function sql_update_payrolldetails()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $pay_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `pay_ppayroll` set  `pay_Lastmodifiedby`='" .$_SESSION['user']."', `pay_Lastmodifiedon`='" .$pay_Lastmodifiedon ."' where pay_Code=".$_POST['xpay_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['pay_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["pay_TaskValue"];
                    $info_code_array = $_POST["pay_PPRCode"];
                    $task_desc_array = $_POST["pay_Description"];
                    $task_infodetails_array = $_POST["pay_Code"];
                   $todate_value = $_POST["todate_Value"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        if($tid == 293 ) //($_POST["todate_Value"]!="")
                        {
                          $current_task_value = $task_value_array[$tid]."~".$todate_value[$tid];
                        }
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `pay_ppayrolldetails` set `pay_PPRCode`='" .$current_info_code."', `pay_TaskCode`='" .$tid."', `pay_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `pay_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `pay_Notes`='".str_replace("'","''",stripslashes(@$_POST["pay_Notes"]))."', `pay_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["pay_IndiaNotes"]))."' where pay_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                       }
                       if($updateResult)
                       {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Payroll ");
                       }
        }
        // BAS Update
        function sql_update_basdetails()
        {
           global $_POST;
            //Update Lastmodified by and last modified date
                   $emh_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `bas_bankaccount` set  `bas_Lastmodifiedby`='" .$_SESSION['user']."', `bas_Lastmodifiedon`='" .$emh_Lastmodifiedon ."' where bas_Code=".$_POST['xbas_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['bas_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["bas_TaskValue"];
                    $info_code_array = $_POST["bas_BASCode"];
                    $task_desc_array = $_POST["bas_Description"];
                    $task_infodetails_array = $_POST["bas_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `bas_bankaccountdetails` set `bas_BASCode`='" .$current_info_code."', `bas_TaskCode`='" .$tid."', `bas_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `bas_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `bas_Notes`='".str_replace("'","''",stripslashes(@$_POST["bas_Notes"]))."', `bas_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["bas_IndiaNotes"]))."' where bas_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                   if($updateResult)
                   {
                         header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=BAS ");
                   }
        }
        // Tax Return  update
        function sql_update_taxreturnsdetails()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $tar_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `tar_ptaxreturns` set  `tar_Lastmodifiedby`='" .$_SESSION['user']."', `tar_Lastmodifiedon`='" .$tar_Lastmodifiedon ."' where tar_Code=".$_POST['xtar_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['tar_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["tar_TaskValue"];
                    $info_code_array = $_POST["tar_PTRCode"];
                    $task_desc_array = $_POST["tar_Description"];
                    $task_infodetails_array = $_POST["tar_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                      $sql = "update `tar_ptaxreturnsdetails` set `tar_PTRCode`='" .$current_info_code."', `tar_TaskCode`='" .$tid."', `tar_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `tar_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `tar_Notes`='".str_replace("'","''",stripslashes(@$_POST["tar_Notes"]))."', `tar_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["tar_IndiaNotes"]))."' where tar_Code=" .$current_infodetails_code;
                      $updateResult= mysql_query($sql) or die(mysql_error());
                    }
                    if($updateResult)
                    {
                          header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Tax Returns ");
                    }
        }
        // Special Tasks update
        function sql_update_sptdetails()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $emh_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `spt_specialtasks` set  `spt_Lastmodifiedby`='" .$_SESSION['user']."', `spt_Lastmodifiedon`='" .$emh_Lastmodifiedon ."' where spt_Code=".$_POST['xspt_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['spt_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["spt_TaskValue"];
                    $info_code_array = $_POST["spt_SPLCode"];
                    $task_desc_array = $_POST["spt_Description"];
                    $task_infodetails_array = $_POST["spt_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `spt_specialtasksdetails` set `spt_SPLCode`='" .$current_info_code."', `spt_TaskCode`='" .$tid."', `spt_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `spt_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `spt_Notes`='".str_replace("'","''",stripslashes(@$_POST["spt_Notes"]))."', `spt_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["spt_IndiaNotes"]))."' where spt_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                   if($updateResult)
                   {
                        header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Special Tasks ");
                   }
        }
        // Due Date update
        function sql_update_ddrdetails()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $emh_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `ddr_duedatereports` set  `ddr_Lastmodifiedby`='" .$_SESSION['user']."', `ddr_Lastmodifiedon`='" .$emh_Lastmodifiedon ."' where ddr_Code=".$_POST['xddr_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['ddr_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $task_value_array = $_POST["ddr_TaskValue"];
                    $info_code_array = $_POST["ddr_DDCode"];
                    $task_desc_array = $_POST["ddr_Description"];
                    $task_due_array = $_POST["ddr_DuedaySend"];
                    $task_work_array = $_POST["ddr_WorkDone"];
                    $task_infodetails_array = $_POST["ddr_Code"];
                    foreach($val as $tid)
                    {
                        $current_task_value = $task_value_array[$tid];
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $current_due_desc = $task_due_array[$tid];
                        $current_work_desc = $task_work_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $sql = "update `ddr_duedatereportsdetails` set `ddr_DDCode`='" .$current_info_code."', `ddr_TaskCode`='" .$tid."', `ddr_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `ddr_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `ddr_DuedaySend`='" .str_replace("'","''",stripslashes(@$current_due_desc))."', `ddr_WorkDone`='" .str_replace("'","''",stripslashes(@$current_work_desc))."', `ddr_Notes`='".str_replace("'","''",stripslashes(@$_POST["ddr_Notes"]))."', `ddr_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["ddr_IndiaNotes"]))."' where ddr_Code=" .$current_infodetails_code;
                        $updateResult= mysql_query($sql) or die(mysql_error());
                    }
                    if($updateResult)
                    {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Due Dates & Reports ");
                    }
        }
        // Task list update
        function sql_update_tasklist()
        {
                global $_POST;
                //Update Lastmodified by and last modified date
                   $Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $tsk_clicode = $_POST['cli_code'];
                   $tsk_masteractivity = '';
                   $tsk_subactivity = "eight~".$_POST['sub_activity8'].",nine~".$_POST['sub_activity9'].",ten~".$_POST['sub_activity10'].",eleven~".$_POST['sub_activity11'].",twelve~".$_POST['sub_activity12'];
                   $tsk_befree_internal_duedate = "three~".$_POST['internal_duedate3'].",four~".$_POST['internal_duedate4'].",five~".$_POST['internal_duedate5'].",seven~".$_POST['internal_duedate7'].",eight~".$_POST['internal_duedate8'].",nine~".$_POST['internal_duedate9'].",ten~".$_POST['internal_duedate10'].",eleven~".$_POST['internal_duedate11'].",twelve~".$_POST['internal_duedate12'];
                   $tsk_ato_duedate = "one~".$_POST['ato_duedate1'].",two~".$_POST['ato_duedate2'].",three~".$_POST['ato_duedate3'].",four~".$_POST['ato_duedate4'].",five~".$_POST['ato_duedate5'].",seven~".$_POST['ato_duedate7'].",eight~".$_POST['ato_duedate8'].",nine~".$_POST['ato_duedate9'].",ten~".$_POST['ato_duedate10'].",eleven~".$_POST['ato_duedate11'].",twelve~".$_POST['ato_duedate12'];
                   $tsk_oneoff = "one~".$_POST['one_off1'].",two~".$_POST['one_off2'].",three~".$_POST['one_off3'].",four~".$_POST['one_off4'].",five~".$_POST['one_off5'].",seven~".$_POST['one_off7'].",eight~".$_POST['one_off8'].",nine~".$_POST['one_off9'].",ten~".$_POST['one_off10'].",eleven~".$_POST['one_off11'].",twelve~".$_POST['one_off12'];
                   $tsk_monthly = "one~".$_POST['monthly1'].",two~".$_POST['monthly2'].",three~".$_POST['monthly3'].",four~".$_POST['monthly4'].",five~".$_POST['monthly5'].",seven~".$_POST['monthly7'].",eight~".$_POST['monthly8'].",nine~".$_POST['monthly9'].",ten~".$_POST['monthly10'].",eleven~".$_POST['monthly11'].",twelve~".$_POST['monthly12'];
                   $tsk_quarterly = "one~".$_POST['quarterly1'].",two~".$_POST['quarterly2'].",three~".$_POST['quarterly3'].",four~".$_POST['quarterly4'].",five~".$_POST['quarterly5'].",seven~".$_POST['quarterly7'].",eight~".$_POST['quarterly8'].",nine~".$_POST['quarterly9'].",ten~".$_POST['quarterly10'].",eleven~".$_POST['quarterly11'].",twelve~".$_POST['quarterly12'];
                   $tsk_yearly = "two~".$_POST['yearly2'].",three~".$_POST['yearly3'].",four~".$_POST['yearly4'].",five~".$_POST['yearly5'].",seven~".$_POST['yearly7'].",eight~".$_POST['yearly8'].",nine~".$_POST['yearly9'].",ten~".$_POST['yearly10'].",eleven~".$_POST['yearly11'].",twelve~".$_POST['yearly12'];
                   $tsk_must = "two~".$_POST['must2'].",three~".$_POST['must3'].",four~".$_POST['must4'].",five~".$_POST['must5'].",seven~".$_POST['must7'].",eight~".$_POST['must8'].",nine~".$_POST['must9'].",ten~".$_POST['must10'].",eleven~".$_POST['must11'].",twelve~".$_POST['must12'];
                   $tsk_comment = "one~".$_POST['comment1'].",two~".$_POST['comment2'].",three~".$_POST['comment3'].",four~".$_POST['comment4'].",five~".$_POST['comment5'].",seven~".$_POST['comment7'].",eight~".$_POST['comment8'].",nine~".$_POST['comment9'].",ten~".$_POST['comment10'].",eleven~".$_POST['comment11'].",twelve~".$_POST['comment12'];
                   $tsk_notes = $_POST['tsk_notes'];
                   $tsk_indianotes = $_POST['tsk_india_notes'];
                   $query = mysql_query("select cli_code from tsk_perminfotasklist where cli_code=".$tsk_clicode);
                   $update_row = mysql_num_rows($query);
                   if($update_row>0) {
                       $sql = "update tsk_perminfotasklist set master_activity='".mysql_real_escape_string($tsk_masteractivity)."',sub_activity='".mysql_real_escape_string($tsk_subactivity)."',befree_internal_due_date='".mysql_real_escape_string($tsk_befree_internal_duedate)."',ato_due_date='".mysql_real_escape_string($tsk_ato_duedate)."',one_off='".mysql_real_escape_string($tsk_oneoff)."',monthly='".mysql_real_escape_string($tsk_monthly)."',quarterly='".mysql_real_escape_string($tsk_quarterly)."',yearly='".mysql_real_escape_string($tsk_yearly)."',must='".mysql_real_escape_string($tsk_must)."',comment='".mysql_real_escape_string($tsk_comment)."',tsk_notes='".mysql_real_escape_string($tsk_notes)."',tsk_india_notes='".mysql_real_escape_string($tsk_indianotes)."',last_modified_by='".$_SESSION[staffcode]."',last_modified_on='".$Lastmodifiedon."' where cli_code=".$tsk_clicode;
                       $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                   else { $sql = "insert into tsk_perminfotasklist (cli_code,master_activity,sub_activity,befree_internal_due_date,ato_due_date,one_off,monthly,quarterly,yearly,must,comment,tsk_notes,tsk_india_notes,last_modified_by,last_modified_on) values ('".  mysql_real_escape_string($tsk_clicode)."','".  mysql_real_escape_string($tsk_masteractivity)."','".  mysql_real_escape_string($tsk_subactivity)."','".  mysql_real_escape_string($tsk_befree_internal_duedate)."','".  mysql_real_escape_string($tsk_ato_duedate)."','".  mysql_real_escape_string($tsk_oneoff)."','".  mysql_real_escape_string($tsk_monthly)."','".  mysql_real_escape_string($tsk_quarterly)."','".  mysql_real_escape_string($tsk_yearly)."','".  mysql_real_escape_string($tsk_must)."','".  mysql_real_escape_string($tsk_comment)."','".  mysql_real_escape_string($tsk_notes)."','".  mysql_real_escape_string($tsk_india_notes)."','$_SESSION[staffcode]','$Lastmodifiedon')";
                        $updateResult= mysql_query($sql) or die(mysql_error());
                   }
                    if($updateResult)
                    {
                            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=3&file=Task List ");
                    }
        }

}
$perminfoQuery = new perminfoDbquery();

            // setupsydney
              $setupsyd = $_POST['setupsyd'];
              if($setupsyd=="Update")
              {
                  $perminfoQuery->sql_update_setupdetails();
              }
            // perminfo
              $perminfo = $_POST['perminfo'];
              if($perminfo=="Update")
              {
                  $perminfoQuery->sql_update_pinfodetails();
              }
            // current status
              $curstatus = $_POST['curstatus'];
              if($curstatus=="Update")
              {
                  $perminfoQuery->sql_update_curstatusdetails();
              }
            // backlog jobsheet
              $bckjob = $_POST['bckjob'];
              if($bckjob=="Update")
              {
                  $perminfoQuery->sql_update_backlogdetails();
              }
            // general info
              $generalinfo = $_POST['generalinfo'];
              if($generalinfo=="Update")
              {
                  $perminfoQuery->sql_update_geninfodetails();
              }
            // bank
              $bankupdate = $_POST['bankupdate'];
              if($bankupdate=="Update")
              {
                  $perminfoQuery->sql_update_bankdetails();
              }
            // AR
              $ARupdate = $_POST['ARupdate'];
              if($ARupdate=="Update")
              {
                  $perminfoQuery->sql_update_ardetails();
              }
            // AP
              $APupdate = $_POST['APupdate'];
              if($APupdate=="Update")
              {
                  $perminfoQuery->sql_update_apdetails();
              }
            // Payroll
              $payroll = $_POST['payroll'];
              if($payroll=="Update")
              {
                  $perminfoQuery->sql_update_payrolldetails();
              }
            // BAS
              $BAS = $_POST['BAS'];
              if($BAS=="Update")
              {
                  $perminfoQuery->sql_update_basdetails();
              }
            // Tax Return
              $tax = $_POST['tax'];
              if($tax=="Update")
              {
                  $perminfoQuery->sql_update_taxreturnsdetails();
              }
            // Special Tasks
              $specialTasks = $_POST['specialTasks'];
              if($specialTasks=="Update")
              {
                  $perminfoQuery->sql_update_sptdetails();
              }
            // Due Date & Reports
              $dueDate = $_POST['dueDate'];
              if($dueDate=="Update")
              {
                  $perminfoQuery->sql_update_ddrdetails();
              }
            // Task list
              $tasklist = $_POST['tasklist'];
              if($tasklist=="Update")
              {
                  $perminfoQuery->sql_update_tasklist();
              }

?>