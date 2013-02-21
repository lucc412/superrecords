<?php 
ob_start();
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';
    include 'dbclass/timesheet_report_db_class.php';
    include 'dbclass/timesheet_report_content_class.php';
    
  if($_SESSION['validUser'])
  {
          if (isset($_GET["order"])) $order = @$_GET["order"];
          if (isset($_GET["type"])) $ordtype = @$_GET["type"];
          if (isset($_POST["filter"])) $filter = @$_POST["filter"];
          if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
          $wholeonly = false;
          if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
          if ($_GET['a'] == "reset")
          {
                  $_SESSION["tis_FromDate"] = "";
                  $_SESSION["Submit"] = "";
                  $_SESSION["tis_ClientCode"] = "";
                  $_SESSION["tis_ClientName"] = "";
                  $_SESSION["tis_ToDate"] ="";
                  $_SESSION["tis_StaffList"] = "";
                  $_SESSION["tis_StatusList"] = "";
                  $_SESSION["tis_MasterActivityList"] ="";
                  $_SESSION["tis_SubActivityList"] = "";
                  $_SESSION["order"] = "";
                  $_SESSION["type"] = "";
                  $_SESSION["query"] = "";
         }
          if (isset($_POST['order'])) $_SESSION["order"] = $_GET['order'];
          if (isset($_POST['ordtype'])) $_SESSION["ordtype"] = $_GET['type'];
          if($_POST['Submit']=="Generate Report" || $_POST['Submit']=="Generate Excel Report" )
          {
                  $_SESSION["tis_FromDate"] = "";
                  $_SESSION["Submit"] = "";
                  $_SESSION["tis_ClientCode"] = "";
                  $_SESSION["tis_ClientName"] = "";
                  $_SESSION["tis_ToDate"] ="";
                  $_SESSION["tis_StaffList"] = "";
                  $_SESSION["tis_StatusList"] = "";
                  $_SESSION["tis_MasterActivityList"] ="";
                  $_SESSION["tis_SubActivityList"] = "";
                  $_SESSION["order"] = "";
                  $_SESSION["type"] = "";

          if (isset($_POST['Submit'])  || isset($_SESSION['Submit'])) $_SESSION["Submit"] = $_POST['Submit'];
          if (isset($_POST['tis_FromDate'])  || isset($_SESSION['tis_FromDate'])) $_SESSION["tis_FromDate"] = $_POST['tis_FromDate'];
          if (isset($_POST['tis_ClientCode'])  || isset($_SESSION['tis_ClientCode'])) $_SESSION["tis_ClientCode"] = $_POST['tis_ClientCode'];
          if (isset($_POST['tis_ClientName'])  || isset($_SESSION['tis_ClientName']))   $_SESSION["tis_ClientName"] = $_POST['tis_ClientName'];
          if (isset($_POST['tis_ToDate'])  || isset($_SESSION['tis_ToDate'])) $_SESSION["tis_ToDate"] =$_POST['tis_ToDate'];
          if (isset($_POST['tis_StaffList'])  || isset($_SESSION['tis_StaffList'])) $_SESSION["tis_StaffList"] = $_POST['tis_StaffList'];
          if (isset($_POST['tis_StatusList'])  || isset($_SESSION['tis_StatusList'])) $_SESSION["tis_StatusList"] = $_POST['tis_StatusList'];
          if (isset($_POST['tis_MasterActivityList'])  || isset($_SESSION['tis_MasterActivityList'])) $_SESSION["tis_MasterActivityList"] = $_POST['tis_MasterActivityList'];
          if (isset($_POST['tis_SubActivityList'])  || isset($_SESSION['tis_SubActivityList'])) $_SESSION["tis_SubActivityList"] = $_POST['tis_SubActivityList'];
          }
          ?>
        <html>
            <head>
                <title>Time Sheet</title>
                 <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" /> <LINK href="stylesheet/Style.css" rel="stylesheet" type="text/css">
                <style type="text/css">
                    @media print {

                        p#printscreen {
                            display:block;
                         }
                        div#notprint {
                            display:none;
                        }
                         th#notprint {
                            display:none;
                        }
                         td#notprint {
                            display:none;
                        }

                    }
                </style>
                <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
                <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
                <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
                <script language="JavaScript" src="<?php echo $javaScript; ?>timesheet_report.js"></script>
            </head>
            <body>
                <?php include ("includes/header.php");
                  //Get FormCode
                  $formcode=$commonUses->getFormCode("Timesheet");
                  $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                  //Get FormCode
                  $formcode_report=$commonUses->getFormCode("Timesheet Report");
                //  //Call CheckAccess function by passing $_SESSION of staff code and form code
                  $access_file_level_report=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_report);
                  if($access_file_level_report==0)
                  {
                  //If View, Add, Edit, Delete all set to N
                  echo "You are not authorised to view this file.";
                  }
                  else if(is_array($access_file_level_report)==1)
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
                     if($access_file_level_report['stf_Delete']=="Y")
                         {
                            $timesheetReportDbcontent->sql_delete($_REQUEST['recid']);
                         }
                         else
                         {
                     echo "You are not authorised to delete the record.";
                         }

                  switch ($a) {
                    default:
                         if($access_file_level_report['stf_View']=="Y")
                          {
                                $timesheetReportContent->select($access_file_level_report);
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
<?php }  
        else
        {
            header("Location:index.php?msg=timeout");
        }
?>
