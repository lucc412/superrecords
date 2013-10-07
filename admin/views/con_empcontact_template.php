<?php
        include 'dbclass/commonFunctions_class.php';
        include 'dbclass/con_empcontact_class.php';
        include 'dbclass/con_empcontact_db_class.php';
		include ("includes/header.php");
        
  if($_SESSION['validUser'])
  {
      if (isset($_GET["order"])) $order = @$_GET["order"];
      if (isset($_GET["type"])) $ordtype = @$_GET["type"];
      if (isset($_POST["filter"])) $filter =str_replace("\'","'",stripslashes(@$_POST["filter"])) ;
      if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
      $wholeonly = false;
      if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
      if (!isset($order) && isset($_SESSION["order"])) $order = $_SESSION["order"];
      if (!isset($ordtype) && isset($_SESSION["type"])) $ordtype = $_SESSION["type"];
      if (!isset($filter) && isset($_SESSION["filter"])) $filter = $_SESSION["filter"];
      if (!isset($filterfield) && isset($_SESSION["filter_field"])) $filterfield = $_SESSION["filter_field"];
    ?>
	<br/>
            <?php
              //Get FormCode
              $formcode=$commonUses->getFormCode("Employee Contact");
              //Call CheckAccess function by passing $_SESSION of staff code and form code
              $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
              if($access_file_level==0)
              {
                //If View, Add, Edit, Delete all set to N
                echo "You are not authorised to view this file.";
              }
              else if(is_array($access_file_level)==1)
              {
                      //If any one of View, Add, Edit, Delete set to Y or N
                      $showrecs = 20;
                      $pagerange = 10;
                      $a = @$_GET["a"];
                      $recid = @$_GET["recid"];
                      $page = @$_GET["page"];
                      if (!isset($page)) $page = 1;
                      $sql = @$_POST["sql"];
                      $mode=@$_GET["mode"];
                      if($mode=="delete")
                         if($access_file_level['stf_Delete']=="Y")
                             {
                                $empcontactDbcontent->sql_delete($_REQUEST['recid']);
                             }
                             else
                             {
                                echo "You are not authorised to delete the record.";
                             }
                      switch ($sql) {
                            case "insert":
                                $empcontactDbcontent->sql_insert();
                            break;
                            case "update":
                                $empcontactDbcontent->sql_update();
                            break;
                       }
                      switch ($a) {
                        case "add":
                          if($access_file_level['stf_Add']=="Y")
                              {
                                    $empcontactContent->addrec();
                              }
                              else
                              {
                                echo "You are not authorised to add a record.";
                              }
                            break;
                        case "view":
                             if($access_file_level['stf_View']=="Y")
                              {
                                    $empcontactContent->viewrec($recid,$access_file_level);
                              }
                               else
                              {
                                echo "You are not authorised to view the record.";
                              }
                          break;
                        case "edit":
                             if($access_file_level['stf_Edit']=="Y")
                              {
                                    $empcontactContent->editrec($recid);
                              }
                               else
                              {
                                echo "You are not authorised to edit record.";
                              }
                          break;
                        default:
                             if($access_file_level['stf_View']=="Y")
                              {
                                    $empcontactContent->select($access_file_level);
                              }
                               else
                              {
                                echo "You are not authorised to view the record.";
                              }
                               break;
                      }
                      if (isset($order)) $_SESSION["order"] = $order;
                      if (isset($ordtype)) $_SESSION["type"] = $ordtype;
                      if (isset($filter)) $_SESSION["filter"] = $filter;
                      if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
                      if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
                      mysql_close();
              }
           
				include("includes/footer.php");
			}  
        else
        {
            header("Location:index.php?msg=timeout");
        }
 ?>
