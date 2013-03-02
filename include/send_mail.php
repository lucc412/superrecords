<?php
//It will Send Email according Information given to Function.
function send_mail($from, $to, $cc=NULL, $subject, $content)
{	
	//It will set the Header From Which Email Id main will send also it will Set CC
	$headers = "From: ".$from . "\r\n" ."CC:".$cc."";

	//mail function will Send Email as Information given to Mail Function.
	mail($to,$subject,$content,$headers);
}

?>