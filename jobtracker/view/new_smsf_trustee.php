<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Trustee Details</h1>
	<span>
		<b>Welcome to the Super Records Trustee Details page.</b>
	<span>
</div>
<div >
	

	<input type="hidden" name="trustyType" id="trustyType" value="<?php echo($_SESSION['TRUSTEETYPE'])?>"/><?

	// Form display for New Corporate Trustee 
	if($_SESSION['TRUSTEETYPE'] == '2') {

		?><div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details to set up your new corporate trustee. These details will be used to register the corporate trustee. If you need any help completing this section, please contact us.</div>
		<span style="color:#0c436c"><u><b>New Corporate Trustee Details</b></u><span>
		<form method="post" action="new_smsf_trustee.php" name="frmnewsmsftrustee" onsubmit="return formValidation()">
		
			<table class="fieldtable">
				<tr>
					<td>Preferred Company Name</td>
					<td><input type="text" name="txtCname" value="<?=$cname?>" />
					<a id="iconQuestion" class="tooltip" title="Please provide three options for your company name. A company name is required <br/>to be unique, so if your selected name is taken we will use one of your other options.">?</a>
					</td>
				</tr>
				<tr>
					<td>Alternative Name Option 1</td>
					<td><input type="text" name="txtName1" value="<?=$altOption1?>" /></td>
				</tr>
				<tr>
					<td>Alternative Name Option 2</td>
					<td><input type="text" name="txtName2" value="<?=$altOption2?>" /></td>
				</tr>
				<tr>
					<td>Registered Office Address</td>
					<td><input type="text" name="txtRegAddress" value="<?=$regAdd?>" />
					<a id="iconQuestion" class="tooltip" title="Provide the address for any notices to be sent at.">?</a>
					</td>
				</tr>
				<tr>
					<td>Principal Place of Business</td>
					<td><input type="text" name="txtPriAddress" value="<?=$priBusiness?>" />
					<a id="iconQuestion" class="tooltip" title="This cannot be a PO Box.">?</a>
					</td>
				</tr>
			</table>
                        <input type="hidden" id="newTrust_status" name="newTrust_status" value=""/>
			<div style="padding-top:20px;">
        <span align="left"><button type="button" onclick="window.location.href='<?php if(count($arrLegRef)>0){echo 'legal_references.php';}else { echo 'new_smsf_member.php';} ?> '" >BACK</button></span>
                            <span align="right" style="padding-left:55px;"><button type="submit" id="btnNext" >NEXT</button></span>
                            <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave" >SAVE & EXIT</button></span>
			</div>
			<input type="hidden" name="doAction" value="addNewTrusteeInfo">
                        <script>
                            $('#btnNext').click(function(){$('#newTrust_status').val('0')})
                            $('#btnSave').click(function(){$('#newTrust_status').val('1')})
                        </script>

		</form><?
	}

	// Form display for Existing Corporate Trustee
	if($_SESSION['TRUSTEETYPE'] == '3') {
		?> <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details of the company you have to act as your corporate trustee. If you need any help completing this section, please contact us.</div>
           <span style="color:#0c436c"><u><b>Existing Corporate Trustee Details</b></u><span>
			
		<form method="post" action="new_smsf_trustee.php" name="frmnewsmsftrustee" onsubmit="return formValidation()">
		
			<table class="fieldtable">
				<tr>
					<td>Company Name</td>
					<td><input type="text" name="txtCname" value="<?=$cname?>" /></td>
				</tr>
				<tr>
					<td>Company A.C.N</td>
					<td><input type="text" name="txtAcn" value="<?=$acn?>" /></td>
				</tr>
				<tr>
					<td>Company A.B.N</td>
					<td><input type="text" name="txtAbn" value="<?=$abn?>" /></td>
				</tr>
				<tr>
					<td>Company T.F.N</td>
					<td><input type="text" name="txtTfn" value="<?=$tfn?>" /></td>
				</tr>
				<tr>
					<td>Registered Office Address</td>
					<td><input type="text" name="txtRegAddress" value="<?=$regAdd?>" />
					<a id="iconQuestion" class="tooltip" title="Provide the address for any notices to be sent at.">?</a>
					</td>
				</tr>
				<tr>
					<td>Principal Place of Business</td>
					<td><input type="text" name="txtPriAddress" value="<?=$priBusiness?>" />
					<a id="iconQuestion" class="tooltip" title="This cannot be a PO Box.">?</a>
					</td>
				</tr>
				<tr>
					<td>Are all proposed members of the Superfund are directors of the company ?</td>
					<td>
						<select name="lstQuestion" id="lstQuestion" onchange="javascript:yes_no();"><?
							foreach($arrYesNo AS $option) {
								$selectStr = "";
								if($memberType == $option) $selectStr = "selected";
								?><option <?=$selectStr?> ><?=$option?></option><?
							}
						?></select>
						<a id="iconQuestion" class="tooltip" title="Each member of the fund is required to be a director of the company.">?</a>
					</td>
				</tr>
			</table>
            <input type="hidden" id="extTrust_status" name="extTrust_status" value=""/>
			<div style="padding-top:20px;">
               <span align="left"><button type="button" onclick="window.location.href='<?php if(count($arrLegRef)>0){echo 'legal_references.php';}else { echo 'new_smsf_member.php';} ?>'" >BACK</button></span>
               <span align="right" style="padding-left:55px;"><button type="submit" id="btnNext" >NEXT</button></span>
				<span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">SAVE & EXIT</button></span>
            </div>
		<input type="hidden" name="doAction" value="addExsTrusteeInfo">
        <script>
            $('#btnNext').click(function(){$('#extTrust_status').val('0')})
            $('#btnSave').click(function(){$('#extTrust_status').val('1')})
        </script>
		</form><?
	}
?></div><?

include(FOOTER);
?>