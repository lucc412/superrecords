<?php
    include(TOPBAR);
    include(STND_COMP_NAV);
    
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Officer Details</h1>
	<span>
		<b>Welcome to the Super Records officer details page.</b>
	<span>
</div>
<div>
    <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your company. These details will be used to register the company. If you need any help completing this section, please contact us.</div>
    <form method="post" action="officer_details.php" onsubmit="return  checkValidation();">
        <div id="dvOfficer">
        <table class="fieldtable">
            <tr>
                <td>Number of officers </td>
                <td>
                    <select id="selOfficers" name="selOfficers" style="margin-bottom: 5px;width:180px;" onchange="addOfficers()">
                        <option value="0">Select no of officer`s</option>
                        <?php 
                            $arrCount = array(1,2,3,4,5,6,7,8,9,10);
                            foreach($arrCount AS $count) {
                                $selectStr = '';
                                if($StrAddState == $count) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$count?>"><?=$count?></option><?
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        </div>
        <br/>
        <div style="padding-bottom:20px;color: #F05729;font-size: 14px;">Principal Business Address</div>
        <table class="fieldtable">
            <tr>
                <td style="padding-right: 95px;" >Address</td>
                <td>
                    <div>
                        <input type="text" name="busAddUnit" style="width:115px;" value="<?=$StrAddUnit?>" placeholder="Unit number" />
                        <input type="text" name="busAddBuild" style="width:115px;" value="<?=$StrAddBuild?>" placeholder="Building" />
                        <input type="text" name="busAddStreet" style="width:115px;" value="<?=$StrAddStreet?>" placeholder="Street"/><br>
                        <input type="text" name="busAddSubrb" style="width:115px;" value="<?=$StrAddSubrb?>" placeholder="Suburb"/>
                        <select name="busAddState" style="margin-bottom: 5px;width:180px;" >
                            <option value="0">Select State</option>
                            <?php foreach($arrStates AS $stateKey => $stateName) {
                                        $selectStr = '';
                                        if($StrAddState == $stateKey) $selectStr = 'selected';
                                        ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                }
                            ?>
                        </select><br>
                        <input type="text" name="busAddPstCode" value="<?=$StrAddPstCode?>" placeholder="Post Code"/> 
                    </div>
                </td>
            </tr>
        </table>
        <br/>
        <div style="padding-bottom:20px;color: #F05729;font-size: 14px;">Meeting Address</div>
        <table class="fieldtable">
            <tr>
                <td style="padding-right: 95px;" >Address</td>
                <td>
                    <div>
                        <input type="text" name="metAddUnit" style="width:115px;" value="<?=$StrAddUnit?>" placeholder="Unit number" />
                        <input type="text" name="metAddBuild" style="width:115px;" value="<?=$StrAddBuild?>" placeholder="Building" />
                        <input type="text" name="metAddStreet" style="width:115px;" value="<?=$StrAddStreet?>" placeholder="Street"/><br>
                        <input type="text" name="metAddSubrb" style="width:115px;" value="<?=$StrAddSubrb?>" placeholder="Suburb"/>
                        <select name="metAddState" style="margin-bottom: 5px;width:180px;" >
                            <option value="0">Select State</option>
                            <?php foreach($arrStates AS $stateKey => $stateName) {
                                        $selectStr = '';
                                        if($StrAddState == $stateKey) $selectStr = 'selected';
                                        ?><option <?=$selectStr?> value="<?=$stateKey?>"><?=$stateName?></option><?
                                }
                            ?>
                        </select><br>
                        <input type="text" name="metAddPstCode" value="<?=$StrAddPstCode?>" placeholder="Post Code"/> 
                    </div>
                </td>
            </tr>
        </table>
        <input type="hidden" id="sql" name="sql" value="" />
        <div style="padding-top:20px;">
            <span align="left"><button type="button" onclick="window.location.href='address_details.php'" >Back</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit"  id='btnNext'>Next</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">Save & Exit</button></span>
        </div>
    </form>
    <script>
        $('#btnNext').click(function(){$('#sql').val('Add')})
        $('#btnSave').click(function(){$('#sql').val('Save')})
    </script>
</div>
<? include(FOOTER); ?>