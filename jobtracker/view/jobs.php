<?
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit new job</h1>
	<span>
		<b>Welcome to the superrecords job submission page.</b></br>Please select the type of job you would like to submit from below.
	<span>
</div>

<div class="pdT50 pdB20">
	<span onclick="javascript:urlRedirect('jobs.php?a=add&type=comp');" title="Submit new compliance job" class="jobbox">Submit Compliance job</span>
	<span onclick="javascript:urlRedirect('jobs.php?a=audit&var=new');" title="Submit new audit only job" class="jobbox" style="padding-left:26px;padding-right:26px">Submit Audit Only job</span>
</div><?

include (FOOTER);
?>