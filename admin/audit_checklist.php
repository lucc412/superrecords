<?php 
//************************************************************************************************
//  Task          : Controller page which redirect to View, Add or Update page
//  Modified By   : Nishant Bhatt 
//  Created on    : 3-Jan-2014
//  Last Modified : 3-Jan-2014
//************************************************************************************************
ob_start();
include 'dbclass/commonFunctions_class.php';
include 'dbclass/audit_checklist_class.php';
include(PHPFUNCTION);
include("includes/header.php");

// create class object for class function access
$objCallData = new Audit_checklist();

if($_SESSION['validUser']) {

	$formcode = $commonUses->getFormCode("Audit Checklist");
    $access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
	
	//If View, Add, Edit, Delete all set to N
    if($access_file_level == 0 && 0) {
            echo "You are not authorised to view this file.";
    } else {			
	    if (isset($_POST["filter"]) && $_POST['filter']!="") {
			$_SESSION["filter"] = $_POST["filter"];
		} else {
			unset($_SESSION["filter"]);
		}
	    
	    if (isset($_POST["wholeonly"]) && $_POST["wholeonly"]!="") {
			$_SESSION["wholeonly"] = $_POST["wholeonly"];	
		} else {
			unset($_SESSION["wholeonly"]);
		}

	    $a = $_REQUEST["a"];
	    $recid = $_REQUEST["recid"];
	    $sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

	    switch ($sql) {
	            case "insert":                    
						$name = $_REQUEST["txtCheckListName"];
						$parent_ids = $_REQUEST["selParent"];
						$order = $_REQUEST['order'];
						/*if($_REQUEST["selParent"] == 0)
							$order = $objCallData->maxorder_cid() + 1;
						else 
							$order = $objCallData->maxorder_sid() + 1;
						*/
	                    // insert query for add task
	                    $objCallData->sql_insert($name, $order, $parent_ids);
						
						if($_REQUEST["selParent"] == 0)
	                    	header('location: audit_checklist.php');
						else
							header('location: audit_checklist.php?parent_id='.$_REQUEST["selParent"]);
	                    break;

	            case "update":
						//echo "<pre>";print_r($_REQUEST);exit;
						$name = $_REQUEST["txtCheckListName"];
						$parent_ids = $_REQUEST["selParent"];
	                    $id  =$_REQUEST['id'];
						$order = $_REQUEST['order'];
	                    $objCallData->sql_update($name,$parent_ids,$id,$order);
	                    if($_REQUEST["selParent"] == 0)
	                    	header('location: audit_checklist.php');
						else
							header('location: audit_checklist.php?parent_id='.$_REQUEST["selParent"]);
	                    break;
						
				case "order_update":
						//echo "<pre>";print_r($_REQUEST);exit;						
	                    $id = $_REQUEST['id'];
						$order = $_REQUEST['order'];
						$parent_ids = $_REQUEST["parent_ids"];
						
	                    $objCallData->sql_update_order($id,$order, $parent_ids);
	                    if($_REQUEST["parent_ids"] == 0)
	                    	header('location: audit_checklist.php');
						else
							header('location: audit_checklist.php?parent_id='.$_REQUEST["parent_ids"]);
	                    break;

	            case "delete":
						if(isset($_REQUEST['checklist_id'])) {
							$objCallData->sql_delete_checklist($_REQUEST['checklist_id']);	
						}
	                    if(isset($_REQUEST['subchecklist_id'])) {
							$objCallData->sql_delete_subchecklist($_REQUEST['subchecklist_id']);	
						}
	                    
						if(isset($_REQUEST["parent_id"]))
	                    	header('location: audit_checklist.php?parent_id='.$_REQUEST["parent_id"]);
						else
							header('location: audit_checklist.php');
	                    break;
	    }

	    switch ($a) {
	    case "add":
				$arrChecklist = $objCallData->fetchChecklist();	
				$order = $objCallData->maxorder_cid();		
	            include('views/audit_checklist_add.php');
	            break;    

	    case "edit":
	           	$arrChecklist = $objCallData->fetchChecklist();
				
				if(isset($_REQUEST['pid'])){
					$arrData = $objCallData->getFetchSubCheckListById($_REQUEST['id']);
					$order = $objCallData->maxorder_sid($_REQUEST['pid']);
				} else {
					$arrData = $objCallData->getFetchCheckListById($_REQUEST['id']);
					$order = $objCallData->maxorder_cid();
				}				
					
				//echo "<pre>";		print_r($arrData);
	            include('views/audit_checklist_edit.php');
	            break;

		case "order":
				if(isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] > 0){
					$arrChecklist = $objCallData->fetchSubChecklist($_REQUEST['parent_id']);	
				} else {
					$arrChecklist = $objCallData->fetchChecklist();	
				}                    
                include('views/audit_checklist_order.php');
				break;
				
	    case "reset":
				unset($_SESSION["filter"]);
				unset($_SESSION["wholeonly"]);
				$pid = isset($_REQUEST['parent_id'])?"?parent_id=".$_REQUEST['parent_id']:"";
                header("Location: audit_checklist.php".$pid);
	            break;

	    default:
	            $formcode = $commonUses->getFormCode("Audit Checklist");
	            $access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

	            //If View, Add, Edit, Delete all set to N
	            if($access_file_level == 0 && 0) {
	                    echo "You are not authorised to view this file.";
	            }
	            else 
				{
						if(isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] > 0){
							$arrChecklist = $objCallData->fetchSubChecklist($_REQUEST['parent_id']);	
							$arrCount = $objCallData->maxorder_sid($_REQUEST['parent_id']);
							if(isset($_REQUEST['reset'])){
								unset($_SESSION["filter"]);
								unset($_SESSION["wholeonly"]);
							}
						} else {
							$arrChecklist = $objCallData->fetchChecklist();	
							$arrCount = $objCallData->maxorder_cid();
						}                    
	                    include('views/audit_checklist.php');
	            }
	            break;
	    }
	}
    include("includes/footer.php");	
}  
else {
	header("Location:index.php?msg=timeout");
}
?>