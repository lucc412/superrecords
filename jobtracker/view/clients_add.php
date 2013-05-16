<?php

// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Add New Client</h1>
	<span>
		<b>Welcome to the Super Records client submission page.</b></br>Here you can submit a new client for Super Records.
	<span>
</div><?

// error message
if(!empty($_REQUEST['flagDuplicate'])) {
	?><div class="errorMsg"><?=ERRORICON?>&nbsp;Client already exists.</div><?	
}

// content
?><form name="objForm" method="post" action="clients.php" onSubmit="javascript:return checkValidation();">
	<input type="hidden" name="sql" value="insert"></br>
	
	<table width="60%" cellpadding="10px;">
		<tr>
			<td><strong>Client Name</strong></td>
			<td><input type="text" name="txtName" id="txtName" onblur="javascript:checkUnique(this.value, '')"><br/>
			<span class="errmsg" id="wrongText" style="display:none;"><b>Client already exists.</b></span></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td><strong>Entity Type</strong></td>
			<td>
				<select name="lstType" id="lstType">
					<option value="0">Select Entity Type</option><?php
					foreach($arrClientType AS $typeId => $typeDesc){
						?><option value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left" colspan="2"><input id="cbAuthority" name="cbAuthority" type="checkbox" style="width: auto;margin-right: 10px;" value="">
			<strong>I have received written authority from my client to utilise the services of Super Records Pty Ltd <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and its associated entities for the completion of work as requested.</strong></input></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" id="submit" value="Add">Add</button></td>
		</tr>
	</table><?
?></form><?

// include footer file
include(FOOTER);	
?>