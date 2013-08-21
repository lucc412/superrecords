<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit a Job (Audit)</h1>
	<span>
		<b>Welcome to the Super Records job submission page.</b></br>Here you can submit a new job for any client. Please note you must create the client before submitting a job for that client.
	<span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data"><?
	if(empty($arrJobInfo)) {
		?><input type="hidden" name="sql" value="insertJob"><?
	}
	else {
		?><input type="hidden" name="sql" value="update"><?
	}

	?><input type="hidden" name="type" id="type" value="AUDIT">
	<table align="center" width="90%" class="fieldtable" cellpadding="10px;">

		<tr>
			<td width="225px"><strong>Client</strong></td>
			<td>
				<select name="lstClientType" id="lstClientType" title="Select client">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $dbClientId) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Client Type</strong></td>
			<td>
				<select name="lstCliType" id="lstCliType" title="Select type of client" onchange="javascript:selectOptions('JobType');">
					<option value="0">Select Client Type</option><?php
					foreach($arrClientType AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $dbCliTypeId) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Job Type</strong></td>
			<td>
				<span id="spanJobType">	
					<select name="lstJobType" id="lstJobType" title="Select type of job"><?
						if(!empty($dbJobTypeId)) {
							?><option value="0">Select Job Type</option><?php
							foreach($arrJobType AS $typeId => $typeDesc){
								$selectStr = '';
								if($typeId == $dbJobTypeId) $selectStr = 'selected';
								?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
							}
						}
						else {
							?><option value="0">Select Job Type</option><?
						}
					?></select>
				</span>
			</td>
		</tr>


		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Period</strong></td>
			<td><input title="Specify period of job" type="text" name="txtPeriod" id="txtPeriod" value="<?=$dbPeriod?>"></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Notes</strong></td>
			<td><textarea id="txtNotes" name="txtNotes"><?=$dbNotes?></textarea>  </td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><button type="submit" value="Add">Next</button></td>
		</tr>

	</table>
</form><?

// include footer file
include(FOOTER);
?>