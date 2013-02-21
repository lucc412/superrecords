function getCookie(c_name) {
    if (document.cookie.length>0) {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1) {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function checkCaptcha() {
    // check captcha
    var sInsCaptcha = calcMD5($('.captcha').val());
    var sCookieCaptcha = getCookie('strSec');
    var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var flag = 1;
    if(enquiry.cmp_name.value=="")
        {
            document.getElementById('errname').style.display='inline'
            enquiry.cmp_name.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errname').style.display='none'
    if(enquiry.cnt_name.value=="")
        {
            document.getElementById('errcmpname').style.display='inline'
            enquiry.cnt_name.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errcmpname').style.display='none'
    if(enquiry.phone.value=="")
        {
            document.getElementById('errphone').style.display='inline'
            enquiry.phone.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errphone').style.display='none'

    if(enquiry.email.value=="")
        {
            document.getElementById('erremail').style.display='inline'
            enquiry.email.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('erremail').style.display='none'
    if(enquiry.email.value!="")    {
        if(filter.test(enquiry.email.value)==false){
            document.getElementById('errcheck').style.display='inline';
            enquiry.email.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errcheck').style.display='none'
    }
    if(enquiry.cnt_address.value=="")
        {
            document.getElementById('erraddress').style.display='inline'
            enquiry.cnt_address.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('erraddress').style.display='none'

    if(enquiry.states.value=="0")
        {
            document.getElementById('errstate').style.display='inline'
            enquiry.states.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errstate').style.display='none'
    if(enquiry.services.value=="0")
        {
            document.getElementById('errservice').style.display='inline'
            enquiry.services.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errservice').style.display='none'
        if(document.getElementById('services').selectedIndex=='4')
            {
            if(enquiry.other.value=="")
                {
                    document.getElementById('errother').style.display='inline'
                    enquiry.other.focus();
                    flag = 0;
                    return false;
                }
                else document.getElementById('errother').style.display='none'
            }
  /*  if (sInsCaptcha == sCookieCaptcha) {
        document.getElementById('errsecurity').style.display='none'
        
    } else {
        document.getElementById('errsecurity').style.display='inline'
        enquiry.captcha.focus();
        flag = 0;
        return false;
    } */
            if(document.getElementById('captcha1').value=="") {
                document.getElementById('errsecurity1').style.display='inline'
                enquiry.captcha1.focus();
                flag = 0;
                return false;
            }
            else document.getElementById('errsecurity1').style.display='none'
    
    if(flag==1) {
      //  mailSend();
    }
    
}
/* function mailSend() {
    parent.location.href = '../Submit-Mail.html';
} */
