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
<div class="introduction">
	<div class="pdT10">
		Welcome to the application page to <em>transfer your Existing Self Managed Superannuation Fund (SMSF)</em> to <span>Super Records</span>. <br/>Please note that <span>Super Records</span> is an accounting service only. We do not provide financial planning or investment advice, apart from whether investments will comply with legislation. Completing this application will result <br/>in <span>Super Records</span> becoming the tax agent of the fund and handling the ongoing accounting, tax and audit for your new SMSF.
	</div>
	<div class="pdT10">
		If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please either call us or complete the enquiry form on our<br/> main page to have one of our consultants contact you.
	</div>
	<p class="pdT10"><input type="checkbox" value="" style="width: auto;margin-right: 10px;" name="cbAuthority" id="cbAuthority" <?php if($arrSMSF['apply_abntfn']==1){echo "checked";}?> >I have received written authority from my client to utilize the services of <span>Super Records Pty Ltd</span> and its associated entities for the completion of work as requested.</p>
</div>

<div class="pdT20">
    <?php if(empty($_SESSION['jobId'])){ ?><span align="left"><button type="button" onclick="window.location.href='jobs.php?a=order'" value="BACK" />Back</button></span><?php } ?>
    <span align="right" style="<?php if(!isset($_SESSION['jobId'])){ echo'padding-left:55px;'; } ?>"><button type="submit" id="btnNext" >Next</button></span>
</div>
</form>
<script>

    function checkValidation()
    {
            if($('#cbAuthority').is(':checked') == true)
            {
                $('#cbAuthority').val(1);
                return true;
            }
            else
            {
                alert('Please tick if you have received written authority from your client.');
                $('#cbAuthority').val(0);
                return false;
            }
    }

</script>
<?
    include(FOOTER);
?>