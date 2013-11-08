<?php
// include topbar file
include(TOPBAR);

// include navigation
include(CHNGTRUSTEENAV);

// include page content
include(CHNGTRUSTEECONTENT);

// page header
?><div class="pageheader">
    <h1>Limited Recourse Loan Details</h1>
    <span><b>Welcome to the Super Records limited recourse loan details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="member.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>     
           <td>Asset</td>
            <td><textarea name="taAsset" id="taAsset"><?=$arrHoldTrust['asset_details']?></textarea></td>
        </tr>
        <tr>
            <td>Loan Amount</td>
            <td><input type="text" name="txtLoan" id="txtLoan" value="<?=$arrHoldTrust['loan_amount']?>"></td>
        </tr>
        <tr>
            <td>Term of loan (years)</td>
            <td><input type="text" name="txtYear" id="txtYear" value="<?=$arrHoldTrust['loan_years']?>"></td>
        </tr>
        <tr>
            <td>Interest Rate %</td>
            <td><input type="text" name="txtRate" id="txtRate" value="<?=$arrHoldTrust['interest']?>"></td>
        </tr>
        <tr>
            <td>Interest Rate Type</td>
            <td>
                <select name="lstRateType" id="lstRateType">
                    <option value="">Select Interest Rate Type</option><?php
                    foreach($arrRateType AS $charType => $typeDesc){
                            $selectStr = "";
                            if($arrHoldTrust['interest_type'] == $charType) $selectStr = "selected";
                            ?><option <?=$selectStr?> value="<?=$charType?>"><?=$typeDesc?></option><?php 
                    }
                ?></select>
            </td>
        </tr>
        <tr>
            <td>Loan Type</td>
            <td>
                <select name="lstLoanType" id="lstLoanType">
                    <option value="">Select Loan Type</option><?php
                    foreach($arrLoanType AS $charType => $typeDesc){
                            $selectStr = "";
                            if($arrHoldTrust['loan_type'] == $charType) $selectStr = "selected";
                            ?><option <?=$selectStr?> value="<?=$charType?>"><?=$typeDesc?></option><?php 
                    }
                ?></select>
            </td>
        </tr>
    </table>
    
    <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='new_trustee.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Preview</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>