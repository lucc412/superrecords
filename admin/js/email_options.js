function validateFormOnSubmit()
{
                        // do field validation
			if (document.emailoptions.email_shortname.value == "") {
				alert( "Enter email name" );
				document.emailoptions.email_shortname.focus();
				return(false);
			}
			else if (document.emailoptions.email_value.value == "") {
				alert( "Enter the email address" );
				document.emailoptions.email_value.focus();
				return(false);
			}

			else if (document.emailoptions.email_template.value == "") {
				alert( "Enter the email template" );
				document.emailoptions.email_template.focus();
				return(false);
			}
			/*if (document.emailoptions.email_value.value != "")
			{
				if (echeck(document.emailoptions.email_value.value)==false)
				{
					document.emailoptions.email_value.value="";
					document.emailoptions.email_value.focus();
					return false;
				}
			}*/
			else {
				document.emailoptions.submit();
				return(true);
			}
}
 function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "email_options.php";

   }else{

      return false;
   }
}
