<?php

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {
	// include model file
	include(MODEL . "new_smsf_declarations_class.php");

	// create class object for class function access
	$objScr = new DECLARATIONS();
            
	// fetch states for drop-down
	$arrQuestionsList = $objScr->fetchQuestions();
        $checkTerms = $objScr->fetchTerms();
        
	$arrQues = array();
	if(isset($_REQUEST['job_submitted']))
	{
		$stQry = "UPDATE job SET job_submitted = '".$_REQUEST['job_submitted']."', job_received = NOW() WHERE job_id = ".$_SESSION['jobId'];
		$flagReturn = mysql_query($stQry);
		
		$objScr->updateTerms($_REQUEST['chkAgree']);

		if($_REQUEST['job_submitted'] == 'Y')
		{
			$objScr->generatePDF();
		}
	}
        
	foreach($arrQuestionsList as $value)
	{	
            $arrId = explode(",",$value['trustee_type_id']);

            for($i=0; $i<count($arrId); $i++)
            {
                if($_SESSION['TRUSTEETYPE'] == $arrId[$i])
                    $arrQues[] = $value["question"];
            }
	}
        
        // include view file 
        if(isset($_REQUEST['job_submitted']) && $_REQUEST['job_submitted'] == 'Y')
            header('Location: jobs.php?a=pending');
        
        else if(isset($_REQUEST['job_submitted']) && $_REQUEST['job_submitted'] == 'N')
            header('Location: jobs.php?a=saved');
        else
            include(VIEW . "new_smsf_declarations.php");
}
else {
	header('Location: jobs.php');
}
?>