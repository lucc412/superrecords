<div class="frmheading">
	<h1>View Client</h1>
</div>

<table class="tbl" border="0" cellspacing="12" width="70%">
	<tr>
		<td class="hr">Client</td>
		<td class="dr">View</td>
	</tr>
	<tr>
		<td class="hr">Practice</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrPractice[$arrClientData["id"]])?></td>
	</tr>
	<tr>
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrClientData["sr_manager"]])?></td>
	</tr>
	<tr>
		<td class="hr">India Manager</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrClientData["india_manager"]])?></td>
	</tr>
	<tr>
		<td class="hr">Team Member</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrClientData["team_member"]])?></td>
	</tr>
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($arrEmployees[$arrClientData["sales_person"]])?></td>
	</tr>
	<tr>
		<td class="hr">Client Name</td>
		<td class="dr"><?=htmlspecialchars($arrClientData["client_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Entity Type</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrTypes[$arrClientData["client_type_id"]])?></td>
	</tr>
	<tr>
		<td class="hr">Client Notes</td>
		<td class="dr"><?=htmlspecialchars($arrClientData["client_notes"])?></td>
	</tr>
	<tr>
		<td class="hr">Date Signed Up</td><?
		$dateSignedUp = "";
		if (isset($arrClientData["client_received"]) && $arrClientData["client_received"] != "") {
			if($arrClientData["client_received"] != "0000-00-00 00:00:00") {
				$dateSignedUp = date("d/m/Y",strtotime( $arrClientData["client_received"]));
			}
		}  
		?><td class="dr"><?=$dateSignedUp?></td>
	</tr>
	<tr>
		<td class="hr">Sent Items</td><?
		$arrStepsList = explode(',', $arrClientData['steps_done']);
		foreach($arrStepsList AS $intKey => $stepsId) {
			$arrSteps[] = $objCallData->arrStepsList[$stepsId];
		}
		$strSteps = implode(',', $arrSteps);
		?><td class="dr"><?=$strSteps?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr><?

		if($access_file_level['stf_Add'] == "Y") {
			?><td><a class="hlight"  href="cli_client.php?a=add">Add Record</a></td><?
		}

		if($access_file_level['stf_Edit'] == "Y") {
			?><td><a class="hlight"  href="cli_client.php?a=edit&recid=<?=$recid?>">Edit Record</a></td><?
		}

		if($access_file_level['stf_Delete'] == "Y") {
			?><td><a class="hlight"  onClick="performdelete('cli_client.php?sql=delete&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td><?
		}
	?></tr>
</table>