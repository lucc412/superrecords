<?
// include topbar file
include(TOPBAR);
include(SETUPNAVIGATION);
// page header
?><div class="pageheader">
	<h1>Submit a Job (Setup)</h1>
	<span>
		<b>Welcome to the Super Records job submission page.</b></br>Here you can submit a new job for any client. Please note you must create the client before submitting a job for that client.
	<span>
</div>
<form name="objForm" id="objForm" method="post" action="jobs.php?sql=insertJob&type=SETUP" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">
	<input type="hidden" name="job_submitted" value="N">
        <input type="hidden" name="type" id="type" value="SETUP">
        <input type="hidden" name="subfrmId" value="<?=$_REQUEST['frmId']?>">
	<table align="center" width="90%" class="fieldtable" cellpadding="10px;">

		<tr>
			<td><strong>Client</strong></td>
			<td>
				<select name="lstClientType" id="lstClientType" title="Select Client">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						?><option value="<?=$clientId?>"><?=$clientName?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Client Type</strong></td>
			<td>
				<select name="lstCliType" id="lstCliType" title="Select type of client" onchange="javascript:selectOptions('JobType');">
					<option value="0">Select Client Type</option><?php
					foreach($arrClientType AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Job Type</strong></td>
			<td>
				<span id="spanJobType">	
					<select name="lstJobType" id="lstJobType" title="Select type of job">
						<option value="0">Select Job Type</option>
					</select>
				</span>
			</td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Period</strong></td>
			<td><input title="Specify period of job" type="text" name="txtPeriod" id="txtPeriod" value=""></td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Notes</strong></td>
			<td><textarea id="txtNotes" name="txtNotes"></textarea>  </td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        </table>
        <div style="padding-top:20px;">
            <span align="left"><button type="button" onclick="window.location.href='jobs.php?a=order'" value="BACK" />BACK</button></span>
            <span align="right" style="padding-left:55px;"><button type="reset" >RESET</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit">NEXT</button></span>
        </div>
</form><?

// include footer file
include(FOOTER);
?>