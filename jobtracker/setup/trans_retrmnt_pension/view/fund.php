<?php
// include topbar file
include(TOPBAR);

// include navigation
include(RETPENSNNAV);

// page header
?><div class="pageheader">
    <h1>Fund Details</h1>
    <span><b>Welcome to the Super Records fund details page.</b><span>
</div>

<form id="frmFund" method="post" action="fund.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of the Fund</td>
            <td><input type="text" name="txtFund" id="txtFund" value="<?=$arrFund['fund_name']?>"></td>
        </tr>
        <tr>
            <td>Meeting Address</td>
            <td>
                <div>
                    <input type="text" name="mtAddUnit" id="mtAddUnit" style="width:115px;" value="<?=$arrFund['mt_add_unit']?>" placeholder="Unit number" />
                    <input type="text" name="mtAddBuild" id="mtAddBuild" style="width:115px;" value="<?=$arrFund['mt_add_build']?>" placeholder="Building" />
                    <input type="text" name="mtAddStreet" id="mtAddStreet" style="width:115px;" value="<?=$arrFund['mt_add_street']?>" placeholder="Street"/><br>
                    <input type="text" name="mtAddSubrb" id="mtAddSubrb" style="width:115px;" value="<?=$arrFund['mt_add_subrb']?>" placeholder="Suburb"/>
                    <select name="mtAddState" id="mtAddState" style="margin-bottom: 5px;width:180px;" >
                        <option value="0">Select State</option>
                        <?php foreach($arrStates AS $stateKey => $stateName) {
                                $selectStr = '';
                                if($arrFund['mt_add_state'] == $stateKey) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                            }
                        ?>
                    </select><br>
                    <input type="text" name="mtAddPstCode" id="mtAddPstCode" value="<?=$arrFund['mt_add_pst_code']?>" placeholder="Post Code"/> 
                    <select id="mtAddCntry" name="mtAddCntry" style="margin-bottom: 5px;width:135px;" >
                        <option value="0">Select Country</option>
                        <?php foreach($arrCountry AS $countryId => $countryName) {
                                    $selectStr = "";
                                    if($arrFund['mt_add_cntry'] == $countryId) $selectStr = "selected";
                                    else if ($countryId == 9 && $arrFund['mt_add_cntry'] == 0)
                                        $selectStr = "selected";
                                    ?><option <?=$selectStr?> value="<?=$countryId?>"><?=$countryName?></option><?
                            }
                        ?>
                    </select>
                </div>
            </td>
        </tr>        
    </table>
    
    <div class="pdT20"><?
        if(empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span class="pdR20" ><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?
// include footer file
include(FOOTER);
?>