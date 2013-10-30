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
    <form method="post" id="frmOfficer" action="officer_details.php">
        <table class="fieldtable">
            <tr>
                <td>Number of officers </td>
                <td>
                    <select id="selOfficers" name="selOfficers" style="margin-bottom: 5px;width:180px;" onchange="addOfficers()">
                        <option value="0">Select no of officer`s</option>
                        <?php 
                            for($i = 1;$i <= 10;$i++) {
                                $selectStr = '';
                                if(count($arrOffcrData) == $i) $selectStr = 'selected';
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
                     $cntr = 0;
                    foreach($arrOffcrData as $key => $value) 
                    { 
                        $cntr++;
                        $noOfOffcr = $value['no_of_offcr'];
                    ?>
                        <div id="officer_<?=$cntr?>"> 
                            <div style="padding:10px 0;color: #F05729;font-size: 14px;">Officer <?=$cntr?>:</div>
                            <input type="hidden" name="offcrId[<?=$cntr?>]" id="offcrId" value="<?=$value['offcr_id']?>">
                            <table class="fieldtable">
                                <tr>
                                    <td>First name </td>
                                    <td><input type="text" id="txtFname_<?=$cntr?>" name="txtFname[<?=$cntr?>]" value="<?=$value['offcr_fname']?>" placeholder="First Name" /></td>
                                </tr>
                                <tr>
                                    <td>Middle name </td>
                                    <td><input type="text" id="txtMname_<?=$cntr?>" name="txtMname[<?=$cntr?>]" value="<?=$value['offcr_mname']?>" placeholder="Middle Name" /></td>
                                </tr>
                                <tr>
                                    <td>Last name </td>
                                    <td><input type="text" id="txtLname_<?=$cntr?>" name="txtLname[<?=$cntr?>]" value="<?=$value['offcr_lname']?>" placeholder="Last Name" /></td>
                                </tr>
                                <tr>
                                    <td>Date of birth </td>
                                    <td><input type="text" id="txtDob_<?=$cntr?>" name="txtDob[<?=$cntr?>]" value="<?=date("d/m/Y",strtotime($value['offcr_dob']))?>" placeholder="Date of birth" readonly="" /><img src="../../images/calendar.png" id="calImgId" onclick="javascript:NewCssCal('txtDob_<?=$cntr?>','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/></td>
                                </tr>
                                <tr>
                                    <td>City of birth </td>
                                    <td><input type="text" id="txtCob_<?=$cntr?>" name="txtCob[<?=$cntr?>]" value="<?=$value['offcr_city_birth']?>" placeholder="City of birth" /><td>
                                </tr>
                                <tr>
                                    <td>State and Country of birth </td>
                                    <td>
                                        <select id="selSob_<?=$cntr?>" name="selSob[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select State</option><?php foreach($arrStates AS $stateKey => $stateName) { $selectStr = ""; if($value['offcr_state_birth'] == $stateKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><? } ?>
                                        </select>
                                        <select id="selCntryob_<?=$cntr?>" name="selCntryob[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select Country</option><?php foreach($arrCountry AS $cntryKey => $cntryName) { $selectStr = ""; if($value['offcr_cntry_birth'] == $cntryKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$cntryKey?>"><?=$cntryName?></option><? } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tax File Number </td>
                                    <td><input type="text" id="txtTFN_<?=$cntr?>" name="txtTFN[<?=$cntr?>]" value="<?=$value['offcr_tfn']?>" placeholder="Tax File Number" /></td>
                                </tr>
                                <tr>
                                    <td>Residential Address </td>
                                    <td>
                                        <div>
                                            <input type="text" id="offAddUnit_<?=$cntr?>" name="offAddUnit[<?=$cntr?>]" style="width:115px;" value="<?=$value['offcr_addr_unit']?>" placeholder="Unit number" />
                                            <input type="text" id="offAddBuild_<?=$cntr?>" name="offAddBuild[<?=$cntr?>]" style="width:115px;" value="<?=$value['offcr_addr_build']?>" placeholder="Building" />
                                            <input type="text" id="offAddStreet_<?=$cntr?>" name="offAddStreet[<?=$cntr?>]" style="width:115px;" value="<?=$value['offcr_addr_street']?>" placeholder="Street"/><br>
                                            <input type="text" id="offAddSubrb_<?=$cntr?>" name="offAddSubrb[<?=$cntr?>]" style="width:115px;" value="<?=$value['offcr_addr_subrb']?>" placeholder="Suburb"/>
                                            <select id="offAddState_<?=$cntr?>" name="offAddState[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                                <option value="0">Select State</option><?php foreach($arrStates AS $stateKey => $stateName) { $selectStr = ""; if($value['offcr_addr_state'] == $stateKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><? } ?>
                                            </select><br>
                                            <input type="text" id="offAddPstCode_<?=$cntr?>" name="offAddPstCode[<?=$cntr?>]" value="<?=$value['offcr_addr_pst_code']?>" placeholder="Post Code"/>
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
        <input type="hidden" id="sql" name="sql" value="update" />
        <div style="padding-top:20px;"> 
            <span class="pdR20"><button type="button" onclick="window.location.href='address_details.php'" >Back</button></span>
            <span class="pdR20"><button type="submit" name="save" id="btnSave">Save & Exit</button></span>
            <span><button type="submit" name="next" id='btnNext'>Next</button></span>
        </div>
    </form>
</div>
<? include(FOOTER); ?>