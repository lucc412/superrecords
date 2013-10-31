<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

//include class file address_details_class.php
include("model/shareholder_details_class.php");
$objShrHdlrDtls = new SHAREHOLDER_DETAILS;

$arrshrhldrDtls = '';

if(!empty($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'share_class')
{
    $arrShrCls = $objShrHdlrDtls->fetchShareClass();
    echo $jsnShrCls = json_encode($arrShrCls);
    exit;    
}

// fetch data if available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

    // fetch existing officer details
    $arrShrhldrDtls = $objShrHdlrDtls->fetchShrhldrDtls();
}


if(!empty($_REQUEST['sql']) && $_REQUEST['sql'] == 'Add')
{
    
    $no_of_shrhldr = $_REQUEST['selShrHldr'];
    
    
    //Reverse Array for deleting officer
    krsort($arrShrhldrDtls);
    
    //Deleting officer id
    $delShrhldr = count($arrShrhldrDtls) - $no_of_shrhldr;
    if($delShrhldr > 0) {
        foreach ($arrShrhldrDtls as $key => $value) {
            if($delShrhldr > 0) {
                
                $objShrHdlrDtls->delShrhldrDtls($value['shrhldr_id']);
                $delShrhldr--;
            }
        }
    }
    
    ksort($arrShrhldrDtls);
    
    for($i = 1; $i <= $no_of_shrhldr; $i++)
    {
        $shrhldr['shrhldr_id'] = $_REQUEST['shrhldrId'][$i];
        $shrhldr['job_id'] = $_SESSION['jobId'];
        $shrhldr['no_of_shrhldr'] = $no_of_shrhldr;
        $shrhldr['shrhldr_type'] = $_REQUEST['selShrType'][$i];
        
        //For corporate shareholder
                
        $shrhldr['shrhldr_cmpny_name'] = $_REQUEST['txtCmpName'][$i];
        $shrhldr['shrhldr_acn'] = $_REQUEST['txtACN'][$i];
        $shrhldr['shrhldr_reg_addr'] = $_REQUEST['txtRegAddr'][$i];
        $shrhldr['no_of_directrs'] = $_REQUEST['selNoDirtr'][$i];
        
        //if(is_array($_REQUEST['txtFulName'][$i]))
        if($shrhldr['no_of_directrs'] > 0)    
            $shrhldr['directrs_name'] = implode(',',$_REQUEST['txtFulName'][$i]);
        else
            $shrhldr['directrs_name'] = $_REQUEST['txtFulName'][$i];
            
        
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
//        $shrhldr['is_shars_own_bhlf'] = $_REQUEST['selShrBhlf'][$i];
//        $shrhldr['shars_own_bhlf'] = $_REQUEST['txtShrOwnBhlf'][$i];
        $shrhldr['no_of_shares'] = $_REQUEST['txtNoShares'][$i];
        
        
        if(empty($shrhldr['shrhldr_id']))
            $objShrHdlrDtls->insertShrhldrDtls($shrhldr);
        else
            $objShrHdlrDtls->updateShrhldrDtls($shrhldr);
    }
    
    if(!empty($_REQUEST['btnNext']))
        header("location:preview.php");
    
    if(!empty($_REQUEST['btnSave']))
        header("location:../../jobs_saved.php");
}


// fetch states for drop-down
$arrStates = fetchStates();

// fetch share class for drop-down
$arrShrCls = $objShrHdlrDtls->fetchShareClass();

include("view/shareholder_details.php");
?>
