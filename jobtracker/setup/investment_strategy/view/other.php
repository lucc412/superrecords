<?php
// include topbar file
include(TOPBAR);

// include navigation
include(INVSTMNTSTRAGYNAV);

// page header
?><div class="pageheader">
    <h1>Other Details</h1>
    <span><b>Welcome to the Super Records other details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="other.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="90%" cellpadding="10px;">
        <tr>
            <td style="width:120px">Specific Objectives</td>
            <td><input type="text" name="txtObj" id="txtObj" value="<?=$arrOtherData['spc_objective']?>" /></td>
        </tr>
        <tr>    
            <td>Insurance Details</td>
            <td><?
                foreach ($arrInsurancelist AS $listId => $listStr) {
                    $checked = '';
                    if(in_array($listId, $arrInsDetail)) $checked = 'checked';
                   ?><p class="pdB8">
                        <span><input type="checkbox" class="checkboxClass" name="insurance<?=$listId?>" id="insurance<?=$listId?>" value="0" <?=$checked?>/></span>
                        <span><?=$listStr;?></span>
                     </p><?
                } 
            ?></td>
        </tr>
    </table>
    
    <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='trust_asset.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Preview</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>