function enableHost(obj,tVal,rol)
{
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+2;
                for(var t=taskVal; t<=252; t++)
                    {
                        var hostTab=document.getElementById('hostingTab_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                        for (var i=0,thistextArea; thistextArea=CTextareaHosting[i]; i++) {
                        thistextArea.disabled=false;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                    }
                var taskVal = tVal+138;
                for(var t=taskVal; t<=393; t++)
                    {
                        var hostTab=document.getElementById('hostingTab_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                        for (var i=0,thistextArea; thistextArea=CTextareaHosting[i]; i++) {
                        thistextArea.disabled=false;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=false;
                        }
                    }

            }
            if(rolNum==2)
                {
               /* var taskVal = tVal+1;
                        var hostTab=document.getElementById('myob_'+taskVal);
                        hostTab.style.display='block'; */
                var taskVal = tVal+135;
                for(var i=taskVal; i<=387; i++) {
                        var hostTab=document.getElementById('myob_'+i);
                        hostTab.style.display='block';
                }
                }
        /*    if(rolNum==4)
                {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('myobNotes_'+taskVal);
                        hostTab.style.display='block';
                } */
            if(rolNum==14)
                {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('myob_'+taskVal);
                        hostTab.style.display='block';
                }

     }
      else {
        var rolNum = rol;

        if(rolNum==0)
            {
                var taskVal = tVal+2;
                for(var t=taskVal; t<=252; t++)
                    {
                        var hostTab=document.getElementById('hostingTab_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                        for (var i=0,thistextArea; thistextArea=CTextareaHosting[i]; i++) {
                        thistextArea.disabled=true;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                    }
                var taskVal = tVal+138;
                for(var t=taskVal; t<=393; t++)
                    {
                        var hostTab=document.getElementById('hostingTab_'+t);
                        var CInputHosting=hostTab.getElementsByTagName('input');
                        var CTextareaHosting=hostTab.getElementsByTagName('TEXTAREA');
                        var CSelectHosting=hostTab.getElementsByTagName('select');
                        for (var i=0,thisInput; thisInput=CInputHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                        for (var i=0,thistextArea; thistextArea=CTextareaHosting[i]; i++) {
                        thistextArea.disabled=true;
                        }
                        for (var i=0,thisInput; thisInput=CSelectHosting[i]; i++) {
                        thisInput.disabled=true;
                        }
                    }

            }
            if(rolNum==2)
                {
                /* var taskVal = tVal+1;
                        var hostTab=document.getElementById('myob_'+taskVal);
                        hostTab.style.display='none';
                        document.getElementById('myob_'+taskVal).value=""; */
                var taskVal = tVal+135;
                for(var i=taskVal; i<=387; i++) {
                        var hostTab=document.getElementById('myob_'+i);
                        hostTab.style.display='none';
                        document.getElementById('myob_'+i).value="";
                }
                }
          /*  if(rolNum==4)
                {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('myobNotes_'+taskVal);
                        hostTab.style.display='none';
                        document.getElementById('myobNotes_'+taskVal).value="";
                } */
            if(rolNum==14)
                {
                var taskVal = tVal+1;
                        var hostTab=document.getElementById('myob_'+taskVal);
                        hostTab.style.display='none';
                        document.getElementById('myob_'+taskVal).value="";
                }
    }
}
