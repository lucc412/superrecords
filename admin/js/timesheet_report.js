function printpage()
 {
  window.print();
 }


function validateFormOnSubmit_filter()
{
 if(enterkeycodeflag==1)
			{
			enterkeycodeflag=0;
			return (false);
			}
			else
			{
  			// do field validation
 		    statuscodeindex=document.timesheet_report.tis_StatusList.selectedIndex;
		    mastercodeindex=document.timesheet_report.tis_MasterActivityList.selectedIndex;
		    subactcodeindex=document.timesheet_report.tis_SubActivityList.selectedIndex;
		    staffcodeindex=document.timesheet_report.tis_StaffList.selectedIndex;
    			if(document.timesheet_report.tis_FromDate.value == "" && document.timesheet_report.tis_ToDate.value == "" &&
			document.timesheet_report.tis_ClientName.value=="" && statuscodeindex==0 && mastercodeindex==-1 && staffcodeindex==-1 && subactcodeindex==-1)
			{
			alert( "Select at least one search criteria" );
  		    return(false);
			}
 			else if(document.timesheet_report.tis_FromDate.value !="")
			{
			                var tisfrmdate=document.timesheet_report.tis_FromDate.value
 							if (isDate(tisfrmdate)==false){
								document.timesheet_report.tis_FromDate.focus()
								return (false)
							}
			}
			else if(document.timesheet_report.tis_ToDate.value !="")
			{
			                var tistodate=document.timesheet_report.tis_ToDate.value
 							if (isDate(tistodate)==false){
								document.timesheet_report.tis_ToDate.focus()
								return (false)
							}
			}
 			else {
				document.timesheet_report.submit();
				return(true);
			}
			}
}
function selectAll(listName, selected) {
			var listBox = document.getElementById(listName);

			if(document.getElementById('SelectAll_Staff')!=null && document.getElementById('SelectAll_Staff').checked==true  || document.timesheet_report.SelectAll_MasterActivity.checked==true || document.timesheet_report.SelectAll_SubActivity.checked==true)
			{
			for(i=0; i<listBox.length; i++) {
				listBox.options[i].selected=selected;
			}
			}
			else
			{
			for(i=0; i<listBox.length; i++) {
				listBox.options[i].selected="";
			}
			}
 		}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "tis_timesheet_report.php";

   }else{

      return false;
   }
}
