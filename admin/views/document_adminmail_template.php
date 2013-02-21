<?php
session_start();
include('dbclass/commonFunctions_class.php');
$clientid = $_GET['cid'];
            $query="SELECT email_name, email_value, email_template FROM email_options where email_id=38";
            $res=mysql_query($query);
            $docmail = @mysql_fetch_array($res);
            $template = $docmail['email_template'];
            $emailTxt = $docmail['email_value'];
            $message = $template;
            $result = (mysql_query ('SELECT MAX(id) FROM jos_docman'));
            $row = @mysql_fetch_row($result);
            $docid = $row[0];
            //$_SESSION['newfilename'] = $this->dmname;
            $dmname = $_GET['dmname'];
            $submitid = $doccont['dmsubmitedby'];
            $querydoc = "select u.name,u.email,c.con_Firstname,c.con_Lastname,c.con_Email from jos_users AS u LEFT OUTER JOIN stf_staff AS s ON(u.sendEmail = s.stf_Code) LEFT OUTER JOIN con_contact AS c ON(s.stf_CCode = con_Code) where id=".$clientid;
            $result = mysql_query($querydoc);
            $clientname = @mysql_fetch_array($result);
            $fname = $clientname['con_Firstname'];
            $lname = $clientname['con_Lastname'];
            $tomail = $clientname['email'];
          //  $from = "info@befree.com.au";
            $to = $tomail.",".$emailTxt;
           // $to = "murugesh@hiristechnologies.com";
          /*  $eol="\r\n";
            $headers .= 'From: '.$from.$eol;
            $headers .= 'Reply-To: '.$from.$eol;
            $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
            $message = str_replace("{%admin%}",$adname,$message);
            $message = str_replace("{%docname%}",$dmname,$message);
            $message = str_replace("{%fn%}",$fname,$message);
            $message = str_replace("{%ln%}",$lname,$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = "Super Records has uploaded new document";
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                       echo $status = $mail_object->send($to, $headers, $message);

           // $status=mail($to , "befree has uploaded new document", $message,$headers);
?>