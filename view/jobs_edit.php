<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Edit Existing Job</h1>
	<span><b>Welcome to the Super Records job edit page.</b><span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">

	<input type="hidden" name="sql" value="update">
	<input type="hidden" name="recid" value="<?=$_REQUEST['recid']?>"><?
	$jobId = $_REQUEST['recid'];

	?><table class="resources" width="100%" cellpadding="10px;">

		<tr>
			<td><strong>Client</strong></td>
			<td>
				<select name="lstClientType" id="lstClientType" title="Select client">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $arrJobsData['client_id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Client Type</strong></td>
			<td>
				<select name="lstCliType" id="lstCliType" title="Select type of client" onchange="javascript:selectOptions('JobType');">
					<option value="0">Select Client Type</option><?php
					foreach($arrClientType AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrJobsData['mas_Code']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Job Type</strong></td>
			<td>
				<span id="spanJobType">	
					<select name="lstJobType" id="lstJobType" title="Select type of job">
						<option value="0">Select Job Type</option><?php
						foreach($arrJobType AS $typeId => $typeDesc){
							$selectStr = '';
							if($typeId == $arrJobsData['job_type_id']) $selectStr = 'selected';
							?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
						}
					?></select>
				</span>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr> 

		<tr>
			<td><strong>Period</strong></td>
			<td><input type="text" name="txtPeriod" id="txtPeriod" value="<?=$arrJobsData['period']?>"></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Checklist</strong></td>
			<td><?
				$folderPath = "../uploads/checklists/".$arrJobsData['checklist'];
				if(empty($arrJobsData['checklist']) || !file_exists($folderPath)) {
					?><input type="file" name="fileChecklist" id="fileChecklist"><?
				}
				else {
					$filePath = $arrJobsData['checklist'];

					?><p><a href="jobs.php?a=download&filePath=<?=$arrJobsData['checklist']?>&flagChecklist=C" title="Click to view this checklist">Checklist</a></p>
					<!--<span style="margin-left:20px;"><a title="Click to delete this document" href="jobs.php?filePath=<?=$filePath?>&recid=<?=$jobId?>&a=deleteDoc&flagChecklist=C" onclick="javascript:return unlinkFile();">X</a></span>--><?
				}
			?></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Source Documents</strong></td>
			<td><?
				$arrSourceDocs = $objScr->fetch_documents($jobId);
				if(!empty($arrSourceDocs)) {
					$cntFile = 0;
					foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
						$cntFile++;
						$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
						if(file_exists($folderPath)) {
							?><p><a href="jobs.php?a=download&filePath=<?=$arrDocInfo['file_path']?>&flagChecklist=S" title="Click to view this source document">Document <?=$cntFile?></a>
							<!--<span style="margin-left:20px;"><a title="Click to delete this document" href="jobs.php?filePath=<?=$arrDocInfo['file_path']?>&recid=<?=$jobId?>&documentId=<?=$documentId?>&a=deleteDoc&flagChecklist=S" onclick="javascript:return unlinkFile('<?=$filePath?>');">X</a></span>--></p>
							<input type="hidden" name="sourceDoc_<?=$cntFile?>" id="sourceDoc_<?=$cntFile?>" value="<?=$arrDocInfo['file_path']?>"><?
						}
					}
				}
			?></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td>&nbsp;</td>
			<td><span class="docheader">Description</span></td>
			<td><span class="docheader">File Path</span></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><input type="text" name="textSource_50" title="Specify name of source document"></td>
			<td><input type="file" name="sourceDoc_50" id="sourceDoc_50"></td>
			<td><button type="button" title="Click here to upload new source document" onclick="javascript:addElement();" value="Add">Upload New +</button></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><div id="parentDiv">&nbsp;</div></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" value="Edit">Edit</button></td>
		</tr>
	</table>
</form><?

// include footer file
include(FOOTER);
?>