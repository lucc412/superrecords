function printpage()
 {
  window.print();
 }
function selectAll(listName, selected) {
			var listBox = document.getElementById(listName);
			if(document.getElementById('SelectAll_Type').checked==true || document.getElementById('SelectAll_Stage').checked==true  || document.client_report.SelectAll_SalesPerson.checked==true || document.client_report.SelectAll_Status.checked==true )
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
 function validateFormOnSubmitReport()
{
   			// do field validation
			typeindex=document.client_report.cli_TypeList.selectedIndex;
                        stageindex=document.client_report.cli_StageList.selectedIndex;
                        salespersonindex=document.client_report.cli_SalespersonList.selectedIndex;
                        statusindex=document.client_report.cli_StatusList.selectedIndex;


     			 if(document.client_report.cli_DateFrom.value == "" && document.client_report.cli_DateTo.value == "" && document.client_report.cli_CompanyName.value == "" && document.client_report.cli_State.value == "" && typeindex==-1 && stageindex==-1 && salespersonindex==-1 && statusindex==-1  ) {
				alert( "Select at least one search criteria" );
  		    return(false);
			}

  			else if(document.client_report.cli_DateFrom.value !="")
			{
			                var clifrmdate=document.client_report.cli_DateFrom.value
 							if (isDate(clifrmdate)==false){
								document.client_report.cli_DateFrom.focus()
								return (false)
							}
			}
			else if(document.client_report.cli_DateTo.value !="")
			{
			                var clitodate=document.client_report.cli_DateTo.value
 							if (isDate(clitodate)==false){
								document.client_report.cli_DateTo.focus()
								return (false)
							}
			}
                      if(document.client_report.cli_DateFrom.value !="" && document.client_report.cli_DateTo.value !="")
                            {
                            if(document.client_report.cli_DateFrom.value > document.client_report.cli_DateTo.value)
                            {
                                alert("Invalid Date Received To value");
                                document.client_report.cli_DateTo.focus()
                                return(false)
                            }
                       }

 			else {
				document.client_report.submit();
				return(true);
			}
}
