<div class="frmheading">
	<h1>Manage Lead</h1>
</div>

<table class="fieldtable" width="100%" align="center"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="lead.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a></td>
		</tr><?
	}
		
	?><tr class="fieldheader">
		<th class="fieldheader" align="left">Lead Type</th>
		<th class="fieldheader" align="left">Lead Name</th>
		<th class="fieldheader" align="left">Sales Person</th>
		<th class="fieldheader">Date Received</th>
		<th width="12%" class="fieldheader" colspan="3" align="center">Actions</th>
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