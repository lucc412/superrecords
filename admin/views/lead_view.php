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
		<td class="hr">SR Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSrManager[$arrLeadData["sr_manager"]])?></td>
	</tr>
    
    <tr>
		<td class="hr">India Manager</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrIndiaManager[$arrLeadData["india_manager"]])?></td>
	</tr>
    
    <tr>
		<td class="hr">Team Member
       
        </td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrEmployees[$arrLeadData["team_member"]])?></td>
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
		<td class="hr">Date Received</td><? 
		$dateReceived = "";
		if (isset($arrLeadData["date_received"]) && $arrLeadData["date_received"] != "") {
			if($arrLeadData["date_received"] != "0000-00-00 00:00:00") {
				$dateReceived = date("d/m/Y",strtotime($arrLeadData["date_received"])); 
			}
		}
		?><td class="dr"><?=$dateReceived?></td>
	</tr>
	<tr>
		<td class="hr">Day Received</td>
		<td class="dr"><?=$arrLeadData['day_received']?></td>
	</tr>
	<tr>
		<td class="hr">Industry</td>
		<td class="dr"><?=$objCallData->arrIndustry[$arrLeadData['lead_industry']]?></td>
	</tr>
	<tr>
		<td class="hr">Lead Status</td>
		<td class="dr"><?=$objCallData->arrStatus[$arrLeadData['lead_status']]?></td>
	</tr><?
	
	if($arrLeadData['lead_reason'] != ''){
		?><tr>
			<td class="hr">Reason</td>
			<td class="dr">
				<input type="text" name="lead_reason" value="<?=$arrLeadData['lead_reason']?>">
			</td>
		</tr><?
	}
		
	?><tr>
		<td class="hr">Lead Stage</td>
		<td class="dr"><?=$objCallData->arrStage[$arrLeadData['lead_stage']]?></td>
	</tr>
	<tr>
		<td class="hr">Lead Source</td>
		<td class="dr"><?=$objCallData->arrSource[$arrLeadData['lead_source']]?></td>
	</tr>
	<tr>
		<td class="hr">Sales Person</td>
		<td class="dr"><?=htmlspecialchars($objCallData->arrSalesPerson[$arrLeadData["sales_person"]])?></td>
	</tr>
	<tr>
		<td class="hr">Last Date of Contact</td><?
		$lastContactDate = "";
		if (isset($arrLeadData["last_contact_date"]) && $arrLeadData["last_contact_date"] != "") {
			if($arrLeadData["last_contact_date"] != "0000-00-00 00:00:00") {
				$lastContactDate = date("d/m/Y",strtotime($arrLeadData["last_contact_date"])); 
			}
		}
		?><td class="dr"><?=$lastContactDate?></td>
	</tr>
	<tr>
		<td class="hr">Future Contact Date</td><?
		$futureContactDate = "";
		if (isset($arrLeadData["future_contact_date"]) && $arrLeadData["future_contact_date"] != "") {
			if($arrLeadData["future_contact_date"] != "0000-00-00 00:00:00") {
				$futureContactDate = date("d/m/Y",strtotime($arrLeadData["future_contact_date"])); 
			}
		}
		?><td class="dr"><?=$futureContactDate?></td>
	</tr>
	<tr>
		<td class="hr">Notes</td>
		<td class="dr"><?=nl2br($arrLeadData['note'])?></td>
	</tr>
</table>

<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
	<tr><?
		if($access_file_level['stf_Add'] == "Y") {
			?><td><a class="hlight"  href="lead.php?a=add">Add Record</a></td><?
		}

		if($access_file_level['stf_Edit'] == "Y") {
			?><td><a class="hlight"  href="lead.php?a=edit&recid=<?=$recid?>">Edit Record</a></td><?
		}

		if($access_file_level['stf_Delete'] == "Y") {
			?><td><a class="hlight"  onClick="performdelete('lead.php?sql=delete&recid=<?=$recid?>'); return false;" href="#" >Delete Record</a></td><?
		}
	?></tr>
</table>