<?
// include topbar file
include(HEADDATA);

?><!--<div class="wrapper">
	<div class="pagebackground">
		<div class="container">--><?
			// page header
			?><div class="pageheader pd10">
				<h1>Upload checklist - <?=$checklistName?></h1>
				<span>
					<b>Welcome to the Super Records job checklist upload page.</b></br>Here you can upload a new checklist for any job.
				<span>
			</div><?

			// content
			?><form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">	
				<div class="pd10">
					<span><input type="file" name="fileUpload"></span>
					<span class="pdL30"><button type="submit" value="Add">Add</button></span>
				</div>
				<input type="hidden" name="checklistId" value="<?=$_REQUEST['checklistId']?>">
				<input type="hidden" name="sql" value="uploadAuditDocs">
			</form><?

			if(!empty($arrDocList)) {
				?><div class="pdT50 pd10">
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
		?><!--</div>
	</div>
</div>--><?

// include footer file
//include(FOOTER);
?>