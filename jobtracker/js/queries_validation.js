// This function is used to update a query response
function updateQuery(queryId) {

	var eleQueryId = document.getElementById('queryId');
	eleQueryId.value = queryId;
	var filestoupload = $("#upload_" + queryId + " > div").size(); //Count inside of upload
	if(filestoupload > 0) {
		$("#fileUploadbtn_" + queryId).click();
	} else {	
		document.objForm.submit();
	}
}

// This function is used to update a query response
function submitForm() {

	var doAction = document.getElementById('action');
	doAction.value = 'submitForm';
	document.objForm.submit();
}

$(function () {
    'use strict';
    var url = 'queries.php?flagUpdate=Y&lstJob=' + $("#lstJob").val() + '&lstCliType='+$('#lstCliType').val();

	$('.fileupload').each(function () {				
	    $(this).fileupload({
			autoUpload: false,
			maxNumberOfFiles: 1,
	        url: url,
	        dataType: 'json',
			add: function (e, data) {
				var tmp_names = $(this).attr('id').split('_');
							
				var file=data.files[0];
				var vOutput="";
				vOutput+= '<div><span>'+file.name + '<input type="button" id="fileCancel_'+tmp_names[1]+'" class="fileCancel boxclose" style="margin-top: -5px;width:20px;" value="X" style=""></span></div><div id="progress_'+tmp_names[1]+'" class="progress"><div class="progress-percent">0%</div><div class="progress-bar progress-bar-success"></div></div><input type="button" class="fileUploadbtn" id="fileUploadbtn_'+tmp_names[1]+'" value="upload" style="display:none;">';
				$("#upload_" + tmp_names[1]).append(vOutput);
				$("#doc_"+tmp_names[1]).hide();				
				$("#fileUploadbtn_" + tmp_names[1]).on("click",function(){
				var new_url = 'queries.php?flagUpdate=Y&lstJob=' + $("#lstJob").val() + '&lstCliType='+$('#lstCliType').val();
				//data.url = new_url;
				   var jqXHR = data.submit()
			        .success(function (result, textStatus, jqXHR) {})
			        .error(function (jqXHR, textStatus, errorThrown) {})
			        .complete(function (result, textStatus, jqXHR) {
						location.href = new_url;
						//alert("done");
					});
				});
				//$(".fileCancel").eq(-1).on("click",function(){	
				$("#fileCancel_"+ tmp_names[1]).on("click",function(){
                	$("#upload_" + tmp_names[1]).html("");
					$("#doc_" + tmp_names[1]).show();
             	});
		    },
	        progressall: function (e, data) {
			
				var tmp_names = $(this).attr('id').split('_');
				//var tmp_names = $(this).attr('id').split('-');
	            var progress = parseInt(data.loaded / data.total * 100, 10);
				//alert(progress);
				//console.log(progress);
	            $('#progress_'+tmp_names[1]+' .progress-bar').css(
	                'width',
	                progress + '%'
	            );
				$('#progress_'+tmp_names[1]+' .progress-percent').text(progress + '%');
	        }
	    });
	});
});