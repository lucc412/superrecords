<div class="frmheading">
	<h1>Edit Record</h1>
</div>
<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form action="pr_practice.php" method="post" name="managepractice" onSubmit="return validateFormOnSubmit()">
	<p><input type="hidden" name="sql" value="update"></p>
	<input type="hidden" name="recid" value="<?=$recid?>">
	<input type="hidden" name="a" value="edit">
	<table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Type<font style="color:red;" size="2">*</font></td>
			<td><select name="lstType">
					<option value="">Select Type</option><?php
					foreach($objCallData->arrTypes AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrPracticeData['type']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Type of Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="refName" maxlength="50" value="<?=$arrPracticeData['name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">SR Manager<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrManager">
					<option value="">Select SR Manager</option><?php
					foreach($objCallData->arrSrManager AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrPracticeData['sr_manager']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select senior manager for Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">India Manager</td>
			<td><select name="lstManager">
					<option value="">Select India Manager</option><?php
					foreach($objCallData->arrInManager AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrPracticeData['india_manager']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select india manager for Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Team Member</td>
			<td><select name="lstMember">
					<option value="">Select Team Member</option><?php
					foreach($objCallData->arrTeamMember AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrPracticeData['team_member']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select team member for Practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Street Address</td>
			<td class="dr">
				<input type="text" name="street_Address" value="<?=$arrPracticeData['street_adress']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Suburb</td>
			<td class="dr">
				<input type="text" name="suburb" value="<?=$arrPracticeData['suburb']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Suburban area of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">State<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<select name="lstState">
					<option value="">Select State</option><?php
					foreach($objCallData->arrStates AS $code => $state){
						$selectStr = '';
						if($code == $arrPracticeData['state']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$code?>"><?=$state?></option><?php 
					} 
				?></select>
			</td>
		</tr>
		<tr>
			<td class="hr">Post Code</td>
			<td class="dr">
				<input type="text" name="postCode" value="<?=$arrPracticeData['postcode']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Postcode of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Postal Address</td>
			<td class="dr">
				<textarea name="postalAddress"><?=$arrPracticeData['postal_address']?></textarea>
			</td>
		</tr>
		<tr>
			<td class="hr">Main Contact Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="mainContactName" value="<?=$arrPracticeData['main_contact_name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Main contact name of practice.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Other Contact Name</td>
			<td class="dr">
				<input type="text" name="otherContactName" value="<?=$arrPracticeData['other_contact_name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Alternate contact name of practice.</span></a>
			</td>
		</tr>
		<tr>
	 		<td class="hr">Contact Phone No</td>
			<td class="dr">
				<input type="text" name="phoneNo" value="<?=$arrPracticeData['phone_no']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Alternate Phone No</td>
			<td class="dr">
				<input type="text" name="altPhoneNo" value="<?=$arrPracticeData['alternate_no']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Fax Number</td>
			<td class="dr">
				<input type="text" name="fax" value="<?=$arrPracticeData['fax']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Email (User Name)<font style="color:red;" size="2">*</font></td>
			
		
			<td class="dr">
				<input type="text" name="email" value="<?=$arrPracticeData['email']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Password<font style="color:red;" size="2">*</font></td>
			
			<td class="dr">
				<input type="text" name="password" value="<?=$arrPracticeData['password']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Date Signed Up<font style="color:red;" size="2">*</font></td>
			<td class="dr"><?
				$dateSignedUp = "";
				if (isset($arrPracticeData["date_signed_up"]) && $arrPracticeData["date_signed_up"] != "") {
					if($arrPracticeData["date_signed_up"] != "0000-00-00 00:00:00") {
						$dateSignedUp = date("d/m/Y",strtotime( $arrPracticeData["date_signed_up"]));
					}
				}  
				?><input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$dateSignedUp?>" onBlur="showDay()">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Referral signed up date.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Agreed Services</td>
			<td class="dr"><?
				$arrServices = explode(',', $arrPracticeData['agreed_services']);
				foreach($objCallData->arrServices AS $code => $description){
					$checkedStr = '';
					if(in_array($code, $arrServices)) $checkedStr = 'checked';
					?><input <?=$checkedStr?> type="checkbox" class="checkboxClass" name="service:<?=$code?>" id="<?=$description?>" /><label for="<?=$description?>"><?=$description?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Sent Items</td>
			<td class="dr"><?
				$arrItemsList = explode(',', $arrPracticeData['sent_items']);
				foreach($objCallData->arrItemList AS $itemId => $itemName){
					$checkedStr = '';
					if(in_array($itemId, $arrItemsList)) $checkedStr = 'checked';
					?><input <?=$checkedStr?> type="checkbox" class="checkboxClass" name="item:<?=$itemId?>" id="<?=$itemName?>" /><label for="<?=$itemName?>"><?=$itemName?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Sales Person<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<select name="lstSalesPerson">
					<option value="">Select Sales Person</option><?php
					foreach($objCallData->arrSalesPerson AS $stfCode => $stfName){
						$selectStr = '';
						if($stfCode == $arrPracticeData['sales_person']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$stfCode?>"><?=$stfName?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select name of sales person.</span></a>
			</td>
		</tr>
		
		<tr>
			<td>
				<button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
			</td>
			<td>
				<button type="submit" name="action" value="Update" class="button">Update</button>
			</td>
		</tr>
	</table>
</form><?