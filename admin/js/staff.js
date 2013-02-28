// This function is used to check unique login name by ajax
function checkUnique(eletxt,mode,updateValue)
{
	var that = document.getElementById("stf_Login");
	var searchVal = eletxt.value;

	
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
		  	var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response = xmlhttp.responseText;
				
				alert(response);
				
				if(response == 'success')
				{
					document.getElementById("enableText").innerHTML= 'Congratulations, You can proceed. This Login name is available.';
					document.getElementById("disableText").innerHTML= '';
					document.getElementById("btnSave").disabled = false;
					document.getElementById("btnUpdate").disabled = false;
				}
				else
				{
				document.getElementById("disableText").innerHTML= 'Sorry, You cannot proceed. This Login name is NOT available.';
					document.getElementById("enableText").innerHTML= '';
					document.getElementById("btnSave").disabled = true;
					document.getElementById("btnSave").className = 'disbtnclass';
					document.getElementById("btnUpdate").className = 'disbtnclass';
					document.getElementById("stf_Login").focus();
				}
		    }
		}
	
	if (searchVal == that.value)
	{	
		xmlhttp.open("GET","ajax_staff.php?inputValue="+searchVal+"&mode="+mode+"&updateValue="+updateValue,true);
		xmlhttp.send();
	}
}


function genUserPwd(contactname)
	{
		var strURL="includes/genuserpwd.php?contactname="+contactname;
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

                                        var string=req.responseText.split(",");
					document.getElementById( 'stf_Login').value=string[0];
					document.getElementById( 'stf_Password').value=string[1];
  					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}

	}

function showHideAccessSection(accessType) {
	if(accessType == 2) {
		document.getElementById('permissionSection').style.display = 'none';
	}
	else {
		document.getElementById('permissionSection').style.display = '';
	}
}
 function CheckAll_Row(rowid)
{
if(document.getElementById('Check_ctr_row['+rowid+"]").checked==true)
{
document.getElementById('stf_View['+rowid+"]").checked=true;
document.getElementById('stf_Add['+rowid+"]").checked=true;
document.getElementById('stf_Edit['+rowid+"]").checked=true;
document.getElementById('stf_Delete['+rowid+"]").checked=true;
}
else
{
document.getElementById('stf_View['+rowid+"]").checked=false;
document.getElementById('stf_Add['+rowid+"]").checked=false;
document.getElementById('stf_Edit['+rowid+"]").checked=false;
document.getElementById('stf_Delete['+rowid+"]").checked=false;
}
}

function CheckAll_View(chk)
{
var string=chk.split("|");
if(document.staff.Check_ctr_view.checked==true)
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_View['+string[i]+"]").checked=true;
}
}
else
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_View['+string[i]+"]").checked=false;
}
}
}
function CheckAll_Add(chk)
{
var string=chk.split("|");
if(document.staff.Check_ctr_add.checked==true)
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Add['+string[i]+"]").checked=true;
}
}
else
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Add['+string[i]+"]").checked=false;
}
}
}
function CheckAll_Edit(chk)
{
var string=chk.split("|");
if(document.staff.Check_ctr_edit.checked==true)
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Edit['+string[i]+"]").checked=true;
}
}
else
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Edit['+string[i]+"]").checked=false;
}
}
}
function CheckAll_Delete(chk)
{
var string=chk.split("|");
if(document.staff.Check_ctr_delete.checked==true)
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Delete['+string[i]+"]").checked=true;
}
}
else
{
for (i = 0; i < string.length; i++)
{
document.getElementById('stf_Delete['+string[i]+"]").checked=false;
}
}
}

function validateFormOnSubmit()
{
			// do field validation
			staffcontactcodeindex=document.staff.stf_CCode.selectedIndex
			accesstypencodeindex=document.staff.stf_AccessType.selectedIndex
             if(staffcontactcodeindex==0)
			{
				alert( "Select User Name" );
				document.staff.stf_CCode.focus();
				return(false);
			}
			else if(accesstypencodeindex==0)
			{
				alert( "Select Access Type" );
				document.staff.stf_AccessType.focus();
				return(false);
			}
			else if(document.staff.stf_Login.value == "") {
				alert( "Enter the Username" );
				document.staff.stf_Login.focus();
				return(false);
			}
			else if(document.staff.stf_Password.value == "") {
				alert( "Enter the Password" );
				document.staff.stf_Password.focus();
				return(false);
			}

			else {

                            if(document.getElementById("stf_Disabled").checked)
                                document.staff.chkDisabled.value = "Y";
                            else
                                document.staff.chkDisabled.value = "N";
                            if(document.getElementById("stf_Viewall").checked)
                                document.staff.chkViewall.value = "Y";
                            else
                                document.staff.chkViewall.value = "N";
                            if(document.getElementById("stf_Upload").checked)
                                document.staff.chkUpload.value = "Y";
                            else
                                document.staff.chkUpload.value = "N";
                            if(document.getElementById("stf_LoginStatus").checked)
                                document.staff.chkLoginStatus.value = "Y";
                            else
                                document.staff.chkLoginStatus.value = "N";

				document.staff.submit();
				return(true);
			}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "stf_staff.php";

   }else{

      return false;
   }
}
