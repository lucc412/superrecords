<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>

<div class="pageheader" style="padding-bottom: 0;">
	<h1>Fund Details</h1>
	<span>
		<b>Welcome to the Super Records fund details page.</b>
	<span>
</div>
<div>
	<div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your fund. These details will be used to set up the fund in our system. If you need any help completing this section, please contact us.</div>
	
	<form method="post" action="existing_smsf_fund.php" name="frmexstsmsffund" onsubmit="return formValidation();">
		<table class="fieldtable">
			<tr>
				<td>Fund Name</td>
				<td><input type="text" name="txtFund" value="<?=$fundName?>" />
				<a id="iconQuestion" class="tooltip" title="Please enter the name of your SMSF.">?</a>
				</td>
			</tr>
			<tr>
				<td>Fund ABN</td>
				<td><input type="text" name="txtAbn" value="<?=$abn?>" />
				<a id="iconQuestion" class="tooltip" title="Please enter the ABN of your SMSF.">?</a>
				</td>
			</tr>
			<tr>
				<td>Street Address</td>
				<td><textarea name="taStreetAdd" style="margin-bottom: 5px;"/><?=$streetAdd?></textarea></td>
			</tr>
			<tr>
				<td>Postal Address</td>
				<td><textarea name="taPostalAdd" style="margin-bottom: 5px;"/><?=$postalAdd?></textarea></td>
			</tr>
			<tr>
				<td>How many members?</td>
				<td>
					<select name="lstMembers" style="width: auto;margin-bottom: 5px;">
                       <option value="">Select no of members</option><?
						foreach($arrNoOfMembers AS $noOfMembers) {
							$selectedStr = "";
							if($members == $noOfMembers) $selectedStr = "selected='selected'";
							?><option value="<?=$noOfMembers?>" <?=$selectedStr?> ><?=$noOfMembers?></option><?
						}
					?></select>
					<a id="iconQuestion" class="tooltip" title="Select how many members in your SMSF.">?</a>
				</td>
			</tr>
			<tr>
				<td>Trustee Type</td>
				<td>
					<select name="lstTrustee">
						<option value="">Select Trustee type</option><?
						foreach($arrTrusteeType AS $trusteeTypeId => $trusteeTypeName) {
							$selectedStr = "";
							if($trusteeType == $trusteeTypeId) $selectedStr = "selected='selected'";
							?><option <?=$selectedStr?> value="<?=$trusteeTypeId?>"><?=$trusteeTypeName?></option><?
						}
					?></select>
					<a id="iconQuestion" class="tooltip" title="Select whether you have individuals as trustees or a Corporate trustee.">?</a>
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
                <input type="hidden" name="job_submitted" id="job_submitted" value="N">

	</form>
        <script>
            $('#btnNext').click(function(){$('#fund_status').val('0')})
            $('#btnSave').click(function(){$('#fund_status').val('1');$('#job_submitted').val('Y')})
        </script>
</div><?

include(FOOTER);
?>