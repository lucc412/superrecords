<?php
//echo phpinfo(); exit;
include("Mail.php");

$recipients = "info@befree.com.au";

$headers["From"]    = "admin@befree.com.au";
$headers["To"]      = "info@befree.com.au";
$headers["Subject"] = "Test message";

$body = "SMTP TEST MESSAGE!!!";

$params["host"] = "ssl://smtp.gmail.com";
$params["port"] = "465";
$params["auth"] = true;
$params["username"] = "admin@befree.com.au";
$params["password"] = "g1tas1ta";

// Create the mail object using the Mail::factory method
$mail_object =& Mail::factory("smtp", $params);

echo $mail_object->send($recipients, $headers, $body);

?>