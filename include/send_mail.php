<?php
//It will Send Email according Information given to Function.
function sent_mail($fromEmail)
{	
	
	//It will Get All Details in array format for Send Email	
	$arrEmailInfo = get_email_info('1');
	
	$from = $fromEmail;
	$cc = $arrEmailInfo['event_cc'];
	$to = $arrEmailInfo['event_to'];
	$subject = $arrEmailInfo['event_subject'];
	$content = $arrEmailInfo['event_content'];
	
	//It will set the Header From Which Email Id main will send also it will Set CC
	$headers = "From: ".$from . "\r\n" ."CC:".$cc."";
	//mail function will Send Email as Information given to Mail Function.
	mail($to,$subject,$content,$headers);
		
}

?>