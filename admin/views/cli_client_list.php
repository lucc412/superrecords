<div class="frmheading">
	<h1>Manage Client</h1>
</div>

<table class="fieldtable" width="100%" align="center" border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="cli_client.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}

	?><tr class="fieldheader">
		<th class="fieldheader" align="left">Type</th>
		<th class="fieldheader" align="left">Practice</th>
		<th class="fieldheader" align="left">Client Name</th>
		<th class="fieldheader" align="left">SR Manager</th>
		<th class="fieldheader">Date Signed Up</th>
		<th  class="fieldheader" colspan="3" align="center">Actions</th>
	</tr><?

	$countRow = 0;
	foreach($arrClient AS $clientId => $arrInfo) {
		if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrTypes[$arrInfo["client_type_id"]])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrPractice[$arrInfo["id"]])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($arrInfo["client_name"])?></td>
			<td class="<?=$style?>"><?=htmlspecialchars($objCallData->arrSrManager[$arrInfo["sr_manager"]])?></td>
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