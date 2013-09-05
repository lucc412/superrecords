<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include(MODEL . "new_smsf_fund_class.php");

	// create class object for class function access
	$objScr = new NEW_SMSF_FUND();

	// function to download doc file
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'download') {
		$objScr->doc_download();	
	}

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}

	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addFundInfo') {
		$fundName = $_REQUEST['txtFund'];
		$streetAdd = $_REQUEST['taStreetAdd'];
		$postalAdd = $_REQUEST['taPostalAdd'];
		$regDate = getDateFormat($_REQUEST['txtSetupDate']);
		$regState = $_REQUEST['lstRegState'];
		$members = $_REQUEST['lstMembers'];
		$trusteeId = $_REQUEST['lstTrustee'];
                $fundStatus = $_REQUEST['fund_status'];

		// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);

		// insert fund details of sign up user
		if(empty($arrData)) {
			$flagReturn = $objScr->addFundInfo($fundName, $streetAdd, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus);
			$arrClient = $objScr->checkClients($fundName);
		}
		// edit fund details of sign up user
		else {
			$flagReturn = $objScr->editFundInfo($fundName, $streetAdd, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus);
		}
                 
		if($flagReturn) 
                {
                	// set no of members allowed in session variable
			if(isset($_SESSION['TRUSTEETYPE'])) unset($_SESSION['TRUSTEETYPE']);
			$_SESSION['TRUSTEETYPE'] = $trusteeId;

			if(isset($_SESSION['NOOFMEMBERS'])) unset($_SESSION['NOOFMEMBERS']);
			$_SESSION['NOOFMEMBERS'] = $members;
                        
                        if(isset($_POST['fund_status']) && $_POST['fund_status'] == 1)
                        {
                            if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                            header('Location: jobs.php?a=saved');
                        }
			else
                            header('Location: new_smsf_member.php');
		}
		else {
			echo "Sorry, Please try later.";
		}
	}

	// if data is already entered for current session then set variables
	if(isset($arrData) && !empty($arrData)) {
		$fundName = $arrData['fund_name'];
		$streetAdd = $arrData['street_address'];
		$postalAdd = $arrData['postal_address'];
		$regDate = $arrData['date_of_establishment'];
		$regState = $arrData['registration_state'];
		$members = $arrData['members'];
		$trusteeType = $arrData['trustee_type_id'];
	}
	else {
		$fundName = "";
		$streetAdd = "";
		$postalAdd = "";
		$regDate = "";
		$regState = "";
		$members = "";
		$trusteeType = "";
	}

	// define array of members
	$arrNoOfMembers = array('1', '2', '3', '4');

	// fetch trustee type for drop-down
	$arrTrusteeType = $objScr->fetchTrusteeType();

	// fetch states for drop-down
	$arrStates = fetchStates();
	 
	// include view file 
	include(VIEW . "new_smsf_fund.php");
}
else {
	header('Location: index.php');
}

?>