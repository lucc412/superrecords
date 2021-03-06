<div class="frmheading">
	<h1>Add Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>

<form action="cli_client.php?sql=insert" method="POST" name="manageclient" onSubmit="return validateFormOnSubmit()">
	<table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Client</td>
			<td class="dr">New</td>
		</tr>
                <tr>
			<td class="hr">Date client received<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="dateSignedUp" id="dateSignedUp" value="">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Client received date.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Practice<font style="color:red;" size="2">*</font></td>
			<td><select name="lstPractice" id="lstPractice" onchange="javascript:selectPanel();">
					<option value="">Select Practice</option><?php
					foreach($objCallData->arrPractice AS $practiceId => $typeDesc){
						?><option value="<?=$practiceId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Practice to which this client belongs to.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="cliName" maxlength="50" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Client.</span></a>
			</td>
		</tr>
                <tr>
			<td class="hr">Entity Type<font style="color:red;" size="2">*</font></td>
			<td class="dr"><select name="lstType">
					<option value="">Select Entity Type</option><?php
					foreach($objCallData->arrTypes AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Entity type of Client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Client Notes</td>
			<td class="dr">
				<textarea name="client_notes"></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="hr">SR Manager</td>
			<td class="dr" id="tdSrManager">&nbsp;</td>
		</tr>
		<tr>
			<td class="hr">Manager Comp</td>
			<td class="dr" id="tdInManager">&nbsp;</td>
		</tr>
                <tr>
			<td class="hr">Manager Audit</td>
			<td class="dr" id="tdAuditManager">&nbsp;</td>
		</tr>
        <tr>
			<td class="hr">Sr. Accountant Comp</td>
			<td class="dr"><select name="lstSrAccntComp">
					<option value="">Select Sr. Accountant Comp</option><?php
					foreach($objCallData->arrSrAccntComp AS $staffId => $staffName){
						?><option value="<?=$staffId?>"><?=$staffName?></option><?php 
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
						?><option value="<?=$staffId?>"><?=$staffName?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select   Sr. Accountant Audit of client.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Jnr. Accountant Comp</td>
			<td class="dr"><select name="lstTeamMember">
					<option value="">Select Jnr. Accountant Comp</option><?php
					foreach($objCallData->arrTeamMember AS $staffId => $staffName){
						?><option value="<?=$staffId?>"><?=$staffName?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Jnr. Accountant Comp of client.</span></a>
			</td>
		</tr>
                
		<tr>
			<td class="hr">Sales Person</td>
			<td class="dr" id="tdSalesPrson">&nbsp;</td>
		</tr>
		
		
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Save" class="button">Save</button></td>
		</tr>
	</table>
</form><?