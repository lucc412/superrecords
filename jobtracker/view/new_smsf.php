<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?><div class="pageheader">
	<h1>SMSF Deed of Establishment</h1>
	<span>
		<b>Welcome to the Super Records SMSF deed of establishment page.</b>
	<span>
</div>

<div class="introduction"><b>
	<!--<div>
		<span>Before you begin:</span>
		<div>
			<p class="pdL20 pdB8">
				1. It is recommended that you have spoken to an advisor about whether setting up a SMSF is the right choice for your circumstances.
			</p>
			<p class="pdL20 pdB8">
				2. It is recommended that you have spoken to an advisor about whether you need a corporate trustee or not. You can access an outline of using a corporate trustee as opposed to individuals as trustees by clicking this link.
			</p>
			<p class="pdL20 pdB8">
				3. Ensure you have complete details for every proposed member of the SMSF, including their tax file numbers.
			</p>
		</div>
	</div>-->

	<br/><div>
		<span>Completing this application will result in:</span>
		<p class="pdL20 pdB8">1. A new SMSF being set up for you by Super Records.</p>
		<p class="pdL20 pdB8">2. For ABN/TFN set up purposes, Super Records will become the tax agent of the fund.</p>
	</div><br/>

	If you have any difficulty with this application or would like to discuss the SMSF or the service before completing it, please contact us.<br/><br/>

	<p class="orangeheader">If you are ready to continue, please click NEXT at the bottom of the page.</p>
</b></div>
<input type="hidden" name="lstClientType" value="25"/>
<div class="pdT20">
    <span align="left"><button type="button" onclick="window.location.href='jobs.php?a=order'" value="BACK" />BACK</button></span>
    <span align="right" style="padding-left:55px;"><button type="button" onclick="javascript:window.location.assign('jobs.php?sql=<?php if(isset($_SESSION['jobId'])){echo'update';}else{echo'insertJob';} ?>&type=SETUP&subfrmId=1');">NEXT</button></span>
</div><?
include(FOOTER);
?>