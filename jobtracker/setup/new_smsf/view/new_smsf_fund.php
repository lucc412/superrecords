<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Fund Details</h1>
	<span>
		<b>Welcome to the Super Records fund details page.</b>
	<span>
</div>
<div >
	<div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your new fund. These details will be used to register the fund. If you need any help completing this section, please contact us.</div>
	
	<form method="post" name="frmnewsmsffund" action="new_smsf_fund.php" onsubmit="return formValidation()">
		<table class="fieldtable">
			<tr>
				<td>Fund Name</td>
				<td><input type="text" name="txtFund" value="<?=$fundName?>" />
				<a id="iconQuestion" class="tooltip" title="Please enter the name you would like to use for your new SMSF">?</a>
				</td>
			</tr>
			<tr>
				<td>Street Address</td>
				<td>
                                    <div>
                                        <input type="text" name="StrAddUnit" style="width:115px;" value="<?=$StrAddUnit?>" placeholder="Unit number" />
                                        <input type="text" name="StrAddBuild" style="width:115px;" value="<?=$StrAddBuild?>" placeholder="Building" />
                                        <input type="text" name="StrAddStreet" style="width:115px;" value="<?=$StrAddStreet?>" placeholder="Street"/><br>
                                        <input type="text" name="StrAddSubrb" style="width:115px;" value="<?=$StrAddSubrb?>" placeholder="Suburb"/>
                                        <select name="StrAddState" style="margin-bottom: 5px;width:135px;" >
                                            <option value="0">Select State</option>
                                            <?php foreach($arrStates AS $stateKey => $stateName) {
							$selectStr = '';
							if($StrAddState == $stateKey) $selectStr = 'selected';
							?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
						}
                                            ?>
                                        </select><br>
                                        <input type="text" name="StrAddPstCode" style="width:115px;" value="<?=$StrAddPstCode?>" placeholder="Post Code"/>
                                        <select name="StrAddCntry" style="margin-bottom: 5px;width:135px;" >
                                            <option value="0">Select Country</option>
                                            <?php foreach($arrCountry AS $countryId => $countryName) {
                                                        $selectStr = "";
                                                        var_dump($StrAddCntry);
                                                        if($StrAddCntry == $countryId) 
                                                            $selectStr = "selected";
                                                        else if ($countryId == 9 && $StrAddCntry == 0)
                                                            $selectStr = "selected";
                                                        ?><option <?=$selectStr?> value="<?=$countryId?>"><?=$countryName?></option><?
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </td>
			</tr>
			<tr>
				<td>Postal Address</td>
				<td><input type="text" name="taPostalAdd" value="<?=$postalAdd?>" /></td>
			</tr>
			<tr>
				<td>Date of establishment </td>
				<td>
					<input type="text" style="width:70px" id="txtSetupDate" readonly="true" name="txtSetupDate" size="10" value="<?
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
                                        else {
                                            $regDate=date("d/m/Y");
                                        }
					echo($regDate);
					?>"/><img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtSetupDate','ddMMyyyy')" align="middle" class="calendar"/>
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
							?><option value="<?=$noOfMembers?>" <?=$selectStr?> ><?=$noOfMembers?></option><?
						}
					?></select>
					<a id="iconQuestion" class="tooltip" title="A SMSF is limited to a maximum of four members">?</a>
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
					<a id="iconQuestion" class="tooltip" title="Select whether you wish to have individuals as trustees or whether you need a corporate trustee. <br/>Please note if there is only one member a corporate trustee is required.">?</a>
				</td>
			</tr>
		</table>
            <div class="txtAboveButton">To learn more about the differences between Individual and Corporate Trustees please click to <a href='new_smsf_fund.php?do=download' onclick="javascript:windows.location.assign('new_smsf_fund.php?do=download')" target="_new" style="color: #F05729;">download guide.</a></div>
                <input type="hidden" id="fund_status" name="fund_status" value=""/>
		<div style="padding-top:20px;">
                    <span align="left"><button type="button" onclick="window.location.href='new_smsf_contact.php'" >Back</button></span>
			<span align="right" style="padding-left:55px;"><button type="submit" id='btnNext'>Next</button></span>
                        <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">Save & Exit</button></span>
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