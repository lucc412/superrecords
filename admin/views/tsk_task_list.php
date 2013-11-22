<!--*************************************************************************************************
//  Task          : Page for Listing details of Task
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 01-Jan-2013 
//************************************************************************************************-->

<div class="frmheading">
	<h1>Task</h1>
</div>
<form action="tsk_task.php" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "pr.name" ?>"<?php if ($filterfield == "pr.name") { echo "selected"; } ?>>Practice Name</option> 
<option value="<?php echo "t.task_name" ?>"<?php if ($filterfield == "t.task_name") { echo "selected"; } ?>>Task Name</option>
<option value="<?php echo "ts.description" ?>"<?php if ($filterfield == "ts.description") { echo "selected"; } ?>>Task Status</option>
<option value="<?php echo "tg.description" ?>"<?php if ($filterfield == "tg.description") { echo "selected"; } ?>>Task Stage</option>
<option value="<?php echo "t.start_date" ?>"<?php if ($filterfield == "t.start_date") { echo "selected"; } ?>>Start Date</option>
</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="tsk_task.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<table class<table class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="tsk_task.php?a=add&jobId=<?=$_REQUEST["jobId"]?>" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}
		
	?><tr class="fieldheader">
		<th width="15%" align="left" class="fieldheader"><a href="tsk_task.php?order=<?php echo "pr.name" ?>&type=<?php echo $ordertype; ?>">Practice Name</a></th>
		<th width="30%" align="left" class="fieldheader"><a href="tsk_task.php?order=<?php echo "t.task_name" ?>&type=<?php echo $ordertype; ?>">Task Name</a></th>
		<th width="10%" align="left" class="fieldheader"><a href="tsk_task.php?order=<?php echo "t.task_status_id" ?>&type=<?php echo $ordertype; ?>">Task Status</a></th>
                <th width="20%" align="left" class="fieldheader"><a href="tsk_task.php?order=<?php echo "t.task_stage_id" ?>&type=<?php echo $ordertype; ?>">Task Stage</a></th>
                <th width="15%" align="center" class="fieldheader"><a href="tsk_task.php?order=<?php echo "t.start_date" ?>&type=<?php echo $ordertype; ?>">Start Date</a></th>
		<th width="10%" class="fieldheader" colspan="3" align="center">Actions</th>
	</tr><?

	$countRow = 0;
	foreach ($arrTask AS $taskId => $arrInfo) {
		if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			
			<td><?=htmlspecialchars($arrInfo["name"])?></td>

			<td><?=stripslashes($arrInfo["task_name"])?></td>

		  	<td><?=$arrInfo["description"]?></td>
                        
		  	<td><?=$arrInfo["stageName"]?></td>
                            
                        <td align="center" ><?=$arrInfo["start_date"]?></td><?
			
			if($access_file_level['stf_View'] == "Y") {
				?><td align="center">
					<a href="tsk_task.php?a=view&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$taskId?>">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td align="center">
					<a href="tsk_task.php?a=edit&jobId=<?=$_REQUEST["jobId"]?>&recid=<?=$taskId?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}
			
			if($access_file_level['stf_Delete'] == "Y") {
				?><td align="center"><?
					$jsFunc = "javascript:performdelete('tsk_task.php?sql=delete&jobId=".$_REQUEST["jobId"]."&recid=".$taskId."');";
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}

		?></tr><?
	$countRow++;
	}
?></table><br>