 function getSubActivityTasks(MasterActivityId,recid)
	{
   		var strURL="dbclass/getsubactivities_class.php?mastercode="+MasterActivityId+"&recid="+recid+"&filename=cases";
    		var req = getXMLHTTP();
		if (req)
		 {
			req.onreadystatechange = function()
			{
				if (req.readyState == 4)
				{
					// only if "OK"
					if (req.status == 200)
					{

					       if(recid==-1)
						   {
  					       document.getElementById('cas_SubActivity').innerHTML=req.responseText;
  						   document.getElementById('cas_SubActivity_old').style.display='none';
						   }
 					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}

	}
        function showMember(clicode)
        {
            //  alert(clicode);
              $(document).ready(function() {
                     $.ajax({
                        url: "cases_ajax.php",
                        type:"POST",
                        cache: false,
                        async:false,
                        data:{code:clicode},
                        success: function(msg){
                            var msg_split = msg.split("~~");
                            //alert(msg_split[6]);
                            $("#cas_ClientContact").html(msg_split[0]);
                            document.getElementById('cas_AustraliaManager').value = msg_split[1];
                            document.getElementById('cas_ManagerInChrge').value = msg_split[2];
                            document.getElementById('cas_TeamInCharge').value = msg_split[3];
                            document.getElementById('cas_StaffInCharge').value = msg_split[4];
                            document.getElementById('cas_BillingPerson').value = msg_split[5];
                            document.getElementById('cas_SalesPerson').value = msg_split[6];
                            document.getElementById('cas_SeniorInCharge').value = msg_split[7];
                            document.getElementById('selectContact').style.display = 'none';
                        }
                    });
              });
        }
/*
function showContacts(clientcode)
{

    if(clientcode!="")
	{
        var strURL="dbclass/wrk_clientcontact_class.php?clientcode="+clientcode+"&filename=cases";

      		var req = getXMLHTTP();
		if (req)
		 {
			req.onreadystatechange = function()
			{
				if (req.readyState == 4)
				{
					// only if "OK"
					if (req.status == 200)
					{
 					 document.getElementById('cas_ClientContact').innerHTML=req.responseText;
					  document.getElementById('cas_ClientContact_old').style.display='none';
					  checkKeycode(event);
 					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}
		}
}

function switchTab(t)
{
    switch(t)
    {
        case 'page1':
                    page1.style.display='block';
                    page2.style.display='none';
                     page1Tab.className = 'tabsel';
                    page2Tab.className = 'tab';
                     break;

        case 'page2':
                    page2.style.display='block';
                    page1.style.display='none';
                     page1Tab.className = 'tab';
                    page2Tab.className = 'tabsel';
                     break;

     }
}
*/
function validateFormOnSubmit()
{
                        title = document.getElementById('cas_Title').value;
                        client = document.getElementById('testinput').value;
                        indDue = document.getElementById('cas_InternalDueDate').value;
                        extDue = document.getElementById('cas_ExternalDueDate').value;
                        issDet = document.getElementById('cas_IssueDetails').value;
                      //  bNotes = document.getElementById('cas_Notes').value;
                        res = document.getElementById('cas_Resolution').value;
                        issueocc = document.getElementById('cas_Issue_Occurred').value;
                       // tnotes = document.getElementById('cas_TeamInChargeNotes').value;
                        if(document.getElementById('cas_ClientNotes')) cCom = document.getElementById('cas_ClientNotes').value; else cCom = " ";
                        if(document.getElementById('cas_ClosedDate')) cDate = document.getElementById('cas_ClosedDate').value;
                        //if(document.getElementById('cas_ClosureReason')) cRes = document.getElementById('cas_ClosureReason').value;
                        //if(document.getElementById('cas_HoursSpentDecimal')) cHSD = document.getElementById('cas_HoursSpentDecimal').value;
                        selMas = document.getElementById('cas_MasterActivity');
                        if(document.cases.cas_SubActivity) selSub = document.cases.cas_SubActivity;
                        if(document.cases.cas_ClientContact) selCon = document.cases.cas_ClientContact;
                        castype = document.cases.cas_Type;
                        selPry = document.getElementById('cas_Priority');
                        selSts = document.getElementById('cas_Status');
                        selStaff = document.getElementById('cas_StaffInCharge');
                        selTeam = document.getElementById('cas_TeamInCharge');
                        selMan = document.getElementById('cas_ManagerInChrge');
                        selSenior = document.getElementById('cas_SeniorInCharge');
                        selAus = document.getElementById('cas_AustraliaManager');
                        selBill = document.getElementById('cas_BillingPerson');
                        selSales = document.getElementById('cas_SalesPerson');
                        selHour = document.getElementById('hour');
                        selMin = document.getElementById('minute');
                        selSec = document.getElementById('second');
                        mas = document.getElementById('cas_MasterActivity').options[selMas.selectedIndex].text;
                        ctype = document.getElementById('cas_Type').options[castype.selectedIndex].text;
                        if(document.getElementById('cas_SubActivity').style.display=='block') sub = document.cases.cas_SubActivity.options[selSub.selectedIndex].text; else sub = "";
                        if(document.getElementById('cas_ClientContact').style.display=='block') cascon = document.cases.cas_ClientContact.options[selCon.selectedIndex].text; else cascon = "";
                        pry = document.getElementById('cas_Priority').options[selPry.selectedIndex].text;
                        sts = document.getElementById('cas_Status').options[selSts.selectedIndex].text;
                        stff = document.getElementById('cas_StaffInCharge').options[selStaff.selectedIndex].text;
                        team = document.getElementById('cas_TeamInCharge').options[selTeam.selectedIndex].text;
                        man = document.getElementById('cas_ManagerInChrge').options[selMan.selectedIndex].text;
                        senior = document.getElementById('cas_SeniorInCharge').options[selSenior.selectedIndex].text;
                        aus = document.getElementById('cas_AustraliaManager').options[selAus.selectedIndex].text;
                        bill = document.getElementById('cas_BillingPerson').options[selBill.selectedIndex].text;
                        spers = document.getElementById('cas_SalesPerson').options[selSales.selectedIndex].text;
                        hour = document.getElementById('hour').options[selHour.selectedIndex].text;
                        min = document.getElementById('minute').options[selMin.selectedIndex].text;
                        sec = document.getElementById('second').options[selSec.selectedIndex].text;
                        historyContent = "Type : "+ctype+"~Subject : "+title+"~Client : "+client+"~Contact : "+cascon+"~Master Activity : "+mas+"~Sub Activity : "+sub+"~Priority : "+pry+"~Status : "+sts+"~Billing Person : "+bill+"~Australia Manager : "+aus+"~Staff In Charge : "+stff+"~Team In Charge : "+team+"~Manager In Charge : "+man+"~Senior In Charge : "+senior+"~Sales Person : "+spers+"~Internal Due Date : "+indDue+"~External Due Date : "+extDue+"~Due Time : "+hour+":"+min+":"+sec+"~Issue Details : "+issDet+"~Explain why this has occurred : "+issueocc+"~Resolution : "+res+"~Client Comments : "+cCom+"~Completion Date : "+cDate;
                        document.getElementById('hisContent').value = historyContent;

                        // validate
                        if(enterkeycodeflag==1)
			{
			enterkeycodeflag=0;
			return (false);
			}
			else
			{
			// do field validation
 			masteractivitycodeindex=document.cases.cas_MasterActivity.selectedIndex
			prioritycodeindex=document.cases.cas_Priority.selectedIndex
			statuscodeindex=document.cases.cas_Status.selectedIndex
			teamcodeindex=document.cases.cas_TeamInCharge.selectedIndex
                        auscodeindex=document.cases.cas_AustraliaManager.selectedIndex
                        statusvalueindex=document.getElementById('cas_Status');
                        flag = 1;
                        if(cases.cas_Type.value=="0") {
                            alert('Select Type')
                            document.cases.cas_Type.focus();
                            flag=0;
                            return(false);
                        }
			 if(auscodeindex==0)
			{
				alert( "Select Australia Manager" );
				document.cases.cas_AustraliaManager.focus();
                                flag=0;
				return(false);
			}
			 if(teamcodeindex==0)
			{
				alert( "Select Team In Charge" );
				document.cases.cas_TeamInCharge.focus();
                                flag=0;
				return(false);
			}
			 if(masteractivitycodeindex==0)
			{
				alert( "Select Master Activity" );
				document.cases.cas_MasterActivity.focus();
                                flag=0;
				return(false);
			}
			 if(prioritycodeindex==0)
			{
				alert( "Select Priority" );
				document.cases.cas_Priority.focus();
                                flag=0;
				return(false);
			}
			 if(statuscodeindex==0)
			{
				alert( "Select Status" );
				document.cases.cas_Status.focus();
                                flag=0;
				return(false);
			}
			/* if(staffinchargecodeindex==0)
			{
				alert( "Select Staff In Charge" );
				document.cases.cas_StaffInCharge.focus();
				return(false);
			} */
                        if(document.cases.cas_ClientName.value=="") {
                                alert( "Select valid client from the provided options." );
                                document.cases.testinput.value="";
                                document.cases.testinput.focus();
                                flag=0;
                                return(false);
                        }
                        if(document.cases.cas_ClientName.value!=""){
                                  //   if(document.getElementById('cas_ClientCode').value){
                                   //     var codeval = document.getElementById('cas_ClientCode').value;
                                   //  }
                                   //  else { var codeval = document.getElementById('cas_ClientCode_old').value; }
                                     $(document).ready(function() {
                                             $.ajax({
                                                url: "cases_company_ajax.php",
                                                type:"POST",
                                                cache: false,
                                                async:false,
                                                data:{name:document.getElementById('testinput').value},
                                                success: function(msg){
                                                   document.getElementById('compcode').value = msg;
                                                }
                                            });
                                      });
                        }
                      /*  if(document.getElementById('compcode').value==""){
                            alert('company name did not match existing clients');
                            document.cases.testinput.focus();
                            flag=0;
                            return(false);
                        } */
 			if(document.cases.cas_InternalDueDate.value == "") {
				alert( "Enter Super Records Due Date" );
				document.cases.cas_InternalDueDate.focus();
                                flag=0;
				return(false);
			}
			 if ( document.cases.cas_InternalDueDate.value != "" )
			{
 			                var induedate=document.cases.cas_InternalDueDate.value
 							if (isDate(induedate)==false){
								document.cases.cas_InternalDueDate.focus()
                                                                flag=0;
								return (false)
							}
			}

                        if(document.cases.cas_ExternalDueDate.value == "") {
				alert( "Enter External Due Date" );
				document.cases.cas_ExternalDueDate.focus();
                                flag=0;
				return(false);
			}
			 if ( document.cases.cas_ExternalDueDate.value != "" )
			{
 			                var duedate=document.cases.cas_ExternalDueDate.value
 							if (isDate(duedate)==false){
								document.cases.cas_ExternalDueDate.focus()
                                                                flag=0;
								return (false)
							}
			}
                        if(document.cases.cas_ExternalDueDate.value == "") {
				alert( "Enter External Due Date" );
				document.cases.cas_ExternalDueDate.focus();
                                flag=0;
				return(false);
			}
                        if(document.cases.cas_IssueDetails.value == "") {
				alert( "Enter Issue Details" );
				document.cases.cas_IssueDetails.focus();
                                flag=0;
				return(false);
			}
                   if(sts=='Completed') {     
                        if(ctype=='Issue' || ctype=='Internal') {
                        if(document.cases.cas_Issue_Occurred.value == "") {
				alert( "Enter Explain why this has occurred" );
				document.cases.cas_Issue_Occurred.focus();
                                flag=0;
				return(false);
			}
                       }
                   }
                        if(document.getElementById('cas_Status').options[statusvalueindex.selectedIndex].text == "Completed")
                            {
                                if(document.getElementById('cas_ClosedDate').value=="") {
                                alert('Enter Completion Date');
                                document.getElementById('cas_ClosedDate').focus();
                                flag=0;
                                return false;
                                }
                            }
                   if(sts=='Completed') {     
                        var staffrow = document.getElementsByName('cas_Staff[]');
                        var detailrow = document.getElementsByName('cas_ActionDetails[]');
                        var actflag=0;
                        for(var j=0;j<detailrow.length;j++) {
                            if(detailrow[j].value!="") { actflag=1; break;}
                        }
                        if(actflag==0) {
                            alert('Enter any one Action details');
                            document.getElementById('cas_ActionDetails').focus();
                            flag=0;
                            return false;
                        }
                        else {
                            for(var j=0;j<detailrow.length;j++) {
                                if(detailrow[j].value!="" && staffrow[j].value=="0") { alert('Select Staff'); staffrow[j].focus(); flag=0; return false; }
                                else if(detailrow[j].value=="" && staffrow[j].value!="0") { alert('Enter Action details'); detailrow[j].focus(); flag=0; return false; }
                            }
                        }
                   }    
                        if(document.getElementById('add_ticket')) { if(flag=="1") {document.getElementById('add_ticket').disabled=true;} }
  			//else {
				document.cases.submit();
				return(true);
			//}
			}
}
function statusComplete(code,type,issuer,sid)
{
                        statuscodeindex=document.getElementById('cas_Status');
                        if(document.getElementById('cas_Status').options[statuscodeindex.selectedIndex].text == "Completed")
                            {
                                if(type=='Staff' && code!=issuer) {
                                    alert('Permission not allowed. You are can not Change the Staus for Completed.');
                                    document.getElementById('cas_Status').value=sid;
                                }
                                document.getElementById('closeDatestyle').style.display='inline';
                                document.getElementById('action_field').style.display='inline';
                                document.getElementById('explain_field').style.display='inline';
                            }
                            else {
                                document.getElementById('closeDatestyle').style.display='none';
                                document.getElementById('action_field').style.display='none';
                                document.getElementById('explain_field').style.display='none';
                            }
}
function checkHours()
{
if(document.cases.cas_HoursSpentDecimal.value!="")
				{
						if (isDecimal( document.cases.cas_HoursSpentDecimal.value)==false)
						{
						document.cases.cas_HoursSpentDecimal.value="";
						document.cases.cas_HoursSpentDecimal.focus();
						alert( "Invalid Entry" );
						return(false);
						}
				}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "cas_cases.php?a=reset";

   }else{

      return false;
   }
}
