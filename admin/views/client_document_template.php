<?php 
ob_start();
    include("common/varDeclare.php");
    //include("common/class.Database.php");
    include("dbclass/commonFunctions_class.php");
    include("dbclass/clidocument_content_class.php");
    include("dbclass/clidocument_db_class.php");
     if($_SESSION['validUser'])
  {
   if (isset($_GET["docorder"])) $order = @$_GET["docorder"];
  if (isset($_GET["doctype"])) $ordtype = @$_GET["doctype"];
  if (!isset($order) && isset($_SESSION["docorder"])) $order = $_SESSION["docorder"];
  if (!isset($ordtype) && isset($_SESSION["doctype"])) $ordtype = $_SESSION["doctype"];
 ?>

<html>
<head>
<title>Client</title>
<LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>client_document.js"></script>
</head>
<body   >
<?php
    include ("includes/header.php");
  $showrecs = 20;
  $pagerange = 10;
  $a = @$_GET["a"];
  $recid = @$_GET["recid"];
  $page = @$_GET["page"];
  $typeapp = $_REQUEST['app'];
  $clientid = $_REQUEST['mid'];
  if (!isset($page)) $page = 1;
  $sql = @$_POST["sql"];
 $mode=@$_GET["mode"];
 if($mode=="delete") {
            $clidocumentQuery->sql_delete($_REQUEST['recid']);
 }
   $cli_code=$_REQUEST['cli_code'];
    
            $clidocumentContent->select();

  if (isset($order)) $_SESSION["docorder"] = $order;
  if (isset($ordtype)) $_SESSION["doctype"] = $ordtype;

  mysql_close();
?>

</body>
</html>
<?php }  
else
{
header("Location:index.php?msg=timeout");
}
$clidocumentContent->adminLink();
?>
