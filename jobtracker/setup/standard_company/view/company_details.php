<?php

include(TOPBAR);
include(STND_COMP_NAV);

?><div class="pageheader">
	<h1>Company Details</h1>
	<span>
		<b>Welcome to the Super Records Company Details page.</b>
	<span>
</div>

<form method="post" action="company_details.php" onsubmit="return  checkValidation();">
    <input type="hidden" name="flagUpdate" id="flagUpdate" value="Y" />
    <input type="hidden" name="job_type" id="smsf_type" value="SETUP" />
    <input type="hidden" name="lstClientType" value="25" />
<div>
    <table class="fieldtable" >
        <tr>
            <td colspan="3">Proposed name of company</td>
            <?php $pref_name = explode(',', $arrCompDtls['comp_pref_name']); ?>
            <td><input type="text" name="txtCompPref[]" value="<?=$pref_name[0]?>" placeholder="Preference 1" /><br/>
            <input type="text" name="txtCompPref[]" value="<?=$pref_name[1]?>" placeholder="Preference 2" /><br/>
            <input type="text" name="txtCompPref[]" value="<?=$pref_name[2]?>" placeholder="Preference 3" /></td>
        </tr>
        <tr>
            <td colspan="3">Jurisdiction of registration</td>
            <td>
                <select id="selJuriReg" name="selJuriReg" style="margin-bottom: 5px;" ><?
                        foreach($arrStates AS $stateKey => $stateName) {
                                $selectStr = '';
                                if($arrCompDtls['comp_juri_reg'] == $stateKey) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                        }
                ?></select>
            </td>
        </tr>
        <tr>
            <td colspan="3">Is the proposed company name an <br/>existing business name ?</td>
            <td>
                <select id="selExtBusName" name="selExtBusName" style="margin-bottom: 5px;" onchange="checkExistingBusiness()">
                        
                    <option value="1" <?php if($arrCompDtls['exst_busns_name'] == 1) echo 'selected';?> >Yes</option>
                    <option value="0" <?php if($arrCompDtls['exst_busns_name'] == 0) echo 'selected';?> >No</option>
                </select>
            </td>
        </tr>
        <tr id="trRegBusns" class="hide"> 
            <td colspan="3">Was the business name registered<br/> on or after 28 May 2012 ? </td>
            <td>
                <select id="selRegBusns" name="selRegBusns" style="margin-bottom: 5px;" onchange="checkBusnsReg()">
                    <option value="1" <?php if($arrCompDtls['reg_busns_name'] == 1) echo 'selected';?> >Yes</option>
                    <option value="0" <?php if($arrCompDtls['reg_busns_name'] == 0) echo 'selected';?> >No</option>
                </select>
            </td>
        </tr>
        <tr id="trABN" class="hide" >
            <td colspan="3">ABN</td>
            <td><input type="text" name="txtABN" value="<?=$arrCompDtls['reg_busns_abn']?>" placeholder="ABN Number" /></td>
        </tr>
        <tr id="trState" class="hide" >
            <td colspan="3">State</td>
            <td>
                <select name="selState" style="margin-bottom: 5px;"><?
                    foreach($arrStates AS $stateKey => $stateName) 
                    {
                        $selectStr = '';
                        if($arrCompDtls['reg_busns_state'] == $stateKey) $selectStr = 'selected';
                        ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                    }
                ?></select>
            </td>
        </tr>
        <tr id="trRegNo" class="hide" >
            <td colspan="3">Registration Number</td>
            <td><input type="text" name="txtRegNo" value="<?=$arrCompDtls['reg_busns_number']?>" placeholder="Registration Number" /></td>
        </tr>
    </table>
</div>

<div class="pdT20">
    <?php if(empty($_SESSION['jobId'])){ ?><span align="left"><button type="button" onclick="window.location.href='<?=DIR?>setup.php'" value="BACK" />Back</button></span><? } ?>
    <span align="right" style="<?php if(!isset($_SESSION['jobId'])){ echo'padding-left:55px;'; } ?>"><button type="submit" id="btnNext" name="btnNext" value="submit">Next</button></span>
</div>
</form>

    
<? include(FOOTER); ?>
