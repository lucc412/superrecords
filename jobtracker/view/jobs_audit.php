<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader"><?
	if(empty($arrJobInfo)) {
		?><h1>Submit new audit job</h1><?
	}
	else {
		?><h1>Edit existing audit job</h1><?
	}
	?><span><?
		if(empty($arrJobInfo)) {
			?><b>Welcome to Super Records audit only job submission page.</b></br>Here you can submit a new Audit job. Please note you must create the client before submitting a job for that client.<br/>If you would like to retrieve the previously saved job, please go to <i>Retrieve saved jobs</i> under Jobs menu otherwise please continue.<?
		}
		else {
			?><b>Welcome to Super Records audit only job edit page.</b></br>Here you can edit an existing Audit job.<?
		}
	?><span>
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
			<td><?=$arrAuditType['cliType'];?><input type="hidden" name="lstCliType" value="25"></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Job Type</strong></td>
			<td><?=$arrAuditType['jobType'];?><input type="hidden" name="lstJobType" value="11"></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Period</strong></td>
			<td><?
				$optionYear = "2010";
				?><select name="txtPeriod" id="txtPeriod" title="Select period">
					<option value="">Select Period</option><?
					while($optionYear <= date("Y")) {
						if(time() < strtotime("01 July ".$optionYear)) break;
						$optPeriod = "Year End 30/06/".$optionYear++;
						$strPeriod = '';
						if($dbPeriod == $optPeriod) $strPeriod = 'selected';
						?><option value="<?=$optPeriod?>" <?=$strPeriod?>><?=$optPeriod?></option><?php 
					}
				?></select>
			</td>
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