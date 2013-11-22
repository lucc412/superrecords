<?php
// include topbar file
include(TOPBAR);

// include navigation
include(INVSTMNTSTRAGYNAV);

// page header
?><div class="pageheader">
    <h1>Asset Allocation</h1>
    <span><b>Welcome to the Super Records asset allocation page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="trust_asset.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="assetCnt" id="assetCnt" value="<?=$assetCnt?>">
    <span class="pdR20">Financial Year</span>
    <span class="pdR20"><input type="text" name="txtYear" id="txtYear" value="<?=$financialYear?>" /></span>
    <!--<span><button type="button" id="btnAdd" style="width:105px">Add Asset</button></span>--><?
    
    // add case
    if(empty($arrHoldTrust)) {
        $assetCnt = 1;
        ?><div style="padding:10px 0;color: #F05729;font-size: 14px;">Asset <?=$assetCnt?>:</div>
            <input type="hidden" name="assetId<?=$assetCnt?>" value="<?=$assetId?>">
            <table class="fieldtable" width="60%" cellpadding="10px;">
                <tr>    
                    <td>Asset</td>
                    <td><textarea name="taAsset<?=$assetCnt?>" id="taAsset<?=$assetCnt?>"><?=$assetData['asset']?></textarea></td>
                </tr>
                <tr>    
                    <td>Asset Type</td>
                    <td><input type="text" name="txtType<?=$assetCnt?>" id="txtType<?=$assetCnt?>" value="<?=$assetData['type']?>" /></td>
                </tr>
                <tr>    
                    <td>Amount</td>
                    <td><input type="text" name="txtAmt<?=$assetCnt?>" id="txtAmt<?=$assetCnt?>" value="<?=$assetData['amount']?>" /></td>
                </tr>
                <tr>    
                    <td>Range (0-100%)</td>
                    <td><input type="text" name="txtRange<?=$assetCnt?>" id="txtRange<?=$assetCnt?>" value="<?=$assetData['asset_range']?>" /></td>
                </tr>
                <tr>    
                    <td>12 months target %</td>
                    <td><input type="text" name="txtTarget<?=$assetCnt?>" id="txtTarget<?=$assetCnt?>" value="<?=$assetData['target']?>" /></td>
                </tr>
            </table><?
    }
    // edit case
    else if(!empty($arrHoldTrust)) {
        $assetCnt = 1;
        foreach ($arrHoldTrust AS $assetId => $assetData) {
            ?><div style="padding:10px 0;color: #F05729;font-size: 14px;">Asset <?=$assetCnt?>:</div>
            <input type="hidden" name="assetId<?=$assetCnt?>" value="<?=$assetId?>">
            <table class="fieldtable" width="60%" cellpadding="10px;">
                <tr>    
                    <td>Asset</td>
                    <td><textarea name="taAsset<?=$assetCnt?>" id="taAsset<?=$assetCnt?>"><?=$assetData['asset']?></textarea></td>
                </tr>
                <tr>    
                    <td>Asset Type</td>
                    <td><input type="text" name="txtType<?=$assetCnt?>" id="txtType<?=$assetCnt?>" value="<?=$assetData['type']?>" /></td>
                </tr>
                <tr>    
                    <td>Amount</td>
                    <td><input type="text" name="txtAmt<?=$assetCnt?>" id="txtAmt<?=$assetCnt?>" value="<?=$assetData['amount']?>" /></td>
                </tr>
                <tr>    
                    <td>Range (0-100%)</td>
                    <td><input type="text" name="txtRange<?=$assetCnt?>" id="txtRange<?=$assetCnt?>" value="<?=$assetData['asset_range']?>" /></td>
                </tr>
                <tr>    
                    <td>12 months target %</td>
                    <td><input type="text" name="txtTarget<?=$assetCnt?>" id="txtTarget<?=$assetCnt?>" value="<?=$assetData['target']?>" /></td>
                </tr>
            </table><?
            $assetCnt++;
        }
    }
    ?><div id="divAssets"></div>
    <span><button type="button" id="btnAdd" style="width:105px">Add Asset</button></span>
    
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='fund.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>