<?php
    include(TOPBAR);
    include(STND_COMP_NAV);
    
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Shareholder Details</h1>
	<span>
		<b>Welcome to the Super Records shareholder details page.</b>
	<span>
</div>

<div>
    <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your new fund. These details will be used to register the fund. If you need any help completing this section, please contact us.</div>
    <form method="post" id="frmShrhldr" action="shareholder_details.php" >
       <table class="fieldtable">
            <tr>
                <td>Number of shareholders </td>
                <td>
                    <select id="selShrHldr" name="selShrHldr" style="margin-bottom: 5px;width:180px;" onchange="addShrHldr()">
                        <option value="0">Select no of shareholders</option>
                        <?php 
                            for($i = 1;$i <= 10;$i++) {
                                $selectStr = '';
                                if(count($arrShrhldrDtls) == $i) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$i?>"><?=$i?></option><?
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <div id="dvShrHldr">
            <?php
            
                if(!empty($arrShrhldrDtls))
                {
                    $cntr = 0;
                    foreach($arrShrhldrDtls as $key => $value) 
                    { 
                        $cntr++;
                        $noOfShrhldr = $value['no_of_shrhldr'];
                    ?>
                        <div id="shrHldr_<?=$cntr?>"> 
                                <div style="padding:20px 0 10px 0;color: #F05729;font-size: 14px;height:30px;width:196px;float:left">Shareholder <?=$cntr?>:</div>
                                <div style="padding:10px 0;font-size:13px;width:500px"> Type <select id="selShrType_<?=$cntr?>" name="selShrType[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" onchange="changeShrHldrType(this,<?=$cntr?>)" >
                                            <option value="1" <?php if($value['shrhldr_type'] == 1) echo 'selected';?> >Corporate</option>
                                            <option value="2" <?php if($value['shrhldr_type'] == 2) echo 'selected';?> >Individual</option>
                                        </select></div>
                                </div><div style="clear:both"></div>
                                <input type="hidden" name="shrhldrId[<?=$cntr?>]" id="shrhldrId_<?=$cntr?>" value="<?=$value['shrhldr_id']?>" >
                                
                                <table id="trCrpShrHldr_<?=$cntr?>" style="width:700px" class="fieldtable <?php if($value['shrhldr_type'] == 1){ echo 'show'; }else echo 'hide'; ?>">
                                    <tr>
                                        <td>Company Name</td>
                                        <td><input type="text" id="txtCmpName_<?=$cntr?>" name="txtCmpName[<?=$cntr?>]" value="<?=$value['shrhldr_cmpny_name']?>" placeholder="Company Name" /></td>
                                    </tr>
                                    <tr>
                                        <td>ACN </td>
                                        <td><input type="text" id="txtACN_<?=$cntr?>" name="txtACN[<?=$cntr?>]" value="<?=$value['shrhldr_acn']?>" placeholder="ACN" /></td>
                                    </tr>
                                    <tr>
                                        <td>Registered Address </td>
                                        <td><input type="text" id="txtRegAddr_<?=$cntr?>" name="txtRegAddr[<?=$cntr?>]" value="<?=$value['shrhldr_reg_addr']?>" placeholder="Registered Address" /></td>
                                    </tr>
                                    <tr>
                                        <td>Number of Director</td>
                                        <td><select id="selNoDirtr_<?=$cntr?>" name="selNoDirtr[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" onchange="addDirectors($('#trCrpShrHldr_<?=$cntr?>'),<?=$cntr?>)" >
                                            <option value="0">Select no of Director`s</option>
                                            <?php 
                                                for($i = 1;$i <= 10;$i++) {
                                                    $selectStr = '';
                                                    if($value['no_of_directrs'] == $i) $selectStr = 'selected';
                                                    ?><option <?=$selectStr?> value="<?=$i?>"><?=$i?></option><?
                                                }
                                            ?>
                                        </select></td>
                                    </tr>
                                </table>
                                <div id="crpNoDirtr_<?=$cntr?>" class="<?php if($value['no_of_directrs'] > 0){ echo 'show'; }else echo 'hide'; ?>" style="margin-left:228px;width:auto">
                                    <?php $drctrsName = explode(',', $value['directrs_name']);
                                    foreach ($drctrsName as $fldId => $fldvalue) { $fldId++; ?>                                    
                                    <div id="dvDirtr_<?=$cntr.$fldId?>" >
                                        <table class="fieldtable">
                                            <tr>
                                                <td><input type="text" id="txtFulName_<?=$cntr.$fldId?>" name="txtFulName[<?=$cntr?>][<?=$fldId?>]" value="<?=$fldvalue?>" placeholder="Director Name <?=$fldId?>" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php } ?>
                                </div>
                                <table id="trIndShrHldr_<?=$cntr?>" style="width:1050px" class="fieldtable <?php if($value['shrhldr_type'] == 2){ echo 'show'; }else echo 'hide'; ?>">
                                    <tr><td>First name </td>
                                    <td><input type="text" id="txtFname_<?=$cntr?>" name="txtFname[<?=$cntr?>]" value="<?=$value['shrhldr_fname']?>" placeholder="First Name" /></td></tr>
                                    <tr><td>Middle name </td>
                                    <td><input type="text" id="txtMname_<?=$cntr?>" name="txtMname[<?=$cntr?>]" value="<?=$value['shrhldr_mname']?>" placeholder="Middle Name" /></td></tr>
                                    <tr><td>Last name </td>
                                    <td><input type="text" id="txtLname_<?=$cntr?>" name="txtLname[<?=$cntr?>]" value="<?=$value['shrhldr_lname']?>" placeholder="Last Name" /></td></tr>
                                    <tr><td>Residential Address </td>
                                    <td><div>
                                        <input type="text" id="resAddUnit_<?=$cntr?>" name="resAddUnit[<?=$cntr?>]" style="width:115px;" value="<?=$value['res_addr_unit']?>" placeholder="Unit number" />
                                        <input type="text" id="resAddBuild_<?=$cntr?>" name="resAddBuild[<?=$cntr?>]" style="width:115px;" value="<?=$value['res_addr_build']?>" placeholder="Building" />
                                        <input type="text" id="resAddStreet_<?=$cntr?>" name="resAddStreet[<?=$cntr?>]" style="width:115px;" value="<?=$value['res_addr_street']?>" placeholder="Street"/><br>
                                        <input type="text" id="resAddSubrb_<?=$cntr?>" name="resAddSubrb[<?=$cntr?>]" style="width:115px;" value="<?=$value['res_addr_subrb']?>" placeholder="Suburb"/>
                                        <select id="resAddState_<?=$cntr?>" name="resAddState[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select State</option><?php foreach($arrStates AS $stateKey => $stateName) { $selectStr = ""; if($value['res_addr_state'] == $stateKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><? } ?>
                                        </select><br>
                                        <input type="text" id="resAddPstCode_<?=$cntr?>" name="resAddPstCode[<?=$cntr?>]" value="<?=$value['res_addr_pcode']?>" placeholder="Post Code"/>
                                    </div>
                                </td>
                            </tr>
                            </table>
                            <table class="fieldtable" style="width:528px">
                                <tr><td>Share Class </td>
                                <td>
                                    <select id="selShrCls_<?=$cntr?>" name="selShrCls[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                        <option value="0">Select Share class</option><?php foreach($arrShrCls AS $shrKey => $clsName) { $selectStr = ""; if($value['share_class'] == $shrKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$shrKey?>"><?=$clsName?></option><? } ?>
                                    </select></td></tr>
                                <tr><td>Are the shares owned on behalf </br>of another Company or Trust? </td>
                                <td><select id="selShrBhlf_<?=$cntr?>" name="selShrBhlf[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" onchange="changeShrOwnBhlf(this,<?=$cntr?>)">
                                        <option value="1" <?php if($value['is_shars_own_bhlf'] == 1) echo 'selected';?>>Yes</option>
                                        <option value="0" <?php if($value['is_shars_own_bhlf'] == 0) echo 'selected';?>>No</option>
                                    </select></td></tr>
                                <tr id="trShrOwnBhlf_<?=$cntr?>" class="<?php if($value['is_shars_own_bhlf'] == 1){ echo 'show'; }else echo 'hide'; ?>" ><td>Shares are owned on behalf </td>
                                    <td><input type="text" id="txtShrOwnBhlf_<?=$cntr?>" name="txtShrOwnBhlf[<?=$cntr?>]" value="<?=$value['shars_own_bhlf']?>" placeholder="Shares are owned on behalf" /></td></tr>
                                <tr><td>Number of shares </td>
                                <td><input type="text" id="txtNoShares_<?=$cntr?>" name="txtNoShares[<?=$cntr?>]" value="<?=$value['no_of_shares']?>" placeholder="Number of shares" /></td></tr>
                            </table>
                        </div>
                        
             <?php    
                    }   
                }
            ?>
        </div>
        <input type="hidden" id="sql" name="sql" value="" />
        <div style="padding-top:20px;">
            <span align="left"><button type="button" onclick="window.location.href='officer_details.php'" >Back</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave" name="btnSave" value="Save" >Save & Exit</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit"  id="btnNext" name="btnNext" value="Next" >Preview</button></span>
        </div>
    </form>
    <script>
        $('#btnNext').click(function(){$('#sql').val('Add')})
//        $('#btnSave').click(function(){$('#sql').val('Save')})
    </script>
</div>
<? include(FOOTER); ?>