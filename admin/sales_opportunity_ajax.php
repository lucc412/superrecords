<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
  $clicode =  $_POST['code'];
  $formType = $_POST['type'];
  if($formType=='cso') {
  $con_id = $_POST['con'];
  $ent_id = $_POST['ent'];
  
    $rep_qry = "SELECT  `con_Code`, `con_Firstname`, `con_Lastname` FROM `con_contact` WHERE con_Company=".$clicode;
    $rep_result = mysql_query($rep_qry);
          $cont = "";
                $cont .= "~~<select name='cso_contact_code' id='cso_contact_code' >";
                $cont .= "<option value='0'>Select Contact</option>";
              while($row = @mysql_fetch_array($rep_result))
              {
                      if($con_id==$row[con_Code]) echo $selected = 'selected'; else $selected = '';
                      $cont .= "<option value='$row[con_Code]' $selected>".$row[con_Firstname]." ".$row[con_Lastname]."</option>";
              }
              $cont .= "</select>";
              // entity type
              $cli_entity = mysql_query("SELECT `inf_EntityType` FROM inf_pinfoentity WHERE inf_ClientCode=".$clicode."");

              $cli_entity = mysql_result($cli_entity, 0, 'inf_EntityType');
              $ent_query = mysql_query("SELECT * FROM ety_entitytype");
                $cont .= "~~<select name='cso_entity' id='cso_entity' >";
                $cont .= "<option value='0'>Select Entity</option>";
              
              while($en_row = mysql_fetch_array($ent_query)) {
                  if($ent_id) { if($ent_id==$en_row[ety_Code]) echo $selected = 'selected'; else $selected = ''; }
                  else { if($cli_entity==$en_row[ety_Code]) echo $selected = 'selected'; else $selected = ''; }
                  $cont .= "<option value='$en_row[ety_Code]' $selected>".$en_row[ety_Description]."</option>";
              }
              $cont .= "</select>";
  }
  else {
    $rep_qry = "SELECT  `con_Code`, `con_Firstname`, `con_Lastname` FROM `con_contact` WHERE con_Company=".$clicode;
    $rep_result = mysql_query($rep_qry);
          $cont = "";
                $cont .= "~~<select name='cso_contact_code' id='cso_contact_code' >";
                $cont .= "<option value='0'>Select Contact</option>";
              while($row = @mysql_fetch_array($rep_result))
              {
                      if($_SESSION['last_con_id']==$row[con_Code]) echo $selected = 'selected'; else $selected = '';
                      $cont .= "<option value='$row[con_Code]' $selected>".$row[con_Firstname]." ".$row[con_Lastname]."</option>";
              }
              $cont .= "</select>";
  }
  echo $cont;
?>