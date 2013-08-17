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
	<div style="padding-bottom:20px;">Please enter your contact details. If there are any issues with this application, we will contact you using these details. Once your fund is set up, we will also contact you using these details to guide you through the next stages of the process.</div>
	
	<form method="post" name="frmnewsmsffund" action="new_smsf_fund.php" onsubmit="return formValidation()">
		<table>
			<tr>
				<td>Fund Name</td>
				<td><input type="text" name="txtFund" value="<?=$fundName?>" />
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Please enter the name you would like to use for your new SMSF</span></a>
				</td>
			</tr>
			<tr>
				<td>Street Address</td>
				<td><textarea name="taStreetAdd" style="margin-bottom: 5px;"/><?=$streetAdd?></textarea></td>
			</tr>
			<tr>
				<td>Postal Address</td>
				<td><textarea name="taPostalAdd" style="margin-bottom: 5px;" /><?=$postalAdd?></textarea></td>
			</tr>
			<tr>
				<td>Date of establishment </td>
				<td>
					<input type="text" id="txtSetupDate" readonly="true" name="txtSetupDate" size="10" value="<?
					if(isset($regDate) && $regDate != "") {
						if($regDate != "0000-00-00") {
							if($regDate == '1970-01-01') 
								$regDate = '';
							else
								$regDate = date("d/m/Y",strtotime($regDate));
						}
						else{
							$regDate='';
						}
					}  
					echo($regDate);
					?>"/><img src="images/calendar.png" id="calImgId" onclick="javascript:NewCssCal('txtSetupDate','ddMMyyyy')" align="middle" style="cursor:pointer"/>
				</td>
			</tr>
			<tr>
				<td>State of registration</td>
				<td>
					<select name="lstRegState" style="margin-bottom: 5px;"><?
						foreach($arrStates AS $stateKey => $stateName) {
							$selectStr = '';
							if($regState == $stateKey) $selectStr = 'selected';
							?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
						}
					?></select>
				</td>
			</tr>

			<tr>
				<td>How many members?</td>
				<td>
                                    <select name="lstMembers" style="width: auto;margin-bottom: 5px;">
						<option value="">Select no of members</option><?
						foreach($arrNoOfMembers AS $noOfMembers) {
							$selectStr = "";
							if($members == $noOfMembers) $selectStr = "selected";
							?><option <?=$selectStr?> ><?=$noOfMembers?></option><?
						}
					?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">A SMSF is limited to a maximum of four members</span></a>
				</td>
			</tr>
			<tr>
				<td>Trustee Type</td>
				<td>
					<select name="lstTrustee" style="margin-bottom: 5px;">
						<option value="">Select Trustee type</option><?
						foreach($arrTrusteeType AS $trusteeTypeId => $trusteeTypeName) {
							$selectStr = "";
							if($trusteeType == $trusteeTypeId) $selectStr = "selected";
							?><option <?=$selectStr?> value="<?=$trusteeTypeId?>"><?=$trusteeTypeName?></option><?
						}
					?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Select whether you wish to have individuals as trustees or whether you need a corporate trustee. Please note if there is only one member a corporate trustee is required.</span></a>
				</td>
			</tr>
		</table>
		<div style="padding-top:20px;font-weight:bold;">To learn more about the differences between Individual and Corporate Trustees please read our <a href="#" onclick="javascript:popUp('docs/guide.html');">guide.</a></div>
                <input type="hidden" id="fund_status" name="fund_status" value=""/>
		<div style="padding-top:20px;">
                    <span align="left"><button type="button" onclick="window.location.href='new_smsf_contact.php'" >BACK</button></span>
			<span align="right" style="padding-left:55px;"><button type="submit" id='btnNext'>NEXT</button></span>
                        <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">SAVE & EXIT</button></span>
		</div>
		<input type="hidden" name="doAction" value="addFundInfo">

	</form>
        <script>
            $('#btnNext').click(function(){$('#fund_status').val('0')})
            $('#btnSave').click(function(){$('#fund_status').val('1')})
        </script>
</div><?

include(FOOTER);
?>