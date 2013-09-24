<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) 
{

    
    
	// include model file
	include(MODEL . "existing_smsf_fund_class.php");

	// create class object for class function access
	$objScr = new EXISTING_SMSF_FUND();

	// function to download doc file
        if(isset($_REQUEST['do']) && $_REQUEST['do'] == 'download') {
	    showPDFViewer('docs/guide.pdf','guide.pdf');	
	}

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing fund details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}

	// case when next button is clicked
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addFundInfo') 
        {
            $flagReturn = false;
            $fundName = $_REQUEST['txtFund'];
            $abn = $_REQUEST['txtAbn'];
            $streetAdd = $_REQUEST['taStreetAdd'];
            $postalAdd = $_REQUEST['taPostalAdd'];
            $members = $_REQUEST['lstMembers'];
            $trusteeId = $_REQUEST['lstTrustee'];
            $fundStatus = $_REQUEST['fund_status'];
            $jobStatus = $_REQUEST['job_submitted'];

            // fetch existing fund details
            $arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);

            // fetch existing fund details
            if(empty($arrData)) 
            {
                // insert fund details of sign up user
                $flagReturn = $objScr->addFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
                                    $arrClient = $objScr->checkClients($fundName);
            }
            else {
                // edit fund details of sign up user
                $flagReturn = $objScr->editFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
            }


            if($jobStatus == 'Y')
            {
                $objScr->generatePDF();
            }


            if($flagReturn) 
            { 
                //if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                if(isset($_POST['fund_status']) && $_POST['fund_status'] == 1)
                    header('Location: jobs.php?a=pending');
                else if(isset($_POST['preview']) && $_POST['preview'] == 1) 
                    header('Location: setup_preview.php');
                else
                    header('Location: jobs.php?a=saved');
            }
            else {
                echo "Sorry, Please try later.";
            }
	}

        if(isset($_REQUEST['preview_form']) && $_REQUEST['preview_form'] == 'submit')
        {
            $jobStatus = $_REQUEST['job_submitted'];
            if($jobStatus == 'Y')
            {
                $objScr->generatePDF();
            }
            header('Location: jobs.php?a=pending');
        }
        
	// if data is already entered for current session then set variables
	if(isset($arrData) && !empty($arrData)) 
        {
            $fundName = $arrData['fund_name'];
            $abn = $arrData['abn'];
            $streetAdd = $arrData['street_address'];
            $postalAdd = $arrData['postal_address'];
            $members = $arrData['members'];
            $trusteeType = $arrData['trustee_type_id'];
	}
	// declare variables
	else {
		$fundName = "";
		$abn = "";
		$streetAdd = "";
		$postalAdd = "";
		$members = "";
		$trusteeType = "";
	}

	// define array of members
	$arrNoOfMembers = array('1', '2', '3', '4');

	// fetch trustee type for drop-down
	$arrTrusteeType = $objScr->fetchTrusteeType();
	 
	// include view file 
	include(VIEW . "existing_smsf_fund.php");
}
else {
	header('Location: login.php');
}
?>