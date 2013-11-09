<?php
// include topbar file
include(TOPBAR);

// include navigation
include(CHNGTRUSTEENAV);

// include page content
include(CHNGTRUSTEECONTENT);

// page header
?><div class="pageheader">
    <h1>Fund Details</h1>
    <span><b>Welcome to the Super Records fund details page.</b><span>
</div><?

// content
?><form id="frmFund" method="post" action="fund.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of Fund</td>
            <td><input type="text" name="txtFund" id="txtFund" value="<?=$arrFund['fund_name']?>"></td>
        </tr>
        <tr>
            <td>Meeting Address</td>
            <td>
                <div>
                    <input type="text" id="metAddUnit" name="metAddUnit" style="width:115px;" value="<?=$arrFund['met_add_unit']?>" placeholder="Unit number" />
                    <input type="text" id="metAddBuild" name="metAddBuild" style="width:115px;" value="<?=$arrFund['met_add_build']?>" placeholder="Building" />
                    <input type="text" id="metAddStreet" name="metAddStreet" style="width:115px;" value="<?=$arrFund['met_add_street']?>" placeholder="Street"/><br>
                    <input type="text" id="metAddSubrb" name="metAddSubrb" style="width:115px;" value="<?=$arrFund['met_add_subrb']?>" placeholder="Suburb"/>
                    <select id="metAddState" name="metAddState" style="margin-bottom: 5px;width:135px;" >
                        <option value="0">Select State</option>
                        <?php foreach($arrStates AS $stateKey => $stateName) {
                                    $selectStr = '';
                                    if($arrFund['met_add_state'] == $stateKey) $selectStr = 'selected';
                                    ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                            }
                        ?>
                    </select><br>
                    <input type="text" id="metAddPstCode" name="metAddPstCode" style="width:115px;" value="<?=$arrFund['met_add_pst_code']?>" placeholder="Post Code"/>
                    <select id="metAddCntry" name="metAddCntry" style="margin-bottom: 5px;width:135px;" >
                        <option value="0">Select Country</option>
                        <?php foreach($arrCountry AS $countryId => $countryName) {
                                    $selectStr = "";
                                    if($arrFund['met_add_country'] == $countryId) $selectStr = "selected";
                                    else if ($countryId == 9 && $arrFund['met_add_country'] == 0)
                                        $selectStr = "selected";
                                    ?><option <?=$selectStr?> value="<?=$countryId?>"><?=$countryName?></option><?
                            }
                        ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Date of Establishment </td>
            <td>
                <input type="text" style="width:70px" id="txtDtEstblshmnt" readonly="true" name="txtDtEstblshmnt" size="10" value="<?=$arrFund['dt_estblshmnt']?>"/>
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDtEstblshmnt','ddMMyyyy')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
            <td>Action Type</td>
            <td><select name="selActTyp" id="selActTyp">
            <option value="0">Select action type</option><?
            foreach ($arrActionType as $type) {
                $selectStr = "";
                if($arrFund['action_type'] == $type) $selectStr = "selected";
                ?><option <?=$selectStr?>><?=$type?></option><?
            }  
            ?></select></td>
        </tr>
        <tr>
            <td>Appointment Clause</td>
            <td><input type="text" name="txtAppCls" id="txtAppCls" value="<?=$arrFund['appointment_clause']?>"></td>
        </tr>
        <tr>
            <td>Resignation Clause</td>
            <td><input type="text" name="txtResgnCls" id="txtResgnCls" value="<?=$arrFund['resignation_clause']?>"></td>
        </tr>
    </table>

    <div class="pdT20"><?
        if(empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>