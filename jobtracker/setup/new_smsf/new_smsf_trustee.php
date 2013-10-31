<?

// include common file
include("../../include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include("model/new_smsf_trustee_class.php");

	// create class object for class function access
	$objScr = new NEW_SMSF_TRUSTEE();

	// define array
	$arrYesNo = array('Yes', 'No');
        $arrLegRef = $objScr->checkLegalRef();
        
	// case of Trustee Type - New Trustee
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addNewTrusteeInfo') {
		$cName = $_REQUEST['txtCname'];
		$name1 = $_REQUEST['txtName1'];
		$name2 = $_REQUEST['txtName2'];
		$regAddress = $_REQUEST['txtRegAddress'];
		$priAddress = $_REQUEST['txtPriAddress'];
                $newTrstStats = $_REQUEST['newTrust_status'];
		$jobId = $_SESSION["jobId"];

		// fetch new trustee data
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
		
		// insert new trustee details
		if(empty($arrData)) {
			$flagReturn = $objScr->addNewTrustee($jobId, $cName, $name1, $name2, $regAddress, $priAddress, $newTrstStats);
		}
		else {
			$flagReturn = $objScr->editNewTrustee($cName, $name1, $name2, $regAddress, $priAddress, $newTrstStats);
		}

		if($flagReturn)
		{
                    if(isset($_POST['newTrust_status']) && $_POST['newTrust_status'] == 1)
                    {
                        if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                        header('Location: ../../jobs_saved.php');
                    }
                    else
			header('Location: new_smsf_declarations.php');
		}
		else
		{
			echo "Sorry, Please try later.";
		}
	}
	// case of Trustee Type - Existing Trustee
	else if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addExsTrusteeInfo') 
        {
		$cName = $_REQUEST['txtCname'];
		$acn = $_REQUEST['txtAcn'];
		$abn = $_REQUEST['txtAbn'];
		$tfn = $_REQUEST['txtTfn'];
		$regAddress = $_REQUEST['txtRegAddress'];
		$priAddress = $_REQUEST['txtPriAddress'];
		$yesNo = $_REQUEST['lstQuestion'];
                $extTrstStats = $_REQUEST['extTrust_status'];
                $jobId = $_SESSION["jobId"];

		// fetch existing trustee data
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
		
		// insert existing trustee details
		if(empty($arrData)) {
			$flagReturn = $objScr->addExistingTrustee($jobId, $cName, $acn, $abn, $tfn, $regAddress, $priAddress, $yesNo, $extTrstStats);
		}
		// edit existing trustee details
		else {
			$flagReturn = $objScr->editExistingTrustee($cName, $acn, $abn, $tfn, $regAddress, $priAddress, $yesNo, $extTrstStats);
		}	

		if($flagReturn) {
                    if(isset($_POST['extTrust_status']) && $_POST['extTrust_status'] == 1)
                    {
                        if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                        header('Location: ../../jobs_saved.php');
                    }
                    else
			header('Location: new_smsf_declarations.php');
		}
		else {
			echo "Sorry, Please try later.";
		}
	}

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}

	// if data is already entered for current session then set variables for New Trustee
	if($_SESSION['TRUSTEETYPE'] == '2') {
		if(isset($arrData) && !empty($arrData)) {
			$cname = $arrData['company_name'];
			$altOption1 = $arrData['alternative_name1'];
			$altOption2 = $arrData['alternative_name2'];
			$regAdd = $arrData['office_address'];
			$priBusiness = $arrData['business_address'];
		}
		// declare variables
		else {
			$cname = "";
			$altOption1 = "";
			$altOption2 = "";
			$regAdd = "";
			$priBusiness = "";
		}
	}
	// if data is already entered for current session then set variables for Existing Trustee
	else if($_SESSION['TRUSTEETYPE'] == '3') {
		if(isset($arrData) && !empty($arrData)) {
			$cname = $arrData['company_name'];
			$acn = $arrData['acn'];
			$abn = $arrData['abn'];
			$tfn = $arrData['tfn'];
			$regAdd = $arrData['office_address'];
			$priBusiness = $arrData['business_address'];
			$memberType = $arrData['yes_no'];
		}
		// declare variables
		else {
			$cname = "";
			$acn = "";
			$abn = "";
			$tfn = "";
			$regAdd = "";
			$priBusiness = "";
			$memberType = "";
		}
	}


	// include view file
	include("view/new_smsf_trustee.php");
}
else {
	header('Location: ../../login.php');
}
?>