<?php
// include topbar file
include(TOPBAR);

// include navigation
include(INVSTMNTSTRAGYNAV);

// page header
?><div class="pageheader">
    <h1>Fund Details</h1>
    <span><b>Welcome to the Super Records fund details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="fund.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of Fund</td>
            <td><input type="text" name="txtFund" id="txtFund" value="<?=$arrFund['fund']?>"></td>
        </tr>
        <tr>
            <td>Date of Establishment </td>
            <td>
                <input type="text" style="width:70px" id="txtDtEstblshmnt" readonly="true" name="txtDtEstblshmnt" size="10" value="<?=$arrFund['dt_estblshmnt']?>"/>
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDtEstblshmnt','ddMMyyyy')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
            <td>Date of Meeting </td>
            <td>
                <input type="text" style="width:70px" id="txtDtMeeting" readonly="true" name="txtDtMeeting" size="10" value="<?=$arrFund['dt_meeting']?>"/>
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDtMeeting','ddMMyyyy')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
            <td>Meeting Address</td>
            <td><input type="text" name="txtMetAdd" id="txtMetAdd" value="<?=$arrFund['met_add']?>"></td>
        </tr>
        <tr>
            <td>Trustee Type</td>
            <td>
                <select name="lstType" id="lstType">
                    <option value="">Select Trustee Type</option><?php
                    foreach($arrTrusteeType AS $typeId => $typeDesc){
                            $selectStr = "";
                            if($arrFund['trustee_id'] == $typeId) $selectStr = "selected";
                            ?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
                    }
                ?></select>
            </td>
        </tr>
    </table><?
    
    $dispCorporate = "style='display:none'";
    if($arrFund['trustee_id'] == '2') $dispCorporate = "style='display:block'";
    ?><div id="divCorporate" class="pdT10" <?=$dispCorporate?>>
          <div class="frmMidHeader">Company Details</div>
          <table class="fieldtable" width="50%" cellpadding="10px;">
          <tr>
              <td>Name of company</td>
              <td><input type="text" name="txtCompName" id="txtCompName" value="<?=$arrFund['comp_name']?>"></td>
          </tr>
          <tr>
              <td>ACN Number</td>
              <td><input type="text" name="txtAcn" id="txtAcn" value="<?=$arrFund['acn']?>"></td>
          </tr>
          <tr>
              <td>Registered Address</td>
              <td><textarea name="txtAdd" id="txtAdd"><?=$arrFund['reg_address']?></textarea>
          </tr>
          <tr>
              <td>No of Directors</td>
              <td><select name="lstDirector" id="lstDirector">
                    <option value="">Select no of directors</option><?
                    $dirCnt=1;
                    while($dirCnt<=4) {
                        $selectdir="";
                        if($arrFund['noofdirector'] == $dirCnt) $selectdir = "selected";
                        ?><option <?=$selectdir?>><?=$dirCnt?></option><?
                        $dirCnt++;
                    }
                ?></select>
              </td>
          </tr>
      </table><?
        foreach ($arrDirectors AS $fieldKey => $director){            
            ?><p style="padding-left:165px;" id="direle<?=$fieldKey?>">
                <input type="hidden" name="dirId<?=$fieldKey?>" value="<?=$director['indvdl_id']?>">
                <input type="text" name="txtDirName<?=$fieldKey?>" id="txtDirName<?=$fieldKey?>" value="<?=$director['name']?>" placeholder="Name of Director"/>
                <span class="pdL20"><input type="text" name="txtDirAdd<?=$fieldKey?>" id="txtResAdd<?=$fieldKey?>" value="<?=$director['address']?>" placeholder="Residential Address"/></span>
                <span class="pdL20">
                    <input type="text" name="txtDirDob<?=$fieldKey?>" id="txtDirDob<?=$fieldKey?>" style="width:70px;" value="<?=$director['dob']?>" placeholder="Dob" readonly/>
                    <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDirDob<?=$fieldKey?>','ddMMyyyy')" align="middle" class="calendar"/>
                </span><?
        } 
        ?><!-- Dynamic div to show directors -->
        <br/><div id="directorbox"></div>
    </div><?
    $dispIndividual = "style='display:none'";
    if($arrFund['trustee_id'] == '1') $dispIndividual = "style='display:block'";
    ?><div id="divIndividual" class="pdT10" <?=$dispIndividual?>>
        <div class="frmMidHeader">Individual Details</div>
        <table class="fieldtable" width="45%" cellpadding="10px;">
          <tr>
              <td>No of Trustees</td>
              <td><select name="lstMember" id="lstMember">
                    <option value="">Select no of trustees</option><?
                    $members=1;
                    while($members<=4) {
                        $selectMember="";
                        if($arrFund['noofmember'] == $members) $selectMember = "selected";
                        ?><option <?=$selectMember?>><?=$members?></option><?
                        $members++;
                    }
                ?></select>
              </td>
          </tr>
         </table><?
        foreach ($arrIndvdlTrust AS $fieldKey => $indvdlTrustee){            
            ?><p style="padding-left:165px;" id="ele<?=$fieldKey?>">
                <input type="hidden" name="indvdlId<?=$fieldKey?>" value="<?=$indvdlTrustee['indvdl_id']?>">
                <input type="text" name="txtTrusteeName<?=$fieldKey?>" id="txtTrusteeName<?=$fieldKey?>" value="<?=$indvdlTrustee['name']?>" placeholder="Name of Trustee"/>
                <span class="pdL20"><input type="text" name="txtResAdd<?=$fieldKey?>" id="txtResAdd<?=$fieldKey?>" value="<?=$indvdlTrustee['address']?>" placeholder="Residential Address"/></span>
                <span class="pdL20">
                    <input type="text" name="txtDob<?=$fieldKey?>" id="txtDob<?=$fieldKey?>" style="width:70px;" value="<?=$indvdlTrustee['dob']?>" placeholder="Dob" readonly/>
                    <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob<?=$fieldKey?>','ddMMyyyy')" align="middle" class="calendar"/>
                </span><?
        } 
        ?><!-- Dynamic div to show textboxes -->
        <br/><div id="memberbox"></div>
    </div>

    <div class="pdT20"><?
        if(empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>