<?
// include topbar file
include(HEADDATA);

// page header
?><div class="pageheader pd10">
	<h1>Add documents for <?=$checklistName?></h1>
	<span>
		<b>Welcome to the Super Records job checklist upload page.</b></br>Here you can upload a new checklist for any job.
	<span>
</div><?

// content
?><div class="pd10">
	<form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return uploadValidate();" enctype="multipart/form-data">
		<span><input type="file" id="fileUpload" name="fileUpload"></span>
		<span class="pdL10"><button style="width:94px;" type="submit" title="click here to add document" value="Add">Add</button></span>
		<input type="hidden" name="checklistId" value="<?=$_REQUEST['checklistId']?>">
		<input type="hidden" name="sql" value="uploadAuditDocs">
	</form><?

	if(!empty($arrDocList)) {
		?><div class="pdT50">
			<table width="100%">
				<tr>
					<td class="td_title">Document Name</td>
					<td width="100px" align="center" class="td_title">Date</td>
				</tr><?

				$countRow = 0;
				foreach($arrDocList AS $fileName => $uploadedDate) {
					if($countRow%2 == 0) $trClass = "trcolor";
					else $trClass = "";
					$docName = str_replace(substr($fileName, 0, strpos($fileName, '~')+1), "", $fileName);
					?><tr class="<?=$trClass?>">
						<td class="tddata"><p><a href="jobs.php?a=download&filePath=<?=urlencode($fileName)?>&flagChecklist=A" title="Click to view this document"><?=$docName?></a></p></td>
						<td align="center" class="tddata"><?=$uploadedDate?></td>
					</tr><?
					$countRow++;
				}
			?></table>
		</div><?
	}
	else {
		?><div class="pdT50"><div class="errorMsg">You don't have any documents added yet.</div></div><?
	}

	?><div align="center" style="padding-top:55px;">
		<button style="width:100px;" type="button" title="click here to close window" onclick="window.close()" />Close</button>
	</div>
</div>