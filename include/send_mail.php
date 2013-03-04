<?php
//It will Send Email according Information given to Function.
function send_mail($from, $to, $cc=NULL, $subject, $content)
{	
	//It will set the Header From Which Email Id main will send also it will Set CC
	
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset: utf8\r\n";
	$headers .= "From: ".$from . "\r\n" ."CC:".$cc."";
	//mail function will Send Email as Information given to Mail Function.
//	$content = htmlentities($content, ENT_QUOTES);
	
	
	mail($to,$subject,$content,$headers);
}

?>