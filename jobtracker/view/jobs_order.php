<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit a Job</h1>
	<span>
		<b>Welcome to the Super Records job submission page.</b></br>Here you can submit a new job for any client. Please note you must create the client before submitting a job for that client.
	<span>
</div>
<form name="objForm" id="objForm" method="post" action="jobs.php?sql=insertJob&type=SETUP" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">
	<input type="hidden" name="job_submitted" value="N">
        <input type="hidden" name="subfrmId" value="<?=$_REQUEST['frmId']?>">
	<table align="center" width="90%" class="fieldtable" cellpadding="10px;">

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

<!--		<tr>
			<td><strong>Source Documents</strong></td>
			<td><span class="docheader">Description</span></td>
			<td><span class="docheader">File Path</span></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td width="274px"><input type="text" name="textSource_50" title="Specify name of source document"></td>
			<td width="240px"><input type="file" name="sourceDoc_50" id="sourceDoc_50" title="Upload source document"></td>
			<td><button type="button" style="margin-top:-6px;width: 94px;" title="Click here to upload new source document" onclick="javascript:addElement();" value="Add">Add</button></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><div id="parentDiv" style="margin-top:-17px;">&nbsp;</div></td>
		</tr>-->

<!--		<td><button type="reset" onclick="window.location.href='jobs.php?a=order'" >Back</button></td>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" value="Add">Next</button></td>-->
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