
<!--*************************************************************************************************
//  Task          : Page for Listing details of Task
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 01-Jan-2013 
//************************************************************************************************-->

<div class="frmheading">
	<h1>Manage Task</h1>
</div>

<table class<table class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="tsk_task.php?a=add&jobId=<?=$_REQUEST["jobId"]?>" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}
		
	?><tr class="fieldheader">
		<th align="left" class="fieldheader">Task Name</th>
		<th align="left" class="fieldheader">Practice Name</th>
		<th align="left" class="fieldheader">Client Name</th>
		<th align="left" class="fieldheader">Job Name</th>
		<th align="left" class="fieldheader">SR Manager</th>
		<th align="left" class="fieldheader">SR India Manager</th>
		<th align="left" class="fieldheader">SR Team Member</th>
		<th class="fieldheader">Due Date</th>
		<th class="fieldheader">Created Date</th>
		<th  class="fieldheader" colspan="3" align="center">Actions</th>
	</tr><?

	$countRow = 0;
	foreach ($arrTask AS $taskId => $arrInfo) {
		if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			<td class="<?=$style?>"><?=htmlspecialchars($arrInfo["task_name"])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrPractice[$arrInfo["id"]])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrClient[$arrInfo["client_id"]])?></td><?
		  	  $jobName = ($objCallData->arrJob[$arrInfo["job_id"]]);
			  $arrJobParts = explode('::', $jobName);
			  
			  $jobName = '<b style="color:#b30000">'.$objCallData->arrClient[$arrJobParts[0]] . '</b> - <b style="color:#0411ff">' . $arrJobParts[1] . '</b> - <b style="color:#006a0e">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</b>';
			
		  ?><td class="<?=$style?>"><?=$jobName?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrSrManager[$arrInfo["manager_id"]])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrEmployees[$arrInfo["india_manager_id"]])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrEmployees[$arrInfo["team_member_id"]])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($arrInfo["due_date"])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($arrInfo["created_date"])?></td><?
			
			if($access_file_level['stf_View'] == "Y") {
				?><td>
					<a href="tsk_task.php?a=view&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$taskId?>">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td>
					<a href="tsk_task.php?a=edit&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$taskId?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}
			
			if($access_file_level['stf_Delete'] == "Y") {
				?><td><?
					$jsFunc = "javascript:performdelete('tsk_task.php?sql=delete&jobId=".$_REQUEST["jobId"]."&recid=".$taskId."');";
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}

		?></tr><?
	$countRow++;
	}
?></table><br>