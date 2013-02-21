<?php
session_start();
 //error_reporting(E_ALL);
$inc_path = get_include_path();

//set_include_path($inc_path);
include($_SERVER['DOCUMENT_ROOT'].'/admin/dbclass/commonFunctions_class.php');
// from client to admin mail content
        //$docmail=getMailContent('DocUpload');
        $query="SELECT email_name, email_value, email_template FROM email_options where email_id=37";
        $res=mysql_query($query);
        $docmail = @mysql_fetch_array($res);
        $template = $docmail['email_template'];
        $tomail = $docmail['email_value'];
        $message = $template;
        $result = (mysql_query ('SELECT MAX(id) FROM jos_docman'));
        $row = @mysql_fetch_row($result);
        $docid = $row[0];
        $querydoc = "select dmname,dmsubmitedby from jos_docman where id=".$docid;
        $result = mysql_query($querydoc);
        $doccont = @mysql_fetch_array($result);
        $dmname = $doccont['dmname'];
        $submitid = $doccont['dmsubmitedby'];
        $querydoc = "select name from jos_users where id=".$submitid;
        $result = mysql_query($querydoc);
        $clientname = @mysql_fetch_array($result);
        $bname = $clientname['name'];
        //get fname and lname
        $querydoc = "select u.name,u.email,c.con_Firstname,c.con_Lastname,c.con_Email from jos_users AS u LEFT OUTER JOIN stf_staff AS s ON(u.sendEmail = s.stf_Code) LEFT OUTER JOIN con_contact AS c ON(s.stf_CCode = con_Code) where id=".$_SESSION['userid'];
        $result = mysql_query($querydoc);
        $clientname = @mysql_fetch_array($result);
        $fname = $clientname['con_Firstname'];
        $lname = $clientname['con_Lastname'];
        $frmmail = $clientname['email'];
        $cliname = $clientname['name'];
        $from = $frmmail;
        $to = $tomail;
        $subject = $bname." uploaded document to super records";
     /*   $eol="\r\n";
        $headers .= 'From: '.$from.$eol;
        $headers .= 'Reply-To: '.$to.$eol;
        $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
        $message = str_replace("{%bn%}",$bname,$message);
        $message = str_replace("{%docname%}",$dmname,$message);
        $message = str_replace("{%fn%}",$fname,$message);
        $message = str_replace("{%ln%}",$lname,$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $status = $mail_object->send($to, $headers, $message);

      //  $status=mail($to,$subject,$message,$headers);

        //TeaminCharge mail
        $query = "SELECT c.con_Firstname,c.con_Lastname,c.con_Email from jos_users as j LEFT OUTER JOIN stf_staff as s ON(j.cli_TeaminCharge = s.stf_Code) LEFT OUTER JOIN con_contact as c ON(s.stf_CCode = c.con_Code) where id=".$_SESSION['userid'];
        $result = mysql_query($query);
        $teammail = @mysql_fetch_array($result);
        $teamleader = $teammail['con_Email'];
        $teamfname = $teammail['con_Firstname'];
        $teamlname = $teammail['con_Lastname'];
        if($teamleader!="")
        {
        $template = $docmail['email_template'];
        $tomail = $teamleader;
        $message = $template;
        $from = $frmmail;
        $to = $tomail;
     /*   $eol="\r\n";
        $headers .= 'From: '.$from.$eol;
        $headers .= 'Reply-To: '.$to.$eol;
        $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
        $message = str_replace("{%bn%}",$bname,$message);
        $message = str_replace("{%docname%}",$dmname,$message);
        $message = str_replace("{%fn%}",$teamfname,$message);
        $message = str_replace("{%ln%}",$teamlname,$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $status = $mail_object->send($to, $headers, $message);

      //  $status=mail($to,$subject,$message,$headers);
        }
        //India Manager mail
        $query = "SELECT c.con_Firstname,c.con_Lastname,c.con_Email from jos_users as j LEFT OUTER JOIN stf_staff as s ON(j.cli_Assignedto = s.stf_Code) LEFT OUTER JOIN con_contact as c ON(s.stf_CCode = c.con_Code) where id=".$_SESSION['userid'];
        $result = mysql_query($query);
        $indmail = @mysql_fetch_array($result);
        $indiamangEmail = $indmail['con_Email'];
        $indfname = $indmail['con_Firstname'];
        $indlname = $indmail['con_Lastname'];
        if($indiamangEmail!="")
        {
        $template = $docmail['email_template'];
        $indtomail = $indiamangEmail;
        $message = $template;
        $from = $frmmail;
        $to = $indtomail;
     /*   $eol="\r\n";
        $headers .= 'From: '.$from.$eol;
        $headers .= 'Reply-To: '.$to.$eol;
        $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
        $message = str_replace("{%bn%}",$bname,$message);
        $message = str_replace("{%docname%}",$dmname,$message);
        $message = str_replace("{%fn%}",$indfname,$message);
        $message = str_replace("{%ln%}",$indlname,$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $status = $mail_object->send($to, $headers, $message);

      //  $status=mail($to,$subject,$message,$headers);
        }

?>