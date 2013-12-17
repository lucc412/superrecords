<?php 
     include 'dbclass/commonFunctions_class.php';
	 include ("includes/header.php");
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
<br/>

<?php
   $myip = gethostbyname($_SERVER['SERVER_NAME']);

  //Get FormCode
  $formcode=$commonUses->getFormCode("IP Address");

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
 }  
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
	<h1>IP Address</h1>
</div>
<form action="stf_ipaddress.php" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "stf_IPowner" ?>"<?php if ($filterfield == "stf_IPowner") { echo "selected"; } ?>>Owner</option>
 
 <option value="<?php echo "stf_From_ip" ?>"<?php if ($filterfield == "stf_From_ip") { echo "selected"; } ?>>From IP Address</option>
  <option value="<?php echo "stf_To_ip" ?>"<?php if ($filterfield == "stf_To_ip") { echo "selected"; } ?>>To IP Address</option>

</select></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="stf_ipaddress.php?a=reset" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
 <p>&nbsp;</p>

<br><br>
<?php 
  if($access_file_level['stf_Add']=="Y")
	  {  
?>
<a href="stf_ipaddress.php?a=add" class="hlight"  ><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
<?php } ?>
<?php showpagenav($page, $pagecount); ?><br>
<br>
<table width="100%" class="fieldtable" cellspacing="1" cellpadding="5" align="center"  >
<tr align="left" class="fieldheader">
    <th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_own');">Owner of the IP <img id="sort_own" src="images/sort_asc.png"></th>

 <th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_ip');">From IP Address <img id="sort_ip" src="images/sort_asc.png"></th>
 <th class="fieldheader sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_to');">To IP Address <img id="sort_to" src="images/sort_asc.png"></th>
<td class="fieldheader" colspan="3" align="center">Actions</td>
</tr>
<?php
  $countRow = 0;
  for ($i = $startrec; $i < $reccount; $i++)
  {
	if($countRow%2 == 0) $trClass = "trcolor";
	else $trClass = "";

    $row = mysql_fetch_assoc($res);
    
 ?>
<tr class="<?=$trClass?>">
    <td><?php echo htmlspecialchars($row["stf_IPowner"]); ?></td>
<td><?php echo htmlspecialchars($row["From_ip"]); ?></td>
<td><?php echo htmlspecialchars($row["To_ip"]); ?></td>
<?php 
  if($access_file_level['stf_View']=="Y")
	  {  
?>
<td align="center"><a href="stf_ipaddress.php?a=view&recid=<?php echo $i ?>"><img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a></td>
<?php }?>
<?php 
  if($access_file_level['stf_Edit']=="Y")
	  {  
?>
<td align="center"><a href="stf_ipaddress.php?a=edit&recid=<?php echo $i ?>"><img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a></td>
<?php } ?>
<?php 
  if($access_file_level['stf_Delete']=="Y")
	  {  
?>
<td align="center"><a onClick="performdelete('stf_ipaddress.php?mode=delete&recid=<?php echo htmlspecialchars($row["stf_IPcode"]) ?>'); return false;" href="#"><img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a></td>
<?php }?>
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
<form action="stf_ipaddress.php?a=view&recid=<?php echo $recid ?>" method="post">
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
<table border="0" cellspacing="10" cellpadding="5"width="50%" align="center" >
    <tr>
<td class="hr">Owner of the IP</td>
<td class="dr"><?php echo htmlspecialchars($row["stf_IPowner"]); ?></td>
</tr>
 <tr>
<td class="hr">From IP Address</td>
<td class="dr"><?php echo htmlspecialchars($row["From_ip"]); ?></td>
</tr>
 <tr>
<td class="hr">To IP Address</td>
<td class="dr"><?php echo htmlspecialchars($row["To_ip"]); ?></td>
</tr>

</table>
<?php } ?>

<?php function showroweditor($row, $iseditmode)
  {
?>
<table border="0" cellspacing="10" cellpadding="5"width="100%">
<?php 
if(!$iseditmode) { 
?>
<tr>
<td class="hr" style="width:12%">Code</td>
<td class="dr"><?php echo "New";}?></td>
</tr>
<tr>
<td class="hr" style="width:12%">Owner</td>
<td class="dr"> <input type="text" name="stf_IPowner" maxlength="100" size="25" value="<?php echo $row['stf_IPowner']; ?>" ></td>
</tr>
<tr>
<td class="hr" style="width:5%">From IP Address<font style="color:red;" size="2">*</font></td>
<td class="dr">
    <?php
    $from_ip = explode(".",$row["From_ip"]);
    ?>
    <input type="text" name="stf_From_ip1" maxlength="3" size="3" value="<?php echo $from_ip[0]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_From_ip2" maxlength="3" size="3" value="<?php echo $from_ip[1]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_From_ip3" maxlength="3" size="3" value="<?php echo $from_ip[2]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_From_ip4" maxlength="3" size="3" value="<?php echo $from_ip[3]; ?>" onkeypress='return isNumberKey(event)'>
        <?php
if($row["To_ip"]=="")
    {
    ?>
        <a href="#" onclick="SelectIP()" class="hlight" id="or_lable">Select Range</a>
        <?php } ?>
</td>
</tr>
<?php
if($row["To_ip"]!="")
    {
    $style="";
}
else
    {
    $style="display:none";
}
?>
<tr>
    <td class="hr" id="show_lable" style="<?php echo $style?>" nowrap>To IP Address<font style="color:red;" size="2">*</font></td>
    <td class="dr" id="show_Range" style="<?php echo $style?>" nowrap>
    <?php
    $to_ip = explode(".",$row["To_ip"]);
    ?>

        <input type="text" name="stf_To_ip1" maxlength="3" size="3" value="<?php echo $to_ip[0]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_To_ip2" maxlength="3" size="3" value="<?php echo $to_ip[1]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_To_ip3" maxlength="3" size="3" value="<?php echo $to_ip[2]; ?>" onkeypress='return isNumberKey(event)'>&nbsp;.&nbsp;
        <input type="text" name="stf_To_ip4" maxlength="3" size="3" value="<?php echo $to_ip[3]; ?>" onkeypress='return isNumberKey(event)'>
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
<td><a href="stf_ipaddress.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
<td><a href="stf_ipaddress.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
<?php } } } else { ?>
<td><a href="stf_ipaddress.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
<td>&nbsp;<a href="stf_ipaddress.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
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
<td><a href="stf_ipaddress.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="stf_ipaddress.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
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
<div class="frmheading">
	<h1><?=$title?> IP Address</h1>
</div>
<?php } ?>

<?php function addrec()
{
 ?>
<div class="frmheading">
	<h1>Add Record</h1>
</div>
<div style="position:absolute; top:20; right:0px; width:300; height:300;">
	<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
</div>
<form enctype="multipart/form-data" action="stf_ipaddress.php" method="post" name="ipaddress" onSubmit="return Validateip()">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(

  "stf_IPcode" => "",
     "stf_IPowner" => "",
  "stf_From_ip" => "",
  "stf_To_ip" => "");
showroweditor($row, false);
?>
<button style="margin-right:32px;" type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
<button type="submit" name="action" value="Save" class="button">Save</button></form>
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
<div class="frmheading">
	<h1></h1>
</div>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<?php
if($access_file_level['stf_Add']=="Y")
 {
?>
<td><a href="stf_ipaddress.php?a=add" class="hlight">Add Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Edit']=="Y")
 {
?>
<td><a href="stf_ipaddress.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
<?php } ?>
<?php
if($access_file_level['stf_Delete']=="Y")
 {
?>
<td><a onClick="performdelete('stf_ipaddress.php?mode=delete&recid=<?php echo htmlspecialchars($row["stf_IPcode"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
<?php } ?>
</tr>
</table>
<?php
  mysql_free_result($res);
} ?>

<?php function editrec($recid)
{
 
  $res = sql_select();
  //$count = sql_getrecordcount();
  $count = mysql_num_rows($res);
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("edit", $recid, $count);
?><div style="position:absolute; top:5; right:0px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form enctype="multipart/form-data" action="stf_ipaddress.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post" name="ipaddress" onSubmit="return Validateip()">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xstf_IPcode" value="<?php echo $row["stf_IPcode"] ?>">
<?php showroweditor($row, true); ?>
<button style="margin-right:32px;" type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
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
  $sql = "SELECT stf_IPcode,stf_IPowner,INET_NTOA(`stf_From_ip`) as From_ip,INET_NTOA(`stf_To_ip`) as To_ip FROM `stf_ipaddress`";
  if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
    $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
  } elseif (isset($filterstr) && $filterstr!='') {
    $sql .= " where (`stf_IPcode` like '" .$filterstr ."') or (`stf_IPowner` like '" .$filterstr ."') or (`stf_From_ip` like '" .$filterstr ."') or (`stf_To_ip` like '" .$filterstr ."')";
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

  $fip1 = $_POST['stf_From_ip1'];
  $fip2 = $_POST['stf_From_ip2'];
  $fip3 = $_POST['stf_From_ip3'];
  $fip4 = $_POST['stf_From_ip4'];
  $from_ip = $fip1.".".$fip2.".".$fip3.".".$fip4;

  $tip1 = $_POST['stf_To_ip1'];
  $tip2 = $_POST['stf_To_ip2'];
  $tip3 = $_POST['stf_To_ip3'];
  $tip4 = $_POST['stf_To_ip4'];
  $to_ip = $tip1.".".$tip2.".".$tip3.".".$tip4;

  $duplicate_entry=$commonUses->checkDuplicate('stf_ipaddress','stf_From_ip',$from_ip);
  if($duplicate_entry==0)
   {

   $sql = "insert into `stf_ipaddress` (`stf_IPcode`, `stf_IPowner`,`stf_From_ip`, `stf_To_ip`) values (" .$commonUses->sqlvalue(@$_POST["stf_IPcode"], false).",'".str_replace("'","",stripslashes($_POST['stf_IPowner']))."', INET_ATON('" .$commonUses->sqlvalue($from_ip, false)."'), INET_ATON('" .$commonUses->sqlvalue($to_ip, false)."'))";

  mysql_query($sql) or die(mysql_error());
}
  }

function sql_update()
{
  global $_POST;
  global $commonUses;
//From IP Address
  $fip1 = $_POST['stf_From_ip1'];
  $fip2 = $_POST['stf_From_ip2'];
  $fip3 = $_POST['stf_From_ip3'];
  $fip4 = $_POST['stf_From_ip4'];
  $from_ip = $fip1.".".$fip2.".".$fip3.".".$fip4;
//To IP Address
  $tip1 = $_POST['stf_To_ip1'];
  $tip2 = $_POST['stf_To_ip2'];
  $tip3 = $_POST['stf_To_ip3'];
  $tip4 = $_POST['stf_To_ip4'];
  $to_ip = $tip1.".".$tip2.".".$tip3.".".$tip4;

  $sql = "update `stf_ipaddress` set `stf_IPowner`='".str_replace("'","",stripslashes($_POST['stf_IPowner']))."',`stf_From_ip`=INET_ATON('" .$commonUses->sqlvalue($from_ip, false)."'),`stf_To_ip`=INET_ATON('" .$commonUses->sqlvalue($to_ip, false)."') where " .primarykeycondition();
  mysql_query($sql) or die(mysql_error());
}

function sql_delete($id)
{
   $sql = "delete from `stf_ipaddress` where stf_IPcode='".$id."'";
  if(!mysql_query($sql))
echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
 }
function primarykeycondition()
{
  global $_POST;
  global $commonUses;
  $pk = "";
  $pk .= "(`stf_IPcode`";
  if (@$_POST["xstf_IPcode"] == "") {
    $pk .= " IS NULL";
  }else{
  $pk .= " = " .$commonUses->sqlvalue(@$_POST["xstf_IPcode"], false);
  };
  $pk .= ")";
  return $pk;
}
 ?>
