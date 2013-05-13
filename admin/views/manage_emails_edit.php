<?
/*	
	Created By -> 01-Mar-13 [Disha Goyal]
	Last Modified By -> 07-Mar-13 [Disha Goyal]									
	Description: This is view file for page 'Manage Emails' to edit subject, content of events
*/

/* Header of file */
?><div class="frmheading">
	<h1>Set Email Template - <?=$arrEventInfo["event_name"]?></h1>
</div><br>

<form name="objForm" action="manage_emails.php" method="post"><?

	/* set hidden variables for this form */
	?><input type="hidden" name="doAction" value="setTemplate">
	<input type="hidden" name="action" value="edit">
	<input type="hidden" name="eventId" id="eventId" value="<?=$arrEventInfo["event_id"]?>">

	<div align="left">
		<table class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%"><?

			/* Event subject */
			?><tr>
				<td>Subject</td>
				<td>
					<input size="90" maxlength="200" type="text" name="txtSubject" value="<?=htmlspecialchars($arrEventInfo["event_subject"])?>" />
				</td>
			</tr><?
	
			/* Empty row*/
			?><tr><td>&nbsp;</td></tr><?

			/* Event content */
			?><tr>
				<td>Content</td>
				<td><?
					$eventId = $arrEventInfo["event_id"];
					?><textarea cols="80" id="txtContent" name="txtContent" rows="10"><?=$arrEventInfo["event_content"]?></textarea><br/>

					<span style="color:orange"><u>Below are the dynamic fields applicable to this content:</u></span><?

					if($eventId != '6' && $eventId != '7' && $eventId != '8' && $eventId != '9') {
						?><div style="padding-bottom:5px;color:red;font-weight:bold">PRACTICENAME</div><?
					}

					if($eventId == '1') {
						?><div style="padding-bottom:5px;color:red;font-weight:bold">SALESPERSONNAME</div><?
					}
					
					if($eventId == '2') {
						?><div style="padding-bottom:5px;color:red;font-weight:bold">CLIENTNAME</div><?
					}
					
					if($eventId != '1' && $eventId != '2' && $eventId == '9') {
						?><div style="padding-bottom:5px;color:red;font-weight:bold">JOBNAME</div><?
					}

					if($eventId == '5') {
						?><div style="padding-bottom:5px;color:red;font-weight:bold">DOCNAME</div>
						<div style="padding-bottom:5px;color:red;font-weight:bold">DATETIME</div><?
					}

					?><script type="text/javascript">
					//<![CDATA[

						CKEDITOR.replace( 'txtContent',
							{
								skin : 'kama'
							});

					//]]>
					</script>
				</td>
			</tr><?

			/* Empty row*/
			?><tr><td>&nbsp;</td></tr><?

			/* Save content button */
			?><tr>
				<td>&nbsp;</td>
				<td>
					<button type="submit" value="save" onclick="manage_emails.php">Save</button>
				</td>
			</tr><?

		?></table>
	</div>

</form>