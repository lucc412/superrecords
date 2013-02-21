<?php
include '../common/class.Database.php';
class taxaccountDbquery extends Database
{
        function sql_update_taxdetails()
        {
            global $_POST;
            //Update Lastmodified by and last modified date
                   $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );
                   $sql = "update `tax_taxaccounting` set  `tax_Lastmodifiedby`='" .$_SESSION['user']."', `tax_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where tax_Code=".$_POST['xtax_Code'];
                   @mysql_query($sql) or die(mysql_error());
                    $TaskVal = $_POST['tax_TaskCode'];
                    $val = explode(",",$TaskVal);
                    $info_code_array = $_POST["tax_TAXCode"];
                    $task_infodetails_array = $_POST["tax_Code"];
                    $taskVal_array = $_POST["tax_TaskValue"];
                    foreach($val as $tid)
                    {
                        $current_info_code = $info_code_array[$tid];
                        $current_taskVal = $taskVal_array[$tid];
                        $current_infodetails_code = $task_infodetails_array[$tid];
                       // $rateVal = substr($current_task_desc,1);
                        $sql = "update `tax_taxaccountingdetails` set `tax_TAXCode`='" .$current_info_code."', `tax_TaskCode`='" .$tid."', `tax_TaskValue`='" .str_replace("'","''",stripslashes(@$current_taskVal))."', `tax_Notes`='".str_replace("'","''",stripslashes(@$_POST["tax_Notes"]))."', `tax_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["tax_IndiaNotes"]))."' where tax_Code=" .$current_infodetails_code;
                        $updateResult= @mysql_query($sql) or die(mysql_error());
                    } 
                    if($updateResult)
                    {
                        header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Tax and Accounting ");
                    }
         }

}
$taxaccountQuery = new taxaccountDbquery();

            // sales notes details query option
              $taxaccount = $_POST['taxaccount'];
              if($taxaccount=="Update")
              {
                  $taxaccountQuery->sql_update_taxdetails();
              }
?>