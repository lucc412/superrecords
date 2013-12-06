<?php
// include topbar file
include(TOPBAR);

// include navigation
include(ACCPENSNNAV);

// include page content
include(ACCPENSNCONTENT);

// page header
?><div class="pageheader">
    <h1>Pension Details</h1>
    <span><b>Welcome to the Super Records pension details page.</b><span>
</div><?

// content
?><form id="frmPension" method="post" action="pension.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of Member Commencing the Pension</td>
            <td><input type="text" name="txtMembrName" id="txtMembrName" value="<?=$arrPension['member_name']?>"></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td>
                <input type="text" style="width:70px" id="txtDob" readonly="true" name="txtDob" size="10" value="<?=$arrPension['dob']?>" />
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
            <td>Commencement Date</td>
            <td>
                <input type="text" style="width:70px" id="txtComncDt" readonly="true" name="txtComncDt" size="10" value="<?=$arrPension['commence_date']?>"/>
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtComncDt','ddMMyyyy')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
            <td>Condition of Release</td>
            <td>
                <?php $arrCondRel = array(1=>'Retirement',2=>'Reaching Age 65',3=>'Roll-over') ?>
                <select id="selCondRel" name="selCondRel" style="margin-bottom: 5px;">
                    <?php foreach ($arrCondRel as $cond_id => $condValue) { 
                        $sel = "";
                        if($arrPension['condition_release'] == $cond_id) $sel = "selected"; ?>
                        <option value="<?=$cond_id?>" <?=$sel?> ><?=$condValue?></option>
                    <?php }?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pension Account Balance</td>
            <td><input type="text" name="txtPenAccBal" id="txtPenAccBal" value="<?=$arrPension['pension_acc_bal']?>" placeholder="$"></td>
        </tr>
        <tr>
            <td>Current Year Payment</td>
            <td><input type="text" name="txtCurYrPay" id="txtCurYrPay" value="<?=$arrPension['currnt_yr_pay']?>" placeholder="$"></td>
        </tr>
        <tr>
            <td>Tax Free Percentage</td>
            <td><input type="text" name="txtTxFrePrcnt" id="txtTxFrePrcnt" value="<?=$arrPension['tax_free_percnt']?>" ></td>
        </tr>
        <tr>
            <td>Reversionary Pension Name (if applicable)</td>
            <td><input type="text" name="txtRevPenName" id="txtRevPenName" value="<?=$arrPension['rev_pensn_name']?>"></td>
        </tr>
        <tr>
            <td>Reversionary Terms and Conditions</td>
            <td><input type="text" name="txtRevTnC" id="txtRevTnC" value="<?=$arrPension['rev_terms_condn']?>"></td>
        </tr>
    </table>
<div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='trustee.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Preview</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>