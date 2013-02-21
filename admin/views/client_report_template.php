<?php 
ob_start();
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';
    include 'dbclass/client_report_content_class.php';
    include 'dbclass/client_report_db_class.php';

  if (isset($_GET["order"])) $order =  @$_GET["order"];
  if (isset($_GET["type"])) $ordtype = @$_GET["type"];
  if (isset($_POST["filter"])) $filter = @$_POST["filter"];
  if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
  $wholeonly = false;
  if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
  if ($_GET['a'] == "reset")  
  {
	 $_SESSION["cli_DateFrom"] 				= "";
	 $_SESSION["cli_DateTo"] 				="";
	 $_SESSION["cli_Type"] 				= "";
	 $_SESSION["cli_CompanyName"] 				="";
 	 $_SESSION["cli_State"] 			= "";
	 $_SESSION["cli_Stage"] 			= "";
	 $_SESSION["cli_Salesperson"] 			="";
	 $_SESSION["cli_Status"] 			="";
	 $_SESSION["order"] 					= "";
	 $_SESSION["type"] 						= "";
	 $_SESSION["Submit"]					= "";
         $_SESSION["query"] = "";
         $_SESSION['cli_TypeLead'] = "";
 } 
  if($_POST['Submit']=="Generate Report" || $_POST['Submit']=="Generate Excel Report" )
  {
	 $_SESSION["cli_DateFrom"] 				= "";
	 $_SESSION["cli_DateTo"] 				="";
	 $_SESSION["cli_Type"] 				= "";
	 $_SESSION["cli_CompanyName"] 				="";
 	 $_SESSION["cli_State"] 			= "";
	 $_SESSION["cli_Stage"] 			= "";
	 $_SESSION["cli_Salesperson"] 			="";
	 $_SESSION["cli_Status"] 			="";
	 $_SESSION["order"] 					= "";
	 $_SESSION["type"] 						= "";
	 $_SESSION["Submit"]					= "";
         $_SESSION["query"] = "";
         $_SESSION['cli_TypeLead'] = "";
         $_SESSION['cli_TypeClient'] = "";
         $_SESSION['cli_TypeDis'] = "";
         $_SESSION['cli_TypeConsign'] = "";

         if (isset($_POST['cli_DateFrom']) || isset($_SESSION['cli_DateFrom'])) 			$_SESSION["cli_DateFrom"] 			= $_POST['cli_DateFrom'];
         if (isset($_POST['cli_DateTo'])  || isset($_SESSION["cli_DateTo"])) 				$_SESSION["cli_DateTo"] 			=$_POST['cli_DateTo'];
         if (isset($_POST['cli_TypeList']) || isset($_SESSION['cli_Type'])) 			$_SESSION["cli_Type"] 			= $_POST['cli_TypeList'];
         if (isset($_POST['cli_TypeListPerm']) || isset($_SESSION['cli_TypePerm'])) 			$_SESSION["cli_TypePerm"] 			= $_POST['cli_TypeListPerm'];
         if (isset($_POST['cli_CompanyName'])  || isset($_SESSION["cli_CompanyName"])) 				$_SESSION["cli_CompanyName"] 			=$_POST['cli_CompanyName'];
         if (isset($_POST['cli_State'])  || isset($_SESSION["cli_State"])) 			$_SESSION["cli_State"] 		= $_POST['cli_State'];
         if (isset($_POST['cli_StageList'])  || isset($_SESSION["cli_Stage"])) 			$_SESSION["cli_Stage"] 		= $_POST['cli_StageList'];
         if (isset($_POST['cli_SalespersonList'])  || isset($_SESSION["cli_Salesperson"])) 			$_SESSION["cli_Salesperson"] 			= $_POST['cli_SalespersonList'];
         if (isset($_POST['cli_StatusList'])  || isset($_SESSION["cli_Status"])) 			$_SESSION["cli_Status"] 			= $_POST['cli_StatusList'];
         if (isset($_POST['order'])  || isset($_SESSION["order"])) 	$_SESSION["order"] 					= $_GET['order'];
         if (isset($_POST['type'])  || isset($_SESSION["type"] )) 	$_SESSION["type"] 				= $_GET['type'];
         if (isset($_POST['Submit'])  || isset($_SESSION["Submit"])) 					$_SESSION["Submit"] 				= $_POST['Submit'];
    }
   ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
        <title>Sales Report</title>
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
        <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
        <script type="text/javascript" src="<?php echo $javaScript; ?>client_report.js"></script>
        <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
    </head>
    <body onload="selectAll('cli_TypeList',selected)">
        <?php
        if($_SESSION['validUser'])
        {
            include("includes/header.php");

         //Get FormCode
          $formcode=$commonUses->getFormCode("Clients");
          $formcode_lead=$commonUses->getFormCode("Lead");
          $formcode_consigned=$commonUses->getFormCode("Contract Signed");
          $formcode_discontinued=$commonUses->getFormCode("Discontinued");
          $formcode_report=$commonUses->getFormCode("Client Report");
          //Call CheckAccess function by passing $_SESSION of staff code and form code
          $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
          $access_file_level_lead=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_lead);
          $access_file_level_consigned=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_consigned);
          $access_file_level_discontinued=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_discontinued);
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
                    $clireportDbcontent->sql_delete($_REQUEST['recid']);
                 }
                 else
                 {
             echo "You are not authorised to delete the record.";
                 }

          switch ($sql) {
            case "insert":
                $clireportDbcontent->sql_insert();
              break;
            case "update":
                $clireportDbcontent->sql_update();
              break;
          }

             if($access_file_level_report['stf_View']=="Y")
                  {
                        $clireportContent->select();
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
