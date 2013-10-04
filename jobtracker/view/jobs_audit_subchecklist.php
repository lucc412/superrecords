<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader" style="padding-bottom:0px;">
	<h1>Checklist for Audit</h1>
	<div>
		<span>
			<b>Welcome to Super Records Audit checklist section.</b></br>Please click on below selected categories to view the checklists & upload documents against each category as applicable. If you would like to upload multiple documents or files for this particular job, please select <i>Upload Multiple Documents</i> button.
			<div align="right">
				<span class="pdR20"><button style="width:205px" type="button" title="click here to manage documents" onclick="JavaScript:newPopup('jobs.php?a=uploadAudit','400');">Upload Multiple Documents</button></span>
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
	?><div><?
		foreach($arrSubchecklist AS $strChecklist => $arrInnerlist) {
			$checklist = stringToArray(':',$strChecklist);
			$checklistId = $checklist['0'];
			$checklistName = $checklist['1'];

			?><div class="accordionButton bluearrow"><?=$checklistName;?></div>
			<div class="accordionContent" <?if($_REQUEST['checklistId'] == $checklistId) echo "style='display:block'"; else echo "style='display:none'";?>>
				<table width="80%" class="resources pdB20">
					<tbody>
						<tr>
							<td width="50%" class="td_title">Description</td>
							<td class="td_title" align="center">Upload</td>
							<td class="td_title">Documents</td>
							<td class="td_title" align="center">Status</td>
							<td align="center" class="td_title">Comments</td>
						</tr><?
						$countRow = 0;
						foreach($arrInnerlist AS $subChecklistId => $subChecklistName) {
							if($countRow%2 == 0) $trClass = "trcolor";
							else $trClass = "";
							?><tr class="<?=$trClass?>"><?
								$strAttached = "";
								if($arrDocDetails[$subChecklistId]['status'] == 'ATTACHED') $strAttached = "color:#073f61";
								?><td class="tddata" style="width:400px;<?=$strAttached?>" id="subchecklist"><?=$subChecklistName?></td>
								<td class="tddata" align="center"><a href="javascript:;" onclick="JavaScript:newPopup('jobs.php?a=uploadSubAudit&checklistId=<?=$checklistId?>&subchecklistId=<?=$subChecklistId?>','250');" title="click here to upload documents"><?=UPLOAD?></a></td>
								<td class="tddata"><?
									$arrSubDocuments = $arrSubDocList[$subChecklistId];
									if(!empty($arrSubDocuments)) {
										foreach($arrSubDocuments AS $docDetails) {
											$arrDocInfo = stringToArray(":", $docDetails);
											$docPath = $arrDocInfo['0'];
											$docName = $arrDocInfo['1'];
											$folderPath = "../uploads/audit/" . $docPath;
											if(file_exists($folderPath)) {
												?><p><a href="jobs.php?a=download&filePath=<?=urlencode($docPath)?>&flagChecklist=A" title="Click to view this document"><?=$docName?></a></p><?
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
				</table>
			</div><?
		}
		?><div class="pdT20">
			<span class="pdR20"><button type="reset"  onclick="window.location.href='jobs.php?a=checklist'" value="Reset">Back</button></span>
			<span class="pdR20"><button name="button"  type="submit" value="Save">Save & Exit</button></span>
			<span><button name="button"  type="submit" value="Submit">Submit</button></span>
		</div>
	</div>
</form><?

// include footer file
include(FOOTER);
?>