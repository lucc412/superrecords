<!--*************************************************************************************************
//  Task          : Page for Adding Task details
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 30-Jan-2013 
//************************************************************************************************-->
<div class="frmheading">
	<h1>Add Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form action="tsk_task.php?sql=insert&jobId=<?=$_REQUEST["jobId"]?>" method="POST" name="managetask" onSubmit="return validateFormOnSubmit()"><?
	$JobID = $_REQUEST["jobId"];
	$ClientID = $objCallData->arrJobDetails[$_REQUEST["jobId"]]["client_id"];
	$PracticeID =  $objCallData->arrClientDetails[$ClientID]["id"];

	$arrJobParts = explode('::', $objCallData->arrJob[$JobID]);
	$jobName = '<span class="clientclr">'.$objCallData->arrClient[$ClientID] . '</span> - <span class="periodclr">' . $objCallData->arrJobDetails[$_REQUEST["jobId"]]["period"]. '</span> - <span class="activityclr">' . $objCallData->arrJobType[$arrJobParts[2]]["sub_Description"].'</span>';
			
	?><table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Task Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="txtTaskName" size="26" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Task.</span></a>
			</td>
		</tr>
		
		<tr>
		   <td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
		   
		   <td><? 
			   	if($JobID) {
					?><span><b><?=$objCallData->arrPractice[$PracticeID]?></b></span><?
				}
				else {
			   		?><select id="lstPractice" name="lstPractice" onchange="javascript:selectOptions('Client');selectPanel();">
						<option value="0">----- Select Practice -----</option><?php
						foreach($objCallData->arrPractice AS $practice_id => $practice_name) {
							?><option value="<?=$practice_id?>"><?=$practice_name?></option><? 
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
					  ?></select>
					</span>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Job.</span></a><?
				}
			?></td>
		</tr>
		
		<tr>
			<td class="hr">Master Activity<font style="color:red;" size="2">*</font></td>
			<td><select id="lstMasterActivity" name="lstMasterActivity" onchange="javascript:selectOptions('SubActivity');">
					<option value="0">--- Select Master Activity ---</option><?php
					foreach($objCallData->arrMasterActivity AS $mas_code => $mas_desc){
						?><option value="<?=$mas_code?>"><?=$mas_desc?></option><?php 
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
						<option value="0">--------------- Select Sub Activity ---------------</option>
					</select>
				</span>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Sub Activity.</span></a>
			</td>
		</tr>
<tr>
			<td class="hr">Task Status <font style="color:red;" size="2">*</font></td>
			<td><select name="lstTaskStatus">
					<option value="0">--- Select Task Status ---</option><?php
					foreach($objCallData->arrTaskStatus AS $id => $desc){
						?><option value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select task status.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Priority <font style="color:red;" size="2">*</font></td>
			<td><select name="lstPriority">
					<option value="0">--- Select Priority ---</option><?php
					foreach($objCallData->arrPriority AS $id => $desc){
						?><option value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select priority of task.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Process Cycle <font style="color:red;" size="2">*</font></td>
			<td><select name="lstProcessingCycle">
					<option value="0">--- Select Process Cycle ---</option><?php
					foreach($objCallData->arrProcessingCycle AS $id => $desc){
						?><option value="<?=$id?>"><?=$desc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select process cycle of task.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">External Due Date</td>
				<td class="dr">						
					<input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$due_date?>">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
					<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Superrecords Due Date</td>
				<td class="dr">						
					<input type="text" name="befreeDueDate" id="befreeDueDate" value="<?=$due_date?>">&nbsp;<a href="javascript:NewCal('befreeDueDate','ddmmyyyy',false,24)">
					<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				</td>
		</tr>
		<tr>
			<td class="hr">SR Manager</td>
			<td class="dr" id="tdSrManager"><?=$srManagerEmail?></td>
		</tr>
		<tr>
			<td class="hr">Manager Comp</td>
			<td class="dr" id="tdInManager"><?=$inManagerEmail?></td>
		</tr>
                <tr>
			<td class="hr">Manager Audit</td>
			<td class="dr" id="tdAuditManager"><?=$auditManagerEmail?></td>
		</tr>
		<tr>
			<td class="hr">Jnr. Accountant Comp</td>
			<td class="dr" id="tdTeamMember"><?=$teamMemberEmail?></td>
		</tr>
                <tr>
			<td class="hr">Sr. Accountant Comp</td>
			<td class="dr" id="tdSrAcntComp"><?=$SrAccntCompEmail?></td>
		</tr>
        <tr>
			<td class="hr">Sr. Accountant Audit</td>
			<td class="dr" id="tdSrAcntAudit"><?=$SrAccntAuditEmail?></td>
		</tr>
		<tr>
			<td class="hr">Sales Person</td>
			<td class="dr" id="tdSalesPrson"><?=$salesPersonEmail?></td>
		</tr>

		
			
		<tr>
			<td class="hr">India Staff Notes</td>
			<td class="dr">
				<textarea name="txtNotes" rows="3" cols="25"></textarea>
			</td>
		</tr>
		
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel("<?=$_REQUEST["jobId"]?>");' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Save" class="button">Save</button></td>
	</tr>
</table>
</form><?