<div class="frmheading">
	<h1>Manage Lead</h1>
</div>
<form action="lead.php" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
 <option value="<?php echo "lead_type" ?>"<?php if ($filterfield == "lead_type") { echo "selected"; } ?>>Lead Type</option>
 <option value="<?php echo "lead_name" ?>"<?php if ($filterfield == "lead_name") { echo "selected"; } ?>>Lead Name</option>
 <option value="<?php echo "sales_person" ?>"<?php if ($filterfield == "sales_person") { echo "selected"; } ?>>Sales Person</option>
 <option value="<?php echo "t1.date_received" ?>"<?php if ($filterfield == "t1.date_received") { echo "selected"; } ?>>Date Recieved</option>
</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="lead.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<table class="fieldtable" width="100%" align="center"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="lead.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a></td>
		</tr><?
	}
		
	?>
</table>
<table class="fieldtable" width="100%" align="center">
	<tr class="fieldheader">
		<th class="fieldheader" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_type');">Lead Type <img id="sort_type" src="images/sort_asc.png"></th>
		<th class="fieldheader" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Lead Name <img id="sort_name" src="images/sort_asc.png"></th>
		<th class="fieldheader" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_person');">Sales Person <img id="sort_person" src="images/sort_asc.png"></th>
		<th class="fieldheader date" style="cursor:pointer;" align="center" onclick="changeSortImage('sort_date');">Date Received <img id="sort_date" src="images/sort_asc.png"></th>
		<td width="12%" class="fieldheader" colspan="3" align="center">Actions</td>
	</tr><?

	$countRow = 0;
	foreach ($arrLead AS $leadId => $arrInfo) {
		if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";

		?><tr class="<?=$trClass?>">
			<td><?=htmlspecialchars($objCallData->arrTypes[$arrInfo["lead_type"]])?></td>
			<td><?=htmlspecialchars($arrInfo["lead_name"])?></td>
			<td><?=htmlspecialchars($objCallData->arrSalesPerson[$arrInfo["sales_person"]])?></td>
			<td align="center"><?
				$dateReceived = "";
				if (isset($arrInfo["date_received"]) && $arrInfo["date_received"] != "") {
					if($arrInfo["date_received"] != "0000-00-00 00:00:00") {
						$dateReceived = date("d/m/Y",strtotime($arrInfo["date_received"]));
					}
				}  
				echo htmlspecialchars($dateReceived);
			?></td><?
			
			if($access_file_level['stf_View'] == "Y") {
				?><td align="center">
					<a href="lead.php?a=view&recid=<?=$leadId?>">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td align="center">
					<a href="lead.php?a=edit&recid=<?=$leadId?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Delete'] == "Y") {
				?><td align="center"><?
					if($leadId == '1') {
						$jsFunc = 'javascript:noDelete()';
					}
					else {
						$jsFunc = "javascript:performdelete('lead.php?sql=delete&recid=" . $leadId . "');";
					}
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}
		?></tr><?
		$countRow++;
	}
?></table><br>