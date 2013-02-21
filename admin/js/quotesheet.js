 function validate_qinvoice_details_add()
{
            // do field validation
			taskcodeindex=document.qinvoicedetailadd.inv_TaskCode_new.selectedIndex
                        //invaddqty=document.qinvoicedetailadd.inv_Quantity_new.selectedIndex
  			 if(taskcodeindex==0)
			{
				alert( "Select Invoice Task" );
				document.qinvoicedetailadd.inv_TaskCode_new.focus();
				return(false);
			}
                        else
			{
		    document.qinvoicedetailadd.submit();
			return(true);
			}

}
function getNetamount()
{
    var qty = document.getElementsByName('inv_Quantity[]');
    var rate = document.getElementsByName('inv_Rates[]');
    var Netamount=document.getElementsByName('inv_Amount[]');

    for(var j = 0; j < Netamount.length; j++)
        {
           Netamount[j].value=qty[j].value*rate[j].value;
        }
}
function getAddAmount()
{
    var addqty = document.getElementById('inv_Quantity_new').value;
    var addrate = document.getElementById('inv_Rates_new').value;
    document.getElementById('inv_Amount_new').value = addqty * addrate;
}
function rateVal(obj,rate)
{
   if(obj == true)
    document.getElementById('inv_Rates_'+rate).disabled=false;
    else
    document.getElementById('inv_Rates_'+rate).disabled=true;
}
