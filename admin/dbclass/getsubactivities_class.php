<?php 
  include '../common/class.Database.php';
  $conn = new Database();
$mastercode=$_GET['mastercode'];
$filename=$_GET['filename'];
$query="SELECT * FROM `sub_subactivity` where sas_Code=".$mastercode." ORDER BY sub_Order ASC";
$result=mysql_query($query);
if($filename=="timesheet")
{
while($row=mysql_fetch_array($result)) {
      echo $row['sub_Code']."|".$row['Code'].($row["Code"]!=""? "-":"").$row['sub_Description']."~";
}
}
else  if($filename=="worksheet")
{
?>
<select name="wrk_SubActivity"  style="width:350px; ">
<option value="0">Select SubActivity</option>
    <?php while($row=mysql_fetch_array($result)) { ?>
    <option value="<?php echo $row['sub_Code']?>"><?php echo $row['Code'].($row["Code"]!=""? "-":"").$row['sub_Description']?></option>
     <?php } ?>
</select>
<?php  } 
else if($filename=="cases")
{
?>
<select name="cas_SubActivity"  style="width:350px; ">
<option value="0">Select SubActivity</option>
    <?php while($row=mysql_fetch_array($result)) { ?>
    <option value="<?php echo $row['sub_Code']?>"><?php echo $row['Code'].($row["Code"]!=""? "-":"").$row['sub_Description']?></option>
     <?php } ?>
</select>
<?php  } 
?>
