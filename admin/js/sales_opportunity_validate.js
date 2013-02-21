// ~~~~~~~~~~~~~~~~~~~ multiservice ~~~~~~~~~~~~~~~~~~~~~~~~~~~
                $(function(){
			$(".multiservice").multiselect();
		});
		function multi_selection()
		{
			$(".multiservice").multiselect();
		}
// ~~~~~~~~~~~~~~~~~~~ multiservice end ~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ~~~~~~~~~~~~~~~~~~~ confirm cancel ~~~~~~~~~~~~~~~~~~~~~~~~~~~
                function ComfirmCancel(){
                    var r=confirm("Are you sure you want to cancel?");
                    if(r==true){
                        window.location = "cso_cross_sales_opportunity.php";
                   }else{
                      return false;
                    }
                }
// ~~~~~~~~~~~~~~~~~~~ confirm cancel end ~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ~~~~~~~~~~~~~~~~~~~ client add option ~~~~~~~~~~~~~~~~~~~~~~~~~~~
                function validateSales()
                {
                       csoStage=document.getElementById('cso_stage').selectedIndex
                       csoStatus=document.getElementById('cso_lead_status').selectedIndex
                       csoSource=document.getElementById('cso_source').selectedIndex
                       csoLead=document.getElementById('cso_generated_lead').selectedIndex
                       csoMoc=document.getElementById('cso_method_of_contact').selectedIndex
                       csoSales=document.getElementById('cso_sales_person').selectedIndex

                        if(document.getElementById('comp_name').value=="") {
                                alert( "Select valid client from the provided options." );
                                document.getElementById('comp_name').value="";
                                document.getElementById('comp_name').focus();
                                return(false);
                        }
                   //     csoEntity=document.getElementById('cso_entity').selectedIndex
		/*	if(csoEntity==0)
                            {
				alert( "Select group entity" );
				document.getElementById('cso_entity').focus();
				return(false);
                            } */
			else if(document.getElementById('cso_date_received').value == "") {
				alert( "Enter Date Received" );
				document.getElementById('cso_date_received').focus();
				return(false);
			}
			else if(document.getElementById('cso_service_required').value == "") {
				alert( "Select Service Required" );
				return(false);
			}
			else if(csoStage==0)
			{
				alert( "Select Stage" );
				document.getElementById('cso_stage').focus();
				return(false);
			}
			else if(csoStatus==0)
			{
				alert( "Select lead status" );
				document.getElementById('cso_lead_status').focus();
				return(false);
			}
			else if(csoSource==0)
			{
				alert( "Select Source" );
				document.getElementById('cso_source').focus();
				return(false);
			}
			else if(csoLead==0)
			{
				alert( "Select generated lead" );
				document.getElementById('cso_generated_lead').focus();
				return(false);
			}
			else if(csoMoc==0)
			{
				alert( "Select method of contact" );
				document.getElementById('cso_method_of_contact').focus();
				return(false);
			}
			else if(csoSales==0)
			{
				alert( "Select Sales staff" );
				document.getElementById('cso_sales_person').focus();
				return(false);
			}
			else {
				document.getElementById('action').click();
				return(true);
			}
                }
// ~~~~~~~~~~~~~~~~~~~ client add option end ~~~~~~~~~~~~~~~~~~~~~~~~~~~
// ~~~~~~~~~~~~~~~~~~~  alert confirm message ~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function ComfirmDelete(){
            var r=confirm("Are you sure you want to delete all selected Contacts?");
            if(r==true){
                document.cli_contact_edit.submit();
            }else{
                return false;
            }
       }
// ~~~~~~~~~~~~~~~~~~~  alert confirm message end ~~~~~~~~~~~~~~~~~~~~~~~~~~~

function showDay()
{
    var SelectDate = document.getElementById('cso_date_received').value;
    if(SelectDate!="")
        {
           // var d=new Date(SelectDate.substring(3,5)+","+Number(SelectDate.substring(0,2))+","+SelectDate.substring(5,10))
              var DayRec=SelectDate.split("/");
              var d=new Date(DayRec[2],(DayRec[1].replace(/^[0]+/g,""))-1,DayRec[0]);

            var Myday = d.getDay();
            var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
                      document.getElementById('cli_DayReceived').innerHTML=dayarray[Myday];
                      document.getElementById('cli_DayHide').value=dayarray[Myday];
        }
    document.getElementById( 'dayhide').style.display = 'none';
}
function gridSave()
{
    if(confirm("Save"))
        {
            document.getElementById('btnsubmit').click();
        }
        else {
           document.getElementById('btnreset').click();
        }
}
                function isNumberKey(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    if(charCode==67 || charCode==86 || charCode==99 || charCode==118)
                        return true;

                    if (charCode > 31 && (charCode < 32 || charCode > 57 ))
                    return false;
                    return true;
                }
                function alphanumeric_only(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    if((charCode >= 47 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))
                        return true;

                    else {
                    alert('Special Characters not allowed');
                    return false;
                    }
                 //   return true;
                }

function refresh()
{
    window.location='cso_cross_sales_opportunity.php';
}
function saveClick(page,id)
{
    if(page=="")
	{
		document.cso_sales.action="cso_cross_sales_opportunity.php?row_id="+id;
	}
	else {
		document.cso_sales.action="cso_cross_sales_opportunity.php"+page+"&row_id="+id;
	}
    document.cso_sales.submit();
    return false;
}
        function showContact(clicode,conid,entid)
        {
            //  alert(clicode);
              $(document).ready(function() {
                     $.ajax({
                        url: "sales_opportunity_ajax.php",
                        type:"POST",
                        cache: false,
                        async:false,
                        data:{code:clicode,con:conid,ent:entid,type:'cso'},
                        success: function(msg){
                            var msg_split = msg.split("~~");
                            //alert(msg_split[1]);
                            $("#cso_contact").html(msg_split[1]);
                          //  $("#cso_entity_type").html(msg_split[2]);
                            $('#add_contact').css('display','block');
                        }
                    });
              });
        }
        function performdelete(DestURL) {
            var ok = confirm("Are you sure you want delete this record?");
            if (ok) {location.href = DestURL;}
            return ok;
        } 
function saveConfirm(val)
{
    if(confirm("Have you saved all the changes made in this particular page? Click OK to continue or click CANCEL to SAVE and continue"))
        {
           window.location = "cso_cross_sales_opportunity.php?page="+val;
           return true;
        }
        else {
        return false;
        }
}
function contactForm() {
    var cCode = $('#cso_client_code').val();
        msgWindow=window.open( '', 'subwindow','toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,menubar=no,resizable=yes,height=600,width=500,top=200,left=300');
		msgWindow.focus();
		msgWindow.location = 'contact_form.php?cli_code='+cCode;
    
}