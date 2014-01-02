<?php
// include topbar file
include(TOPBAR);

// include navigation
include(MARKETLINKEDPENSION);

//Content
include(MARKETLINKEDPENSIONCONTENT);

// page header
?><div class="pageheader">
    <h1>Fund Details</h1>
    <span><b>Welcome to the Super Records Market Linked Pension fund details page.</b><span>
</div>

<form id="frmFund" method="post" action="fund.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of the Fund</td>
            <td><input type="text" name="txtFund" id="txtFund" value="<?=isset($arrFund['fund_name'])?$arrFund['fund_name']:"";?>"></td>
        </tr>
        <tr>
            <td>Meeting Address</td>
            <td>
                <textarea name="mtAdd" id="mtAdd"><?=isset($arrFund['mt_add'])?$arrFund['mt_add']:"";?></textarea>
            </td>
        </tr>        
    </table>
    
    <div class="pdT20"><?
        if(empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span class="pdR20" ><button type="submit" id="submit" name="save">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?
// include footer file
include(FOOTER);
?>