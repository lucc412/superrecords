<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Submit new compliance job</h1>
	<span>
		<b>Welcome to the Super Records compliance job submission page.</b></br>Here you can submit a new compliance job. Please note you must create the client before submitting a job for that client.
	<span>
</div><?

// content
?><form name="objForm" id="objForm" method="post" action="jobs.php?sql=insertJob" onSubmit="javascript:return checkDuplicateJob();" enctype="multipart/form-data">
	<input type="hidden" name="type" id="type" value="COMPLIANCE">
	<table align="center" width="90%" class="fieldtable" cellpadding="10px;">

		<tr>
			<td><strong>Client</strong></td>
			<td>
                            
<!--                            <select name="lstClientType" id="lstClientType" title="Select client" onchange="changeDuplicate()">
					<option value="0">Select Client</option><?php
					//foreach($arrClients AS $clientId => $clientName){
						?><option value="<?=$clientId?>"><?=$clientName?></option><?php 
					//}
				?></select>-->
                                
                                <input type="text" name="lstClientTypeSearch" id="lstClientTypeSearch" value=""  />
                                <input type="hidden" name="lstClientType" id="lstClientType" />
                                
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
			<!--<td><input title="Specify period of job" type="text" name="txtPeriod" id="txtPeriod" value=""></td>-->
                        <td><?
				$optionYear = "2010";
				?><select name="txtPeriod" id="txtPeriod" title="Select period" onchange="changeDuplicate()">
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
			<td><textarea id="txtNotes" name="txtNotes"></textarea>  </td>
		</tr>

		<tr><td>&nbsp;</td></tr>

		<tr>
			<td><strong>Source Documents</strong></td>
			<td><span class="docheader">Description</span></td>
			<td><span class="docheader">File Path</span></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td width="274px"><input type="text" name="textSource_50" id="textSource_50" title="Specify name of source document"></td>
			<td width="240px"><input type="file" name="sourceDoc_50" id="sourceDoc_50" title="Upload source document"></td>
			<td><button type="button" style="margin-top:-6px;width: 94px;" title="Click here to upload new source document" onclick="javascript:addElement();" value="Add">Add</button></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><div id="parentDiv" style="margin-top:-17px;">&nbsp;</div></td>
		</tr>

		<tr>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" value="Add">Submit</button></td>
		</tr>

	</table>
</form>
<style>
    .ui-dialog
    {
        height: 142px !important;
        width: 550px !important;
    }
    .ui-widget-header{
        background: url("../images/submit-bg.jpg") no-repeat scroll left center #074165;
        color: #FFF;
    }
    .ui-dialog-content{
        height: 40px !important;
        overflow: hidden !important;
    }
</style>

<div id="dialog-confirm" title="Warning" style="display: none;">
  <p>
      <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
      You have already submitted the same Job previously. If you would like to upload additional documents for already submitted job, please go to <a style="text-decoration: underline;cursor: pointer;color: #074165;" onclick="javascript:window.location.assign('jobs.php?a=document')">View and upload documents</a> menu under Jobs.
  </p>
</div>


    <?

// include footer file
include(FOOTER);
?>