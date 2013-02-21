<?php
include("common/class.Database.php");
$conn=new Database();

$userquery = "SELECT s1.stf_Code,CONCAT(c1.con_Firstname,' ',c1.con_Lastname) AS Username FROM stf_staff s1 LEFT JOIN con_contact AS c1 ON(s1.stf_CCode = c1.con_Code)";
$userresult = mysql_query($userquery);
$uid = array();
$label[1] = "India Manager";
$label[2] = "Australia Manager";
$label[3] = "Team Member";
$label[4] = "TeaminCharge";
$label[5] = "BillingPerson";
$label[6] = "Sales Person";

$i=1;
$clients = array();
$content = "No \t Staff Name \t Staff Id \t Total Record \t Company Name \t Staff's Role \r\n";
while (list($userid,$username) = mysql_fetch_array($userresult))
{
  $qry1 = "SELECT name,cli_Assignedto,cli_AssignAustralia,cli_TeamMember,cli_TeaminCharge,cli_BillingPerson,cli_Salesperson FROM `jos_users` WHERE cli_Assignedto=".$userid." OR cli_AssignAustralia=".$userid." OR cli_TeaminCharge=".$userid." OR cli_TeamMember=".$userid." OR cli_BillingPerson=".$userid." OR cli_Salesperson=".$userid."";
    $result1 = mysql_query($qry1);
    $count = mysql_num_rows($result1);
    $content .= $i."\t".$username."\t".$userid."\t".$count."\r\n";
    while (list($name,$im,$am,$tm,$ti,$bp,$sp) = mysql_fetch_array($result1))
    {
        $role = array();
        $content .= "\t\t\t\t".$clients[$userid]['name'] = $name;
        if($im == $userid)
            $role[] = $label[1];
        if($am == $userid)
            $role[] = $label[2];
        if($tm == $userid)
            $role[] = $label[3];
        if($ti == $userid)
            $role[] = $label[4];
        if($bp == $userid)
            $role[] = $label[5];
        if($sp == $userid)
            $role[] = $label[6];
       $content .= "\t".implode(",",$role)."\r\n";
    }
    $i++;
       $content .= "\n";
}
    header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
    header("Content-type: application/x-msexcel");                    // This should work for the rest
    # replace excelfile.xls with whatever you want the filename to default to
    header("Content-Disposition: attachment; filename=ClientName.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $content;
?>
