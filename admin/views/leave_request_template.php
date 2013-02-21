<?php  
    ob_start();
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';
    include 'dbclass/leave_request_content_class.php';
    include 'dbclass/leave_request_db_class.php';
    
  if($_SESSION['validUser'])
  {
      if (isset($_GET["order"])) $order = @$_GET["order"];
      if (isset($_GET["type"])) $ordtype = @$_GET["type"];
      if (isset($_POST["filter"])) $filter = @$_POST["filter"];
      if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
      $wholeonly = false;
      if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
      if (!isset($order) && isset($_SESSION["order"])) $order = $_SESSION["order"];
      if (!isset($ordtype) && isset($_SESSION["type"])) $ordtype = $_SESSION["type"];
      if (!isset($filter) && isset($_SESSION["filter"])) $filter = $_SESSION["filter"];
      if (!isset($filterfield) && isset($_SESSION["filter_field"])) $filterfield = $_SESSION["filter_field"];
    ?>
    <html>
        <head>
            <title>Super Records -- leave request form</title>
            <meta name="generator" http-equiv="content-type" >
            <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
            <LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
            <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
            <script language="JavaScript" src="<?php echo $javaScript; ?>leaverequest.js"></script>
         </head>
        <body>
            <?php
            include("includes/header.php");
              //Get FormCode
              $formcode=$commonUses->getFormCode("Leave Request Form");
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
                        $leaverequestDbcontent->sql_delete($_REQUEST['recid']);
                     }
                     else
                     {
                        echo "You are not authorised to delete the record.";
                     }
              switch ($sql) {
                case "insert":
                  $leaverequestDbcontent->sql_insert();
                  break;
                case "update":
                  $leaverequestDbcontent->sql_update();
                  break;
               }
              switch ($a) {
                case "add":
                  if($access_file_level['stf_Add']=="Y")
                      {
                        $leaverequestContent->addrec();
                      }
                      else
                      {
                        echo "You are not authorised to add a record.";
                      }
                  break;
                case "view":
                   if($access_file_level['stf_View']=="Y")
                      {
                        $leaverequestContent->viewrec($recid,$access_file_level);
                      }
                       else
                      {
                        echo "You are not authorised to view the record.";
                      }
                  break;
                case "edit":
                   if($access_file_level['stf_Edit']=="Y")
                      {
                        $leaverequestContent->editrec($recid);
                      }
                       else
                      {
                        echo "You are not authorised to edit record.";
                      }
                  break;
                default:
                  $leaverequestContent->select($access_file_level);
                  break;
              }
              if (isset($order)) $_SESSION["order"] = $order;
              if (isset($ordtype)) $_SESSION["type"] = $ordtype;
              if (isset($filter)) $_SESSION["filter"] = $filter;
              if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
              if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
              mysql_close();
              }
            ?>
        </body>
    </html>
<?php }  
    else
    {
        header("Location:index.php?msg=timeout");
    }
?>
