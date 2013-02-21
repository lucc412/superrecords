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
<title>Entity Type</title>
<meta name="generator" http-equiv="content-type" content="text/html">
<LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
<LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
<script>
function validateFormOnSubmit()
{
			// do field validation
			if (document.entitytype.ety_Description.value == "") {
				alert( "Enter the Description" );
				document.entitytype.ety_Description.focus();
				return(false);
			}
			else {
				document.entitytype.submit();
				return(true);
			}
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){
      
      window.location.href = "ety_entitytype.php";

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
  $formcode=$commonUses->getFormCode("Entity Type");

//update case status order
        if(isset($_POST['gridedit']) && $_POST['gridedit']=="save")
        $sql_update_order =mysql_query("update `ety_entitytype` set `ety_Order`=".$_POST['ety_Order']." where ety_Code=".$_POST['etycode']);

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
  $res = sql_select($access_file_level);
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
   <span class="frmheading">Entity Type
    </span>
 <hr size="1" noshade>
<form action="ety_entitytype.php" method="post">
<table align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
 <option value="<?php echo "ety_Description" ?>"<?php if ($filterfield == "ety_Description") { echo "selected"; } ?>>Description</option>
</select></td>
<td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="action" value="Apply Filter"></td>
<td><a href="ety_entitytype.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
 <?php showpagenav($page, $pagecount); ?>
<p>&nbsp;</p>
<br><br>
<table class="fieldtable_outer" align="center"><tr><td>
<td>
<?php 
  if($access_file_level['stf_Add']=="Y")
	  {  
?>
<a href="ety_entitytype.php?a=add" class="hlight"  >
<img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
<?php } ?>
<table  border="0" cellspacing="1" cellpadding="5" class="fieldtable" align="center">
<tr class="fieldheader">
 <th class="fieldheader"><a  href="ety_entitytype.php?order=<?php echo "ety_Description" ?>&type=<?php echo $ordtypestr ?>">Description</a></th>
 <th class="fieldheader"><a href="ety_entitytype.php?order=<?php echo "ety_Order" ?>&type=<?php echo $ordtypestr ?>">Order</a></th>
<th  class="fieldheader" colspan="3" align="center">Actions</th>
</tr>
<?php
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mysql_fetch_assoc($res);
 ?>
<tr>
 <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["ety_Description"]) ?></td>
 <td>
<?php
                                if($_GET['page']!="")
                                    $updatequery="?page=".$_GET['page'];
                                if($_GET['order']!="" && $_GET['type']!="")
                                    $updatequery="?order=".$_GET['order']."&type=".$_GET['type'];

?>
                                <form action="ety_entitytype.php<?php echo $updatequery; ?>" method="post">
                                    <select name="ety_Order" onChange="if(confirm('Save?')){this.form.gridedit.click();} else { location.href='ety_entitytype.php?a=reset'}"  ><option value="0">Select Order</option>
                                    <?php
                                      //  $count = sql_getrecordcount();
                                    $count = mysql_num_rows($res);
                                        for($c=1; $c<=$count; $c++)
                                            {
                                                $val = $c;
                                                if ($row["ety_Order"] == $val) {$selstr = " selected"; } else {$selstr = ""; }

                                    ?>
                                        <option value="<?php echo $c ?>"<?php echo $selstr ?>><?php echo $c ?></option>
                                    <?php } ?>
                                    </select>
                                            <input type="hidden" name="etycode" value="<?php echo $row["ety_Code"]; ?>">
                                            <input type="submit" name="gridedit" value="save">
                                </form>
</td>

 <?php 
  if($access_file_level['stf_View']=="Y")
	  {  
?><td>
<a href="ety_entitytype.php?a=view&recid=<?php echo $i ?>">
<img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>

</td>
<?php } ?>
<?php 
  if($access_file_level['stf_Edit']=="Y")
	  {  
?> 
<td>
<a href="ety_entitytype.php?a=edit&recid=<?php echo $i ?>">
<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
</td>
<?php } ?>
<?php 
  if($access_file_level['stf_Delete']=="Y")
	  {  
?><td>
<a onClick="performdelete('ety_entitytype.php?mode=delete&recid=<?php echo htmlspecialchars($row["ety_Code"]) ?>'); return false;" href="#">
<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
</td>
<?php } ?>
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
<form action="ety_entitytype.php?a=view&recid=<?php echo $recid ?>" method="post">
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
<table align="center" border="0" cellspacing="1" cellpadding="5"width="50%">
 <tr>
<td class="hr">Description</td>
<td class="dr"><?php echo htmlspecialchars($row["ety_Description"]) ?></td>
</tr>
 <tr>
<td class="hr">Order</td>
<td class="dr"><?php echo htmlspecialchars($row["ety_Order"]) ?></td>
</tr>

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
<td class="hr">Description<font style="color:red;" size="2">*</font>
</td>
<td class="dr"><input type="text" name="ety_Description" maxlength="50" value="<?php echo str_replace('"', '&quot;', trim($row["ety_Description"])) ?>">
<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of the entity.</span></a>
</td>
</tr>
<tr>
<td class="hr">Order</td>
		<td>
			<select name="ety_Order">
                            <option value="">Select Order</option>
                                <?php
                                //$count = sql_getrecordcount();
                                $res = sql_select();
                                $count = mysql_num_rows($res);
                                for($i=1; $i<=$count; $i++)
                                {
                                  $val = $i;
                                  if ($row["ety_Order"] == $val) {$selstr = " selected"; } else {$selstr = ""; }

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
<td><a href="ety_entitytype.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
<td><a href="ety_entitytype.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
<?php } } } else { ?>
<td><a href="ety_entitytype.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
<td>&nbsp;<a href="ety_entitytype.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
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
<td><a href="ety_entitytype.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="ety_entitytype.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
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
<?php echo $title?> Entity Type
</span>
<hr size="1" noshade>
<?php } ?>

<?php function addrec()
{
?><br>
<span class="frmheading">
 Add Record
</span><hr size="1" noshade><div style="position:absolute; top:160; right:-50px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form enctype="multipart/form-data" action="ety_entitytype.php" method="post" name="entitytype" onSubmit="return validateFormOnSubmit()">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "ety_Code" => "",
  "ety_Description" => "");
showroweditor($row, false);
?>
<input type="submit" name="action" value="Save" class="button"><input type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton"/> </form>
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
<td><a href="ety_entitytype.php?a=add" class="hlight">Add Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Edit']=="Y")
 {
?>
<td><a href="ety_entitytype.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Delete']=="Y")
 {
?>
<td><a onClick="performdelete('ety_entitytype.php?mode=delete&recid=<?php echo htmlspecialchars($row["ety_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
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
<form enctype="multipart/form-data" action="ety_entitytype.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post" name="entitytype" onSubmit="return validateFormOnSubmit()">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xety_Code" value="<?php echo $row["ety_Code"] ?>">
<?php showroweditor($row, true); ?>
<input type="submit" name="action" value="Update" class="button"><input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/>  </form>
<?php
  mysql_free_result($res);
} ?>

 
<?php  
 
function sql_select($access_file_level)
{
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $commonUses;

  $filterstr = $commonUses->sqlstr($filter);
  if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
  $sql = "SELECT `ety_Code`, `ety_Description`, `ety_Order` FROM `ety_entitytype`";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (`ety_Code` like '" .$filterstr ."') or (`ety_Description` like '" .$filterstr ."')";
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

  $duplicate_entry=$commonUses->checkDuplicate('ety_entitytype','ety_Description',str_replace("'","''",stripslashes(@$_POST["ety_Description"])));
  if($duplicate_entry==0)
   {

  $sql = "insert into `ety_entitytype` (`ety_Code`, `ety_Description`, `ety_Order`) values (" .$commonUses->sqlvalue(@$_POST["ety_Code"], false).", '" .str_replace("'","''",stripslashes(@$_POST["ety_Description"])) ."', ".$commonUses->sqlvalue(@$_POST["ety_Order"], false).")";
  mysql_query($sql) or die(mysql_error());
}
   }

function sql_update()
{
  global $_POST;

  $sql = "update `ety_entitytype` set `ety_Description`='" .str_replace("'","''",stripslashes(@$_POST["ety_Description"])) ."',ety_Order='".$_POST["ety_Order"]."' where " .primarykeycondition();
  mysql_query($sql) or die(mysql_error());
}

function sql_delete($id)
{
   $sql = "delete from `ety_entitytype` where ety_Code='".$id."'";
  if(!mysql_query($sql))
echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
 }
function primarykeycondition()
{
  global $_POST;
  global $commonUses;
  $pk = "";
  $pk .= "(`ety_Code`";
  if (@$_POST["xety_Code"] == "") {
    $pk .= " IS NULL";
  }else{
  $pk .= " = " .$commonUses->sqlvalue(@$_POST["xety_Code"], false);
  };
  $pk .= ")";
  return $pk;
}
 ?>
