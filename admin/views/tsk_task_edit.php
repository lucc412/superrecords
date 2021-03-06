<!--*************************************************************************************************
//  Task          : Page for Updating Task details
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 30-Jan-2013 
//************************************************************************************************-->

<div class="frmheading">
	<h1>Edit Record</h1>
</div>
<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form action="tsk_task.php?jobId=<?=$_REQUEST["jobId"]?>" method="post" name="managetask" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="update"></p>
	<input type="hidden" name="recid" value="<?=$recid?>">
	<input type="hidden" name="a" value="edit"><?
                        $JobID = $_REQUEST["jobId"];
			$ClientID = $objCallData->arrJobDetails[$_REQUEST["jobId"]]["client_id"];
			$PracticeID =  $objCallData->arrClientDetails[$ClientID]["id"];
	
			$arrJobParts = explode('::', $objCallData->arrJob[$JobID]);

			$jobName = '<span class="clientclr">'.$objCallData->arrClient[$ClientID] . '</span> - <span class="periodclr">' . $objCallData->arrJobDetails[$_REQUEST["jobId"]]["period"]. '</span> - <span class="activityclr">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</span>';
			
	?><table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Task Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="txtTaskName" size="26" value="<?=stripslashes($arrTaskData['task_name'])?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Task.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
			<td><? 
			   	if($JobID)
				{
					?><span><b><?=$objCallData->arrPractice[$PracticeID]?></b></span><?
				}
				else
				{
			   		?><select id="lstPractice" name="lstPractice" onchange="javascript:selectOptions('Client');selectPanel();">
					<option value="0">Select Practice</option><?php
					foreach($objCallData->arrPractice AS $practice_id => $practice_name){
						$selectStr = '';
						if($practice_id == $arrTaskData['id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$practice_id?>"><?=stripslashes($practice_name)?></option><?php 
				} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a><?
		   		}
		   ?></td>
		</tr>
		
		<tr>
			<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
			<td><? 
			   	if($JobID) {
					?><span><b><?=$objCallData->arrClient[$ClientID]?></b></span><?
				}
				else {
			   		?><span id="spanClient">
						<select id="lstClient" name="lstClient">
							<option value="0">Select Client</option><?php
							foreach($arrFewClient AS $client_id => $client_name){
								$selectStr = '';
								if($client_id == $arrTaskData['client_id']) $selectStr = 'selected';
								?><option <?=$selectStr?> value="<?=$client_id?>"><?=stripslashes($client_name)?></option><?php 
							} 
						?></select>
					</span>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Client.</span></a><?
		   		}
		 ?></td>
		</tr>
		
		<tr>
			<td class="hr">Job Name<font style="color:red;" size="2">*</font></td>
			<td><? 
			   	if($JobID)
				{
					?><span><b><?=$jobName?></b></span><?
				}
				else
				{
			   		?><span id="spanJob"><?
						$arrJobNames = array();
						foreach($arrFewJob AS $jobId => $job_name)
						{
							$arrJobParts = explode('::', $job_name);
							$arrJobNames[$jobId] = $objCallData->arrClient[$arrJobParts[0]] . ' - ' . $arrJobParts[1]. ' - ' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"];
						}
						// Code to sort Job Names array in ascending order
						asort($arrJobNames);
						?><select id="lstJob" name="lstJob">
								<option value="0">Select Job</option><?php
								foreach($arrJobNames AS $job_id => $job_name)
								{
									$selectStr = '';
									if($job_id == $arrTaskData['job_id']) $selectStr = 'selected';		
									?><option <?=$selectStr?> value="<?=$job_id?>"><?=stripslashes($job_name)?></option><?php 
								} 
							?></select>
					  </span>
					  <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Job.</span></a><?
		   		}
		 	?>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Master Activity<font style="color:red;" size="2">*</font></td>
			<td><select id="lstMasterActivity" name="lstMasterActivity" onchange="javascript:selectOptions('SubActivity');">
					<option value="0">elect Master Activity</option><?php
					foreach($objCallData->arrMasterActivity AS $mas_code => $mas_desc){
						$selectStr = '';
						if($mas_code == $arrTaskData['mas_Code']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$mas_code?>"><?=$mas_desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Master Activity.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Sub Activity<font style="color:red;" size="2">*</font></td>
			<td>
				<span id="spanSubActivity">
					<select id="lstSubActivity" name="lstSubActivity">
							<option value="0">Select Sub Activity</option><?php
							foreach($arrFewSubActivity AS $sub_code => $sub_desc){
								$selectStr = '';
								if($sub_code == $arrTaskData['sub_Code']) $selectStr = 'selected';			
								?><option <?=$selectStr?> value="<?=$sub_code?>"><?=$sub_desc?></option><?php 
							} 
						?></select>
					</span>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Sub Activity.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Task Status <font style="color:red;" size="2">*</font></td>
			<td><select name="lstTaskStatus">
					<option value="0">Select Task Status</option><?php
					foreach($objCallData->arrTaskStatus AS $id => $desc){
						$selectStr = '';
                                                if(empty($arrTaskData['task_status_id']) && $id == 1) $selectStr = 'selected';
						if($id == $arrTaskData['task_status_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select task status.</span></a>
			</td>
		</tr>
                
                <tr>
			<td class="hr">Task Stage</td>
			<td><select name="lstTaskStage">
					<option value="0">Select Task Stage</option><?php
					foreach($arrStages AS $id => $desc){
						$selectStr = '';
						if($id == $arrTaskData['task_stage_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select task stage.</span></a>
			</td>
		</tr>
		
		
		<tr>
			<td class="hr">Priority <font style="color:red;" size="2">*</font></td>
			<td><select name="lstPriority">
					<option value="0">Select Priority</option><?php
					foreach($objCallData->arrPriority AS $id => $desc){
						$selectStr = '';
                                                if(isset($arrTaskData['priority_id']) && $id == $arrTaskData['priority_id']) 
                                                    $selectStr = 'selected';
                                                elseif (empty($arrTaskData['priority_id']) && $id == 7) {
                                                    $selectStr = 'selected';
                                                }
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select priority of task.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Process Cycle <font style="color:red;" size="2">*</font></td>
			<td><select name="lstProcessingCycle">
					<option value="0">Select Process Cycle</option><?php
					foreach($objCallData->arrProcessingCycle AS $id => $desc){
						$selectStr = '';
						if($id == $arrTaskData['process_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select process cycle for task.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Start Date</td>
				<td class="dr"><?=$arrTaskData["start_date"]?></td>
		</tr>
                <tr>
                    <td class="hr">Job Due Date</td>
                    <td class="dr">
                        <?      
                            $due_date = "";
                            if (isset($arrTaskData["job_due_date"]) && $arrTaskData["job_due_date"] != "") {
                                if($arrTaskData["job_due_date"] != "00/00/0000") {
                                    echo $due_date = $arrTaskData["job_due_date"];
                                }
                            }  
                        ?>
					
                    </td>
		</tr>

		<tr>
			<td class="hr">Task Due Date</td>
				<td class="dr">
				<?						
					$task_due_date = "";
					if (isset($arrTaskData["task_due_date"]) && $arrTaskData["task_due_date"] != "") {
						if($arrTaskData["task_due_date"] != "00/00/0000 00:00:00") {
							$task_due_date = $arrTaskData["task_due_date"];
						}
					}  
                                
                                        if($_SESSION["usertype"] == "Staff") {
                                            $arrFeatures = $commonUses->getFeatureVisibility(6);
                                        }else
                                            $arrFeatures['stf_visibility'] = 1;
                                    
                                        if($arrFeatures['stf_visibility'] == 1)
                                        {
                                ?>
                                    <input type="text" name="taskDueDate" id="taskDueDate" readonly="" value="<?=$task_due_date?>">&nbsp;<a href="javascript:NewCal('taskDueDate','ddmmyyyy',true,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                    <? }  else { ?>
                                        <span><?=$task_due_date?></span>
                                        <input type="hidden" name="taskDueDate" id="taskDueDate" value="<?=$task_due_date?>">
                                   <? }?>	
				</td>
		</tr>
		<tr>
			<td class="hr">SR Manager</td>
			<td class="dr" id="tdSrManager"><?=$arrEmployees[$arrTaskData['sr_manager']]?></td>
		</tr>
		<tr>
			<td class="hr">Manager Comp</td>
			<td class="dr" id="tdInManager"><?=$arrEmployees[$arrTaskData['india_manager']]?></td>
		</tr>
                <tr>
			<td class="hr">Manager Audit</td>
			<td class="dr" id="tdAuditManager"><?=$arrEmployees[$arrTaskData['audit_manager']]?></td>
		</tr>
		<tr>
			<td class="hr">Jnr. Accountant Comp</td>
			<td class="dr" id="tdTeamMember"><?=$arrEmployees[$arrTaskData['team_member']]?></td>
		</tr>
                <tr>
			<td class="hr">Sr. Accountant Comp</td>
			<td class="dr" id="tdSrAcntComp"><?=$arrEmployees[$arrTaskData['sr_accnt_comp']]?></td>
		</tr>
                <tr>
			<td class="hr">Sr. Accountant Audit</td>
			<td class="dr" id="tdSrAcntAudit"><?=$arrEmployees[$arrTaskData['sr_accnt_audit']]?></td>
		</tr>
		<tr>
			<td class="hr">Sales Person</td>
			<td class="dr" id="tdSalesPrson"><?=$arrEmployees[$arrTaskData['sales_person']]?></td>
		</tr>
		
		
		

		<tr>
			<td class="hr">India Staff Notes</td>
			<td class="dr">
				<textarea name="txtNotes" rows="3" cols="25"><?=$arrTaskData['notes']?></textarea>
			</td>
		</tr>
				
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel("<?=$_REQUEST["jobId"]?>");' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Update" class="button">Update</button></td>
		</tr>
	</table>
</form><?