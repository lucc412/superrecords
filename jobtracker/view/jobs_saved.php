<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Saved Jobs</h1>
	<span>
		<b>Welcome to the Super Records saved job list.</b></br>Below you can see all saved jobs for your practice.
	<span>
        </div><form name="objForm" method="post" action="jobs.php?a=saved"><?

	// client drop-down
	?><table width="100%">
		<tr>
			<td align="right">
				<select name="lstClientType" id="lstClientType" onchange="this.form.submit();">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $_REQUEST['lstClientType']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select>
			</td>
		</tr>
	</table><br/><?

	// content
	if(count($arrJobs) == 0) {
		?><div class="errorMsg"><?=ERRORICON?>&nbsp;No jobs added yet...!</div><?	
	}
	else {
		// display job data
		?><table align="center" width="100%" class="resources">
			<tr>
				<td width="50%" class="td_title">Job Name</td>
				<td width="15%" class="td_title">Job Genre</td>
				<td width="15%" class="td_title" align="center">Date Created</td>
				<td width="8%" class="td_title" align="center">Actions</td>
			</tr><?

			$countRow = 0;
			foreach($arrJobs AS $jobId => $arrJobDetails) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				$arrJobParts = explode('::', $arrJobDetails['job_name']);
				$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

				?><tr class="<?=$trClass?>">
					<td class="tddata"><?=$jobName?></td>

					<td class="tddata"><?=ucfirst(strtolower($arrJobDetails['job_genre']))?></td>

					<td class="tddata" align="center"><?=$arrJobDetails['job_received']?></td>

					<td class="tddata" align="center"><?
						if($arrJobDetails['job_genre'] == 'SETUP') {
							?><a title="click here to edit this job" href='jobs.php?a=edit&recid=<?=$jobId?>&frmId=<?=$arrJobDetails['setup_subfrm_id']?>'><?=EDITICON?></a><?
						}
						else {
							?><a title="click here to edit this job" href='jobs.php?a=audit&recid=<?=$jobId?>'><?=EDITICON?></a><?
						}
					?></td>

				</tr><?
				$countRow++;
			}
		?></table><?
	}
?></form><?

// include footer file
include(FOOTER);
?>