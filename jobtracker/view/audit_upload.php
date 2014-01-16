<?
// include topbar file
include(HEADDATA);

// page header
?>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=DIR?>js/jquery-fileupload/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=DIR?>js/jquery-fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=DIR?>js/jquery-fileupload/jquery.fileupload.js"></script>

<div class="pageheader pd10">
	<h1>Upload multiple documents</h1>
	<a href="javascript:;" class="boxclose" title="click here to close this window" onclick="window.close()" />X</a>
	<span>
		<b>Welcome to the Super Records audit checklist upload page.</b></br>Here you can upload multiple documents for your job.
	<span>
</div><?

// content
?><div class="pd10">
	<form name="objForm" id="objForm" method="post" action="audit_upload.php" onSubmit="javascript:return uploadValidate();" enctype="multipart/form-data">
		<span><input type="text" id="fileTitle" name="fileTitle"></span>
		<span><input type="file" id="fileUpload" class="fileupload" name="fileUpload"></span>
		<span><button style="width:94px;" type="button" id="add" title="click here to add document" onclick="return uploadValidate();" value="Add">Upload</button></span>
		<input type="hidden" name="sql" value="uploadAuditDocs">
		<div id="uploads"></div>		
	</form><?

	if(!empty($arrDocList)) {
		?><div class="pdT50">
			<table width="100%" class="resources">
				<tr>
					<td class="td_title">Document Name</td>
					<td width="100px" align="center" class="td_title">Date</td>
				</tr><?

				$countRow = 0;
				foreach($arrDocList AS $intKey => $uploadDocs) {
					$fileName = $uploadDocs['file_path'];
					$uploadedDate = $uploadDocs['date'];
					$docTitle = $uploadDocs['document_title'];
					if($countRow%2 == 0) $trClass = "trcolor";
					else $trClass = "";
					?><tr class="<?=$trClass?>"><?
                                                $icon = returnFileIcon($fileName);
						?><td class="tddata"><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($fileName)?>&folderPath=A" title="Click to view this document"><?=$docTitle?></a></p></td>
						<td align="center" class="tddata"><?=$uploadedDate?></td>
					</tr><?
					$countRow++;
				}
			?></table>
		</div><?
	}
	else {
		?><div class="pdT50"><div class="errorMsg">You don't have any documents added yet.</div></div><?
	}
?></div>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'audit_upload.php';

	$('.fileupload').each(function () {				
	    $(this).fileupload({
			autoUpload: false,
			maxNumberOfFiles: 1,
	        url: url,
	        dataType: 'json',
			add: function (e, data) {
				$("#uploads").html("");
				filestoupload =0;
				var file=data.files[0];
				var vOutput="";
				vOutput+= file.name + '<div id="progress" class="progress"><div class="progress-percent">0%</div><div class="progress-bar progress-bar-success"></div></div><input type="button" class="fileUpload" value="upload" style="display:none;"><input type="button" class="fileCancel" value="cancel" style="display:none;">';
				$("#uploads").append(vOutput);
				$(".fileUpload").eq(-1).on("click",function(){
				   var jqXHR = data.submit()
			        .success(function (result, textStatus, jqXHR) {})
			        .error(function (jqXHR, textStatus, errorThrown) {})
			        .complete(function (result, textStatus, jqXHR) {
						location.reload();
					});
				});
				$(".fileCancel").eq(-1).on("click",function(){
                	$("#uploads").html("");
					filestoupload--;
             	});
      			filestoupload++;
		    },
	        progressall: function (e, data) {
				//var tmp_names = $(this).attr('id').split('-');
	            var progress = parseInt(data.loaded / data.total * 100, 10);
	            $('#progress .progress-bar').css(
	                'width',
	                progress + '%'
	            );
				$('#progress .progress-percent').text(progress + '%');
	        }
	    });
	});
});
</script>