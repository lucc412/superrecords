<div class="frmheading">
	<h1>View Practice</h1>
</div>

<table class="tbl" border="0" cellspacing="12" width="70%">
	<tr>
		<td class="hr">Practice</td>
		<td class="dr">New</td>
	</tr>
	<tr>
		<td class="hr">Type</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrTypes[$arrPracticeData["type"]])?></td>
	</tr>
	<tr>
		<td class="hr">Practice Name</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["name"])?></td>
	</tr>
	<tr>
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrPracticeData["sr_manager"]])?></td>
	</tr>
	<tr>
		<td class="hr">India Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrInManager[$arrPracticeData["india_manager"]])?></td>
	</tr>
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSalesPerson[$arrPracticeData["sales_person"]])?></td>
	</tr>
	<tr>
		<td class="hr">Street Address</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["street_adress"])?></td>
	</tr>
	<tr>
		<td class="hr">Suburb</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["suburb"])?></td>
	</tr>
	<tr>
		<td class="hr">State</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrStates[$arrPracticeData["state"]])?></td>
	</tr>
	<tr>
		<td class="hr">Post Code</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["postcode"])?></td>
	</tr>
	<tr>
		<td class="hr">Postal Address</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["postal_address"])?></td>
	</tr>
	<tr>
		<td class="hr">Main Contact Name</td>
	 	<td class="dr"><?=htmlspecialchars($arrPracticeData["main_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Other Contact Name</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["other_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Contact Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["phone_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Alternate Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["alternate_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Fax Number</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["fax"])?></td>
	</tr>
	<tr>
		<td class="hr">Email (User Name)</td>
		<td class="dr"><?=htmlspecialchars($arrPracticeData["email"])?></td>
	</tr>
	<tr>
		<td class="hr">Password</td>
		<td class="dr"><?=$arrPracticeData["password"]?></td>
	</tr>
	<tr>
		<td class="hr">Date Signed Up</td><?
		$dateSignedUp = "";
		if (isset($arrPracticeData["date_signed_up"]) && $arrPracticeData["date_signed_up"] != "") {
			if($arrPracticeData["date_signed_up"] != "0000-00-00 00:00:00") {
				$dateSignedUp = date("d/m/Y",strtotime( $arrPracticeData["date_signed_up"]));
			}
		}  
		?><td class="dr"><?=$dateSignedUp?></td>
	</tr>
	<tr>
		<td class="hr">Agreed Services</td><?
		$arrServices = explode(',', $arrPracticeData["agreed_services"]);
		foreach($arrServices AS $intKey => $serviceId) {
			$arrAgreedServices[] = $objCallData->arrServices[$serviceId];
		}
		$strServices = implode(',', $arrAgreedServices);
		?><td class="dr"><?=$strServices;?></td>
	</tr>
	<tr>
		<td class="hr">Sent Items</td><?
		$arrItemList = explode(',', $arrPracticeData["sent_items"]);
		foreach($arrItemList AS $intKey => $serviceId) {
			$arrSentItems[] = $objCallData->arrItemList[$serviceId];
		}
		$strSentItems = implode(',', $arrSentItems);
		?><td class="dr"><?=$strSentItems?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr><?

		if($access_file_level['stf_Add'] == "Y") {
			?><td><a class="hlight"  href="pr_practice.php?a=add">Add Record</a></td><?
		}

		if($access_file_level['stf_Edit'] == "Y") {
			?><td><a class="hlight" href="pr_practice.php?a=edit&recid=<?=$recid?>">Edit Record</a></td><?
		}

		if($access_file_level['stf_Delete'] == "Y") {
			?><td><a class="hlight" onClick="performdelete('pr_practice.php?sql=delete&recid=<?=$recid?>'); return false;" href="#">Delete Record</a></td><?
		}
	?></tr>
</table>