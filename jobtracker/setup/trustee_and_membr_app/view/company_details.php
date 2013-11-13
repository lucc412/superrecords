<?php

// include topbar file
include(TOPBAR);

// include navigation
include(FRMTNAV);

?><div class="pageheader">
    <h1>Company Details</h1>
    <span><b>Welcome to the Super Records company details page.</b><span>
</div>

<form id="frmCompDtls" method="post" action="company_details.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of company</td>
            <td><input type="text" name="txtCmpName" id="txtCmpName" value="<?=$arrCompDtls['comp_name']?>"></td>
        </tr>
        <tr>
            <td>ACN Number</td>
            <td><input type="text" name="txtACN" id="txtACN" value="<?=$arrCompDtls['acn']?>"></td>
        </tr>
        <tr>
            <td>Registered Address</td>
            <td><input type="text" name="txtRegAddr" id="txtRegAddr" value="<?=$arrCompDtls['reg_addr']?>"></td>
        </tr>
        <tr>
            <td>Number of Directors</td>
            <td>
                <select id="selNoDirtr" name="selNoDirtr" style="margin-bottom: 5px;width:180px;" onchange="addDirectors()">
                    <option value="0">Select no of directors</option>
                    <?php 
                        for($i = 1;$i <= 4;$i++) {
                            $selectStr = '';
                            if($arrCompDtls['no_of_directors'] == $i) $selectStr = 'selected';
                            ?><option <?=$selectStr?> value="<?=$i?>"><?=$i?></option><?
                        }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <div id="dvDirectors" style="margin-left:198px;width:auto">
        <?php if(!empty($arrCompDtls['directors_name'])) $drctrsName = explode(',', $arrCompDtls['directors_name']);                                    
        foreach ($drctrsName as $fldId => $fldvalue) {  $fldId++; ?>                                    
        <div id="dvDirtr_<?=$fldId?>" >
            <table class="fieldtable">
                <tr>
                    <td><input type="text" id="txtDirctrName_<?=$fldId?>" name="txtDirctrName[<?=$fldId?>]" value="<?=$fldvalue?>" placeholder="Director Name <?=$fldId?>" /></td>
                </tr>
            </table>
        </div>
        <?php } ?>
    </div>
    <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
    <div class="pdT20">
        <span class="pdR20"><button type="button" onclick="window.location='fund.php'" value="Back">Back</button></span>
        <span class="pdR20" ><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Preview</button></span>
    </div>
</form><?
// include footer file
include(FOOTER);
?>