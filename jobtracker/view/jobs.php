<?
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit new job</h1>
	<span>
		<b>Welcome to the super records job submission page.</b></br>Please select the type of job you would like to submit from below.
	<span>
</div>

<div class="pdT50 pdB20">
	<span onclick="javascript:urlRedirect('compliance.php');" title="Submit new compliance job" class="jobbox">Submit Compliance job</span>
	<span onclick="javascript:urlRedirect('audit.php');" title="Submit new audit only job" class="jobbox" style="padding-left:26px;padding-right:26px">Submit Audit Only job</span>
	<span onclick="javascript:urlRedirect('setup.php');" title="Order documents" class="jobbox" style="padding-left:26px;padding-right:26px">Order Documents</span>
</div><?

include (FOOTER);
?>