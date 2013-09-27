// JavaScript Document

// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}


function performdelete(DestURL) {
var ok = confirm("Are you sure you want delete this record?");
if (ok) {location.href = DestURL;}
return ok;
} 
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}


function isDate(dtStr){
   var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strDay=dtStr.substring(0,pos1)
	var strMonth=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : dd/mm/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}

 function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
var enterkeycodeflag=0;
 document.onkeydown = checkKeycode
function checkKeycode(e) {
 var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
if(keycode == 13){
enterkeycodeflag=1;
}
}

function isDecimal(data)
{
	var sFullNumber = data;
    var ValidChars = "0123456789.";
    var Validn = "0123456789";
    var IsDotPres=false;
    var Char;
    Char = sFullNumber.charAt(0); 
    if (Validn.indexOf(Char) == -1) 
    {
        return false;
    }
    else
    {
        for (i = 0; i < sFullNumber.length; i++) 
        { 
            Char = sFullNumber.charAt(i); 
            if(Char == '.' ) 
            {
                if( IsDotPres == false)
                    IsDotPres = true;
                else
                {
                    return false;
                }
            }
            if (ValidChars.indexOf(Char) == -1) 
            {
                return false;
            }
        }
    }
   return true;
}//end Decimal value check.
function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
}

function selectPanel() {
	var selObj = document.getElementById('lstPractice');
	var item_id = selObj.value;

	if(item_id != '')
	{
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var strResponse = xmlhttp.responseText;

				if(strResponse) {
					var arrResponse = strResponse.split('~');

					document.getElementById("tdSrManager").innerHTML = arrResponse[0];
					if(document.getElementById("tdSalesPrson"))
						document.getElementById("tdSalesPrson").innerHTML = arrResponse[1];
					document.getElementById("tdInManager").innerHTML = arrResponse[2];
					document.getElementById("tdAuditMngr").innerHTML = arrResponse[3];
				}
			}
		}
		xmlhttp.open("GET","ajax_options.php?doAction=LoadPanel&itemId="+item_id,true);
		xmlhttp.send();
	}
}

function selectTeamMember() {
	var selObj = document.getElementById('lstClient');
	var item_id = selObj.value;

	if(item_id != '')
	{
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var strResponse = xmlhttp.responseText;

				if(strResponse) {
					var arrResponse = strResponse.split('~');

					document.getElementById("tdTeamMember").innerHTML = arrResponse[0];
					document.getElementById("tdSrAcntComp").innerHTML = arrResponse[1];
					document.getElementById("tdSrAcntAudit").innerHTML = arrResponse[2];
				}
			}
		}
		xmlhttp.open("GET","ajax_options.php?doAction=LoadTeamMember&itemId="+item_id,true);
		xmlhttp.send();
	}
}