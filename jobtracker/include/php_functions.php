<?php

//It will Check Given Event is Active or Not it will Return Status Event according Event Id is Givent as Argument to Function
function getEventStatus($pageCode) 
{
	//It will Generate Query to Fetch Event Record based on Event ID Given	
	$query = "SELECT event_status 
			  FROM email_events 
			  WHERE event_code = '{$pageCode}'";
		  
	$runquery = mysql_query($query);
	while($myRow = mysql_fetch_assoc($runquery))
	{
		//It will Store Event Status
		$eventStatus = $myRow['event_status'];
	}
		
	//Return the Status of Given Event Id
    return $eventStatus;
}

//It is Used to Get Email Id of Practice Login User it will Return Email Id of Practice User
function get_email_id($pr_id)
{
	//It will Give Email id of Practice Login User 	
	$myQueryPrId = "SELECT email 
					FROM pr_practice 
					WHERE id = '$pr_id'";

	$myRunQueryPrId = mysql_query($myQueryPrId);
	$fetchRow = mysql_fetch_assoc($myRunQueryPrId);
	 $prEmailId = $fetchRow['email'];

	//It will Return Email Id of Practice User
	return $prEmailId;
}

//It will Get All Information Regarding Event like TO , FROM , CC , Subject , Message etc It will Return all those Details in Array Form.
function get_email_info($pageCode)
{
	//It will Generate Query and will get Require Details From Database
	$myQuery = "SELECT event_name,event_subject,event_content, event_cc, event_from, event_bcc
				FROM email_events 
				WHERE event_code = '{$pageCode}'";
	
	$runQuery = mysql_query($myQuery);
	$arrEmailInfo = mysql_fetch_assoc($runQuery);
		
	//It will Return all Necessary Information in form of Array
	return $arrEmailInfo;
}

function fetchEntityName($entityId, $flagType) {	
	
	if($flagType == 'P') {
		$selStr = "p.name";
		$frmStr = "pr_practice p";
		$whrStr = "p.id = {$entityId}";
	}
	else if($flagType == 'C') {
		$selStr = "c.client_name name";
		$frmStr = "client c";
		$whrStr = "c.client_id = {$entityId}";
	}
	else if($flagType == 'J') {
		$selStr = "j.job_name name";
		$frmStr = "job j";
		$whrStr = "j.job_id = {$entityId}";
	}
	else if($flagType == 'T') {
		$selStr = "t.task_name name";
		$frmStr = "task t";
		$whrStr = "t.task_id = {$entityId}";
	}

	$qrySel = "SELECT {$selStr}
				FROM {$frmStr}
				WHERE {$whrStr}";
		
	$fetchResult = mysql_query($qrySel);		
	$rowData = mysql_fetch_assoc($fetchResult);
	$entityName = $rowData['name'];
	
	return $entityName;	
}

function fetchStaffInfo($staffId, $flagType) {	
	
	if($flagType == 'email') {
		$selStr = "cc.con_Email staffInfo";
	}
	else if($flagType == 'name') {
		$selStr = "CONCAT_WS(' ',cc.con_Firstname,cc.con_Middlename,cc.con_Lastname) staffInfo";
	}

	$qrySel = "SELECT {$selStr}
				FROM stf_staff ss, con_contact cc
				WHERE ss.stf_CCode = cc.con_Code
				AND ss.stf_Code = {$staffId}";
				
	$fetchResult = mysql_query($qrySel);		
	$rowData = mysql_fetch_assoc($fetchResult);
	$staffInfo = $rowData['staffInfo'];
	
	return $staffInfo;	
}

// fetch sr manager, india manager, sales manager, team member for selected practice
function fetch_prac_designation($practiceId, $flSrMngr=false, $flSalesPerson=false, $flInMngr=false, $flAdtMngr=false) {
	
	// fetch array of name of all employees
	$arrEmployees = fetchEmployees();

	$sql = "SELECT sr_manager, india_manager, sales_person, audit_manager
			FROM pr_practice
			WHERE id=".$practiceId;
			
	$res = mysql_query($sql) or die(mysql_error());
	while($rowData = mysql_fetch_assoc($res)) {
		if($flSrMngr) $arrToEmail[] = $arrEmployees[$rowData['sr_manager']];
		if($flSalesPerson) $arrToEmail[] = $arrEmployees[$rowData['sales_person']];
		if($flInMngr) $arrToEmail[] = $arrEmployees[$rowData['india_manager']];
		if($flAdtMngr) $arrToEmail[] = $arrEmployees[$rowData['audit_manager']];
	}
	$arrToEmail = array_filter($arrToEmail);
	$strToEmail = implode(',',$arrToEmail);
	
	return $strToEmail;
}

// fetch sr manager, india manager, sales manager, team member for selected practice
function fetch_client_designation($jobId, $flTeamMmbr=false, $flSrAcComp=false, $flagSrAcAdt=false) {
	
	// fetch array of name of all employees
	$arrEmployees = fetchEmployees();

	$sql = "SELECT cl.team_member, cl.sr_accnt_comp, cl.sr_accnt_audit
			FROM client cl, job jb
			WHERE cl.client_id = jb.client_id
			AND jb.job_id=".$jobId;
			
	$res = mysql_query($sql) or die(mysql_error()); 
	while($rowData = mysql_fetch_assoc($res)) {
		if($flTeamMmbr) $arrCcEmail[] = $arrEmployees[$rowData['team_member']];
		if($flSrAcComp) $arrCcEmail[] = $arrEmployees[$rowData['sr_accnt_comp']];
		if($flagSrAcAdt) $arrCcEmail[] = $arrEmployees[$rowData['sr_accnt_audit']];
	}
	$arrCcEmail = array_filter($arrCcEmail);
	$strCcEmail = implode(',',$arrCcEmail);

	return $strCcEmail;
}

function fetchEmployees() {	

	$qrySel = "SELECT ss.stf_Code, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) staffName, cc.con_Email
				FROM stf_staff ss, con_contact cc
				WHERE ss.stf_CCode = cc.con_Code ";

	$fetchResult = mysql_query($qrySel);		
	while($rowData = mysql_fetch_assoc($fetchResult)) {
		$arrEmployees[$rowData['stf_Code']] = $rowData['con_Email'];
	}
	return $arrEmployees;	
} 

// this is used to replace the dynamic variables used in mail content
function replaceContent($content, $salesPersonId=NULL, $practiceId=NULL, $clientId=NULL, $jobId=NULL, $taskId=NULL) {
	
	// for sales person name
	if(!empty($salesPersonId)) {
		$staffName = fetchStaffInfo($salesPersonId, 'name');
		$content = str_replace('SALESPERSONNAME', $staffName, $content);
	}

	// for practice name
	if(!empty($practiceId)) {
		$prName = fetchEntityName($practiceId, 'P');
		$content = str_replace('PRACTICENAME', $prName, $content);
	}

	// for client name
	if(!empty($clientId)) {
		$clientName = fetchEntityName($clientId, 'C');
		$content = str_replace('CLIENTNAME', $clientName, $content);
	}

	// for job name
	if(!empty($jobId)) {
		$jobName = fetchEntityName($jobId, 'J');
		$arrJobParts = stringToArray('::',$jobName);
		
		$client_id = $arrJobParts[0];
		$sub_activity = $arrJobParts[2];
		
		
		$queryClient = "SELECT client_name
						FROM client
						WHERE client_id='$client_id'
						";
		$runClient = mysql_query($queryClient);
		$row_client = mysql_fetch_assoc($runClient);
		$client_name =  $row_client['client_name'];
		
		$queryActivity ="SELECT sub_Description
						FROM sub_subactivity
						WHERE sub_code='$sub_activity'
						";
						
		$runActivity = mysql_query($queryActivity);
		$row_subactivity = mysql_fetch_assoc($runActivity);
		$subactivity_name  = $row_subactivity['sub_Description'];
				
		$queryName = $client_name.'-'.$arrJobParts[1].'-'.$subactivity_name;
		
		$content = str_replace('JOBNAME', $queryName, $content);
	}

	// for task name
	if(!empty($taskId)) {
		$taskName = fetchEntityName($taskId, 'T');
		$content = str_replace('TASKNAME', $taskName, $content);
	}
	
	return $content;	
} 

function showArray($exp){

    echo '<pre>';
    print_r($exp);
    echo '</pre>';
}

function arrayToString($sep,$source){

    $cs_str = implode($sep, $source);
    return $cs_str;
}

function stringToArray($sep, $src){

    $cs_array = explode($sep, $src);
    return $cs_array;
}

function stringrtrim($source, $sep){

    $string = rtrim($source, $sep);
    return $string;
}

function replaceString($srch, $rep, $src)
{
    $cont = str_replace($srch, $rep, $src);
    return $cont;
}

// function to covert date into mysql format
function getDateFormat($dateformat)
{
	$date=explode("/",$dateformat);
	$year=$date[2];
	$month=$date[1];
	$day=$date[0];
	$mysql=$year."-".$month."-".$day;
	return $mysql;
}

// function to fetch states
function fetchStates() {
    $qryFetch = "SELECT cs.cst_Code state_id, cs.cst_Description state_name 
                            FROM cli_state cs";

    $fetchResult = mysql_query($qryFetch);

    while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrStates[$rowData['state_id']] = $rowData['state_name'];
    }
    return $arrStates;
}

function fetchStateName($id) 
{
    $qryFetch = "SELECT cs.cst_Code state_id, cs.cst_Description state_name FROM cli_state cs WHERE cs.cst_Code = ".$id;

    $fetchResult = mysql_query($qryFetch);
    $rowData = mysql_fetch_assoc($fetchResult);

    return $rowData['state_name'];
}

function fetchTrusteeName($id) 
{
    $qryFetch = "SELECT * FROM es_trustee_type  WHERE trustee_type_id = ".$id;

    $fetchResult = mysql_query($qryFetch);
    $rowData = mysql_fetch_assoc($fetchResult);

    return $rowData['trustee_type_name'];
}

// send mail for new job & new task
function new_job_task_mail() 
{
	/* send mail function starts here for ADD NEW JOB */
	$pageCode = "NEWJB";
	
	// check if event is active or inactive [This will return TRUE or FALSE as per result]
	$flagSet = getEventStatus($pageCode);
	
	// if event is active it go for mail function
	if($flagSet)
	{
		//It will Get All Details in array format for Send Email	
		$arrEmailInfo = get_email_info($pageCode);

		// fetch email id of sr manager
		$to = fetch_prac_designation($_SESSION['PRACTICEID'],true,true,true,true);
		$cc = fetch_client_designation($_SESSION['jobId'],true,true,true);
		if(!empty($arrEmailInfo['event_cc'])) $cc .= ','.$arrEmailInfo['event_cc'];
		$bcc = $arrEmailInfo['event_bcc'];
		$from = $arrEmailInfo['event_from'];
		$subject = $arrEmailInfo['event_subject'];
		$content = $arrEmailInfo['event_content'];
		$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_SESSION['jobId']);
		send_mail($from, $to, $cc, $bcc, $subject, $content);
	}
	/* send mail function ends here */	
		
	/* send mail function starts here for ADD NEW TASK */
	$pageCode = "NWTSK";
			
	// check if event is active or inactive [This will return TRUE or FALSE as per result]
	$flagSet = getEventStatus($pageCode);
	
	// if event is active it go for mail function
	if($flagSet)
	{
		//It will Get All Details in array format for Send Email	
		$arrEmailInfo = get_email_info($pageCode);

		// fetch email id of sr manager
		$to = fetch_prac_designation($_SESSION['PRACTICEID'],true,false,true,true);
		$cc = fetch_client_designation($_SESSION['jobId'],true,true,true);
		if(!empty($arrEmailInfo['event_cc'])) $cc .= ','.$arrEmailInfo['event_cc'];
		$bcc = $arrEmailInfo['event_bcc'];
		$from = $arrEmailInfo['event_from'];
		$subject = $arrEmailInfo['event_subject'];
		$content = $arrEmailInfo['event_content'];
		$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_SESSION['jobId']);
		send_mail($from, $to, $cc, $bcc, $subject, $content);
	}
	/* send mail function ends here */	
}

function createPDF($html,$filename,$title1,$title2)
{
    include(PDF);
    
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Super Records');
    $pdf->SetTitle('SuperRecords Setup Report');
    $pdf->SetSubject('SuperRecords Setup Report');
    $pdf->SetKeywords('SuperRecords Setup Report');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, 70, $title1.' ',$title2,array(7,65,101));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 12));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // set font
    $pdf->SetFont('helvetica', '', 10);

    // add a page
    $pdf->AddPage();

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //$pdf->Output($filename, 'I');
    $pdf->Output(UPLOADSETUP.$filename,"F");
}

function showPDFViewer($file,$filename)
{
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);
}

function generateClientCode($clientId,$cliName)
{
    
    // fetch practice code for respective client
    $qrySel = "SELECT pr_code FROM pr_practice WHERE id = '" . $_SESSION['PRACTICEID'] . "'";
    $resultObj = mysql_query($qrySel);
    $arrInfo = mysql_fetch_assoc($resultObj);
    $pracCode = $arrInfo['pr_code'];

    // build client code
    $clientName = preg_replace('/[^a-zA-Z0-9]/', '_', $cliName);
    $arrCliName = explode("_", $clientName);

    $cntNameWords = count($arrCliName);
    $intCounter = 0;
    $cliCode = "";

    While ($intCounter < $cntNameWords) 
    {

        $wordLgth=0;
        $word = $arrCliName[$intCounter];
        $wordLgth = strlen($arrCliName[$intCounter]);

        if($cntNameWords == 1)
        {
            
            if(strlen($cliCode) < 5)
            {
                if($wordLgth >= 5) 
                {
                    $cliCode .= substr($word, 0, 5);
                } 
                else 
                {
                    $cliCode .= substr($word, 0, $wordLgth);
                }
            }    

        }
        else
        {

            if(strlen($cliCode) < 5 && ($word != ''))
            {
                if ($wordLgth >= 3) 
                {
                    if(strlen($cliCode) == 0)
                    {
                        $cliCode .= substr($word, 0, 3);
                    }
                    else
                    {
                        $len = 5 - strlen($cliCode);
                        $cliCode .= substr($word, 0, $len);
                    }
                }
                else 
                {
                    $cliCode .= substr($word, 0, $wordLgth);
                }

            }
            else{

            }
        }

        $intCounter++;
        if($intCounter == $cntNameWords)
        {
            if(strlen($cliCode) < 5)
                $cliCode = str_pad($cliCode, 5, "0",STR_PAD_LEFT);
        }

        // check if client code is unique or not 
        if (strlen($cliCode) == 5) 
        {
            $flagCodeExists = checkClientCodeUnique($pracCode.$cliCode);

            if(!$flagCodeExists)
            {
                break;
            }
            else
            {
                $strName = str_replace(' ', '', $cliName);
                $seed = str_split($strName);
                shuffle($seed);
                $cliCode = '';
                foreach (array_rand($seed, 5) as $k) $cliCode .= $seed[$k];
                break;
            }
        }
        else
        {
            $word = "";
            $wordLgth = 0;
        }

    }
    
    if($pracCode != '' && $cliCode != '')
    {
        $qryUpd = "UPDATE client SET client_code = '" . strtoupper($pracCode.$cliCode) . "' WHERE client_id ='" . $clientId . "'";
        mysql_query($qryUpd);
    }
    return $clientId;
}

// check if client code is unique or not
function checkClientCodeUnique($code,$clientId = '') {

    if(!empty($clientId))
        $strAppend = "AND client_id <> ".$clientId;
    else
        $strAppend = "" ;

    $qrySel = "SELECT client_id FROM client WHERE client_code = '" . $code . "' {$strAppend}";
    $resultObj = mysql_query($qrySel);
    $flagCodeExists = mysql_fetch_assoc($resultObj);

    return $flagCodeExists;
}

//It will Check Given Event is Active or Not it will Return Status Event according Event Id is Givent as Argument to Function
function returnFileIcon($fileName) 
{   
	 $path_parts = pathinfo($fileName);
         $ext = $path_parts['extension'];
         $ext = strtolower($ext);
       
         switch ($ext) {
            case 'txt':
                $icon = ICOTXT;
                break;
            case 'doc':
            case 'docx':
                $icon = ICODOC;
                break;
            case 'ppt':
            case 'pptx':
                $icon = ICOPPT;
                 break;
            case 'pdf':
                $icon = ICOPDF;
                break;
            case 'xls':
            case 'xlsx':
                $icon = ICOXLS;
                break;
            case 'zip':
            case 'rar':
                $icon = ICOZIP;
                break;
            case 'png':
            case 'jpg':
            case 'jpeg':
                $icon = ICOIMG;
                break;
            case 'msg':
                $icon = ICOMSG;
                break;
         }
		
	//Return the Status of Given Event Id
    return $icon;
}

// function to fetch countries
function fetchCountries() 
{
        $qryFetch = "SELECT * FROM es_country";	
        $fetchResult = mysql_query($qryFetch);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
                $arrStates[$rowData['country_id']] = $rowData['country_name'];
        }
        return $arrStates;
}

function fetchSubForm()
{
    $qry =  "SELECT * FROM setup_subforms";
    $data = mysql_query($qry);
    
    while($rows = mysql_fetch_assoc($data))
    {
        $arrSubfrms[$rows['subform_id']] = $rows;
    }
    
    return $arrSubfrms;
}

// Client list in json form
function search_clients() {		

        $qrySel = "SELECT t1.client_id, t1.client_name
                    FROM client t1
                    WHERE id = '{$_SESSION['PRACTICEID']}'
                    AND t1.client_name LIKE '%".$_REQUEST['name']."%'
                    ORDER BY t1.client_name";

        $fetchResult = mysql_query($qrySel);		
        while($rowData = mysql_fetch_assoc($fetchResult)) {
                $arrClients[$rowData['client_id']] = $rowData['client_name'];
        }

        $result = array();
        foreach ($arrClients as $key=>$value)
        array_push($result, array("id"=>$key, "value" =>$value));

        $clientsJSON = json_encode($result);

        if(empty($clientsJSON))
            $clientsJSON = '';


        return $clientsJSON;	
}

// fetch al clients specific to practice
function getclientlist() {
        $qrySel = "SELECT t1.client_id, t1.client_name
                    FROM client t1
                    WHERE t1.id = '{$_SESSION['PRACTICEID']}'
                    ORDER BY t1.client_name";

        $fetchResult = mysql_query($qrySel);		
        while($rowData = mysql_fetch_assoc($fetchResult)) {
                $arrClients[$rowData['client_id']] = $rowData['client_name'];
        }
        return $arrClients;	
}
?>