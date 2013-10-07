<?php

    include(TOPBAR);
    
    echo $html;
    
    if ($_SESSION['frmId'] == 1)
    { ?><div align="left">
            <span align="right"><button onclick='window.location.assign("new_smsf_declarations.php");'>Back</button></span>
            <span style="padding-left:55px;" align="right"><button onclick='window.location.assign("jobs.php?a=saved");'>Save & Exit</button></span>
            <span style="padding-left:55px;" align="right"><button onclick='window.location.assign("new_smsf_declarations.php?job_submitted=Y");'>Submit</button></span>
    </div>
<?php 
    }
    if ($_SESSION['frmId'] == 2)
    { 
?>
    <div align="left">
	<span align="right"><button onclick=' window.location.assign("existing_smsf_fund.php");'>Back</button></span>
	<span style="padding-left:55px;" align="right"><button onclick=' window.location.assign("jobs.php?a=saved");'>Save & Exit</button></span>
	<span style="padding-left:55px;" align="right"><button onclick=' window.location.assign("existing_smsf_fund.php?job_submitted=Y&preview_form=submit");'>Submit</button></span>
    </div>
<?php } ?>
                        
<?php include(FOOTER); ?>