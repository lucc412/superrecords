<?php
// include topbar file
include(TOPBAR);

// include navigation
include(DEATHBENEFITNOMINATION);

// include page content
include(DEATHBENEFITNOMINATIONCONTENT);
// page header
?><div class="pageheader">
    <h1>Death Benefit Nomination - Fund Details</h1>
    <span><b>Welcome to the Super Records fund details page.</b><span>
</div>
<?

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
            ?><input type="hidden" name="dirId<?=$fieldKey?>" value="<?=$director['d_id']?>">
			<p style="padding-left:165px;" id="direle<?=$fieldKey?>">
                <input type="text" name="txtDirName<?=$fieldKey?>" id="txtDirName<?=$fieldKey?>" value="<?=$director['name']?>" placeholder="Name of Director"/>
                <span class="pdL20"><input type="text" name="txtDirAdd<?=$fieldKey?>" id="txtResAdd<?=$fieldKey?>" value="<?=$director['address']?>" placeholder="Residential Address"/></span>
				</p>
                <?
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
                    $members=2;
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
            ?><input type="hidden" name="indvdlId<?=$fieldKey?>" value="<?=$indvdlTrustee['indvdl_id']?>">
				<p style="padding-left:165px;" id="ele<?=$fieldKey?>">                
                <input type="text" name="txtTrusteeFName<?=$fieldKey?>" style="width:185px;" id="txtTrusteeFName<?=$fieldKey?>" value="<?=$indvdlTrustee['fname']?>" placeholder="Name of Trustee"/>
				<input type="text" name="txtTrusteeMName<?=$fieldKey?>" style="width:185px;" id="txtTrusteeMName<?=$fieldKey?>" value="<?=$indvdlTrustee['mname']?>" placeholder="Name of Trustee"/>
				<input type="text" name="txtTrusteeLName<?=$fieldKey?>" style="width:185px;" id="txtTrusteeLName<?=$fieldKey?>" value="<?=$indvdlTrustee['lname']?>" placeholder="Name of Trustee"/>
                <input type="text" name="txtResAdd<?=$fieldKey?>" style="width:185px;" id="txtResAdd<?=$fieldKey?>" value="<?=$indvdlTrustee['address']?>" placeholder="Residential Address"/>
				</p>
				<?
        } 
        ?><!-- Dynamic div to show textboxes -->
        <br/><div id="memberbox"></div>
    </div>

    <div class="pdT20"><?
        if(!empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span class="pdR20"><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>