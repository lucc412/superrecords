// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var username = document.getElementById('txtName');
	var password = document.getElementById('txtPassword');

	if(username.value == "")
	{
		document.getElementById('val_username').innerHTML = "Please Provide User Name";
		document.getElementById('txtName').focus();
		username.className = "errclass";
		flagReturn = false;
	}
	else {
                document.getElementById('val_username').innerHTML = "";
		username.className = "";
	}
	
	
	if(password.value == "") 
	{
		document.getElementById('val_password').innerHTML = "Please Provide Password";
		document.getElementById('txtPassword').focus();
		password.className = "errclass";
		flagReturn = false;
	}
	else {
                document.getElementById('val_password').innerHTML = "";
		password.className = "";
	}
	
	return flagReturn;
}

function userValidation()
{
        var flagReturn = true;
	var username = document.getElementById('txtName');
	
	if(username.value == "")
	{
		document.getElementById('val_username').innerHTML = "Please Provide User Name";
		document.getElementById('txtName').focus();
		username.className = "errclass";
		flagReturn = false;
	}
	else {
                document.getElementById('val_username').innerHTML = "";
		username.className = "";
	}
        
        return flagReturn;
}
    
/*
function email()
{

var x=document.getElementById('txtName').value;

var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
   alert("Please Provide valid e-mail address");
  document.getElementById('txtName').value ="";
  document.objForm.txtName.focus();
  //alert("Please Provide valid e-mail address");
//  document.getElementById('txtName').value ="";
   return false;
   
  }
  var y,ylen;
	y = document.getElementById('txtPassword').value;
	ylen = y.length;
	
	if (x==null || x=="")
	{
	document.getElementById('txtName').focus();
	
	}
	else if( ylen  < 4 )
	{
		document.getElementById('txtPassword').value = "";
		alert('Please Provide Valid Password');
		//document.getElementById('txtPassword').focus();
		 document.objForm.txtPassword.focus();
	}
}

*/