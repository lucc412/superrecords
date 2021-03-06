<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>
<div class="pageheader" style="padding-bottom: 0">
	<h1>Member Details</h1>
	<span>
		<b>Welcome to the Super Records member details page.</b>
	<span>
</div>
<div>
	<div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for each member of the new fund. These details will be used to register the fund. If you need any help completing this section, please contact us.</div><?

	// show member form as per no of members
	?><form method="post" action="new_smsf_member.php" name="frmnewsmsfmember" onsubmit="return formValidation(<?=$_SESSION['NOOFMEMBERS']?>)"><?
                $legalRef = 0;
		for($memberCount=1; $memberCount <= $_SESSION['NOOFMEMBERS']; $memberCount++) {

			$memberId = "";
			$title = "";
			$fname = "";
			$mname = "";
			$lname = "";
			$dob = "";
			$city = "";
			$country = "";
			$gender = "";
			$StrAddUnit = "";
                        $StrAddBuild = "";
                        $StrAddStreet = "";
                        $StrAddSubrb = "";
                        $StrAddState = "";
                        $StrAddPstCode = "";
                        $StrAddCntry = "";
			$tfn = "";
			$occupation = "";
			$contactNo = "";
                        
			if(!empty($arrData)) {
				if(isset($arrData[$memberCount])) {
                                    $arrMemberInfo = $arrData[$memberCount];
                                    
                                    $memberId = $arrMemberInfo['member_id'];
                                    $title = $arrMemberInfo['title'];
                                    $fname = $arrMemberInfo['fname'];
                                    $mname = $arrMemberInfo['mname'];
                                    $lname = $arrMemberInfo['lname'];
                                    $dob = $arrMemberInfo['dob'];
                                    $city = $arrMemberInfo['city'];
                                    $country = $arrMemberInfo['country_id'];
                                    $gender = $arrMemberInfo['gender'];
                                    $address = $arrMemberInfo['address'];
                                    $tfn = $arrMemberInfo['tfn'];
                                    $occupation = $arrMemberInfo['occupation'];
                                    $contactNo = $arrMemberInfo['contact_no'];
                                    $StrAddUnit = $arrMemberInfo['strAddUnit'];
                                    $StrAddBuild = $arrMemberInfo['strAddBuild'];
                                    $StrAddStreet = $arrMemberInfo['strAddStreet'];
                                    $StrAddSubrb = $arrMemberInfo['strAddSubrb'];
                                    $StrAddState = $arrMemberInfo['strAddState'];
                                    $StrAddPstCode = $arrMemberInfo['strAddPstCode'];
                                    $StrAddCntry = $arrMemberInfo['strAddCntry'];
                                    
                                    
                                    
				}
			}
			
			?><span style="color:#0c436c"><u><b>Member <?=$memberCount?></b></u></span>
			<table class="fieldtable">
				<tr>
					<td>Title</td>
					<td>
						<select name="lstTitle<?=$memberCount?>" style="margin-bottom: 5px;"><?
							foreach($arrTitle AS $titleName) {
								$selectStr = "";
								if($title == $titleName) $selectStr = "selected";
								?><option <?=$selectStr?> ><?=$titleName?></option><?
							}
						?></select>
					</td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><input type="text" id="txtFname<?=$memberCount?>" name="txtFname<?=$memberCount?>" value="<?=$fname?>" /></td>
				</tr>
				<tr>
					<td>Middle Name</td>
					<td><input type="text" id="txtMname<?=$memberCount?>" name="txtMname<?=$memberCount?>" value="<?=$mname?>" /></td>
				</tr>
				<tr>
					<td>Surname</td>
					<td><input type="text" id="txtLname<?=$memberCount?>" name="txtLname<?=$memberCount?>" value="<?=$lname?>" /></td>
				</tr>
				<tr>
					<td>Date of Birth</td>
					<td>
                                            <script> var refVal = 0; </script>
						<input type="text" style="width:70px" id="txtDob<?=$memberCount?>" readonly="true" name="txtDob<?=$memberCount?>" size="10" value="<?
						if(isset($dob) && $dob != "") {
                                                    if($dob != "0000-00-00") {
                                                        if($dob == '1970-01-01') $dob = '';
                                                    }
                                                    else{
                                                            $dob='';
                                                    }
						}  
						echo($dob);
                                                ?>" />
                                                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob<?=$memberCount?>','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/>
                                                
					</td>
				</tr>
				<tr>
					<td>City of Birth</td>
					<td><input type="text" id="txtCity<?=$memberCount?>" name="txtCity<?=$memberCount?>" value="<?=$city?>" /></td>
				</tr>
				<tr>
					<td>Country of Birth</td>
					<td>
						<select name="lstCountry<?=$memberCount?>" style="margin-bottom: 5px;"><?
							foreach($arrCountry AS $countryId => $countryName) {
								$selectStr = "";
								if($country == $countryId) $selectStr = "selected";
                                                                else if ($countryId == 9 && $country == 0)
                                                                    $selectStr = "selected";
								?><option <?=$selectStr?> value="<?=$countryId?>"><?=$countryName?></option><?
							}
						?></select>
					</td>
				</tr>
				<tr>
					<td>Sex</td>
					<td>
						<select name="lstGender<?=$memberCount?>" style="margin-bottom: 5px;"><?
							foreach($arrGender AS $genderName) {
								$selectStr = "";
								if($gender == $genderName) $selectStr = "selected";
								?><option <?=$selectStr?> ><?=$genderName?></option><?
							}
						?></select>
					</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>
                                            
<!--                                            <textarea id="txtAddress<?=$memberCount?>" name="txtAddress<?=$memberCount?>" style="margin-bottom: 5px;" /><?=$address?></textarea>-->
                                            <div>
                                                <input type="text" id="StrAddUnit<?=$memberCount?>" name="StrAddUnit<?=$memberCount?>" style="width:115px;" value="<?=$StrAddUnit?>" placeholder="Unit number" />
                                                <input type="text" id="StrAddBuild<?=$memberCount?>" name="StrAddBuild<?=$memberCount?>" style="width:115px;" value="<?=$StrAddBuild?>" placeholder="Building" />
                                                <input type="text" id="StrAddStreet<?=$memberCount?>" name="StrAddStreet<?=$memberCount?>" style="width:115px;" value="<?=$StrAddStreet?>" placeholder="Street"/><br>
                                                <input type="text" id="StrAddSubrb<?=$memberCount?>" name="StrAddSubrb<?=$memberCount?>" style="width:115px;" value="<?=$StrAddSubrb?>" placeholder="Suburb"/>
                                                <select id="StrAddState<?=$memberCount?>" name="StrAddState<?=$memberCount?>" style="margin-bottom: 5px;width:135px;" >
                                                    <option value="0">Select State</option>
                                                    <?php foreach($arrStates AS $stateKey => $stateName) {
                                                                $selectStr = '';
                                                                if($StrAddState == $stateKey) $selectStr = 'selected';
                                                                ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                                        }
                                                    ?>
                                                </select><br>
                                                <input type="text" id="StrAddPstCode<?=$memberCount?>" name="StrAddPstCode<?=$memberCount?>" style="width:115px;" value="<?=$StrAddPstCode?>" placeholder="Post Code"/>
                                                <select id="StrAddCntry<?=$memberCount?>" name="StrAddCntry<?=$memberCount?>" style="margin-bottom: 5px;width:135px;" >
                                                    <option value="0">Select Country</option>
                                                    <?php foreach($arrCountry AS $countryId => $countryName) {
                                                                $selectStr = "";
                                                                if($StrAddCntry == $countryId) $selectStr = "selected";
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
					<td>Tax File Number</td>
					<td><input type="text" id="txtTfn<?=$memberCount?>" name="txtTfn<?=$memberCount?>" value="<?=$tfn?>" />
					<a id="iconQuestion" class="tooltip" title="The Tax File Number is required to register the SMSF for an ABN. <br/>You can get this from your last tax return or group certificate.">?</a>
					</td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td><input type="text" id="txtOccupation<?=$memberCount?>" name="txtOccupation<?=$memberCount?>" value="<?=$occupation?>" />
					<a id="iconQuestion" class="tooltip" title="Your occupation is required to be provided as part of the application.">?</a>
					</td>
				</tr>
				<tr>
					<td>Contact Number</td>
					<td><input type="text" id="txtPhone<?=$memberCount?>" name="txtPhone<?=$memberCount?>" value="<?=$contactNo?>" /></td>
				</tr>
			</table><br/><br/>
			<input type="hidden" name="memberId<?=$memberCount?>" value="<?=$memberId?>"><?
                        
		}?>
                <input type="hidden" id="member_status" name="member_status" value=""/>
                <input type="hidden" value="<?=$legalRef?>" id="ref" name="ref" />
                <div class="pdT20">
                    <span class="pdR20"><button type="button" onclick="window.location.href='new_smsf_fund.php'" >Back</button></span>
                    <span class="pdR20"><button type="submit" id="btnSave">Save & Exit</button></span>
                    <span><button type="submit" id="btnNext" >Next</button></span>
		</div>
		<input type="hidden" name="doAction" value="addMemberInfo">
	</form>
        <script>
            $('#btnNext').click(function(){$('#member_status').val('0')})
            $('#btnSave').click(function(){$('#member_status').val('1')})
        </script>
        
</div><?
include(FOOTER);
?>