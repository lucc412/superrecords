function validate_bank_details()
{
             // do field validation

			taskcodeindex=document.bankdetail.ban_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.bankdetail.ban_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.bankdetail.submit();
				return(true);
			}
}
function enableBank(obj,tVal,rol)
{
  //  alert(tVal);
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+2;
              //  alert(taskVal);
                for(var t=taskVal; t<=280; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
                var taskVal1 = tVal+5;
                for(var t=taskVal1; t<=283; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
                var taskVal2 = tVal+8;
                for(var t=taskVal2; t<=286; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
                var taskVal = tVal+2;
                for(var t=taskVal; t<=280; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
                var taskVal1 = tVal+5;
                for(var t=taskVal1; t<=283; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
                var taskVal2 = tVal+8;
                for(var t=taskVal2; t<=286; t++)
                    {
                        var hostTab=document.getElementById('bankList_'+t);
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
