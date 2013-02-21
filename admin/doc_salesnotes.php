<?php
	require_once('Document/clsMsDocGenerator.php');
        require 'common/class.Database.php';

        $db = new Database();
	$doc = new clsMsDocGenerator();
	
	$titleFormat = array(
							'text-align' 	=> 'center',
							'font-weight' 	=> 'bold',
							'font-size'		=> '30px',
                                                        'font-family'		=> 'Arial,Tahoma, Verdana,  Helvetica, sans-serif',
							'color'			=> '#047ea7');
	$datestyleFormat = array(
							'text-align' 	=> 'right',
							'font-weight' 	=> 'bold',
							'font-size'		=> '13px',
                                                        'font-family'		=> 'Arial,Tahoma, Verdana,  Helvetica, sans-serif');

	$topFormat = array(
							'font-weight' 	=> 'bold',
							'font-size'	=> '13px',
                                                        'font-family'		=> 'Arial,Tahoma, Verdana,  Helvetica, sans-serif');

	$headerFormat = array(
							'font-weight' 	=> 'bold',
							'font-size'		=> '18px',
                                                        'font-family'		=> 'Arial,Tahoma, Verdana,  Helvetica, sans-serif',
							'color'			=> '#84371d');
        $cli_code = $_REQUEST['cli_code'];
        $cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
        $st_query = mysql_query($cli_query);
        $clientName = mysql_fetch_array($st_query);
        $company = $clientName['name'];
        $curdate = date('d-M-Y');

        $doc->addParagraph($company,$topFormat);
        $doc->addParagraph('Report generated at  '.$curdate,$datestyleFormat);
	$doc->addParagraph('Sales Notes',$titleFormat);
	$doc->addParagraph('');
	$doc->addParagraph('Entity Details',$headerFormat);
	
	$doc->startTable();
	$header = array('Task Description','');
	$aligns = array('left','left');
	$valigns = array('middle','middle');
	$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'font-size' => '12pt',
						'height' => '40pt', 'background-color' => '#047ea7', 'text-align' => 'center', 'color' => '#f9fbfc'));
        //details
            $cli_code=$_REQUEST['cli_code'];
            $query = "SELECT * FROM snd_salesdetails where snd_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_inv = mysql_fetch_assoc($result);
            $snd_Code=@mysql_result( $result,0,'snd_Code') ;
            $details_query = "SELECT * FROM snd_salesdetails_details where snd_SNCode =".$snd_Code." order by snd_Code";
            $details_result=@mysql_query($details_query);
            $s=0;
            while ($row_snddetails=mysql_fetch_array($details_result))
            {
                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snd_TaskCode"];
                    $lookupresult=@mysql_query($typequery);
                    $sub_query = mysql_fetch_array($lookupresult);
                    $subtasks = $sub_query['sub_Description'];
                    $subs = array();
                    $subs[] = $subtasks;
                    if($s==0) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==6) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==11) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));

                $query="select tsk_Description from tsk_tasks where tsk_Code=".$row_snddetails["snd_TaskCode"];
                $result=@mysql_query($query);
                $row_taskdetails = @mysql_fetch_array($result);
                $tasks = $row_taskdetails["tsk_Description"];
                $taskval = $row_snddetails["snd_TaskValue"];
                $cols = array($tasks, $taskval);
		$doc->addTableRow($cols, NULL, NULL, array('font-size' => '9pt'));
		unset($cols);
            $s++;
            }
                        $query = "SELECT i1.snd_Code,i2.snd_Notes,i2.snd_IndiaNotes FROM snd_salesdetails AS i1 LEFT OUTER JOIN snd_salesdetails_details AS i2 ON (i1.snd_Code = i2.snd_SNCode) where snd_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);

	$lable_notes = array('Notes',$row_notes['snd_Notes']);
	$doc->addTableRow($lable_notes, NULL, NULL, array('font-size' => '9pt'));
        $lable_indnotes = array('India Notes',$row_notes['snd_IndiaNotes']);
	$doc->addTableRow($lable_indnotes, NULL, NULL, array('font-size' => '9pt'));

	$doc->endTable();
        //Status
	$doc->newPage();
	$doc->addParagraph('Current Status',$headerFormat);

	$doc->startTable();
	$header = array('Task Description','');
	$aligns = array('left','left');
	$valigns = array('middle','middle');
	$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'font-size' => '12pt',
						'height' => '40pt', 'background-color' => '#047ea7', 'text-align' => 'center', 'color' => '#f9fbfc'));
            $query = "SELECT * FROM sns_salesstatus where sns_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_inv = mysql_fetch_assoc($result);
            $sns_Code=@mysql_result( $result,0,'sns_Code') ;
            $details_query = "SELECT * FROM sns_salesstatusdetails where sns_SNCode =".$sns_Code." order by sns_Code";
            $details_result=@mysql_query($details_query);
            $s=0;
            while ($row_snsdetails=mysql_fetch_array($details_result))
            {
                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                    $lookupresult=@mysql_query($typequery);
                    $sub_query = mysql_fetch_array($lookupresult);
                    $subtasks = $sub_query['sub_Description'];
                    $subs = array();
                    $subs[] = $subtasks;
                    if($s==0) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==2) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==3) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==4) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==6) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));

                $query="select tsk_Description from tsk_tasks where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                $result=@mysql_query($query);
                $row_taskdetails = @mysql_fetch_array($result);
                $tasks = $row_taskdetails["tsk_Description"];
                $taskval = $row_snsdetails["sns_TaskValue"];
                $cols = array($tasks, $taskval);
		$doc->addTableRow($cols, NULL, NULL, array('font-size' => '9pt'));
		unset($cols);
            $s++;
            }
                        $query = "SELECT i1.sns_Code,i2.sns_Notes,i2.sns_IndiaNotes FROM sns_salesstatus AS i1 LEFT OUTER JOIN sns_salesstatusdetails AS i2 ON (i1.sns_Code = i2.sns_SNCode) where sns_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);

	$lable_notes = array('Notes',$row_notes['sns_Notes']);
	$doc->addTableRow($lable_notes, NULL, NULL, array('font-size' => '9pt'));
        $lable_indnotes = array('India Notes',$row_notes['sns_IndiaNotes']);
	$doc->addTableRow($lable_indnotes, NULL, NULL, array('font-size' => '9pt'));
	$doc->endTable();
        //Tasks
	$doc->newPage();
	$doc->addParagraph('Tasks',$headerFormat);

	$doc->startTable();
	$header = array('Task Description','');
	$aligns = array('left','left');
	$valigns = array('middle','middle');
	$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'font-size' => '12pt',
						'height' => '40pt', 'background-color' => '#047ea7', 'text-align' => 'center', 'color' => '#f9fbfc'));
            $query = "SELECT * FROM snt_salestasks where snt_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_inv = mysql_fetch_assoc($result);
            $snt_Code=@mysql_result( $result,0,'snt_Code') ;
            $details_query = "SELECT * FROM snt_salestasksdetails where snt_SNCode =".$snt_Code." order by snt_Code";
            $details_result=@mysql_query($details_query);
            $s=0;
            while ($row_sntdetails=mysql_fetch_array($details_result))
            {
                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                    $lookupresult=@mysql_query($typequery);
                    $sub_query = mysql_fetch_array($lookupresult);
                    $subtasks = $sub_query['sub_Description'];
                    $subs = array();
                    $subs[] = $subtasks;
                    if($s==0) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==6) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==10) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==14) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                    if($s==17) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                $query="select tsk_Description from tsk_tasks where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                $result=@mysql_query($query);
                $row_taskdetails = @mysql_fetch_array($result);
                $tasks = $row_taskdetails["tsk_Description"];
                $taskval = $row_sntdetails["snt_TaskValue"];
                $cols = array($tasks, $taskval);
		$doc->addTableRow($cols, NULL, NULL, array('font-size' => '9pt'));
		unset($cols);
            $s++;
            }
                        $query = "SELECT i1.snt_Code,i2.snt_Notes,i2.snt_IndiaNotes FROM snt_salestasks AS i1 LEFT OUTER JOIN snt_salestasksdetails AS i2 ON (i1.snt_Code = i2.snt_SNCode) where snt_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
	$lable_notes = array('Notes',$row_notes['snt_Notes']);
	$doc->addTableRow($lable_notes, NULL, NULL, array('font-size' => '9pt'));
        $lable_indnotes = array('India Notes',$row_notes['snt_IndiaNotes']);
	$doc->addTableRow($lable_indnotes, NULL, NULL, array('font-size' => '9pt'));
	$doc->endTable();
        //Notes
	$doc->newPage();
	$doc->addParagraph('Notes',$headerFormat);

	$doc->startTable();
	$header = array('Task Description','Task Description');
	$aligns = array('left','left');
	$valigns = array('middle','middle');
	$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'font-size' => '12pt',
						'height' => '40pt', 'background-color' => '#047ea7', 'text-align' => 'center', 'color' => '#f9fbfc'));
        $query = "SELECT * FROM snn_salesnotes where snn_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_inv = mysql_fetch_assoc($result);
        $snn_Code=@mysql_result( $result,0,'snn_Code') ;
        $details_query = "SELECT * FROM snn_salesnotesdetails where snn_SNCode =".$snn_Code." order by snn_Code";
        $details_result=@mysql_query($details_query);
            $s=0;
            while ($row_snddetails=mysql_fetch_array($details_result))
            {
                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snn_TaskCode"];
                    $lookupresult=@mysql_query($typequery);
                    $sub_query = mysql_fetch_array($lookupresult);
                    $subtasks = $sub_query['sub_Description'];
                    $subs = array();
                    $subs[] = $subtasks;
                    if($s==0) $doc->addTableRow($subs, NULL, NULL, array('font-size' => '10pt', 'font-weight' => 'bold', 'color' => '#84371d', 'background-color' => '#c6e3ef', 'padding' => '5px 5px 5px 5px'));
                $query="select tsk_Description from tsk_tasks where tsk_Code=".$row_snddetails["snn_TaskCode"];
                $result=@mysql_query($query);
                $row_taskdetails = @mysql_fetch_array($result);
                $tasks = $row_taskdetails["tsk_Description"];
                $taskval = $row_snddetails["snn_TaskValue"];
                $cols = array($tasks, $taskval);
		$doc->addTableRow($cols, NULL, NULL, array('font-size' => '9pt'));
		unset($cols);
            $s++;
            }
                        $query = "SELECT i1.snn_Code,i2.snn_Notes,i2.snn_IndiaNotes FROM snn_salesnotes AS i1 LEFT OUTER JOIN snn_salesnotesdetails AS i2 ON (i1.snn_Code = i2.snn_SNCode) where snn_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
	$lable_notes = array('Notes',$row_notes['snn_Notes']);
	$doc->addTableRow($lable_notes, NULL, NULL, array('font-size' => '9pt'));
        $lable_indnotes = array('India Notes',$row_notes['snn_IndiaNotes']);
	$doc->addTableRow($lable_indnotes, NULL, NULL, array('font-size' => '9pt'));
	$doc->endTable();

	$doc->output('Sales Notes');
?>