function validate_bas_details()
{
            // do field validation

			taskcodeindex=document.basdetail.bas_TaskCode_new.selectedIndex
            if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.basdetail.bas_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.basdetail.submit();
				return(true);
			}
}
function enableBas(obj,tVal,rol)
{
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=166; t++)
                    {
                        var hostTab=document.getElementById('basList_'+t);
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
      }
      else {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=166; t++)
                    {
                        var hostTab=document.getElementById('basList_'+t);
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

      }
}
