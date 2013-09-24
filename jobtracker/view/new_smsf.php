<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?><div class="pageheader">
	<h1>SMSF Deed of Establishment</h1>
	<span>
		<b>Welcome to the Super Records SMSF deed of establishment page.</b>
	<span>
</div>
<form method="post" action="new_smsf.php?do=redirect" onsubmit="return  checkValidation();">
    <input type="hidden" name="smsf_type" id="smsf_type" value="1" />
<div class="introduction"><b>
	<br/><div>
		<span>Completing this application will result in:</span>
		<p class="pdL20 pdB8">1. A new SMSF being set up for you by Super Records.</p>
		<p class="pdL20 pdB8">2. For ABN/TFN set up purposes, Super Records will become the tax agent of the fund.</p>
	</div><br/>

	If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please contact us.<br/><br/>
        <p><input type="checkbox" value="" style="width: auto;margin-right: 10px;" name="cbAuthority" id="cbAuthority" <?php if($arrSMSF[$_SESSION["jobId"]]['authority_status']==1){echo "checked";}?> >I have received written authority from my client to utilise the services of Super Records Pty Ltd and its associated entities for the completion of work as requested.</p><br/>
	<p class="orangeheader">If you are ready to continue, please click NEXT at the bottom of the page.</p>
        
        
</b></div>
<input type="hidden" name="lstClientType" value="25"/>
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
                //window.location.assign('jobs.php?sql=<?php if(isset($_SESSION['jobId'])){echo'update';}else{echo'insertJob';} ?>&type=SETUP&subfrmId=1');
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