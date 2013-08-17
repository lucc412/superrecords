<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include(MODEL . "existing_smsf_fund_class.php");

	// create class object for class function access
	$objScr = new EXISTING_SMSF_FUND();

	// function to download doc file
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'download') {
		$objScr->doc_download();	
	}

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing fund details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}

	// case when next button is clicked
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addFundInfo') {
		$fundName = $_REQUEST['txtFund'];
		$abn = $_REQUEST['txtAbn'];
		$streetAdd = $_REQUEST['taStreetAdd'];
		$postalAdd = $_REQUEST['taPostalAdd'];
		$members = $_REQUEST['lstMembers'];
		$trusteeId = $_REQUEST['lstTrustee'];
                $fundStatus = $_REQUEST['fund_status'];
                $jobStatus = $_REQUEST['job_status'];

		// fetch existing fund details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);

		// fetch existing fund details
		if(empty($arrData)) {

			// insert fund details of sign up user
			$flagReturn = $objScr->addFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
		}
		else {
			// edit fund details of sign up user
			$flagReturn = $objScr->editFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
		}

		if($flagReturn) {
                    
                    if(isset($_POST['fund_status']) && $_POST['fund_status'] == 1)
                            header('Location: jobs.php?a=saved');
                    else
			header('Location: jobs.php');
		}
		else {
			echo "Sorry, Please try later.";
		}
	}

	// if data is already entered for current session then set variables
	if(isset($arrData) && !empty($arrData)) {
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
	header('Location: index.php');
}
?>