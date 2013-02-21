<?php
include '../common/class.Database.php';
class quotesheetDbquery extends Database
{

    // card file insert
        function sql_insert_qcard()
        {
          global $_POST;
          global $commonUses;
           $crd_Createdon=date( 'Y-m-d H:i:s' );
           $sql = "insert into `crd_qcardfile` (`crd_ClientCode`, `crd_LegalName`, `crd_BillingName`, `crd_TradingName`, `crd_EntityType`, `crd_ABN`, `crd_HasRelatedEntities`, `crd_PrimaryContact`, `crd_Createdby`, `crd_Createdon`) values ('"  .@$_POST["crd_ClientCode"]."',  '" .str_replace("'","''",stripslashes(@$_POST["crd_LegalName"])) ."',  '" .str_replace("'","''",stripslashes(@$_POST["crd_BillingName"])) ."',  '" .str_replace("'","''",stripslashes(@$_POST["crd_TradingName"])) ."', '" .@$_POST["crd_EntityType"]."', '" .@$_POST["crd_ABN"]."', '" .@$_POST["crd_HasRelatedEntities"]."', '" .@$_POST["crd_PrimaryContact"]."', '" .$_SESSION['user']."', '" .$crd_Createdon."')";
           $insertResult=mysql_query($sql) or die(mysql_error());
          //Insert this qcardfile code in details table
           $result = (mysql_query ('SELECT LAST_INSERT_ID() FROM crd_qcardfile'));
           $row=mysql_fetch_row($result);
           $cde_CardFileCode = $row[0];
           $selectedclients=$_POST['allclients'];
           if($selectedclients!="")
           {
               $selectedclients=$_POST['allclients'];
               foreach($selectedclients as $v)
               {
                   $sql = "insert into `cde_qcardfiledetails` (`cde_CardFileCode`, `cde_ClientCode`) values ("  . $cde_CardFileCode.", " .$v.")";
                  $insertResult=mysql_query($sql) or die(mysql_error());
                }
           }
           if($insertResult)
                {
                    header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["crd_ClientCode"]."&msg=Records Inserted&page=2&file=Card File ");
                }
        }
        // card file update
        function sql_update_qcard()
        {
                global $_POST;
                global $commonUses;
                $crd_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                $sql = "update `crd_qcardfile` set `crd_ClientCode`='" .@$_POST["crd_ClientCode"]."', `crd_LegalName`='" .str_replace("'","''",stripslashes(@$_POST["crd_LegalName"]))."', `crd_BillingName`='" .str_replace("'","''",stripslashes(@$_POST["crd_BillingName"]))."', `crd_TradingName`='" .str_replace("'","''",stripslashes(@$_POST["crd_TradingName"]))."', `crd_EntityType`='" .@$_POST["crd_EntityType"]."', `crd_ABN`='" .@$_POST["crd_ABN"]."', `crd_HasRelatedEntities`='" .@$_POST["crd_HasRelatedEntities"]."', `crd_PrimaryContact`='" .@$_POST["crd_PrimaryContact"]."', `crd_Lastmodifiedby`='" .$_SESSION['user']."', `crd_Lastmodifiedon`='" .$crd_Lastmodifiedon ."' where " .$this->primarykeycondition_qcard();
                $updateResult=mysql_query($sql) or die(mysql_error());
                if ( $_POST["crd_EntityType"]==0)
                {
                    mysql_query("Delete from `cde_qcardfiledetails` where cde_CardFileCode=".$_POST["xcrd_Code"]);
                }
                $selectedclients=$_POST['allclients'];
                if($selectedclients!="")
                {
                      $implodeclients=implode(",",$selectedclients);
                       foreach($selectedclients as $v)
                       {

                            $sql = "select * from `cde_qcardfiledetails` where cde_CardFileCode=". $_POST['cde_CardFileCode']. " and cde_ClientCode =".$v;
                              $insertResult=mysql_query($sql);
                              if(mysql_num_rows($insertResult)==0)
                              {
                             $sql1="insert into `cde_qcardfiledetails` (`cde_CardFileCode`, `cde_ClientCode`) values ("  . $_POST['cde_CardFileCode'].", " .$v.")";
                             $selectResult=mysql_query($sql1) or die(mysql_error());
                          }
                      }
                          $sql = "select * from `cde_qcardfiledetails` where cde_ClientCode IN (".$implodeclients.")";
                          $updateResult=mysql_query($sql);
                    if(mysql_num_rows($updateResult)>0)
                    {
                       mysql_query("Delete from `cde_qcardfiledetails` where cde_ClientCode NOT IN (".$implodeclients.")");
                    }
                }
                if($updateResult)
                {
                     header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["crd_ClientCode"]."&msg=Records Updated&page=2&file=Card File ");
                }
        }
        // record id condition
        function primarykeycondition_qcard()
        {
          global $_POST;
          global $commonUses;
          $pk = "";
          $pk .= "(`crd_Code`";
          if (@$_POST["xcrd_Code"] == "") {
            $pk .= " IS NULL";
          }else{
          $pk .= " = " .@$_POST["xcrd_Code"];
          };
          $pk .= ")";
          return $pk;
        }
        // invoice update
        function sql_update_invdetails()
        {
           global $_POST;
                  //Update Lastmodified by and last modified date
                   $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `inv_qinvoice` set  `inv_Lastmodifiedby`='" .$_SESSION['user']."', `inv_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where inv_Code=".$_POST['xinv_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['inv_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $info_code_array = $_POST["inv_QICode"];
                    $task_desc_array = $_POST["inv_Rates"];
                    $task_infodetails_array = $_POST["inv_Code"];
                    $taskVal_array = $_POST["inv_TaskValue"];
                    foreach($val as $tid)
                    {
                        $current_info_code = $info_code_array[$tid];
                        $current_task_desc = $task_desc_array[$tid];
                        $rval = substr($current_task_desc,0,1);
                        if($rval=="$") $current_task_desc = $current_task_desc; else $current_task_desc = "$".$current_task_desc;
                        $current_taskVal = $taskVal_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                        $rateVal = substr($current_task_desc,1);
                        $sql = "update `inv_qinvoicedetails` set `inv_QICode`='" .@$current_info_code."', `inv_TaskCode`='" .@$tid."', `inv_Quantity`='" .@$_POST["inv_Quantity"]."', `inv_Rates`='" .$rateVal."', `inv_Amount`='" .@$_POST["inv_Amount"]."', `inv_Remarks`='".str_replace("'","''",stripslashes(@$_POST["inv_Remarks"]))."', `inv_Notes`='".str_replace("'","''",stripslashes(@$_POST["inv_Notes"]))."', `inv_TaskValue`='".@$current_taskVal."', `inv_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["inv_IndiaNotes"]))."' where inv_Code=" .$current_infodetails_code;
                        $updateResult= @mysql_query($sql) or die(mysql_error());
                    }
                    if($updateResult)
                    {
                        header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Invoice ");
                    }
         }

}
$quotesheetQuery = new quotesheetDbquery();

            // card file query option
            $sql_qcard = @$_POST["sql_qcard"];
              switch ($sql_qcard)
              {
                    case "insert_qcard":
                        $quotesheetQuery->sql_insert_qcard();
                      break;
                    case "update_qcard":
                        $quotesheetQuery->sql_update_qcard();
                      break;
              }
              // invoice query option
              $qinv = $_POST['qinvoice'];
              if($qinv=="Update")
              {
                  $quotesheetQuery->sql_update_invdetails();
              }
?>