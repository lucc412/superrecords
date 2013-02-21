function validate_backlog_details()
{
             // do field validation

			taskcodeindex=document.backlogdetail.blj_TaskCode_new.selectedIndex
             if(taskcodeindex==0)
			{
				alert( "Select Tasks" );
				document.backlogdetail.blj_TaskCode_new.focus();
				return(false);
			}
			else
			{
				document.backlogdetail.submit();
				return(true);
			}
}
function enableBacklog(obj,tVal,rol)
{
   // alert(rol);
    if(obj == true)
      {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=369; t++)
                    {
                        var hostTab=document.getElementById('backLog_'+t);
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

        var obj1 = document.getElementsByName("bjs_SourceDocument[]");
        for(var i=0;i<obj1.length;i++)
        {
          obj1[i].disabled = false;
        }
        var obj2 = document.getElementsByName("bjs_MethodofDelivery[]");
        for(var i=0;i<obj2.length;i++)
        {
          obj2[i].disabled = false;
        } 

        }
        if(rolNum==2)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=365; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='block';
                }
        }
        if(rolNum==5)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=368; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='block';
                }
        }
        if(rolNum==8)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=371; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='block';
                }
        }
        if(rolNum==11)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=374; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='block';
                }
        }
        if(rolNum==14)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=377; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='block';
                }
                var Oval = document.getElementById('relOther');
                Oval.style.display='block';

        }
        if(rolNum==19)
            {
                        var taskNote=document.getElementById('taskNote');
                        taskNote.style.display='block';
        }

      /*  var obj1 = document.getElementsByName("bjs_SourceDocument[]");
        for(var i=0;i<obj1.length;i++)
        {
          obj1[i].disabled = false;
        }
        var obj2 = document.getElementsByName("bjs_MethodofDelivery[]");
        for(var i=0;i<obj2.length;i++)
        {
          obj2[i].disabled = false;
        } */
      }
      else {
        var rolNum = rol;
        if(rolNum==0)
            {
                var taskVal = tVal+1;
                for(var t=taskVal; t<=369; t++)
                    {
                        var hostTab=document.getElementById('backLog_'+t);
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

        var obj1 = document.getElementsByName("bjs_SourceDocument[]");

        for(var i=0;i<obj1.length;i++)
        {
          obj1[i].disabled = true;
        }
        var obj2 = document.getElementsByName("bjs_MethodofDelivery[]");
        for(var i=0;i<obj2.length;i++)
        {
          obj2[i].disabled = true;
        }

        }
        if(rolNum==2)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=365; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='none';
                        document.getElementById('relevant_'+i).value="";
                }
        }
        if(rolNum==5)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=368; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='none';
                        document.getElementById('relevant_'+i).value="";
                }
        }
        if(rolNum==8)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=371; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='none';
                        document.getElementById('relevant_'+i).value="";
                }
        }
        if(rolNum==11)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=374; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='none';
                        document.getElementById('relevant_'+i).value="";
                }
        }
        if(rolNum==14)
            {
                var taskVal = tVal+1;
                for(var i=taskVal; i<=377; i++) {
                        var hostTab=document.getElementById('relevant_'+i);
                        hostTab.style.display='none';
                        document.getElementById('relevant_'+i).value="";
                }
                var Oval = document.getElementById('relOther');
                Oval.style.display='none';
                Oval.value="";
        }
        if(rolNum==19)
            {
                        var taskNote=document.getElementById('taskNote');
                        taskNote.style.display='none';
                        document.getElementById('taskNote').value="";
        }

      }
}
