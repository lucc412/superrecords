<?php
// include topbar file
include(TOPBAR);

// include navigation
include(CHNGTRUSTEENAV);

// include page content
include(CHNGTRUSTEECONTENT);

// page header
?><div class="pageheader">
    <h1>Lender Details</h1>
    <span><b>Welcome to the Super Records lender details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="existing_trustee.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Type of lender</td>
            <td>
                <select name="lstType" id="lstType">
                    <option value="">Select type of lender</option><?php
                    foreach($arrTrusteeType AS $typeId => $typeDesc){
                            $selectStr = "";
                            if($arrHoldTrust['trustee_id'] == $typeId) $selectStr = "selected";
                            ?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
                    }
                ?></select>
            </td>
        </tr>
    </table><?
    
    $dispCorporate = "style='display:none'";
    if($arrHoldTrust['trustee_id'] == '2') $dispCorporate = "style='display:block'";
    ?><div id="divCorporate" class="pdT10" <?=$dispCorporate?>>
          <div class="frmMidHeader">Company Details</div>
          <table class="fieldtable" width="50%" cellpadding="10px;">
          <tr>
              <td>Name of company</td>
              <td><input type="text" name="txtCompName" id="txtCompName" value="<?=$arrHoldTrust['comp_name']?>"></td>
          </tr>
          <tr>
              <td>ACN Number</td>
              <td><input type="text" name="txtAcn" id="txtAcn" value="<?=$arrHoldTrust['acn']?>"></td>
          </tr>
          <tr>
              <td>Registered Address</td>
              <td><textarea name="txtAdd" id="txtAdd"><?=$arrHoldTrust['reg_address']?></textarea>
          </tr>
          <tr>
              <td>Directors</td>
              <td><?
                  $arrDirectorName = stringToArray('|', $arrHoldTrust['director']);
                  $dirCnt=0;
                  $placeHolderCnt=1;
                  while($dirCnt<4) {
                      ?><input type="text" name="dir<?=$dirCnt?>" id="dir<?=$dirCnt?>" placeholder="Director <?=$placeHolderCnt?>" value="<?=$arrDirectorName[$dirCnt]?>"/><br/><?
                      $dirCnt++;
                      $placeHolderCnt++;
                  }     
             ?></td>
          </tr>
      </table>
    </div><?
    $dispIndividual = "style='display:none'";
    if($arrHoldTrust['trustee_id'] == '1') $dispIndividual = "style='display:block'";
    ?><div id="divIndividual" class="pdT10" <?=$dispIndividual?>>
        <div class="frmMidHeader">Individual Details</div>
        <table class="fieldtable" width="45%" cellpadding="10px;">
          <tr>
              <td>No of individuals</td>
              <td><select name="lstMember" id="lstMember">
                    <option value="">Select no of individuals</option><?
                    $members=1;
                    while($members<=4) {
                        $selectMember="";
                        if($arrHoldTrust['noofmember'] == $members) $selectMember = "selected";
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
                    <input type="text" name="txtTrusteeName<?=$fieldKey?>" id="txtTrusteeName<?=$fieldKey?>" value="<?=$indvdlTrustee['name']?>" placeholder="Name"/>
                    <span class="pdL20">
                        <input type="text" name="txtResAdd<?=$fieldKey?>" id="txtResAdd<?=$fieldKey?>" value="<?=$indvdlTrustee['address']?>" placeholder="Residential Address"/>
                    </span><?
        } 
        ?><!-- Dynamic div to show textboxes -->
        <br/><div id="memberbox"></div>
    </div>

    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='fund.php'" value="Back">Back</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>