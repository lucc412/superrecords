<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>View All Queries</h1>
	<span>
		<b>Welcome to the Super Records pending query list.</b></br>Below you can see all pending queries for your practice.
	<span>
</div>

<form name="objForm" method="post" action="queries.php" enctype="multipart/form-data">
	<input type="hidden" name="queryId" id="queryId" value="">
	<input type="hidden" name="action" id="action" value="update">	

	<div id="savePopup" align="center" class="successPopup">
		Answer Saved.
	</div>

	<div id="saveAllPopup" align="center" class="successPopup">
		All Answers Saved.
	</div>	
	
	<table class="resources" width="100%">
		<tr>
			<td align="right">
				<select name="lstCliType" id="lstCliType" onchange="javascript:submitForm();">
					<option value="0">Select Client</option><?
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $_REQUEST['lstCliType']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select><?
					$arrJobNames = array();
					foreach($arrJobs AS $jobId => $jobName)
					{
						$arrJobParts = explode('::', $jobName);
						$arrJobNames[$jobId] = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];
					}
					asort($arrJobNames);
				?><select name="lstJob" id="lstJob" onchange="javascript:submitForm();">
					<option value="0">Select Job</option><?
					foreach($arrJobNames AS $jobId => $jobName){
						$selectStr = '';
						if($jobId == $_REQUEST['lstJob']) $selectStr = 'selected';
						//$arrJobParts = explode('::', $jobName);
						//$jobDispName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];
						?><option <?=$selectStr?> value="<?=$jobId?>"><?=$jobName?></option><?php 
					}
				?></select>
				<!--<button align="right" type="button" style="width:100px;" onclick="javascript:this.form.submit();" value="Save All">Save All</button>-->
			</td>
		</tr>
	</table></br><?

	if(count($arrQueries) == 0) {
		?><div align="center"><div class="errorMsg"><?=ERRORICON?>&nbsp;No pending queries available...!</div></div><?	
	}
	else {
		?><table width="100%" class="resources">
			<tr>
				<td class="td_title">Job</td>
				<td class="td_title">Query</td>
				<td class="td_title">Response</td>
				<td class="td_title" align="center">Uploaded by SR</td>
				<td class="td_title" align="center">Supporting Doc</td>
				<td class="td_title" align="center">Save</td>
			</tr><?

			$countRow = 0;
			foreach($arrQueries AS $queryId => $arrInfo) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				?><tr class="<?=$trClass?>">
					<td class="tddata"><?
						$arrJobParts = explode('::', $arrInfo['job_name']);
						$jobDispName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];
						echo $jobDispName;
					?></td>
					<td class="tddata"><?=nl2br($arrInfo['query'])?></td>
					<td class="tddata"><textarea name="txtResponse<?=$queryId?>"><?=$arrInfo['response']?></textarea></td>
					
					<td width="9%" class="<?=$style?> yellowBG"><?
					if(!empty($arrInfo["report_file_path"]))
					{
						/*$arrFileName = explode('~', $arrInfo['report_file_path']);
						$origFileName = $arrFileName[1];
						$docTitle = $origFileName;*/
					?><p><b><a href="queries.php?action=download&flagType=SRQ&filePath=<?=urlencode($arrInfo['report_file_path'])?>" title="Click to view this document">Document</a></b></p><?
					}
					?></td>
					
					<td class="tddata"><?
					$folderPath = "../uploads/queries/".$arrInfo['file_path'];
					if(empty($arrInfo['file_path']) || !file_exists($folderPath)) {
						?><input type="file" name="doc_<?=$queryId?>"><?
					}
					else {
						/*$arrFileName = explode('~', $arrInfo['file_path']);
						$origFileName = $arrFileName[1];
						$docTitle = $origFileName;*/
						?><p><a href="queries.php?action=download&flagType=PRQ&filePath=<?=urlencode($arrInfo['file_path'])?>" title="Click to view this document">Document</a></p><?
					}
					?></td>
					<td class="tddata" align="center"><button type="button" style="width:100px;" onclick="javascript:updateQuery(<?=$queryId?>);" value="Save">Save</button></td>
				</tr><?
				$countRow++;
			}
		?></table><?

		// individual save button click display message
		if($_REQUEST["flagUpdate"] == 'Y') {
			echo '
			   <script type="text/javascript">
				 function hideMsg() {
					document.getElementById("savePopup").style.visibility = "hidden";
				 }
				 mrgLeft = (screen.width / 2) - 330;
				 mrgLeft = mrgLeft +"px";
				 document.getElementById("savePopup").style.visibility = "visible";
				 document.getElementById("savePopup").style.marginLeft = mrgLeft;
				 window.setTimeout("hideMsg()", 4000);
			   </script>';
		}

		// individual save all button click display message
		if($_REQUEST["flagUpdate"] == 'A') {
			echo '
			   <script type="text/javascript">
				 function hideMsg() {
					document.getElementById("saveAllPopup").style.visibility = "hidden";
				 }
				 mrgALeft = (screen.width / 2) - 150;
				 mrgALeft = mrgALeft +"px";
				 document.getElementById("saveAllPopup").style.visibility = "visible";
				 document.getElementById("saveAllPopup").style.left = mrgALeft;
				 window.setTimeout("hideMsg()", 4000);
			   </script>';
		}	
	}
?></form><?

// include footer file
include(FOOTER);
?>