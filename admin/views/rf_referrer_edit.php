<div class="frmheading">
	<h1>Edit Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>

<form action="rf_referrer.php" method="post" name="managereferrer" onSubmit="return validateFormOnSubmit()">
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
						if($typeId == $arrRefererData['type']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Type of Referrer.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Referrer Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="refName" maxlength="50" value="<?=$arrRefererData['name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Referrer.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">SR Manager<font style="color:red;" size="2">*</font></td>
			<td><select name="lstSrManager">
					<option value="">Select SR Manager</option><?php
					foreach($objCallData->arrSrManager AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrRefererData['sr_manager']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select senior manager for Referrer.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Street Address</td>
			<td class="dr">
				<input type="text" name="street_Address" value="<?=$arrRefererData['street_adress']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Suburb</td>
			<td class="dr">
				<input type="text" name="suburb" value="<?=$arrRefererData['suburb']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Suburban area of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">State<font style="color:red;" size="2">*</font></td>
			<td>
				<select name="lstState">
					<option value="">Select State</option><?php
					foreach($objCallData->arrStates AS $code => $state){
						$selectStr = '';
						if($code == $arrRefererData['state']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$code?>"><?=$state?></option><?php 
					} 
				?></select>
			</td>
		</tr>
		<tr>
			<td class="hr">Post Code</td>
			<td class="dr">
				<input type="text" name="postCode" value="<?=$arrRefererData['postcode']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Postcode of the city.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Postal Address</td>
			<td class="dr">
				<textarea name="postalAddress"><?=$arrRefererData['postal_address']?></textarea>
			</td>
		</tr>
		<tr>
			<td class="hr">Main Contact Name<font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="mainContactName" value="<?=$arrRefererData['main_contact_name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Main contact name of referrer.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Other Contact Name</td>
			<td class="dr">
				<input type="text" name="otherContactName" value="<?=$arrRefererData['other_contact_name']?>">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Alternate contact name of referrer.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Contact Phone No</td>
			<td class="dr">
				<input type="text" name="phoneNo" value="<?=$arrRefererData['phone_no']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Alternate Phone No</td>
			<td class="dr">
				<input type="text" name="altPhoneNo" value="<?=$arrRefererData['alternate_no']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Fax Number</td>
			<td class="dr">
				<input type="text" name="fax" value="<?=$arrRefererData['fax']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Email</td>
			<td class="dr">
				<input type="text" name="email" value="<?=$arrRefererData['email']?>">
			</td>
		</tr>
		<tr>
			<td class="hr">Date Signed Up<font style="color:red;" size="2">*</font></td>
			<td class="dr"><?
				$dateSignedUp = "";
				if (isset($arrRefererData["date_signed_up"]) && $arrRefererData["date_signed_up"] != "") {
					if($arrRefererData["date_signed_up"] != "0000-00-00 00:00:00") {
						$dateSignedUp = date("d/m/Y",strtotime( $arrRefererData["date_signed_up"]));
					}
				}  
				?><input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$dateSignedUp?>" onBlur="showDay()">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)">
				<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Referrer signed up date.</span></a>
			</td>
		</tr>
		<tr>
			<td class="hr">Agreed Services</td>
			<td class="dr"><?
				$arrServices = explode(',', $arrRefererData['agreed_services']);
				foreach($objCallData->arrServices AS $code => $description){
					$checkedStr = '';
					if(in_array($code, $arrServices)) $checkedStr = 'checked';
					?><input <?=$checkedStr?> class="checkboxClass" type="checkbox" name="service:<?=$code?>" id="<?=$description?>" /><label for="<?=$description?>"><?=$description?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Sent Items</td>
			<td class="dr"><?
				$arrItemsList = explode(',', $arrRefererData['sent_items']);
				foreach($objCallData->arrItemList AS $itemId => $itemName){
					$checkedStr = '';
					if(in_array($itemId, $arrItemsList)) $checkedStr = 'checked';
					?><input <?=$checkedStr?> class="checkboxClass" type="checkbox" name="item:<?=$itemId?>" id="<?=$itemName?>" /><label for="<?=$itemName?>"><?=$itemName?></label><br/><?
				}
			?></td>
		</tr>
		<tr>
			<td class="hr">Sales Person<font style="color:red;" size="2">*</font></td>
			<td>
				<select name="lstSalesPerson">
					<option value="">Select Sales Person</option><?php
					foreach($objCallData->arrSalesPerson AS $stfCode => $stfName){
						$selectStr = '';
						if($stfCode == $arrRefererData['sales_person']) $selectStr = 'selected';
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