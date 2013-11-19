
function validation()
{
	var name = document.getElementById("Name");
	var email =document.getElementById("Email");
	var phone = document.getElementById("Telephone");
	var captcha = document.getElementById("ct_captcha");
	
	var flagReturn = true;
	
	if(name.value == "" || name.value == "Full Name *")
	{
		name.className = "errclass";
		flagReturn = false;
	}
	else if(name.value != "" || name.value != "Full Name *")
	{
		name.className = "";
	}
	
	if(email.value == '' || email.value == "Email *")
	{	
		email.className = "errclass";
		flagReturn = false;
		
	}else if(email.value != '' || email.value != "Email *"){
		flagReturn = email_validate(email);
	}
	
	
	if((phone.value == '') || (phone.value == "Telephone *"))
	{	
		phone.className = "errclass";
		flagReturn = false;
		
	}else if((phone.value != '') || (phone.value == "Telephone *")){
		
		if(isNaN(phone.value) == true)
		{
			phone.className = "errclass";
			flagReturn = false;
		}else{
			phone.className = "";
			
		}
		
	}
	
	if(captcha.value == "" || captcha.value == "Enter Code *")
	{
		captcha.className = "errclass";
		flagReturn = false;
	}
	else if(captcha.value != "" || captcha.value != "Enter Code *")
	{
		captcha.className = "";
	}
	
	return flagReturn;
} 

	function email_validate(element)
	{
		var x = element.value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			element.className = "errclass";
			element.value="";
			return false;
		}else{
			element.className = "";
		}
	}

function clearText(element)
{
	
	if(element.value == 'Full Name *')
		element.value = '';
		
	if(element.value == 'Email *')
		element.value = '';
		
	if(element.value == 'Telephone *')
		element.value = '';
		
	/*if(element.value = 'Comments *')
		element.value = '';*/
		
	if(element.value == 'Enter Code *')
		element.value = '';
							
	element.focus();
}


