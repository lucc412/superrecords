<?php
// include topbar file
include(TOPBAR);

// include navigation
include(DEEDVARNAV);

// include page content
include(DEEDVARCONTENT);

// page header
?><div class="pageheader" style="padding-bottom:0;">
	<h1>Member Details</h1>
	<span>
		<b>Welcome to the Super Records member details page.</b>
	<span>
</div>
<div class="pdT20">
    <form method="post" id="frmMember" action="member.php">
        <table class="fieldtable">
            <tr>
                <td>Number of members </td>
                <td>
                    <select id="selMembers" name="selMembers" style="margin-bottom: 5px;width:180px;" onchange="addMembers()">
                        <option value="0">Select no of members</option>
                        <?php 
                            for($intCnt = $memeberStartCnt;$intCnt <= 4;$intCnt++) 
                            {
                                $selectStr = '';
                                if(count($arrMembrData) == $intCnt) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$intCnt?>"><?=$intCnt?></option><?
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        
        <div id="divMember">
            <?php
                                    
                if(!empty($arrMembrData))
                {
                     $cntr = 0;
                    foreach($arrMembrData as $key => $value) 
                    { 
                        $cntr++;
                    
                        ?><div id="member_<?=$cntr?>"> 
                            <div style="padding:10px 0;color: #F05729;font-size: 14px;">Member <?=$cntr?>:</div>
                            <input type="hidden" name="offcrId[<?=$cntr?>]" id="offcrId" value="<?=$value['member_id']?>">
                            <table class="fieldtable">
                                <tr>
                                    <td>First name </td>
                                    <td><input type="text" id="txtFname_<?=$cntr?>" name="txtFname[<?=$cntr?>]" value="<?=$value['fname']?>"  /></td>
                                </tr>
                                <tr>
                                    <td>Middle name </td>
                                    <td><input type="text" id="txtMname_<?=$cntr?>" name="txtMname[<?=$cntr?>]" value="<?=$value['mname']?>" /></td>
                                </tr>
                                <tr>
                                    <td>Last name </td>
                                    <td><input type="text" id="txtLname_<?=$cntr?>" name="txtLname[<?=$cntr?>]" value="<?=$value['lname']?>" /></td>
                                </tr>
                                <tr>
                                    <td>Date of birth </td>
                                    <td><input type="text" id="txtDob_<?=$cntr?>" name="txtDob[<?=$cntr?>]" value="<?=date("d/m/Y",strtotime($value['dob']))?>" readonly="" /><img src="../../images/calendar.png" id="calImgId" onclick="javascript:NewCssCal('txtDob_<?=$cntr?>','ddMMyyyy','dropdown',false,24,false,'past')" align="middle" class="calendar"/></td>
                                </tr>
                                <tr>
                                    <td>City of birth </td>
                                    <td><input type="text" id="txtCob_<?=$cntr?>" name="txtCob[<?=$cntr?>]" value="<?=$value['city_birth']?>" /><td>
                                </tr>
                                <tr>
                                    <td>Country of birth </td>
                                    <td><select id="selCntryob_<?=$cntr?>" name="selCntryob[<?=$cntr?>]" style="margin-bottom:5px; width:180px;" >
                                            <option value="0">Select Country</option><?php foreach($arrCountry AS $cntryKey => $cntryName) { $selectStr = ""; if($value['cntry_birth'] == $cntryKey) $selectStr = "selected"; ?><option <?=$selectStr?> value="<?=$cntryKey?>"><?=$cntryName?></option><? } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Residential Address </td>
                                    <td><input type="text" id="txtResAdd_<?=$cntr?>" name="txtResAdd[<?=$cntr?>]" value="<?=$value['res_add']?>"  /></td>
                                </tr>
                                <tr>
                                    <td>Tax File Number </td>
                                    <td><input type="text" id="txtTFN_<?=$cntr?>" name="txtTFN[<?=$cntr?>]" value="<?=$value['tfn']?>"  /></td>
                                </tr>
                            </table>
                        </div>
                <?php    
                    }   
                }
            ?>
        </div>
        <input type="hidden" id="sql" name="sql" value="update" />
        <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div> 
        <div style="padding-top:20px;"> 
            <span class="pdR20"><button type="button" onclick="window.location.href='holding_trust.php'" >Back</button></span>
            <span class="pdR20"><button type="submit" name="save" id="btnSave">Save & Exit</button></span>
            <span><button type="submit" name="next" id='btnNext'>Preview</button></span>
        </div>
    </form>
</div>
<? include(FOOTER); ?>