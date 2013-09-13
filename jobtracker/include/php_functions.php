<?php
//It will Check Given Event is Active or Not it will Return Status Event according Event Id is Givent as Argument to Function
function getEventStatus($pageUrl) 
{
	//It will Generate Query to Fetch Event Record based on Event ID Given	
	$query = "SELECT event_status 
			  FROM email_events 
			  WHERE event_url LIKE '%{$pageUrl}%'";
		  
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
function get_email_info($pageUrl)
{
	//It will Generate Query and will get Require Details From Database
	$myQuery = "SELECT event_name,event_subject,event_content, event_cc
				FROM email_events 
				WHERE event_url LIKE '%{$pageUrl}%'";
	
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
function sql_select_panel($practiceId) {
	$sql = "SELECT sr_manager, india_manager, sales_person
			FROM pr_practice
			WHERE id=".$practiceId;
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	if(!empty($count))
	{
		// fetch array of name of all employees
		$arrEmployees = fetchEmployees();

		$rowData = mysql_fetch_assoc($res);
		$srManager = $arrEmployees[$rowData['sr_manager']];
		$salesPrson = $arrEmployees[$rowData['sales_person']];
		$inManager = $arrEmployees[$rowData['india_manager']];

		// set string of srManager, salesPrson, inManager, teamMember
		$strReturn = $srManager .'~'. $salesPrson .'~'. $inManager;
	}
	return $strReturn;
}

// fetch sr manager, india manager, sales manager, team member for selected practice
function fetch_team_member($clientId) {
	$sql = "SELECT team_member
			FROM client
			WHERE client_id=".$clientId;
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	if(!empty($count))
	{
		// fetch array of name of all employees
		$arrEmployees = fetchEmployees();

		$rowData = mysql_fetch_assoc($res);
		$teamMember = $arrEmployees[$rowData['team_member']];
	}
	return $teamMember;
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
function replaceContent($content, $salesPersonId=NULL, $practiceId=NULL, $clientId=NULL, $jobId=NULL) {
	
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
		$arrJobParts = explode('::',$jobName);
		
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
    $qryFetch = "SELECT cs.cst_Code state_id, cs.cst_Description state_name 
                                FROM cli_state cs WHERE cs.cst_Code = ".$id;

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
	$pageUrl = "jobs.php?sql=insertJob";
	
	// check if event is active or inactive [This will return TRUE or FALSE as per result]
	$flagSet = getEventStatus($pageUrl);
	
	// if event is active it go for mail function
	if($flagSet)
	{
		//It will Get All Details in array format for Send Email	
		$arrEmailInfo = get_email_info($pageUrl);

		// fetch email id of sr manager
		$strPanelInfo = sql_select_panel($_SESSION['PRACTICEID']);
		$arrPanelInfo = explode('~', $strPanelInfo);
		$srManagerEmail = $arrPanelInfo[0];
		$inManagerEmail = $arrPanelInfo[2];

		$to = $srManagerEmail. ',' .$inManagerEmail;
		$cc = $arrEmailInfo['event_cc'];
		$subject = $arrEmailInfo['event_subject'];
		$content = $arrEmailInfo['event_content'];
		$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_SESSION['jobId']);

		include_once(MAIL);
		send_mail($to, $cc, $subject, $content);
	}
	/* send mail function ends here */	
		
	/* send mail function starts here for ADD NEW TASK */
	$pageUrl = "job.php?sql=addTask";
			
	// check if event is active or inactive [This will return TRUE or FALSE as per result]
	$flagSet = getEventStatus($pageUrl);
	
	// if event is active it go for mail function
	if($flagSet)
	{
		//It will Get All Details in array format for Send Email	
		$arrEmailInfo = get_email_info($pageUrl);

		// fetch email id of sr manager
		$strPanelInfo = sql_select_panel($_SESSION['PRACTICEID']);
		$arrPanelInfo = explode('~', $strPanelInfo);
		$inManagerEmail = $arrPanelInfo[2];

		$to = $inManagerEmail;
		$cc = $arrEmailInfo['event_cc'];
		$subject = $arrEmailInfo['event_subject'];
		$content = $arrEmailInfo['event_content'];
		$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_SESSION['jobId']);

		include_once(MAIL);
		send_mail($to, $cc, $subject, $content);
	}
	/* send mail function ends here */	
}

function createPDF($html,$filename)
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
    $pdf->SetHeaderData(PDF_HEADER_LOGO, 70, 'Super Records'.' ', 'Trustee Guide',array(7,65,101));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
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
    
    //$html = "";

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output($filename, 'I');
    //$pdf->Output(UPLOADSETUP.$filename,"F");
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
?>