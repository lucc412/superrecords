
function printpage()
 {
  window.print();
 }

function validateFormOnSubmitReport()
{
  			// do field validation
                    statuscodeindex=document.worksheet_report.wrk_StatusList.selectedIndex;
		    mastercodeindex=document.worksheet_report.wrk_MasterActivityList.selectedIndex;
                    subactcodeindex=document.worksheet_report.wrk_SubActivityList.selectedIndex;
		    teamcodeindex=document.worksheet_report.wrk_TeamList.selectedIndex;
		    managercodeindex=document.worksheet_report.wrk_ManagerList.selectedIndex;
                    seniorcodeindex=document.worksheet_report.wrk_SeniorList.selectedIndex;
                    staffcodeindex=document.worksheet_report.wrk_StaffList.selectedIndex;
                    catindex=document.worksheet_report.cli_Category.selectedIndex;
  			 if(document.worksheet_report.wrk_FromDate.value == "" && document.worksheet_report.wrk_ToDate.value == "" && document.worksheet_report.wrk_ExdateFrom.value == "" && document.worksheet_report.wrk_ExdateTo.value == "" && document.worksheet_report.wrk_ClientName.value=="" && statuscodeindex==-1 && mastercodeindex==-1 && subactcodeindex==-1 && teamcodeindex==-1 && managercodeindex==-1 && seniorcodeindex==-1 && staffcodeindex==-1 && catindex=="") {
				alert( "Select at least one search criteria" );
  		    return(false);
			}
  			else if(document.worksheet_report.wrk_FromDate.value !="")
			{
			                var wrkfrmdate=document.worksheet_report.wrk_FromDate.value
 							if (isDate(wrkfrmdate)==false){
								document.worksheet_report.wrk_FromDate.focus()
								return (false)
							}
			}
			else if(document.worksheet_report.wrk_ToDate.value !="")
			{
			                var wrktodate=document.worksheet_report.wrk_ToDate.value
 							if (isDate(wrktodate)==false){
								document.worksheet_report.wrk_ToDate.focus()
								return (false)
							}
			}
  			else if(document.worksheet_report.wrk_ExdateFrom.value !="")
			{
			                var exfrmdate=document.worksheet_report.wrk_ExdateFrom.value
 							if (isDate(exfrmdate)==false){
								document.worksheet_report.wrk_ExdateFrom.focus()
								return (false)
							}
			}
			else if(document.worksheet_report.wrk_ExdateTo.value !="")
			{
			                var extodate=document.worksheet_report.wrk_ExdateTo.value
 							if (isDate(extodate)==false){
								document.worksheet_report.wrk_ExdateTo.focus()
								return (false)
							}
			}

 			else {
				document.worksheet_report.submit();
				return(true);
			}
}
