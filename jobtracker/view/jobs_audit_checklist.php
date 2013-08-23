<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit documents (Audit)</h1>
	<span>
		<b>Welcome to the Super Records documents upload page for audit.</b></br>Here you can upload documents for audit job.
	<span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php"><?
	if(empty($arrDocDetails)) {
		?><input type="hidden" name="sql" value="insertAudit"><?
	}
	else {
		?><input type="hidden" name="sql" value="updateAudit"><?
	}

	?><div class="auditupload"><?
		foreach($arrChecklist AS $strChecklist => $arrSubChecklist) {
			$checklist = stringToArray(':',$strChecklist);
			$checklistId = $checklist['0'];
			$checklistName = $checklist['1'];
			$checklistStatus = $checklist['2'];

			if(empty($checklistStatus)) 
				$classStr = "bluearrow";
			else 
				$classStr = "orangearrow";
			?><span class="<?=$classStr?>" id="checklist<?=$checklistId?>"><?=$checklistName;?></span>
			<table style="display:none;" id="subchecklist<?=$checklistId?>"><?
				foreach($arrSubChecklist AS $subChecklistId => $subChecklistName) {
					?><tr>
						<td style="width:400px" id="subchecklist"><?=$subChecklistName?></td>
						<td align="right"><?
							foreach($arrUplStatus AS $charStatus => $strStatus) {
								$strChecked = "";
								// edit case
								if(isset($arrDocDetails[$subChecklistId]['status'])) {
									if($charStatus == $arrDocDetails[$subChecklistId]['status'])
										$strChecked = "checked";
								}
								// add case
								else {
									if($charStatus == 'PENDING')
										$strChecked = "checked";
								}
								?><input type="radio" name="rdUplStatus<?=$subChecklistId?>" class="checkboxClass" value="<?=$charStatus?>" <?=$strChecked?>><?=$strStatus;
							}
						?></td>
						<td align="right"><textarea name="taNotes<?=$subChecklistId?>" cols="5" rows="1"><?=$arrDocDetails[$subChecklistId]['notes']?></textarea></td>
					</tr><?
				}
				?><tr>
					<td align="right" colspan="3">
						<button type="button" title="click here to manage documents" onclick="JavaScript:newPopup('jobs.php?a=uploadAudit&checklistId=<?=$checklistId?>');">Documents</button>
					</td>
				</tr>
			</table><?
		}
		?><div class="pdT50">
			<span class="pdR50"><button type="reset" onclick="window.location.href='jobs.php?a=audit'" value="Reset">Back</button></span>
			<span class="pdR50"><button name="button" type="submit" value="Save">Save</button></span>
			<span><button name="button" type="submit" value="Submit">Submit</button></span>
		</div>
	</div>
</form><?

// include footer file
include(FOOTER);
?>