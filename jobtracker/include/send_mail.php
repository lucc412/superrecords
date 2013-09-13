<?php

// send mail function
function send_mail($to, $cc=NULL, $subject, $content)
{	
	$from = "siddhesh.c@befreeit.com.au";

	//It will set the Header From Which Email Id main will send also it will Set CC
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset: utf8\r\n";
	$headers .= "From: ".$from . "\r\n" ."CC:".$cc."";

	/*print('<pre>headers::');
	print_r($headers);
	print('</pre>');

	print('<pre>to::');
	print_r($to);
	print('</pre>');

	print('<pre>subject::');
	print_r($subject);
	print('</pre>');

	print('<pre>content::');
	print_r($content);
	print('</pre>');

	exit;*/

	// this will send e-mail as per parameters passed to mail function.
	mail($to,$subject,$content,$headers);
}

?>