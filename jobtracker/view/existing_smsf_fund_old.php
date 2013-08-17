<?php
include(TOPBAR1);

?><div style="padding-top:20px;">
	<div style="padding-bottom:20px;">Please enter your contact details. If there are any issues with this application, we will contact you using these details. Once your fund is set up, we will also contact you using these details to guide you through the next stages of the process.</div>
	
	<form method="post" action="existing_smsf_fund.php" name="frmexstsmsffund" onsubmit="return formValidation();">
		<table>
			<tr>
				<td>Fund Name</td>
				<td><input type="text" name="txtFund" value="<?=$fundName?>" />
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Please enter the name of your SMSF</span></a>
				</td>
			</tr>
			<tr>
				<td>Fund ABN</td>
				<td><input type="text" name="txtAbn" value="<?=$abn?>" />
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Please enter the ABN of your SMSF</span></a>
				</td>
			</tr>
			<tr>
				<td>Street Address</td>
				<td><textarea name="taStreetAdd" /><?=$streetAdd?></textarea></td>
			</tr>
			<tr>
				<td>Postal Address</td>
				<td><textarea name="taPostalAdd" /><?=$postalAdd?></textarea></td>
			</tr>
			<tr>
				<td>How many members?</td>
				<td>
					<select name="lstMembers"><?
						foreach($arrNoOfMembers AS $noOfMembers) {
							$selectedStr = "";
							if($members == $noOfMembers) $selectedStr = "selected='selected'";
							?><option <?=$selectedStr?> ><?=$noOfMembers?></option><?
						}
					?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select how many members in your SMSF</span></a>
				</td>
			</tr>
			<tr>
				<td>Trustee Type</td>
				<td>
					<select name="lstTrustee"><?
						foreach($arrTrusteeType AS $trusteeTypeId => $trusteeTypeName) {
							$selectedStr = "";
							if($trusteeType == $trusteeTypeId) $selectedStr = "selected='selected'";
							?><option <?=$selectedStr?> value="<?=$trusteeTypeId?>"><?=$trusteeTypeName?></option><?
						}
					?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select whether you have individuals as trustees or a Corporate trustee.</span></a>
				</td>
			</tr>
		</table>
		<div style="padding-top:20px;font-weight:bold;">To learn more about the differences between Individual and Corporate Trustees please read our <a href="existing_smsf_fund.php?doAction=download">guide.</a></div>

		<div style="padding-top:20px;">
			<span align="left"><input type="button" onclick="window.location.href='existing_smsf_contact.php'" value="BACK" /></span>
			<span style="padding-left:1000px;" align="right"><input type="submit" value="NEXT" /></span>
		</div>
		<input type="hidden" name="doAction" value="addFundInfo">

	</form>
</div><?

include(FOOTER);
?>