<?
// include topbar file
include(HEADDATA);

// page header
?><div class="pageheader pd10">
	<h1>Upload multiple documents</h1>
	<a href="javascript:;" class="boxclose" title="click here to close this window" onclick="window.close()" />X</a>
	<span>
		<b>Welcome to the Super Records audit checklist upload page.</b></br>Here you can upload multiple documents for your job.
	<span>
</div><?

// content
?><div class="pd10">
	<form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return uploadValidate();" enctype="multipart/form-data">
		<span><input type="text" id="fileTitle" name="fileTitle"></span>
		<span><input type="file" id="fileUpload" name="fileUpload"></span>
		<span><button style="width:94px;" type="submit" title="click here to add document" value="Add">Add</button></span>
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
				foreach($arrDocList AS $intKey => $uploadDocs) {
					$fileName = $uploadDocs['file_path'];
					$uploadedDate = $uploadDocs['date'];
					$docTitle = $uploadDocs['document_title'];
					if($countRow%2 == 0) $trClass = "trcolor";
					else $trClass = "";
					?><tr class="<?=$trClass?>">
						<td class="tddata"><p><a href="jobs.php?a=download&filePath=<?=urlencode($fileName)?>&flagChecklist=A" title="Click to view this document"><?=$docTitle?></a></p></td>
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
?></div>