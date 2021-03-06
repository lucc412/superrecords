<?php 
//************************************************************************************************
//  Task          : Controller page which redirect to Job Listing page
//  Modified By   : Dhiraj Sahu 
//  Created on    : 01-Jan-2013
//  Last Modified : 07-Jan-2013 
//************************************************************************************************

ob_start();
include 'dbclass/commonFunctions_class.php';
include 'dbclass/job_class.php';
include(PHPFUNCTION);

if(!isset($_REQUEST['sql'])) $_REQUEST['sql'] = "";
else $sql = $_REQUEST['sql'];
if(!isset($_REQUEST['a'])) $_REQUEST['a'] = "";
else $a = $_REQUEST['a'];

if($a == "uploadReports") {
	session_start();
}
else if($a == "auditDocs") {
	session_start();	
}
else {
	include("includes/header.php");	
}

// create class object for class function access
$objCallData = new Job_Class();

if($_SESSION['validUser']) {

	// do not include below code when file 'download' case is called
	if($sql != 'download') {
		if($a == "uploadReports" || $a == "auditDocs") {
			?><link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
			<script type="text/javascript" src="<?php echo $javaScript;?>jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript;?>job.js"></script><?
		}
	}
	
	$filter = $_REQUEST["filter"];
	?><br/><?
			
			// db query as per request
			switch ($sql) {

				case "insertJob":
					$jobId = $objCallData->insert_job();
					
					/* send mail function starts here for ADD NEW JOB */
					$pageCode = 'NEWJB';
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageCode);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageCode);

						// fetch email id of sr manager
						$to = fetch_prac_designation($_REQUEST['lstPractice'],true,true,true,true);
						$cc = fetch_client_designation($jobId,true,true,true);
						if(!empty($arrEmailInfo['event_cc'])) $cc .= ','.$arrEmailInfo['event_cc'];
						$bcc = $arrEmailInfo['event_bcc'];
						$from = $arrEmailInfo['event_from'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, NULL, $_REQUEST['lstPractice'], NULL, $jobId);
						
						 
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}
					/* send mail function ends here */

					header('location: job.php');
					break;

				case "updateJob":
					$jobId = $_REQUEST['jobId'];
					$oldJobStatus = $objCallData->getJobStatus($jobId);
					$newJobStatus = $_POST['lstJobStatus'];
					
					if($oldJobStatus != $newJobStatus && $newJobStatus == '7')
					{
						/* send mail function starts here */	
						$pageCode = 'JBDON';
						// check if event is active or inactive [This will return TRUE or FALSE as per result]
						$flagSet = getEventStatus($pageCode);
						// if event is active it go for mail function
						if($flagSet) {
							//It will Get All Details in array format for Send Email
							$arrEmailInfo = get_email_info($pageCode);
							//It will Get Email Id from Which Email Id the Email will Send.
							$practiceId = $objCallData->fetchPracticeId($jobId);
							$toEmail = get_email_id($practiceId);
							$to = $toEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = fetch_prac_designation($practiceId,true);
							if(!empty($arrEmailInfo['event_bcc'])) $bcc .= ','.$arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = replaceContent($content,NULL,$practiceId,NULL,$jobId);
							
							 
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
						/* send mail function ends here */
					}
					
					$objCallData->sql_update($jobId);

					header('Location: job.php');
					break;
					
				case "deleteJob":
					$objCallData->discontinue_job();
                                        header('Location: job.php');
					break;

				case "deleteQuery":
					$objCallData->delete_query();
					header('Location: job.php?a=queries&jobId='.$_REQUEST["jobId"]);
					break;

				case "download":
				
					if($_REQUEST["filePath"]) {
						$objCallData->update_document($_REQUEST["docId"]);
						$objCallData->doc_download($_REQUEST["filePath"]);
						header('Location: job.php?a=documents&jobId='.$_REQUEST["jobId"]);
					}
					break;
					
				case "insertReport":
					$objCallData->upload_report();
					
					/* send mail function starts here */	
					$pageCode = 'NEWRP';
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageCode);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageCode);
						
						//It will Get Email Id from Which Email Id the Email will Send.
						$jobId = $_REQUEST['jobId'];
						$practiceId = $objCallData->fetchPracticeId($jobId);
						$toEmail = get_email_id($practiceId);
						$to = $toEmail;
						$cc = $arrEmailInfo['event_cc'];
						$bcc = fetch_prac_designation($practiceId,true);
						if(!empty($arrEmailInfo['event_bcc'])) $bcc .= ','.$arrEmailInfo['event_bcc'];
						$from = $arrEmailInfo['event_from'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];	
						$content = replaceContent($content,NULL,$practiceId,NULL,$jobId);
						
						 
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}
					/* send mail function ends here */
					
					?><script>
					  window.opener.document.location= 'job.php?a=reports&jobId=<?php echo  $_REQUEST["jobId"];?>'; 
					  self.close();
					 </script><?

					break;

				case "insertQuery":
					$objCallData->add_query();
					header('Location: job.php?a=queries&jobId='.$_REQUEST["jobId"]);
					break;

				case "updateQuery":
					
					$qryPost = $_REQUEST["qryPost"];
					$queryId = $_REQUEST["queryId"];
					$flagPost = $_REQUEST["flagPost"];
					
					if((isset($qryPost)) && $qryPost != '')
					{
						if($qryPost == 'Y')
							$qryPost = 'N';
						else
							$qryPost = 'Y';
													
						$objCallData->update_query_post($qryPost,$queryId);	
					}
					else if($qryPost == '')
					{
						$objCallData->update_query($queryId);
					} 
						
					
					header('Location: job.php?a=queries&jobId='.$_REQUEST["jobId"]);
					
					break;
					
				case "updateQueryPost":
					$queryId = $_POST["queryId"];
					$flagPost = $_POST["flagPost"];
					
					$objCallData->update_query_post($flagPost,$queryId);
					header('Location: job.php?a=queries&jobId='.$_POST["jobId"]);
					
					break;

				case "sendMail":

					/* send mail function starts here */

					//set send mail date in database
					$objCallData->send_mail_practice($_REQUEST['jobId']);

					//It will Get All Details in array format for Send Email	
					$arrEmailInfo = get_email_info('NEWQR');
					
					//It will Get Email Id from Which Email Id the Email will Send.
					$jobId = $_REQUEST['jobId'];
					$practiceId = $objCallData->fetchPracticeId($jobId);
					$toEmail = get_email_id($practiceId);
					$to = $toEmail;
					$cc = $arrEmailInfo['event_cc'];
					$bcc = fetch_prac_designation($practiceId,true,false,true,true);
					if(!empty($arrEmailInfo['event_bcc'])) $bcc .= ','.$arrEmailInfo['event_bcc'];
					$from = $arrEmailInfo['event_from'];
					$subject = $arrEmailInfo['event_subject'];
					$content = $arrEmailInfo['event_content'];	
					$content = replaceContent($content,NULL,NULL,NULL,$jobId);
					
					 
					send_mail($from, $to, $cc, $bcc, $subject, $content);
					/* send mail function ends here */

					header('Location: job.php?a=queries&jobId='.$jobId);
					break;
                                        
                                    default :
                                        //Get FormCode [Display main listing page of Job]
                                        $formcode = $commonUses->getFormCode("Job List");
                                        $access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                                        //If View, Add, Edit, Delete all set to N
                                        if($access_file_level == 0) {
                                            echo "You are not authorised to view this file.";
                                        }
                                        else 
                                        {
//                                            $arrJob = $objCallData->fetchJob();
//                                            $arrPractice = $objCallData->fetchPractice();
//                                            $arrClients = $objCallData->fetchClient();
//                                            $arrJobType = $objCallData->fetchJobType();

                                            include('views/job_list.php');
                                        }
                                        break;

				}

				
		
	if($a != "uploadReports" && $a != "auditDocs") include("includes/footer.php");	
}  
else {
	header("Location:index.php?msg=timeout");
}
?>