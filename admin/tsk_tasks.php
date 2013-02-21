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
<title>Tasks</title>
<meta name="generator" http-equiv="content-type" content="text/html">
<LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
<LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
 <script>
function validateFormOnSubmit()
{
			// do field validation
			tskcatindex=document.tasks.tsk_Category.selectedIndex
			subtskcatindex=document.tasks.tsk_SubCategory.selectedIndex
            
			if (document.tasks.tsk_Description.value == "") {
				alert( "Enter the Description" );
				document.tasks.tsk_Description.focus();
				return(false);
			}
			else if(tskcatindex==0)
			{
				alert( "Select Category" );
				document.tasks.tsk_Category.focus();
				return(false);
			}
			else if(subtskcatindex==0)
			{
				alert( "Select Sub Category" );
				document.tasks.tsk_SubCategory.focus();
				return(false);
			}
			else {
				document.tasks.submit();
				return(true);
			}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){
      
      window.location.href = "tsk_tasks.php";

   }else{
      
      return false;
   }
}
</script>
 </head>
<body>
<?php include ("includes/header.php");?><br>
<?php
   //Get FormCode
  $formcode=$commonUses->getFormCode("Tasks");

/* update tasks order
        if(isset($_POST['gridedit']) && $_POST['gridedit']=="save")
        $sql_update_order =mysql_query("update `tsk_tasks` set `tsk_Order`=".$_POST['tsk_Order']." where tsk_Code=".$_POST['tskcode']);
*/
  //Call CheckAccess function by passing $_SESSION of staff code and form code
  
  $access_file_level=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
  if($access_file_level==0)
  {
  //If View, Add, Edit, Delete all set to N
  echo "<br>You are not authorised to view this file.";
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


  if ($a == "reset")
   {
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
<br>
<span class="frmheading">Tasks</span>
<hr size="1" noshade>
<form action="tsk_tasks.php" method="post">
<table align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
 <option value="<?php echo "lp_tsk_Category" ?>"<?php if ($filterfield == "lp_tsk_Category") { echo "selected"; } ?>>Category</option>
<option value="<?php echo "lp_tsk_SubCategory" ?>"<?php if ($filterfield == "lp_tsk_SubCategory") { echo "selected"; } ?>>Sub Category</option>
<option value="<?php echo "tsk_Description" ?>"<?php if ($filterfield == "tsk_Description") { echo "selected"; } ?>>Description</option>
</select></td>
<td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="action" value="Apply Filter"></td>
<td><a href="tsk_tasks.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<p>&nbsp;</p>
<br><br>
<table class="fieldtable_outer" align="center">
<tr>
<td>
<?php 
    if($access_file_level['stf_Add']=="Y")
	  {  
?>
<a href="tsk_tasks.php?a=add" class="hlight">
<img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
<?php }?>
<?php showpagenav($page, $pagecount); ?>
<p>&nbsp;</p>
<table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" >
 <tr class="fieldheader">
 <th class="fieldheader"><a  href="tsk_tasks.php?order=<?php echo "lp_tsk_Category" ?>&type=<?php echo $ordtypestr ?>">Category</a></th>
<th class="fieldheader"><a   href="tsk_tasks.php?order=<?php echo "lp_tsk_SubCategory" ?>&type=<?php echo $ordtypestr ?>">Sub Category</a></th>
 <th class="fieldheader"><a   href="tsk_tasks.php?order=<?php echo "tsk_Description" ?>&type=<?php echo $ordtypestr ?>">Description</a></th>
 <!-- <th class="fieldheader"><a href="tsk_tasks.php?order=<?php echo "tsk_Order" ?>&type=<?php echo $ordtypestr ?>">Order</a></th> -->
<th  class="fieldheader" colspan="3" align="center">Actions</th>

</tr>
<?php
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mysql_fetch_assoc($res);
 ?>
<tr>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tsk_Category"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tsk_SubCategory"]) ?></td>

 <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["tsk_Description"]) ?></td>
<td>
<?php 
  if($access_file_level['stf_View']=="Y")
	  {  
?>
<a href="tsk_tasks.php?a=view&recid=<?php echo $i ?>">
<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
</td>
<td>
<?php }?>
<?php 
  if($access_file_level['stf_Edit']=="Y")
	  {  
?>
<a href="tsk_tasks.php?a=edit&recid=<?php echo $i ?>">
<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
</td>
<td>
<?php }?>
<?php 
  if($access_file_level['stf_Delete']=="Y")
	  {  
?>
<a onClick="performdelete('tsk_tasks.php?mode=delete&recid=<?php echo htmlspecialchars($row["tsk_Code"]) ?>'); return false;" href="#">
<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
<?php }?>
</td>
</tr>
<?php
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
<form action="tsk_tasks.php?a=view&recid=<?php echo $recid ?>" method="post">
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
<td><input type="submit" name="action" value="Login"></td>
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
<table align="center"  border="0" cellspacing="1" cellpadding="5"width="50%">
<tr>
<td class="hr">Category</td>
<td class="dr"><?php echo htmlspecialchars($row["lp_tsk_Category"]) ?></td>
</tr>
<tr>
<td class="hr">Sub Category</td>
<td class="dr"><?php echo htmlspecialchars($row["lp_tsk_SubCategory"]) ?></td>
</tr>

 <tr>
<td class="hr">Description</td>
<td class="dr"><?php echo htmlspecialchars($row["tsk_Description"]) ?></td>
</tr>
<!--
 <tr>
<td class="hr">Order</td>
<td class="dr"><?php echo htmlspecialchars($row["tsk_Order"]) ?></td>
</tr>
-->
</table>
<?php } ?>

<?php function showroweditor($row, $iseditmode)
  {
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
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
<td class="hr">Category<font style="color:red;" size="2">*</font>
</td>
<td class="dr"><select name="tsk_Category"><option value="0">Select Category</option>
<?php
  $sql = "select `cat_Code`, `cat_Description` from `cat_categorytasks` ORDER BY cat_Description ASC";
  $res = mysql_query($sql) or die(mysql_error());

  while ($lp_row = mysql_fetch_assoc($res)){
  $val = $lp_row["cat_Code"];
  $caption = $lp_row["cat_Description"];
  if ($row["tsk_Category"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
<?php } ?></select>
</td>
</tr>
<tr>
<td class="hr">Sub Category<font style="color:red;" size="2">*</font>
</td>
<td class="dr"><select name="tsk_SubCategory"><option value="0">Select Sub Category</option>
<?php
  $sql = "select `sub_Code`, `sub_Description` from `sub_subcategorytasks` ORDER BY sub_Description ASC ";
  $res = mysql_query($sql) or die(mysql_error());

  while ($lp_row = mysql_fetch_assoc($res)){
  $val = $lp_row["sub_Code"];
  $caption = $lp_row["sub_Description"];
  if ($row["tsk_SubCategory"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
<?php } ?></select>
</td>
</tr>

<tr>
<td class="hr">Description<font style="color:red;" size="2">*</font>
</td>
<td class="dr"><textarea cols="35" rows="4" name="tsk_Description" maxlength="65535"><?php echo str_replace('"', '&quot;', trim($row["tsk_Description"])) ?></textarea>
<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of the Tasks.</span></a>
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
<td><a href="tsk_tasks.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
<td><a href="tsk_tasks.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
<?php } } } else { ?>
<td><a href="tsk_tasks.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
<td>&nbsp;<a href="tsk_tasks.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
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
<td><a href="tsk_tasks.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="tsk_tasks.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
<?php } ?>
</tr>
</table>
<br>
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
<?php echo $title?> Tasks
</span>
<hr size="1" noshade>
<?php } ?>

<?php function addrec()
{
?><br>
<span class="frmheading">
 Add Record
</span>
<hr size="1" noshade><div style="position:absolute; top:160; right:-50px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form enctype="multipart/form-data" action="tsk_tasks.php" method="post"  name="tasks" onSubmit="return validateFormOnSubmit()">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "tsk_Code" => "",
  "tsk_Description" => "",
  "tsk_Category" => "",
  "tsk_SubCategory" => "");
showroweditor($row, false);
?>
<input type="submit" name="action" value="Save" class="button"> <input type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton"/> 
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
<br>
<hr size="1" noshade>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<?php
if($access_file_level['stf_Add']=="Y")
 {
?>
<td><a href="tsk_tasks.php?a=add" class="hlight">Add Record</a></td>
<?php }?>
<?php
 if($access_file_level['stf_Edit']=="Y")
 {
 ?>
<td><a href="tsk_tasks.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Delete']=="Y")
 {
?>
<td><a onClick="performdelete('tsk_tasks.php?mode=delete&recid=<?php echo htmlspecialchars($row["tsk_Code"]) ?>'); return false;" href="#" class="hlight">Delete Record</a></td>
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
?><div style="position:absolute; top:160; right:-50px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<br>
<form enctype="multipart/form-data" action="tsk_tasks.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post"  name="tasks" onSubmit="return validateFormOnSubmit()">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xtsk_Code" value="<?php echo $row["tsk_Code"] ?>">
<?php showroweditor($row, true); ?>
<input type="submit" name="action" value="Update" class="button"> <input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/> </form>
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
  $sql = "SELECT * FROM (SELECT t1.`tsk_Code`, t1.`tsk_Description`, t1.`tsk_Category`, lp2.`cat_Description` AS `lp_tsk_Category`, t1.`tsk_SubCategory`, lp3.`sub_Description` AS `lp_tsk_SubCategory`, `tsk_Order` FROM `tsk_tasks` AS t1 LEFT OUTER JOIN `cat_categorytasks` AS lp2 ON (t1.`tsk_Category` = lp2.`cat_Code`) LEFT OUTER JOIN `sub_subcategorytasks` AS lp3 ON (t1.`tsk_SubCategory` = lp3.`sub_Code`)) subq";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (`tsk_Code` like '" .$filterstr ."') or (`tsk_Description` like '" .$filterstr ."') or (`lp_tsk_Category` like '" .$filterstr ."') or (`lp_tsk_SubCategory` like '" .$filterstr ."')";
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

  $fields=array('tsk_Category','tsk_Description','tsk_SubCategory');
  $postvalue=array($_POST["tsk_Category"],str_replace("'","''",stripslashes(@$_POST["tsk_Description"])),$_POST["tsk_SubCategory"]);
  $where= " where ".$fields[0]."=".$postvalue[0]." and ".$fields[1]."='".$postvalue[1]."' and ".$fields[2]."='".$postvalue[2]."'";
  $duplicate_entry=$commonUses->checkDuplicateMultiple('tsk_tasks',$fields,$postvalue,$where);
  if($duplicate_entry==0)
   {
  $sql = "insert into `tsk_tasks` (`tsk_Code`, `tsk_Description`, `tsk_Category`, `tsk_SubCategory`, `tsk_Order`) values (" .$commonUses->sqlvalue(@$_POST["tsk_Code"], false).", '" .str_replace("'","''",stripslashes(@$_POST["tsk_Description"])) ."', " .$commonUses->sqlvalue(@$_POST["tsk_Category"], false).", " .$commonUses->sqlvalue(@$_POST["tsk_SubCategory"], false).", " .$commonUses->sqlvalue(@$_POST["tsk_Order"], false).")";
  mysql_query($sql) or die(mysql_error());
  }
}

function sql_update()
{
  global $_POST;
  global $commonUses;

  $sql = "update `tsk_tasks` set `tsk_Description`='" .str_replace("'","''",stripslashes(@$_POST["tsk_Description"])) ."', `tsk_Category`=" .$commonUses->sqlvalue(@$_POST["tsk_Category"], false).", `tsk_SubCategory`=" .$commonUses->sqlvalue(@$_POST["tsk_SubCategory"], false) .",`tsk_Order`=" .$commonUses->sqlvalue(@$_POST["tsk_Order"], false)." where " .primarykeycondition();
  mysql_query($sql) or die(mysql_error());
}

function sql_delete($id)
{
   $sql = "delete from `tsk_tasks` where tsk_Code='".$id."'";
  if(!mysql_query($sql))
echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
 }

function primarykeycondition()
{
  global $_POST;
  global $commonUses;
  $pk = "";
  $pk .= "(`tsk_Code`";
  if (@$_POST["xtsk_Code"] == "") {
    $pk .= " IS NULL";
  }else{
  $pk .= " = " .$commonUses->sqlvalue(@$_POST["xtsk_Code"], false);
  };
  $pk .= ")";
  return $pk;
}
 ?>
