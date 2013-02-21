<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMSF SERVICES</title>
<style type="text/css">
<!--
body {
	background-image: url(images/bg.jpg);
	background-repeat: repeat-x;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #eef0f3;
}
#border-box
{
width:900px;
background:#f3f4f6;
margin:50px auto;
padding:10px 0px 10px 10px;
}
#container
{
width:895px;
background:#FFFFFF;
padding:10px;
}
.title
{
background:url(images/title.png) no-repeat;
width:427px;
height:112px;
float:right;
position:relative;
top:-33px;
right:45px;
font-family: "Century Gothic";
font-size:22px;
font-weight:bold;
color:#f8ac08;
text-align:center;
padding-top:25px;
}
.logo
{
margin-left:40px;
}
.request-quote
{
background:url(images/request-quote.jpg) no-repeat;
width:68px;
height:301px;
position:relative;
margin-left:-17px;
}
#form
{
width:100%;
background:#FFFFFF;
margin:20px auto;
font-family: Arial, Helvetica, sans-serif;
font-size:14px;
color:#000000;
}
.points ul
{
width:100%;
}
.points li
{
background:url(images/tick.jpg) 0px 3px;
background-repeat:no-repeat;
list-style:none;
font-family: Arial, Helvetica, sans-serif;
font-size:14px;
color:#000000;
padding-left:30px;
line-height:22px;
margin-left:-25px;
padding-bottom:25px;
}
.orangetext
{
color:#FF9900;
font-size:14px;
font-weight:bold;
}
.blue
{
color:#126fbd;
font-family: Arial, Helvetica, sans-serif;
font-size:18px;
font-weight:bold;
}
#footer 
{
width:895px;
background:#cfd4d9;
text-align:center;
font-family: "Trebuchet MS";
font-size:18px;
color:#000;
font-style: italic;
font-weight:bold;
height:20px;
margin-left:-10px;
position:relative;
padding:10px;

}
#footer a, #footer a:visited
{
color:#000;
text-decoration:none;
}
#footer a:hover
{
color:#000;
text-decoration: underline;
}
-->
</style>
<script>

function email_validate(email) {
	   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	   var address = email;
	   if(reg.test(address) == false) {
		   return false;
	   }
	   else
	   	return true;
	}
	
function validateform()
{
	var flag = true;
    var notification = '';
	
	if(document.smsf['cnt_name'].value.replace(/^\s*|\s*$/g,"")=='')
	{
		document.getElementById("err_name").style.display="block";
		flag =  false;
	}
	else
		document.getElementById("err_name").style.display="none";
	
	if(document.smsf['cmp_name'].value.replace(/^\s*|\s*$/g,"")=='')
	{
		document.getElementById("err_cmp").style.display="block";
		flag =  false;
	}
	else
		document.getElementById("err_cmp").style.display="none";
	
	if(document.smsf['email'].value.replace(/^\s*|\s*$/g,"")=='')
			{
					document.getElementById("err_email").style.display="block";
					flag =  false;
			}
			else
			{
				if(!email_validate(document.smsf['email'].value))
				{
				document.getElementById("err_email").style.display="block";
				document.getElementById("err_email").innerHTML="invalid";
					//$("#err_email").html("invalid");
					flag =  false;
				}
				else
					document.getElementById("err_email").style.display="none";
					
			}
	
	if(document.smsf['phone'].value.replace(/^\s*|\s*$/g,"")=='')
	{
		document.getElementById("err_phone").style.display="block";
		//$("#err_phone").css("display","block");
		flag =  false;
	}
	else
	document.getElementById("err_phone").style.display="none";
	//$("#err_phone").css("display","none");
	
	
	if(document.smsf['states'].value.replace(/^\s*|\s*$/g,"")=='')
	{
		document.getElementById("err_states").style.display="block";
		//$("#err_phone").css("display","block");
		flag =  false;
	}
	else
	document.getElementById("err_states").style.display="none";
	//$("#err_phone").css("display","none");
	
	
	if(document.smsf['comments'].value.replace(/^\s*|\s*$/g,"")=='')
	{
		document.getElementById("err_comments").style.display="block";
		//$("#err_comments").css("display","block");
		flag =  false;
	}
	else
	document.getElementById("err_comments").style.display="none";
	//$("#err_comments").css("display","none");
	
	if(flag)
	{
		document.smsf.submit();
		
	}
	else
	{	
		return false;
	}
}
</script>
</head>

<body>
<div id="border-box">
<div id="container">
<img src="images/logo.jpg" width="155" height="77"  class="logo"/>
<div class="title">Managing Your 
Self-Managed Superfund (SMSF) </div>
<div id="form">
	<form name="smsf" method="post" action="smsf_register.php" onSubmit = "return validateform();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td align="center" colspan="2"><div style="color:#FE0002;"><?php if($_GET['msg'] == "success")
	echo "Thank you for visiting our website.<br>We will endeavour to respond to your request within one business day." ?></div></td>
  </tr>
  <tr>
    <td width="8%" valign="top"><div class="request-quote"></div></td>
    <td width="41%" valign="top"><table width="96%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td width="46%">Contact Name <span class="orangetext">*</span></td>
        <td colspan="2"><input name="cnt_name" type="text" id="cnt_name" size="25" />
		<div id="err_name" style="display:none;color:#FE0002;">Required</div>
		</td>
      </tr>
      <tr>
        <td>Company Name <span class="orangetext">*</span></td>
        <td colspan="2">
          <input name="cmp_name" type="text" id="cmp_name" size="25" />
        	<div id="err_cmp" style="display:none;color:#FE0002;">Required</div>
		</td>
      </tr>
      <tr>
        <td>Email <span class="orangetext">*</span></td>
        <td colspan="2"><input name="email" type="text" id="email" size="25" />
		<div id="err_email" style="display:none;color:#FE0002;">Required</div>
		</td>
      </tr>
      <tr>
        <td>Phone number <span class="orangetext">*</span></td>
        <td colspan="2"><input name="phone" type="text" id="phone" size="25" />
		<div id="err_phone" style="display:none;color:#FE0002;">Required</div>
		</td>
      </tr>
      <tr>
        <td>State <span class="orangetext">*</span></td>
        <td colspan="2">
		<select name="states">
		<option value="">State</option>
		<option value="ACT">ACT</option>	
		<option value="NSW">NSW</option>
		<option value="NT">NT</option>
		<option value="QLD">QLD</option>
		<option value="SA">SA</option>
		<option value="TAS">TAS</option>
		<option value="VIC">VIC</option>	
		<option value="WA">WA</option>
		</select>	
		<br /><div id="err_states" style="display:none;color:#FE0002;">Required</div>	
		</td>
		
      </tr>
      <!--<tr>
        <td>Services Required </td>
        <td colspan="2">
		<select name="services" >
			<option value="0"></option>
			<option value="Bookkeeping">Bookkeeping</option>
			<option value="Accounting &amp; Tax">Accounting &amp; Tax</option>
			<option value="Both">Both</option>	
			<option value="other">Other</option>
		</select>
		</td>
      </tr>-->
      <tr>
        <td>Message  <span class="orangetext">*</span></td>
        <td colspan="2"><label>
          <textarea name="comments" id="comments" cols="19" rows="5"></textarea>
          <div id="err_comments" style="display:none;color:#FE0002;">Required</div>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="26%"><input type="image" name="submit" src="images/submit.jpg" width="85" height="22" /></td>
        <td width="28%"><input type="image" src="images/clear.jpg" width="86" height="24" onclick = "document.smsf.reset();return false;" /></td>
      </tr>
    </table></td>
     <td width="2%" valign="top"style="background:url(images/dots.jpg) repeat-y;">&nbsp;</td>
      <td width="49%" valign="top"><img src="images/easy.jpg" width="140" height="60" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/affordable.jpg" width="144" height="61" />
      
      <ul class="points">
      <li>Capped Prices at <span class="blue">$700*</span> for ANY SuperFund</li>
      <li>Easy to Manage . We will manage it all for you.</li>
      <li>Experts. We are SMSF Specialist Advisors & CPA Accountants.</li>
      <li>Awards. Awarded as BRW Fast Starters 2011</li>
      </ul>      </td>
  </tr>
</table>
</form>
  <br />
  
  
  
</div>
<!--<div id="footer"> <a href="http://hiristechnologies.com/joomla/">Home</a> | <a href="http://hiristechnologies.com/joomla/self-managed-super-fund.html">SMSF Services</a></div>-->
<div id="footer"> <a href="http://befree.com.au/">Home</a> | <a href="http://befree.com.au/self-managed-super-fund.html">SMSF Services</a></div>

<br />

</div>

</div>
</body>
</html>
