 function validate_ar_details()
{
             // do field validation

			taskcodeindex=document.ardetail.are_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.ardetail.are_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.ardetail.submit();
				return(true);
			}
}
function enableAR(obj,tVal,rol)
{
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=321; t++)
                    {
                        var hostTab=document.getElementById('arList_'+t);
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
        if(rolNum==7)
            {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('emailText_'+taskVal);
                        hostTab.style.display='block';
        }
        if(rolNum==15)
            {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('emailText_'+taskVal);
                        hostTab.style.display='block';
        }

      }
      else {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=321; t++)
                    {
                        var hostTab=document.getElementById('arList_'+t);
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
        if(rolNum==7)
            {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('emailText_'+taskVal);
                        hostTab.style.display='none';
                        document.getElementById('emailText_'+taskVal).value="";
        }
        if(rolNum==15)
            {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('emailText_'+taskVal);
                        hostTab.style.display='none';
                        document.getElementById('emailText_'+taskVal).value="";
        }

      }
}
