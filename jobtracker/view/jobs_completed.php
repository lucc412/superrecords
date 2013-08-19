<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Completed Jobs</h1>
	<span>
		<b>Welcome to the Super Records completed job list.</b></br>Below you can see all completed jobs for your practice.
	<span>
</div><?

?><form name="objForm" method="post" action="jobs.php">
	<input type="hidden" name="a" value="completed"><?
		
	// client drop-down
	?><table align="center" width="100%">
		<tr><td align="right">
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
	</table></br><?

	// content
	if(count($arrJobs) == 0) {
		?><div class="errorMsg"><?=ERRORICON?>&nbsp;No completed jobs yet...!</div><?	
	}
	else {

		// display job data
		?><table width="100%" class="resources">
		<tr>
			<td width="50%" class="td_title">Job Name</td>
			<td width="10%" class="td_title">Job Genre</td>
			<td width="15%" class="td_title">Source Documents</td>
			<td width="15%" class="td_title">Reports</td>
			<td width="12%" class="td_title" align="center">Queries</td>
		</tr><?			
		
		$countRow = 0;
		foreach($arrJobs AS $jobId => $arrJobDetails) {
			if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";

			?><tr class="<?=$trClass?>"><?
				$arrJobParts = explode('::', $arrJobDetails['job_name']);
				$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

				?><td class="tddata"><?=$jobName?></td>

				<td class="tddata"><?=ucfirst(strtolower($arrJobDetails['job_genre']))?></td>

				<td class="tddata"><?
					$arrSourceDocs = $objScr->fetch_documents($jobId);
					if(!empty($arrSourceDocs)) {
						$docCnt = 0;
						foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
							$docCnt++;
							$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
							if(file_exists($folderPath)) {
								?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=S" title="Click to view this document">Document <?=$docCnt?></a></p><?
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
								?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrReportInfo['file_path'])?>&flagChecklist=R" title="Click to view this document">Report <?=$reportCnt?></a></p><?
							}
						}
					}
				?></td>

				<td class="tddata viewquery" align="center"><a target="_blank" href="queries.php?lstJob=<?=$jobId?>" title="Click to view queries">View Queries</a></td>
			</tr><?
			$countRow++;
		}
		?></table><?
	}
?></form><?
	
// include footer file
include(FOOTER);
?>