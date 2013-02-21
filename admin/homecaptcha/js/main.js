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
    if(freequote.cnt_name.value=="")
        {
            document.getElementById('errname').style.display='inline'
            freequote.cnt_name.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errname').style.display='none'
    if(freequote.cmp_name.value=="")
        {
            document.getElementById('errcmpname').style.display='inline'
            freequote.cmp_name.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errcmpname').style.display='none'
    if(freequote.email.value=="")
        {
            document.getElementById('erremail').style.display='inline'
            freequote.email.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('erremail').style.display='none'
    if(freequote.email.value!="")    {
        if(filter.test(freequote.email.value)==false){
            document.getElementById('errcheck').style.display='inline';
            freequote.email.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errcheck').style.display='none'
    }
    if(freequote.phone.value=="")
        {
            document.getElementById('errphone').style.display='inline'
            freequote.phone.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errphone').style.display='none'
    if(freequote.states.value=="0")
        {
            document.getElementById('errstate').style.display='inline'
            freequote.states.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errstate').style.display='none'
    if(freequote.services.value=="0")
        {
            document.getElementById('errservice').style.display='block'
            freequote.services.focus();
            flag = 0;
            return false;
        }
        else document.getElementById('errservice').style.display='none'
        if(document.getElementById('services').selectedIndex=='4')
            {
            if(freequote.other.value=="")
                {
                    document.getElementById('errother').style.display='block'
                    freequote.other.focus();
                    flag = 0;
                    return false;
                }
                else document.getElementById('errother').style.display='none'
            }
            if(document.getElementById('captcha').value=="") {
                document.getElementById('errsecurity').style.display='inline'
                freequote.captcha.focus();
                flag = 0;
                return false;
            }
            else document.getElementById('errsecurity').style.display='none'
  /*  if (sInsCaptcha == sCookieCaptcha) {
        document.getElementById('errsecurity').style.display='none'
        
    } else {
        document.getElementById('errsecurity').style.display='inline'
        freequote.captcha.focus();
        return false;
    } */
    
}
