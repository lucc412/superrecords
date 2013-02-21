<?php
include '../common/class.Database.php';
class salesnotesDbquery extends Database
{
    // sales notes details update
    function sql_update_snddetails()
    {
       global $_POST;
        //Update Lastmodified by and last modified date
               $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );
               $sql = "update `snd_salesdetails` set  `snd_Lastmodifiedby`='" .$_SESSION['user']."', `snd_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where snd_Code=".$_POST['xsnd_Code'];
               @mysql_query($sql) or die(mysql_error());
                $TaskVal = $_POST['snd_TaskCode'];
                $val = explode(",",$TaskVal);
                $info_code_array = $_POST["snd_SNCode"];
                $task_infodetails_array = $_POST["snd_Code"];
                $taskVal_array = $_POST["snd_TaskValue"];
                foreach($val as $tid)
                {
                    $current_info_code = $info_code_array[$tid];
                    $current_taskVal = $taskVal_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];
                    $sql = "update `snd_salesdetails_details` set `snd_SNCode`='" .$current_info_code."', `snd_TaskCode`='" .$tid."', `snd_TaskValue`='" .str_replace("'","''",stripslashes(@$current_taskVal))."', `snd_Notes`='".str_replace("'","''",stripslashes(@$_POST["snd_Notes"]))."', `snd_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["snd_IndiaNotes"]))."' where snd_Code=" .$current_infodetails_code;
                    $updateResult= @mysql_query($sql) or die(mysql_error());
                }
                if($updateResult)
                {
                    header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Details ");
                }
    }
    // sales notes Status update
    function sql_update_snstatus()
    {
        global $_POST;

        //Update Lastmodified by and last modified date
               $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );
               $sql = "update `sns_salesstatus` set  `sns_Lastmodifiedby`='" .$_SESSION['user']."', `sns_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where sns_Code=".$_POST['xsns_Code'];
               @mysql_query($sql) or die(mysql_error());
                $TaskVal = $_POST['sns_TaskCode'];
                $val = explode(",",$TaskVal);
                $info_code_array = $_POST["sns_SNCode"];
                $task_infodetails_array = $_POST["sns_Code"];
                $taskVal_array = $_POST["sns_TaskValue"];
                foreach($val as $tid)
                {
                    $current_info_code = $info_code_array[$tid];
                    $current_taskVal = $taskVal_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];
                 $sql = "update `sns_salesstatusdetails` set `sns_SNCode`='" .$current_info_code."', `sns_TaskCode`='" .$tid."', `sns_TaskValue`='" .str_replace("'","''",stripslashes(@$current_taskVal))."', `sns_Notes`='".str_replace("'","''",stripslashes(@$_POST["sns_Notes"]))."', `sns_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["sns_IndiaNotes"]))."' where sns_Code=" .$current_infodetails_code;
                 $updateResult= @mysql_query($sql) or die(mysql_error());
            }
            if($updateResult)
            {
                header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Status ");
            }
    }
    // sales notes Tasks update
    function sql_update_sntasks()
    {
        global $_POST;
        //Update Lastmodified by and last modified date
               $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );

               $sql = "update `snt_salestasks` set  `snt_Lastmodifiedby`='" .$_SESSION['user']."', `snt_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where snt_Code=".$_POST['xsnt_Code'];
               @mysql_query($sql) or die(mysql_error());

                $TaskVal = $_POST['snt_TaskCode'];
                $val = explode(",",$TaskVal);
                $info_code_array = $_POST["snt_SNCode"];
                $task_infodetails_array = $_POST["snt_Code"];
                $taskVal_array = $_POST["snt_TaskValue"];
                foreach($val as $tid)
                {
                    $current_info_code = $info_code_array[$tid];
                    $current_taskVal = $taskVal_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];

                 $sql = "update `snt_salestasksdetails` set `snt_SNCode`='" .$current_info_code."', `snt_TaskCode`='" .$tid."', `snt_TaskValue`='" .str_replace("'","''",stripslashes(@$current_taskVal))."', `snt_Notes`='".str_replace("'","''",stripslashes(@$_POST["snt_Notes"]))."', `snt_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["snt_IndiaNotes"]))."' where snt_Code=" .$current_infodetails_code;

                  $updateResult= @mysql_query($sql) or die(mysql_error());
            }
       if($updateResult)
            {
            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Tasks ");
            }
    }
    // sales notes Notes update
    function sql_update_snNotes()
    {
        global $_POST;

        //Update Lastmodified by and last modified date
               $inv_Lastmodifiedon=date( 'Y-m-d H:i:s' );

               $sql = "update `snn_salesnotes` set  `snn_Lastmodifiedby`='" .$_SESSION['user']."', `snn_Lastmodifiedon`='" .$inv_Lastmodifiedon ."' where snn_Code=".$_POST['xsnn_Code'];
               @mysql_query($sql) or die(mysql_error());

                $TaskVal = $_POST['snn_TaskCode'];
                $val = explode(",",$TaskVal);
                $info_code_array = $_POST["snn_SNCode"];
                $task_infodetails_array = $_POST["snn_Code"];
                $taskVal_array = $_POST["snn_TaskValue"];
                foreach($val as $tid)
                {
                    $current_info_code = $info_code_array[$tid];
                    $current_taskVal = $taskVal_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];

                 $sql = "update `snn_salesnotesdetails` set `snn_SNCode`='" .$current_info_code."', `snn_TaskCode`='" .$tid."', `snn_TaskValue`='" .str_replace("'","''",stripslashes(@$current_taskVal))."', `snn_Notes`='".str_replace("'","''",stripslashes(@$_POST["snn_Notes"]))."', `snn_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["snn_IndiaNotes"]))."' where snn_Code=" .$current_infodetails_code;

                  $updateResult= @mysql_query($sql) or die(mysql_error());
            }
       if($updateResult)
            {
            header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Records Updated&page=2&file=Notes ");
            }
    }

}
$salesnotesQuery = new salesnotesDbquery();

            // sales notes details query option
              $sndetails = $_POST['sndetails'];
              if($sndetails=="Update")
              {
                  $salesnotesQuery->sql_update_snddetails();
              }
              // sales notes status query option
              $snstatus = $_POST['snstatus'];
              if($snstatus=="Update")
              {
                  $salesnotesQuery->sql_update_snstatus();
              }
              // sales notes Tasks query option
              $sntasks = $_POST['sntasks'];
              if($sntasks=="Update")
              {
                  $salesnotesQuery->sql_update_sntasks();
              }
              // sales notes Notes query option
              $snnotes = $_POST['snnotes'];
              if($snnotes=="Update")
              {
                  $salesnotesQuery->sql_update_snNotes();
              }

?>