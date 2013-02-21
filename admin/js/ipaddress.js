function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){

      window.location.href = "stf_ipaddress.php";

   }else{

      return false;
   }
}
function Validateip()
{
     if(document.ipaddress.stf_IPowner.value==""){
        alert("Enter owner of the IP Address");
        document.ipaddress.stf_IPowner.focus();
        return false;
    }
    else if(document.ipaddress.stf_From_ip1.value==""){
        alert("Enter IP Address");
        document.ipaddress.stf_From_ip1.focus();
        return false;
    }
   else if(document.ipaddress.stf_From_ip1.value>255){
        alert("In Valid IP Address");
        document.ipaddress.stf_From_ip1.focus();
        return false;
    }

    else if(document.ipaddress.stf_From_ip2.value==""){
        alert("Enter IP Address");
        document.ipaddress.stf_From_ip2.focus();
        return false;
    }
   else if(document.ipaddress.stf_From_ip2.value>255){
        alert("In Valid IP Address");
        document.ipaddress.stf_From_ip2.focus();
        return false;
    }

    else if(document.ipaddress.stf_From_ip3.value==""){
        alert("Enter IP Address");
        document.ipaddress.stf_From_ip3.focus();
        return false;
    }
   else if(document.ipaddress.stf_From_ip3.value>255){
        alert("In Valid IP Address");
        document.ipaddress.stf_From_ip3.focus();
        return false;
    }

    else if(document.ipaddress.stf_From_ip4.value==""){
        alert("Enter IP Address");
        document.ipaddress.stf_From_ip4.focus();
        return false;
    }
   else if(document.ipaddress.stf_From_ip4.value>255){
        alert("In Valid IP Address");
        document.ipaddress.stf_From_ip4.focus();
        return false;
    }

if(document.getElementById('show_Range').style.display=='block')
    {
       if(document.ipaddress.stf_To_ip1.value==""){
            alert("Enter IP Address");
            document.ipaddress.stf_To_ip1.focus();
            return false;
        }
       else if(document.ipaddress.stf_To_ip1.value>255){
            alert("In Valid IP Address");
            document.ipaddress.stf_To_ip1.focus();
            return false;
        }

        else if(document.ipaddress.stf_To_ip2.value==""){
            alert("Enter IP Address");
            document.ipaddress.stf_To_ip2.focus();
            return false;
        }
       else if(document.ipaddress.stf_To_ip2.value>255){
            alert("In Valid IP Address");
            document.ipaddress.stf_To_ip2.focus();
            return false;
        }

        else if(document.ipaddress.stf_To_ip3.value==""){
            alert("Enter IP Address");
            document.ipaddress.stf_To_ip3.focus();
            return false;
        }
       else if(document.ipaddress.stf_To_ip3.value>255){
            alert("In Valid IP Address");
            document.ipaddress.stf_To_ip3.focus();
            return false;
        }

        else if(document.ipaddress.stf_To_ip4.value==""){
            alert("Enter IP Address");
            document.ipaddress.stf_To_ip4.focus();
            return false;
        }
       else if(document.ipaddress.stf_To_ip4.value>255){
            alert("In Valid IP Address");
            document.ipaddress.stf_To_ip4.focus();
            return false;
        }


    }
    else {
        return true;
    }
}
 function isNumberKey(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    if (charCode > 47 && charCode < 58)
                    return true;
                    return false;
                }
function SelectIP()
{
    document.getElementById('show_Range').style.display='block';
    document.getElementById('show_lable').style.display='block';
    document.getElementById('or_lable').style.display='none';


}
