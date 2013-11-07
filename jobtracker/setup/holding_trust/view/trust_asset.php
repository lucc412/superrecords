<?php
// include topbar file
include(TOPBAR);

// include navigation
include(HOLDINGTRUSTNAV);

// include page content
include(HOLDINGTRUSTCONTENT);

// page header
?><div class="pageheader">
    <h1>Asset Details</h1>
    <span><b>Welcome to the Super Records asset details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="trust_asset.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>    
            <td>Asset Details <a id="iconQuestion" class="tooltip" title="Please provide details of asset to be acquired.">?</a></td>
            <td><textarea name="taAsset" id="taAsset"><?=$arrHoldTrust['asset_details']?></textarea></td>
        </tr>
    </table>
    
    <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='trust_fund.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Preview</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>