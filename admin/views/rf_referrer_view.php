<div class="frmheading">
	<h1>View Referrer</h1>
</div>

<table class="tbl" border="0" cellspacing="12" width="70%">
	<tr>
		<td class="hr">Referrer</td>
		<td class="dr">New</td>
	</tr>
	<tr>
		<td class="hr">Type</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrTypes[$arrRefererData["type"]])?></td>
	</tr>
	<tr>
		<td class="hr">Referrer Name</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["name"])?></td>
	</tr>
	<tr>
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrRefererData["sr_manager"]])?></td>
	</tr>
	<tr>
		<td class="hr">Street Address</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["street_adress"])?></td>
	</tr>
	<tr>
		<td class="hr">Suburb</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["suburb"])?></td>
	</tr>
	<tr>
		<td class="hr">State</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrStates[$arrRefererData["state"]])?></td>
	</tr>
	<tr>
		<td class="hr">Post Code</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["postcode"])?></td>
	</tr>
	<tr>
		<td class="hr">Postal Address</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["postal_address"])?></td>
	</tr>
	<tr>
		<td class="hr">Main Contact Name</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["main_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Other Contact Name</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["other_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Contact Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["phone_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Alternate Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["alternate_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Fax Number</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["fax"])?></td>
	</tr>
	<tr>
		<td class="hr">Email</td>
		<td class="dr"><?=htmlspecialchars($arrRefererData["email"])?></td>
	</tr>
	<tr>
		<td class="hr">Date Signed Up</td><?
		$dateSignedUp = "";
		if (isset($arrRefererData["date_signed_up"]) && $arrRefererData["date_signed_up"] != "") {
			if($arrRefererData["date_signed_up"] != "0000-00-00 00:00:00") {
				$dateSignedUp = date("d/m/Y",strtotime( $arrRefererData["date_signed_up"]));
			}
		}  
		?><td class="dr"><?=$dateSignedUp?></td>
	</tr>
	<tr>
		<td class="hr">Agreed Services</td><?
		$arrServices = explode(',', $arrRefererData["agreed_services"]);
		foreach($arrServices AS $intKey => $serviceId) {
			$arrAgreedServices[] = $objCallData->arrServices[$serviceId];
		}
		$strServices = implode(',', $arrAgreedServices);
		?><td class="dr"><?=$strServices;?></td>
	</tr>
	<tr>
		<td class="hr">Sent Items</td><?
		$arrItemList = explode(',', $arrRefererData["sent_items"]);
		foreach($arrItemList AS $intKey => $serviceId) {
			$arrSentItems[] = $objCallData->arrItemList[$serviceId];
		}
		$strSentItems = implode(',', $arrSentItems);
		?><td class="dr"><?=$strSentItems?></td>
	</tr>
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSalesPerson[$arrRefererData["sales_person"]])?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="14">
	<tr><?
		if($access_file_level['stf_Add'] == "Y") {
			?><td><a class="hlight"  href="rf_referrer.php?a=add">Add Record</a></td><?
		}

		if($access_file_level['stf_Edit'] == "Y") {
			?><td><a class="hlight" href="rf_referrer.php?a=edit&recid=<?=$recid?>">Edit Record</a></td><?
		}
		
		if($access_file_level['stf_Delete'] == "Y") {
			?><td><a class="hlight"  onClick="performdelete('rf_referrer.php?sql=delete&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td><?
		}
	?></tr>
</table>