<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Completed jobs</h1>
	<span>
		<b>Welcome to the Super Records completed job list.</b></br>Below you can see all completed jobs for your practice.
	<span>
</div><?

?><form name="objForm" method="post" action="jobs_completed.php">
	<input type="hidden" name="a" value="completed"><?
		
	// client drop-down
	?><table align="center" width="100%">
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
			</td>
		</tr>
	</table></br><?

	// content
	if(count($arrJobs) == 0) {
		?><div class="errorMsg">You don't have any completed jobs linked to this client.</div><?
	}
	else {

		// display job data
		?><table width="100%" class="resources">
		<tr>
			<th width="40%" class="td_title sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Job Name <img id="sort_name" src="images/sort_asc.png"></th>
			<td class="td_title">Source Documents</td>
			<td class="td_title">Reports</td>
			<th class="td_title date sort_column" align="center" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_date');">Completion Date <img id="sort_date" src="images/sort_asc.png"></th>
			<td class="td_title" align="center">Queries</td>
		</tr><?			
		
		$countRow = 0;
		foreach($arrJobs AS $jobId => $arrJobDetails) {
			if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";

			?><tr class="<?=$trClass?>"><?
				?><td class="tddata"><?=$arrJobDetails['job_name']?></td>

				<td class="tddata"><?
					$arrSourceDocs = $arrAllDocs[$jobId];
                                        if(!empty($arrSourceDocs)) {
                                                foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
                                                        $icon = returnFileIcon($arrDocInfo['file_path']);
                                                        if($arrDocInfo['job_genre'] == 'AUDIT') {
                                                                $folderPath = "../uploads/audit/" . $arrDocInfo['file_path'];
                                                                if(file_exists($folderPath)) {
                                                                        ?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrDocInfo['file_path'])?>&folderPath=A" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
                                                                }
                                                        }
                                                        else if($arrDocInfo['job_genre'] == 'SETUP') {
                                                                $folderPath = "../uploads/setup/" . $arrDocInfo['file_path'];
                                                                if(file_exists($folderPath)) {
                                                                        ?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrDocInfo['file_path'])?>&folderPath=ST" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
                                                                }
                                                        }
                                                        else {
                                                                $folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
                                                                if(file_exists($folderPath)) {
                                                                        ?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrDocInfo['file_path'])?>&folderPath=S" title="Click to view this document"><?=$arrDocInfo['document_title']?></a></p><?
                                                                }
                                                        }
                                                }
                                        }
				?></td>

				<td class="tddata"><?
					$arrReports = $arrAllReports[$jobId];
					if(!empty($arrReports)) {
						foreach($arrReports AS $reportId => $arrReportInfo) {
                                                        $icon = returnFileIcon($arrReportInfo['file_path']);
							$folderPath = "../uploads/reports/" . $arrReportInfo['file_path'];
							if(file_exists($folderPath)) {
								?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrReportInfo['file_path'])?>&folderPath=R" title="Click to view this document"><?=$arrReportInfo['report_title']?></a></p><?
							}
						}
					}
				?></td>

				<td class="tddata" align="center"><?=$arrJobDetails['job_completed_date']?></td>

				<td class="tddata" align="center"><?
					$flagQueryExists = $arrAllQueryCnt[$jobId];
					if(!empty($flagQueryExists)) {
						?><a target="_blank" href="queries.php?lstJob=<?=$jobId?>&lstCliType=<?=$arrJobDetails['client_id']?>" title="Click to view queries"><?= QUERY ?></a><?
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