<?php
include("common/class.Database.php");
$conn=new Database();

$userquery = "SELECT s1.stf_Code,CONCAT(c1.con_Firstname,' ',c1.con_Lastname) AS Username FROM stf_staff s1 LEFT JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code)";
$userresult = mysql_query($userquery);

$cliquery = "SELECT name FROM jos_users Where name!='' AND cli_Type=5";
$cliresult = mysql_query($cliquery);
$clicount = mysql_num_rows($cliresult);

  $empqry1 = "SELECT name FROM `jos_users` WHERE cli_TeaminCharge='' AND cli_TeamMember='' AND name!='' AND cli_Type=5";
  $empresult1 = mysql_query($empqry1);
  $bothempcount = mysql_num_rows($empresult1);

  $empqry2 = "SELECT name FROM `jos_users` WHERE cli_TeaminCharge='' AND name!='' AND cli_Type=5";
  $empresult2 = mysql_query($empqry2);
  $tcempcount = mysql_num_rows($empresult2);

    $empqry3 = "SELECT name FROM `jos_users` WHERE cli_TeamMember='' AND name!='' AND cli_Type=5";
  $empresult3 = mysql_query($empqry3);
  $tmempcount = mysql_num_rows($empresult3);

$content = "Total ClientType \t with out assign TeaminCharge Client \t with out assign TeamMember Client \t both without assign client \r\n";
$content .= $clicount."\t".$bothempcount."\t".$tcempcount."\t".$tmempcount;
    header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
    header("Content-type: application/x-msexcel");                    // This should work for the rest
    # replace excelfile.xls with whatever you want the filename to default to
    header("Content-Disposition: attachment; filename=ClientName.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $content;
?>
