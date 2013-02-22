<?php

    ob_start();
    //$inc_path = get_include_path();
    //common functions
    //require_once("common/class.Database.php");
    include("dbclass/commonFunctions_class.php");
    include("dbclass/sales_opportunity_db_class.php");
    include("dbclass/sales_opportunity_content_class.php");
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
                    $cli_code=$_REQUEST['cli_code'];
             ?>
            <html>
                <head>
                    <title>Cross Sales Opportunity</title>
                        
                        <LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
                        <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
                        <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
                        <link type="text/css" rel="stylesheet" href="<?php echo $styleSheet; ?>jquery-ui-1.7.2/themes/base/ui.all.css" />
                        <link type="text/css" href="<?php echo $styleSheet; ?>ui.multiselect.css" rel="stylesheet" />
                        <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>
                        <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-ui-1.8.custom.min.js"></script>
                        <script type="text/javascript" src="<?php echo $javaScript; ?>plugins/localisation/jquery.localisation-min.js"></script>
                        <script type="text/javascript" src="<?php echo $javaScript; ?>plugins/scrollTo/jquery.scrollTo-min.js"></script>
                        <!--<script type="text/javascript" src="<?php echo $javaScript; ?>ui.multiselect.js"></script>-->
                        <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
                        <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
                        <script language="JavaScript" src="<?php echo $javaScript; ?>sales_opportunity_validate.js"></script>
                </head>
            <body >
                <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
                <?php
                    include ("includes/header.php");
                
                                if (isset($order)) $_SESSION["order"] = $order;
                                if (isset($ordtype)) $_SESSION["type"] = $ordtype;
                                if (isset($filter)) $_SESSION["filter"] = $filter;
                                if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
                                if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
                // select the function based on url
                //Client
                $formcode = $commonUses->getFormCode("Cross Sales Opp");
                    //Call CheckAccess function by passing $_SESSION of staff code and form code
                $access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                    //Condition if clients and lead form set to N for V,A,E,D
                if($access_file_level==0)
                {
                    //If View, Add, Edit, Delete all set to N
                    echo "You are not authorised to view this file.";
                }
                else if(is_array($access_file_level)==1)
                {
                
                }
            // template contents
            $showrecs  = 20;
            $pagerange = 10;
            $a         = @$_GET["a"];
            $recid     = @$_GET["recid"];
            $page      = @$_GET["page"];
            if (!isset($page)) $page = 1;
            $sql             = @$_POST["sql"];
            $newsql          = @$_POST["newsql"];
            $mode            = @$_GET["mode"];
            $grid_rowid      = @$_GET['row_id'];
            $grid_del        = @$_POST['delbut'];
            //inline grid save
            if($grid_rowid)
            {
                $CrossDbcontent->inlineSave();
            }
            // client multiple Delete with checkbox option
            switch ($mode)
            {
            // grid delete
                case "delete":
                if($access_file_level['stf_Delete']=="Y")
                {
                    $CrossDbcontent->sql_delete($_REQUEST['recid']);
                }
                else
                {
                    echo "You are not authorised to delete the record.";
                }
                break;
            }
                // Manage Clients
                switch ($sql) {
                    case "insert":
                        $CrossDbcontent->sql_insert();
                    break;
                    case "update":
                        $CrossDbcontent->sql_update();
                    break;
                }
                switch ($a)
                {
                    case "add":
                        if($access_file_level['stf_Add']=="Y")
                        {
                            $crossSales->addrec();
                        }
                        else
                        {
                            echo "You are not authorised to add a record.";
                        }
                    break;
                    case "view":
                        if($access_file_level['stf_View']=="Y")
                        {
                            $crossSales->viewrec($recid);
                        }
                        else
                        {
                            echo "You are not authorised to view the record.";
                        }
                    break;
                    case "edit":
                        if($_GET['ref']=="yes") echo "<script>window.location='cli_client.php?a=edit&recid=$_GET[recid]&cli_code=$_GET[cli_code]&page=$_GET[page]';</script>";
                        if($access_file_level['stf_Edit']=="Y")
                        {
                            $crossSales->editrec($recid);
							echo "<script>multi_selection();</script>";
                        }
                        else
                        {
                            echo "You are not authorised to edit record.";
                        }
                   break;
                    default:
                        if($access_file_level['stf_View']=="Y")
                        {
                            $crossSales->select();
                        }
                        else
                        {
                            echo "You are not authorised to view the record.";
                        }
                    break;
               }
		     include("includes/footer.php");
		  ?></body>
        </html>
<?php
      }
      else
      {
          header("Location:index.php?msg=timeout");
      }
?>


