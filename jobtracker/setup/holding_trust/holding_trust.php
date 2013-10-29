<?php
// include common file
include("../../include/common.php");

// include class file
include("model/holding_trust_class.php");
$objHoldingTrust = new Holding_Trust();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objHoldingTrust->fetchHoldingTrustDetails();
    if($arrHoldTrust['trustee_id'] == '1') $arrIndvdlTrust = $objHoldingTrust->fetchIndividualTrustDetails();
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    // update holding trust details
    if(!empty($arrHoldTrust)) {
        // for individual trust
        if($_REQUEST['lstType'] == '1') {
            $cntMember = $_REQUEST['lstMember'];
            $trust = $_REQUEST['txtTrust'];
            $trusteeId = $_REQUEST['lstType'];
            
            foreach($_REQUEST AS $eleName => $eleValue) {
                if(strstr($eleName, "txtTrusteeName")) $arrTrusteeData[replaceString('txtTrusteeName', '', $eleName)]['name'] = $eleValue; 
                if(strstr($eleName, "txtResAdd")) $arrTrusteeData[replaceString('txtResAdd', '', $eleName)]['address'] = $eleValue;
                if(strstr($eleName, "indvdlId")) $arrTrusteeData[replaceString('indvdlId', '', $eleName)]['indvdlId'] = $eleValue;
            }
            if(!empty($arrIndvdlTrust) && !empty($arrTrusteeData)) {
                $arrAddMember = array_diff_assoc($arrTrusteeData, $arrIndvdlTrust);
                $arrRemMember = array_diff_assoc($arrIndvdlTrust, $arrTrusteeData);
            }
            else if(empty($arrIndvdlTrust) && !empty($arrTrusteeData)) {
                $arrAddMember = $arrTrusteeData;
            }
            
            $objHoldingTrust->updateHoldingTrustIndividual($trust, $trusteeId, $cntMember, $arrAddMember, $arrRemMember);
            if(isset($_REQUEST['next'])) {
                header('location: trust_fund.php');
                exit;
            }
            else if(isset($_REQUEST['save'])) {
                header('location: ../../jobs_saved.php');
                exit;
            }
        }
        // for corporate trust
        else if($_REQUEST['lstType'] == '2') {
            $trust = $_REQUEST['txtTrust'];
            $trusteeId = $_REQUEST['lstType'];
            $compName = $_REQUEST['txtCompName'];
            $acn = $_REQUEST['txtAcn'];
            $address = $_REQUEST['txtAdd'];

            foreach($_REQUEST AS $eleName => $eleValue) {
                if(!empty($eleValue)) if(strstr($eleName, "dir")) $arrDir[] = $eleValue;
            }
            $directors = arrayToString('|', $arrDir);

            $objHoldingTrust->updateHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors);
            if(isset($_REQUEST['next'])) {
                header('location: trust_fund.php');
                exit;
            }
            else if(isset($_REQUEST['save'])) {
                header('location: ../../jobs_saved.php');
                exit;
            }
        }
    }
    // insert holding trust details
    else {
        $jobId = $objHoldingTrust->insertNewJob();
        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
        $_SESSION['jobId'] = $jobId;
        
        // for individual trust
        if($_REQUEST['lstType'] == '1') {
            $cntMember = $_REQUEST['lstMember'];
            $trust = $_REQUEST['txtTrust'];
            $trusteeId = $_REQUEST['lstType'];
            
            foreach($_REQUEST AS $eleName => $eleValue) {
                if(strstr($eleName, "txtTrusteeName")) $arrTrusteeData[replaceString('txtTrusteeName', '', $eleName)]['name'] = $eleValue; 
                if(strstr($eleName, "txtResAdd")) $arrTrusteeData[replaceString('txtResAdd', '', $eleName)]['address'] = $eleValue;
            }
            $objHoldingTrust->newHoldingTrustIndividual($trust, $trusteeId, $cntMember, $arrTrusteeData);
        }
        // for corporate trust
        else if($_REQUEST['lstType'] == '2') {
            $trust = $_REQUEST['txtTrust'];
            $trusteeId = $_REQUEST['lstType'];
            $compName = $_REQUEST['txtCompName'];
            $acn = $_REQUEST['txtAcn'];
            $address = $_REQUEST['txtAdd'];
            
            foreach($_REQUEST AS $eleName => $eleValue) {
                if(!empty($eleValue)) if(strstr($eleName, "dir")) $arrDir[] = $eleValue;
            }
            $directors = arrayToString('|', $arrDir);
            
            $objHoldingTrust->newHoldingTrustCorporate($trust, $trusteeId, $compName, $acn, $address, $directors);
        }
        
        if(isset($_REQUEST['next'])) {
            header('location: trust_fund.php');
            exit;
        }
        else if(isset($_REQUEST['save'])) {
            header('location: ../../jobs_saved.php');
            exit;
        }
    }
}

// fetch holding trustee types
$arrTrusteeType = $objHoldingTrust->fetchTrusteeType();

// include view file
include("view/holding_trust.php");

?>