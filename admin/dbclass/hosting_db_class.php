<?php
include '../common/class.Database.php';
class hostingDbquery extends Database
{
    function sql_update_mhgdetails()
    {
       global $_POST;
        //Update Lastmodified by and last modified date
               $mhg_Lastmodifiedon=date( 'Y-m-d H:i:s' );
               $sql = "update `mhg_qmyobhosting` set  `mhg_Lastmodifiedby`='" .$_SESSION['user']."', `mhg_Lastmodifiedon`='" .$mhg_Lastmodifiedon ."' where mhg_Code=".$_POST['xmhg_Code'];
               @mysql_query($sql) or die(mysql_error());
                $TaskVal = $_POST['mhg_TaskCode'];
                $val = explode(",",$TaskVal);
                $task_value_array = $_POST["mhg_TaskValue"];
                $info_code_array = $_POST["mhg_MYOBHCode"];
                $task_desc_array = $_POST["mhg_Description"];
                $task_infodetails_array = $_POST["mhg_Code"];
                foreach($val as $tid)
                {
                    $current_task_value = $task_value_array[$tid];
                    $current_info_code = $info_code_array[$tid];
                    $current_task_desc = $task_desc_array[$tid];
                    $current_infodetails_code = $task_infodetails_array[$tid];
                    $sql = "update `mhg_qmyobhostingdetails` set `mhg_MYOBHCode`='" .$current_info_code."', `mhg_TaskCode`='" .$tid."', `mhg_TaskValue`='" .str_replace("'","''",stripslashes(@$current_task_value))."', `mhg_Description`='" .str_replace("'","''",stripslashes(@$current_task_desc))."', `mhg_Notes`='".str_replace("'","''",stripslashes(@$_POST["mhg_Notes"]))."', `mhg_IndiaNotes`='".str_replace("'","''",stripslashes(@$_POST["mhg_IndiaNotes"]))."' where mhg_Code=" .$current_infodetails_code;
                    $updateResult= mysql_query($sql) or die(mysql_error());
                }
                   if($updateResult)
                        {
                        header("Location:../cli_client.php?a=edit&recid=".$_POST['recid']."&cli_code=".$_POST["cli_code"]."&msg=Record Updated&page=2&file=Hosting ");
                        }
    }

}
$hostingQuery = new hostingDbquery();

            // sales notes details query option
              $hostupdate = $_POST['hostupdate'];
              if($hostupdate=="Update")
              {
                  $hostingQuery->sql_update_mhgdetails();
              }
?>