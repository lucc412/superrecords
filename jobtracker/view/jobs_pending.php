<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Pending jobs</h1>
	<span>
		<b>Welcome to the Super Records pending job list.</b></br>Below you can see all pending jobs for your practice as well as their current status.
	<span>
</div><?

?><form name="objForm" method="post" action="jobs.php">
	<input type="hidden" name="a" value="pending"><?

	// client drop-down
	?><table width="100%">
		<tr>
			<td align="right">
				<select style="width:300px;" name="lstClientType" id="lstClientType" onchange="this.form.submit();">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $_REQUEST['lstClientType']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select>
			</td></tr>
	</table></br><?

	// content
	if(count($arrJobs) == 0) {	
		?><div class="errorMsg">You don't have any pending jobs linked to this client.</div><?
	}
	else {
		
		// display job data
		?><table width="100%" class="resources">
			<tr>
				<td class="td_title">Job Name</td>
				<td class="td_title">Job Status</td>
				<td class="td_title">Source Documents</td>
				<td class="td_title">Reports</td>
				<td align="center" class="td_title">Submission Date</td>
				<td width="12%" class="td_title" colspan="2" align="center">Actions</td>
			</tr><?
			
			$countRow = 0;
			foreach($arrJobs AS $jobId => $arrJobDetails) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				?><tr class="<?=$trClass?>"><?
					$arrJobParts = stringToArray('::', $arrJobDetails['job_name']);
					$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

					?><td class="tddata"><?=$jobName?></td>

					<td class="tddata"><?=$arrJobStatus[$arrJobDetails['job_status_id']]?></td>

					<td class="tddata"><?
						$arrSourceDocs = $objScr->fetch_documents($jobId);
						if(!empty($arrSourceDocs)) {
							foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
								if($arrDocInfo['job_genre'] == 'AUDIT') {
									$folderPath = "../uploads/audit/" . $arrDocInfo['file_path'];
									if(file_exists($folderPath)) {
										?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=A" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
									}
								}
								else if($arrDocInfo['job_genre'] == 'SETUP') {
									$folderPath = "../uploads/setup/" . $arrDocInfo['file_path'];
									if(file_exists($folderPath)) {
										?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=ST" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
									}
								}
								else {
									$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
									if(file_exists($folderPath)) {
										?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=S" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
									}
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

					<td class="tddata" style="width:15px" align="center"><?
						if($arrJobDetails['job_genre'] != 'SETUP') {
							?><a href="jobs.php?a=uploadDoc&lstJob=<?=$jobId?>&genre=<?=$arrJobDetails['job_genre']?>" title="Click to upload additional documents"><?=UPLOAD?></a><?
						}
					?></td>
					<td class="tddata" style="width:15px" align="center"><?
						$flagQueryExists = $objScr->fetch_queries($jobId);
						if(!empty($flagQueryExists)) {
							?><a target="_blank" href="queries.php?lstJob=<?=$jobId?>&lstCliType=<?=$arrJobDetails['client_id']?>" title="Click to view queries"><?=QUERY?></a><?
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