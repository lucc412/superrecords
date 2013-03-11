<?php 
//************************************************************************************************
//  Task          : Controller page which redirect to Job Listing page
//  Modified By   : Dhiraj Sahu 
//  Created on    : 01-Jan-2013
//  Last Modified : 07-Jan-2013 
//************************************************************************************************

ob_start();
include 'common/varDeclare.php';
include(PHPFUNCTION);
include 'dbclass/commonFunctions_class.php';
include 'dbclass/job_class.php';

// create class object for class function access
$objCallData = new Job_Class();

if($_SESSION['validUser']) {

	// do not include below code when file 'download' case is called
	if($_REQUEST['sql'] != 'download') {
		?><html>
			<head>
				<title>Job List</title>
				<meta name="generator" http-equiv="content-type" content="text/html">
				<LINK href="<?php echo $styleSheet; ?>stylesheet.css" rel="stylesheet" type="text/css">
				<LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
				<script type="text/javascript" src="<?php echo $javaScript;?>datetimepicker.js"></script>
				<script type="text/javascript" src="<?php echo $javaScript;?>validate.js"></script>
				<script type="text/javascript" src="<?php echo $javaScript;?>job.js"></script>
				<script type="text/javascript" src="<?php echo $javaScript;?>jquery-1.4.2.min.js"></script>
			</head>

			<body><?
	}

			$a = $_REQUEST["a"];
			$sql = $_REQUEST["sql"];
			$filter = $_REQUEST["filter"];
		
			if($a != "uploadReports") include("includes/header.php");	
			?><br><?
			
			// db query as per request
			switch ($sql) {
			
				case "sendMail":
					$objCallData->send_mail_practice($_REQUEST['jobId']);
					
					/* send mail function starts here */
					//It will Get Email Id from Which Email Id the Email will Send.
					$jobId = $_REQUEST['jobId'];
					$practiceId = $objCallData->fetchPracticeId($jobId);
					$to = get_email_id($practiceId);
					$subject = 'Query Submitted to Practice';
					$content = 'You have pending queries for JOBNAME. Please log into the Super Records Job Tracker via http://superrecords.com.au/jobtracker/ to view and resolve your pending queries.';
					$content = replaceContent($content,NULL,NULL,NULL,$jobId);
					include_once(MAIL);
					send_mail($to, $cc, $subject, $content);
					/* send mail function ends here */
					header('Location: job.php?a=queries&jobId='.$_REQUEST["jobId"]);
					break;

				case "insertJob":
					$jobId = $objCallData->insert_job();
					
					/* send mail function starts here */
					$pageUrl = basename($_SERVER['REQUEST_URI']);
					$arrPageUrl = explode('&',$pageUrl);	
					$pageUrl = $arrPageUrl[0];
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageUrl);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageUrl);
						$srManagerEmailId = fetchStaffInfo('113','email');
						
						$to = $srManagerEmailId;
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content =replaceContent($content, NULL, $_REQUEST['lstPractice'], NULL, $jobId);
						
						include_once(MAIL);
						send_mail($to, $cc, $subject, $content);
					}
					/* send mail function ends here */
					
					break;

				case "updateJob":
					
					$jobStatus = $_POST['lstJobStatus'];
					if($jobStatus == '7')
					{
						/* send mail function starts here */
						$pageUrl = basename($_SERVER['REQUEST_URI']);
						$arrPageUrl = explode('&',$pageUrl);	
						$pageUrl = $arrPageUrl[0];
						// check if event is active or inactive [This will return TRUE or FALSE as per result]
						$flagSet = getEventStatus($pageUrl);
						// if event is active it go for mail function
						if($flagSet) {
							//It will Get All Details in array format for Send Email
							$arrEmailInfo = get_email_info($pageUrl);
							//It will Get Email Id from Which Email Id the Email will Send.
							$jobId = $_REQUEST['jobId'];
							$practiceId = $objCallData->fetchPracticeId($jobId);
							$toEmail = get_email_id($practiceId);
							$to = $toEmail;
							$cc = $arrEmailInfo['event_cc'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = replaceContent($content,NULL,$practiceId,NULL,$jobId);
							include_once(MAIL);
							send_mail($to, $cc, $subject, $content);
							
						}
					/* send mail function ends here */
					}
					
					$objCallData->sql_update($_REQUEST["jobId"]);

					header('Location: job.php?a=editJob&jobId='.$_REQUEST["jobId"]);
					break;
					
				case "deleteJob":
					$objCallData->discontinue_job();
					break;

				case "download":
					if($_REQUEST["filePath"]) {
						if($_REQUEST['flagType'] == 'S') { 
							$objCallData->update_document($_REQUEST["docId"]);
						}
						$objCallData->doc_download($_REQUEST["filePath"]);
						header('Location: job.php?a=documents&jobId='.$_REQUEST["jobId"]);
					}
					break;
					
				case "insertReport":
					$objCallData->upload_report();
					
					/* send mail function starts here */
					$pageUrl = basename($_SERVER['REQUEST_URI']);
					$arrPageUrl = explode('&',$pageUrl);	
					$pageUrl = $arrPageUrl[0];
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageUrl);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageUrl);
						
						//It will Get Email Id from Which Email Id the Email will Send.
						$jobId = $_REQUEST['jobId'];
						$practiceId = $objCallData->fetchPracticeId($jobId);
				
						$toEmail = get_email_id($practiceId);
				
						$to = $toEmail;
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];	
						$content = replaceContent($content,NULL,$practiceId,NULL,$jobId);
						
						include_once(MAIL);
						send_mail($to, $cc, $subject, $content);
						
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
					
					$queryId = $_REQUEST["queryId"];
					$objCallData->update_query($queryId);	

					/* send mail function starts here */
					$queryStatus = $_REQUEST['rdStatus' . $queryId];
					
					if($queryStatus) {
						// check if event is active or inactive [This will return TRUE or FALSE as per result]
						$pageUrl = basename($_SERVER['REQUEST_URI']);	
						
						$flagSet = getEventStatus($pageUrl);
						// if event is active it go for mail function
						if($flagSet) {
						

							//It will Get All Details in array format for Send Email	
							$arrEmailInfo = get_email_info($pageUrl);
						
							//It will Get Email Id from Which Email Id the Email will Send.
							$practiceId = $objCallData->fetchPracticeId($_REQUEST["jobId"]);
							$toEmail = get_email_id($practiceId);

							$from = $arrEmailInfo['event_from'];
							$to = $toEmail;
							$cc = $arrEmailInfo['event_cc'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];

							// replace variable @fromName with name of administrator
							$fromName = $objCallData->fetchFromName($from);
							$content = str_replace('@fromName', $fromName, $content);

							// replace variable @toName with name of practice
							$toName = $objCallData->arrPracticeName[$practiceId];
							$content = str_replace('@toName', $toName, $content);
						
							include_once(MAIL);
							send_mail($to, $cc, $subject, $content);
						}
					}
					/* send mail function ends here */

					header('Location: job.php?a=queries&jobId='.$_REQUEST["jobId"]);	
					break;
				}

				//Get FormCode [Display main listing page of Job]
				$formcode = $commonUses->getFormCode("Job List");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrJob = $objCallData->fetchJob();
					$arrPractice = $objCallData->fetchPractice();
					$arrClients = $objCallData->fetchClient();
					$arrJobType = $objCallData->fetchJobType();

					include('views/job_list.php');
				}
		
	if($a != "uploadReports") include("includes/footer.php");	
}  
else {
	header("Location:index.php?msg=timeout");
}
?>