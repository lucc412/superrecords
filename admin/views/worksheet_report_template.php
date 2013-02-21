<?php 
ob_start();
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';
    include 'dbclass/worksheet_report_db_class.php';
    include 'dbclass/worksheet_report_content_class.php';

  if (isset($_GET["order"])) $order =  @$_GET["order"];
  if (isset($_GET["type"])) $ordtype = @$_GET["type"];
  if (isset($_POST["filter"])) $filter = @$_POST["filter"];
  if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
  $wholeonly = false;
  if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
  if ($_GET['a'] == "reset")  
  {
	 $_SESSION["wrk_FromDate"] 			= "";
	 $_SESSION["wrk_ToDate"] 			="";
	 $_SESSION["wrk_ExdateFrom"] 			= "";
	 $_SESSION["wrk_ExdateTo"] 			="";
	 $_SESSION["wrk_ClientCode"] 			= "";
	 $_SESSION["wrk_ClientName"] 			= "";
	 $_SESSION["wrk_StaffCode"] 			="";
	 $_SESSION["wrk_StaffList"] 			="";
	 $_SESSION["wrk_TeamList"] 			= "";
	 $_SESSION["wrk_ManagerList"] 			= "";
         $_SESSION["wrk_SeniorList"] 			= "";
	 $_SESSION["wrk_StatusList"] 			= "";
	 $_SESSION["wrk_MasterActivityList"]            ="";
	 $_SESSION["wrk_SubActivityList"] 		= "";
         $_SESSION["cli_Category"]                      = "";
	 $_SESSION["order"] 				= "";
	 $_SESSION["type"] 				= "";
	 $_SESSION["Submit"]				= "";
         $_SESSION["query"]                             = "";
 } 
  if($_POST['Submit']=="Generate Report" || $_POST['Submit']=="Generate Excel Report" )
  {
	 $_SESSION["wrk_FromDate"] 			= "";
	 $_SESSION["wrk_ToDate"] 			="";
	 $_SESSION["wrk_ExdateFrom"] 			= "";
	 $_SESSION["wrk_ExdateTo"] 			="";
	 $_SESSION["wrk_ClientCode"] 			= "";
	 $_SESSION["wrk_ClientName"] 			= "";
	 $_SESSION["wrk_StaffCode"] 			="";
	 $_SESSION["wrk_StaffList"] 			="";
	 $_SESSION["wrk_TeamList"] 			= "";
	 $_SESSION["wrk_ManagerList"] 			= "";
         $_SESSION["wrk_SeniorList"] 			= "";
	 $_SESSION["wrk_StatusList"] 			= "";
	 $_SESSION["wrk_MasterActivityList"]            ="";
	 $_SESSION["wrk_SubActivityList"] 		= "";
         $_SESSION["cli_Category"]                      = "";
	 $_SESSION["order"] 				= "";
	 $_SESSION["type"] 				= "";
	 $_SESSION["Submit"]				= "";
         $_SESSION["query"]                             = "";

  if (isset($_POST['wrk_FromDate']) || isset($_SESSION['wrk_FromDate'])) 			$_SESSION["wrk_FromDate"] 			= $_POST['wrk_FromDate'];
  if (isset($_POST['wrk_ToDate'])  || isset($_SESSION["wrk_ToDate"])) 				$_SESSION["wrk_ToDate"] 			=$_POST['wrk_ToDate'];
  if (isset($_POST['wrk_ExdateFrom']) || isset($_SESSION['wrk_ExdateFrom'])) 			$_SESSION["wrk_ExdateFrom"] 			= $_POST['wrk_ExdateFrom'];
  if (isset($_POST['wrk_ExdateTo'])  || isset($_SESSION["wrk_ExdateTo"])) 			$_SESSION["wrk_ExdateTo"] 			=$_POST['wrk_ExdateTo'];
  if (isset($_POST['wrk_ClientCode'])  || isset($_SESSION["wrk_ClientCode"])) 			$_SESSION["wrk_ClientCode"] 		= $_POST['wrk_ClientCode'];
  if (isset($_POST['wrk_ClientName'])  || isset($_SESSION["wrk_ClientName"])) 			$_SESSION["wrk_ClientName"] 		= $_POST['wrk_ClientName'];
  if (isset($_POST['wrk_StaffCode'])  || isset($_SESSION["wrk_StaffCode"])) 			$_SESSION["wrk_StaffCode"] 			= $_POST['wrk_StaffCode'];
  if (isset($_POST['wrk_StaffList'])  || isset($_SESSION["wrk_StaffList"])) 			$_SESSION["wrk_StaffList"] 			= $_POST['wrk_StaffList'];
  if (isset($_POST['wrk_TeamList'])  || isset($_SESSION["wrk_TeamList"])) 			$_SESSION["wrk_TeamList"] 			= $_POST['wrk_TeamList'];
  if (isset($_POST['wrk_ManagerList'])  || isset($_SESSION["wrk_ManagerList"])) 		$_SESSION["wrk_ManagerList"] 		= $_POST['wrk_ManagerList'];
  if (isset($_POST['wrk_SeniorList'])  || isset($_SESSION["wrk_SeniorList"])) 		$_SESSION["wrk_SeniorList"] 		= $_POST['wrk_SeniorList'];
  if (isset($_POST['wrk_StatusList'])  || isset($_SESSION["wrk_StatusList"])) 			$_SESSION["wrk_StatusList"] 		= $_POST['wrk_StatusList'];
  if (isset($_POST['wrk_MasterActivityList'])  || isset($_SESSION["wrk_MasterActivityList"])) 	$_SESSION["wrk_MasterActivityList"] = $_POST['wrk_MasterActivityList'];
  if (isset($_POST['wrk_SubActivityList'])  || isset($_SESSION["wrk_SubActivityList"])) 	$_SESSION["wrk_SubActivityList"] 	= $_POST['wrk_SubActivityList'];
  if (isset($_POST['cli_Category'])  || isset($_SESSION["cli_Category"])) 	$_SESSION["cli_Category"] 	= $_POST['cli_Category'];
  if (isset($_POST['order'])  || isset($_SESSION["order"])) 	$_SESSION["order"] 					= $_GET['order'];
  if (isset($_POST['type'])  || isset($_SESSION["type"] )) 	$_SESSION["type"] 				= $_GET['type'];
  if (isset($_POST['Submit'])  || isset($_SESSION["Submit"])) 					$_SESSION["Submit"] 				= $_POST['Submit'];
    }
 ?>
<html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
            <title>Super Records Worksheet Report</title>
            <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" /> <LINK href="stylesheet/Style.css" rel="stylesheet" type="text/css">
            <style type="text/css">
                @media print {

                    p#printscreen {
                        display:block;
                    }
                    div#notprint {
                        display:none;
                    }
                    td#notprint {
                        display:none;
                    }
                            th#notprint {
                        display:none;
                    }
                }
            </style>
            <script language="JavaScript" src="js/datetimepicker.js"></script>
            <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
            <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $javaScript; ?>worksheet_report.js"></script>
            <script type="text/javascript">
                function selectAll(listName, selected) {
                                    var listBox = document.getElementById(listName);
                                    <?php
                                           if(($_SESSION['usertype']!="Staff") || ($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y"))
                                           {
                                        ?>
                                    if(document.getElementById('SelectAll_Staff')!=null && document.getElementById('SelectAll_Staff').checked==true  || document.worksheet_report.SelectAll_Team.checked==true || document.worksheet_report.SelectAll_Manager.checked==true || document.worksheet_report.SelectAll_Senior.checked==true || document.worksheet_report.SelectAll_Status.checked==true || document.worksheet_report.SelectAll_Mas.checked==true || document.worksheet_report.SelectAll_SubActivity.checked==true)
                                    {
                                    for(i=0; i<listBox.length; i++) {
                                            listBox.options[i].selected=selected;
                                    }
                                    }
                                    else
                                    {
                                    for(i=0; i<listBox.length; i++) {
                                            listBox.options[i].selected="";
                                    }
                                    }
                                    <?php }
                                else { ?>
                                    if(document.getElementById('SelectAll_Staff')!=null && document.getElementById('SelectAll_Staff').checked==true  || document.worksheet_report.SelectAll_Status.checked==true || document.worksheet_report.SelectAll_Mas.checked==true || document.worksheet_report.SelectAll_SubActivity.checked==true)
                                    {
                                    for(i=0; i<listBox.length; i++) {
                                            listBox.options[i].selected=selected;
                                    }
                                    }
                                    else
                                    {
                                    for(i=0; i<listBox.length; i++) {
                                            listBox.options[i].selected="";
                                    }
                                    }


                             <?php   }
                                ?>
                            }
            </script>
        </head>
        <body>
            <?php
            if($_SESSION['validUser'])
            {
                include("includes/header.php");
                   if(isset($_POST['wrk_Status']) && isset($_POST['gridedit']) && $_POST['gridedit']=="save")
                  $sql_update_stage =mysql_query("update `wrk_worksheet` set `wrk_Status`=".$_POST['wrk_Status']." where wrk_Code=".$_POST['workcode']);
                 //Get FormCode
                  $formcode=$commonUses->getFormCode("Worksheet");
                  $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                 //Get FormCode
                  $formcode_report=$commonUses->getFormCode("Worksheet Report");
                  //Call CheckAccess function by passing $_SESSION of staff code and form code
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
                            $wrkReportDbcontent->sql_delete($_REQUEST['recid']);
                         }
                         else
                         {
                     echo "You are not authorised to delete the record.";
                         }

                  switch ($sql) {
                    case "insert":
                        $wrkReportDbcontent->sql_insert();
                      break;
                    case "update":
                        $wrkReportDbcontent->sql_update();
                      break;

                  }

                     if($access_file_level_report['stf_View']=="Y")
                          {
                                $wrkReportContent->select($access_file_level_report);
                          }
                           else
                          {
                            echo "You are not authorised to view the record.";
                          }
                  if (isset($order)) $_SESSION["order"] = $order;
                  if (isset($ordtype)) $_SESSION["type"] = $ordtype;
                  if (isset($filter)) $_SESSION["filter"] = $filter;
                  if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
                  if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
                  mysql_close();
                  }
                ?>
                <br>
            <?php
            }
            else
            {
                header("Location:index.php");
            }
            ?>
        </body>
</html>
