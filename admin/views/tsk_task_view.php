<!--*************************************************************************************************
//  Task          : Page for Listing details of Task
//  Modified By   : Dhiraj Sahu
//  Created on    : 28-Dec-2012
//  Last Modified : 30-Jan-2013
//************************************************************************************************-->

<div class="frmheading">
	<h1>View Task</h1>
</div>

<table class="tbl" border="0" cellspacing="12" width="70%">
	<tr>
		<td class="hr">Task Name</td>
		<td class="dr"><?=stripslashes($arrTaskData["task_name"])?></td>
	</tr>
	
	<tr>
		<td class="hr">Practice Name</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrPractice[$arrTaskData["id"]])?></td>
	</tr>

	<tr>
		<td class="hr">Client Name</td>
		<td class="dr"><?=stripslashes($objCallData->arrClient[$arrTaskData["client_id"]])?></td>
	</tr>

	<tr>
		<td class="hr">Job Name</td>
		<td class="dr"><?
			$JobID = $_REQUEST["jobId"];
			
			if(!$JobID)
				$JobID = $arrTaskData["job_id"];
			
			$ClientID = $objCallData->arrJobDetails[$JobID]["client_id"];
			$PracticeID =  $objCallData->arrClientDetails[$ClientID]["id"];
	
			$arrJobParts = explode('::', $objCallData->arrJob[$JobID]);
			$jobName = '<span class="clientclr">'.$objCallData->arrClient[$ClientID] . '</span> - <span class="periodclr">' . $objCallData->arrJobDetails[$JobID]["period"]. '</span> - <span class="activityclr">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</span>';
			
			echo stripslashes($jobName); 	
	?></td>
	</tr>

	<tr>
		<td class="hr">Master Activity</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrMasterActivity[$arrTaskData["mas_Code"]])?></td>
	</tr>

	<tr>
		<td class="hr">Sub Activity</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSubActivity[$arrTaskData["sub_Code"]])?></td>
	</tr>
	
        <tr>
		<td class="hr">Task Status</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrTaskStatus[$arrTaskData["task_status_id"]])?></td>
	</tr>
	
	<tr>
		<td class="hr">Priority</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrPriority[$arrTaskData["priority_id"]])?></td>
	</tr>
	
	<tr>
		<td class="hr">Process Cycle</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrProcessingCycle[$arrTaskData["process_id"]])?></td>
	</tr>
        
        <tr>
		<td class="hr">External Due Date</td>
		<td class="dr"><?
                        if (isset($arrTaskData["due_date"]) && $arrTaskData["due_date"] != "") {
                            if($arrTaskData["due_date"] != "0000-00-00 00:00:00") {
                                echo $due_date = date("d/m/Y",strtotime( $arrTaskData["due_date"]));
                            }
                        }
                ?></td>
	</tr>
        
        <tr>
		<td class="hr">Superrecords Due Date</td>
		<td class="dr"><?
                        if (isset($arrTaskData["befree_due_date"]) && $arrTaskData["befree_due_date"] != "") {
                            if($arrTaskData["befree_due_date"] != "0000-00-00 00:00:00") {
                                echo $befree_due_date = date("d/m/Y",strtotime( $arrTaskData["befree_due_date"]));
                            }
                        }  
                ?></td>
	</tr>
        
	<tr>
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["sr_manager"]])?></td>
	</tr>
	
	<tr>
		<td class="hr">Manager Comp</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["india_manager"]])?></td>
	</tr>
	
        <tr>
		<td class="hr">Manager Audit</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["audit_manager"]])?></td>
	</tr>
        
        <tr>
		<td class="hr">Sr.Accountant Comp</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["sr_accnt_comp"]])?></td>
	</tr>
        
        <tr>
		<td class="hr">Sr.Accountant Audit</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["sr_accnt_audit"]])?></td>
	</tr>

        <tr>
		<td class="hr">Jnr.Accountant Comp</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["team_member"]])?></td>
	</tr>
        
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrTaskData["sales_person"]])?></td>
	</tr>
		
	<tr>
		<td class="hr">India Staff Notes</td>
		<td class="dr"><?=htmlspecialchars($arrTaskData["notes"])?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr><?

		if($access_file_level['stf_Add'] == "Y") {
			?><td><a class="hlight"  href="tsk_task.php?a=add&jobId=<?=$_REQUEST["jobId"]?>">Add Record</a></td><?
		}

		if($access_file_level['stf_Edit'] == "Y") {
			?><td><a class="hlight"  href="tsk_task.php?a=edit&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$recid?>">Edit Record</a></td><?
		}

		if($access_file_level['stf_Delete'] == "Y") {
			?><td><a class="hlight"  onClick="performdelete('tsk_task.php?sql=delete&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td><?
		}
	?></tr>
</table>