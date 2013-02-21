<?php   
ob_start();
include("filepdf/fpdf.php");
include("dbclass/commonFunctions_class.php");
session_start();

class PDF extends FPDF
{

//Load data
function Header()
{
//get client name
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
$curdate = date('d-M-Y');
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(212,239,249);
$this->SetFont('Arial','I',7);
$this->SetTextColor(0);
$this->Cell(150,1,$company,0,0,'L',true); $this->Cell(10,1,'Report generated at '.$curdate,0,0,'L',true);
$this->Ln(10);
}

//Colored table
function FancyTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(70,80,80);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}
function EntityTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(30,30,30,30,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],4,$header[$i],1,0,'C',true);
    $this->Ln();
}
//sydney wrap text
	function sydwrapTxt($taskContent,$TaskVal,$stfremark)
        {
		$data[] = array($taskContent, $TaskVal, $stfremark);
		$w = array(70, 80, 40);
		// Mark start coords
		$x = $this->GetX();
		$y = $this->GetY();
		$i = 0;

		foreach($data as $row)
		{
                        $this->Cell($w[0], 9, $row[0], 'LRB');
			$this->Cell($w[1], 9, $row[1], 'LRB');
                        $this->MultiCell($w[2], 3, $row[2], 'LRB');
                        $i++;
                }
        }
function SydneyData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  set_psetup where set_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_set = mysql_fetch_assoc($result);
$set_Code=@mysql_result( $result,0,'set_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM  set_psetupdetails where set_PSCode =".$set_Code." order by set_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(210,4,'Client',1,0,'T',true); $this->Ln(); }
        if($c==5) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(210,4,'Super Records',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["set_TaskCode"]));
        if($task_data['set_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['set_TaskValue']; }
                    if($taskContent=='BGL Login Details') { 
                        $loginval = explode('~',$task_data['set_TaskValue']);
                        $TaskVal = 'Username: '.$loginval[0].", Password: ".$loginval[1];
                    }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
      //  $this->sydwrapTxt($taskContent,$TaskVal,$task_data['set_Remarks']);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->Cell(80,3,$TaskVal,1,0,'T',true);
        $this->Cell(80,3,$task_data['set_Remarks'],1,0,'T',true);
        $this->Ln();
        $c++;
    }
$query = "SELECT i1.set_Code,i2.set_Notes,i2.set_IndiaNotes FROM set_psetup AS i1 LEFT OUTER JOIN set_psetupdetails AS i2 ON (i1.set_Code = i2.set_PSCode) where set_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['set_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['set_IndiaNotes'],'LRB');
}

function TableData()
{
   global $commonUses;
    
$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM inf_pinfo where inf_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_inf = mysql_fetch_assoc($result);
$inf_Code=@mysql_result( $result,0,'inf_Code') ;
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

    $details_query = "SELECT * FROM inf_pinfodetails where inf_PInfoCode =".$inf_Code." order by inf_Code";
    $details_result=mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Client Details',1,0,'T',true); $this->Ln(); }
        if($c==7) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'INCOME',1,0,'T',true); $this->Ln(); }
        if($c==9) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'EXPENSES',1,0,'T',true); $this->Ln(); }
        if($c==11) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Software / Version / Licensing',1,0,'T',true); $this->Ln(); }
       // if($c==16) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Software / Version / Licensing',1,0,'T',true); $this->Ln(); }
      //  if($c==24) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Access to the clients file',1,0,'T',true); $this->Ln(); }
        if($task_data['inf_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['inf_TaskValue']; }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["inf_TaskCode"]));
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
       // $this->Ln();
        $c++;
    }
$query = "SELECT i1.inf_Code,i2.inf_Notes,i2.inf_IndiaNotes FROM inf_pinfo AS i1 LEFT OUTER JOIN inf_pinfodetails AS i2 ON (i1.inf_Code = i2.inf_PInfoCode) where inf_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['inf_Notes'],'LRB');
        //$this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['inf_IndiaNotes'],'LRB');
       // $this->Ln();
}
function CurrentData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM cst_pcurrentstatus where cst_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_cst = mysql_fetch_assoc($result);
$cst_Code=@mysql_result( $result,0,'cst_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM cst_pcurrentstatusdetails where cst_PCSCode =".$cst_Code." order by cst_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Current Status',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["cst_TaskCode"]));
        if($task_data['cst_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['cst_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
       // $this->Ln();
        $c++;
    }
        $query = "SELECT i1.cst_Code,i2.cst_Notes,i2.cst_IndiaNotes FROM cst_pcurrentstatus AS i1 LEFT OUTER JOIN cst_pcurrentstatusdetails AS i2 ON (i1.cst_Code = i2.cst_PCSCode) where cst_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['cst_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->Cell(80,3,$row_notes['cst_IndiaNotes'],'LRB');
}
function BacklogData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_backlog = mysql_fetch_assoc($result);
$blj_Code=@mysql_result( $result,0,'blj_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM blj_pbacklogdetails where blj_PBLCode =".$blj_Code." order by blj_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Backlog Jobsheet',1,0,'T',true); $this->Ln(); }
        if($c==2) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Types of jobs to be done',1,0,'T',true); $this->Ln(); }
      //  if($c==17) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Software',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["blj_TaskCode"]));
        $task_explode = explode("~",$task_data['blj_TaskValue']);
        $task_Val1 = $task_explode[0];
        $task_Val2 = $task_explode[1];
        if($task_data['blj_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_Val1; if(count($task_explode)>1) { if($task_Val1=="Y") { $otherVal = "Yes"; } $TaskVal = $otherVal.".  Other: ".$task_Val2; } else { $TaskVal = $task_Val1; }}
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
       // $this->Ln();
        $c++;
    }
}
function SourceDocumentData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_backlog = mysql_fetch_assoc($result);
$blj_Code=@mysql_result( $result,0,'blj_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

    $details_query = "SELECT * FROM bjs_sourcedocumentdetails where bjs_PBLCode =".$blj_Code." order by bjs_Code asc limit 10";
    $details_result=@mysql_query($details_query);
    while($task_data = mysql_fetch_array($details_result))
    {
        $sourceDoc = $task_data['bjs_SourceDocument'];
        if($sourceDoc=="NULL") { $sourceDoc=""; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$sourceDoc,1,0,'T',true);
        $this->MultiCell(80,3,$task_data['bjs_MethodofDelivery'],'LRB');
      //  $this->Ln();
    }
$query = "SELECT i1.blj_Code,i2.blj_Notes,i2.blj_IndiaNotes FROM blj_pbacklog AS i1 LEFT OUTER JOIN blj_pbacklogdetails AS i2 ON (i1.blj_Code = i2.blj_PBLCode) where blj_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['blj_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['blj_IndiaNotes'],'LRB');
}
function BankData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  ban_pbank where ban_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_ban = mysql_fetch_assoc($result);
$ban_Code=@mysql_result( $result,0,'ban_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM ban_pbankdetails where ban_PBCode =".$ban_Code." order by ban_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Transactions and Bank',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["ban_TaskCode"]));
        if($task_data['ban_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['ban_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
        //$this->Ln();
        $c++;
    }
$query = "SELECT i1.ban_Code,i2.ban_Notes,i2.ban_IndiaNotes FROM ban_pbank AS i1 LEFT OUTER JOIN ban_pbankdetails AS i2 ON (i1.ban_Code = i2.ban_PBCode) where ban_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['ban_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['ban_IndiaNotes'],'LRB');

}
function ArTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(90,80);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}

function ArData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  are_paccountsreceivable where are_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_are = mysql_fetch_assoc($result);
$are_Code=@mysql_result( $result,0,'are_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

 $details_query = "SELECT * FROM `are_paccountsreceivable details` where are_PARCode =".$are_Code." order by are_Code";
		$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Listed Shares',1,0,'T',true); $this->Ln(); }
        if($c==6) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Unlisted Shares',1,0,'T',true); $this->Ln(); }
        if($c==11) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Listed unit trusts',1,0,'T',true); $this->Ln(); }
        if($c==17) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Unlisted unit trusts',1,0,'T',true); $this->Ln(); }
        if($c==22) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Managed Investments',1,0,'T',true); $this->Ln(); }
        if($c==28) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Properties',1,0,'T',true); $this->Ln(); }
        if($c==36) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(170,4,'Investments - Others',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["are_TaskCode"]));
        if($task_data['are_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['are_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(90,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
       // $this->Ln();
        $c++;
    }
$query = "SELECT i1.are_Code,i2.are_Notes,i2.are_IndiaNotes FROM are_paccountsreceivable AS i1 LEFT OUTER JOIN `are_paccountsreceivable details` AS i2 ON (i1.are_Code = i2.are_PARCode) where are_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(90,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['are_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(90,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['are_IndiaNotes'],'LRB');

}
function taskReturnData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM  tar_ptaxreturns where tar_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_tar = mysql_fetch_assoc($result);
$tar_Code=@mysql_result( $result,0,'tar_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM `tar_ptaxreturnsdetails` where tar_PTRCode =".$tar_Code." order by tar_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Tax Returns',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["tar_TaskCode"]));
        if($task_data['tar_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['tar_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
        //$this->Ln();
        $c++;
    }
$query = "SELECT i1.tar_Code,i2.tar_Notes,i2.tar_IndiaNotes FROM tar_ptaxreturns AS i1 LEFT OUTER JOIN tar_ptaxreturnsdetails AS i2 ON (i1.tar_Code = i2.tar_PTRCode) where tar_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['tar_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['tar_IndiaNotes'],'LRB');

}
function basData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM bas_bankaccount where bas_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_cst = mysql_fetch_assoc($result);
$bas_Code=@mysql_result( $result,0,'bas_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM bas_bankaccountdetails where bas_BASCode =".$bas_Code." order by bas_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'GST / IAS',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["bas_TaskCode"]));
        if($task_data['bas_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['bas_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
      //  $this->Ln();
        $c++;
    }
$query = "SELECT i1.bas_Code,i2.bas_Notes,i2.bas_IndiaNotes FROM bas_bankaccount AS i1 LEFT OUTER JOIN bas_bankaccountdetails AS i2 ON (i1.bas_Code = i2.bas_BASCode) where bas_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['bas_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['bas_IndiaNotes'],'LRB');

}
function sTaskData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM spt_specialtasks where spt_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_cst = mysql_fetch_assoc($result);
$spt_Code=@mysql_result( $result,0,'spt_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM spt_specialtasksdetails where spt_SPLCode =".$spt_Code." order by spt_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Special Tasks',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["spt_TaskCode"]));
        if($task_data['spt_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['spt_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(70,3,$taskContent,1,0,'T',true);
        $this->MultiCell(80,3,$TaskVal,'LRB');
       // $this->Ln();
        $c++;
    }
$query = "SELECT i1.spt_Code,i2.spt_Notes,i2.spt_IndiaNotes FROM spt_specialtasks AS i1 LEFT OUTER JOIN spt_specialtasksdetails AS i2 ON (i1.spt_Code = i2.spt_SPLCode) where spt_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(70,3,'Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['spt_Notes'],'LRB');
       // $this->Ln();
        $this->Cell(70,3,'India Notes',1,0,'T',true);
        $this->MultiCell(80,3,$row_notes['spt_IndiaNotes'],'LRB');

}
function tasklistTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(25,25,30,20,15,15,15,15,15,20);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}
function tasklistData()
{
   global $commonUses;

   // get task list value
            $cli_code=$_REQUEST['cli_code'];
            $query = mysql_query("select * from tsk_perminfotasklist where cli_code=".$cli_code."");
            $tsk_row = mysql_fetch_array($query);
            // sub activity
            $sub_activity = explode(',',$tsk_row['sub_activity']);
            $sub_activity8 = explode('~',$sub_activity[0]); $sub_activity9 = explode('~',$sub_activity[1]); $sub_activity10 = explode('~',$sub_activity[2]); $sub_activity11 = explode('~',$sub_activity[3]); $sub_activity12 = explode('~',$sub_activity[4]);
            //befree internal due date
            $int_duedate = explode(',',$tsk_row['befree_internal_due_date']);
            $int_duedate3 = explode('~',$int_duedate[0]); $int_duedate4 = explode('~',$int_duedate[1]); $int_duedate5 = explode('~',$int_duedate[2]); $int_duedate7 = explode('~',$int_duedate[3]); $int_duedate8 = explode('~',$int_duedate[4]); $int_duedate9 = explode('~',$int_duedate[5]); $int_duedate10 = explode('~',$int_duedate[6]); $int_duedate11 = explode('~',$int_duedate[7]); $int_duedate12 = explode('~',$int_duedate[8]);
            //ato due date
            $ato_duedate = explode(',',$tsk_row['ato_due_date']);
            $ato_duedate1 = explode('~',$ato_duedate[0]); $ato_duedate2 = explode('~',$ato_duedate[1]); $ato_duedate3 = explode('~',$ato_duedate[2]); $ato_duedate4 = explode('~',$ato_duedate[3]); $ato_duedate5 = explode('~',$ato_duedate[4]); $ato_duedate7 = explode('~',$ato_duedate[5]); $ato_duedate8 = explode('~',$ato_duedate[6]); $ato_duedate9 = explode('~',$ato_duedate[7]); $ato_duedate10 = explode('~',$ato_duedate[8]); $ato_duedate11 = explode('~',$ato_duedate[9]); $ato_duedate12 = explode('~',$ato_duedate[10]);
            //one off
            $oneoff = explode(',',$tsk_row['one_off']);
            $oneoff1 = explode('~',$oneoff[0]); $oneoff2 = explode('~',$oneoff[1]); $oneoff3 = explode('~',$oneoff[2]); $oneoff4 = explode('~',$oneoff[3]); $oneoff5 = explode('~',$oneoff[4]); $oneoff7 = explode('~',$oneoff[5]); $oneoff8 = explode('~',$oneoff[6]); $oneoff9 = explode('~',$oneoff[7]); $oneoff10 = explode('~',$oneoff[8]); $oneoff11 = explode('~',$oneoff[9]); $oneoff12 = explode('~',$oneoff[10]);
            //monthly
            $monthly = explode(',',$tsk_row['monthly']);
            $monthly1 = explode('~',$monthly[0]); $monthly2 = explode('~',$monthly[1]); $monthly3 = explode('~',$monthly[2]); $monthly4 = explode('~',$monthly[3]); $monthly5 = explode('~',$monthly[4]); $monthly7 = explode('~',$monthly[5]); $monthly8 = explode('~',$monthly[6]); $monthly9 = explode('~',$monthly[7]); $monthly10 = explode('~',$monthly[8]); $monthly11 = explode('~',$monthly[9]); $monthly12 = explode('~',$monthly[10]);
            //quarterly
            $quarterly = explode(',',$tsk_row['quarterly']);
            $quarterly1 = explode('~',$quarterly[0]); $quarterly2 = explode('~',$quarterly[1]); $quarterly3 = explode('~',$quarterly[2]); $quarterly4 = explode('~',$quarterly[3]); $quarterly5 = explode('~',$quarterly[4]); $quarterly7 = explode('~',$quarterly[5]); $quarterly8 = explode('~',$quarterly[6]); $quarterly9 = explode('~',$quarterly[7]); $quarterly10 = explode('~',$quarterly[8]); $quarterly11 = explode('~',$quarterly[9]); $quarterly12 = explode('~',$quarterly[10]);
            //yearly
            $yearly = explode(',',$tsk_row['yearly']);
            $yearly2 = explode('~',$yearly[0]); $yearly3 = explode('~',$yearly[1]); $yearly4 = explode('~',$yearly[2]); $yearly5 = explode('~',$yearly[3]); $yearly7 = explode('~',$yearly[4]); $yearly8 = explode('~',$yearly[5]); $yearly9 = explode('~',$yearly[6]); $yearly10 = explode('~',$yearly[7]); $yearly11 = explode('~',$yearly[8]); $yearly12 = explode('~',$yearly[9]);
            //must
            $must = explode(',',$tsk_row['must']);
            $must2 = explode('~',$must[0]); $must3 = explode('~',$must[1]); $must4 = explode('~',$must[2]); $must5 = explode('~',$must[3]); $must7 = explode('~',$must[4]); $must8 = explode('~',$must[5]); $must9 = explode('~',$must[6]); $must10 = explode('~',$must[7]); $must11 = explode('~',$must[8]); $must12 = explode('~',$must[9]);
            //comments
            $comment = explode(',',$tsk_row['comment']);
            $comment1 = explode('~',$comment[0]); $comment2 = explode('~',$comment[1]); $comment3 = explode('~',$comment[2]); $comment4 = explode('~',$comment[3]); $comment5 = explode('~',$comment[4]); $comment7 = explode('~',$comment[5]); $comment8 = explode('~',$comment[6]); $comment9 = explode('~',$comment[7]); $comment10 = explode('~',$comment[8]); $comment11 = explode('~',$comment[9]); $comment12 = explode('~',$comment[10]);
   
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        
        $this->Cell(25,4,'Preparation of SMSF Accounts',1,0,'T',true);
        $this->Cell(25,4,'Create Tasks for next year',1,0,'T',true);
        $this->Cell(30,4,'15th June every day',1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate1[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff1[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly1[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly1[1]),1,0,'T',true);
        $this->Cell(15,4,'Yearly',1,0,'T',true);
        $this->Cell(15,4,'Must',1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment1[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'Bank Processing',1,0,'T',true);
        $this->Cell(25,4,'Processing SMSF Banks',1,0,'T',true);
        $this->Cell(30,4,'5th of next month',1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate2[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff2[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly2[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly2[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly2[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must2[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment2[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'GST-SMSF Clients',1,0,'T',true);
        $this->Cell(25,4,'BAS',1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate3[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate3[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff3[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly3[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly3[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly3[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must3[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment3[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'',1,0,'T',true);
        $this->Cell(25,4,'IAS',1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate4[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate4[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff4[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly4[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly4[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly4[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must4[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment4[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'SMSF Tax Return',1,0,'T',true);
        $this->Cell(25,4,'Preparation of Tax Return',1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate5[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate5[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff5[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly5[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly5[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly5[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must5[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment5[1]),1,0,'T',true);
        $this->Ln();
        
        $this->SetFillColor(4,126,167);
        $this->SetTextColor(255,255,255);
        $this->SetDrawColor(212,239,249);
        $this->SetLineWidth(.2);
        $this->SetFont('arial','B');
        
        $this->Cell(25,5,'Misc Tasks',1,0,'C',true);
        $this->Cell(25,5,'',1,0,'T',true);
        $this->Cell(30,5,'',1,0,'T',true);
        $this->Cell(20,5,'',1,0,'T',true);
        $this->Cell(15,5,'',1,0,'T',true);
        $this->Cell(15,5,'',1,0,'T',true);
        $this->Cell(15,5,'',1,0,'T',true);
        $this->Cell(15,5,'',1,0,'T',true);
        $this->Cell(15,5,'',1,0,'T',true);
        $this->Cell(20,5,'',1,0,'T',true);
        $this->Ln();
        
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        
        $this->Cell(25,4,'Backlog',1,0,'T',true);
        $this->Cell(25,4,'Create tasks for all agreed work we have to do for backlog',1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate7[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate7[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff7[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly7[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly7[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly7[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must7[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment7[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'2',1,0,'T',true);
        $this->Cell(25,4,stripslashes($sub_activity8[1]),1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate8[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate8[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff8[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly8[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly8[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly8[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must8[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment8[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'3',1,0,'T',true);
        $this->Cell(25,4,stripslashes($sub_activity9[1]),1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate9[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate9[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff9[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly9[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly9[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly9[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must9[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment9[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'4',1,0,'T',true);
        $this->Cell(25,4,stripslashes($sub_activity10[1]),1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate10[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate10[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff10[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly10[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly10[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly10[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must10[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment10[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'5',1,0,'T',true);
        $this->Cell(25,4,stripslashes($sub_activity11[1]),1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate11[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate11[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff11[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly11[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly11[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly11[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must11[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment11[1]),1,0,'T',true);
        $this->Ln();
        $this->Cell(25,4,'6',1,0,'T',true);
        $this->Cell(25,4,stripslashes($sub_activity12[1]),1,0,'T',true);
        $this->Cell(30,4,stripslashes($int_duedate12[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($ato_duedate12[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($oneoff12[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($monthly12[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($quarterly12[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($yearly12[1]),1,0,'T',true);
        $this->Cell(15,4,stripslashes($must12[1]),1,0,'T',true);
        $this->Cell(20,4,stripslashes($comment12[1]),1,0,'T',true);
        $this->Ln();
        
        $this->Cell(25,4,'Notes',1,0,'T',true);
        $this->MultiCell(55,4,stripslashes($tsk_row['tsk_notes']),'LRB');
        //$this->Ln();
        $this->Cell(25,4,'India Notes',1,0,'T',true);
        $this->MultiCell(55,4,stripslashes($tsk_row['tsk_india_notes']),'LRB');
        
}
function dueDateTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(30,55,55,59);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}
function dueDateData()
{
   global $commonUses;

$cli_code=$_REQUEST['cli_code'];
$query = "SELECT * FROM ddr_duedatereports where ddr_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_cst = mysql_fetch_assoc($result);
$ddr_Code=@mysql_result( $result,0,'ddr_Code') ;

    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);

$details_query = "SELECT * FROM ddr_duedatereportsdetails where ddr_DDCode =".$ddr_Code." order by ddr_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',9); $this->SetTextColor(148,43,14); $this->Cell(199,4,'Tasks list for befree',1,0,'T',true); $this->Ln(); }
        if($c==5) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',9); $this->SetTextColor(148,43,14); $this->Cell(199,4,'Tasks list for client admin',1,0,'T',true); }
        if($c==6) { $this->SetFillColor(4,126,167); $this->SetFont('arial','B',7); $this->SetTextColor(255,255,255); $this->SetDrawColor(212,239,249); $this->Cell(30,10,'Cycle',1,0,'C',true); $this->Cell(55,10,'Documents to be sent to befree',1,0,'C',true); $this->Cell(55,10,'Due Day',1,0,'C',true); $this->Cell(59,10,'Internal Process / Delivery method',1,0,'C',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["ddr_TaskCode"]));
        if($task_data['ddr_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['ddr_TaskValue']; }
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(30,3,$taskContent,1,0,'T',true);
        $this->Cell(55,3,$TaskVal,1,0,'T',true);
        $this->Cell(55,3,$task_data['ddr_DuedaySend'],1,0,'T',true);
        $this->Cell(59,3,$task_data['ddr_WorkDone'],1,0,'T',true);
        $this->Ln();
        $c++;
    }
$query = "SELECT i1.ddr_Code,i2.ddr_Notes,i2.ddr_IndiaNotes FROM ddr_duedatereports AS i1 LEFT OUTER JOIN ddr_duedatereportsdetails AS i2 ON (i1.ddr_Code = i2.ddr_DDCode) where ddr_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);
        $this->Cell(30,3,'Notes',1,0,'T',true);
        $this->MultiCell(55,3,$row_notes['ddr_Notes'],'LRB');
        //$this->Ln();
        $this->Cell(30,3,'India Notes',1,0,'T',true);
        $this->MultiCell(55,3,$row_notes['ddr_IndiaNotes'],'LRB');
}

}
$pdf=new PDF();
            $formcode=$commonUses->getFormCode("Set up Syd");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_syd=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Permanent Information");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_perminfo=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                //Get FormCode
            $formcode=$commonUses->getFormCode("Current Status");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_curst=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Estimated hours");
            $commonUses->checkFileAccess($_SESSION['staffcode'],$estimateformcode);
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_estimate=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            $formcode=$commonUses->getFormCode("Back Log Jobsheet");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_blj=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("General Info");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_gen=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Bank");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_ban=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("AP");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_ape=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Investments");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_are=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Payroll");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_pay=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("BAS");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_bas=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Tax Returns");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_tax=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Special tasks");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_specialtasks=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Task List");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_duedate=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

	if(($access_file_level_syd['stf_Add']=="Y" || $access_file_level_syd['stf_View']=="Y" || $access_file_level_syd['stf_Edit']=="Y" || $access_file_level_syd['stf_Delete']=="Y"))
	{

//set up sydney
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Set up Sydney');
$pdf->Ln();
$header=array('Task Description',' ','Remarks');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->SydneyData();
        }
//permanent info
	if(($access_file_level_perminfo['stf_Add']=="Y" || $access_file_level_perminfo['stf_View']=="Y" || $access_file_level_perminfo['stf_Edit']=="Y" || $access_file_level_perminfo['stf_Delete']=="Y"))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Permanent Information');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
//$pdf->SetFont('Arial','',6);
$pdf->TableData();
$pdf->Ln();
       $cli_code=$_REQUEST['cli_code'];
       $qcard_qry = "select crd_EntityType from crd_qcardfile WHERE crd_ClientCode='$cli_code' ";
       $qcard_result = @mysql_query($qcard_qry);
       $ent_type = mysql_fetch_array($qcard_result);
       $entity_type = $ent_type['crd_EntityType'];
       switch($entity_type)
       {
         case 1:
            $title = "Director";
            $entity = true;
            //$rows = 4;
            break;

         case 2:
            $title = "Sole Trader";
            $entity = true;
           // $rows = 1;
            break;

         case 3:
            $title = "Partnership";
            $entity = true;
           // $rows = 4;
            break;
         default:
           $entity = false;

       }
        }
//current status
	if(($access_file_level_curst['stf_Add']=="Y" || $access_file_level_curst['stf_View']=="Y" || $access_file_level_curst['stf_Edit']=="Y" || $access_file_level_curst['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Current Status');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->CurrentData();
        }
//backlog jobsheet
	if(($access_file_level_blj['stf_Add']=="Y" || $access_file_level_blj['stf_View']=="Y" || $access_file_level_blj['stf_Edit']=="Y" || $access_file_level_blj['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Back Log Jobsheet');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->BacklogData();
$pdf->Ln();
$header=array('Source documents needed','Method of delivery(attached / to come)');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->SourceDocumentData();
        }
//bank
	if(($access_file_level_ban['stf_Add']=="Y" || $access_file_level_ban['stf_View']=="Y" || $access_file_level_ban['stf_Edit']=="Y" || $access_file_level_ban['stf_Delete']=="Y" ))
	{
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'BANK');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->BankData();
        }
//Investments
	if(($access_file_level_are['stf_Add']=="Y" || $access_file_level_are['stf_View']=="Y" || $access_file_level_are['stf_Edit']=="Y" || $access_file_level_are['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Investments');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->ArTable($header);
$pdf->ArData();
        }
//tax return
	if(($access_file_level_tax['stf_Add']=="Y" || $access_file_level_tax['stf_View']=="Y" || $access_file_level_tax['stf_Edit']=="Y" || $access_file_level_tax['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Tax Returns');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->taskReturnData();
        }
//BAS
	if(($access_file_level_bas['stf_Add']=="Y" || $access_file_level_bas['stf_View']=="Y" || $access_file_level_bas['stf_Edit']=="Y" || $access_file_level_bas['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'BAS');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->basData();
        }
//special tasks
	if(($access_file_level_specialtasks['stf_Add']=="Y" || $access_file_level_specialtasks['stf_View']=="Y" || $access_file_level_specialtasks['stf_Edit']=="Y" || $access_file_level_specialtasks['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Special Tasks');
$pdf->Ln();
$header=array('Task Description',' ');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
$pdf->sTaskData();
        }
//task list
	if(($access_file_level_duedate['stf_Add']=="Y" || $access_file_level_duedate['stf_View']=="Y" || $access_file_level_duedate['stf_Edit']=="Y" || $access_file_level_duedate['stf_Delete']=="Y" ))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Task List');
$pdf->Ln();
$header=array('Master Activity','S Activity/Notes','Internal Due Date','ATO Due Date','One off','Monthly','Quarterly','Yearly','Must','Comment');
$pdf->SetFont('Arial','B',7);
$pdf->tasklistTable($header);
$pdf->tasklistData();
        }
$pdf->Output('perminfo.pdf');

 header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="perminfo.pdf"');
// The PDF source is in original.pdf
readfile('perminfo.pdf');

?>

