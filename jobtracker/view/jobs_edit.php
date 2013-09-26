<?
// include topbar file
include(TOPBAR);
include(SETUPNAVIGATION);
// page header
?><div class="pageheader">
	<h1>Edit Job</h1>
	<span><b>Welcome to the Super Records job edit page.</b><span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php" onSubmit="javascript:return checkValidation();" enctype="multipart/form-data">
	<input type="hidden" name="sql" value="update">
	<input type="hidden" name="type" value="<?=$arrJobsData['job_genre']?>">
	<input type="hidden" name="subfrmId" value="<?=$_REQUEST['frmId']?>">
	<input type="hidden" name="recid" value="<?=$_REQUEST['recid']?>"><?
	$jobId = $_REQUEST['recid'];
	?>
        <table align="center" width="90%" class="fieldtable" cellpadding="10px;">
		<tr>
			<td><strong>Client</strong></td>
			<td>
				<select name="lstClientType" id="lstClientType" title="Select client">
					<option value="0">Select Client</option><?php
					foreach($arrClients AS $clientId => $clientName){
						$selectStr = '';
						if($clientId == $arrJobsData['client_id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
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
						$selectStr = '';
						if($typeId == $arrJobsData['mas_Code']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
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
						<option value="0">Select Job Type</option><?php
						foreach($arrJobType AS $typeId => $typeDesc){
							$selectStr = '';
							if($typeId == $arrJobsData['job_type_id']) $selectStr = 'selected';
							?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
						}
					?></select>
				</span>
			</td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Period</strong></td>
			<td><input type="text" name="txtPeriod" id="txtPeriod" value="<?=$arrJobsData['period']?>"></td>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		
		<tr>
			<td><strong>Notes</strong></td>
			<td> <textarea id="txtNotes" name="txtNotes"><?=$arrJobsData['notes']?></textarea>
		</tr>

		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr>
			<td>&nbsp;</td>
			<td colspan="3"><div id="parentDiv">&nbsp;</div></td>
		</tr>
	</table>
        
        <div style="padding-top:20px;">

            <span align="right" ><button type="reset" value="Reset" >Reset</button></span>
            <span align="right" style="padding-left:55px;"><button type="submit" value="Edit">Next</button></span>
        </div>
</form><?

// include footer file
include(FOOTER);
?>