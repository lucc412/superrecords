<div class="frmheading">
	<h1>View Lead</h1>
</div>

<table class="tbl" border="0" cellspacing="12" width="70%">
	<tr>
		<td class="hr">Lead</td>
		<td class="dr">&nbsp;</td>
	</tr>
	<tr>
		<td class="hr">Lead Type</td>
		<td><?=htmlspecialchars($objCallData->arrTypes[$arrLeadData["lead_type"]])?></td>
	</tr>
	<tr>
		<td class="hr">Lead Name</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["lead_name"])?></td>
	</tr>
	
	<tr>
		<td class="hr">Street Address</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["street_adress"])?></td>
	</tr>
	<tr>
		<td class="hr">Suburb</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["suburb"])?></td>
	</tr>
	<tr>
		<td class="hr">State</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrStates[$arrLeadData["state"]])?></td>
	</tr>
	<tr>
		<td class="hr">Post Code</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["postcode"])?></td>
	</tr>
	<tr>
		<td class="hr">Postal Address</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["postal_address"])?></td>
	</tr>
	<tr>
		<td class="hr">Main Contact Name</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["main_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Other Contact Name</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["other_contact_name"])?></td>
	</tr>
	<tr>
		<td class="hr">Contact Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["phone_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Alternate Phone No</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["alternate_phone_no"])?></td>
	</tr>
	<tr>
		<td class="hr">Fax Number</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["fax"])?></td>
	</tr>
	<tr>
		<td class="hr">Email</td>
		<td class="dr"><?=htmlspecialchars($arrLeadData["email"])?></td>
	</tr>
	<tr>
		<td class="hr">Date Signed Up</td>
		<? $dateReceived = date("d/m/Y",strtotime( $arrLeadData["date_received"])); ?>
		<td class="dr"><?=$dateReceived?></td>
	</tr>
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSalesPerson[$arrLeadData["sales_person"]])?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr>
		<td><a class="hlight"  href="lead.php?a=add">Add Record</a></td>
		<td><a class="hlight"  href="lead.php?a=edit&recid=<?=$recid?>">Edit Record</a></td>
		<td><a class="hlight"  onClick="performdelete('lead.php?sql=delete&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td>
	</tr>
</table>