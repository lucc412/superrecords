<div class="frmheading">
	<h1>Add Record</h1>
</div>
<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif;padding-right:92px" size="2">Fields marked with * are mandatory</font></div><?

// error message
if(!empty($_REQUEST['flagErrMsg'])) {
	?><div class="errorMsg"><?=ERRORICON?>&nbsp;Sorry, the email address is already registered.</div><?	
}

?><form action="pr_practice.php" method="POST" name="managepractice" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="insert"></p>
	<table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Practice</td>
			<td class="dr">New</td>
		</tr>
		<tr>
			<td class="hr">Type<font style="color:red;" size="2">*</font></td>
			<td class="dr"><select name="lstType">
					<option value="">Select Type</option><?php
					foreach($objCallData->arrTypes AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Type of Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="refName" maxlength="50" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Street Address</td>
			<td class="dr">
				<input type="text" name="street_Address" value="">
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
			<td class="dr">
				<select name="lstState" id="lstState">
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
				<input type="text" name="postCode" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Postcode of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Postal Address</td>
			<td class="dr">
				<textarea name="postalAddress">&nbsp;</textarea>
			</td>
		</tr>
		<tr>
			<td class="hr">Main Contact Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="mainContactName" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Main contact name of practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Other Contact Name</td>
			<td class="dr">
				<input type="text" name="otherContactName" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Alternate contact name of practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Contact Phone No</td>
			<td class="dr">
				<input type="text" name="phoneNo" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Alternate Phone No</td>
			<td class="dr">
				<input type="text" name="altPhoneNo" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Fax Number</td>
			<td class="dr">
				<input type="text" name="fax" value="">
	 		</td>
		</tr>
		<tr>
			<td class="hr">Email Address<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				
				<input type="text" name="email" id="uname">
				
			</td>
		</tr>
		<tr>
			<td class="hr">Password<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="password" id="password" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Practice Software</td>
			<td class="dr">
				<input type="text" name="software" maxlength="255" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice Software.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Agreed Services<font style="color:red;" size="2">*</font></td>
			<td class="dr"><?
				foreach($objCallData->arrServices AS $code => $description){
					?><input type="checkbox" class="checkboxClass" name="service:<?=$code?>" id="<?=$description?>" /><label for="<?=$description?>"><?=$description?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Compliance Jobs Projected</td>
			<td class="dr">
				<input type="text" name="comp_projected" maxlength="255" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">Audit Only Jobs Projected</td>
			<td class="dr">
				<input type="text" name="audit_projected" maxlength="255" value="">
			</td>
		</tr>
		<tr>
			<td class="hr">SR Manager<font style="color:red;" size="2">*</font></td>
			<td class="dr"><select name="lstSrManager">
					<option value="">Select SR Manager</option><?php
					foreach($objCallData->arrSrManager AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select senior manager.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Manager Comp</td>
			<td class="dr"><select name="lstManager">
					<option value="">Select Manager Comp</option><?php
					foreach($objCallData->arrInManager AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select compliance manager.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Manager Audit</td>
			<td class="dr"><select name="lstAuditManager">
					<option value="">Select Manager Audit</option><?php
					foreach($objCallData->arrAuditMngr AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select audit manager.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Sales Person<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<select name="lstSalesPerson">
					<option value="">Select Sales Person</option><?
					foreach($objCallData->arrSalesPerson AS $stfCode => $stfName){
						?><option value="<?=$stfCode?>"><?=$stfName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select name of sales person.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Date Signed Up<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="dateSignedUp" id="dateSignedUp" value="">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Practice signed up date.</span></a>
			</td>
		</tr>
		<!--<tr>
			<td class="hr">Sent Items</td>
			<td class="dr"><?
				foreach($objCallData->arrItemList AS $itemId => $itemName){
					?><input type="checkbox" class="checkboxClass" name="item:<?=$itemId?>" id="<?=$itemName?>" /><label for="<?=$itemName?>"><?=$itemName?></label><br/><?
				}
			?></td>
		</tr>-->
	<tr>
		<td>
			<button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button></td>
		<td>
			<button type="submit" name="action" id="saveBtn" value="Save">Save</button>
		</td>
	</tr>
</table>
</form><?