<div class="frmheading">
	<h1>Add Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>

<form action="lead.php" method="POST" name="frmlead" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="insert"></p>
	<table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Lead</td>
			<td class="dr">New</td>
		</tr>
		<tr>
			<td class="hr">Lead Type<font style="color:red;" size="2">*</td>
			<td><select name="lead_type">
					<option value="">Select Type</option><?php
					foreach($objCallData->arrTypes AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Type of Lead.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Lead Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="lead_name" maxlength="50" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Lead.</span></a>
			</td>
		</tr>
        
      <tr>
			<td class="hr">SR Manager</font></td>
			<td><select name="lstSrManager">
					<option value="0">Select SR Manager</option><?php
					foreach($objCallData->arrSrManager AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select senior manager for Practice.</span></a>
			</td>
		</tr>
        
        
        
        
        
        <!--<tr>
			<td class="hr">India Manager</font></td>
			<td><select name="lstSrIndiaManager">
					<option value="0">Select India Manager</option><?php
					foreach($objCallData->arrIndiaManager AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select India Manager for Task.</span></a>
			</td>
		</tr>-->

		<!--<tr>
			<td class="hr">Team Member</font></td>
			<td><select name="lstSrTeamMember">
            <option value="0">Select Team Member</option>
					<?php
					foreach($objCallData->arrEmployees AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select Team Member for Task.</span></a>
			</td>
		</tr>-->
        
        
        
		<tr>
			<td class="hr">Street Address</td>
			<td class="dr">
				<input type="text" name="street_adress" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Suburb</td>
			<td class="dr">
				<input type="text" name="suburb" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Suburban area of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">State<font style="color:red;" size="2">*</font></td>
			<td>
				<select name="state">
					<option value="">Select State</option><?php
					foreach($objCallData->arrStates AS $code => $state){
						?><option value="<?=$code?>"><?=$state?></option><?php 
					} 
				?></select>
			</td>
		</tr>
		<tr>
			<td class="hr">Post Code</td>
			<td class="dr">
				<input type="text" name="postcode" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Postcode of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Postal Address</td>
			<td class="dr">
				<textarea name="postal_address">&nbsp;</textarea>
			</td>
		</tr>
		<tr>
			<td class="hr">Main Contact Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="main_contact_name" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Main contact name of Lead.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Other Contact Name</td>
			<td class="dr">
				<input type="text" name="other_contact_name" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Alternate contact name of Lead.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Contact Phone No</td>
			<td class="dr">
				<input type="text" name="phone_no" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Alternate Phone No</td>
			<td class="dr">
				<input type="text" name="alternate_phone_no" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Fax Number</td>
			<td class="dr">
				<input type="text" name="fax" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Email</td>
			<td class="dr">
				<input type="text" name="email" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Date Received<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="date_received" id="date_received" value="">&nbsp;<a href="javascript:NewCal('date_received','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Lead received date.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Day Received</td>
			<td class="dr">
				<input type="text" name="day_received" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Industry</td>
			<td><select name="lead_industry">
					<option value="">Select Industry</option><?php
					foreach($objCallData->arrIndustry AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Industry of Lead.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Lead Status</td>
			<td><select name="lead_status" id="lead_status" onchange="showreason();">
					<option value="">Select Status</option><?php
					foreach($objCallData->arrStatus AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Status of Lead.</span></a>
			</td>
		</tr>
		
			<tr id="reasondiv" style="display:none;">
				<td class="hr">Reason<font style="color:red;" size="2">*</font></td>
				<td class="dr"><input type="text" name="lead_reason" value=""></td>
			</tr>
		<tr>
			<td class="hr">Lead Stage</td>
			<td><select name="lead_stage">
					<option value="">Select Stage</option><?php
					foreach($objCallData->arrStage AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Stage of Lead.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Lead Source</td>
			<td><select name="lead_source">
					<option value="">Select Source</option><?php
					foreach($objCallData->arrSource AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Source of Lead.</span></a>
			</td>
		</tr>
			
		<tr>
			<td class="hr">Sales Person<font style="color:red;" size="2">*</font></td>
			<td>
				<select name="sales_person">
					<option value="">Select Sales Person</option><?
					foreach($objCallData->arrSalesPerson AS $stfCode => $stfName){
						?><option value="<?=$stfCode?>"><?=$stfName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select name of sales person.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Last Date of Contact</td>
			<td class="dr">
				<input type="text" name="last_contact_date" id="last_contact_date" value="">&nbsp;<a href="javascript:NewCal('last_contact_date','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Last Contact Date.</span></a>
			</td>
		</tr>
		
		<tr>
			<td class="hr">Future Contact Date</td>
			<td class="dr">
				<input type="text" name="future_contact_date" id="future_contact_date" value="">&nbsp;<a href="javascript:NewCal('future_contact_date','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Future Contact Date.</span></a>
			</td>
		</tr>

		<tr>
			<td class="hr">Notes</td>
			<td class="dr">
				<textarea name="note">&nbsp;</textarea>
			</td>
		</tr>
		<tr>
			<td><button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Save" class="button">Save</button></td>
		</tr>
	</table>
</form>