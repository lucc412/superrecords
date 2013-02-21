<?php
	//error_reporting(5);
	include('dbclass/commonFunctions_class.php');
	//print_r($_POST);
	 
      $cnt_name = isset($_POST['cnt_name']) ? trim($_POST['cnt_name']) : '';
      $cmp_name = isset($_POST['cmp_name']) ? trim($_POST['cmp_name']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone= isset($_POST['phone']) ? trim($_POST['phone']) : '';
     // $cnt_address= isset($_POST['cnt_address']) ? trim($_POST['cnt_address']) : '';	  
      $states= isset($_POST['states']) ? trim($_POST['states']) : '';
      $services= isset($_POST['services']) ? trim($_POST['services']) : '';
      //$other= isset($_POST['other']) ? trim($_POST['other']) : '';
      $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';

  if(($_POST['cnt_name']!="" && $_POST['email']!="" && $_POST['phone']!=""))
      {
      		$mailcontent=$commonUses->getMailContent($_POST['states']);
                      
            $message=$mailcontent['email_template'];
			$from = "help@superrecords.com.au";
			$to = $mailcontent['email_value']; //"maprakash23@gmail.com"; //
			if($services=="Both") $services = "Bookkeeping,Accounting & Tax";
		
			$subject = "SMSF Free Quote- Super Records";

                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
						//Hiris server
                        /*$params["host"] = "aspmx2.googlemail.com";
                        $params["port"] = "25";
                        $params["auth"] = false;
                        $params["username"] = "";
                        $params["password"] = "";*/
						
						// LIve server
						
						$params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
						
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);

						$message = str_replace("{%companyname%}",$_POST['cmp_name'],$message);
						$message = str_replace("{%contactname%}",$_POST['cnt_name'],$message);
						$message = str_replace("{%phonenumber%}",$_POST['phone'],$message);
						$message = str_replace("{%email%}",$_POST['email'],$message);
						$message = str_replace("{%contactaddress%}","",$message);
						$message = str_replace("{%contactstate%}",$_POST['states'],$message);
						$message = str_replace("{%servicesrequired%}", 'SMSF service',$message);
						$message = str_replace("{%netoffer%}","",$message);
						$message = str_replace("{%servicesother%}","",$message);
						
						//echo "<br><br>".$message;
					   
						$message = str_replace("{%message%}",$_POST['comments'],$message);
						//echo "<br><br>".$message;
						
						$status = $mail_object->send($to, $headers, $message);
    					
   // print_r($_POST);
    if($_POST['email']!="")
    {
		//echo "Yes 3";
        $mailcontent=$commonUses->getMailContent('Thanking');
        //Get mail content
        $message=$mailcontent['email_template'];
        $emailTxt = $mailcontent['email_value'];
        $to = $_POST['email'].",".$emailTxt;
     /*   $frommail = "info@befree.com.au";
    $eol="\r\n";
    $headers1 .= 'From: '.$frommail.$eol;
    $headers1 .= 'Reply-To: '.$frommail.$eol;
    $headers1.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
    $message = str_replace("{%name%}",$_POST['cnt_name'],$message);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = "Thanks for your Interest";
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
						
						//Hiris server
                        /*$params["host"] = "aspmx2.googlemail.com";
                        $params["port"] = "25";
                        $params["auth"] = false;
                        $params["username"] = "";
                        $params["password"] = "";*/
						
						// LIve server
						
						$params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
						
                         // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                        $clistatus = $mail_object->send($to, $headers, $message);

    //$clistatus=mail($to , "Thanks for your Interest", $message,$headers1);
    }
	//exit;

//$servicereq = array(16);// Hiris server
$servicereq = array(13); 

switch ($states)
{
    case 'ACT':
        $state = 7;
        break;
    case 'NSW':
        $state = 1;
        break;
    case 'NT':
        $state = 8;
        break;
    case 'QLD':
        $state = 2;
        break;
    case 'SA':
        $state = 3;
        break;
    case 'TAS':
        $state = 4;
        break;
    case 'VIC':
        $state = 5;
        break;
    case 'WA':
        $state = 6;
        break;
}
    $Createdon=date( 'Y-m-d H:i:s' );
    $tday = date("D");
    switch ($tday)
    {
        case 'Mon':
            $day = "Monday";
            break;
        case 'Tue':
            $day = "Tuesday";
            break;
        case 'Wed':
            $day = "Wednesday";
            break;
        case 'Thu':
            $day = "Thursday";
            break;
        case 'Fri':
            $day = "Friday";
            break;
        case 'Sat':
            $day = "Saturday";
            break;
        case 'Sun':
            $day = "Sunday";
            break;
    }

    if($services=="other") {
        $comments = "New Service :- ".$other.". Notes :- ".$comments;
    }
    $userqry = mysql_query("INSERT INTO jos_users (`activation`,`cli_Type`,`name`,`email`,`block`,`cli_Phone`,`cli_DateReceived`,`cli_DayReceived`,`cli_State`,`cli_Notes`,`cli_Salesperson`,`cli_Createdby`,`cli_Createdon`,`cli_Lastmodifiedby`,`cli_Lastmodifiedon`) values ('smsfForm','4','".str_replace("'","''",$cmp_name)."','".str_replace("'","''",$email)."','1','".str_replace("'","''",$phone)."','".$Createdon."','".$day."','".$state."','".str_replace("'","''",$comments)."','52','".str_replace("'","''",$cnt_name)."','".$Createdon."','".str_replace("'","''",$cnt_name)."','".$Createdon."')");
      // insert client Code
      if($userqry){
           $result = (mysql_query ('select MAX(id) from jos_users'));
           $rowid=mysql_fetch_row($result);
           $cur_clicode = $rowid[0];
           $qry = "update jos_users set cli_Code=".$cur_clicode." where id=".$cur_clicode;
           $result = mysql_query($qry);
      }
    // datas stored Client table
      $result = (mysql_query ('select MAX(cli_Code) from jos_users'));
      $row = @mysql_fetch_row($result);
      $userCode = $row[0];
    $conqry = mysql_query("INSERT INTO con_contact (`cli_Code`,`con_Type`,`con_Firstname`,`con_Company`) values ('".$userCode."','1','".str_replace("'","''",$cnt_name)."','".$userCode."')");
    foreach ($servicereq as $sid) {
        $serviceqry = mysql_query("INSERT INTO cli_allservicerequired (`cli_ClientCode`,`cli_ServiceRequiredCode`) values ('".$userCode."','".$sid."')");
    }
    if($status==1)
    {
    echo "<script>
            parent.location.href = 'smsf.php?msg=success';
            </script>";
      }
      }
?> 