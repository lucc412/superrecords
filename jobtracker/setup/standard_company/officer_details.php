<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

if(!empty($_REQUEST['sql']) && $_REQUEST['sql'] == 'Add')
{
    include("model/officer_details_class.php");
    $objOffDtls = new OFFICER_DETAILS();
    
    //$objAddrDtls->insertAddrDtls();
}

// fetch states for drop-down
$arrStates = fetchStates();

include("view/officer_details.php");
?>