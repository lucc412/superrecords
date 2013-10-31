<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

include("model/officer_details_class.php");
$objOffDtls = new OFFICER_DETAILS();

$arrOffcrData='';

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'state')
{
    $arrStates = fetchStates();
    echo $jsonStates = json_encode($arrStates);
    exit;    
}

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'country')
{
    $arrCountry = fetchCountries();
    echo $jsonCntry = json_encode($arrCountry);
    exit;    
}

// fetch data if available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

    // fetch existing officer details
    $arrOffcrData = $objOffDtls->fetchOffcrDtls();
}

if(!empty($_REQUEST['sql']))
{
    $no_of_offcr = $_REQUEST['selOfficers'];
    
    //Reverse Array for deleting officer
    krsort($arrOffcrData);
    
    //Deleting officer id
    $delOffcr = count($arrOffcrData) - $no_of_offcr;
    if($delOffcr > 0) {
        foreach ($arrOffcrData as $key => $value) {
            if($delOffcr > 0) {
                
                $objOffDtls->delOffcrDtls($value['offcr_id']);
                $delOffcr--;
            }
        }
    }
    
    ksort($arrOffcrData);

    for($i = 1; $i <= $no_of_offcr; $i++)
    {
        $offcr['selOfficers'] = $_REQUEST['selOfficers'];
        $offcr['offcrId'] = $_REQUEST['offcrId'][$i];
        $offcr['txtFname'] = $_REQUEST['txtFname'][$i];
        $offcr['txtMname'] = $_REQUEST['txtMname'][$i];
        
        $offcr['txtLname'] = $_REQUEST['txtLname'][$i];
        $offcr['txtDob'] = getDateFormat($_REQUEST['txtDob'][$i]);
        
        $offcr['txtCob'] = $_REQUEST['txtCob'][$i];
        $offcr['selSob'] = $_REQUEST['selSob'][$i];
        $offcr['selCntryob'] = $_REQUEST['selCntryob'][$i];
        $offcr['txtTFN'] = $_REQUEST['txtTFN'][$i];
        $offcr['offAddUnit'] = $_REQUEST['offAddUnit'][$i];
        $offcr['offAddBuild'] = $_REQUEST['offAddBuild'][$i];
        $offcr['offAddStreet'] = $_REQUEST['offAddStreet'][$i];
        $offcr['offAddSubrb'] = $_REQUEST['offAddSubrb'][$i];
        $offcr['offAddState'] = $_REQUEST['offAddState'][$i];
        $offcr['offAddPstCode'] = $_REQUEST['offAddPstCode'][$i];

        if(empty($offcr['offcrId']))
            $objOffDtls->insertOffcrDtls($offcr);
        else
            $objOffDtls->updateOffcrDtls($offcr);
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: shareholder_details.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// fetch states for drop-down
$arrStates = fetchStates();

// fetch country for drop-down
$arrCountry = fetchCountries();



include("view/officer_details.php");
?>