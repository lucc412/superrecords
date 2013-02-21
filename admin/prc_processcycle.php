<?php 
    include 'common/varDeclare.php';
    include 'dbclass/commonFunctions_class.php';

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
<title>Process Cycle</title>
<meta name="generator" http-equiv="content-type" content="text/html">
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
<script>
function validateFormOnSubmit()
{
			// do field validation
			if (document.processcycle.prc_Description.value == "") {
				alert( "Enter the Description" );
				document.processcycle.prc_Description.focus();
				return(false);
			}
			else {
				document.processcycle.submit();
				return(true);
			}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){
      
      window.location.href = "prc_processcycle.php";

   }else{
      
      return false;
   }
}
</script>


</head>
<body>
<?php include ("includes/header.php"); ?>
<br>

<?php
  
  //Get FormCode
  $formcode=$commonUses->getFormCode("Process Cycle");

//update Process Cycle order
        if(isset($_POST['gridedit']) && $_POST['gridedit']=="save")
        $sql_update_order =mysql_query("update `prc_processcycle` set `prc_Order`=".$_POST['prc_Order']." where prc_Code=".$_POST['prccode']);

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
	  sql_delete($_REQUEST['recid']);
	 }
	 else
	 {
     echo "You are not authorised to delete the record.";
	 }
	 
  switch ($sql) {
    case "insert":
      sql_insert();
      break;
    case "update":
      sql_update();
      break;
   }

  switch ($a) {
    case "add":
      if($access_file_level['stf_Add']=="Y")
	  {    
        addrec();
	  }
	  else
	  {
	    echo "You are not authorised to add a record.";
	  }
        break;
    case "view":
	 if($access_file_level['stf_View']=="Y")
	  {
        viewrec($recid,$access_file_level);
	  }
	   else
	  {
	    echo "You are not authorised to view the record.";
	  }
      break;
    case "edit":
	 if($access_file_level['stf_Edit']=="Y")
	  {
        editrec($recid);
	  }
	   else
	  {
	    echo "You are not authorised to edit record.";
	  }
      break;
    default:
	 if($access_file_level['stf_View']=="Y")
	  {
        select($access_file_level);
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
?>

</body>
</html>
<?php }  
else
{
header("Location:index.php?msg=timeout");
}
?>

<?php function select($access_file_level)
  {
  global $a;
  global $showrecs;
  global $page;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $order;
  global $ordtype;


  if ($a == "reset") {
    $filter = "";
    $filterfield = "";
    $wholeonly = "";
    $order = "";
    $ordtype = "";
  }

  $checkstr = "";
  if ($wholeonly) $checkstr = " checked";
  if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
  $res = sql_select();
  //$count = sql_getrecordcount();
  $count = mysql_num_rows($res);
  if ($count % $showrecs != 0) {
    $pagecount = intval($count / $showrecs) + 1;
  }
  else {
    $pagecount = intval($count / $showrecs);
  }
  $startrec = $showrecs * ($page - 1);
  if ($startrec < $count) {mysql_data_seek($res, $startrec);}
  $reccount = min($showrecs * $page, $count);
?>
<div class="frmheading">
	<h1>Process Cycle</h1>
</div>
<form action="prc_processcycle.php" method="post">
<table class="customFilter" align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
 <option value="<?php echo "prc_Description" ?>"<?php if ($filterfield == "prc_Description") { echo "selected"; } ?>>Description</option>
</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="prc_processcycle.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
 <p>&nbsp;</p>
<?php 
  if($access_file_level['stf_Add']=="Y")
	  {  
?>
<br><br><br>
<a href="prc_processcycle.php?a=add" class="hlight">
<img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
<?php } ?>
<?php showpagenav($page, $pagecount); ?>
<br>
<table class="fieldtable" align="center" width="100%">
<tr class="fieldheader">
 <th class="fieldheader"><a   href="prc_processcycle.php?order=<?php echo "prc_Description" ?>&type=<?php echo $ordtypestr ?>">Description</a></th>
 <th width="25%" class="fieldheader"><a href="prc_processcycle.php?order=<?php echo "prc_Order" ?>&type=<?php echo $ordtypestr ?>">Order</a></th>
<th width="12%" class="fieldheader" colspan="3" align="center">Actions</th>

</tr>
<?php
$countRow = 0;
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mysql_fetch_assoc($res);
	if($countRow%2 == 0) $trClass = "trcolor";
		else $trClass = "";
 ?>
<tr class="<?=$trClass?>">
 <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["prc_Description"]) ?></td>
<td>
<?php
                                if($_GET['page']!="")
                                    $updatequery="?page=".$_GET['page'];
                                if($_GET['order']!="" && $_GET['type']!="")
                                    $updatequery="?order=".$_GET['order']."&type=".$_GET['type'];

?>
                                <form action="prc_processcycle.php<?php echo $updatequery; ?>" method="post">
                                    <select name="prc_Order" onChange="if(confirm('Save?')){this.form.gridedit.click();} else { location.href='prc_processcycle.php?a=reset'}"  ><option value="0">Select Order</option>
                                    <?php
                                        //$count = sql_getrecordcount();
                                    $count = mysql_num_rows($res);
                                        for($c=1; $c<=$count; $c++)
                                            {
                                                $val = $c;
                                                if ($row["prc_Order"] == $val) {$selstr = " selected"; } else {$selstr = ""; }

                                    ?>
                                        <option value="<?php echo $c ?>"<?php echo $selstr ?>><?php echo $c ?></option>
                                    <?php } ?>
                                    </select>
                                            <input type="hidden" name="prccode" value="<?php echo $row["prc_Code"]; ?>">
                                            <button type="submit" name="gridedit" value="save">Save</button>
                                </form>
</td>

<?php 
  if($access_file_level['stf_View']=="Y")
	  {  
?><td>
<a href="prc_processcycle.php?a=view&recid=<?php echo $i ?>">
<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a></td>
<?php } ?>


<?php 
  if($access_file_level['stf_Edit']=="Y")
	  {  
?><td>
<a href="prc_processcycle.php?a=edit&recid=<?php echo $i ?>">
<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a></td>
<?php } ?>

<?php 
  if($access_file_level['stf_Delete']=="Y")
	  {  
?><td>

<a onClick="performdelete('prc_processcycle.php?mode=delete&recid=<?php echo htmlspecialchars($row["prc_Code"]) ?>'); return false;" href="#">
<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
</td>
<?php } ?>
</tr>
<?php
$countRow++;
  }
  mysql_free_result($res);
?>
</table>
<br>
 <?php } ?>

<?php function login_view($recid)
{
  global $_POST;
  global $_SESSION;
  if (!isset($_SESSION["logged_view"])) $_SESSION["logged_view"] = false;
  if (!$_SESSION["logged_view"]) {
    $login = "";
    $password = "";
    if (isset($_POST["login_view"])) $login = @$_POST["login_view"];
    if (isset($_POST["password_view"])) $password = @$_POST["password_view"];

    if (($login != "") && ($password != "")) {
       $sql = "select `ape_Code` from `ape_paccountspayable` where `ape_Code` = '" .$login ."'";
      $res = mysql_query($sql) or die(mysql_error());
      $row = mysql_fetch_assoc($res) or $row = array(0 => "");;
      if (isset($row)) reset($row);

      if (isset($password) && ($password == trim(current($row)))) {
        $_SESSION["logged_view"] = true;
    }
    else {
?>
<p><b><font color="-1">Sorry, the login/password combination you've entered is invalid</font></b></p>
<?php } } }if (isset($_SESSION["logged_view"]) && (!$_SESSION["logged_view"])) { ?>
<form action="prc_processcycle.php?a=view&recid=<?php echo $recid ?>" method="post">
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td>Login</td>
<td><input type="text" name="login_view" value="<?php echo $login ?>"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password_view" value="<?php echo $password ?>"></td>
</tr>
<tr>
<td><button type="submit" name="action" value="Login">Login</button></td>
</tr>
</table>
</form>
<?php
  }
  if (!isset($_SESSION["logged_view"])) $_SESSION["logged_view"] = false;
  return $_SESSION["logged_view"];
} ?>

<?php function showrow($row, $recid)
  {
?>
<table class="tbl" border="0" cellspacing="12" width="70%">
 <tr>
<td class="hr">Description</td>
<td class="dr"><?php echo htmlspecialchars($row["prc_Description"]) ?></td>
</tr>
 <tr>
<td class="hr">Order</td>
<td class="dr"><?php echo htmlspecialchars($row["prc_Order"]) ?></td>
</tr>

</table>
<?php } ?>

<?php function showroweditor($row, $iseditmode)
  {
?>
<table class="tbl" border="0" cellspacing="10" width="50%">
<?php 
if(!$iseditmode) { 
?>
<tr>
<td class="hr">Code</td>
<td class="dr">
<?php echo "New";?>
<?php } ?>
</td>
</tr>

<tr>
<td class="hr">Description<font style="color:red;" size="2">*</font>
</td>
<td class="dr"><input type="text" name="prc_Description" maxlength="50" value="<?php echo str_replace('"', '&quot;', trim($row["prc_Description"])) ?>">
<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of the process cycle.</span></a>
</td>
</tr>
<tr>
<td class="hr">Order</td>
		<td>
			<select name="prc_Order">
                            <option value="">Select Order</option>
                                <?php
                                //$count = sql_getrecordcount();
                                $res = sql_select();
                                $count = mysql_num_rows($res);
                                for($i=1; $i<=$count; $i++)
                                {
                                  $val = $i;
                                  if ($row["prc_Order"] == $val) {$selstr = " selected"; } else {$selstr = ""; }

                                 ?><option value="<?php echo $i ?>"<?php echo $selstr ?>><?php echo $i ?></option>
                                    <?php } ?>
                        </select>
		</td>

</tr>

</table>
<?php } ?>

<?php function showpagenav($page, $pagecount)
{
?>
<table   border="0" cellspacing="1" cellpadding="4" align="right" >
<tr>
 <?php if ($page > 1) { ?>
<td><a href="prc_processcycle.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
<?php } ?>
<?php
  global $pagerange;

  if ($pagecount > 1) {

  if ($pagecount % $pagerange != 0) {
    $rangecount = intval($pagecount / $pagerange) + 1;
  }
  else {
    $rangecount = intval($pagecount / $pagerange);
  }
  for ($i = 1; $i < $rangecount + 1; $i++) {
    $startpage = (($i - 1) * $pagerange) + 1;
    $count = min($i * $pagerange, $pagecount);

    if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
      for ($j = $startpage; $j < $count + 1; $j++) {
        if ($j == $page) {
?>
<td><strong><span class="hlight_current" ><?php echo $j ?></span></strong></td>
<?php } else { ?>
<td><a href="prc_processcycle.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
<?php } } } else { ?>
<td><a href="prc_processcycle.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
<td>&nbsp;<a href="prc_processcycle.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
<?php } ?>
</tr>
</table>
<?php } ?>

<?php function showrecnav($a, $recid, $count)
{
?>
<table border="0" cellspacing="1" cellpadding="4" align="right">
<tr>
 <?php if ($recid > 0) { ?>
<td><a href="prc_processcycle.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="prc_processcycle.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;</span></a></td>
<?php } ?>
</tr>
</table>

<span class="frmheading">
<?php 
switch($a)
{
case "view":
		$title="View";
		break;
case "edit";
		$title="Edit";
		break;
default:
		$title="";
		break;
}
?>
<?php echo $title?> Process Cycle
</span>
<div class="frmheading">
	<h1></h1>
</div>
<?php } ?>

<?php function addrec()
{
?>

<div class="frmheading">
	<h1>Add Record</h1>
</div>	
	
<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form enctype="multipart/form-data" action="prc_processcycle.php" method="post" name="processcycle" onSubmit="return validateFormOnSubmit()">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "prc_Code" => "",
  "prc_Description" => "");
showroweditor($row, false);
?>
<button type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton">Cancel</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="submit" name="action" value="Save" class="button">Save</button>
</form>
<?php } ?>

<?php function viewrec($recid,$access_file_level)
{
  $res = sql_select($access_file_level);
  //$count = sql_getrecordcount();
  $count = mysql_num_rows($res);
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("view", $recid, $count);
?>
<br>
<?php showrow($row, $recid) ?>
<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<?php
if($access_file_level['stf_Add']=="Y")
 {
?><td><a href="prc_processcycle.php?a=add" class="hlight">Add Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Edit']=="Y")
 {
?><td><a href="prc_processcycle.php?a=edit&recid=<?php echo $recid ?>" class="hlight"> Edit Record</a></td>
<?php } ?>
<?php 
  if($access_file_level['stf_Delete']=="Y")
	  {  
?><td><a onClick="performdelete('prc_processcycle.php?mode=delete&recid=<?php echo htmlspecialchars($row["prc_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
<?php } ?>
</tr>
</table>
<?php
  mysql_free_result($res);
} ?>

<?php function editrec($recid)
{

  $res = sql_select($access_file_level);
  //$count = sql_getrecordcount();
  $count = mysql_num_rows($res);
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("edit", $recid, $count);
?><div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<br>
<form enctype="multipart/form-data" action="prc_processcycle.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post" name="processcycle" onSubmit="return validateFormOnSubmit()">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xprc_Code" value="<?php echo $row["prc_Code"] ?>">
<?php showroweditor($row, true); ?>
 <button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <button type="submit" name="action" value="Update" class="button">Update</button>
 </form>
<?php
  mysql_free_result($res);
} ?>

 
<?php  
 function sql_select()
{
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $commonUses;
  $filterstr = $commonUses->sqlstr($filter);
  if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
  $sql = "SELECT `prc_Code`, `prc_Description`, `prc_Order` FROM `prc_processcycle`";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (`prc_Code` like '" .$filterstr ."') or (`prc_Description` like '" .$filterstr ."')";
  }
  if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
  if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
  $res = mysql_query($sql) or die(mysql_error());
  return $res;
}

function sql_insert()
{
  global $_POST;
  global $commonUses;
  $duplicate_entry=$commonUses->checkDuplicate('prc_processcycle','prc_Description',str_replace("'","''",stripslashes(@$_POST["prc_Description"])));
  if($duplicate_entry==0)
   {

  $sql = "insert into `prc_processcycle` (`prc_Code`, `prc_Description`, `prc_Order`) values (" .$commonUses->sqlvalue(@$_POST["prc_Code"], false).", '" .str_replace("'","''",stripslashes(@$_POST["prc_Description"])) ."', " .$commonUses->sqlvalue(@$_POST["prc_Order"], false).")";
  mysql_query($sql) or die(mysql_error());
}
   }

function sql_update()
{
  global $_POST;
  global $commonUses;

  $sql = "update `prc_processcycle` set `prc_Description`='" .str_replace("'","''",stripslashes(@$_POST["prc_Description"])) ."',prc_Order=" .$commonUses->sqlvalue(@$_POST["prc_Order"], false)." where " .primarykeycondition();
  mysql_query($sql) or die(mysql_error());
}

function sql_delete($id)
{
   $sql = "delete from `prc_processcycle` where prc_Code='".$id."'";
  if(!mysql_query($sql))
echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
 }
function primarykeycondition()
{
  global $_POST;
  global $commonUses;
  $pk = "";
  $pk .= "(`prc_Code`";
  if (@$_POST["xprc_Code"] == "") {
    $pk .= " IS NULL";
  }else{
  $pk .= " = " .$commonUses->sqlvalue(@$_POST["xprc_Code"], false);
  };
  $pk .= ")";
  return $pk;
}
 ?>
