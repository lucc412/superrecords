<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Edit Existing Client</h1>
	<span><b>Welcome to the Super Records client edit page.</b><span>
</div><?

// error message
if(!empty($_REQUEST['flagDuplicate'])) {
	?><div class="errorMsg"><?=ERRORICON?>&nbsp;Client already exists.</div><?	
}

// content
?><form name="objForm" method="post" action="clients.php" onSubmit="javascript:return checkValidation();">
	<input type="hidden" name="sql" value="update">
	<input type="hidden" name="recid" value="<?=$_REQUEST['recid']?>">
	
	</br>
	<table width="50%" cellpadding="10px;">
		<tr>
			<td><strong>Client Name</strong></td>
			<td><input type="text" name="txtName" id="txtName" value="<?=$arrClientsData['client_name']?>" onblur="javascript:checkUnique(this.value, '<?=$_REQUEST['recid']?>')"><br/>
			<span class="errmsg" id="wrongText" style="display:none;"><b>Client already exists.</b></span></td>
		</tr>
		<tr>
			<td><strong>Entity Type</strong></td>
			<td>
				<select name="lstType" id="lstType">
					<option value="0">Select Entity Type</option><?php
					foreach($arrClientType AS $typeId => $typeDesc){
						$selectStr = '';
						if($typeId == $arrClientsData['client_type_id']) $selectStr = 'selected';
						?><option <?=$selectStr?> value="<?=$typeId?>"><?=$typeDesc?></option><?php 
					}
				?></select>
			</td>
		</tr>
		<tr>
			<td><button type="reset" value="Reset">Reset</button></td>
			<td><button type="submit" id="submit" value="Edit">Edit</button></td>
		</tr>
	</table>	
</form><?

// include footer file
include(FOOTER);
?>