<?php
    include(TOPBAR);
    include(STND_COMP_NAV);
    
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Address Details</h1>
	<span>
		<b>Welcome to the Super Records address details page.</b>
	<span>
</div>

<div>
    <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your new fund. These details will be used to register the fund. If you need any help completing this section, please contact us.</div>
    <form method="post" action="address_details.php" onsubmit="return  checkValidation();">
        <div class="frmMidHeader">Registered Address</div>
        <table class="fieldtable">
            <tr>
                <td>Address</td>
                <td>
                    <div>
                        <input type="text" name="regAddUnit" style="width:115px;" value="<?=$arrAddrDtls['reg_add_unit']?>" placeholder="Unit number" />
                        <input type="text" name="regAddBuild" style="width:115px;" value="<?=$arrAddrDtls['reg_add_build']?>" placeholder="Building" />
                        <input type="text" name="regAddStreet" style="width:115px;" value="<?=$arrAddrDtls['reg_add_street']?>" placeholder="Street"/><br>
                        <input type="text" name="regAddSubrb" style="width:115px;" value="<?=$arrAddrDtls['reg_add_subrb']?>" placeholder="Suburb"/>
                        <select name="regAddState" style="margin-bottom: 5px;width:180px;" >
                            <option value="0">Select State</option>
                            <?php foreach($arrStates AS $stateKey => $stateName) {
                                    $selectStr = '';
                                    if($arrAddrDtls['reg_add_state'] == $stateKey) $selectStr = 'selected';
                                    ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                }
                            ?>
                        </select><br>
                        <input type="text" name="regAddPstCode" value="<?=$arrAddrDtls['reg_add_pst_code']?>" placeholder="Post Code"/> 
                    </div>
                </td>
            </tr>
            <tr>
                <td>Will this company occupy <br/>this address? </td>
                <td>
                    <select id="selCompAddr" name="selCompAddr" style="margin-bottom: 5px;" onchange="checkCompAddress()">
                        <option value="1" <?php if($arrAddrDtls['is_comp_addr'] == 1) echo 'selected';?> >Yes</option>
                        <option value="0" <?php if($arrAddrDtls['is_comp_addr'] == 0) echo 'selected';?> >No</option>
                    </select>
                </td>
            </tr>
            <tr id="trOccpName" class="hide">
                <td>Occupier`s name </td>
                <td>
                    <input type="text" name="txtOccpName" value="<?=$arrAddrDtls['occp_name']?>" placeholder="Occupier`s name"/>
                </td>
            </tr>
        </table>
        <br/>
        <div style="padding-bottom:20px;color: #F05729;font-size: 14px;">Principal Business Address</div>
        <table class="fieldtable">
            <tr>
                <td style="padding-right: 95px;" >Address</td>
                <td>
                    <div>
                        <input type="text" name="busAddUnit" style="width:115px;" value="<?=$arrAddrDtls['bsns_add_unit']?>" placeholder="Unit number" />
                        <input type="text" name="busAddBuild" style="width:115px;" value="<?=$arrAddrDtls['bsns_add_build']?>" placeholder="Building" />
                        <input type="text" name="busAddStreet" style="width:115px;" value="<?=$arrAddrDtls['bsns_add_street']?>" placeholder="Street"/><br>
                        <input type="text" name="busAddSubrb" style="width:115px;" value="<?=$arrAddrDtls['bsns_add_subrb']?>" placeholder="Suburb"/>
                        <select name="busAddState" style="margin-bottom: 5px;width:180px;" >
                            <option value="0">Select State</option>
                            <?php foreach($arrStates AS $stateKey => $stateName) {
                                        $selectStr = '';
                                        if($arrAddrDtls['bsns_add_state'] == $stateKey) $selectStr = 'selected';
                                        ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                }
                            ?>
                        </select><br>
                        <input type="text" name="busAddPstCode" value="<?=$arrAddrDtls['bsns_add_pst_code']?>" placeholder="Post Code"/> 
                    </div>
                </td>
            </tr>
        </table>
        <br/>
        <div class="frmMidHeader">Meeting Address</div>
        <table class="fieldtable">
            <tr>
                <td style="padding-right: 95px;" >Address</td>
                <td>
                    <div>
                        <input type="text" name="metAddUnit" style="width:115px;" value="<?=$arrAddrDtls['met_add_unit']?>" placeholder="Unit number" />
                        <input type="text" name="metAddBuild" style="width:115px;" value="<?=$arrAddrDtls['met_add_build']?>" placeholder="Building" />
                        <input type="text" name="metAddStreet" style="width:115px;" value="<?=$arrAddrDtls['met_add_street']?>" placeholder="Street"/><br>
                        <input type="text" name="metAddSubrb" style="width:115px;" value="<?=$arrAddrDtls['met_add_subrb']?>" placeholder="Suburb"/>
                        <select name="metAddState" style="margin-bottom: 5px;width:180px;" >
                            <option value="0">Select State</option>
                            <?php foreach($arrStates AS $stateKey => $stateName) {
                                        $selectStr = '';
                                        if($arrAddrDtls['met_add_state'] == $stateKey) $selectStr = 'selected';
                                        ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                }
                            ?>
                        </select><br>
                        <input type="text" name="metAddPstCode" value="<?=$arrAddrDtls['met_add_pst_code']?>" placeholder="Post Code"/> 
                    </div>
                </td>
            </tr>
        </table>
        <input type="hidden" id="sql" name="sql" value="" />
        <div style="padding-top:20px;">
            <span align="left"><button type="button" onclick="window.location.href='company_details.php'" >Back</button></span>
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