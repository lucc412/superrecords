<?php
// include topbar file
include(TOPBAR);

// include navigation
include(FRMTNAV);

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
            <td>Name of new Director</td>
            <td><input type="text" name="txtNwDirctr" id="txtNwDirctr" value="<?=$arrFund['new_director_name']?>"></td>
        </tr>
        <tr>
            <td>Residential Address</td>
            <td>
                <div>
                    <input type="text" name="resAddUnit" id="resAddUnit" style="width:115px;" value="<?=$arrFund['res_add_unit']?>" placeholder="Unit number" />
                    <input type="text" name="resAddBuild" id="resAddBuild" style="width:115px;" value="<?=$arrFund['res_add_build']?>" placeholder="Building" />
                    <input type="text" name="resAddStreet" id="resAddStreet" style="width:115px;" value="<?=$arrFund['res_add_street']?>" placeholder="Street"/><br>
                    <input type="text" name="resAddSubrb" id="resAddSubrb" style="width:115px;" value="<?=$arrFund['res_add_subrb']?>" placeholder="Suburb"/>
                    <select name="resAddState" id="resAddState" style="margin-bottom: 5px;width:180px;" >
                        <option value="0">Select State</option>
                        <?php foreach($arrStates AS $stateKey => $stateName) {
                                $selectStr = '';
                                if($arrFund['res_add_state'] == $stateKey) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                            }
                        ?>
                    </select><br>
                    <input type="text" name="resAddPstCode" id="resAddPstCode" value="<?=$arrFund['res_add_pst_code']?>" placeholder="Post Code"/> 
                </div>
            </td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td>
                <input type="text" style="width:70px" id="txtDob" readonly="true" name="txtDob" size="10" value="<?
                $dob = $arrFund['dob'];
                if(isset($dob) && $dob != "") 
                {
                    if($dob != "0000-00-00") 
                    {
                        if($dob == '01/01/1970') $dob = '';
                    }
                    else{
                        $dob='';
                    }
                }  
                echo($dob);
                             
                ?>" />
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/>
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