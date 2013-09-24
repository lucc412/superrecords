<?php

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) 
{
	// include model file
	include(MODEL . "new_smsf_declarations_class.php");

	// create class object for class function access
	$objScr = new DECLARATIONS();
            
	// fetch states for drop-down
	$arrQuestionsList = $objScr->fetchQuestions();
        $arrLegRef = $objScr->checkLegalRef();
        $checkTerms = $objScr->fetchTerms();

	$arrQues = array();
	if(isset($_REQUEST['job_submitted']))
	{
            $objScr->updateTerms($_REQUEST['chkAgree']);

            // include view file 
            if(isset($_REQUEST['job_submitted']) && $_REQUEST['job_submitted'] == 'Y')
            {
                // generate PDF
                $objScr->generatePDF();
                if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                header('Location: jobs.php?a=pending');
            }
            else if(isset($_REQUEST['job_submitted']) && $_REQUEST['job_submitted'] == 'N')
            {
                if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                header('Location: jobs.php?a=saved');
            }
            
	}
        else
        {
            foreach($arrQuestionsList as $value)
            {	
                $arrId = stringToArray(",",$value['trustee_type_id']);

                for($i=0; $i<count($arrId); $i++)
                {
                    if($_SESSION['TRUSTEETYPE'] == $arrId[$i])
                        $arrQues[] = $value["question"];
                }
            }
            
            include(VIEW . "new_smsf_declarations.php");
        }
	
}
else {
	header('Location: jobs.php');
}
?>