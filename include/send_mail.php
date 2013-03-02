<?php
function sent_mail()
{	
		$email_id = get_email_id($_SESSION['PRACTICEID']);
		$arrEmailInfo = get_email_info('1');
		
		$from = $email_id;
		$cc = $arrEmailInfo['event_cc'];
		$to = $arrEmailInfo['event_to'];
		$subject = $arrEmailInfo['event_subject'];
		$content = $arrEmailInfo['event_content'];
		
	
		$headers = "From: ".$from . "\r\n" ."CC:".$cc."";
		mail($to,$subject,$content,$headers);
		
}

?>