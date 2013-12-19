<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("dbclass/commonFunctions_class.php");
include("dbclass/task_rights_class.php");
$objJobRights = new task_rights_class();

if(isset($_REQUEST['sql']))
{
    // Features from database
    $arrChkFeatrs = $objJobRights->checkFeature();
    $arrFilChckList = $_POST['stf_View'];  

    if(!empty($arrFilChckList) && !empty($arrChkFeatrs)) 
    {
        $arrAddChckList = array_diff_assoc($arrFilChckList, $arrChkFeatrs);
        $arrRemChckList = array_diff_assoc($arrChkFeatrs, $arrFilChckList);
    }
    else if(empty($arrFilChckList) && !empty($arrChkFeatrs)) 
    {
        $arrRemChckList = $arrChkFeatrs;
    }
    else if(!empty($arrFilChckList) && empty($arrChkFeatrs)) 
    {
        $arrAddChckList = $arrFilChckList;
    }

    if(!empty($arrRemChckList))
    {
        $objJobRights->removeJobRights($_REQUEST,implode(',',  array_keys($arrRemChckList)));
    }

    if(!empty($arrAddChckList))
    {
        $objJobRights->insertJobRights($_REQUEST,$arrAddChckList);
    }
}



$arrFeatures = $objJobRights->checklistFeature();

include 'views/task_rights.php';

?>
