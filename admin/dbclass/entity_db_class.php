<?php
  ob_start();
  include '../common/class.Database.php';
  $conn = new Database();
  $sno = $_GET['sno'];
  $type = $_GET['type'];
  $cli_code = $_POST['cli_code'];
  $entity = $_POST['entity']; 
  $fname = "fname_".$sno;
  $firstname = $_POST[$fname];
  $lname = "lname_".$sno;
  $lastname = $_POST[$lname];
  $date = "date_".$sno;
  $date = $_POST[$date];
  if($date != "")
  {
    $date_split = explode("/",$date);
    $date = date("Y-m-d",mktime(0,0,0,$date_split[1],$date_split[0],$date_split[2]));
  }
  $tfn = "tfn_".$sno;
  $tfn = $_POST[$tfn];
  $hid = "hid_".$sno;
  $hid = $_POST[$hid];
 
  if($type == "save")
  {
     if($hid != "")
     {
      
        $qry = "UPDATE inf_pinfoentity SET inf_ClientCode='$cli_code',inf_EntityType='$entity',inf_FirstName='$firstname',inf_LastName='$lastname',inf_DOB='$date',inf_TFN='$tfn' WHERE inf_Code='$hid' ";
     }
     else
     {
        $qry = "INSERT into inf_pinfoentity(inf_ClientCode,inf_EntityType,inf_FirstName,inf_LastName,inf_DOB,inf_TFN) values($cli_code,$entity,'$firstname','$lastname','$date','$tfn')";
     }
     
     $result = mysql_query($qry);
     //echo mysql_error();
     header("location:../cli_client.php?a=edit&cli_code=$cli_code&page=1");
     exit;
  }
  else if($type == "delete")
  {
       $qry = "DELETE from inf_pinfoentity WHERE inf_Code='$hid' ";
       $result = mysql_query($qry);
       header("location:../cli_client.php?a=edit&cli_code=$cli_code&page=1");
       exit;
  } 
  
   
  
?>