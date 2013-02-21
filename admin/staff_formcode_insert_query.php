<?php
include("common/class.Database.php");
$conn=new Database();

$staff = array(24);

foreach($staff as $val)
{
      
      $values = "";
      for($i=1;$i<78;$i++)
      {
         $values .= "($val,$i,'Y','Y','Y','Y',0),";
      }
      $values = substr($values,0,-1);
      $qry = "INSERT INTO stf_staffforms (stf_SCode,stf_FormCode,stf_View,stf_Add,stf_Edit,stf_Delete,stf_SubFormCode) 
              VALUES $values ";
      
      $result_detail_qry = mysql_query($qry);
      //echo mysql_error();
}     
  
  

?>