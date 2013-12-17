<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>View My Client List</h1>
	<span>
		<b>Welcome to the Super Records client list for your practice.</b></br>Here you can see a list of clients you have set up with Super Records as well as add new clients. Please note you will need to add the client before submitting any jobs for that client.
	<span>
</div><?

// content
if(count($arrClients) == 0) {
	?><div class="errorMsg">You don't have any clients added yet.</div><?	
}
else {
	?><table align="center" width="100%">
		<tr>
			<th width="60%" class="td_title" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Client Name <img id="sort_name" src="images/sort_asc.png"></th>
			<th width="18%" class="td_title" align="left" style="cursor:pointer;" onclick="changeSortImage('sort_type');">Entity Type <img id="sort_type" src="images/sort_asc.png"></th>
			<th width="12%" class="td_title date" align="center" style="cursor:pointer;" onclick="changeSortImage('sort_date');">Date Created <img id="sort_date" src="images/sort_asc.png"></th>
			<td width="8%" class="td_title" align="center">Actions</td>
		</tr><?

		$countRow = 0;
		foreach($arrClients AS $clientId => $arrClientDetails) {
			if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";
			?><tr class="<?=$trClass?>">
				<td class="tddata"><?=$arrClientDetails['client_name']?></td>
				<td class="tddata"><?=$arrClientType[$arrClientDetails['client_type_id']]?></td>
				<td class="tddata" align="center"><?=$arrClientDetails['client_received']?></td>
				<td class="tddata" align="center"><a title="click here to edit this client" href='clients.php?a=edit&recid=<?=$clientId?>'><?=EDITICON?></a></td>
			</tr><?
			$countRow++;
		}
	?></table>
	<?
}

// include footer file
include(FOOTER);
?>