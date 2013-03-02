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

		<body>
		  <!--<form method="POST" name="frmJobList" action="job.php?a=reset">--><?
		
			if($_REQUEST["doAction"] != "uploadReports")
				include("includes/header.php");?><br><?

			$a = $_REQUEST["a"];
			$sql = $_REQUEST["sql"];
			$filter = $_REQUEST["filter"];
			$doAction = $_REQUEST["list"];
					
			if($_REQUEST["queryId"])
			{
				$queryId = $_REQUEST["queryId"];
				$objCallData->update_query($queryId);	

				/* send mail function starts here */
				$queryStatus = $_REQUEST['rdStatus' . $queryId];

				if($queryStatus) {
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus('6');

					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info('6');

						//It will Get Email Id from Which Email Id the Email will Send.
						$practiceId = $objCallData->fetchPracticeId($_REQUEST["recid"]);
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
						send_mail($from, $to, $cc, $subject, $content);
					}
				}
				/* send mail function ends here */

				header('Location: job.php?a=reset&doAction=queries&jobId='.$_REQUEST["jobId"]);	
			}
			
			// db query as per request
			switch ($sql)
			{
				case "update":
					
					$objCallData->sql_update($_REQUEST["recid"]);

					/* send mail function starts here */

					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus('4');

					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info('4');

						//It will Get Email Id from Which Email Id the Email will Send.
						$practiceId = $objCallData->fetchPracticeId($_REQUEST["recid"]);
						$toEmail = get_email_id($practiceId);

						$from = $arrEmailInfo['event_from'];
						$to = $toEmail;
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];

						// replace variable @jobStatus with updated status of job 
						$jobStatusId = $_REQUEST['lstJobStatus'];
						$jobStatus = $objCallData->arrJobStatus[$jobStatusId]['job_status'];
						$content = str_replace('@jobStatus', $jobStatus, $content);

						// replace variable @fromName with name of administrator
						$fromName = $objCallData->fetchFromName($from);
						$content = str_replace('@fromName', $fromName, $content);

						// replace variable @toName with name of practice
						$toName = $objCallData->arrPracticeName[$practiceId];
						$content = str_replace('@toName', $toName, $content);

						include_once(MAIL);
						send_mail($from, $to, $cc, $subject, $content);
						
					}
					/* send mail function ends here */

					break;
					
				case "add":
					$objCallData->upload_report();
					?><script>
						window.opener.location.reload();
						self.close();
					</script><?
					break;
					
				case "discon":
					$objCallData->discontinue_job();
					break;
					
				case "insertJob":
					$objCallData->insert_job();
					break;
			}
				
			// display pages content as per request
			switch($a)
			{
				case "add":
					$objCallData->add_query();

					/* send mail function starts here */

					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus('5');

					// if event is active it go for mail function
					if($flagSet) {
						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info('5');

						//It will Get Email Id from Which Email Id the Email will Send.
						$practiceId = $objCallData->fetchPracticeId($_REQUEST["recid"]);
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
						send_mail($from, $to, $cc, $subject, $content);
					}
					/* send mail function ends here */

					header('Location: job.php?a=reset&doAction=queries&jobId='.$_REQUEST["jobId"]);
					break;
					
				case "addJob":
					header('Location: job.php?a=reset&doAction=add_job');
					break;
					
				case "edit":
					$arrTask = $objCallData->sql_select();
					header('Location: job.php?a=reset&doAction=details&jobId='.$_REQUEST["recid"]);
					break;
				
				case "reset":

					//Get FormCode
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

						if($_REQUEST["filePath"]) {
							if($_REQUEST['flagType'] == 'S') { 
								$objCallData->update_document($_REQUEST["docId"]);
							}
							else {
								$objCallData->update_checklist_status($_REQUEST["jobId"]);
							}
							$objCallData->doc_download($_REQUEST["filePath"]);
							header('Location: job.php?a=reset&doAction=documents&jobId='.$_REQUEST["jobId"]);
						}
							
						include('views/job_list.php');
					}

					break;
			}
		
		if($_REQUEST["doAction"] != "uploadReports")
		{
			include("includes/footer.php");	
		}
}  
else {
	header("Location:index.php?msg=timeout");
}
?>