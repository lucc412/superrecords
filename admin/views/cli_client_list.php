<div class="frmheading">
	<h1>Manage Client</h1>
</div>
<form action="cli_client.php" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo stripslashes($filter)?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "pr.name" ?>"<?php if ($filterfield == "pr.name") { echo "selected"; } ?>>Practice</option>
<option value="<?php echo "cl.client_code" ?>"<?php if ($filterfield == "cl.client_code") { echo "selected"; } ?>>Client Code</option>
 <option value="<?php echo "cl.client_name" ?>"<?php if ($filterfield == "cl.client_name") { echo "selected"; } ?>>Client Name</option>
 <option value="<?php echo "clt.client_type" ?>"<?php if ($filterfield == "clt.client_type") { echo "selected"; } ?>>Type</option>
 <option value="<?php echo "sr_manager" ?>"<?php if ($filterfield == "sr_manager") { echo "selected"; } ?>>SR Manager</option>
 <option value="<?php echo "cl.client_received" ?>"<?php if ($filterfield == "cl.client_received") { echo "selected"; } ?>>Date Signed Up</option>
</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="cli_client.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<table class="fieldtable" width="100%" align="center" border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="cli_client.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}

	?>
</table>
<table class="fieldtable" width="100%" align="center" border="0" cellspacing="1" cellpadding="5">
	<tr class="fieldheader">
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_practice');">Practice <img id="sort_practice" src="images/sort_asc.png"></th>
		<th width="10%" class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_code');">Client Code <img id="sort_code" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Client Name <img id="sort_name" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_type');">Type <img id="sort_type" src="images/sort_asc.png"></th>
		<th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_sr');">SR Manager <img id="sort_sr" src="images/sort_asc.png"></th>
		<th class="fieldheader date sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_date');">Date Signed Up <img id="sort_date" src="images/sort_asc.png"></th>
		<td class="fieldheader" colspan="3" align="center">Actions</td>
	</tr>
	<?

	$countRow = 0;
	foreach($arrClient AS $clientId => $arrInfo) {
		if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrPractice[$arrInfo["id"]])?></td>
			<td class="<?=$style?>" align="center"><?=htmlspecialchars($arrInfo["client_code"])?></td>
			<td class="<?=$style?>"><?=stripslashes($arrInfo["client_name"])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrTypes[$arrInfo["client_type_id"]])?></td>
			
			<td class="<?=$style?>"><?=htmlspecialchars($arrEmployees[$arrInfo["sr_manager"]])?></td>
			<td align="center" class="<?=$style?>"><?
				$dateSignedUp = "";
				if (isset($arrInfo["client_received"]) && $arrInfo["client_received"] != "") {
					if($arrInfo["client_received"] != "0000-00-00 00:00:00") {
						$dateSignedUp = date("d/m/Y",strtotime($arrInfo["client_received"]));
					}
				}  
				print htmlspecialchars($dateSignedUp);
			?></td><?
			
			if($access_file_level['stf_View'] == "Y") {
				?><td align="center">
					<a href="cli_client.php?a=view&recid=<?=$clientId?>">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td align="center">
					<a href="cli_client.php?a=edit&recid=<?=$clientId?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Delete'] == "Y") {
				?><td align="center"><?
					$jsFunc = "javascript:performdelete('cli_client.php?sql=delete&recid=" . $clientId . "');";
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}
		?></tr><?
		$countRow++;
	}
?></table><br>