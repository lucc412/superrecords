<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

//include class file address_details_class.php
include("model/shareholder_details_class.php");
$objShrHdlrDtls = new SHAREHOLDER_DETAILS;

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'share_class')
{
    $arrShrCls = $objShrHdlrDtls->fetchShareClass();
    echo $jsnShrCls = json_encode($arrShrCls);
    exit;    
}
$arrshrhldrDtls = $objShrHdlrDtls->fetchShrhldrDtls();

if(!empty($_REQUEST['sql']) && $_REQUEST['sql'] == 'Add')
{
    
    $no_of_shrhldr = $_REQUEST['selShrHldr'];
    
    showArray($_REQUEST);
    for($i = 1; $i <= $no_of_shrhldr; $i++)
    {
        $shrhldr['shrhldr_id'] = $_REQUEST['shrhldrId'][$i];
        $shrhldr['job_id'] = $_SESSION['jobId'];
        $shrhldr['no_of_shrhldr'] = $no_of_shrhldr;
        $shrhldr['shrhldr_type'] = $_REQUEST['selShrType'][$i];
        
        //For corporate shareholder
        if($shrhldr['shrhldr_type'] == 1)
        $shrhldr['shrhldr_cmpny_name'] = $_REQUEST['txtCmpName'][$i];
        $shrhldr['shrhldr_acn'] = $_REQUEST['txtACN'][$i];
        $shrhldr['shrhldr_reg_addr'] = $_REQUEST['txtRegAddr'][$i];
        $shrhldr['no_of_directrs'] = $_REQUEST['selNoDirtr'][$i];
        $shrhldr['directrs_name'] = $_REQUEST['txtFulName'][$i];
        
        //For individual shareholder
        if($shrhldr['shrhldr_type'] == 2)
        $shrhldr['shrhldr_fname'] = $_REQUEST['txtFname'][$i];
        $shrhldr['shrhldr_mname'] = $_REQUEST['txtMname'][$i];
        $shrhldr['shrhldr_lname'] = $_REQUEST['txtLname'][$i];
        $shrhldr['res_addr_unit'] = $_REQUEST['resAddUnit'][$i];
        $shrhldr['res_addr_build'] = $_REQUEST['resAddBuild'][$i];
        $shrhldr['res_addr_street'] = $_REQUEST['resAddStreet'][$i];
        $shrhldr['res_addr_subrb'] = $_REQUEST['resAddSubrb'][$i];
        $shrhldr['res_addr_state'] = $_REQUEST['resAddState'][$i];
        $shrhldr['res_addr_pcode'] = $_REQUEST['resAddPstCode'][$i];
        
        $shrhldr['share_class'] = $_REQUEST['selShrCls'][$i];
        $shrhldr['is_shars_own_bhlf'] = $_REQUEST['selShrBhlf'][$i];
        $shrhldr['shars_own_bhlf'] = $_REQUEST['txtShrOwnBhlf'][$i];
        $shrhldr['no_of_shares'] = $_REQUEST['txtNoShares'][$i];
        
        
        if(empty($shrhldr['shrhldr_id']))
            $objShrHdlrDtls->insertShrhldrDtls($shrhldr);
        else
            $objShrHdlrDtls->updateShrhldrDtls($shrhldr);
    }

//    $no_of_offcr = $_REQUEST['selOfficers'];
//    
//    //Reverse Array for deleting officer
//    krsort($arrOffcrData);
//    
//    //Deleting officer id
//    $delOffcr = count($arrOffcrData) - $no_of_offcr;
//    if($delOffcr > 0) {
//        foreach ($arrOffcrData as $key => $value) {
//            if($delOffcr > 0) {
//                
//                $objOffDtls->delOffcrDtls($key);
//                $delOffcr--;
//            }
//        }
//    }
//    
//    ksort($arrOffcrData);
//    
//    for($i = 1; $i <= $no_of_offcr; $i++)
//    {
//        $offcr['selOfficers'] = $_REQUEST['selOfficers'];
//        $offcr['offcrId'] = $_REQUEST['offcrId'][$i];
//        $offcr['txtFname'] = $_REQUEST['txtFname'][$i];
//        $offcr['txtMname'] = $_REQUEST['txtMname'][$i];
//        
//        $offcr['txtLname'] = $_REQUEST['txtLname'][$i];
//        $offcr['txtDob'] = getDateFormat($_REQUEST['txtDob'][$i]);
//        
//        $offcr['txtCob'] = $_REQUEST['txtCob'][$i];
//        $offcr['selSob'] = $_REQUEST['selSob'][$i];
//        $offcr['selCntryob'] = $_REQUEST['selCntryob'][$i];
//        $offcr['txtTFN'] = $_REQUEST['txtTFN'][$i];
//        $offcr['offAddUnit'] = $_REQUEST['offAddUnit'][$i];
//        $offcr['offAddBuild'] = $_REQUEST['offAddBuild'][$i];
//        $offcr['offAddStreet'] = $_REQUEST['offAddStreet'][$i];
//        $offcr['offAddSubrb'] = $_REQUEST['offAddSubrb'][$i];
//        $offcr['offAddState'] = $_REQUEST['offAddState'][$i];
//        $offcr['offAddPstCode'] = $_REQUEST['offAddPstCode'][$i];
//        
//        if(empty($offcr['offcrId']))
//            $objOffDtls->insertOffcrDtls($offcr);
//        else
//            $objOffDtls->updateOffcrDtls($offcr);
//    }
    
    exit;
    //header("location:declaration_details.php");
}


// fetch states for drop-down
$arrStates = fetchStates();

include("view/shareholder_details.php");
?>
