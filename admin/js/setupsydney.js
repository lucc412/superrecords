 function validate_setup_details()
{
             // do field validation

			taskcodeindex=document.setupdetail.set_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.setupdetail.set_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.setupdetail.submit();
				return(true);
			}
}
