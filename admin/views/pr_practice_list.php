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
	
	?><tr class="fieldheader">
		<th width="10%" class="fieldheader"><a href="pr_practice.php?order=<?php echo "pracId" ?>&type=<?php echo $ordertype; ?>">Practice Code</a></th>
		<th class="fieldheader" align="left"><a href="pr_practice.php?order=<?php echo "pr.name" ?>&type=<?php echo $ordertype; ?>">Practice Name</a></th>
		<th class="fieldheader" align="left"><a href="pr_practice.php?order=<?php echo "prt.description" ?>&type=<?php echo $ordertype; ?>">Type</a></th>
		<th class="fieldheader" align="left"><a href="pr_practice.php?order=<?php echo "pr.sr_manager" ?>&type=<?php echo $ordertype; ?>">SR Manager</a></th>
		<th class="fieldheader" align="center"><a href="pr_practice.php?order=<?php echo "pr.date_signed_up" ?>&type=<?php echo $ordertype; ?>">Date Signed Up</a></th>
		<th  class="fieldheader" colspan="3" align="center">Actions</th>
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