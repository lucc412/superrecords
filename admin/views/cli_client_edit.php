<div class="frmheading">
	<h1>Edit Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>

<form action="cli_client.php" method="post" name="manageclient" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="update"></p>
	<input type="hidden" name="recid" value="<?=$recid?>">
	<input type="hidden" name="a" value="edit"><?
            
	?><table class="tbl" border="0" cellspacing="10" width="70%">
		
		<tr>
			<td class="hr">Client Code</td>
			<td class="dr"><?
				if($_SESSION['usertype'] == 'Administrator') {

					if(!empty($_REQUEST['cli_code'])) {
						$cliCode = $_REQUEST['cli_code'];
					}
					else {
						$cliCode = $arrClientData['client_code'];
					}
					?><input type="text" name="cliCode" value="<?=$cliCode?>"><?
				}
				else {
					echo $arrClientData['client_code'];
				}
			?></td>
		</tr><?

		// show error message
		if($_REQUEST['flagError'] == 'Y') {
			?><tr><td>&nbsp;</td><td class="errmsg">This client code already exists.</td></tr><?
		}

		?>
                <tr>
			<td class="hr">Date client received<font style="color:red;" size="2">*</font></td>
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
			<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="cliName" maxlength="50" value="<?=stripslashes($arrClientData['client_name'])?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Client.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Practice<font style="color:red;" size="2">*</font></td>
			<td class="dr"><select name="lstPractice" id="lstPractice" onchange="javascript:selectPanel('LoadPanel');">
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
			<td class="hr">Entity Type<font style="color:red;" size="2">*</font></td>
			<td class="dr"><select name="lstType">
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
			<td class="hr">SR Manager</td>
			<td class="dr" id="tdSrManager"><?=$arrEmployees[$arrClientData['sr_manager']]?></td>
		</tr>
		<tr>
			<td class="hr">Manager Comp</td>
			<td class="dr" id="tdInManager"><?=$arrEmployees[$arrClientData['india_manager']]?></td>
		</tr>
                <tr>
			<td class="hr">Manager Audit</td>
			<td class="dr" id="tdAuditManager"><?=$arrEmployees[$arrClientData['audit_manager']]?></td>
		</tr>
                <tr>
			<td class="hr">Sr. Accountant Comp</td>
			<td class="dr"><select name="lstSrAccntComp">
					<option value="">Select Sr.Accountant Comp</option><?php
					foreach($objCallData->arrSrAccntComp AS $staffId => $staffName){
						$selectStr = '';
						if($staffId == $arrClientData['sr_accnt_comp']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$staffId?>"><?=$staffName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Sr. Accountant Comp of client.</span></a>
			</td>
		</tr>
        <tr>
			<td class="hr">Sr. Accountant Audit</td>
			<td class="dr"><select name="lstSrAccntAudit">
					<option value="">Select Sr. Accountant Audit</option><?php
					foreach($objCallData->arrSrAccntAudit AS $staffId => $staffName){
						$selectStr = '';
						if($staffId == $arrClientData['sr_accnt_audit']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$staffId?>"><?=$staffName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Sr. Accountant Audit of client.</span></a>
			</td>
		</tr>
        <tr>
			<td class="hr">Jnr. Accountant Comp</td>
			<td class="dr"><select name="lstTeamMember">
					<option value="">Select Jnr. Accountant Comp</option><?php
					foreach($objCallData->arrTeamMember AS $staffId => $staffName){
						$selectStr = '';
						if($staffId == $arrClientData['team_member']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$staffId?>"><?=$staffName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Jnr. Accountant Comp for Client.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Sales Person</td>
			<td class="dr" id="tdSalesPrson"><?=$arrEmployees[$arrClientData['sales_person']]?></td>
		</tr>
		
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Update" class="button">Update</button></td>
		</tr>
	</table>
</form><?