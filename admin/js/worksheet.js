function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "wrk_worksheet.php";

   }else{

      return false;
   }
}

 function getSubActivityTasks(MasterActivityId,recid)
	{
                var strURL="dbclass/getsubactivities_class.php?mastercode="+MasterActivityId+"&recid="+recid+"&filename=worksheet";
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
                                                    document.getElementById('wrk_SubActivity').innerHTML=req.responseText;
                                                    document.getElementById('wrk_SubActivity_old').style.display='none';
						   }
 					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}
                if(MasterActivityId==15) {
                    document.getElementById('crmnotes').style.display='table-row';
                }
                else document.getElementById('crmnotes').style.display='none';

	}
function crmNotes() {
    document.getElementById('crmnotes').style.display='table-row';
}
function showContacts(clientcode)
{
    if(clientcode!="")
	{
            var strURL="dbclass/wrk_clientcontact_class.php?clientcode="+clientcode+"&filename=worksheet";
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
 					 document.getElementById('wrk_ClientContact').innerHTML=req.responseText;
					  document.getElementById('wrk_ClientContact_old').style.display='none';
					  checkKeycode(event);
 					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}
		}
}
var bydayAr = new Array();
var bymonthdayAr = new Array();
var bysetposAr = new Array();
var bydayLabels = new Array("SU","MO","TU","WE","TH","FR","SA");
var bydayTrans = new Array( "SU", "MO", "TU", "WE", "TH", "FR", "SA");

function timetype_handler () {
  if ( ! form.timetype )
   return true;
  var i = form.timetype.selectedIndex;
  var val = form.timetype.options[i].text;
  if ( i != 1 ) {
    // Untimed/All Day
    makeInvisible ( "timeentrystart" );
    if ( form.timezonenotice ) {
      makeInvisible ( "timezonenotice" );
    }
    if ( form.duration_h ) {
      makeInvisible ( "timeentryduration" );
    } else {
      makeInvisible ( "timeentryend" );
    }
     if ( form.rpttype ) {
      makeInvisible ( "rpt_until_time_date", true );
    }
  } else {
    // Timed Event
    makeVisible ( "timeentrystart" );
    if ( form.timezonenotice ) {
      makeVisible ( "timezonenotice" );
    }

    if ( form.duration_h ) {
      makeVisible ( "timeentryduration" );
    } else {
      makeVisible ( "timeentryend" );
    }
    if ( form.rpttype ) {
      makeVisible ( "rpt_until_time_date", true );
    }
  }
}

function rpttype_handler () {
  //Repeat Tab disabled
  form = document.worksheet;
  elements = document.worksheet.elements;
  elementlength = document.worksheet.elements.length;

  if ( ! form.rpttype ) {
    return;
  }
  var expert = ( document.getElementById('rptmode').checked);
  var i = form.rpttype.selectedIndex;
  var val = form.rpttype.options[i].text;
  //alert ( "val " + i + " = " + val );
  //i == 0 none
  //i == 1 daily
  //i == 2 weekly
  //i == 3,4,5 monthlyByDay, monthlyByDate, monthlyBySetPos
  //i == 6 yearly
  //i == 7 manual  Use only Exclusions/Inclusions
 //Turn all off initially

  makeInvisible ( "rpt_mode");

  makeInvisible ( "rptstartdate2", true );


  makeInvisible ( "rptenddate1", true );
  makeInvisible ( "rptenddate2", true );
  makeInvisible ( "rptenddate3", true );
  makeInvisible ( "rptfreq", true );
  makeInvisible ( "weekdays_only" );
  makeInvisible ( "rptwkst" );
  //makeInvisible ( "rptday", true );
  makeInvisible ( "rptbymonth", true );
  makeInvisible ( "rptbydayln", true );
  makeInvisible ( "rptbydayln1", true );
  makeInvisible ( "rptbydayln2", true );
  makeInvisible ( "rptbydayln3", true );
  makeInvisible ( "rptbydayln4", true );
  makeInvisible ( "rptbydayextended", true );
  makeInvisible ( "rptbymonthdayextended", true );
  makeInvisible ( "rptbysetpos", true );
  makeInvisible ( "rptbyweekno", true );
  makeInvisible ( "rptbyyearday", true );
  //makeInvisible ( "rptexceptions", true );
  //alert('in rpt i:'+i);
  //makeInvisible ( "select_exceptions_not", true );
  if ( i > 0 && i < 7 ) {
  // alert('in rpt i:'+i);
    //always on
    makeVisible ( "rptstartdate2", true );
    makeVisible ( "rptenddate1", true );
    makeVisible ( "rptenddate2", true );
    makeVisible ( "rptenddate3", true );
    makeVisible ( "rptfreq", true );
    //makeVisible ( "rptexceptions", true);
    makeVisible ( "rpt_mode" );

    if ( i == 1 ) { //daily
      makeVisible ( "weekdays_only" );
    }

    if ( i == 2 ) { //weekly
      makeVisible ( "rptbydayextended", true );
      if (expert ) {
        makeVisible ( "rptwkst" );
      }
    }
   if ( i == 3 ) { //monthly (by day)
     if (expert ) {
        makeVisible ( "rptwkst" );
        makeVisible ( "rptbydayln", true );
        makeVisible ( "rptbydayln1", true );
        makeVisible ( "rptbydayln2", true );
        makeVisible ( "rptbydayln3", true );
        makeVisible ( "rptbydayln4", true );
     }
   }

   if ( i == 4 ) { //monthly (by date)
     if (expert ) {
       makeVisible ( "rptbydayextended", true );
       makeVisible ( "rptbymonthdayextended", true );
     }
   }

   /* if ( i == 5 ) { //monthly (by position)
      makeVisible ( "rptbysetpos", true );
   } */

  if ( i == 5 ) {  //yearly
    if (expert ) {
        makeVisible ( "rptwkst" );
        makeVisible ( "rptbymonthdayextended", true );
        makeVisible ( "rptbydayln", true );
        makeVisible ( "rptbydayln1", true );
        makeVisible ( "rptbydayln2", true );
        makeVisible ( "rptbydayln3", true );
        makeVisible ( "rptbydayln4", true );
        makeVisible ( "rptbyweekno", true );
        makeVisible ( "rptbyyearday", true );
    }
  }
  if (expert ) {
    makeVisible ( "rptbydayextended", true );
    makeInvisible ( "weekdays_only" );
    makeVisible ( "rptbymonth", true );
  }
  }
//  if ( i == 7 ) {
//    makeVisible ( "rptexceptions", true);
//  }
}

function rpttype_weekly () {

form = document.worksheet;
  elements = document.worksheet.elements;
  elementlength = document.worksheet.elements.length;

  var i = form.rpttype.selectedIndex;
  var val = form.rpttype.options[i].text;
 if ( val == "Weekly" ) {
   //Get Event Date values
   var d = form.day.selectedIndex;
   var vald = form.day.options[d].value;
   var m = form.month.selectedIndex;
   var valm = form.month.options[m].value -1;
   var y = form.year.selectedIndex;
   var valy = form.year.options[y].value;
   var c = new Date(valy,valm,vald);
   var dayOfWeek = c.getDay ();
   var rpt_day = bydayLabels[dayOfWeek];
   elements[rpt_day].checked = true;
 }
}

var tabs = new Array ();
tabs[0] = "details";
tabs[1] = "participants";
tabs[2] = "pete";
tabs[3] = "reminder";

var sch_win;


function add_exception (which) {
 var sign = "-";
 if (which ) {
    sign = "+";
 }
 var d = form.except_day.selectedIndex;
 var vald = form.except_day.options[d].value;
 var m = form.except_month.selectedIndex;
 var valm = form.except_month.options[m].value;
 var y = form.except_year.selectedIndex;
 var valy = form.except_year.options[y].value;
 var c = new Date(valy,valm -1,vald);
 if ( c.getDate () != vald ) {
   alert ("Invalid Date");
   return false;
 }
 //alert ( c.getFullYear () + " "  + c.getMonth () + " " + c.getDate ());
 var exceptDate = String((c.getFullYear () * 100 + c.getMonth () +1) * 100 + c.getDate ());
 var isUnique = true;
 //Test to see if this date is already in the list
  with (form)
   {
      with (elements['exceptions[]'])
      {
         for (i = 0; i < length; i++)
         {
            if (options[i].text ==  "-" + exceptDate || options[i].text ==  "+" + exceptDate){
         isUnique = false;
         }
     }
   }
  }
 if ( isUnique ) {
    elements['exceptions[]'].options[elements['exceptions[]'].length]  = new Option( sign + exceptDate, sign + exceptDate );
    makeVisible ( "select_exceptions" );
    makeInvisible ( "select_exceptions_not" );
 }
}
function del_selected () {
   with (form)
   {
      with (elements['exceptions[]'])
      {
         for (i = 0; i < length; i++)
         {
            if (options[i].selected){
         options[i] = null;
         }
         } // end for loop
     if ( ! length ) {
       makeInvisible ( "select_exceptions" );
       makeVisible ( "select_exceptions_not" );
     }
     }
   } // end with document
}

function toggle_byday(ele){
  var bydaytext = bydayTrans[ele.id.substr(2,1)];
  var bydayVal = bydayLabels[ele.id.substr(2,1)];
  var tmp = '';
  if (ele.value.length > 4 ) {
    //blank
    ele.value = ele.id.substr(1,1) + bydaytext;
    tmp = ele.id.substr(1,1) + bydayVal;
  } else if (ele.value == ele.id.substr(1,1) + bydaytext) {
    //positive value
    ele.value =  (parseInt(ele.id.substr(1,1)) -6 ) + bydaytext;
    tmp = (parseInt(ele.id.substr(1,1)) -6 ) +  bydayVal;
  } else if (ele.value ==  (parseInt(ele.id.substr(1,1)) -6 ) +  bydaytext) {
    //negative value
  ele.value = "        ";
  tmp = '';
  }
  bydayAr[ele.id.substr(1)] = tmp;
}

function toggle_bymonthday(ele){
  var tmp = '';
  if (ele.value .length > 3) {
    //blank
  ele.value = tmp = ele.id.substr(10);
  } else if (ele.value == ele.id.substr(10)) {
    //positive value
  ele.value =  tmp = parseInt(ele.id.substr(10)) -32;
  } else if (ele.value ==  (parseInt(ele.id.substr(10)) -32 )) {
    //negative value
  ele.value = "     ";
  tmp = '';
  }
  bymonthdayAr[ele.id] = tmp;
}

function toggle_bysetpos(ele){
  var tmp = '';
  if (ele.value .length > 3) {
    //blank
  ele.value = tmp = ele.id.substr(8);

  } else if (ele.value == ele.id.substr(8)) {
    //positive value
  ele.value =  tmp = parseInt(ele.id.substr(8)) -32;
  } else if (ele.value ==  (parseInt(ele.id.substr(8)) -32 )) {
    //negative value
  ele.value = "    ";
  tmp = '';
  }
  bysetposAr[ele.id.substr(8)] = tmp;
}

function toggle_until () {
  //Repeat Tab disabled
  if ( ! form.rpttype ) {
    return;
  }
 //use date
 elements['rpt_day'].disabled =
  elements['rpt_month'].disabled =
  elements['rpt_year'].disabled =
  elements['rpt_btn'].disabled =
  elements['rpt_hour'].disabled =
  elements['rpt_minute'].disabled =
  ( form.rpt_untilu.checked != true );

 //use count
 elements['rpt_count'].disabled =
  ( form.rpt_untilc.checked != true );
 if ( elements['rpt_ampmA'] ) {
   if ( form.rpt_untilu.checked ) { //use until date
     document.getElementById('rpt_ampmA').disabled = false;
     document.getElementById('rpt_ampmP').disabled = false;
   } else {
     document.getElementById('rpt_ampmA').disabled = 'disabled';
     document.getElementById('rpt_ampmP').disabled = 'disabled';
   }
  }
}

function displayInValid(myvar)
{
  alert ( "You have not entered a valid time of day.");
  myvar.select ();
  myvar.focus ();
}

function isNumeric(sText)
{
   //allow blank values. these will become 0
   if ( sText.length == 0 )
     return sText;
   var validChars = "0123456789";
   var Char;
   for (i = 0; i < sText.length && sText != 99; i++)
   {
      Char = sText.charAt(i);
      if (validChars.indexOf(Char) == -1)
      {
        sText = 99;
      }
   }
   return sText;
}

function completed_handler () {
  if ( form.percent ) {
    elements['completed_day'].disabled =
      elements['completed_month'].disabled =
      elements['completed_year'].disabled =
      elements['completed_btn'].disabled =
      ( form.percent.selectedIndex != 10 || form.others_complete.value != 'yes' );
  }
}
function onLoad () {
//alert('in load');
  if ( ! document.worksheet )
	  return false;
  //define these variables here so they are valid
  form = document.worksheet;
  elements = document.worksheet.elements;
  elementlength = document.worksheet.elements.length;

  //initialize byxxxAr Objects
  if ( form.bydayList ) {
    bydayList = form.bydayList.value;
    if ( bydayList.search( /,/ ) > -1 ) {
      bydayList = bydayList.split ( ',' );
      for ( key in bydayList ) {
        if ( key == isNumeric ( key ) )
        bydayAr[bydayList[key]] = bydayList[key];
      }
    } else if ( bydayList.length > 0 ) {
      bydayAr[bydayList] = bydayList;
    }
  }

  if ( form.bymonthdayList ) {
    bymonthdayList = form.bymonthdayList.value;
    if ( bymonthdayList.search( /,/ ) > -1 ) {
      bymonthdayList = bymonthdayList.split ( ',' );
      for ( key in bymonthdayList ) {
        if ( key == isNumeric ( key ) )
          bymonthdayAr[bymonthdayList[key]] = bymonthdayList[key];
      }
    } else if ( bymonthdayList.length > 0 ) {
      bymonthdayAr[bymonthdayList] = bymonthdayList;
    }
  }

  if ( form.bysetposList ) {
    bysetposList = form.bysetposList.value;
    if ( bysetposList.search( /,/ ) > -1 ) {
      bysetposList = bysetposList.split ( ',' );
      for ( key in bysetposList ) {
        if ( key == isNumeric ( key ) )
          bysetposAr[bysetposList[key]] = bysetposList[key];
      }
    } else if ( bysetposList.length > 0 ){
      bysetposAr[bysetposList] = bysetposList;
    }
  }

  // detect browser
NS4 = (document.layers) ? 1 : 0;
IE4 = (document.all) ? 1 : 0;
// W3C stands for the W3C standard, implemented in Mozilla (and Netscape 6) and IE5
W3C = (document.getElementById) ? 1 : 0;
  timetype_handler ();
  rpttype_handler ();
  toggle_until ();
  //toggle_reminders ();
  //toggle_rem_rep ();
  completed_handler ();
  //alert('complete onload');
}
function makeVisible ( name, hide ) {
 //alert (name);
 var ele;
  if ( W3C ) {
    ele = document.getElementById(name);
  } else if ( NS4 ) {
    ele = document.layers[name];
  } else { // IE4
    ele = document.all[name];
  }

  if ( NS4 ) {
    ele.visibility = 'show';
  } else {  // IE4 & W3C & Mozilla
    ele.style.visibility = 'visible';
    if ( hide )
     ele.style.display = '';
  }
}

function makeInvisible ( name, hide ) {
  //alert (name);
  //alert(W3C);
  //alert(NS4);
 if (W3C) {
   //alert ("1:"+hide);
    document.getElementById(name).style.visibility = "hidden";
    if ( hide )
      document.getElementById(name).style.display = "none";
  } else if (NS4) {
  //alert ("2:"+hide);
    document.layers[name].visibility = "hide";
  } else {
  //alert ("3:"+hide);
    document.all[name].style.visibility = "hidden";
    if ( hide )
      document.all[name].style.display = "none";
  }
}

function showTab ( name ) {
  if ( ! document.getElementById )
    return true;

  var div, i, tab, tname;

  for ( i = 0; i < tabs.length; i++ ) {
    tname = tabs[i];
    tab = document.getElementById ( 'tab_' + tname);
    // We might call without parameter, if so display tabfor div.
    if ( tab && ! name ) {
      if ( tab.className == 'tabfor' )
        name = tname;
    } else if ( tab ) {
      tab.className = ( tname == name ? 'tabfor' : 'tabbak' );
    }
    div = document.getElementById ( 'tabscontent_' + tname );
    if ( div )
      div.style.display = ( tname == name ? 'block' : 'none' );
  }
  return false;
}

function visByClass(classname, state){
 var inc=0;
 var alltags=document.all? document.all : document.getElementsByTagName("*");
 for (i=0; i<alltags.length; i++){
 var str=alltags[i].className;
   if ( str && str.match(classname) )
     if ( state=='hide')
       alltags[i].style.display = "none";
     else
       alltags[i].style.display = "";
 }
}

function getScrollingPosition ()
{
 var position = [0, 0];

 if (typeof window.pageYOffset != 'undefined')
 {
   position = [
       window.pageXOffset,
       window.pageYOffset
   ];
 }

 else if (typeof document.documentElement.scrollTop
     != 'undefined' && document.documentElement.scrollTop > 0)
 {
   position = [
       document.documentElement.scrollLeft,
       document.documentElement.scrollTop
   ];
 }

 else if (typeof document.body.scrollTop != 'undefined')
 {
   position = [
       document.body.scrollLeft,
       document.body.scrollTop
   ];
 }

 return position;
}
//these common function is placed here because all the files that use it
//also use visibility functions
function selectDate ( day, month, year, current, evt, form ) {
  // get currently selected day/month/year
  monthobj = eval( 'document.' + form.id + '.' + month);
  curmonth = monthobj.options[monthobj.selectedIndex].value;
  yearobj = eval( 'document.' + form.id + '.' + year );
  curyear = yearobj.options[yearobj.selectedIndex].value;
  date = curyear;
  evt = evt? evt: window.event;
  var scrollingPosition = getScrollingPosition ();

  if (typeof evt.pageX != "undefined" &&
     typeof evt.x != "undefined")
 {
   mX = evt.pageX + 40;
   mY = self.screen.availHeight - evt.pageY;
 }
 else
 {
   mX = evt.clientX + scrollingPosition[0] + 40;
   mY = evt.clientY + scrollingPosition[1];
 }
//alert ( mX + ' ' + mY );
  var MyPosition = 'scrollbars=no,toolbar=no,screenx=' + mX + ',screeny=' + mY + ',left=' + mX + ',top=' + mY ;
  if ( curmonth < 10 )
    date += "0";
  date += curmonth;
  date += "01";
  url = "datesel.php?form=" + form.id + "&fday=" + day +
    "&fmonth=" + month + "&fyear=" + year + "&date=" + date;
  var colorWindow = window.open (url,"DateSelection","width=300,height=180,"  + MyPosition);
}

function selectColor ( color, evt ) {
  url = "colors.php?color=" + color;
  if (document.getElementById) {
    mX = evt.clientX   + 40;
  }
  else {
    mX = evt.pageX + 40;
  }
  var mY = 100;
  var MyOptions = 'width=390,height=365,scrollbars=0,left=' + mX + ',top=' + mY + ',screenx=' + mX + ',screeny=' + mY;
  var colorWindow = window.open (url,"ColorSelection","width=390,height=365," + MyOptions );
}
function updateColor ( input, target ) {
 // The cell to be updated
 var colorCell = document.getElementById(target);
 // The new color
 var color = input.value;

 if (!valid_color ( color ) ) {
   // Color specified is invalid; use black instead
  colorCell.style.backgroundColor = "#000000";
  input.select ();
  input.focus ();
  alert ( 'Invalid Color');
 } else {
  colorCell.style.backgroundColor = color;
 }
}

function toggle_datefields( name, ele ) {
  var enabled = document.getElementById(ele.id).checked;
  if ( enabled ) {
      makeInvisible ( name );
  } else {
      makeVisible ( name );
  }
}

function callEdit () {
  var features = 'width=600,height=500,resizable=yes,scrollbars=no';
  var url = "edit_entry.php";
  editwin = window.open ( url, "edit_entry", features );
}
function validateFormOnSubmit()
{
  	if(enterkeycodeflag==1)
			{
			enterkeycodeflag=0;
			return (false);
			}
			else
			{
    masteractivitycodeindex=document.worksheet.wrk_MasterActivity.selectedIndex
    prioritycodeindex=document.worksheet.wrk_Priority.selectedIndex
    statuscodeindex=document.worksheet.wrk_Status.selectedIndex
    staffinchargecodeindex=document.worksheet.wrk_StaffInCharge.selectedIndex
    if(masteractivitycodeindex==0)
    {
            alert( "Select Master Activity" );
            document.worksheet.wrk_MasterActivity.focus();
            return(false);
    }
    else if(prioritycodeindex==0)
    {
            alert( "Select Priority" );
            document.worksheet.wrk_Priority.focus();
            return(false);
    }
    else if(statuscodeindex==0)
    {
            alert( "Select Status" );
            document.worksheet.wrk_Status.focus();
            return(false);
    }
    else if(staffinchargecodeindex==0)
    {
            alert( "Select Staff In Charge" );
            document.worksheet.wrk_StaffInCharge.focus();
            return(false);
    }
    else if(document.worksheet.wrk_ClientCode.value=="" && document.worksheet.wrk_ClientCode_old.value=="") {
            alert( "Select valid client from the provided options." );
			document.worksheet.testinput.value="";
            document.worksheet.testinput.focus();
            return(false);
    }

    else if(document.worksheet.wrk_DueDate.value == "") {
            alert( "Enter External Due Date" );
            document.worksheet.wrk_DueDate.focus();
            return(false);
    }
    else if(document.worksheet.wrk_InternalDueDate.value == "") {
            alert( "Enter Super Records Due Date" );
            document.worksheet.wrk_InternalDueDate.focus();
            return(false);
    }

	else if(document.worksheet.wrk_Details.value == "") {
            alert( "Enter Last Reports Sent" );
            document.worksheet.wrk_Details.focus();
            return(false);
    }


    else if ( document.worksheet.rpt_untilu.checked==true && document.worksheet.rpt_type.value != 'none')
	{
    if(document.worksheet.rpt_day.value=="0" || document.worksheet.rpt_month.value=="0" || document.worksheet.rpt_year.value=="0"){
            alert("Please enter repeats end date");
            return(false);
 		}
    }
	   if ( document.worksheet.rpt_untilc.checked==true && document.worksheet.rpt_type.value != 'none')
	{
         if(document.worksheet.rpt_count.value==""){
            alert( "Please enter number of times to repeat" );
            return(false);
        }
     }
					else if(document.worksheet.wrk_HoursSpent.value!="")
				{
						if (isDecimal( document.worksheet.wrk_HoursSpent.value)==false)
						{
						document.worksheet.wrk_HoursSpent.value="";
						alert( "Invalid Entry" );
						document.worksheet.wrk_HoursSpent.focus();
						return(false);
						}
				}
    if ( document.worksheet.wrk_DueDate.value != "" )
    {
        var duedate=document.worksheet.wrk_DueDate.value
        if (isDate(duedate)==false){
                document.worksheet.wrk_DueDate.focus()
                return (false)
        }
    }
    if ( document.worksheet.wrk_InternalDueDate.value != "" )
    {
        var internalduedate=document.worksheet.wrk_InternalDueDate.value
        if (isDate(internalduedate)==false){
                document.worksheet.wrk_InternalDueDate.focus()
                return (false)
        }
    }
    else {
            //set byxxxList values for submission
             var bydayStr = '';
             for ( bydayKey in bydayAr ) {
               if ( bydayKey == isNumeric ( bydayKey ) )
                 bydayStr = bydayStr + ',' + bydayAr[bydayKey];
             }
             if ( bydayStr.length > 0 )
               elements['bydayList'].value = bydayStr.substr(1);
             //set bymonthday values for submission
             var bymonthdayStr = '';
             for ( bymonthdayKey in bymonthdayAr ) {
               if ( bymonthdayKey == isNumeric ( bymonthdayKey ) )
                 bymonthdayStr = bymonthdayStr + ',' + bymonthdayAr[bymonthdayKey];
             }
             if ( bymonthdayStr.length > 0 )
               elements['bymonthdayList'].value = bymonthdayStr.substr(1);

             //set bysetpos values for submission
             var bysetposStr = '';
             for ( bysetposKey in bysetposAr ) {alert(bysetposKey);
               if ( bysetposKey == isNumeric ( bysetposKey ) )
                 bysetposStr = bysetposStr + ',' + bysetposAr[bysetposKey];
             }
             if ( bysetposStr.length > 0 )
               elements['bysetposList'].value = bysetposStr.substr(1);

            document.worksheet.submit();
            return(true);
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
                    page3.style.display='none';
                    page1Tab.className = 'tabsel';
                    page2Tab.className = 'tab';
                    page3Tab.className = 'tab';
                    break;

        case 'page2':
                    page2.style.display='block';
                    page1.style.display='none';
                    page3.style.display='none';
                    page1Tab.className = 'tab';
                    page2Tab.className = 'tabsel';
                    page3Tab.className = 'tab';
                    break;

		 case 'page3':
			page1.style.display='none';
			page2.style.display='none';
			page3.style.display='block';
			page1Tab.className = 'tab';
			page2Tab.className = 'tab';
			page3Tab.className = 'tabsel';
			break;

		 case 'page4':
			page4.style.display='block';
			page5.style.display='none';
			page4Tab.className = 'tabsel';
			page5Tab.className = 'tab';
			break;

		 case 'page5':
			page4.style.display='none';
			page5.style.display='block';
			page4Tab.className = 'tab';
			page5Tab.className = 'tabsel';
			break;

    }
}

function ComfirmDelete(id,page_flag,pages){
   var r=confirm("Are you sure you want to delete all selected Worksheets?");
    var formObj = document.getElementById('wrkrowedit_'+id);
		
   if(r==true){
		formObj.action="wrk_worksheet.php?client="+id+"&page_records="+page_flag+"&page="+pages;
		//alert(formObj);
		formObj.submit();
		return false;
   }else{
      return false;
   }
}

checked = false;
function checkedAll () {
                if (checked == false){checked = true}else{checked = false}
                var chk=document.getElementsByTagName('input');
                for (var i=0,thisInput; thisInput=chk[i]; i++) {
                    if(thisInput.type=="checkbox")
                        thisInput.checked=checked;
                }
            }

function enable_divs(id,page_flag,page,filter,filterfield,wholeonly)
{
  var obj = document.getElementsByName("client_ids[]");
  
   		   if(window.XMLHttpRequest)
           {
            xmlhttp = new XMLHttpRequest();
           }
           else
           {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
           }
           xmlhttp.onreadystatechange = function()
           {
              if(xmlhttp.readyState == 4 )
              {
               
                  if(xmlhttp.responseText == "")
                  {
                 	document.getElementById("div_"+id).innerHTML = "No records found.";
                  }
                  else
                  {
                   document.getElementById("div_"+id).innerHTML = xmlhttp.responseText;
                 }
              }
           }
           xmlhttp.open("GET","ajax_worksheet.php?id="+id+"&pages="+page_flag+"&page="+page+"&filter="+filter+"&filterfield="+filterfield+"&wholeonly="+wholeonly,true);
           xmlhttp.send();
		   
  for(var i=0;i<obj.length;i++)
  {
    var val = obj[i].value;
    if(val == id)
    {
        document.getElementById("div_"+val).style.display = "inline";
        document.getElementById("img_"+val).src = "images/minus.gif";
    }
    else
    {
        document.getElementById("div_"+val).style.display = "none";
        document.getElementById("img_"+val).src = "images/plus.gif";
    }
  }
}
var win = null;
function inlineSave(code,addquery,clientcode,page_records,masid,mypage,myname,w,h,scroll)
{
     statusindex=document.getElementById("wrk_Status_"+code).value
	//var formObj = document.getElementById('wrkrowedit_'+code);
	 var formObj = document.getElementById('wrkrowedit_'+clientcode);
//	alert(formObj);
	if(masid==1 && statusindex==12)
	{
		var con = confirm('Do you want to copy this worksheet?');
		if(con==true)
		{
			LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
			TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
			settings =
			'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
			win = window.open(mypage,myname,settings)

			formObj.action="wrk_worksheet.php?workcode="+code+"&client="+clientcode+"&page_records="+page_records+"&"+addquery;
			formObj.submit();
		}
		else
		{
		formObj.action="wrk_worksheet.php?workcode="+code+"&client="+clientcode+"&page_records="+page_records+"&"+addquery;
		formObj.submit();
		}
	}
	else 
	{
		
		formObj.action="wrk_worksheet.php?workcode="+code+"&client="+clientcode+"&page_records="+page_records+"&"+addquery;
		//alert(formObj);
		formObj.submit();
		return false;
	   
	}
}
var win = null;
function copyWindow(mypage,myname,w,h,scroll)
{
 LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
