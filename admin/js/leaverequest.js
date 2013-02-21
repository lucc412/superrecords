function validateFormOnSubmit()
{
			// do field validation
			staffcodeindex=document.leaverequest.lrf_StaffCode.selectedIndex
              if(staffcodeindex==0)
			{
				alert( "Select User Name" );
				document.leaverequest.lrf_StaffCode.focus();
				return(false);
			}
 			else if(document.leaverequest.lrf_From.value == "") {
				alert( "Enter From date" );
				document.leaverequest.lrf_From.focus();
				return(false);
			}
			else if(document.leaverequest.lrf_To.value == "") {
				alert( "Enter To date" );
				document.leaverequest.lrf_To.focus();
				return(false);
			}
 			else if(document.leaverequest.lrf_Reason.value == "") {
				alert( "Enter Reason" );
				document.leaverequest.lrf_Reason.focus();
				return(false);
			}
 			if ( document.leaverequest.lrf_From.value != "" )
			{
							var fr=document.leaverequest.lrf_From.value
 							if (isDate(fr)==false){
								document.leaverequest.lrf_From.focus()
								return (false)
							}
			}
			if( document.leaverequest.lrf_To.value != "" )
			{
							var to=document.leaverequest.lrf_To.value
 							if (isDate(to)==false){
								document.leaverequest.lrf_To.focus()
								return (false)
							}
			}
			else {
				document.leaverequest.submit();
				return(true);
			}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "lrf_leaverequestform.php";

   }else{

      return false;
   }
}
