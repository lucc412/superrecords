function popUp(url,height,width)
{
	popupWindow = window.open(
		url,'popUpWindow','height='+height+',width='+width+',left=200,top=20,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no,titlebar=no,dependent=yes,dialog=yes');
}

// This function is used to redirect page
function urlRedirect(url)
{
	window.location.href = url;
}

$(function(){
    $( "#lstClientTypeSearch" ).autocomplete(
    {
        source: function(request, response){
            $.getJSON('/jobtracker/ajax/jobs.php',{ name:$( "#lstClientTypeSearch" ).val(), doAction: 'search' },
            function(result) {

                if(result == '')
                    $( "#lstClientType" ).val('')

                response(
                    $.map(result, function(item) {
                        return item;
                    })
                );                    
           })

        },
        select: function( event, ui ) {
           $( "#lstClientType" ).val(ui.item ? ui.item.id : " " + this.value );
        }
    });
        
    $('INPUT[type="file"]').change(function (e) {
        //var ext = this.value.match(/\.(.+)$/)[1];
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        var ext = fileName.split('.').pop();
        ext = ext.toLowerCase();
        switch (ext) {
                case 'txt':
                case 'doc':
                case 'docx':
                case 'ppt':
                case 'pptx':
                case 'pdf':
                case 'xls':
                case 'xlsx':
                case 'zip':
                case 'rar':
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'msg':
                        break;
                default:
                        alert('Sorry, This file type is not allowed.');
                        this.value = '';
        }
		var file_list = e.target.files;
		for (var i = 0, file; file = file_list[i]; i++) {
		    var sFileName = file.name;
		    var sFileExtension = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();
		    var iFileSize = file.size;
		    var iConvert = (file.size / 1048576).toFixed(2);
			if(iConvert > 100) {
				alert('Sorry, Maximum 100MB file is allowed.');
				this.value = '';
				/*$("#uploads").html("");
				document.getElementById('fileUpload').value = "";
				filestoupload = 0;*/
			}
		}
    });
});

// function to change image of Asc / Desc
function changeSortImage(imgId)
{
	imgSrc = document.getElementById(imgId).src;
	val = imgSrc.split("/");

	//rootPath = document.location.hostname;	
	if(val[val.length-1]=='sort_asc.png')
	{
		document.getElementById(imgId).src = 'images/sort_desc.png';
		imgSrc = document.getElementById(imgId).src;
	}
	if(val[val.length-1]=='sort_desc.png')
	{
		document.getElementById(imgId).src = 'images/sort_asc.png';
		imgSrc = document.getElementById(imgId).src;
	}
}