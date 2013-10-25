<?php
// include topbar file
include(TOPBAR);

// include navigation
include(HOLDINGTRUSTNAV);

// include page content
include(HOLDINGTRUSTCONTENT);

// page header
?><div class="pageheader">
    <h1>Holding Trust Details</h1>
    <span><b>Welcome to the Super Records holding trust details page.</b><span>
</div><?

// content
?><form name="objForm" method="post" action="clients.php" onSubmit="javascript:return checkValidation();">
	<input type="hidden" name="sql" value="insert"></br>
	
	<table width="60%" cellpadding="10px;">
		<tr>
                    <td><strong>Client Name</strong></td>
                    <td><input type="text" name="txtName" id="txtName" onblur="javascript:checkUnique(this.value, '')"><br/>
                    <span class="errmsg" id="wrongText" style="display:none;"><b>Client already exists.</b></span></td>
		</tr>
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
		<tr><?
                        if(empty($_SESSION['jobId'])){?><td><button type="button" onclick="window.location='setup.php'" value="Back">Back</button></td><?}
			?><td><button type="submit" id="submit" value="Add">Add</button></td>
		</tr>
	</table><?
?></form><?

// include footer file
include(FOOTER);
?>