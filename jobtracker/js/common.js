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