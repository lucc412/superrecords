<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?><div class="pageheader">
	<h1>SMSF Deed of Establishment</h1>
	<span>
		<b>Welcome to the Super Records SMSF deed of establishment page.</b>
	<span>
</div>
<form method="post" action="new_smsf.php" onsubmit="return  checkValidation();">
    <input type="hidden" name="flagUpdate" id="flagUpdate" value="Y" />
    <input type="hidden" name="job_type" id="smsf_type" value="SETUP" />
    <input type="hidden" name="lstClientType" value="25"/>
<div class="introduction">
	<p><input type="checkbox" style="padding-bottom:2px;" class="checkboxClass" name="cbApply" id="cbApply" <?php if(!empty($arrSMSF['apply_abntfn'])){echo "checked";}?> >Please select if you would like us to <em>apply for ABN/TFN for new SMSF</em>, please note <span>Super Records</span> and/or its associated entities will become the tax agent of the fund.</p>
    
	<p class="pdB15"><input type="checkbox" class="checkboxClass" name="cbAuthority" id="cbAuthority" <?php if(!empty($arrSMSF['authority_status'])){echo "checked";}?> >I have received written authority from my client to utilise the services of <span>Super Records Pty Ltd</span> and its associated entities for the completion of work as requested.</p>
	
	<p>If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please contact us.</p> 
</div>

<div class="pdT20">
    <?php if(empty($_SESSION['jobId'])){ ?><span align="left"><button type="button" onclick="window.location.href='jobs.php?a=order'" value="BACK" />Back</button></span><? } ?>
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