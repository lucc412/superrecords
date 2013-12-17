<div class="frmheading">
	<h1>Manage Practice</h1>
</div>
<form action="pr_practice.php" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
 <option value="<?php echo "pr.pr_code" ?>"<?php if ($filterfield == "pr.pr_code") { echo "selected"; } ?>>Practice Code</option>
 <option value="<?php echo "pr.name" ?>"<?php if ($filterfield == "pr.name") { echo "selected"; } ?>>Practice Name</option>
 <option value="<?php echo "type" ?>"<?php if ($filterfield == "type") { echo "selected"; } ?>>Type</option>
 <option value="<?php echo "sr_manager" ?>"<?php if ($filterfield == "sr_manager") { echo "selected"; } ?>>SR Manager</option>
 <option value="<?php echo "date_signed_up" ?>"<?php if ($filterfield == "date_signed_up") { echo "selected"; } ?>>Date Signed Up</option>
</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="pr_practice.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<table  class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="pr_practice.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}			
	?>
</table>
<table  class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5">
	<tr class="fieldheader">
		<th width="12%" class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_code');">Practice Code <img id="sort_code" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Practice Name <img id="sort_name" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_type');">Type <img id="sort_type" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_srm');">SR Manager <img id="sort_srm" src="images/sort_asc.png"></th>
		<th class="fieldheader date sort_column" align="center"  style="cursor:pointer;" onclick="changeSortImage('sort_date');">Date Signed Up <img id="sort_date" src="images/sort_asc.png"></th>
		<td class="fieldheader" colspan="3" align="center">Actions</td>
	</tr><?

	$countRow = 0;
	foreach ($arrPractice AS $practiceId => $arrInfo) {
 		if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			<td align="center" class="<?=$style?>"><?=htmlspecialchars($arrInfo["pr_code"])?></td>
			<td class="<?=$style?>"><?=stripslashes($arrInfo["name"])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrTypes[$arrInfo["type"]])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrSrManager[$arrInfo["sr_manager"]])?></td>
			<td class="<?=$style?>" align="center"><?
				$dateSignedUp = "";
				if (isset($arrInfo["date_signed_up"]) && $arrInfo["date_signed_up"] != "") {
					if($arrInfo["date_signed_up"] != "0000-00-00 00:00:00") {
						$dateSignedUp = date("d/m/Y",strtotime($arrInfo["date_signed_up"]));
					}
				}  
				print htmlspecialchars($dateSignedUp);
			?></td><?
			
			if($access_file_level['stf_View'] == "Y") {
				?><td align="center">
					<a href="pr_practice.php?a=view&recid=<?=$practiceId?>">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td align="center">
					<a href="pr_practice.php?a=edit&recid=<?=$practiceId?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Delete'] == "Y") {
				?><td align="center"><?
					if($practiceId == '1') {
						$jsFunc = 'javascript:noDelete()';
					}
					else {
						$jsFunc = "javascript:performdelete('pr_practice.php?sql=delete&recid=" . $practiceId . "');";
					}
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}
		?></tr><?
		$countRow++;
	}
?></table><br>