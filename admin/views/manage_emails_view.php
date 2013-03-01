<?
/*	
	Created Date: 01-Mar-13										
	Created By: Disha Goyal										
	Description: This is view file for page 'Manage Emails' to show all events in editable form
*/

/* Header of file */
?><div class="frmheading">
	<h1>Manage Emails</h1>
</div><br>

<form name="objForm" action="manage_emails.php" method="post"><?

	/* set hidden variables for this form */
	?><input type="hidden" name="doAction" value="update">
	<input type="hidden" name="eventId" id="eventId" value="">

	<div align="left">
		<table class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="100%"><?

			/* Headers of page */
			?><tr class="fieldheader">
				<th align="left" width="45%" class="fieldheader">Name of Event</th>
				<th class="fieldheader">From</th>
				<th class="fieldheader">To</th>
				<th class="fieldheader">CC</th>
				<th width="10%" class="fieldheader">Status</th>
				<th width="10%" class="fieldheader" align="center">Set Template</th>
				<th width="10%" class="fieldheader" align="center">Action</th>
			</tr><?

			$countRow = 0;
			foreach ($arrEvents AS $arrInfo) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";
				$eventId = $arrInfo["event_id"];

				?><tr class="<?=$trClass?>"><?

					/* Name of event */
					?><td><?=htmlspecialchars($arrInfo["event_name"])?></td><?

					/* From Email Address */
					?><td align="center"><?
						if($eventId == '1' || $eventId == '2' || $eventId == '3') {
							echo 'Email Address of Practice';
						}
						else {
							?><input size="90" type="text" name="txtFrm~<?=$eventId?>" value="<?=htmlspecialchars($arrInfo["event_from"])?>" /><?
						}
					?></td><?

					/* To Email Address */
					?><td align="center"><?
						if($eventId == '4' || $eventId == '5' || $eventId == '6') {
							echo 'Email Address of Practice';
						}
						else {
							?><textarea cols="10" rows="20" name="txtTo~<?=$eventId?>" ><?=htmlspecialchars($arrInfo["event_to"])?></textarea><?
						}
					?></td><?

					/* CC Email Address */
					?><td><textarea cols="10" rows="20" name="txtCc~<?=$eventId?>"><?=htmlspecialchars($arrInfo["event_cc"])?></textarea></td><?

					/* Status of event */
					?><td align="center"><?
						
						if(empty($arrInfo["event_status"])) {
							$eventStatus = 'InActive';
							$hrefTitle = 'Click to activate the event';
							$hrefStyle = 'style="color:red"';
						}
						else {
							$eventStatus = 'Active';
							$hrefTitle = 'Click to inactivate the event';
							$hrefStyle = 'style="color:#005b17"';
						}
						
						?><a href="manage_emails.php?doAction=changeStatus&eventId=<?=$eventId?>&status=<?=$arrInfo["event_status"]?>" title="<?=$hrefTitle?>"><b <?=$hrefStyle?>><?=$eventStatus;?></a>

					</td><?

					/* Save & Edit content button */
					?><td align="center">
						<a href="manage_emails.php?action=edit&eventId=<?=$eventId?>"><b style="color:#005b17"><img title="Click to set mail template" src="images/email_content.png"/></b></a>
					</td>
					<td align="center">
						<button type="submit" value="save" onclick="javascript:saveEmailEvent(<?=$eventId?>)">Save</button>
					</td>
				</tr><?
				$countRow++;
			}
		?></table>
	</div>

</form>