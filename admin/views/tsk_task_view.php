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
		<td class="dr"><?=htmlspecialchars($arrTaskData["task_name"])?></td>
	</tr>
	
	<tr>
		<td class="hr">Practice Name</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrPractice[$arrTaskData["id"]])?></td>
	</tr>

	<tr>
		<td class="hr">Client Name</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrClient[$arrTaskData["client_id"]])?></td>
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
			$jobName = '<b style="color:#b30000">'.$objCallData->arrClient[$ClientID] . '</b> - <b style="color:#0411ff">' . $objCallData->arrJobDetails[$JobID]["period"]. '</b> - <b style="color:#006a0e">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</b>';
			
			echo $jobName; 	
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
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrTaskData["manager_id"]])?></td>
	</tr>
	
	<tr>
		<td class="hr">SR India Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrTaskData["india_manager_id"]])?></td>
	</tr>
	
	<tr>
		<td class="hr">SR Team Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrTaskData["team_member_id"]])?></td>
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
		<td class="hr">Processing Cycle</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrProcessingCycle[$arrTaskData["process_id"]])?></td>
	</tr>
	
	
	
		
	<tr>
		<td class="hr">Due Date</td>
		<td class="dr"><?=htmlspecialchars($arrTaskData["due_date"])?></td>
	</tr>
	
	<tr>
		<td class="hr">Created Date</td>
		<td class="dr"><?=htmlspecialchars($arrTaskData["created_date"])?></td>
	</tr>
	
	<tr>
		<td class="hr">Notes</td>
		<td class="dr"><?=htmlspecialchars($arrTaskData["notes"])?></td>
	</tr>
</table>

<br><hr size="1" noshade>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td><a class="hlight"  href="tsk_task.php?a=add&jobId=<?=$_REQUEST["jobId"]?>">Add Record</a></td>
		<td><a class="hlight"  href="tsk_task.php?a=edit&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$recid?>">Edit Record</a></td>
		<td><a class="hlight"  onClick="performdelete('tsk_task.php?sql=delete&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td>
	</tr>
</table>