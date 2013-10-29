<?php
    include(TOPBAR);
    include(STND_COMP_NAV);

    
//    echo '<script>
//        var objStates = jQuery.parseJSON('.$jsonStates.');
//            alert("JSON = "+objStates)</script>';
?>

<div class="pageheader" style="padding-bottom:0;">
	<h1>Officer Details</h1>
	<span>
		<b>Welcome to the Super Records officer details page.</b>
	<span>
</div>
<div>
    <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your company. These details will be used to register the company. If you need any help completing this section, please contact us.</div>
    <form method="post" action="officer_details.php" onsubmit="return  checkValidation();">
        <table class="fieldtable">
            <tr>
                <td>Number of officers </td>
                <td>
                    <select id="selOfficers" name="selOfficers" style="margin-bottom: 5px;width:180px;" onchange="addOfficers()">
                        <option value="0">Select no of officer`s</option>
                        <?php 
                            for($i = 1;$i <= 10;$i++) {
                                $selectStr = '';
                                if($StrAddState == $i) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$i?>"><?=$i?></option><?
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <div id="dvOfficer">
            <?php
                if(!empty($arrOffcrData))
                {
                    foreach($arrOffcrData as $key => $value) 
                    { 
                        $noOfOffcr = $value['no_of_offcr'];
                    ?>
                        <div id="officer_<?=$key?>"> 
                            <div style="padding:10px 0;color: #F05729;font-size: 14px;">Officer <?=$key?>:</div>
                            <input type="hidden" name="offcrId[<?=$key?>]" id="offcrId" value="<?=$key?>">
                            <table class="fieldtable">
                                <tr>
                                    <td>First name </td>
                                    <td><input type="text" id="txtFname_<?=$key?>" name="txtFname[<?=$key?>]" value="<?=$value['offcr_fname']?>" placeholder="First Name" /></td>
                                </tr>
                                <tr>
                                    <td>Middle name </td>
                                    <td><input type="text" id="txtMname_<?=$key?>" name="txtMname[<?=$key?>]" value="<?=$value['offcr_mname']?>" placeholder="Middle Name" /></td>
                                </tr>
                                <tr>
                                    <td>Last name </td>
                                    <td><input type="text" id="txtLname_<?=$key?>" name="txtLname[<?=$key?>]" value="<?=$value['offcr_lname']?>" placeholder="Last Name" /></td>
                                </tr>
                                <tr>
                                    <td>Date of birth </td>
                                    <td><input type="text" id="txtDob_<?=$key?>" name="txtDob[<?=$key?>]" value="<?=date("d/m/Y",strtotime($value['offcr_dob']))?>" placeholder="Date of birth" readonly="" /><img src="../../images/calendar.png" id="calImgId" onclick="javascript:NewCssCal('txtDob_<?=$key?>','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/></td>
                                </tr>
                                <tr>
                                    <td>City of birth </td>
                                    <td><input type="text" id="txtCob_<?=$key?>" name="txtCob[<?=$key?>]" value="<?=$value['offcr_city_birth']?>" placeholder="City of birth" /><td>
                                </tr>
                                <tr>
                                    <td>State and Country of birth </td>
                                    <td>
                                        <select id="selSob_<?=$key?>" name="selSob[<?=$key?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select State</option><?php foreach($arrStates AS $stateKey => $stateName) { $selectStr = ""; if($value['offcr_state_birth'] == $stateKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><? } ?>
                                        </select>
                                        <select id="selCntryob_<?=$key?>" name="selCntryob[<?=$key?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select Country</option><?php foreach($arrCountry AS $cntryKey => $cntryName) { $selectStr = ""; if($value['offcr_cntry_birth'] == $cntryKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$cntryKey?>"><?=$cntryName?></option><? } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tax File Number </td>
                                    <td><input type="text" id="txtTFN_<?=$key?>" name="txtTFN[<?=$key?>]" value="<?=$value['offcr_tfn']?>" placeholder="Tax File Number" /></td>
                                </tr>
                                <tr>
                                    <td>Residential Address </td>
                                    <td>
                                        <div>
                                            <input type="text" id="offAddUnit_<?=$key?>" name="offAddUnit[<?=$key?>]" style="width:115px;" value="<?=$value['offcr_addr_unit']?>" placeholder="Unit number" />
                                            <input type="text" id="offAddBuild_<?=$key?>" name="offAddBuild[<?=$key?>]" style="width:115px;" value="<?=$value['offcr_addr_build']?>" placeholder="Building" />
                                            <input type="text" id="offAddStreet_<?=$key?>" name="offAddStreet[<?=$key?>]" style="width:115px;" value="<?=$value['offcr_addr_street']?>" placeholder="Street"/><br>
                                            <input type="text" id="offAddSubrb_<?=$key?>" name="offAddSubrb[<?=$key?>]" style="width:115px;" value="<?=$value['offcr_addr_subrb']?>" placeholder="Suburb"/>
                                            <select id="offAddState_<?=$key?>" name="offAddState[<?=$key?>]" style="margin-bottom:5px; width:180px;" >
                                                <option value="0">Select State</option><?php foreach($arrStates AS $stateKey => $stateName) { $selectStr = ""; if($value['offcr_addr_state'] == $stateKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><? } ?>
                                            </select><br>
                                            <input type="text" id="offAddPstCode_<?=$key?>" name="offAddPstCode[<?=$key?>]" value="<?=$value['offcr_addr_pst_code']?>" placeholder="Post Code"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                <?php    
                    }   
                }
            ?>
        </div>
        <input type="hidden" id="sql" name="sql" value="" />
        <div style="padding-top:20px;"> 
            <span align="left"><button type="button" onclick="window.location.href='address_details.php'" >Back</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit"  id='btnNext'>Next</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">Save & Exit</button></span>
        </div>
    </form>
    <script>
        $('#btnNext').click(function(){$('#sql').val('Add')})
        $('#btnSave').click(function(){$('#sql').val('Save')})
    </script>
</div>
<? include(FOOTER); ?>