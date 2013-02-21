function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "tis_timesheet.php";

   }else{

      return false;
   }
}
function getSubActivityTasks(MasterActivityId,recid)
	{

   		var strURL="dbclass/getsubactivities_class.php?mastercode="+MasterActivityId+"&recid="+recid+"&filename=timesheet";
 		var req = getXMLHTTP();

		/*if(stateId=="Others")
		{
		showtextbox();
		}*/
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
                                                        var i=0;
                                                        var subActivities=req.responseText.split('~');

                                                         for(var j=0;j<=subActivities.length;j++)
                                                         {
                                                             var splitSub=subActivities[j].split('|');

                                                             if(splitSub.length>1){
                                                             document.getElementById('tis_SubActivity_new').options[i]=new Option(splitSub[1], splitSub[0], false, false);
                                                             i=i+1;
                                                            }
                                                         }
                                                        //document.getElementById('tis_SubActivity_new').innerHTML =req.responseText;

						   }
						   else
						   {

                                                   var selLength=document.getElementById('tis_SubActivity_ini'+recid).length;
                                                   while(selLength>0){
                                                    document.getElementById('tis_SubActivity_ini'+recid).options[--selLength] = null;
                                                   }

                                                    var i=0;
                                                        var subActivities=req.responseText.split('~');

                                                         for(var j=0;j<=subActivities.length;j++)
                                                         {
                                                             var splitSub=subActivities[j].split('|');

                                                             if(splitSub.length>1){
                                                             document.getElementById('tis_SubActivity_ini'+recid).options[i]=new Option(splitSub[1], splitSub[0], false, false);
                                                             i=i+1;
                                                            }
                                                         }
						   }
 					}
				}
			}

			req.open("GET", strURL, true);
			req.send(null);
		}

	}
function validateFormOnSubmit_edit()
{
            // do field validation
			var cli = document.getElementsByName('tis_ClientCode[]');
			var units = document.getElementsByName('tis_Units[]');
			//var netunits = document.getElementsByName('tis_NetUnits[]');

 			for(var i = 0; i < cli.length; i++)
            {
				if(cli[i].value==0)
				{
				alert("Select Client");
				cli[i].focus();
				return(false);
				}
			}
			for(var i = 0; i < units.length; i++)
            {
			if(units[i].value!="")
			{
			 if (isDecimal(units[i].value)==false)
				{
				units[i].value="";
				alert( "Invalid Entry" );
				units[i].focus();
				return (false);
				}
			}
			}
			document.timesheet_edit.submit();
			return(true);

}


function validateFormOnSubmit_new()
{
  			// do field validation
			clientcodeindex=document.timesheet_new.tis_ClientCode_new.selectedIndex
 			masactivitycodeindex=document.timesheet_new.tis_MasterActivity_new.selectedIndex
			if(clientcodeindex==0)
			{
				alert( "Select Client" );
				document.timesheet_new.tis_ClientCode_new.focus();
				return(false);
			}
			else if(masactivitycodeindex==0)
			{
				alert( "Select Master Activity" );
				document.timesheet_new.tis_MasterActivity_new.focus();
				return(false);
			}
			else if(document.timesheet_new.tis_Units_new.value == "") {
				alert( "Enter Units" );
				document.timesheet_new.tis_Units_new.focus();
				return(false);
			}
			if(document.timesheet_new.tis_Units_new.value != "") {
				if (isDecimal(document.timesheet_new.tis_Units_new.value)==false)
					{
					 document.timesheet_new.tis_Units_new.value="";
					alert( "Invalid Entry" );
					document.timesheet_new.tis_Units_new.focus();
					return(false);
					}
			}
			if(document.timesheet_new.tis_NetUnits_new.value != "")
			{
				if (isDecimal( document.timesheet_new.tis_NetUnits_new.value)==false)
					{
					document.timesheet_new.tis_NetUnits_new.value="";
					alert( "Invalid Entry" );
					document.timesheet_new.tis_NetUnits_new.focus();
					return(false);
					}
			}
 			else {
				document.timesheet_new.submit();
				return(true);
			}
}
function showTextArea(tempvalue)
{
var string=tempvalue.split("|");
document.getElementById( 'tis_Details_TextArea').style.display='block';
document.getElementById( 'tis_Details_new_select').style.display='none';
if(tempvalue==0)
{
document.getElementById( 'tis_Details_new').value="";
}
else
{
document.getElementById( 'tis_Details_new').value=string[1];
}
}
function showValueinTextarea(tempvalue,recid)
{
var string=tempvalue.split("|");
var tis = document.getElementsByName('tis_Details[]');
for(var i = 0; i < tis.length; i++)
            {
				tis[recid].value=string[1];
			}
}

function validateFormOnSubmit()
{
  			// do field validation
 			athourcodeindex=document.timesheet.at_hour.selectedIndex
			atminutecodeindex=document.timesheet.at_minute.selectedIndex
			atsecondcodeindex=document.timesheet.at_second.selectedIndex
			dthourcodeindex=document.timesheet.dt_hour.selectedIndex
			dtminutecodeindex=document.timesheet.dt_minute.selectedIndex
			dtsecondcodeindex=document.timesheet.dt_second.selectedIndex
			statuscodeindex=document.timesheet.tis_Status.selectedIndex
 			if(athourcodeindex==0)
			{
				alert( "Select Hour" );
				document.timesheet.at_hour.focus();
				return(false);
			}
			else if(atminutecodeindex==0)
			{
				alert( "Select Minute" );
				document.timesheet.at_minute.focus();
				return(false);
			}

			else if(dthourcodeindex==0)
			{
				alert( "Select Hour" );
				document.timesheet.dt_hour.focus();
				return(false);
			}
			else if(dtminutecodeindex==0)
			{
				alert( "Select Minute" );
				document.timesheet.dt_minute.focus();
				return(false);
			}

			else if(statuscodeindex==0)
			{
				alert( "Select Status" );
				document.timesheet.tis_Status.focus();
				return(false);
			}
 			else if(document.timesheet.tis_Date.value == "") {
				alert( "Enter Date" );
				document.timesheet.tis_Date.focus();
				return(false);
			}
 			else if(document.timesheet.tis_Date.value !="")
			{
			                var tisdate=document.timesheet.tis_Date.value
 							if (isDate(tisdate)==false){
								document.timesheet.tis_Date.focus()
								return (false)
							}
			}
 			else {
				document.timesheet.submit();
				return(true);
			}
}
