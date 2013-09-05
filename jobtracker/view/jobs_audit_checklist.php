<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit documents (Audit)</h1>
	<span>
		<b>Welcome to the Super Records checklist selection page for audit.</b></br>Please select the checklist for audit job.
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
		?><input class="checkboxClass" <?=$defaultChckd?> type="checkbox" name="checklist<?=$checklistId?>"><?=$arrChcklst[0];?><br/><?
	}
	?><div class="pdT50">
		<span class="pdR50"><button type="reset" onclick="window.location.href='jobs.php?a=audit'" value="Reset">Back</button></span>
		<span><button name="button" type="submit" value="next">Next</button></span>
	</div>
</form><?

// include footer file
include(FOOTER);
?>