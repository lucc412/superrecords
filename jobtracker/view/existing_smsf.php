<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>
<div class="pageheader">
	<h1>SMSF Deed of Variation</h1>
	<span>
		<b>Welcome to the Super Records SMSF deed of variation page.</b>
	<span>
</div>
<form method="post" action="existing_smsf.php?do=redirect" onsubmit="return  checkValidation();">
    <input type="hidden" name="smsf_type" id="smsf_type" value="2" />
<b>
<div class="pdT10">
	Welcome to the application page to transfer your EXISTING Self Managed Superannuation Fund (SMSF) to Super Records.
</div>

<div class="pdT10">
	Please note that Super Records is an accounting service only. We do not provide financial planning or investment advice, apart from whether investments will comply with legislation.
</div>

<div class="pdT10">
	Completing this application will result in Super Records becoming the tax agent of the fund and handling the ongoing accounting, tax and audit for your new SMSF
</div>

<div class="pdT10">
	If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please either call us or complete the enquiry form on our main page to have one of our consultants contact you.
</div>
<p class="pdT10"><input type="checkbox" value="" style="width: auto;margin-right: 10px;" name="cbAuthority" id="cbAuthority" <?php if($arrSMSF[$_SESSION["jobId"]]['authority_status']==1){echo "checked";}?> >I have received written authority from my client to utilize the services of Super Records Pty Ltd and its associated entities for the completion of work as requested.</p>
<div class="pdT10 orangeheader">
	If you are ready to continue, please click NEXT at the bottom of the page.
</div>
</b>

<div class="pdT20">
    <span align="left"><button type="button" onclick="window.location.href='jobs.php?a=order'" value="BACK" />BACK</button></span>
    <span align="right" style="padding-left:55px;"><button type="submit" id="btnNext" >NEXT</button></span>
</div>
</form>
<script>

    function checkValidation()
    {
            if($('#cbAuthority').is(':checked') == true)
            {
                //window.location.assign('jobs.php?sql=<?php if(isset($_SESSION['jobId'])){echo'update';}else{echo'insertJob';} ?>&type=SETUP&subfrmId=2');
                $('#cbAuthority').val(1);
                return true;
            }
            else
            {
                alert('please check the authority');
                $('#cbAuthority').val(0);
                return false;
            }
    }

</script>
<?
    include(FOOTER);
?>