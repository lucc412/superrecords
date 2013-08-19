<?php
include(TOPBAR);

?>
<div class="pageheader">
	<h1>Contact Details</h1>
	<span>
		<b>Welcome to the Super Records Contact Details page.</b>
	<span>
</div>
<div style="padding-top:20px;">
	<div style="padding-bottom:20px;">Please enter your contact details. If there are any issues with this application, we will contact you using these details. Once your fund is set up, we will also contact you using these details to guide you through the next stages of the process.</div>
	
	<form method="post" action="existing_smsf_contact.php" name="frmexstsmsfcont" onsubmit="return formValidation();">
		<table>
			<tr>
				<td>First Name</td>
				<td><input type="text" name="txtFname" value="<?=$fname?>" /></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input type="text" name="txtLname" value="<?=$lname?>" /></td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td><input type="text" name="txtEmail" value="<?=$email?>" /></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td><input type="text" name="txtPhone" value="<?=$phoneno?>" /></td>
			</tr>
			<tr>
				<td>State</td>
				<td>
					<select name="lstState"><?
						foreach($arrStates AS $stateIdKey => $stateName) {
							$selectedStr = "";
							if($stateId == $stateIdKey) $selectedStr = "selected='selected'";
							?><option <?=$selectedStr?> value="<?=$stateIdKey?>"><?=$stateName?></option><?
						}
					?></select>
				</td>
			</tr>
			<tr>
				<td>Referral Code</td>
				<td><input type="text" name="txtCode" value="<?=$refCode?>" maxlength="6"/>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">If someone has referred you and has provided a referral code, please enter the code here.</span></a>
				<? if(isset($flaginvalid)){
   				   ?><span id="msg" style="padding-left:10px;color:red">Please enter a valid referral code</span><? 
				}?>
				</td>
			</tr>
		</table>
                <input type="hidden" id="cont_status" name="cont_status" value=""/>
                <div style="padding-top:20px;">
                <span align="left"><button type="button" onclick="window.location.href='existing_smsf.php'" value="BACK" />BACK</button></span>
                <span align="right" style="padding-left:55px;"><button type="submit" id="btnNext">NEXT</button></span>
                <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">SAVE & EXIT</button></span>
            </div>
		
		<input type="hidden" name="flaginit" value="">
                 <script>
            $('#btnNext').click(function(){$('#cont_status').val('0')})
            $('#btnSave').click(function(){$('#cont_status').val('1')})
        </script>
	</form> 
	
</div>
<?php
	include(FOOTER);
?>