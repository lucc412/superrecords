<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>View My Job List</h1>
	<span>
		<b>Welcome to the Super Records job list.</b></br>Here you can see a list of jobs you have submitted.
	<span>
</div><?

?><form name="objForm" method="post" action="jobs.php"><?

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
		?><div class="errorMsg">You don't have any jobs yet.</div><?
	}
	else {
		// display job data
		?><table align="center" width="100%" class="resources">
			<tr>
				<td width="50%" class="td_title">Job Name</td>
				<td width="18%" class="td_title">Job Status</td>
				<td width="12%" class="td_title">Source Documents</td>
				<td width="12%" class="td_title">Reports</td>
				<td width="15%" class="td_title" align="center">Date Created</td>
				<td class="td_title" align="center">Actions</td>
			</tr><?

			$countRow = 0;
			foreach($arrJobs AS $jobId => $arrJobDetails) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				$arrJobParts = stringToArray('::', $arrJobDetails['job_name']);
				$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

				?><tr class="<?=$trClass?>">
					<td class="tddata"><?=$jobName?></td>

					<td class="tddata"><?=$arrJobStatus[$arrJobDetails['job_status_id']]?></td>

					<td class="tddata"><?
						$arrSourceDocs = $objScr->fetch_documents($jobId);
						if(!empty($arrSourceDocs)) {
							foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
								$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
								if(file_exists($folderPath)) {
									?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=S" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
								}
							}
						}
					?></td>

					<td class="tddata"><?
						$arrReports = $objScr->fetch_reports($jobId);
						if(!empty($arrReports)) {
							foreach($arrReports AS $reportId => $arrReportInfo) {
								$folderPath = "../uploads/reports/" . $arrReportInfo['file_path'];
								if(file_exists($folderPath)) {
									?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrReportInfo['file_path'])?>&flagChecklist=R" title="Click to view this document"><?=$arrReportInfo['report_title']?></a></p><?
								}
							}
						}
					?></td>

					<td class="tddata" align="center"><?=$arrJobDetails['job_received']?></td>

					<td class="tddata" align="center"><a title="click here to edit this job" href='jobs.php?a=edit&recid=<?=$jobId?>&frmId=<?=$arrJobDetails['setup_subfrm_id']?>'><?=EDITICON?></a></td>

				</tr><?
				$countRow++;
			}
		?></table><?
	}
?></form><?

// include footer file
include(FOOTER);
?>