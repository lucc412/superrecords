<?php
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';
    include 'dbclass/wrk_repeats_content_class.php';
    include 'dbclass/wrk_repeats_db_class.php';
    if($_SESSION['validUser'])
    {
              if (isset($_GET["order"])) $order = @$_GET["order"];
              if (isset($_GET["type"])) $ordtype = @$_GET["type"];
              if (isset($_POST["filtertext"])) $filtertext = @$_POST["filtertext"];
              if (isset($_POST["filter_fieldrepeat"])) $filterfieldrepeat = @$_POST["filter_fieldrepeat"];
              $wholeonly = false;
              if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
              if (!isset($order) && isset($_SESSION["order"])) $order = $_SESSION["order"];
              if (!isset($ordtype) && isset($_SESSION["type"])) $ordtype = $_SESSION["type"];
              if (!isset($filtertext) && isset($_SESSION["filtertext"])) $filtertext = $_SESSION["filtertext"];
              if (!isset($filterfieldrepeat) && isset($_SESSION["filter_fieldrepeat"])) $filterfieldrepeat = $_SESSION["filter_fieldrepeat"];
            ?>
            <html>
                <head>
                    <title>Worksheet Repeats</title>
                    <meta name="generator" http-equiv="content-type" content="text/html">
                    <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
                    <script type="text/javascript" src="<?php echo $javaScript; ?>worksheet_repeats.js"></script>
                    <LINK href="<?php echo $styleSheet ; ?>Style.css" rel="stylesheet" type="text/css">
                    <LINK href="<?php echo $styleSheet ; ?>worksheet_repeats.css" rel="stylesheet" type="text/css">
                </head>
                <body>
                <?php if($_GET['rpt_id']=="") {
                    include ("includes/header.php"); } else { ?><br>
                <?php
                }
              //Get FormCode
              $formcode=$commonUses->getFormCode("Worksheet Repeats");
              //Get FormCode
              $formcode_worksheet=$commonUses->getFormCode("Worksheet");
              //Call CheckAccess function by passing $_SESSION of staff code and form code
              $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
              $access_file_level_worksheet=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_worksheet);
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
                       if($_POST['submit']=="Confirm")
                        {
                            $repeatsDbcontent->copyDel();
                          }
                          switch ($a) {
                             case "view_wrksheet":
                                if($access_file_level['stf_View']=="Y")
                                {
                                    $repeatsContent->viewrec_wrksheet($_REQUEST['rpt_id']);
                                }
                                else
                                {
                                    echo "You are not authorised to view the record.";
                                }
                                break;
                                default:
                                    if($access_file_level['stf_View']=="Y")
                                    {
                                        $repeatsContent->select($access_file_level);
                                     }
                                     else
                                     {
                                            echo "You are not authorised to view the record.";
                                      }
                                break;
                          }
                          if (isset($order)) $_SESSION["order"] = $order;
                          if (isset($ordtype)) $_SESSION["type"] = $ordtype;
                          if (isset($filtertext)) $_SESSION["filtertext"] = $filtertext;
                          if (isset($filterfieldrepeat)) $_SESSION["filter_fieldrepeat"] = $filterfieldrepeat;
                          if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
                          mysql_close();
              }
            ?>
            </body>
        </html>
    <?php
    }
    else
    {
        header("Location:index.php?msg=timeout");
    }

