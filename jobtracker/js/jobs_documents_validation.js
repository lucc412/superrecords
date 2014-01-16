function checkDocValidation()
{	
	flagReturn = true;

	var lstJob = document.getElementById('lstJob');
	var docTitle = document.getElementById('txtDocTitle');
	var fileDoc = document.getElementById('fileDoc');
	
	// do field validation  
	if (lstJob.value == 0)
	{
		lstJob.className = "errclass";
		flagReturn = false;
	}
	else {
		lstJob.className = "drop_down_select";
	}

	if (docTitle.value == "")
	{		
		docTitle.className = "errclass";
		flagReturn = false;
	}
	else {
		docTitle.className = "";
	}
	
	//if (fileDoc.value == "")
	if (filestoupload == 0)
	{		
		fileDoc.className = "errclass";
		flagReturn = false;
	}
	else {
		fileDoc.className = "";
	}
	
	if(flagReturn) {
		$(".fileUpload").click();
		//document.objForm.submit();
	}
	
	return flagReturn;
}

var filestoupload = 0;
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
						if($("#additionalDoc").val() == "Y"){
							location.href = "jobs_pending.php";
						} else {
							location.href = "jobs_doc_list.php";
						}
						//location.reload();
						//opener.parent.location.href = 'audit_subchecklist.php?checklistId=' + $("#checklistId").val();
						//self.close();
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