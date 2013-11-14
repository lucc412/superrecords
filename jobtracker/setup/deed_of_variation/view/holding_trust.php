<?php
// include topbar file
include(TOPBAR);

// include navigation
include(DEEDVARNAV);

// include page content
include(DEEDVARCONTENT);

// page header
?><div class="pageheader">
    <h1>Trustee Details</h1>
    <span><b>Welcome to the Super Records trustee details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="holding_trust.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Trustee Type</td>
            <td>
                <select name="lstType" id="lstType">
                    <option value="">Select type of trustee</option><?php
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
              <td>TFN Number</td>
              <td><input type="text" name="txtTfn" id="txtTfn" value="<?=$arrHoldTrust['tfn']?>"></td>
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
    </div>

    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='fund.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>