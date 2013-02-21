<?
// include topbar file
include('../include/topbar.php');

// page header
?><div class="pageheader">
	<h1>Submit a Job</h1>
	<span>
		<b>Welcome to the Super Records job submission page.</b></br>Here you can submit a new job for any client. Please note you must create the client before submitting a job for that client.
	<span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">
	<input type="hidden" name="sql" value="insert">
	<table align="center" width="100%" class="fieldtable" cellpadding="10px;">

		<tr>
			<td><strong>Client</strong></td>
			<td>
				<select name="lstClientType" id="lstClientType" title="Select client">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						?><option value="<?=$clientId?>"><?=$clientName?></option><?php 
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
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

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

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Period</strong></td>
			<td><input title="Specify period of job" type="text" name="txtPeriod" id="txtPeriod" value=""></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Checklist</strong></td>
			<td><input type="file" name="fileChecklist" id="fileChecklist" title="Upload checklist"></td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Source Documents</strong></td>
			<td><span class="docheader">Description</span></td>
			<td><span class="docheader">File Path</span></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><input type="text" name="textSource_50" title="Specify name of source document"></td>
			<td><input type="file" name="sourceDoc_50" id="sourceDoc_50" title="Upload source document"></td>
			<td><button type="button" title="Click here to upload new source document" onclick="javascript:addElement();" value="Add">Upload New +</button></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><div id="parentDiv">&nbsp;</div></td>
		</tr>

		<tr>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" value="Add">Add</button></td>
		</tr>

	</table>
</form><?

// include footer file
include('../include/footer.php');	
?>