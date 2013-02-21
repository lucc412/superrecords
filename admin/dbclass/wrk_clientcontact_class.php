<?php
session_start();
  include '../common/class.Database.php';
  $conn1 = new Database();
  $clientcode=$_GET['clientcode'];
  $filename=$_GET['filename'];
  if($_SESSION['usertype']=="Administrator")
  {
    $query = "select `con_Code`, `con_Firstname` from `con_contact` where con_Company=".$clientcode;
  }
  else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
  {
    $query = "select `con_Code`, `con_Firstname` from `con_contact` where con_Type=2 and con_Company=".$clientcode;
  }
  else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
  {
    $query = "select `con_Code`, `con_Firstname` from `con_contact` where con_Company=".$clientcode;
  }
      $conresult = mysql_query($query) or die(mysql_error());
if($filename=="worksheet")
{
?>
<select name="wrk_ClientContact"  ><option value="0">Select Contact</option>
<?php
  while ($lp_row = mysql_fetch_assoc($conresult))
  {
 ?><option value="<?php echo $lp_row["con_Code"]; ?>"><?php echo $lp_row["con_Firstname"]; ?></option>
<?php } ?></select>
<?php  } 
else if($filename=="cases")
{
?>
<select name="cas_ClientContact"><option value="0">Select Contact</option>
    <?php
      while ($lp_row = mysql_fetch_assoc($conresult))
      {
     ?><option value="<?php echo $lp_row["con_Code"]; ?>"><?php echo $lp_row["con_Firstname"];; ?></option>
    <?php } ?>
</select>
<?php  } 
?>