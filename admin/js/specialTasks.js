function validate_spt_details()
{
            // do field validation

			taskcodeindex=document.sptdetail.spt_TaskCode_new.selectedIndex
            if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.sptdetail.spt_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.sptdetail.submit();
				return(true);
			}
}
function enableSplTask(obj,tVal,rol)
{
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
              /*  var taskVal = tVal+1;
                for(var t=taskVal; t<=191; t++)
                    {
                        var hostTab=document.getElementById('splTasks_'+t);
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
                    } */
            var spltxtval = document.getElementById('spt_txt');
            spltxtval.disabled=false;
        }
      }
      else {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
             /*   for(var t=taskVal; t<=191; t++)
                    {
                        var hostTab=document.getElementById('splTasks_'+t);
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
                    } */
            var spltxtval = document.getElementById('spt_txt');
            spltxtval.disabled=true;
            
        }
      }
}
