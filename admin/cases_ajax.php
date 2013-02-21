<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
  $clicode =  $_POST['code'];
  
    $rep_qry = "SELECT  `con_Code`, `con_Firstname`, `con_Lastname` FROM `con_contact` WHERE con_Company=".$clicode;
    $rep_result = mysql_query($rep_qry);
    $query = "SELECT cli_Assignedto,cli_AssignAustralia,cli_TeaminCharge,cli_TeamMember,cli_BillingPerson,cli_Salesperson,cli_SeniorInCharge FROM jos_users WHERE cli_Code=".$clicode;
    $result = mysql_query($query);
    $name = @mysql_fetch_array($result);
          $cont = "";
                $cont .= "<select name='cas_ClientContact' id='cas_ClientContact' >";
                $cont .= "<option value='0'>Select Contact</option>";
              while($row = @mysql_fetch_array($rep_result))
              {
                      $cont .= "<option value='$row[con_Code]'>".$row[con_Firstname]." ".$row[con_Lastname]."</option>";
              }
              $cont .= "</select>";
              $cont .= "~~".$name['cli_AssignAustralia'];
              $cont .= "~~".$name['cli_Assignedto'];
              $cont .= "~~".$name['cli_TeaminCharge'];
              $cont .= "~~".$name['cli_TeamMember'];
              $cont .= "~~".$name['cli_BillingPerson'];
              $cont .= "~~".$name['cli_Salesperson'];
              $cont .= "~~".$name['cli_SeniorInCharge'];
  echo $cont;
?>