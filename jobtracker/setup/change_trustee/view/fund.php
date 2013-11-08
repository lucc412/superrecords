<?php
// include topbar file
include(TOPBAR);

// include navigation
include(CHNGTRUSTEENAV);

// include page content
include(CHNGTRUSTEECONTENT);

// page header
?><div class="pageheader">
    <h1>Holding Trust Details</h1>
    <span><b>Welcome to the Super Records holding trust details page.</b><span>
</div><?

// content
?><form id="frmTrust" method="post" action="fund.php">
    <input type="hidden" name="saveData" value="Y">
    <input type="hidden" name="frmId" value="<?=$_REQUEST['frmId']?>">
    <table class="fieldtable" width="60%" cellpadding="10px;">
        <tr>
            <td>Name of Trust</td>
            <td><input type="text" name="txtTrust" id="txtTrust" value="<?=$arrHoldTrust['trust_name']?>"></td>
        </tr>
    </table>

    <div class="pdT20"><?
        if(empty($_SESSION['jobId'])){?><span class="pdR20"><button type="button" onclick="window.location='<?=DIR?>setup.php'" value="Back">Back</button></span><?}
        ?><span><button type="submit" id="submit" name="next">Next</button></span>
    </div>
</form><?

// include footer file
include(FOOTER);
?>