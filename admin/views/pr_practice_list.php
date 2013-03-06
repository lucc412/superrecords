<div class="frmheading">
	<h1>Manage Practice</h1>
</div>

<table  class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="pr_practice.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}		
	
	?><tr class="fieldheader">
		<th class="fieldheader" align="left">Practice Name</th>
		<th class="fieldheader" align="left">Type</th>
		<th class="fieldheader" align="left">SR Manager</th>
		<th class="fieldheader" align="center">Date Signed Up</th>
		<th  class="fieldheader" colspan="3" align="center">Actions</th>
	</tr><?

	$countRow = 0;
	foreach ($arrPractice AS $practiceId => $arrInfo) {
 		if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			<td class="<?=$style?>"><?=htmlspecialchars($arrInfo["name"])?></td>
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