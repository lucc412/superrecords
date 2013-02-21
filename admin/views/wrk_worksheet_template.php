<?php 
    include("dbclass/commonFunctions_class.php");
    include("dbclass/worksheet_db_class.php");
    include("dbclass/worksheet_content_class.php");
    include("dbclass/client_mail_class.php");
    include("common/varDeclare.php");
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
            <title>Super Records -- wrk_worksheet</title>
            <meta name="generator" http-equiv="content-type"  >
            <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
            <LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
            <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
            <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
            <script language="JavaScript" src="<?php echo $javaScript; ?>worksheet.js"></script>
        </head>
        <body>
                <?php
                if($_GET['a']!="copy") { ?>
                    <LINK href="<?php echo $styleSheet ; ?>Style.css" rel="stylesheet" type="text/css">
                    <?php
                    include ("includes/header.php");
                }
                  $formcode=$commonUses->getFormCode("Worksheet");
                  //Call CheckAccess function by passing $_SESSION of staff code and form code
                  $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
				  $_SESSION['access_file_level'] = $access_file_level;
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
                      $page_records = @$_GET["page_records"];
                      if (!isset($page)) $page = 1;
                      if (!isset($page_records)) $page_records = 1;
                      $sql = @$_POST["sql"];
                      $mode=@$_GET["mode"];
                      // grid update
                      if($_GET['workcode']!="") {
                          $worksheetQuery->gridUpdate();
                      }
                      if($mode=="delete")
                      {
                        if($access_file_level['stf_Delete']=="Y")
                             {
                                $worksheetQuery->sql_delete($_REQUEST['recid']);
                             }
                             else
                             {
                                echo "You are not authorised to delete the record.";
                             }
                        //$page = @$_GET["page"];
                        $page_records = 1;
                      }
                      if($_POST['submit']=="Delete")
                      {
                          $worksheetQuery->delRecord();
                      }
                      switch ($sql) {
                        case "insert":
                          $worksheetQuery->sql_insert();
                          break;
                        case "update":
                          $worksheetQuery->sql_update();
                          break;
                      }
                      switch ($a) {
                        case "add":
                         if($access_file_level['stf_Add']=="Y")
                              {
                                    $worksheetContent->addrec();
                              }
                              else
                              {
                                echo "You are not authorised to add a record.";
                              }
                            break;
                          break;
                        case "view":
                          if($access_file_level['stf_View']=="Y")
                              {
                                  $worksheetContent->viewrec($recid,$access_file_level);
                              }
                               else
                              {
                                echo "You are not authorised to view the record.";
                              }
                          break;
                        case "edit":
                        if($access_file_level['stf_Edit']=="Y")
                              {
                                    $worksheetContent->editrec($recid);
                              }
                               else
                              {
                                echo "You are not authorised to edit record.";
                              }
                          break;
                        case "copy":
                            $worksheetContent->copyrec($_GET['copid']);
                            break;
                        default:
                         if($access_file_level['stf_View']=="Y")
                              {
                                $worksheetContent->select_clients($access_file_level);
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
                ?>
        </body>
    </html>
    <?php
     if($_GET['client'] > 0)
           {
            $clientCode = $_GET['client'];
            if($filter=="") $filter = '0';
            if($filterfield=="") $filterfield = '0';
            if($wholeonly=="") $wholeonly = '0';
            echo "<script>alert('yes');enable_divs('$clientCode','$filter','$filterfield','$wholeonly'); <script>";
           }
}  
else
{
    header("Location:index.php?msg=timeout");
}
?>
