<?php
include(TOPBAR);

?>

<div class="pageheader">
	<h1>Fund Details</h1>
	<span>
		<b>Welcome to the Super Records Fund Details page.</b>
	<span>
</div>
<div style="padding-top:20px;">
	<div style="padding-bottom:20px;">Please enter details of Fund you would like to set up.</div>
	
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
                <input type="hidden" id="fund_status" name="fund_status" value=""/>
		<div style="padding-top:20px;">
			<span align="left"><button type="button" onclick="window.location.href='existing_smsf_contact.php'" >BACK</button></span>
			<span align="right" style="padding-left:55px;"><button type="submit" id='btnNext'>SAVE & EXIT</button></span>
                        <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">SUBMIT</button></span>
		</div>
		<input type="hidden" name="doAction" value="addFundInfo">
                <input type="hidden" name="job_status" id="job_status" value="0">

	</form>
        <script>
            $('#btnNext').click(function(){$('#fund_status').val('0')})
            $('#btnSave').click(function(){$('#fund_status').val('1');$('#job_status').val('1')})
        </script>
</div><?

include(FOOTER);
?>