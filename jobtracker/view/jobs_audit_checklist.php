<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Audit Checklist</h1>
	<span>
		<b>Welcome to Super Records Audit checklist section.</b></br>Please tick each SMSF category relevant to the Fund.<br/>A list of documents required for all selected categories will appear in next section.
	<span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php">
	<input type="hidden" name="sql" value="checklistSelection"><?
	foreach($arrChecklist AS $checklistId => $checklistInfo) {
		$arrChcklst = stringToArray(":", $checklistInfo);
		if($checklistId==1)
			$defaultChckd = "checked onclick='return false'";
		else if(!empty($arrChcklst[1]))
			$defaultChckd = "checked";
		else 
			$defaultChckd = "";
		?><p class="pdB8"><input class="checkboxClass" <?=$defaultChckd?> type="checkbox" name="checklist<?=$checklistId?>"><span class="checklistlabel pdL10"><?=$arrChcklst[0];?></span></p><?
	}
	?><div class="pdT50">
		<span class="pdR50"><button type="reset" onclick="window.location.href='jobs.php?a=audit'" value="Reset">Back</button></span>
		<span><button name="button" type="submit" value="next">Next</button></span>
	</div>
</form><?

// include footer file
include(FOOTER);
?>