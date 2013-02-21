 function validate_generalinfo_details()
{
             // do field validation

			taskcodeindex=document.generalinfodetail.gif_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.generalinfodetail.gif_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.generalinfodetail.submit();
				return(true);
			}
}
