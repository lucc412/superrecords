<?php
// include topbar file
include(TOPBAR);

// include navigation
include(RETPENSNNAV);


// page header
?><div class="pageheader">
    <h1>Trustee Details</h1>
    <span><b>Welcome to the Super Records trustee details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="trustee.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Trustee Type</td>
            <td>
                <select id="selTrstyType" name="selTrstyType" >
                    <option value="">Select trustee type</option>
                    <?php 
                        $arrTrstyType = array(1=>"Individual",2=>"Corporate");
                        foreach ($arrTrstyType as $key => $value) {
                            $sel = "";
                            if($key == $arrTrusty['trusty_type']) $sel = "selected";
                            ?><option value="<?=$key?>" <?=$sel?>><?=$value?></option><?php
                        }
                    ?>
                </select>
            </td>
        </tr>
    </table><?
    
    $dispCorporate = "style='display:none'";
    if($arrTrusty['trusty_type'] == 2) $dispCorporate = "style='display:block'";
    ?><div id="divCorporate" class="pdT10" <?=$dispCorporate?> >
          <div class="frmMidHeader">Trustee Company Details</div>
          <table class="fieldtable" width="50%" cellpadding="10px;">
          <tr>
              <td>Name of company</td>
              <td><input type="text" name="txtCompName" id="txtCompName" value="<?=$arrCorpTrust['comp_name']?>"></td>
          </tr>
          <tr>
              <td>ACN Number</td>
              <td><input type="text" name="txtAcn" id="txtAcn" value="<?=$arrCorpTrust['acn']?>"></td>
          </tr>
          <tr>
              <td>Registered Address</td>
              <td><textarea name="txtAdd" id="txtAdd"><?=$arrCorpTrust['reg_add']?></textarea>
          </tr>
          <tr>
              <td>Directors</td>
              <td><?
                  $arrDirectorName = stringToArray('|', $arrCorpTrust['directors']);
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
    if($arrTrusty['trusty_type'] == 1) $dispIndividual = "style='display:block'";
    ?><div id="divIndividual" class="pdT10" <?=$dispIndividual?>>
        <div class="frmMidHeader">Individual Trustee Details</div>
        <table class="fieldtable" width="45%" cellpadding="10px;">
          <tr>
              <td>No of Trustees</td>
              <td><select name="selMember" id="selMember">
                    <option value="">Select no of trustees</option><?
                    $members=2;
                    while($members<=4) {
                        $selectMember="";
                        if($arrTrusty['no_of_members'] == $members) $selectMember = "selected";
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
                    <input style="width:170px" type="text" name="txtFName<?=$fieldKey?>" id="txtFName<?=$fieldKey?>" value="<?=$indvdlTrustee['fname']?>" placeholder="First Name"/>
                    <span class="pdL10"><input style="width:95px" type="text" name="txtMName<?=$fieldKey?>" id="txtMName<?=$fieldKey?>" value="<?=$indvdlTrustee['mname']?>" placeholder="Middle Name"/></span>
                    <span class="pdL10"><input style="width:170px" type="text" name="txtLName<?=$fieldKey?>" id="txtLName<?=$fieldKey?>" value="<?=$indvdlTrustee['lname']?>" placeholder="Last Name"/></span>
                    <span class="pdL10"><input style="width:170px" type="text" name="txtResAdd<?=$fieldKey?>" id="txtResAdd<?=$fieldKey?>" value="<?=$indvdlTrustee['res_add']?>" placeholder="Residential Address"/></span>
                    <?
        } 
        ?><!-- Dynamic div to show textboxes -->
        <br/><div id="memberbox"></div>
    </div>
    <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='fund.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>