<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

include("model/member_class.php");
$objMemDtls = new MEMBER();

$arrOffcrData='';

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'country')
{
    $arrCountry = fetchCountries();
    echo $jsonCntry = json_encode($arrCountry);
    exit;    
}

// fetch data if available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

    // fetch existing officer details
    $arrOffcrData = $objMemDtls->fetchOffcrDtls();
}

if(!empty($_REQUEST['sql']))
{
    $no_of_member = $_REQUEST['selOfficers'];
    
    //Reverse Array for deleting officer
    krsort($arrOffcrData);
    
    //Deleting officer id
    $delOffcr = count($arrOffcrData) - $no_of_member;
    if($delOffcr > 0) {
        foreach ($arrOffcrData as $key => $value) {
            if($delOffcr > 0) {
                
                $objMemDtls->delMemberDtls($value['member_id']);
                $delOffcr--;
            }
        }
    }
    
    ksort($arrOffcrData);

    for($i = 1; $i <= $no_of_member; $i++)
    {
        $offcr['selOfficers'] = $_REQUEST['selOfficers'];
        $offcr['offcrId'] = $_REQUEST['offcrId'][$i];
        $offcr['txtFname'] = $_REQUEST['txtFname'][$i];
        $offcr['txtMname'] = $_REQUEST['txtMname'][$i];
        
        $offcr['txtLname'] = $_REQUEST['txtLname'][$i];
        $offcr['txtDob'] = getDateFormat($_REQUEST['txtDob'][$i]);
        
        $offcr['txtCob'] = $_REQUEST['txtCob'][$i];
        $offcr['selCntryob'] = $_REQUEST['selCntryob'][$i];
        $offcr['txtTFN'] = $_REQUEST['txtTFN'][$i];
        $offcr['resAdd'] = $_REQUEST['txtResAdd'][$i];

        if(empty($offcr['offcrId']))
            $objMemDtls->insertMemberDtls($offcr);
        else
            $objMemDtls->updateOffcrDtls($offcr);
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: preview.php');
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



include("view/member.php");
?>