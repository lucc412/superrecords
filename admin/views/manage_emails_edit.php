<?
/*	
	Created Date: 01-Mar-13										
	Created By: Disha Goyal										
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
					<input size="90" type="text" name="txtSubject" value="<?=htmlspecialchars($arrEventInfo["event_subject"])?>" />
				</td>
			</tr><?
	
			/* Empty row*/
			?><tr><td>&nbsp;</td></tr><?

			/* Event content */
			?><tr>
				<td>Content</td>
				<td>
					<textarea cols="80" id="txtContent" name="txtContent" rows="10"><?=$arrEventInfo["event_content"]?></textarea><br/>

					<span style="color:orange"><u>Below are the pre-defined constants that can be used in the content:</u></span>

					<div style="padding-top:10px;padding-bottom:5px;"><b style="color:red">@fromName</b> - Sets name of FROM email address</div>

					<div style="padding-bottom:5px;"><b style="color:red">@toName</b> - Sets name of TO email address</div><?

					if($_REQUEST['eventId'] == '4') {
						?><div style="padding-bottom:5px;"><b style="color:red">@jobStatus</b> - Sets STATUS of job</div><?
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