<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

include("model/member_class.php");
$objMemDtls = new MEMBER();

$arrMembrData='';

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'country')
{
    $arrCountry = fetchCountries();
    echo $jsonCntry = json_encode($arrCountry);
    exit;    
}

$trusteeType = $objMemDtls->fetchTrustType();
if($trusteeType == '1') $memeberStartCnt = 2;
else $memeberStartCnt = 1;

// fetch data if available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

    // fetch existing officer details
    $arrMembrData = $objMemDtls->fetchMemberDtls();
}

if(!empty($_REQUEST['sql']))
{
    $no_of_member = $_REQUEST['selMembers'];
    
    //Reverse Array for deleting officer
    krsort($arrMembrData);
    
    //Deleting officer id
    $delMember = count($arrMembrData) - $no_of_member;
    if($delMember > 0) {
        foreach ($arrMembrData as $key => $value) {
            if($delMember > 0) {
                
                $objMemDtls->delMemberDtls($value['member_id']);
                $delMember--;
            }
        }
    }
    
    ksort($arrMembrData);

    for($i = 1; $i <= $no_of_member; $i++)
    {
        $member['selMembers'] = $_REQUEST['selMembers'];
        $member['offcrId'] = $_REQUEST['offcrId'][$i];
        $member['txtFname'] = $_REQUEST['txtFname'][$i];
        $member['txtMname'] = $_REQUEST['txtMname'][$i];
        
        $member['txtLname'] = $_REQUEST['txtLname'][$i];
        $member['txtDob'] = getDateFormat($_REQUEST['txtDob'][$i]);
        
        $member['txtCob'] = $_REQUEST['txtCob'][$i];
        $member['selCntryob'] = $_REQUEST['selCntryob'][$i];
        $member['txtTFN'] = $_REQUEST['txtTFN'][$i];
        $member['resAdd'] = $_REQUEST['txtResAdd'][$i];

        if(empty($member['offcrId']))
            $objMemDtls->insertMemberDtls($member);
        else
            $objMemDtls->updateMemberDtls($member);
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

// include view file
include("view/member.php");
?>