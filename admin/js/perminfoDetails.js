 function validate_perminfo_details()
{
             // do field validation
			taskcodeindex=document.perminfodetail.inf_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.perminfodetail.inf_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.perminfodetail.submit();
				return(true);
			}
}
function enablePerm(obj,tVal,rol)
{
          //  alert(rol);
            var selObj = document.getElementById('onGoing');
            if (document.getElementById('onGoing').options[selObj.selectedIndex].text =="ongoing")
            {
                  var convertOn = document.getElementById('conOngoing');
                  convertOn.disabled=true;
            }
            if (document.getElementById('onGoing').options[selObj.selectedIndex].text =="One-off")
            {
                  var convertOn = document.getElementById('conOngoing');
                  convertOn.disabled=false;
            }

      if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==4)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';

        }
        if(rolNum==8)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=450; t++)
                    {
                        var hostTab=document.getElementById('permInfo_'+t);
                       // var hostText=document.getElementById('hostingText_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                        for (var l=0,thistextArea; thistextArea=CTextareaHosting[l]; l++) {
                        thistextArea.disabled=false;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                    }
        }
        if(rolNum==16)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';
                        var perm = tVal+3;
                        var hostTab=document.getElementById('permInfo_'+perm);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
        }

        if(rolNum==11)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='block';
        }

      }
      else {
         var rolNum = rol;
        if(rolNum==4)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        document.getElementById('oneVal_'+taskVal).value="";
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        document.getElementById('oneVal_'+taskVal).value="";
        }
        if(rolNum==8)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=450; t++)
                    {
                        var hostTab=document.getElementById('permInfo_'+t);
                       // var hostText=document.getElementById('hostingText_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                        for (var l=0,thistextArea; thistextArea=CTextareaHosting[l]; l++) {
                        thistextArea.disabled=true;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                    }
        }
        if(rolNum==16)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        document.getElementById('oneVal_'+taskVal).value="";
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        document.getElementById('oneVal_'+taskVal).value="";
                        var perm = tVal+3;
                        var hostTab=document.getElementById('permInfo_'+perm);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
        }
        if(rolNum==11)
            {
                        var taskVal = tVal+1;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        var taskVal = tVal+2;
                        var hostTab=document.getElementById('oneVal_'+taskVal).style.display='none';
                        document.getElementById('oneVal_'+taskVal).value="";
        }

      }
}
