<?php
// include topbar file
include(TOPBAR);

// include navigation
include(DEATHBENEFITNOMINATION);

// include page content
include(DEATHBENEFITNOMINATIONCONTENT);

// page header
?><div class="pageheader">
    <h1>Death Benefit Nomination - Nomination Details</h1>
    <span><b>Welcome to the Super Records nomination details page.</b><span>
</div>
<?

// content
?><form id="frmBenef" method="post" action="nomination.php">
    <input type="hidden" name="saveData" value="Y">
    <table class="fieldtable" width="100%" cellpadding="10px;">
        <tr>
            <td width="20%">Name of Member</td>
            <td><input type="text" name="txtName" id="txtName" value="<?=$arrNomination['name']?>"></td>
        </tr>
        <tr>
            <td>Residential Address</td>
            <td><textarea name="txtAdd" id="txtAdd"><?=$arrNomination['res_add']?></textarea></td>
        </tr>
		 <tr>
            <td>Date of Birth </td>
            <td>
                <input type="text" style="width:70px" id="txtDob" readonly="true" name="txtDob" size="10" value="<?=$arrNomination['dob']?>"/>
                <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/>
            </td>
        </tr>
        <tr>
			<td>Number of Beneficiaries</td>
			<td><select name="beneficiaries" id="beneficiaries">
			    <option value="">Select number of beneficiaries</option><?
			    $dirCnt=1;
			    while($dirCnt<=4) {
			        $selectdir="";
			        if($arrNomination['noofbeneficiars'] == $dirCnt) $selectdir = "selected";
			        ?><option <?=$selectdir?>><?=$dirCnt?></option><?
			        $dirCnt++;
			    }
			?></select>
			</td>
          </tr>
		  <tr>
		  	<td>&nbsp;</td>
			<td>
      			<?
			        foreach ($arrNominationBref AS $fieldKey => $director){            
			            ?><input type="hidden" name="benef_id<?=$fieldKey?>" value="<?=$director['benef_id']?>">
						<p style="" id="direle<?=$fieldKey?>">
			                <input type="text" style="width: 160px;" name="txtName<?=$fieldKey?>" id="txtName<?=$fieldKey?>" value="<?=$director['name']?>" placeholder="Full Name"/>                
			                <span>
			                    <input type="text" name="txtDob<?=$fieldKey?>" id="txtDob<?=$fieldKey?>" style="width:70px;" value="<?=$director['dob']?>" placeholder="Dob" readonly/>
			                    <img src="<?=CALENDARICON?>" id="calImgId" onclick="javascript:NewCssCal('txtDob<?=$fieldKey?>','ddMMyyyy')" align="middle" class="calendar"/>
			                </span>
							<span><input type="text" style="width: 160px;" name="txtAdd<?=$fieldKey?>" id="txtAdd<?=$fieldKey?>" value="<?=$director['res_add']?>" placeholder="Residential Address"/></span>
							<span><input type="text" style="width: 70px;" name="txtRelationship<?=$fieldKey?>" id="txtRelationship<?=$fieldKey?>" value="<?=$director['relationship']?>" placeholder="Relationship"/></span>
							<span><input type="text" style="width: 160px;" name="txtportion<?=$fieldKey?>" id="txtportion<?=$fieldKey?>" value="<?=$director['portion']?>" placeholder="Portion (%) of Death Benefit"/></span>
							</p>
						<?
			        	} 
        ?><!-- Dynamic div to show directors -->
        <div id="directorbox"></div>
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