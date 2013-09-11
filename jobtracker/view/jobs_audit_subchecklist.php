<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Checklist for Audit</h1>
	<div>
		<span>
			<b>Welcome to Super Records Audit checklist section. </b></br>Please click on below selected categories to view the checklists & upload documents against each category as applicable.  If you would like to upload multiple documents or files for this particular job, please select <i>Upload Multiple Documents</i> button.
			<div class="downloadChecklist" align="right">
				<button title="click here to download your preferred checklist" type="button" onclick="javascript:urlRedirect('jobs.php?sql=dwnldchcklst');">Download Checklist</button>
			</div>
		</span>
	</div>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php"><?
	if(empty($arrDocDetails)) {
		?><input type="hidden" name="sql" value="insertAudit"><?
	}
	else {
		?><input type="hidden" name="sql" value="updateAudit"><?
	}

	?><div class=""><?
		foreach($arrSubchecklist AS $strChecklist => $arrSubChecklist) {
			$checklist = stringToArray(':',$strChecklist);
			$checklistId = $checklist['0'];
			$checklistName = $checklist['1'];
			$checklistStatus = $checklist['2'];

			?><span class="bluearrow" id="checklist<?=$checklistId?>"><?=$checklistName;?></span>
			<div class="pdB15" align="right"><button style="width:<?if(empty($checklistStatus)) echo "205px"; else echo "250px";?>" type="button" title="click here to manage documents" onclick="JavaScript:newPopup('jobs.php?a=uploadAudit&checklistId=<?=$checklistId?>','400');"><?if(empty($checklistStatus)) echo "Upload Multiple Documents"; else echo "View multiple uploaded documents";?></button></div>
			<table width="100%" id="subchecklist<?=$checklistId?>" class="resources pdB20">
				<tbody>
					<tr>
						<td width="50%" class="td_title">Description</td>
						<td class="td_title" align="center">Upload</td>
						<td class="td_title">Documents</td>
						<td class="td_title" align="center">Status</td>
						<td align="center" class="td_title">Comments</td>
					</tr><?
					$countRow = 0;
					foreach($arrSubChecklist AS $subChecklistId => $subChecklistName) {
						if($countRow%2 == 0) $trClass = "trcolor";
						else $trClass = "";
						?><tr class="<?=$trClass?>">
							<td class="tddata" style="width:400px" id="subchecklist"><?=$subChecklistName?></td>
							<td class="tddata" align="center"><div class="arrow-up" onclick="JavaScript:newPopup('jobs.php?a=uploadSubAudit&checklistId=<?=$checklistId?>&subchecklistId=<?=$subChecklistId?>','250');" title="click here to upload documents"></div></td>
							<td class="tddata"><?
								$arrSubDocuments = $arrSubDocList[$subChecklistId];
								if(!empty($arrSubDocuments)) {
									$docCnt = 0;
									foreach($arrSubDocuments AS $docPath) {
										$docCnt++;
										$folderPath = "../uploads/audit/" . $docPath;
										if(file_exists($folderPath)) {
											?><p><a href="jobs.php?a=download&filePath=<?=urlencode($docPath)?>&flagChecklist=A" title="Click to view this document">Document <?=$docCnt?></a></p><?
										}
									}
								}
							?></td>
							<td class="tddata" align="center">
								<select name="rdUplStatus<?=$subChecklistId?>"><?
									foreach($arrUplStatus AS $charStatus => $strStatus) {
										$strChecked = "";
										// edit case
										if(isset($arrDocDetails[$subChecklistId]['status'])) {
											if($charStatus == $arrDocDetails[$subChecklistId]['status'])
												$strChecked = "selected";
										}
										// add case
										else {
											if($charStatus == 'PENDING')
												$strChecked = "selected";
										}
										?><option <?=$strChecked?> value="<?=$charStatus?>"><?=$strStatus?></option><?
									}
								?></select>
							</td>
							<td align="center" class="tddata"><textarea name="taNotes<?=$subChecklistId?>" style="width:120px;height:17px" ><?=$arrDocDetails[$subChecklistId]['notes']?></textarea></td>
						</tr><?
						$countRow++;
					}
				?></tbody>
			</table><?
		}
		?><div class="pdT50">
			<span class="pdR50"><button type="reset" onclick="window.location.href='jobs.php?a=checklist'" value="Reset">Back</button></span>
			<span class="pdR50"><button name="button" type="submit" value="Save">Save & Exit</button></span>
			<span><button name="button" type="submit" value="Submit">Submit</button></span>
		</div>
	</div>
</form><?

// include footer file
include(FOOTER);
?>