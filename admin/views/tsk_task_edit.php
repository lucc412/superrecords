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
			$jobName = '<b style="color:#b30000">'.$objCallData->arrClient[$ClientID] . '</b> - <b style="color:#0411ff">' . $objCallData->arrJobDetails[$_REQUEST["jobId"]]["period"]. '</b> - <b style="color:#006a0e">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</b>';
			
	?><table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Task Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="txtTaskName" size="26" value="<?=$arrTaskData['task_name']?>">
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
			   		?><select id="lstPractice" name="lstPractice" onchange="javascript:selectOptions('Client');">
					<option value="0">----- Select Practice -----</option><?php
					foreach($objCallData->arrPractice AS $practice_id => $practice_name){
						$selectStr = '';
						if($practice_id == $arrTaskData['id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$practice_id?>"><?=$practice_name?></option><?php 
				} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a><?
		   		}
		   ?></td>
		</tr>
		
		<tr>
			<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
			<td><? 
			   	if($JobID)
				{
					?><span><b><?=$objCallData->arrClient[$ClientID]?></b></span><?
				}
				else
				{
			   		?><span id="spanClient">
						<select id="lstClient" name="lstClient">
							<option value="0">------------- Select Client -------------</option><?php
							foreach($arrFewClient AS $client_id => $client_name){
								$selectStr = '';
								if($client_id == $arrTaskData['client_id']) $selectStr = 'selected';
								?><option <?=$selectStr?> value="<?=$client_id?>"><?=$client_name?></option><?php 
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
			   		?><span id="spanJob">
							<select id="lstJob" name="lstJob">
								<option value="0">----- Select Job -----</option><?php
								foreach($arrFewJob AS $job_id => $job_name)
								{
									$arrJobParts = explode('::', $job_name);
									$jobName = '<b style="color:#b30000">'.$objCallData->arrClient[$arrJobParts[0]] . '</b> - <b style="color:#0411ff">' . $arrJobParts[1]. '</b> - <b style="color:#006a0e">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</b>';
								
									$selectStr = '';
									if($job_id == $arrTaskData['job_id']) $selectStr = 'selected';		
									?><option <?=$selectStr?> value="<?=$job_id?>"><?=$jobName?></option><?php 
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
					<option value="0">--- Select Master Activity ---</option><?php
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
							<option value="0">--------------- Select Sub Activity ---------------</option><?php
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
			<td class="hr">SR Manager<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrManager">
					<option value="0">--- Select SR Manager ---</option><?php
					foreach($objCallData->arrSrManager AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrTaskData['manager_id']) $selectStr = 'selected';									?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Senior Manager for Task.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">India Manager<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrIndiaManager">
					<option value="0">--- Select India Manager ---</option><?php
					foreach($objCallData->arrIndiaManager AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrTaskData['india_manager_id']) $selectStr = 'selected';									?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select India Manager for Task.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Team Member<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrTeamMember">
					<option value="0">--- Select Team Member ---</option><?php
					foreach($objCallData->arrEmployees AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrTaskData['team_member_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Team Member for Task.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Task Status <font style="color:red;" size="2">*</font></td>
			<td><select name="lstTaskStatus">
					<option value="0">--- Select Task Status ---</option><?php
					foreach($objCallData->arrTaskStatus AS $id => $desc){
						$selectStr = '';
						if($id == $arrTaskData['task_status_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Description of Task Status.</span></a>
			</td>
		</tr>
		
		
		<tr>
			<td class="hr">Priority <font style="color:red;" size="2">*</font></td>
			<td><select name="lstPriority">
					<option value="0">--- Select Priority ---</option><?php
					foreach($objCallData->arrPriority AS $id => $desc){
						$selectStr = '';
						if($id == $arrTaskData['priority_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Description of Priority.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Processing Cycle <font style="color:red;" size="2">*</font></td>
			<td><select name="lstProcessingCycle">
					<option value="0">--- Select Processing Cycle ---</option><?php
					foreach($objCallData->arrProcessingCycle AS $id => $desc){
						$selectStr = '';
						if($id == $arrTaskData['process_id']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Description of Processing Cycle.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">External Due Date</td>
				<td class="dr"><?						
					$arrDate = explode("-", $arrTaskData['due_date']);
					$strDate = $arrDate[2]."/".$arrDate[1]."/".$arrDate[0];
						?><input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$strDate?>">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
					
				</td>
		</tr>

		<tr>
			<td class="hr">Befree Due Date</td>
				<td class="dr"><?						
					$arrDate = explode("-", $arrTaskData['befree_due_date']);
					$strDate = $arrDate[2]."/".$arrDate[1]."/".$arrDate[0];
						?><input type="text" name="befreeDueDate" id="befreeDueDate" value="<?=$strDate?>">&nbsp;<a href="javascript:NewCal('befreeDueDate','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
					
				</td>
		</tr>

		<tr>
			<td class="hr">Last Reports Sent</td>
			<td class="dr">
				<textarea name="txtReportsSent" rows="3" cols="25"><?=$arrTaskData['last_reports_sent']?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Resolution</td>
			<td class="dr">
				<textarea name="txtResolution" rows="3" cols="25"><?=$arrTaskData['resolution']?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Current Job in Hand</td>
			<td class="dr">
				<textarea name="txtJobInHand" rows="3" cols="25"><?=$arrTaskData['current_job_in_hand']?></textarea>
			</td>
		</tr>

		<tr>
			<td class="hr">SR Manager Notes</td>
			<td class="dr">
				<textarea name="txtNotes" rows="3" cols="25"><?=$arrTaskData['notes']?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Related Cases</td>
			<td class="dr">
				<textarea name="txtRelatedCases" rows="3" cols="25"><?=$arrTaskData['related_cases']?></textarea>
			</td>
		</tr>
		
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel("<?=$_REQUEST["jobId"]?>");' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Update" class="button">Update</button></td>
		</tr>
	</table>
</form><?