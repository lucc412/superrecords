<div class="frmheading">
	<h1>Edit Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>

<form action="cli_client.php" method="post" name="manageclient" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="update"></p>
	<input type="hidden" name="recid" value="<?=$recid?>">
	<input type="hidden" name="a" value="edit">
	
	<table class="tbl" border="0" cellspacing="10" width="70%">
		
		<tr>
			<td class="hr">Client</td>
			<td class="dr">New</td>
		</tr>
		<tr>
			<td class="hr">Practice<font style="color:red;" size="2">*</font></td>
			<td><select name="lstPractice">
					<option value="">Select Practice</option><?php
					foreach($objCallData->arrPractice AS $practiceId => $typeDesc){
						$selectStr = '';
						if($practiceId == $arrClientData['id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$practiceId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Practice to which this client belongs to.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">SR Manager<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrManager">
					<option value="">Select SR Manager</option><?php
					foreach($objCallData->arrSrManager AS $userId => $typeDesc) {
						$strSelected = '';
						if($userId == $arrClientData['sr_manager']) $strSelected = 'selected';
						?><option <?=$strSelected?> value="<?=$userId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select senior manager for Client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">India Manager</td>
			<td><select name="lstInManager">
					<option value="">Select India Manager</option><?php
					foreach($objCallData->arrIndiaManager AS $userId => $typeDesc){
						$strSelected = '';
						if($userId == $arrClientData['india_manager']) $strSelected = 'selected';
						?><option <?=$strSelected?> value="<?=$userId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select India manager for Client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Team Member</td>
			<td><select name="lstTeamMember">
					<option value="0">Select Team Member</option><?php
					foreach($objCallData->arrEmployees AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrClientData['team_member']) $selectStr = 'selected';	
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Team Member for Task.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="cliName" maxlength="50" value="<?=$arrClientData['client_name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Entity Type<font style="color:red;" size="2">*</font></td>
			<td><select name="lstType">
					<option value="">Select Entity Type</option><?php
					foreach($objCallData->arrTypes AS $typeId => $typeDesc){
						$strSelected = '';
						if($typeId == $arrClientData['client_type_id']) $strSelected = 'selected';
						?><option <?=$strSelected?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Entity type of Client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Client Notes</td>
			<td class="dr">
				<textarea name="client_notes"><?=$arrClientData['client_notes']?></textarea>
			</td>
		</tr>
		<tr>
			<td class="hr">Date Client Received<font style="color:red;" size="2">*</font></td>
			<td class="dr"><?
				$dateSignedUp = "";
				if (isset($arrClientData["client_received"]) && $arrClientData["client_received"] != "") {
					if($arrClientData["client_received"] != "0000-00-00 00:00:00") {
						$dateSignedUp = date("d/m/Y",strtotime( $arrClientData["client_received"]));
					}
				}  
				?><input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$dateSignedUp?>">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Client received date.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Steps Done</td>
			<td class="dr"><?
				$arrStepsList = explode(',', $arrClientData['steps_done']);
				foreach($objCallData->arrStepsList AS $stepId => $stepName){
					$checkedStr = '';
					if(in_array($stepId, $arrStepsList)) $checkedStr = 'checked';
					?><input class="checkboxClass" <?=$checkedStr?> type="checkbox" name="step:<?=$stepId?>" id="<?=$stepName?>" /><label for="<?=$stepName?>"><?=$stepName?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Sales Person</td>
			<td>
				<select name="lstSalesPerson">
					<option value="">Select Sales Person</option><?php
					foreach($objCallData->arrSalesPerson AS $stfCode => $stfName){
						$selectStr = '';
						if($stfCode == $arrClientData['sales_person']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$stfCode?>"><?=$stfName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select name of sales person.</span></a>
			</td>
		</tr>
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Update" class="button">Update</button></td>
		</tr>
	</table>
</form><?