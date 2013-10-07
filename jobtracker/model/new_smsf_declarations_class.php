<?
class DECLARATIONS
{ 	
	// class constructor
	public function __construct()
	{ 
	
	}
	
	// function to fetch states
	function fetchQuestions()
	{
            $qryFetch = "SELECT * FROM es_declarations";	

            $fetchResult = mysql_query($qryFetch);

            while($rowData = mysql_fetch_assoc($fetchResult))
            {
                    $arrQues[$rowData['question_id']] = $rowData;
            }

            return $arrQues;
	}

        function checkLegalRef()
        {
            $qryFetch = "SELECT * FROM es_member_details WHERE job_id = '" . $_SESSION['jobId'] . "' AND legal_references = 1";
            
            $fetchResult = mysql_query($qryFetch);
            $count = 1;

            $arrData = array();
            while($rowData = mysql_fetch_assoc($fetchResult)) {
                    $arrData[$count++] = $rowData['member_id'];
            }
            
            return $arrData;
        }
        
        function generatePDF()
        {
            // for adding task
            $stQry = "UPDATE job SET job_submitted = '".$_REQUEST['job_submitted']."', job_received = NOW() WHERE job_id = ".$_SESSION['jobId'];
            $flagReturn = mysql_query($stQry);

            // add new task
            include(MODEL."job_class.php");
            $objJob = new Job();
            $objJob->add_new_task($_SESSION['PRACTICEID'], $_SESSION['jobId']);
            // send mail for new task
            new_job_task_mail();
            
            include(MODEL . "setup_preview_class.php");
            $objStpPrvw = new SETUP_PREVIEW();
            
            $arrJob = $objStpPrvw->jobDetails();
            $arrClients = $objStpPrvw->clientDetails($arrJob[$_SESSION['jobId']]['client_id']);
            $arrPractice = $objStpPrvw->practiceDetails();
            $arrActivity = $objStpPrvw->jobActivityDetails($arrJob[$_SESSION['jobId']]['job_type_id']);
            
            // Insert into documents table
            $qrySel = "SELECT max(document_id) docId FROM documents";

            $objResult = mysql_query($qrySel);
            $arrInfo = mysql_fetch_assoc($objResult);
            $fileId = $arrInfo['docId'];	
            $fileId++;
            $currentTime = date('Y-m-d H:i:s');

            $filename = $fileId."~setup.pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,file_path) VALUES (".$_SESSION['jobId'].",'setup','".$currentTime."','".$filename."')";
            mysql_query($docQry);
            

            $html = $objStpPrvw->generatePreview();
            $title1 = $arrPractice['name'];
            $title2 = $arrClients['client_name'].' - '.$arrJob[$_SESSION['jobId']]['period'].' - '.$arrActivity['sub_Description'];

            // Create PDF
            createPDF($html,$filename,$title1,$title2);

        }
        
        function updateTerms($chk)
        {
            $chk = ($chk == 'on')?1:0;
            $qry = "UPDATE es_contact_details SET terms_n_conditn = ".$chk." WHERE job_id = ".$_SESSION['jobId'];
            mysql_query($qry);
        }
        
        function fetchTerms()
        {
            $qry = "SELECT terms_n_conditn FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
            $data = mysql_query($qry);
            $rec = mysql_fetch_assoc($data);
            $chk = ($rec['terms_n_conditn'] == '1')?"on":"off";
            
            return $chk;
        }
}
                    
?>