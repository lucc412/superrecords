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
		?><div class="errorMsg"><?=ERRORICON?>&nbsp;No jobs added yet...!</div><?	
	}
	else {
		// display job data
		?><table align="center" width="100%" class="resources">
			<tr>
				<td class="td_title">Job Name</td>
				<td class="td_title">Job Status</td>
				<td class="td_title" width="90px;">Checklist</td>
				<td class="td_title">Source Documents</td>
				<td class="td_title" width="80px;">Reports</td>
				<td class="td_title" align="center">Date Created</td>
				<td class="td_title" align="center">Actions</td>
			</tr><?

			$countRow = 0;
			foreach($arrJobs AS $jobId => $arrJobDetails) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				$arrJobParts = explode('::', $arrJobDetails['job_name']);
				$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

				?><tr class="<?=$trClass?>">
					<td class="tddata"><?=$jobName?></td>

					<td class="tddata"><?=$arrJobStatus[$arrJobDetails['job_status_id']]?></td>

					<td class="tddata"><?
						$folderPath = "../uploads/checklists/".$arrJobDetails['checklist'];
						if(!empty($arrJobDetails['checklist']) && file_exists($folderPath)) {
							?><p><a href="jobs.php?a=download&filePath=<?=$arrJobDetails['checklist']?>&flagChecklist=C" title="Click to view this checklist">Checklist</a></p><?
						}
					?></td>

					<td class="tddata"><?
						$arrSourceDocs = $objScr->fetch_documents($jobId);
						if(!empty($arrSourceDocs)) {
							$docCnt = 0;
							foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
								$docCnt++;
								$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
								if(file_exists($folderPath)) {
									?><p><a href="jobs.php?a=download&filePath=<?=$arrDocInfo['file_path']?>&flagChecklist=S" title="Click to view this document">Document <?=$docCnt?></a></p><?
								}
							}
						}
					?></td>

					<td class="tddata"><?
						$arrReports = $objScr->fetch_reports($jobId);
						if(!empty($arrReports)) {
							$reportCnt = 0;
							foreach($arrReports AS $reportId => $arrReportInfo) {
								$reportCnt++;
								$folderPath = "../uploads/reports/" . $arrReportInfo['file_path'];
								if(file_exists($folderPath)) {
									?><p><a href="jobs.php?a=download&filePath=<?=$arrReportInfo['file_path']?>&flagChecklist=R" title="Click to view this document">Report <?=$reportCnt?></a></p><?
								}
							}
						}
					?></td>

					<td class="tddata" align="center"><?=$arrJobDetails['job_received']?></td>

					<td class="tddata" align="center"><a title="click here to edit this job" href='jobs.php?a=edit&recid=<?=$jobId?>'><?=EDITICON?></a></td>

				</tr><?
				$countRow++;
			}
		?></table><?
	}
?></form><?

// include footer file
include(FOOTER);
?>