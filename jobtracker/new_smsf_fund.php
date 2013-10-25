<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include(MODEL . "new_smsf_fund_class.php");

	// create class object for class function access
	$objScr = new NEW_SMSF_FUND();

	// function to download doc file
	if(isset($_REQUEST['do']) && $_REQUEST['do'] == 'download') 
        {
            showPDFViewer('docs/guide.pdf','guide.pdf');
        }

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) 
        {
        	// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
        }

	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addFundInfo') 
        {
        	$fundName = $_REQUEST['txtFund'];
                
                // Street Address
		$StrAddUnit = $_REQUEST['StrAddUnit'];
                $StrAddBuild = $_REQUEST['StrAddBuild'];
                $StrAddStreet = $_REQUEST['StrAddStreet']; 
                $StrAddSubrb = $_REQUEST['StrAddSubrb'];
                $StrAddState = $_REQUEST['StrAddState'];
                $StrAddPstCode = $_REQUEST['StrAddPstCode'];
                $StrAddCntry = $_REQUEST['StrAddCntry'];
     
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
			$flagReturn = $objScr->addFundInfo($fundName, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus);
			$arrClient = $objScr->checkClients($fundName);
                        
		}
		// edit fund details of sign up user
		else {
			$flagReturn = $objScr->editFundInfo($fundName, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus);
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
                            header('Location: jobs_saved.php');
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
		$StrAddUnit = $arrData['strAddUnit'];
                $StrAddBuild = $arrData['strAddBuild'];
                $StrAddStreet = $arrData['strAddStreet'];
                $StrAddSubrb = $arrData['strAddSubrb'];
                $StrAddState = $arrData['strAddState'];
                $StrAddPstCode = $arrData['strAddPstCode'];
                $StrAddCntry = $arrData['strAddCntry'];
                $postalAdd = $arrData['postal_address'];
		$regDate = $arrData['date_of_establishment'];
		$regState = $arrData['registration_state'];
		$members = $arrData['members'];
		$trusteeType = $arrData['trustee_type_id'];
	}
	else {
		$fundName = "";
		$StrAddUnit = "";
                $StrAddBuild = "";
                $StrAddStreet = "";
                $StrAddSubrb = "";
                $StrAddState = "";
                $StrAddPstCode = "";
                $StrAddCntry = "";
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
	 
        // fetch country
        $arrCountry = $objScr->fetchCountries();
        
	// include view file 
	include(VIEW . "new_smsf_fund.php");
}
else {
	header('Location: login.php');
}

?>