<?
// include topbar file
include(HEADDATA);

// page header
?><div class="pageheader pd10">
	<h1>Add documents for <?=$subchecklistName?></h1>
	<span>
		<b>Welcome to the Super Records job checklist upload page.</b></br>Here you can upload checklists for job.
	<span>
</div><?

// content
?><div class="pd10">
	<form name="objForm" id="objForm" method="post" action="audit.php" onSubmit="javascript:return uploadValidate();" enctype="multipart/form-data">
		<span><input type="text" id="fileTitle" name="fileTitle"></span>
		<span><input type="file" id="fileUpload" name="fileUpload"></span>
		<span><button style="width:94px;" type="submit" title="click here to add document" value="Add">Add</button></span>
		<input type="hidden" name="checklistId" value="<?=$_REQUEST['checklistId']?>">
		<input type="hidden" name="subchecklistId" value="<?=$_REQUEST['subchecklistId']?>">
		<input type="hidden" name="sql" value="uploadSubAuditDocs">
	</form>
</div>