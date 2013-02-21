function validate_ddr_details()
{
            // do field validation

			taskcodeindex=document.duedatedetail.ddr_TaskCode_new.selectedIndex
            if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.duedatedetail.ddr_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.duedatedetail.submit();
				return(true);
			}
}
