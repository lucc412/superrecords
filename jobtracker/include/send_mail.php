<?php
// send mail function
function send_mail($from, $to, $cc=NULL, $bcc=NULL, $subject, $content)
{	
	//It will set the Header From Which Email Id main will send also it will Set cc, bcc
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset: utf8\r\n";
	$headers .= "From: ".$from . "\r\n" ."CC:".$cc. "\r\n" ."BCC:".$bcc."";

	// this will send e-mail as per parameters passed to mail function.
	mail($to,$subject,$content,$headers);
}
?>