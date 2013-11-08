<?php

include(TOPBAR);
include(STND_COMP_NAV);

?><div class="pageheader">
	<h1>Company Details</h1>
	<span>
		<b>Welcome to the Super Records company details page.</b>
	<span>
</div>

<form id="frmCompany" method="post" action="company_details.php">
<input type="hidden" name="flagUpdate" id="flagUpdate" value="Y" />
<input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
<div>
    <table class="fieldtable" >
        <tr>
            <td colspan="3">Proposed name of company</td>
            <?php $pref_name = explode(',', $arrCompDtls['comp_pref_name']); ?>
            <td><input type="text" name="txtCompPref[]" id="txtCompPref0" value="<?=$pref_name[0]?>" placeholder="Preference 1" /><br/>
            <input type="text" name="txtCompPref[]" id="txtCompPref1" value="<?=$pref_name[1]?>" placeholder="Preference 2" /><br/>
            <input type="text" name="txtCompPref[]" id="txtCompPref2" value="<?=$pref_name[2]?>" placeholder="Preference 3" /></td>
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
        
    </table>
</div>

<div class="pdT20">
    <?php if(empty($_SESSION['jobId'])){ ?><span class="pdR20"><button type="button" onclick="window.location.href='<?=DIR?>setup.php'" value="BACK" />Back</button></span><? } ?>
    <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
    <span><button type="submit" id="btnNext" name="next">Next</button></span>
</div>
</form>

    
<? include(FOOTER); ?>
