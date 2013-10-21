<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include(MODEL . "new_smsf_member_class.php");

	// create class object for class function access
	$objScr = new NEW_SMSF_MEMBER();
	
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addMemberInfo') 
        {
        	// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
                $legRefernces=0;
		for($memberCount=1; $memberCount <= $_SESSION['NOOFMEMBERS']; $memberCount++) 
                {
                    if(isset($_REQUEST['memberId' . $memberCount]))
                            $memberId = $_REQUEST['memberId' . $memberCount]; 

                    $title = $_REQUEST['lstTitle' . $memberCount];
                    $fname = $_REQUEST['txtFname' . $memberCount];
                    $mname = $_REQUEST['txtMname' . $memberCount];
                    $lname = $_REQUEST['txtLname' . $memberCount];
                    $dob = getDateFormat($_REQUEST['txtDob' . $memberCount]);
                    
                    if((date('Y') - date('Y', strtotime($dob)) < 18 ))
                    {
                        $legRefernces++;
                        $ref = 1;
                    }  
					else {
                        //$legRefernces--;
                        $ref = 0;
                    }
                    
                    $city = $_REQUEST['txtCity' . $memberCount];
                    $country = $_REQUEST['lstCountry' . $memberCount];
                    $gender = $_REQUEST['lstGender' . $memberCount];

                    $StrAddUnit = $_REQUEST['StrAddUnit' . $memberCount];
                    $StrAddBuild = $_REQUEST['StrAddBuild' . $memberCount];
                    $StrAddStreet = $_REQUEST['StrAddStreet' . $memberCount];
                    $StrAddSubrb = $_REQUEST['StrAddSubrb' . $memberCount];
                    $StrAddState = $_REQUEST['StrAddState' . $memberCount];
                    $StrAddPstCode = $_REQUEST['StrAddPstCode' . $memberCount];
                    $StrAddCntry = $_REQUEST['StrAddCntry' . $memberCount];
                    
                    $tfn = $_REQUEST['txtTfn' . $memberCount];
                    $occupation = $_REQUEST['txtOccupation' . $memberCount];
                    $phone = $_REQUEST['txtPhone' . $memberCount];
                    $memberStatus = $_REQUEST['member_status'];
                    
                    // insert member info of sign up user
                    if(empty($memberId)) {
                            $flagReturn = $objScr->addMemberInfo($title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone, $memberStatus, $ref);
                    }
                    else {
                            $flagReturn = $objScr->editMemberInfo($memberId, $title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone, $memberStatus, $ref);
                    }
		}
                
		// check for no. of members records added
		if($flagReturn) 
                {
                
			if($_SESSION['TRUSTEETYPE'] == '1')
			{
                            if(isset($_POST['member_status']) && $_POST['member_status'] == 1)
                            {
                                if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                                header('Location: jobs.php?a=saved');
                            }
                            elseif ($legRefernces > 0) 
                            {
                                header('Location: legal_references.php');
                            }
                            else
                                header('Location: new_smsf_declarations.php');
                        }
			else	
			{
                            if(isset($_POST['member_status']) && $_POST['member_status'] == 1)
                            {
                                if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                                header('Location: jobs.php?a=saved');
                            }
                            elseif ($legRefernces > 0) 
                            {
                                header('Location: legal_references.php');
                            }
                            else
                            {
                                header('Location: new_smsf_trustee.php');
                            }
                        }
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

	// define array of titles
	$arrTitle = array('Dr', 'Mr', 'Mrs', 'Ms', 'Miss');

	// define array of genders
	$arrGender = array('Male', 'Female');

	// fetch country for drop-down
	$arrCountry = $objScr->fetchCountries();
        
        // fetch states for drop-down
        $arrStates = fetchStates();

	// include view file 
	include(VIEW . "new_smsf_member.php");
}
else {
	header('Location: login.php');
}
?>