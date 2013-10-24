<?php
include("include/common.php");
include(MODEL."jobs_doc_upload_class.php");
$objScr = new DOCUPLOAD();

$sql = $_REQUEST['sql'];
switch ($sql)
{
	case "insertDoc":
	
		$uploadedDocInfo = $objScr->upload_document();
		
		/* send mail function starts here */

		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus('NEWDC');
		
		// if event is active it go for mail function
		if($flagSet) 
                {
			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info('NEWDC');

			// fetch email id of sr manager & india manager of practice
			$to = fetch_prac_designation($_SESSION['PRACTICEID'],true,false,true,true);
			$cc = $arrEmailInfo['event_cc'];
			$bcc = $arrEmailInfo['event_bcc'];
			$from = $arrEmailInfo['event_from'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];

			$arrDocInfo = stringToArray('~', $uploadedDocInfo);
			$docName = $arrDocInfo[0];
			$uploadedTime =	$arrDocInfo[1];

			// replace DOCNAME with actual doc name
			$content = str_replace('DOCNAME', $docName, $content);

			// replace DOCNAME with actual doc name
			$content = str_replace('DATETIME', $uploadedTime, $content);

			$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_REQUEST['lstJob']);

			include_once(MAIL);
			send_mail($from, $to, $cc, $bcc, $subject, $content);
		}
		/* send mail function ends here */		

		if($_REQUEST['additionalDoc'] == 'Y')
			header('location: jobs_pending.php');
		else 
			header('location: jobs_doc_list.php');
		break;
}

$a = $_REQUEST['a'];
switch ($a) {	 
    default :
        $arrjobs = $objScr->fetchJobs();
        include(VIEW.'jobs_doc_upload.php');
        break;
}
?>