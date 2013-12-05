<?php
// include topbar file
include(TOPBAR);

// include navigation
include(ACCPENSNNAV);

// include page content
include(ACCPENSNCONTENT);

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
            <td>Name of the Fund</td>
            <td><input type="text" name="txtFundName" id="txtFundName" value="<?=$arrFund['fund_name']?>"></td>
        </tr>
        <tr>
            <td>Meeting Address</td>
            <td>
                <div>
                    <input type="text" id="metAddUnit" name="metAddUnit" style="width:115px;" value="<?=$arrFund['metAddUnit']?>" placeholder="Unit number" />
                    <input type="text" id="metAddBuild" name="metAddBuild" style="width:115px;" value="<?=$arrFund['metAddBuild']?>" placeholder="Building" />
                    <input type="text" id="metAddStreet" name="metAddStreet" style="width:115px;" value="<?=$arrFund['metAddStreet']?>" placeholder="Street"/><br>
                    <input type="text" id="metAddSubrb" name="metAddSubrb" style="width:115px;" value="<?=$arrFund['metAddSubrb']?>" placeholder="Suburb"/>
                    <select id="metAddState" name="metAddState" style="margin-bottom: 5px;width:135px;" >
                        <option value="0">Select State</option>
                        <?php foreach($arrStates AS $stateKey => $stateName) {
                                    $selectStr = '';
                                    if($arrFund['metAddState'] == $stateKey) $selectStr = 'selected';
                                    ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                            }
                        ?>
                    </select><br>
                    <input type="text" id="metAddPstCode" name="metAddPstCode" style="width:115px;" value="<?=$arrFund['metAddPstCode']?>" placeholder="Post Code"/>
                    <select id="metAddCntry" name="metAddCntry" style="margin-bottom: 5px;width:135px;" >
                        <option value="0">Select Country</option>
                        <?php foreach($arrCountry AS $countryId => $countryName) {
                                    $selectStr = "";
                                    if($arrFund['metAddCntry'] == $countryId) $selectStr = "selected";
                                    else if ($countryId == 9 && $arrFund['met_add_country'] == 0)
                                        $selectStr = "selected";
                                    ?><option <?=$selectStr?> value="<?=$countryId?>"><?=$countryName?></option><?
                            }
                        ?>
                    </select>
                </div>
            </td>
        </tr>
    </table>

    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>