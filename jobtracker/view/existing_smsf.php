<?php
include(TOPBAR);
?>
<div class="pageheader">
	<h1>SMSF Deed of Variation</h1>
	<span>
		<b>Welcome to the Super Records SMSF Deed of Variation page.</b>
	<span>
</div>

<div style="padding-top:20px;">
	Welcome to the application page to transfer your EXISTING Self Managed Superannuation Fund (SMSF) to befreesuper.
</div>

<div style="padding-bottom:10px;padding-top:10px;">
	Please note that befreesuper is an accounting service only. We do not provide financial planning or investment advice, apart from whether investments will comply with legislation.
</div>

<div style="padding-bottom:10px;">
	Completing this application will result in befreesuper becoming the tax agent of the fund and handling the ongoing accounting, tax and audit for your new SMSF
</div>

<div style="padding-bottom:10px;">
	If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please either call us or complete the enquiry form on our main page to have one of our consultants contact you.
</div>

<div style="padding-bottom:10px;">
	If you are ready to continue, please click NEXT at the bottom of the page.
</div>

<div style="padding-top:20px;" >
    <span align="left"><button type="button" onclick="window.location.href='jobs.php?a=edit&recid=<?=$_SESSION['jobId']?>&frmId=2'" value="BACK" />BACK</button></span>
    <span align="right" style="padding-left:55px;"><button type="button" onclick="javascript:window.location.assign('existing_smsf_contact.php');">NEXT</button></span>
</div>
<?
    include(FOOTER);
?>