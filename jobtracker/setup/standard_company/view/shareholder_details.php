<?php
    include(TOPBAR);
    include(STND_COMP_NAV);
    
?>
<div class="pageheader" style="padding-bottom:0;">
	<h1>Shareholder Details</h1>
	<span>
		<b>Welcome to the Super Records shareholder details page.</b>
	<span>
</div>

<div>
    <div style="padding-bottom:20px;color: #074263;font-size: 14px;">Please enter the details for your new fund. These details will be used to register the fund. If you need any help completing this section, please contact us.</div>
    <form method="post" action="shareholder_details.php" onsubmit="return checkValidation();">
       <table class="fieldtable">
            <tr>
                <td>Number of shareholder's </td>
                <td>
                    <select id="selShrHldr" name="selShrHldr" style="margin-bottom: 5px;width:180px;" onchange="addShrHldr()">
                        <option value="0">Select no of shareholder</option>
                        <?php 
                            for($i = 1;$i <= 10;$i++) {
                                $selectStr = '';
                                if($StrAddState == $i) $selectStr = 'selected';
                                ?><option <?=$selectStr?> value="<?=$i?>"><?=$i?></option><?
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <div id="dvShrHldr">
              
        </div>
        <input type="hidden" id="sql" name="sql" value="" />
        <div style="padding-top:20px;">
            <span align="left"><button type="button" onclick="window.location.href='officer_details.php'" >Back</button></span>
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