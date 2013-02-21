 function validateFormOnSubmit()
{
            if(enterkeycodeflag==1)
			{
			enterkeycodeflag=0;
			return (false);
			}
			else
			{
			// do field validation
			typecodeindex=document.contact.con_Type.selectedIndex
			//designationcodeindex=document.contact.con_Designation.selectedIndex
			//companycodeindex=document.contact.con_Company.selectedIndex

            /*if(typecodeindex==0)
			{
				alert( "Select Contact Type" );
				document.contact.con_Type.focus();
				return(false);
			}
			/*else if(designationcodeindex==0)
			{
				alert( "Select Designation" );
				document.contact.con_Designation.focus();
				return(false);
			}*/
 			if(document.contact.con_Firstname.value == "") {
 				alert( "Enter the First Name" );
				document.contact.con_Firstname.focus();
				return(false);
			}
			else if(document.contact.con_Lastname.value == "") {
				alert( "Enter the Last Name" );
				document.contact.con_Lastname.focus();
				return(false);
			}
                        /*
			else if(document.contact.con_Build.value == "") {
				alert( "Enter Unit/Build Number" );
				document.contact.con_Build.focus();
				return(false);
			}
                        */
			else if (document.contact.con_Email.value != "" )
			{
			var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i

				 if (filter.test(document.contact.con_Email.value)==false)
				  {
						alert("Please enter a valid email address.");
						  document.contact.con_Email.focus();
							var a = true; return false;
				  }
  			}


			else {
				document.contact.submit();
				return(true);
			}
			}
}
 function isNumberKey(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    //alert(charCode);
                    if(charCode==67 || charCode==86 || charCode==99 || charCode==118)
                        return true;
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                    return true;
                }

function ComfirmContact(acon,arec,acli){
   var rc=confirm("Are you sure you want to cancel?");
   if(rc==true){

      window.location = "cli_client.php?a="+acon+"&recid="+arec+"&cli_code="+acli+"&con=reset&process=contact";

   }else{

      return false;
   }
}
