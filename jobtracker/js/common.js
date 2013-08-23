function popUp(url)
{
	popupWindow = window.open(
		url,'popUpWindow','height=550,width=750,left=200,top=20,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no,titlebar=no,dependent=yes,dialog=yes');
}

// This function is used to redirect page
function urlRedirect(url)
{
	window.location.href = url;
}

$(function(){
	$('INPUT[type="file"]').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];
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
	});
});