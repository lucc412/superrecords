<?php

// send mail function
function send_mail($to, $cc=NULL, $subject, $content)
{	
	$from = "noreply@superrecords.com.au";

	//It will set the Header From Which Email Id main will send also it will Set CC
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset: utf8\r\n";
	$headers .= "From: ".$from . "\r\n" ."CC:".$cc."";

	// this will send e-mail as per parameters passed to mail function.
	mail($to,$subject,$content,$headers);
}

?>