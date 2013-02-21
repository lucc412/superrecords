<?php
$db = new Database();
class ClientMailcontent extends Database
{
        // E1 mail content
        function sendMailE1Contentuser($assignaustralian,$oldaustralian,$clientname,$state,$salesperson,$oldsalesperson,$servicerequired,$cliEmail)
        {
                global $typeLead;
                global $typeClient;
                global $typeCsigned;
                global $typeDisCon;
                global $commonUses;
                        /*Get india manager mail id and mail content*/
                         $ausmgrmail = $commonUses->getIndMgrMail($assignaustralian);
                         $salpermail = $commonUses->getIndMgrMail($salesperson);
                         if($assignaustralian!=$oldaustralian)
                         {
                            $mailcontent = $commonUses->getMailContent('E1_AssignAustralian');
                            /*Get mail subject*/
                            $subject = "E1 - New Client Assigned - Please send welcome email.";
                            $emailTxt = $mailcontent['email_value'];
                            $to = $ausmgrmail.",".$emailTxt;
                            /*Get mail header*/
                            $mail_object = $commonUses->getSmtphost();
                            $headers = $commonUses->getHeader();
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                            /*Get mail template */
                            $message=$mailcontent['email_template'];
                            //get australian manager name
                              $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$assignaustralian." AND t2.aty_Description LIKE '%Staff%'";
                              $res = mysql_query($sql);
                              $ausMgr = @mysql_fetch_array($res);
                            $ausmgrname = $ausMgr['con_Firstname']." ".$ausMgr['con_Lastname'];
                            //get sales person name
                              $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salesperson." AND t2.aty_Description LIKE '%Staff%'";
                              $res = mysql_query($sql);
                              $sales = @mysql_fetch_array($res);
                              $salesper_name = $sales['con_Firstname']." ".$sales['con_Lastname'];
                            $sql_state = "SELECT cst_Description FROM cli_state WHERE cst_Code=".$state;
                            $res_state = mysql_query($sql_state);
                            $statename = @mysql_fetch_array($res_state);
                            $stateName = $statename['cst_Description'];
                            $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$_POST['upcli_code'];
                            $cli_serclicode = mysql_query($ser_query);
                            while($service_required = mysql_fetch_array($cli_serclicode))
                            {
                                 $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                 $cli_service = mysql_query($svr_query);
                                 @$service_name = @mysql_fetch_array($cli_service);
                                 $servicename .= $service_name["svr_Description"].",";
                            }
                            $servreq1 = substr($servicename,0,-1);
                            $message = str_replace("{assgnaustmgrfirstlastname}",$ausmgrname,$message);
                            $message = str_replace("{client name}",$clientname,$message);
                            $message = str_replace("{state}",$stateName,$message);
                            $message = str_replace("{servicerequired}",$servreq1,$message);
                            $message = str_replace("{email}",$cliEmail,$message);
                            $status = $mail_object->send($to, $headers, $message);
                            //$status=mail($to,$subject,$message,$headers);
                        }
                        if($salesperson!=$oldsalesperson)
                        {
                            $mailcontent = $commonUses->getMailContent('E1_Salesperson');
                            /*Get mail subject*/
                            $subject = "E1 - Signed Contract Received";
                            $emailTxt = $mailcontent['email_value'];
                            $to = $salpermail.",".$emailTxt;
                            /*Get mail header*/
                            $mail_object = $commonUses->getSmtphost();
                            $headers = $commonUses->getHeader();
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                            /*Get mail template */
                            $message=$mailcontent['email_template'];
                            //get australian manager name
                              $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$assignaustralian." AND t2.aty_Description LIKE '%Staff%'";
                              $res = mysql_query($sql);
                              $ausMgr = @mysql_fetch_array($res);
                            $ausmgrname = $ausMgr['con_Firstname']." ".$ausMgr['con_Lastname'];
                            //get sales person name
                              $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salesperson." AND t2.aty_Description LIKE '%Staff%'";
                              $res = mysql_query($sql);
                              $sales = @mysql_fetch_array($res);
                              $salesper_name = $sales['con_Firstname']." ".$sales['con_Lastname'];
                            $sql_state = "SELECT cst_Description FROM cli_state WHERE cst_Code=".$state;
                            $res_state = mysql_query($sql_state);
                            $stateName = @mysql_fetch_array($res_state);
                            $stateName = $stateName['cst_Description'];
                            $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$_POST['upcli_code'];
                            $cli_serclicode = mysql_query($ser_query);
                            while($service_required = @mysql_fetch_array($cli_serclicode))
                            {
                                  $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                  $cli_service = mysql_query($svr_query);
                                  @$service_name = @mysql_fetch_array($cli_service);
                                  $servicename .= $service_name["svr_Description"].",";
                            }
                            $servreq2 = substr($servicename,0,-1);
                            $message = str_replace("{salespersonfirstlastname}",$salesper_name,$message);
                            $message = str_replace("{client name}",$clientname,$message);
                            $message = str_replace("{state}",$stateName,$message);
                            $message = str_replace("{servicerequired}",$servreq2,$message);
                            $message = str_replace("{email}",$cliEmail,$message);
                            $status = $mail_object->send($to, $headers, $message);
                            //$status=mail($to,$subject,$message,$headers);
                        }
                        // get mail end
        }
        function sendMailE1Content($assignaustralian,$clientname,$state,$salesperson,$servicerequired,$cliEmail)
        {
                global $typeLead;
                global $typeClient;
                global $typeCsigned;
                global $typeDisCon;
                global $commonUses;
                            /*Get india manager mail id and mail content*/
                            $ausmgrmail = $commonUses->getIndMgrMail($assignaustralian);
                            $salpermail = $commonUses->getIndMgrMail($salesperson);
                            if($assignaustralian!="")
                            {
                                $mailcontent = $commonUses->getMailContent('E1_AssignAustralian');
                                /*Get mail subject*/
                               $subject = "E1 - New Client Assigned - Please send welcome email.";
                                $emailTxt = $mailcontent['email_value'];
                                $to = $ausmgrmail.",".$emailTxt;
                                /*Get mail header*/
                                $mail_object = $commonUses->getSmtphost();
                                $headers = $commonUses->getHeader();
                                $headers["To"]      = $to;
                                $headers["Subject"] = $subject;
                                $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                                /*Get mail template */
                                $message=$mailcontent['email_template'];
                                //get australian manager name
                                  $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$assignaustralian." AND t2.aty_Description LIKE '%Staff%'";
                                  $res = mysql_query($sql);
                                  $ausMgr = @mysql_fetch_array($res);
                                $ausmgrname = $ausMgr['con_Firstname']." ".$ausMgr['con_Lastname'];
                                //get sales person name
                                  $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salesperson." AND t2.aty_Description LIKE '%Staff%'";
                                  $res = mysql_query($sql);
                                  $sales = @mysql_fetch_array($res);
                                  $salesper_name = $sales['con_Firstname']." ".$sales['con_Lastname'];
                                $sql_state = "SELECT cst_Description FROM cli_state WHERE cst_Code=".$state;
                                $res_state = mysql_query($sql_state);
                                $statename = @mysql_fetch_array($res_state);
                                $stateName = $statename['cst_Description'];
                                $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$_POST['upcli_code'];
                                $cli_serclicode = mysql_query($ser_query);
                                while($service_required = mysql_fetch_array($cli_serclicode))
                                {
                                     $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                     $cli_service = mysql_query($svr_query);
                                     @$service_name = @mysql_fetch_array($cli_service);
                                     $servicename .= $service_name["svr_Description"].",";
                                }
                                $servreq3 = substr($servicename,0,-1);
                                $message = str_replace("{assgnaustmgrfirstlastname}",$ausmgrname,$message);
                                $message = str_replace("{client name}",$clientname,$message);
                                $message = str_replace("{state}",$stateName,$message);
                                $message = str_replace("{servicerequired}",$servreq3,$message);
                                $message = str_replace("{email}",$cliEmail,$message);
                                $status = $mail_object->send($to, $headers, $message);
                                //$status=mail($to,$subject,$message,$headers);
                            }
                            if($salesperson!="")
                            {
                                $mailcontent = $commonUses->getMailContent('E1_Salesperson');
                                /*Get mail subject*/
                                $subject = "E1 - Signed Contract Received";
                                $emailTxt = $mailcontent['email_value'];
                                $to = $salpermail.",".$emailTxt;
                                /*Get mail header*/
                                $mail_object = $commonUses->getSmtphost();
                                $headers = $commonUses->getHeader();
                                $headers["To"]      = $to;
                                $headers["Subject"] = $subject;
                                $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                                /*Get mail template */
                                $message=$mailcontent['email_template'];
                                //get australian manager name
                                  $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$assignaustralian." AND t2.aty_Description LIKE '%Staff%'";
                                  $res = mysql_query($sql);
                                  $ausMgr = @mysql_fetch_array($res);
                                $ausmgrname = $ausMgr['con_Firstname']." ".$ausMgr['con_Lastname'];
                                //get sales person name
                                  $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salesperson." AND t2.aty_Description LIKE '%Staff%'";
                                  $res = mysql_query($sql);
                                  $sales = @mysql_fetch_array($res);
                                  $salesper_name = $sales['con_Firstname']." ".$sales['con_Lastname'];
                                $sql_state = "SELECT cst_Description FROM cli_state WHERE cst_Code=".$state;
                                $res_state = mysql_query($sql_state);
                                $stateName = @mysql_fetch_array($res_state);
                                $stateName = $stateName['cst_Description'];
                                $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$_POST['upcli_code'];
                                $cli_serclicode = mysql_query($ser_query);
                                while($service_required = @mysql_fetch_array($cli_serclicode))
                                {
                                        $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                        $cli_service = mysql_query($svr_query);
                                        @$service_name = @mysql_fetch_array($cli_service);
                                        $servicename .= $service_name["svr_Description"].",";
                                }
                                $sal_servreq = substr($servicename,0,-1);
                                $message = str_replace("{salespersonfirstlastname}",$salesper_name,$message);
                                $message = str_replace("{client name}",$clientname,$message);
                                $message = str_replace("{state}",$stateName,$message);
                                $message = str_replace("{servicerequired}",$sal_servreq,$message);
                                $message = str_replace("{email}",$cliEmail,$message);
                                $status = $mail_object->send($to, $headers, $message);
                                //$status=mail($to,$subject,$message,$headers);
                            }
                            // get mail end
         }
         // E2 mail content
         function sendmailE2Content()
         {
              global $commonUses;
               //get E2 mail
              $clicode = $_GET['cli_code'];
              $mailcontent = $commonUses->getMailContent('E2');
              $client_query = "SELECT name FROM jos_users WHERE cli_Code=".$clicode;
              $store_query = mysql_query($client_query);
              $cli_Name = @mysql_fetch_array($store_query);
              $clientame = $cli_Name['name'];
               //get salesperson mail id
              $sales_query = "SELECT c2.con_Email FROM jos_users AS c1 LEFT OUTER JOIN stf_staff AS s1 ON (c1.cli_Salesperson = s1.stf_Code) LEFT OUTER JOIN con_contact As c2 ON (s1.stf_CCode = c2.con_Code) WHERE c1.cli_Code=".$clicode;
              $store_sales = mysql_query($sales_query);
              $sales_email = @mysql_fetch_array($store_sales);
              $salesPerson_email = $sales_email['con_Email'];
              $subject = "E2-Quote Sheet Submitted by ".$_SESSION['user']."  for  ".$clientame;
              //Get mail header
              $mail_object = $commonUses->getSmtphost();
              $headers = $commonUses->getHeader();
              //Get mail template
              $message=$mailcontent['email_template'];
              //Get to address
              $default_email=$mailcontent['email_value'];
              $to = $default_email.",".$salesPerson_email;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

              $message = str_replace("{client name}",$clientame,$message);
              $message = str_replace("{dynamicuser}",$_SESSION['user'],$message);
              $status = $mail_object->send($to, $headers, $message);
              //$status=mail($to,$subject,$message,$headers);
         }
         // E3 mail content
         function sendMailE3Content()
         {
                global $commonUses;
                                                                //get australian id
                                                                $clicode = $_GET['cli_code'];
                                                                $client_query = "SELECT cli_AssignAustralia FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_query = mysql_query($client_query);
                                                                $ausid = @mysql_fetch_array($store_query);
                                                                $australianid = $ausid['cli_AssignAustralia'];
                                                                //get client name
                                                                $client_query = "SELECT name FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_query = mysql_query($client_query);
                                                                $cli_Name = @mysql_fetch_array($store_query);
                                                                $clientame = $cli_Name['name'];
                                                                //get sales perosn name
                                                                $sal_query = "SELECT cli_Salesperson FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_sal = mysql_query($sal_query);
                                                                $salid = @mysql_fetch_array($store_sal);
                                                                $salesid = $salid['cli_Salesperson'];
                                                                  $sqlsal="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salesid." AND t2.aty_Description LIKE '%Staff%'";
                                                                  $ressal = mysql_query($sqlsal);
                                                                  $salPer = @mysql_fetch_array($ressal);
                                                                //get india manager name
                                                                  $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$australianid." AND t2.aty_Description LIKE '%Staff%'";
                                                                  $res = mysql_query($sql);
                                                                  $indMgr = @mysql_fetch_array($res);
                                                                $indiamgrname = $indMgr['con_Firstname']." ".$indMgr['con_Lastname'];
                                                                $salesname = $salPer['con_Firstname']." ".$salPer['con_Lastname'];
                                                                if($australianid!="") {
                                                                    $ausmailTxt = $commonUses->getIndMgrMail($australianid);
                                                                    $mailcontent = $commonUses->getMailContent('E3');
                                                                    //Get mail subject
                                                                    $emailTxt = $mailcontent['email_value'];
                                                                    $to = $ausmailTxt.",".$emailTxt;
                                                                  //  $subject = "E3 - Sales Notes submitted by ".$_SESSION['user']." for ".$clientame;
                                                                    //Get mail header
                                                                    $mail_object = $commonUses->getSmtphost();
                                                                    $headers = $commonUses->getHeader();
                                                                    $headers["To"]      = $to;
                                                                    $headers["Subject"] = "E3 - Sales Notes submitted by ".$_SESSION['user']." for ".$clientame;
                                                                    $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                                                                    //Get mail template
                                                                    $message=$mailcontent['email_template'];
                                                                    $message = str_replace("{assgaustmgr}",$indiamgrname,$message);
                                                                    $message = str_replace("{client name}",$clientame,$message);
                                                                    $message = str_replace("{sales person}",$salesname,$message);
                                                                    $message = str_replace("{dynamicuser}",$_SESSION['user'],$message);
                                                                    $status = $mail_object->send($to, $headers, $message);
                                                                   // $status=mail($to,$subject,$message,$headers);
                                                                }
                                                                // vaishali goes to mail
                                                                $query = "SELECT  s2.snt_TaskValue FROM snt_salestasks s1 LEFT OUTER JOIN snt_salestasksdetails AS s2 ON(s1.snt_Code = s2.snt_SNCode) WHERE s2.snt_TaskCode=532 and snt_ClientCode=".$clicode;
                                                                $result = mysql_query($query);
                                                                $taskval = mysql_fetch_array($result);
                                                                $taxval = $taskval['snt_TaskValue'];
                                                                if($taxval=="Yes") {
                                                                    $mailcontent = $commonUses->getMailContent('E3-tax');
                                                                    $sales_message=$mailcontent['email_template'];
                                                                    $to=$mailcontent['email_value']; 
                                                                   // $to = "vaishali@befree.com.au,mukund@befree.com.au,rajesh.k@befreeit.com.au";
                                                                    $mail_object = $commonUses->getSmtphost();
                                                                    $headers = $commonUses->getHeader();
                                                                    $headers["To"]      = $to;
                                                                    $headers["Subject"] = "E3 - Sales Notes submitted by ".$_SESSION['user']." for ".$clientame;
                                                                    $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                                                                    $sales_message = str_replace("{assgaustmgr}","Vaishali Kanapar",$sales_message);
                                                                    $sales_message = str_replace("{client name}",$clientame,$sales_message);
                                                                    $sales_message = str_replace("{sales person}",$salesname,$sales_message);
                                                                    $sales_message = str_replace("{dynamicuser}",$_SESSION['user'],$sales_message);
                                                                    $status = $mail_object->send($to, $headers, $sales_message);
                                                                    //$status=mail($to,$subject,$sales_message,$headers);
                                                                }

         }
         // E4 mail content
         function sendMailE4Content($indassignedto,$clientname)
         {
                global $typeLead;
                global $typeClient;
                global $typeCsigned;
                global $typeDisCon;
                global $commonUses;
                    /*Get india manager mail id and mail content*/
                    if($indassignedto!="")
                    {
                        $indmailTxt = $commonUses->getIndMgrMail($indassignedto);
                    }
                    $mailcontent = $commonUses->getMailContent('E4');
                    /*Get mail subject*/
                    $subject = "E4 - Assign new client to India Manager and Permanant Info Submitted by ".$_SESSION['user']."  for  ".$clientname;
                    $emailTxt = $mailcontent['email_value'];
                    $to = $indmailTxt.",".$emailTxt;
                    /*Get mail header*/
                    $mail_object = $commonUses->getSmtphost();
                    $headers = $commonUses->getHeader();
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                    /*Get mail template */
                    $message=$mailcontent['email_template'];
                    //get india manager name
                      $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$indassignedto." AND t2.aty_Description LIKE '%Staff%'";
                      $res = mysql_query($sql);
                      $indMgr = @mysql_fetch_array($res);
                    $indiamgrname = $indMgr['con_Firstname']." ".$indMgr['con_Lastname'];
                    $message = str_replace("{clientname}",$clientname,$message);
                    $message = str_replace("{assgindiamgr}",$indiamgrname,$message);
                    $message = str_replace("{dynamicuser}",$_SESSION['user'],$message);
                    $status = $mail_object->send($to, $headers, $message);
                    //$status=mail($to,$subject,$message,$headers);
                    // get mail end
        }
        // E5 mail content
        function sendMailE5Content()
        {
            global $commonUses;

            $mailcontent = $commonUses->getMailContent('E5_Hosting');
            //get client name
            $clicode = $_GET['cli_code'];
            $client_query = "SELECT name FROM jos_users WHERE cli_Code=".$clicode;
            $store_query = mysql_query($client_query);
            $cli_Name = @mysql_fetch_array($store_query);
            $clientame = $cli_Name['name'];
            $subject = "E5 - Hosting Submitted by ".$_SESSION['user']."  for  ".$clientame;
            //Get mail header
            $mail_object = $commonUses->getSmtphost();
            $headers = $commonUses->getHeader();
            //Get mail template
            $message=$mailcontent['email_template'];
            //Get to address
            $to=$mailcontent['email_value'];
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

            $message = str_replace("{client name}",$clientame,$message);
            $message = str_replace("{dynamicuser}",$_SESSION['user'],$message);
            $status = $mail_object->send($to, $headers, $message);
            //$status=mail($to,$subject,$message,$headers);
        }
        //E6 mail content
        function sendMailE6Content($teamincharge,$indassignedto,$clientname)
        {
                global $typeLead;
                global $typeClient;
                global $typeCsigned;
                global $typeDisCon;
                global $commonUses;
                    /*Get india manager mail id and mail content*/
                    if($teamincharge!="")
                    $ind_Email = $commonUses->getIndMgrMail($indassignedto);
                    $team_Email = $commonUses->getIndMgrMail($teamincharge);
                    $mailcontent = $commonUses->getMailContent('E6');
                    /*Get mail subject*/
                     $subject=$mailcontent['email_name'];
                     $emailTxt = $mailcontent['email_value'];
                     $to = $ind_Email.",".$team_Email.",".$emailTxt;
                    /*Get mail header*/
                     $mail_object = $commonUses->getSmtphost();
                    $headers = $commonUses->getHeader();
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                    /*Get mail template */
                    $message=$mailcontent['email_template'];
                    //get india manager name
                      $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$teamincharge." AND t2.aty_Description LIKE '%Staff%'";
                      $res = mysql_query($sql);
                      $indMgr = @mysql_fetch_array($res);
                    $teaminchargename = $indMgr['con_Firstname']." ".$indMgr['con_Lastname'];
                    $message = str_replace("{client name}",$clientname,$message);
                    $message = str_replace("{TeamInCharge}",$teaminchargename,$message);
                    $status = $mail_object->send($to, $headers, $message);
                    //$status=mail($to,$subject,$message,$headers);
                    // get mail end
        }
        // E7 mail content
        function sendMailE7Content()
        {
            global $commonUses;

                                                                $mailcontent = $commonUses->getMailContent('E7_TaxAccount');
                                                                //Get mail header
                                                                $mail_object = $commonUses->getSmtphost();
                                                                $headers = $commonUses->getHeader();
                                                                //Get mail template
                                                                $message=$mailcontent['email_template'];
                                                                //Get australian name
                                                                $clicode = $_GET['cli_code'];
                                                                $client_query = "SELECT name, cli_Assignedto, cli_Salesperson FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_query = mysql_query($client_query);
                                                                $ausid = @mysql_fetch_array($store_query);
                                                                $indmanagerid = $ausid['cli_Assignedto'];
                                                                $salespersonid = $ausid['cli_Salesperson'];
                                                                $companyname = $ausid['name'];
                                                                $subject = "E7 - Tax & Accounting Notes being submitted by ".$_SESSION['user']."  for  ".$companyname;
                                                                  $sqlsal="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$indmanagerid." AND t2.aty_Description LIKE '%Staff%'";
                                                                  $ressal = mysql_query($sqlsal);
                                                                  $ausmanager = @mysql_fetch_array($ressal);
                                                                  $ausname = $ausmanager['con_Firstname']." ".$ausmanager['con_Lastname'];
                                                                  //get salesperson
                                                                  $sqlsal="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE stf_Code=".$salespersonid." AND t2.aty_Description LIKE '%Staff%'";
                                                                  $ressal = mysql_query($sqlsal);
                                                                  $salPer = @mysql_fetch_array($ressal);
                                                                  $salesname = $salPer['con_Firstname']." ".$salPer['con_Lastname'];
                                                               // if($indmanagerid!=""){
                                                                            $emailTxt=$mailcontent['email_value'];
                                                                            $indmailTxt = $commonUses->getIndMgrMail($indmanagerid);
                                                                            $to = $emailTxt;
                                                                            $headers["To"]      = $to;
                                                                            $headers["Subject"] = $subject;
                                                                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                                                                            $message = str_replace("{australianmgr}",$ausname,$message);
                                                                            $message = str_replace("{salesper}",$salesname,$message);
                                                                            $message = str_replace("{clientname}",$companyname,$message);
                                                                            $status = $mail_object->send($to, $headers, $message);
                                                                           // $status=mail($to,$subject,$message,$headers);
                                                              //  }
                                                         /*       if($salespersonid!="") {
                                                                            $salesmailTxt = $commonUses->getIndMgrMail($salespersonid);
                                                                            $to = $salesmailTxt;
                                                                            $headers["To"]      = $to;
                                                                            $headers["Subject"] = $subject;
                                                                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                                                                            $message = str_replace("{australianmgr}",$ausname,$message);
                                                                            $message = str_replace("{salesper}",$salesname,$message);
                                                                            $message = str_replace("{clientname}",$companyname,$message);
                                                                            $status = $mail_object->send($to, $headers, $message);
                                                                            //$status=mail($to,$subject,$message,$headers);
                                                                } */

        }
        // Notification mail
        function notificationMailcontent()
        {
            global $commonUses;

                                                                $clicode = $_GET['cli_code'];
                                                                $mailcontent = $commonUses->getMailContent('E8_Notification');
                                                                //Get mail content
                                                                $message=$mailcontent['email_template'];
                                                                //get notify users
                                                                 $notify_query = "SELECT cli_Notification,cli_NotifyNotes FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_notify = mysql_query($notify_query);
                                                                $notify_Name = @mysql_fetch_array($store_notify);
                                                                //get client name
                                                                $client_query = "SELECT name FROM jos_users WHERE cli_Code=".$clicode;
                                                                $store_query = mysql_query($client_query);
                                                                $cli_Name = @mysql_fetch_array($store_query);
                                                                $clientame = $cli_Name['name'];
                                                                $users = $_SESSION['user'];
                                                                $getusers = $notify_Name['cli_Notification'];
                                                                $notifynotes = $notify_Name['cli_NotifyNotes'];
                                                                $user_array = explode(",",$getusers);
                                                                for($i=0; $i<count($user_array); $i++)
                                                                {
                                                                    $subject = $clientame." has been updated by ".$users;
                                                                    $to = $commonUses->getIndMgrMail($user_array[$i]);
                                                                    $mailusername = $commonUses->getUsername($user_array[$i]);
                                                                    $message_cont = str_replace("{Username}",$mailusername,$message);
                                                                    $message_cont = str_replace("{Notes}",$notifynotes,$message_cont);
                                                                    // $message = $notifynotes;
                                                                    $mail_object = $commonUses->getSmtphost();
                                                                    $headers = $commonUses->getHeader();
                                                                    $headers["To"]      = $to;
                                                                    $headers["Subject"] = $subject;
                                                                    $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                                                                    $status = $mail_object->send($to, $headers, $message_cont);
                                                                    //$status=mail($to,$subject,$message_cont,$headers);
                                                                }
                                                                $emailTxt = $mailcontent['email_value'];
                                                                if($emailTxt)
                                                                {
                                                                    $mail_object = $commonUses->getSmtphost();
                                                                    $headers=$commonUses->getHeader();
                                                                    $subject = $clientame." has been updated by ".$users;
                                                                    $to = $emailTxt;
                                                                    $headers["To"]      = $to;
                                                                    $headers["Subject"] = $subject;
                                                                    $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                                                                    $mailusername = $commonUses->getUsername($user_array[$i]);
                                                                    $message_txt = str_replace("{Username}",$mailusername,$message);
                                                                    $message_txt = str_replace("{Notes}",$notifynotes,$message_txt);
                                                                    // $message = $notifynotes;
                                                                    $status = $mail_object->send($to, $headers, $message);
                                                                    //$status=mail($to,$subject,$message_txt,$headers);
                                                                }

        }
        // client activation mail
        function clientActiveMail($cliid)
        {
            global $commonUses;

            $query = "SELECT name,email,password from jos_users where id=".$cliid;
            $result = mysql_query($query);
            $activecont = @mysql_fetch_array($result);
            $cliactiveEmail = $activecont['email'];
            $cliactiveName = $activecont['name'];
            $cliactivePass = $activecont['password'];
            $mailcontent = $commonUses->getMailContent('ClientActive');
            $subject= "Super Records login details";
            $mail_object = $commonUses->getSmtphost();
            $headers = $commonUses->getHeader();
            $message=$mailcontent['email_template'];
            $emailTxt = $mailcontent['email_value'];
            $to = $cliactiveEmail.",".$emailTxt;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
            $message = str_replace("{companyname}",$cliactiveName,$message);
            $message = str_replace("{email}",$cliactiveEmail,$message);
            $message = str_replace("{password}",$cliactivePass,$message);
            $status = $mail_object->send($to, $headers, $message);
            //$status=mail($to,$subject,$message,$headers);
        }
        // client Type changed to Discontinued
        function sendMailDiscontinued($clientname,$disdate,$disreason)
        {
                global $typeLead;
                global $typeClient;
                global $typeCsigned;
                global $typeDisCon;
                global $commonUses;
                    $mailcontent = $commonUses->getMailContent('Discontinued');
                    /*Get mail subject*/
                     $emailTxt = $mailcontent['email_value'];
                     $to = $emailTxt;
                     $subject = $clientname." has been discontinued by ".$_SESSION['user'];
                    /*Get mail header*/
                     $mail_object = $commonUses->getSmtphost();
                    $headers = $commonUses->getHeader();
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                    /*Get mail template */
                    $message=$mailcontent['email_template'];
                    $message = str_replace("{clientname}",$clientname,$message);
                    $message = str_replace("{date}",$disdate,$message);
                    $message = str_replace("{reason}",$disreason,$message);
                    $status = $mail_object->send($to, $headers, $message);
                    //$status=mail($to,$subject,$message,$headers);
                    // get mail end
        }

        function worksheetTeamMail($wid)
        {
            global $commonUses;

                $sqlsal="SELECT u1.name, c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `wrk_worksheet` w1 LEFT OUTER JOIN stf_staff AS s1 ON(w1.wrk_TeamInCharge = s1.stf_Code) LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) LEFT OUTER JOIN jos_users AS u1 ON(w1.wrk_ClientCode = u1.cli_Code) where wrk_Code=".$wid;
                $ressal = mysql_query($sqlsal);
                $wrkquery = @mysql_fetch_array($ressal);
                $teamname = $wrkquery['con_Firstname']." ".$wrkquery['con_Lastname'];
                $cliname = $wrkquery['name'];
                $teammail = $wrkquery['con_Email'];
                $userquery = "SELECT c1.con_Firstname, c1.con_Lastname FROM stf_staff s1 LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where stf_Code =".$_SESSION['staffcode'];
                $result = mysql_query($userquery);
                $username = @mysql_fetch_array($result);
                $staff = $username['con_Firstname']." ".$username['con_Lastname'];
            $mailcontent = $commonUses->getMailContent('WorksheetStatus');
            $subject = "Worksheet Status updated by ".$staff;
            $mail_object = $commonUses->getSmtphost();
            $headers = $commonUses->getHeader();

            $message=$mailcontent['email_template'];
            $emailTxt = $mailcontent['email_value'];
            $to = $teammail.",".$emailTxt;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
            $message = str_replace("{Teamincharge}",$teamname,$message);
            $message = str_replace("{clientname}",$cliname,$message);
            $message = str_replace("{dynamicuser}",$staff,$message);
            $status = $mail_object->send($to, $headers, $message);
            //$status=mail($to,$subject,$message,$headers);

        }
        function clientCasesMail($cid,$mode,$user,$priority,$duedate,$autoid,$ausid,$teamid)
        {
            global $commonUses;
                // get TeaminCharge
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `cas_cases` u1 LEFT OUTER JOIN stf_staff AS s1 ON(u1.cas_TeamInCharge = s1.stf_Code) LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where u1.cas_TeamInCharge=".$teamid;
                $ressal = mysql_query($sqlsal);
                $wrkquery = @mysql_fetch_array($ressal);
                $teamname = $wrkquery['con_Firstname']." ".$wrkquery['con_Lastname'];
                $teammail = $wrkquery['con_Email'];
                // company name
                $query = "SELECT name FROM jos_users WHERE id=".$cid;
                $result = mysql_query($query);
                $compname = @mysql_fetch_array($result);
                $cliname = $compname['name'];

                //get Australia Manager
                $sqlsal="SELECT c2.con_Firstname, c2.con_Lastname, c2.con_Email FROM `cas_cases` u2 LEFT OUTER JOIN stf_staff AS s2 ON(u2.cas_AustraliaManager = s2.stf_Code) LEFT OUTER JOIN con_contact AS c2 ON(s2.stf_CCode = c2.con_Code) where u2.cas_AustraliaManager=".$ausid;
                $ressal = mysql_query($sqlsal);
                $ausname = @mysql_fetch_array($ressal);
                $ausmanager = $ausname['con_Firstname']." ".$ausname['con_Lastname'];
                $ausmail = $ausname['con_Email'];
                // get staff name
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `stf_staff` s1 LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where stf_Code=".$_SESSION['staffcode'];
                $ressal = mysql_query($sqlsal);
                $wrkquery = @mysql_fetch_array($ressal);
                $username = $wrkquery['con_Firstname']." ".$wrkquery['con_Lastname'];
                // get priority
                $query = "SELECT pri_Description FROM pri_priority WHERE pri_Code=".$priority;
                $result = mysql_query($query);
                $priname = @mysql_fetch_array($result);
                $priorityName = $priname['pri_Description'];
                // mail content
                $mailcontent = $commonUses->getMailContent('NewCase');
              //  $subject = $mailcontent['email_name'];
                if($mode=='new' && $user=='client') {
                    $subject = " New Ticket raised by ".$cliname;
                    $content = "New Issue has been raised for ";
                }
                else if($mode=='edit' && $user=='client') {
                    $subject = " Ticket has been Updated by ".$cliname;
                    $content = "Issue <b>".$autoid."</b> has been Updated by ";
                }
                else if($mode=='new' && $user=='admin') {
                    $subject = " New Ticket raised by ".$username;
                    $content = "New Issue has been raised for ";
                }
                else if($mode=='edit' && $user=='admin') {
                    $subject = " Ticket has been Updated by ".$username;
                    $content = "Issue <b>".$autoid."</b> has been Updated by ";
                }
                // admin issuer name
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname FROM cas_cases t1 LEFT OUTER JOIN stf_staff AS s1 ON(s1.stf_Code = t1.cas_Createdby) LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where cas_Code=".$autoid;
                $ressal = mysql_query($sqlsal);
                $issuerquery = @mysql_fetch_array($ressal);
                $createissue = $issuerquery['con_Firstname'];
                $createissuer = $issuerquery['con_Firstname']." ".$issuerquery['con_Lastname'];
                // client create issuer
                $query = "Select cas_Createdby FROM cas_cases WHERE cas_code=".$autoid;
                $result = mysql_query($query);
                $cliuser = @mysql_fetch_array($result);
                $issuecrater = $cliuser['cas_Createdby'];
                if($createissue) $issuer = $createissuer; else $issuer = $issuecrater;
                // due date
                if($user=="client") $duedate = "Not set";
                // mail content
                $mail_object = $commonUses->getSmtphost();
                $headers = $commonUses->getHeader();

                $message=$mailcontent['email_template'];
                $emailTxt = $mailcontent['email_value'];
                // mail value
                if($emailTxt) {
                $to = $emailTxt;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                $messages = str_replace("{name}",'Admin',$message);
                $messages = str_replace("{content}",$content,$messages);
                $messages = str_replace("{clientname}",$cliname,$messages);
                $messages = str_replace("{ausmanager}",$ausmanager,$messages);
                $messages = str_replace("{priority}",$priorityName,$messages);
                $messages = str_replace("{duedate}",$duedate,$messages);
                $messages = str_replace("{issuer}",$issuer,$messages);
                $status = $mail_object->send($to, $headers, $messages);
                //$status=mail($to,$subject,$messages,$headers);
                }
                // Team in Charge
                if($teammail) {
                $to = $teammail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";

                $message1 = str_replace("{name}",$teamname,$message);
                $message1 = str_replace("{content}",$content,$message1);
                $message1 = str_replace("{clientname}",$cliname,$message1);
                $message1 = str_replace("{ausmanager}",$ausmanager,$message1);
                $message1 = str_replace("{priority}",$priorityName,$message1);
                $message1 = str_replace("{duedate}",$duedate,$message1);
                $message1 = str_replace("{issuer}",$issuer,$message1);
                $status = $mail_object->send($to, $headers, $message1);
                //$status=mail($to,$subject,$message1,$headers);
                }
                // Australia manager
                if($ausmail) {
                $to = $ausmail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message2 = str_replace("{name}",$ausmanager,$message);
                $message2 = str_replace("{content}",$content,$message2);
                $message2 = str_replace("{clientname}",$cliname,$message2);
                $message2 = str_replace("{ausmanager}",$ausmanager,$message2);
                $message2 = str_replace("{priority}",$priorityName,$message2);
                $message2 = str_replace("{duedate}",$duedate,$message2);
                $message2 = str_replace("{issuer}",$issuer,$message2);
                $status = $mail_object->send($to, $headers, $message2);
                //$status=mail($to,$subject,$message2,$headers);
                }

        }
        function CaseStatusMail($compid,$issue,$duedate,$issuer,$ausid,$teamid)
        {
            global $commonUses;

                // staff name
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `stf_staff` s1 LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where stf_Code=".$_SESSION['staffcode'];
                $ressal = mysql_query($sqlsal);
                $wrkquery1 = @mysql_fetch_array($ressal);
                $username = $wrkquery1['con_Firstname']." ".$wrkquery1['con_Lastname'];
                $closedusermail = $wrkquery1['con_Email'];
                // get TeaminCharge
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `cas_cases` u1 LEFT OUTER JOIN stf_staff AS s1 ON(u1.cas_TeamInCharge = s1.stf_Code) LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where u1.cas_TeamInCharge=".$teamid;
                $ressal = mysql_query($sqlsal);
                $wrkquery = @mysql_fetch_array($ressal);
                $teamname = $wrkquery['con_Firstname']." ".$wrkquery['con_Lastname'];
                $teammail = $wrkquery['con_Email'];
                // company name
                $query = "SELECT name FROM jos_users WHERE id=".$compid;
                $result = mysql_query($query);
                $compname = @mysql_fetch_array($result);
                $cliname = $compname['name'];
                //get Australia Manager
                $sqlsal="SELECT c2.con_Firstname, c2.con_Lastname, c2.con_Email FROM `cas_cases` u2 LEFT OUTER JOIN stf_staff AS s2 ON(u2.cas_AustraliaManager = s2.stf_Code) LEFT OUTER JOIN con_contact AS c2 ON(s2.stf_CCode = c2.con_Code) where u2.cas_AustraliaManager=".$ausid;
                $ressal = mysql_query($sqlsal);
                $ausname = @mysql_fetch_array($ressal);
                $ausmanager = $ausname['con_Firstname']." ".$ausname['con_Lastname'];
                $ausmail = $ausname['con_Email'];
                // staff issuer name
                $sqlsal="SELECT c1.con_Firstname, c1.con_Lastname, c1.con_Email FROM `stf_staff` s1 LEFT OUTER JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code) where stf_Code=".$issuer;
                $ressal = mysql_query($sqlsal);
                $issuerquery = @mysql_fetch_array($ressal);
                $stffname = $issuerquery['con_Firstname'];
                $staffissuername = $issuerquery['con_Firstname']." ".$issuerquery['con_Lastname']; 
                $staffissuer = $issuerquery['con_Email'];
                // client issuer name
                $sqluser="SELECT email FROM jos_users WHERE name='".$issuer."'";
                $resuser = mysql_query($sqluser);
                $cliuserquery = @mysql_fetch_array($resuser);
                $clientissuer = $cliuserquery['email'];
                $issuermail = $staffissuer;
                if($stffname) { $cliissuername = $staffissuername;  } else { $cliissuername = $issuer; }
                // mail content
                $mailcontent = $commonUses->getMailContent('CaseStatus');
                $subject = " Ticket Status Completed by ".$username;
                $mail_object = $commonUses->getSmtphost();
                $headers = $commonUses->getHeader();
                $message=$mailcontent['email_template'];
                $emailTxt = $mailcontent['email_value'];
                // mail text
                if($emailTxt) {
                $to = $emailTxt;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message1 = str_replace("{name}",'Admin',$message);
                $message1 = str_replace("{issuedetails}",$issue,$message1);
                $message1 = str_replace("{clientname}",$cliname,$message1);
                $message1 = str_replace("{duedate}",$duedate,$message1);
                $message1 = str_replace("{teamincharge}",$teamname,$message1);
                $message1 = str_replace("{issuername}",$username,$message1);
                $status = $mail_object->send($to, $headers, $message1);
                //$status=mail($to,$subject,$message1,$headers);
                }
                //  Issuer mail
                if($issuermail) {
                $to = $issuermail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message2 = str_replace("{name}",$cliissuername,$message);
                $message2 = str_replace("{issuedetails}",$issue,$message2);
                $message2 = str_replace("{clientname}",$cliname,$message2);
                $message2 = str_replace("{duedate}",$duedate,$message2);
                $message2 = str_replace("{teamincharge}",$teamname,$message2);
                $message2 = str_replace("{issuername}",$username,$message2);
                $status = $mail_object->send($to, $headers, $message2);
                //$status=mail($to,$subject,$message2,$headers);
                }
                //  Team in charge mail
                if($teammail) {
                $to = $teammail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message3 = str_replace("{name}",$teamname,$message);
                $message3 = str_replace("{issuedetails}",$issue,$message3);
                $message3 = str_replace("{clientname}",$cliname,$message3);
                $message3 = str_replace("{duedate}",$duedate,$message3);
                $message3 = str_replace("{teamincharge}",$teamname,$message3);
                $message3 = str_replace("{issuername}",$username,$message3);
                $status = $mail_object->send($to, $headers, $message3);
                //$status=mail($to,$subject,$message3,$headers);
                }
                //  Issue Closed user mail
                if($closedusermail) {
                $to = $closedusermail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message4 = str_replace("{name}",$username,$message);
                $message4 = str_replace("{issuedetails}",$issue,$message4);
                $message4 = str_replace("{clientname}",$cliname,$message4);
                $message4 = str_replace("{duedate}",$duedate,$message4);
                $message4 = str_replace("{teamincharge}",$teamname,$message4);
                $message4 = str_replace("{issuername}",$username,$message4);
                $status = $mail_object->send($to, $headers, $message4);
                //$status=mail($to,$subject,$message4,$headers);
                }
                //  Australia Manager mail
                if($ausmail) {
                $to = $ausmail;
                            $headers["To"]      = $to;
                            $headers["Subject"] = $subject;
                            $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                $message5 = str_replace("{name}",$ausmanager,$message);
                $message5 = str_replace("{issuedetails}",$issue,$message5);
                $message5 = str_replace("{clientname}",$cliname,$message5);
                $message5 = str_replace("{duedate}",$duedate,$message5);
                $message5 = str_replace("{teamincharge}",$teamname,$message5);
                $message5 = str_replace("{issuername}",$username,$message5);
                $status = $mail_object->send($to, $headers, $message5);
                //$status=mail($to,$subject,$message5,$headers);
                }
        }

}		
	
	$ClientEmailcontent = new ClientMailcontent();
?>

