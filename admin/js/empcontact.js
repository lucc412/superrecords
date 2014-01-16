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
			/*else if(document.contact.con_Build.value == "") {
				alert( "Enter Unit Number" );
				document.contact.con_Build.focus();
				return(false);
			}*/
			/*else if (document.contact.con_Email.value != "" )
			{*/
			var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i

				 if (filter.test(document.contact.con_Email.value)==false)
				  {
						alert("Please enter a valid email address.");
						  document.contact.con_Email.focus();
							var a = true; return false;
				  }
  			//}
			else {
				document.contact.submit();
				return(true);
			}
			}
}
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 32 || charCode > 57 ))
            return false;

         return true;
      }

function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "con_empcontact.php";

   }else{

      return false;
   }
}
